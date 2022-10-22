<?php

namespace App\Models;

use App\Helpers;
use App\Traits\AddCurrenciesToPrices;
use App\Traits\SaveInitialPrices;
use App\Traits\SerializeDate;
use App\Traits\ServiceCanBeDeleted;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Pipeline\Pipeline;
use Illuminate\Support\Str;
use Spatie\Activitylog\Traits\LogsActivity;

class Guide extends Model
{
    use SoftDeletes, LogsActivity, ServiceCanBeDeleted, SerializeDate, SaveInitialPrices, AddCurrenciesToPrices;

    const PERMISSION_NAME = 'Guide';

    protected $fillable = ['employee_id', 'name', 'name_ar', 'phone', 'city_id', 'daily_fee', 'license_no', 'currency'];

    protected static $logAttributes = ['*'];
    protected static $logAttributesToIgnore = ['created_at', 'updated_at'];
    protected static $logOnlyDirty = true;

    public $can_search_by = ['city.name', 'guides.name', 'phone', 'license_no'];

    public static function boot()
    {
        parent::boot();
        self::created(function ($guide) {
            $guide->createUserAndEmp();
        });

        self::updated(function ($guide) {
            $guide->updateUser();
        });

        self::deleting(function ($guide) {
            $guide->employee->user->delete();
            $guide->employee->delete();
        });
    }

    public static function guidesIndex()
    {
        $query = self::select([
            'guides.*',
            'guides.name as guides.name',
            'city.name as city.name',
        ])->leftJoin('cities as city', 'guides.city_id', '=', 'city.id');

        $guides = app(Pipeline::class)->send($query)
            ->through([
                \App\QueryFilters\FilterBy::class,
                \App\QueryFilters\FilterByRelationship::class,
                \App\QueryFilters\Order::class,
            ])
            ->thenReturn();

        $count = $guides->count();
        $guides = app(Pipeline::class)->send($guides)
            ->through([
                \App\QueryFilters\Paginate::class
            ])
            ->thenReturn();

        $guides = $guides->with(['city', 'languages', 'employee.user'])->get();
        $guides->map->formatObject();
        $guides->map->CanBeDeletedFlag();
        return Helpers::FormatForDatatable($guides, $count);
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id');
    }

    public function reserved_for_jobs()
    {
        return $this->hasMany(JobGuide::class, 'guide_id');
    }

    public function languages()
    {
        return $this->belongsToMany(Language::class, 'guide_languages', 'guide_id', 'lang_id')->withTimestamps();
    }

    public function unavailable_at()
    {
        return $this->hasMany(GuideUnavailableAt::class, 'guide_id');
    }

    public function additional_value_cert()
    {
        return $this->morphOne(File::class, 'fileable')->where('file_type', 'additional_value_cert');
    }

    public function tax_id()
    {
        return $this->morphOne(File::class, 'fileable')->where('file_type', 'tax_id');
    }

    public function editPath()
    {
        return route('guides.edit', ['guide' => $this->id]);
    }

    public function deletePath()
    {
        return route('guides.destroy', ['guide' => $this->id]);
    }

    public function formatObject()
    {
        $this->languagesToStr();
        $this->addCurrencyToPrices();
        $this->email = $this->employee->user->email;
    }

    public function languagesToStr()
    {
        $languages_str = '';
        foreach ($this->languages as $lang) {
            $languages_str .= $lang->language . ', ';
        }
        $this->languages_str = trim($languages_str, ', ');
    }

    public function updateLanguages($data)
    {
        if (!isset($data['languages'])) {
            return $data;
        }
        $languages = $data['languages'];
        $this->languages()->detach();
        foreach ($languages as $language) {
            $this->languages()->attach($language);
        }
    }

    public static function pricesFields()
    {
        return ['daily_fee'];
    }

    public static function pricesFieldsWithCurrencies()
    {
        return [
            'daily_fee' => 'currency'
        ];
    }

    public static function availableGuides($day, $job_id = null)
    {
        $guides = self::where(function ($main_query) use ($day, $job_id) {
            $main_query->whereDoesntHave('reserved_for_jobs', function ($query) use ($day) {
                $query->where('date', '=', $day);
            });
            if ($job_id) {
                $main_query->orWhereHas('reserved_for_jobs', function ($query) use ($job_id) {
                    $query->where('job_id', $job_id);
                });
            }
        })->whereDoesntHave('unavailable_at', function ($query) use ($day) {
            $query->where('day', '=', $day);
        })->get();
        return $guides;
    }

    public function createUserAndEmp()
    {
        $escaped_name = strtolower(preg_replace('/\W+/', "_", $this->name));
        if (strlen($escaped_name) < 10) {
            if ($escaped_name == '_') {
                $escaped_name = strtolower(Str::random(10));
            } else {
                $escaped_name .= strtolower(Str::random(5));
            }
        }
        $generated_email = $escaped_name . '_guide@vdm-egypt.com';
        $user_data = [
            'name' => $this->name,
            'name_ar' => $this->name_ar,
            'email' => $generated_email,
            'password' => 'guide_-_password',
            'phone' => $this->phone,
            'address' => 'address'
        ];
        $user = User::create($user_data);
        $emp_date = [
            'job_id' => JobTitle::where('title', JobTitle::GUIDE_TITLE)->first()->id,
            'commission' => 0,
            'gender' => 1,
            'outsource' => 1,
            'city_id' => $this->city_id
        ];
        $emp = $user->employee()->create($emp_date);
        $emp_permissions = Permission::getGuidePermissions();
        $data = ['permissions' => $emp_permissions];
        $emp->updatePermissions($data);
        $this->employee_id = $emp->id;
        $this->save();
    }

    public function updateUser()
    {
        $user = $this->employee->user;
        $user->name = $this->name;
        $user->name_ar = $this->name_ar;
        $user->phone = $this->phone;
        $user->save();
    }

    public function saveUnavailable_at($data)
    {
        $this->unavailable_at()->delete();
        $dates = [];
        if (isset($data['unavailable_dates'])) {
            foreach ($data['unavailable_dates'] as $date) {
                $dates[] = ['day' => $date];
            }
        }
        $this->unavailable_at()->createMany($dates);
    }

    public function saveAdditionalValueCert($additional_value_cert)
    {
        if ($additional_value_cert) {
            $data = File::uploadFile($additional_value_cert, 'images', $this->id);
            if ($data) {
                $data['file_type'] = 'additional_value_cert';
                $query = [
                    'fileable_id' => $this->id,
                    'fileable_type' => static::class,
                    'file_type' => $data['file_type']
                ];
                $this->additional_value_cert()->updateOrCreate($query, $data);
            }
        }
    }

    public function saveTaxID($tax_id)
    {
        if ($tax_id) {
            $data = File::uploadFile($tax_id, 'images', $this->id);
            if ($data) {
                $data['file_type'] = 'tax_id';
                $query = [
                    'fileable_id' => $this->id,
                    'fileable_type' => static::class,
                    'file_type' => $data['file_type']
                ];
                $this->tax_id()->updateOrCreate($query, $data);
            }
        }
    }
}
