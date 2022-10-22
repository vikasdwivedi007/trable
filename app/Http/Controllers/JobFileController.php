<?php

namespace App\Http\Controllers;

use App\Helpers;
use App\Models\City;
use App\Models\Country;
use App\Models\Currency;
use App\Models\Department;
use App\Models\Employee;
use App\Models\Gift;
use App\Models\Guide;
use App\Models\Hotel;
use App\Models\JobFile;
use App\Models\JobFileReview;
use App\Models\Language;
use App\Models\Lift;
use App\Models\NileCruise;
use App\Models\Room;
use App\Models\Router;
use App\Models\Sightseeing;
use App\Models\SLShow;
use App\Models\TrainTicket;
use App\Models\TravelAgent;
use App\Models\TravelVisa;
use App\Models\VBNight;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class JobFileController extends Controller
{

    private $prefix = 'job-files.';
    private $middlewares = ['auth'];

    public function __construct()
    {
        $this->middleware($this->middlewares);
    }

    public function index()
    {
        $this->authorize('viewAny', JobFile::class);
        if (request()->ajax()) {
            $jobs = JobFile::jobsIndex();
            return $jobs;
        }
        return view($this->prefix . 'index');
    }

    public function create()
    {
        $this->authorize('create', JobFile::class);
        $travel_agents = TravelAgent::orderBy('name')->get();
        $cities = City::where('country_id', Country::EGYPT_ID)->get();
        $languages = Language::all();
        $countries = Country::all();
        $concierge_emps = Employee::whereHas('department', function ($inner) {
            $inner->where('name', 'like', '%' . 'Concierge' . '%');
        })->with('user')->get();
        $visas = TravelVisa::all()->map->addCurrencyToPrices();
        $gifts = Gift::all()->map->addCurrencyToPrices();
        return view($this->prefix . 'create', compact('travel_agents', 'cities', 'languages', 'countries', 'concierge_emps', 'visas', 'gifts'));
    }

    public function store(Request $request)
    {
        $this->authorize('create', JobFile::class);
        $data = $this->validateRequest();
        $data = JobFile::prepareData($data);
        $job_file = JobFile::create($data);
        $job_file->saveRelatedData($data);
        //send notification to users
        if (request()->ajax()) {
            session()->flash('success', __("main.job_file_added"));
            $url = route($this->prefix . 'index');
            if (request('save_then_draft')) {
                $url = route('draft-invoices.create') . '?job-file=' . $job_file->id;
            }
            return response()->json(['success' => true, 'message' => __("main.job_file_added"), 'redirect_to' => $url]);
        } else {
            return redirect(route($this->prefix . 'index'))->with('success', __("main.job_file_added"));
        }
    }

    public function show(JobFile $job_file)
    {
        $this->authorize('view', $job_file);
        $job_file->load(['airport_from', 'airport_to', 'job_visa', 'job_visa.visa', 'job_gifts', 'job_gifts.gift', 'job_router', 'job_router.router', 'accommodations', 'accommodations.hotel', 'train_tickets', 'train_tickets.train_ticket', "train_tickets.train_ticket.from_station", 'train_tickets.train_ticket.to_station', 'nile_cruises', 'nile_cruises.nile_cruise', 'nile_cruises.nile_cruise.from_city', 'nile_cruises.nile_cruise.to_city', 'nile_cruises.cabins', 'flights', 'flights.flight', 'flights.flight.airport_from', 'flights.flight.airport_to', 'guides', 'guides.guide', 'guides.sightseeing', 'programs', 'programs.items', 'programs.items.program_itemable', 'reviews', 'reviews.reviewed_by_emp', 'reviews.reviewed_by_emp.user',
            'programs' => function ($query) {
                $query->orderBy('day', 'asc');
            }
            , 'programs.city', 'concierge_emp', 'concierge_emp.user']);
        $job_file->guides->map(function ($guide) {
            $guide->guide->languagesToStr();
        });
        foreach ($job_file->programs as $program) {
            foreach ($program->items as $item) {
                switch ($item->program_itemable_type) {
                    case Sightseeing::class:
                        $name = $item->program_itemable->name;
                        if ($item->time_from && $item->time_to) {
                            $name .= ' ' . $item->time_from->format('H:i') . ' - ' . $item->time_to->format('H:i');
                        }
                        $item->name = $name;
                        break;
                    case VBNight::class:
                        $name = $item->program_itemable->name;
                        if ($item->time_from && $item->time_to) {
                            $name .= ' ' . $item->time_from->format('H:i') . ' - ' . $item->time_to->format('H:i');
                        }
                        $item->name = $name;
                        break;
                    case SLShow::class:
                        $name = "Sound & Light show - " . $item->program_itemable->place;
                        $name .= ' - ' . $item->program_itemable->time->format('H:i');
                        $item->name = $name;
                        break;
                    case Lift::class:
                        $name = "Transportation - " . $item->program_itemable->details;
                        $name .= ' - ' . $item->program_itemable->time->format('H:i');
                        $item->name = $name;
                        break;
                }
            }
        }
        $job_flights = ['domestic' => [], 'international' => []];
        $i = 0;
        foreach ($job_file->flights as $flight) {
            $formatted = $flight;
            $formatted->flight->airport_from_fromatted = $flight->flight->airport_from->format();
            $formatted->flight->airport_to_fromatted = $flight->flight->airport_to->format();
            $job_flights[$flight->type][$i] = $formatted;
            $i++;
        }
        return view($this->prefix . 'show', compact('job_file', 'job_flights'));
    }

    public function edit(JobFile $job_file)
    {
        $this->authorize('update', $job_file);
        $job_file->load(['airport_from', 'airport_to', 'job_visa', 'job_visa.visa', 'job_gifts', 'job_gifts.gift', 'job_router', 'job_router.router', 'accommodations', 'accommodations.hotel', 'train_tickets', 'train_tickets.train_ticket', "train_tickets.train_ticket.from_station", 'train_tickets.train_ticket.to_station', 'nile_cruises', 'nile_cruises.nile_cruise', 'nile_cruises.nile_cruise.from_city', 'nile_cruises.nile_cruise.to_city', 'nile_cruises.cabins', 'flights', 'flights.flight', 'flights.flight.airport_from', 'flights.flight.airport_to', 'guides', 'guides.guide', 'guides.sightseeing', 'programs', 'programs.items', 'programs.items.program_itemable'])->toArray();
        $concierge_emps = Employee::whereHas('department', function ($inner) {
            $inner->where('name', 'like', '%' . 'Concierge' . '%');
        })->with('user')->get();
        //
        $available_routers = Router::availableRouters($job_file->arrival_date, $job_file->departure_date, $job_file->id);
        $visas = TravelVisa::all()->map->addCurrencyToPrices();
        $gifts = Gift::all()->map->addCurrencyToPrices();

        $hotels_in_cities = [];
        $available_room_views = [];
        $available_room_categories = [];
        foreach ($job_file->accommodations as $acc) {
            $hotels_in_cities[$acc->hotel->city_id] = Hotel::where('city_id', $acc->hotel->city_id)->orderBy('name')->get();
            $rooms = Room::where('hotel_id', $acc->hotel_id)->get();
            foreach ($rooms as $room) {
                if (!isset($available_room_views[$acc->id])) {
                    $available_room_views[$acc->id] = [];
                }
                if (!isset($available_room_categories[$acc->id])) {
                    $available_room_categories[$acc->id] = [];
                }
                if (!in_array($room->view, $available_room_views[$acc->id])) {
                    $available_room_views[$acc->id][] = $room->view;
                }
                if (!in_array($room->name, $available_room_categories[$acc->id])) {
                    $available_room_categories[$acc->id][] = $room->name;
                }
            }
        }

        $job_file->train_tickets->map(function ($job_trains) {
            $job_trains->train_ticket->formatObject();
        });
        $job_file->nile_cruises->map(function ($job_cruise) {
//            $job_cruise->nile_cruise->currency_str = Currency::currencyName($job_cruise->nile_cruise->currency);
            $job_cruise->nile_cruise->sgl_sell_currency = Currency::currencyName($job_cruise->nile_cruise->{NileCruise::pricesFieldsWithCurrencies()['sgl_buy_price']});
            $job_cruise->nile_cruise->dbl_sell_currency = Currency::currencyName($job_cruise->nile_cruise->{NileCruise::pricesFieldsWithCurrencies()['dbl_sell_price']});
            $job_cruise->nile_cruise->trpl_sell_currency = Currency::currencyName($job_cruise->nile_cruise->{NileCruise::pricesFieldsWithCurrencies()['trpl_sell_price']});
            $job_cruise->nile_cruise->child_sell_currency = Currency::currencyName($job_cruise->nile_cruise->{NileCruise::pricesFieldsWithCurrencies()['child_sell_price']});
            $job_cruise->nile_cruise->private_guide_sell_currency = Currency::currencyName($job_cruise->nile_cruise->{NileCruise::pricesFieldsWithCurrencies()['private_guide_sell_price']});
            $job_cruise->nile_cruise->boat_guide_sell_currency = Currency::currencyName($job_cruise->nile_cruise->{NileCruise::pricesFieldsWithCurrencies()['boat_guide_sell_price']});
            $job_cruise->nile_cruise->dates = $job_cruise->nile_cruise->toArray()['date_from'] . ' - ' . $job_cruise->nile_cruise->toArray()['date_to'];
        });
        //
        //
        $job_flights = ['domestic' => [], 'international' => []];
        $i = 0;
        foreach ($job_file->flights as $flight) {
            $formatted = $flight;
            $formatted->flight->airport_from_fromatted = $flight->flight->airport_from->format();
            $formatted->flight->airport_to_fromatted = $flight->flight->airport_to->format();
            $job_flights[$flight->type][$i] = $formatted;
            $i++;
        }
        //
        //
        $job_file->guides->map(function ($guide) {
            $guide->guide->languagesToStr();
        });
        $tours = [];
        foreach ($job_file->guides as $tour) {
            $available_guides = Guide::availableGuides($tour->date, $job_file->id);
            $available_guides->map->languagesToStr();
            $tours[$tour->id]['guides'] = $available_guides;
            $tours[$tour->id]['sightseeings'] = Sightseeing::where('city_id', $tour->city_id)->orderBy('name')->get();
        }
        //
        //
        $programs = [];
        foreach ($job_file->programs as $prog) {
            $prog_arr = $prog->toArray();
            $program = [
                'id' => $prog->id,
                'day' => $prog_arr['day'],
                'city_id' => $prog->city_id,
                'items' => [
                    'sightseeings' => [],
                    'vbnights' => [],
                    'slshows' => [],
                    'lifts' => [],
                ]
            ];
            foreach ($prog->items as $item) {
                switch ($item->program_itemable_type) {
                    case Sightseeing::class:
                        $program['items']['sightseeings'][] = $item;
                        break;
                    case VBNight::class:
                        $program['items']['vbnights'][] = $item;
                        break;
                    case SLShow::class:
                        $program['items']['slshows'][] = $item;
                        break;
                    case Lift::class:
                        $program['items']['lifts'][] = $item;
                        break;
                }
            }
            $programs[$program['id']] = $program;
            $programs[$program['id']]['city_sightseeings'] = Sightseeing::where('city_id', $prog->city_id)->orderBy('name')->get();
            $programs[$program['id']]['city_vbnights'] = VBNight::where('city_id', $prog->city_id)->orderBy('name')->get();
            if ($program['items']['slshows']) {
                $programs[$program['id']]['available_slshows_langs'] = SLShow::getLangsByCityAndDate($prog->day, $program['items']['slshows'][0]->program_itemable->place)['langs'];
                $programs[$program['id']]['available_slshows'] = SLShow::where('date', $prog->day)->where('place', $program['items']['slshows'][0]->program_itemable->place)->where('language_id', $program['items']['slshows'][0]->program_itemable->language_id)->get()->toArray();
            }
        }
        //

        $travel_agents = TravelAgent::orderBy('name')->get();
        $cities = City::where('country_id', Country::EGYPT_ID)->get();
        $languages = Language::all();
        $countries = Country::all();
        return view($this->prefix . 'edit', compact('job_file', 'travel_agents', 'cities', 'languages', 'countries', 'available_routers', 'hotels_in_cities', 'job_flights', 'tours', 'programs', 'concierge_emps', 'visas', 'gifts', 'available_room_categories', 'available_room_views'));
    }

    public function update(Request $request, JobFile $job_file)
    {
        $this->authorize('update', $job_file);
        $data = $this->validateRequest();
        $job_file->update($data);
        $job_file->saveRelatedData($data);
        if (request()->ajax()) {
            session()->flash('success', __("main.job_file_updated"));
            $url = route($this->prefix . 'index');
            if (request('save_then_draft')) {
                $url = route('draft-invoices.create') . '?job-file=' . $job_file->id;
            }
            return response()->json(['success' => true, 'message' => __("main.job_file_updated"), 'redirect_to' => $url]);
        } else {
            return redirect(route($this->prefix . 'index'))->with('success', __("main.job_file_updated"));
        }
    }

    /*public function destroy(JobFile $job_file)
    {
        $this->authorize('delete', $job_file);
        return redirect(route($this->prefix.'index'))->with('success', "Job-File deleted successfully");
    }*/

    public function searchByFileNo()
    {
        $data = [];
        if (request('file_no')) {
            $job_file = JobFile::where('file_no', request('file_no'))->with(['travel_agent', 'country', 'airport_from', 'airport_to', 'language'])->first();
            if ($job_file) {
                $job_file->airport_from_formatted = $job_file->airport_from->format();
                $job_file->airport_to_formatted = $job_file->airport_to->format();
                $data['job_file'] = $job_file;
            }
        }
        return response()->json($data);
    }

    public function searchByFileNoAndDate()
    {
        $data = [];
        if (request('file_no') && request('date')) {
            $job_file = JobFile::where('file_no', request('file_no'))->with(['travel_agent', 'country', 'airport_from', 'airport_to', 'language'])->first();
            if ($job_file) {
                $job_file->airport_from_formatted = $job_file->airport_from->format();
                $job_file->airport_to_formatted = $job_file->airport_to->format();
                $date = Carbon::createFromFormat('l d F Y', request('date'));

                $start = clone $date;
                $end = clone $date;
                $start = $start->startOfDay();
                $end = $end->endOfDay();

                $job_file->load(
                    [
                        'guides' => function ($inner) use ($start, $end) {
                            $inner->where('date', '>=', $start)->where('date', '<=', $end);
                            if (request('city_id')) {
                                $inner->where('city_id', request('city_id'));
                            }
                        }, 'guides.guide', 'guides.city', 'guides.sightseeing',
                        'programs' => function ($inner) use ($start, $end) {
                            $inner->where('day', '>=', $start)->where('day', '<=', $end);
                            if (request('city_id')) {
                                $inner->where('city_id', request('city_id'));
                            }
                        }, 'programs.items', 'programs.items.program_itemable',
                        'job_router', 'job_router.router',
                        'accommodations', 'accommodations.hotel'
                    ]
                );
                $sightseeings = [];
                foreach ($job_file->guides as $tour) {
                    $sightseeings[] = $tour->sightseeing->name;
                }
                foreach ($job_file->programs as $program) {
                    foreach ($program->items as $item) {
                        if ($item->program_itemable_type == Sightseeing::class) {
                            $sightseeings[] = $item->program_itemable->name;
                        }
                    }
                }
                $job_file->itinerary = join(', ', $sightseeings);
                $data['job_file'] = $job_file;
                $last_sheet = $job_file->getLastDailySheet(request('date'));
                $data['daily_sheet'] = $last_sheet ? $last_sheet->load(['transportation', 'representative', 'representative.user']) : null;
            }
        }
        return response()->json($data);
    }

    public function review(JobFile $job_file, $status)
    {
        $this->authorize('update', $job_file);
        $this->authorize('create', JobFileReview::class);
        $job_file->performReview($status);
        return redirect(route($this->prefix . 'index'))->with('success', __("main.job_file_approved"));
    }

    public function delegatePage(JobFile $job_file)
    {
        $this->authorize('update', $job_file);
        if (auth()->user()->employee->id != $job_file->operator()->id) {
            return redirect(route($this->prefix . 'index'));
        }
        $employees = Employee::where('id', '!=', auth()->user()->employee->id)->whereHas('department', function ($inner) {
            $inner->where('name', Department::TOURISM_DEP);
        })->with('user')->get();
        return view($this->prefix . 'delegate', compact('employees', 'job_file'));
    }

    public function delegate(JobFile $job_file)
    {
        $this->authorize('update', $job_file);
        if (request('assigned_to')) {
            $job_file->delegatoTo(request('assigned_to'));
            return redirect(route($this->prefix . 'index'))->with('success', __("main.job_file_delegated"));
        } else {
            return redirect(route($this->prefix . 'index'));
        }
    }


    private function validateRequest()
    {
        logger(request()->all());
        $rules = [
            'command_no' => 'nullable',
            'travel_agent_id' => 'required|exists:travel_agents,id',
            'client_name' => 'required',
            'client_phone' => 'nullable',
            'country_id' => 'required|exists:countries,id',
            'adults_count' => 'required|numeric|min:0',
            'children_count' => 'required|numeric|min:0',
            'language_id' => 'required|exists:languages,id',
            'arrival_date' => 'required|date|date_format:l d F Y H:i',
            'departure_date' => 'required|date|date_format:l d F Y H:i',
            'arrival_flight' => 'nullable',
            'departure_flight' => 'nullable',
            'airport_from_id' => 'required|exists:airports,id',
            'airport_to_id' => 'required|exists:airports,id',
            'request_date' => 'required|date|date_format:l d F Y',

            'profiling' => 'nullable',
            'remarks' => 'nullable',

            'notify_police' => 'nullable|in:0,1',
            'proforma' => 'nullable|in:0,1',

            'router' => 'nullable|in:0,1',
            'router_id' => 'nullable|required_if:router,1|exists:routers,id',
            'days_count' => 'nullable|required_if:router,1|numeric|min:1',

            'service_conciergerie' => 'nullable|in:0,1',
            'concierge_emp_id' => 'nullable|required_if:service_conciergerie,1|exists:employees,id',

            'visa' => 'nullable|in:0,1',
            'visa_id' => 'nullable|required_if:visa,1|exists:travel_visas,id',
            'visas_count' => 'nullable|required_if:visa,1|numeric|min:1',

            'gifts' => 'nullable|in:0,1',//checkbox
            'gifts_data' => 'nullable|array',//data
            'gifts_data.*.gift_id' => 'nullable|exists:gifts,id',
            'gifts_data.*.gifts_count' => 'nullable|numeric|min:1',

            'accommodations' => 'nullable|array',
            'accommodations.*.hotel_id' => 'required|exists:hotels,id',
            'accommodations.*.room_id' => 'nullable|exists:rooms,id',
            'accommodations.*.room_type' => 'required|numeric',
            'accommodations.*.meal_plan' => 'required|numeric',
            'accommodations.*.view' => 'required',
            'accommodations.*.category' => 'required',
            'accommodations.*.check_in' => 'required|date|date_format:l d F Y',
            'accommodations.*.check_out' => 'required|date|date_format:l d F Y',
            'accommodations.*.situation' => 'required',
            'accommodations.*.payment_date' => 'nullable|date|date_format:l d F Y',
            'accommodations.*.voucher_date' => 'nullable|date|date_format:l d F Y',

            'train_tickets' => 'nullable|array',
            'train_tickets.*' => 'nullable|exists:train_tickets,id',

            'nile_cruises' => 'nullable|array',
            'nile_cruises.*.item_id' => 'nullable|exists:nile_cruises,id',
            'nile_cruises.*.room_type' => 'nullable|numeric',
            'nile_cruises.*.inc_private_guide' => 'nullable',
            'nile_cruises.*.inc_boat_guide' => 'nullable',
            'nile_cruises.*.cabins' => 'nullable|array',
            'nile_cruises.*.cabins.*.adults_count' => 'nullable|numeric',
            'nile_cruises.*.cabins.*.children_count' => 'nullable|numeric',

            'flights' => 'nullable|array',
            'flights.*.type' => 'nullable|in:domestic,international',
            'flights.*.flight_no' => 'nullable|exists:flights,number',//will validate in the model

            'guides' => 'nullable|array',
            'guides.*.city_id' => 'nullable|exists:cities,id',
            'guides.*.guide_id' => 'nullable|exists:guides,id',
            'guides.*.sightseeing_id' => 'nullable|exists:sightseeings,id',
            'guides.*.date' => 'nullable|date|date_format:l d F Y',

            'programs' => 'nullable|array',
            'programs.*.day' => 'nullable|required_with:programs.*.city_id|date|date_format:l d F Y',
            'programs.*.city_id' => 'nullable|required_with:programs.*.day|exists:cities,id',

            'programs.*.items' => 'nullable|array',
            'programs.*.items.*.item_type' => 'nullable|required_with:programs.*.items.*.item_id',
            'programs.*.items.*.item_id' => 'nullable|required_with:programs.*.items.*.item_type',
            'programs.*.items.*.time_from' => 'nullable',
            'programs.*.items.*.time_to' => 'nullable',
            'programs.*.items.*.details' => 'nullable',
            'programs.*.items.*.inc_sightseeing' => 'nullable',
            'programs.*.items.*.inc_private_guide' => 'nullable',
            'programs.*.items.*.inc_boat_guide' => 'nullable',
            'programs.*.items.*.cabins' => 'nullable|array',
            'programs.*.items.*.cabins.*.adults_count' => 'nullable|numeric',
            'programs.*.items.*.cabins.*.children_count' => 'nullable|numeric',
            'programs.*.items.*.cabins.*.cabin_type' => 'nullable|numeric',
        ];
        $fields = ['notify_police', 'service_conciergerie', 'router', 'proforma', 'visa', 'gifts'];
        foreach ($fields as $field) {
            if (request($field) && request($field) == 'on') {
                request()->request->set($field, 1);
            } elseif ($field == 'service_conciergerie') {
                //set it to null to fix edit case (if job created with emp then unchecked that box in edit)
                request()->request->set('concierge_emp_id', null);
                request()->request->set($field, 0);
            } else {
                request()->request->set($field, 0);
            }
        }
        request()->request->set('arrival_date', request('arrival_date') . ' ' . request('arrival_time'));
        request()->request->set('departure_date', request('departure_date') . ' ' . request('departure_time'));
        return request()->validate($rules);
    }
}
