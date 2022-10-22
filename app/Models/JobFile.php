<?php

namespace App\Models;

use App\Helpers;
use App\Notifications\GenericNotification;
use App\Traits\SerializeDate;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Pipeline\Pipeline;
use Illuminate\Support\Arr;
use Spatie\Activitylog\Traits\LogsActivity;

class JobFile extends Model
{
    use SoftDeletes, LogsActivity, SerializeDate;
    const PERMISSION_NAME = 'Job-File';
    protected $fillable = ['created_by', 'file_no', 'command_no', 'travel_agent_id', 'client_name', 'client_phone', 'country_id', 'adults_count', 'children_count', 'language_id', 'arrival_date', 'departure_date', 'airport_from_id', 'airport_to_id', 'request_date', 'arrival_flight', 'departure_flight', 'profiling', 'remarks', 'gifts', 'notify_police', 'service_conciergerie', 'router', 'proforma', 'concierge_emp_id'];
    protected static $logAttributes = ['*'];
    protected static $logAttributesToIgnore = ['created_at', 'updated_at'];
    protected static $logOnlyDirty = true;
    protected $dates = ['arrival_date', 'departure_date', 'request_date'];
    protected $casts = [
        'arrival_date' => 'datetime:l d F Y H:i',
        'departure_date' => 'datetime:l d F Y H:i',
        'request_date' => 'datetime:l d F Y',
        'created_at' => 'datetime:d/m/Y'
    ];
    public $can_search_by = ['travel_agent.name', 'client_name', 'client_phone', 'file_no', 'command_no'];

    public static function boot()
    {
        parent::boot();

        self::creating(function ($job_file) {
            $job_file->generateNumber();
        });

        self::created(function ($job_file) {
            $job_file->sendCreationNotification();
        });
    }

    public function travel_agent()
    {
        return $this->belongsTo(TravelAgent::class, 'travel_agent_id');
    }

    public function country()
    {
        return $this->belongsTo(Country::class, 'country_id');
    }

    public function airport_from()
    {
        return $this->belongsTo(Airport::class, 'airport_from_id');
    }

    public function airport_to()
    {
        return $this->belongsTo(Airport::class, 'airport_to_id');
    }

    public function job_router()
    {
        return $this->hasOne(JobRouter::class, 'job_id');
    }

    public function job_visa()
    {
        return $this->hasOne(JobVisa::class, 'job_id');
    }

    public function job_gifts()
    {
        return $this->hasMany(JobGift::class, 'job_id');
    }

    public function accommodations()
    {
        return $this->hasMany(JobAccommodation::class, 'job_id');
    }

    public function train_tickets()
    {
        return $this->hasMany(JobTrainTicket::class, 'job_id');
    }

    public function nile_cruises()
    {
        return $this->hasMany(JobCruise::class, 'job_id');
    }

    public function flights()
    {
        return $this->hasMany(JobFlight::class, 'job_id');
    }

    public function guides()
    {
        return $this->hasMany(JobGuide::class, 'job_id');
    }

    public function programs()
    {
        return $this->hasMany(Program::class, 'job_id');
    }

    public function draft_invoices()
    {
        return $this->hasMany(DraftInvoice::class, 'job_id');
    }

    public function created_by_emp()
    {
        return $this->belongsTo(Employee::class, 'created_by');
    }

    public function language()
    {
        return $this->belongsTo(Language::class, 'language_id');
    }

    public function concierge_emp()
    {
        return $this->belongsTo(Employee::class, 'concierge_emp_id');
    }

    public function reviews()
    {
        return $this->hasMany(JobFileReview::class, 'job_id');
    }

    public function delegation()
    {
        return $this->hasOne(JobFileDelegation::class, 'job_id');
    }

    public function daily_sheets()
    {
        return $this->hasMany(DailySheetFile::class, 'job_id');
    }

    //consider doing this in creating event
    public static function prepareData($data)
    {
        $data['created_by'] = auth()->user()->employee->id;
        return $data;
    }

    public static function jobsIndex()
    {
        $query = self::select([
            'job_files.*',
            'travel_agent.id as travel_agent.id',
            'travel_agent.name as travel_agent.name',
        ])
            ->join('travel_agents as travel_agent', 'job_files.travel_agent_id', '=', 'travel_agent.id');

        $jobs = app(Pipeline::class)->send($query)
            ->through([
                \App\QueryFilters\FilterBy::class,
                \App\QueryFilters\Order::class,
            ])
            ->thenReturn();
        $count = $jobs->count();
        $jobs = app(Pipeline::class)->send($jobs)
            ->through([
                \App\QueryFilters\Paginate::class,//always last
            ])
            ->thenReturn();
        $jobs = $jobs->with(['travel_agent', 'reviews', 'reviews.reviewed_by_emp', 'reviews.reviewed_by_emp.user'])->get();
        $jobs->map->formatObject();
        return Helpers::FormatForDatatable($jobs, $count);
    }

    public function createOrUpdateRouter($data)
    {
        $existing_data = $this->job_router()->get()->map(function ($inner) {
            return join('|', Arr::except($inner->toArray(), ['id', 'updated_at', 'created_at']));
        })->toArray();
        if (isset($data['router']) && $data['router'] && isset($data['router_id']) && isset($data['days_count'])) {
            $this->job_router()->updateOrCreate([], $data);
        } else {
            $this->job_router()->delete();
        }
        $new_data = $this->job_router()->get()->map(function ($inner) {
            return join('|', Arr::except($inner->toArray(), ['id', 'updated_at', 'created_at']));
        })->toArray();
        if (
            count($new_data) != count($existing_data)
            ||
            count($existing_data) != count(array_intersect($existing_data, $new_data))
        ) {
            //log change
            ActivityLog::logToDB($this, 'Updated router data');
        }
    }

    public function createOrUpdateVisa($data)
    {
        $existing_data = $this->job_visa()->get()->map(function ($inner) {
            return join('|', Arr::except($inner->toArray(), ['id', 'updated_at', 'created_at']));
        })->toArray();
        if (isset($data['visa']) && $data['visa'] && isset($data['visa_id']) && isset($data['visas_count'])) {
            $this->job_visa()->updateOrCreate([], $data);
        } else {
            $this->job_visa()->delete();
        }
        $new_data = $this->job_visa()->get()->map(function ($inner) {
            return join('|', Arr::except($inner->toArray(), ['id', 'updated_at', 'created_at']));
        })->toArray();
        if (
            count($new_data) != count($existing_data)
            ||
            count($existing_data) != count(array_intersect($existing_data, $new_data))
        ) {
            //log change
            ActivityLog::logToDB($this, 'Updated visa data');
        }
    }

    public function createOrUpdateGifts($data)
    {
        $existing_data = $this->job_gifts()->get()->map(function ($inner) {
            return join('|', Arr::except($inner->toArray(), ['id', 'updated_at', 'created_at']));
        })->toArray();
        $this->job_gifts()->delete();
        if (isset($data['gifts']) && $data['gifts'] && isset($data['gifts_data']) && is_array($data['gifts_data']) && $data['gifts_data']) {
            $new_data = [];
            foreach ($data['gifts_data'] as $item) {
                if (isset($item['gift_id']) && isset($item['gifts_count'])) {
                    $new_data[] = ['gift_id' => $item['gift_id'], 'gifts_count' => $item['gifts_count']];
                }
            }
            $this->job_gifts()->createMany($new_data);
        }
        $new_data = $this->job_gifts()->get()->map(function ($inner) {
            return join('|', Arr::except($inner->toArray(), ['id', 'updated_at', 'created_at']));
        })->toArray();
        if (
            count($new_data) != count($existing_data)
            ||
            count($existing_data) != count(array_intersect($existing_data, $new_data))
        ) {
            //log change
            ActivityLog::logToDB($this, 'Updated gifts data');
        }
    }

    public function accommodationReminders()
    {
        return Reminder::where('desc', 'Accommodation reminder for Job File ' . $this->file_no)->get();
    }

    public function createOrUpdateAccommodations($data)
    {
        $existing_data = $this->accommodations()->get()->map(function ($inner) {
            return join('|', Arr::except($inner->toArray(), ['id', 'updated_at', 'created_at']));
        })->toArray();
        $this->accommodations()->delete();
        foreach ($this->accommodationReminders() as $reminder) {
            $reminder->delete();
        }
        if (isset($data['accommodations'])) {
            $accommodations = $data['accommodations'];
            if ($accommodations) {
                foreach ($accommodations as $accommodation) {
                    $this->accommodations()->create($accommodation);
                }
            }
        }
        $top_management_emps = Employee::getTopManagementEmployees();
        $data = [
            'title' => 'Accommodation Reminder',
            'desc' => 'Accommodation reminder for Job File ' . $this->file_no,
            'status' => 0,
            'send_by' => ['db', 'mail']
        ];
        foreach ($this->accommodations()->get() as $acc) {
            if ($acc->payment_date || $acc->voucher_date) {
                foreach ($top_management_emps as $emp) {
                    $data['assigned_by_id'] = $emp->id;
                    $data['assigned_to_id'] = $emp->id;
                    if ($acc->payment_date) {
                        $data['send_at'] = Carbon::createFromTimestamp($acc->payment_date->format('U'))->subDays(2)->format('l d F Y H:i');
                        $reminder = Reminder::create($data);
                        $reminder->setJob();
                    }
                    if ($acc->voucher_date) {
                        $data['send_at'] = Carbon::createFromTimestamp($acc->voucher_date->format('U'))->subDays(2)->format('l d F Y H:i');
                        $reminder = Reminder::create($data);
                        $reminder->setJob();
                    }
                }
            }
        }
        $new_data = $this->accommodations()->get()->map(function ($inner) {
            return join('|', Arr::except($inner->toArray(), ['id', 'updated_at', 'created_at']));
        })->toArray();
        if (
            count($new_data) != count($existing_data)
            ||
            count($existing_data) != count(array_intersect($existing_data, $new_data))
        ) {
            //log change
            ActivityLog::logToDB($this, 'Updated accommodations-room data');
        }
    }

    public function createOrUpdateTrains($data)
    {
        $existing_data = $this->train_tickets()->get()->map(function ($inner) {
            return join('|', Arr::except($inner->toArray(), ['id', 'updated_at', 'created_at']));
        })->toArray();
        $this->train_tickets()->delete();
        if (isset($data['train_tickets']) && is_array($data['train_tickets'])) {
            $tickets = $data['train_tickets'];
            if ($tickets) {
                $data = [];
                foreach ($tickets as $ticket_id) {
                    if ($ticket_id) {
                        $data[] = ['train_ticket_id' => $ticket_id];
                    }
                }
                if ($data) {
                    $this->train_tickets()->createMany($data);
                }
            }
        }
        $new_data = $this->train_tickets()->get()->map(function ($inner) {
            return join('|', Arr::except($inner->toArray(), ['id', 'updated_at', 'created_at']));
        })->toArray();
        if (
            count($new_data) != count($existing_data)
            ||
            count($existing_data) != count(array_intersect($existing_data, $new_data))
        ) {
            //log change
            ActivityLog::logToDB($this, 'Updated accommodations-train data');
        }
    }

    public function createOrUpdateCruises($data)
    {
        $existing_data = $this->nile_cruises()->get()->map(function ($inner) {
            $items = $inner->cabins()->get()->map(function ($inner2) {
                return join('|', Arr::except($inner2->toArray(), ['id', 'updated_at', 'created_at', 'item_id']));
            })->toArray();
            return join('|', Arr::except($inner->toArray(), ['id', 'updated_at', 'created_at'])) . '|' . join('|', $items);
        })->toArray();
        $this->nile_cruises->map(function ($job_cruise) {
            $job_cruise->delete();
        });
        if (isset($data['nile_cruises']) && is_array($data['nile_cruises'])) {
            $cruises = $data['nile_cruises'];
            if ($cruises) {
                foreach ($cruises as $cruise) {
                    if ($cruise['item_id']) {
                        $item = [];
                        $item['cruise_id'] = $cruise['item_id'];
                        $item['room_type'] = $cruise['room_type'];
                        $item['inc_private_guide'] = $cruise['inc_private_guide'];
                        $item['inc_boat_guide'] = $cruise['inc_boat_guide'];
                        $item['cabins'] = [];
                        foreach ($cruise['cabins'] as $cabin) {
                            $item['cabins'][] = [
                                'adults_count' => $cabin['adults_count'],
                                'children_count' => $cabin['children_count'],
                            ];
                        }
                        if ($item['cabins']) {
                            $created = $this->nile_cruises()->create($item);
                            $created->cabins()->createMany($item['cabins']);
                        }
                    }
                }
            }
        }
        $new_data = $this->nile_cruises()->get()->map(function ($inner) {
            $items = $inner->cabins()->get()->map(function ($inner2) {
                return join('|', Arr::except($inner2->toArray(), ['id', 'updated_at', 'created_at', 'item_id']));
            })->toArray();
            return join('|', Arr::except($inner->toArray(), ['id', 'updated_at', 'created_at'])) . '|' . join('|', $items);
        })->toArray();
        if (
            count($new_data) != count($existing_data)
            ||
            count($existing_data) != count(array_intersect($existing_data, $new_data))
        ) {
            //log change
            ActivityLog::logToDB($this, 'Updated accommodations-cruise data');
        }
    }

    public function createOrUpdateFlights($flights)
    {
        $existing_data = $this->flights()->get()->map(function ($inner) {
            return join('|', Arr::except($inner->toArray(), ['id', 'updated_at', 'created_at']));
        })->toArray();
        $this->flights()->delete();
        if ($flights) {
            foreach ($flights as $flight) {
                if (isset($flight['flight_no']) && Flight::where('number', $flight['flight_no'])->count()) {
                    $flight['flight_id'] = Flight::where('number', $flight['flight_no'])->first()->id;
                    $this->flights()->create($flight);
                }
            }
        }
        $new_data = $this->flights()->get()->map(function ($inner) {
            return join('|', Arr::except($inner->toArray(), ['id', 'updated_at', 'created_at']));
        })->toArray();
        if (
            count($new_data) != count($existing_data)
            ||
            count($existing_data) != count(array_intersect($existing_data, $new_data))
        ) {
            //log change
            ActivityLog::logToDB($this, 'Updated flights data');
        }
    }

    public function createOrUpdateGuides($guides)
    {
        $existing_data = $this->guides()->get()->map(function ($inner) {
            return join('|', Arr::except($inner->toArray(), ['id', 'updated_at', 'created_at']));
        })->toArray();
        $this->guides()->delete();
        if ($guides) {
            foreach ($guides as $key => $guide) {
                if (isset($guide['date']) && isset($guide['city_id']) && isset($guide['sightseeing_id']) && isset($guide['guide_id'])) {
                    $this->guides()->create($guide);
                }
            }
        }
        $new_data = $this->guides()->get()->map(function ($inner) {
            return join('|', Arr::except($inner->toArray(), ['id', 'updated_at', 'created_at']));
        })->toArray();
        if (
            count($new_data) != count($existing_data)
            ||
            count($existing_data) != count(array_intersect($existing_data, $new_data))
        ) {
            //log change
            ActivityLog::logToDB($this, 'Updated guides data');
        }
    }

    public function createOrUpdatePrograms($data)
    {
        $existing_data = $this->programs()->get()->map(function ($inner) {
            $items = $inner->items()->get()->map(function ($inner2) {
                return join('|', Arr::except($inner2->toArray(), ['id', 'updated_at', 'created_at', 'program_id']));
            })->toArray();
            return join('|', Arr::except($inner->toArray(), ['id', 'updated_at', 'created_at'])) . '|' . join('|', $items);
        })->toArray();
        foreach ($this->programs as $to_del) {
            foreach ($to_del->items as $to_del_item) {
                $to_del_item->delete();
            }
            $to_del->delete();
        }
        if (isset($data['programs'])) {
            $programs = $data['programs'];
            if ($programs) {
                foreach ($programs as $program) {
                    if (isset($program['items']) && $program['items']) {
                        if (isset($program['id']) && $program['id']) {
                            $created = $this->programs()->updateOrCreate(['id' => $program['id']], $program);
                        } else {
                            $created = $this->programs()->create($program);
                        }
                        // create/update program-items
                        foreach ($program['items'] as $item) {
                            $item['program_itemable_id'] = $item['item_id'];
                            if (isset($item['time_from'])) {
                                $item['time_from'] = Carbon::createFromFormat('l d F Y H:i', $program['day'] . ' ' . $item['time_from']);
                            }
                            if (isset($item['time_to'])) {
                                $item['time_to'] = Carbon::createFromFormat('l d F Y H:i', $program['day'] . ' ' . $item['time_to']);
                            }
                            switch ($item['item_type']) {
                                case 'sightseeing':
                                    $item['program_itemable_type'] = Sightseeing::class;
                                    break;
                                case 'vbnight':
                                    $item['program_itemable_type'] = VBNight::class;
                                    break;
                                case 'slshow':
                                    $item['program_itemable_type'] = SLShow::class;
                                    break;
                                case 'lift':
                                    $item['program_itemable_type'] = Lift::class;
                                    $item['time'] = $item['time_from'];
                                    $lift = Lift::create($item);
                                    $item['program_itemable_id'] = $lift->id;
                                    break;
                                default:
                                    $item['program_itemable_type'] = 'not_found_model_type';
                            }

                            $item_created = $created->items()->create($item);
                            if (isset($item['cabins']) && $item['cabins']) {
                                foreach ($item['cabins'] as $cabin) {
                                    $item_created->cabins()->create($cabin);
                                }
                            }
                        }
                    }
                }
            }
        }
        $new_data = $this->programs()->get()->map(function ($inner) {
            $items = $inner->items()->get()->map(function ($inner2) {
                return join('|', Arr::except($inner2->toArray(), ['id', 'updated_at', 'created_at', 'program_id']));
            })->toArray();
            return join('|', Arr::except($inner->toArray(), ['id', 'updated_at', 'created_at'])) . '|' . join('|', $items);
        })->toArray();
        if (
            count($new_data) != count($existing_data)
            ||
            count($existing_data) != count(array_intersect($existing_data, $new_data))
        ) {
            //log change
            ActivityLog::logToDB($this, 'Updated program data');
        }
    }

    public function generateNumber()
    {
        $month_start = Carbon::createFromFormat("d-m-Y", $this->arrival_date->format('d-m-Y'))->startOfMonth();
        $month_end = Carbon::createFromFormat("d-m-Y", $this->arrival_date->format('d-m-Y'))->endOfMonth();
        $count = self::where('arrival_date', '>=', $month_start)->where('arrival_date', '<=', $month_end)->count();
        $file_no = ($count + 1) . '/' . $this->arrival_date->format('my');
        $this->file_no = $file_no;
    }

    public function formatObject()
    {
        $last_invoice = Invoice::whereHas('draft_invoice', function ($inner) {
            $inner->whereHas('job_file', function ($inner2) {
                $inner2->where('job_id', $this->id);
            });
        })->orderBy('created_at', 'DESC')->first();
        $this->invoice_no = $last_invoice ? $last_invoice->number : '';
        $this->reviewer_name = '';
        $current_operator = $this->operator();
        $this->operator_name = $current_operator->user->name;
        $this->status = $this->status();
        $this->can_delegate = false;
        if ($current_operator->id == auth()->user()->employee->id) {
            $this->can_delegate = true;
        }
        $this->can_edit = false;
        if (auth()->user()->can('update', $this)) {
            $this->can_edit = true;
        }
    }

    public function saveRelatedData($data)
    {
        $this->createOrUpdateRouter($data);
        $this->createOrUpdateVisa($data);
        $this->createOrUpdateGifts($data);
        $this->createOrUpdateAccommodations($data);
        $this->createOrUpdateTrains($data);
        $this->createOrUpdateCruises($data);
        $this->createOrUpdateFlights(isset($data['flights']) ? $data['flights'] : []);
        $this->createOrUpdateGuides(isset($data['guides']) ? $data['guides'] : []);
        $this->createOrUpdatePrograms($data);
    }

    public function sendCreationNotification()
    {
        $title = 'New Job File';
        $desc = 'New Job File number ' . $this->file_no . ' has been created. Check Job-Files section to review it.';

        $to = Employee::where(function ($query) {
            //modeer el sya7a
            $query->whereHas('department', function ($inner) {
                $inner->where('name', Department::TOURISM_DEP);
            })->whereHas('job', function ($inner) {
                $inner->where('title', JobTitle::MANAGER_TITLE);
            });
        })
            //also send to general and vice manager
            ->orWhere(function ($query) {
                $query->whereHas('job', function ($inner) {
                    $inner->where('title', JobTitle::GENERAL_MANAGER_TITLE)->orWhere('title', JobTitle::VICE_GENERAL_MANAGER_TITLE);
                });
            })
            ->with('user')->get();

        foreach ($to as $emp) {
            //to all except the one who created the file
            if ($emp->user_id != auth()->user()->id) {
                $emp->user->notify(new GenericNotification($title, $desc));
            }
        }
    }

    public function performReview($status)
    {
        if (in_array($status, JobFileReview::available_status())) {
            $review = $this->reviews()->where('reviewed_by', auth()->user()->employee->id)->first();
            if (!$review) {
                $review = new JobFileReview();
                $review->job_id = $this->id;
                $review->reviewed_by = auth()->user()->employee->id;
            }
            $review->status = $status;
            $review->save();
        }
    }

    public function status()
    {
        $review = $this->reviews()->first();
        if (!$review) {
            $this->reviewer_name = '';
            $this->status = 'Not reviewed';
            $this->status_num = JobFileReview::STATUS_NOT_YET;
            return $this->status;
        }
        switch ($review->status) {
            case JobFileReview::STATUS_NOT_YET:
                $this->status = 'Not reviewed';
                $this->reviewer_name = '';
                break;
            case JobFileReview::STATUS_APPROVED:
                $this->status = 'Approved';
                $this->reviewer_name = $review->reviewed_by_emp->user->name;
                break;
            case JobFileReview::STATUS_DECLINED:
                $this->status = 'Declined';
                $this->reviewer_name = $review->reviewed_by_emp->user->name;
                break;
        }
        $this->status_num = $review->status;
        return $this->status;
    }

    public function operator()
    {
        if (!$this->delegation) {
            return $this->created_by_emp;
        }
        return $this->delegation->assigned_to_emp;
    }

    public function delegatoTo($assigned_to_emp_id)
    {
        $current_operator = $this->operator();//Employee object
        $assigned_to_emp = Employee::where('id', $assigned_to_emp_id)->whereHas('department', function ($inner) {
            $inner->where('name', Department::TOURISM_DEP);
        })->with('user')->first();
        if (!$assigned_to_emp) {
            return false;
        }
        if ($assigned_to_emp_id != $current_operator->id && auth()->user()->employee->id == $current_operator->id) {
            $this->delegation()->delete();
            $this->delegation()->create(
                [
                    'job_id' => $this->id,
                    'assigned_by' => $current_operator->id,
                    'assigned_to' => $assigned_to_emp_id
                ]
            );
        }
    }

    public function getLastDailySheet($date_str = '')
    {
        if ($date_str) {
            $date = Carbon::createFromFormat('l d F Y', $date_str);
            $start = clone $date;
            $end = clone $date;
            $start = $start->startOfDay();
            $end = $end->endOfDay();
            return $this->daily_sheets()->whereHas('daily_sheet', function ($inner) use ($start, $end) {
                $inner->where('date', '>=', $start)->where('date', '<=', $end);
            })->orderBy('created_at', 'DESC')->first();
        } else {
            return $this->daily_sheets()->orderBy('created_at', 'DESC')->first();
        }
    }
}
