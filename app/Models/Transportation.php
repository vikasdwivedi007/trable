<?php

namespace App\Models;

use App\Helpers;
use App\Traits\SerializeDate;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Pipeline\Pipeline;
use Illuminate\Support\Facades\DB;
use Spatie\Activitylog\Traits\LogsActivity;

class Transportation extends Model
{
    use SoftDeletes, LogsActivity, SerializeDate;

    const PERMISSION_NAME = 'Transportation';

    protected $fillable = ['code', 'name', 'name_ar', 'email', 'phone', 'city_id'];

    protected static $logAttributes = ['*'];
    protected static $logAttributesToIgnore = ['created_at', 'updated_at'];
    protected static $logOnlyDirty = true;

    public $can_search_by = ['code', 'transportations.name', 'email', 'phone', 'city.name'];

    public static function transportationsIndex()
    {
        $query = self::select([
            'transportations.*',
            'transportations.name as transportations.name',
            'city.name as city.name',
//            DB::raw('COUNT(cars.id) AS cars_count'),
        ])->leftJoin('cities as city', 'transportations.city_id', '=', 'city.id');
//            ->leftJoin('cars as cars', 'transportations.id', '=', 'cars.transportation_id')->groupBy('transportations.id');

        $transportations = app(Pipeline::class)->send($query)
            ->through([
                \App\QueryFilters\FilterBy::class,
                \App\QueryFilters\FilterByRelationship::class,
                \App\QueryFilters\Order::class,
            ])
            ->thenReturn();
        $count = $transportations->count();
        $transportations = app(Pipeline::class)->send($transportations)
            ->through([
                \App\QueryFilters\Paginate::class,//always last
            ])
            ->thenReturn();
        $transportations = $transportations->with('city')->get();
        $transportations->map->fillerObjects();
        return Helpers::FormatForDatatable($transportations, $count);
    }

    public function contacts()
    {
        return $this->morphMany(Contact::class, 'contactable');
    }

    public function cars()
    {
        return $this->hasMany(Car::class);
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function company_register()
    {
        return $this->morphOne(File::class, 'fileable')->where('file_type', 'company_register');
    }

    public function tax_id()
    {
        return $this->morphOne(File::class, 'fileable')->where('file_type', 'tax_id');
    }

    public function editPath()
    {
        return route('transportations.edit', ['transportation' => $this->id]);
    }

    public function deletePath()
    {
        return route('transportations.destroy', ['transportation' => $this->id]);
    }

    public function createOrUpdateCars($cars)
    {
        $existing_cars = $this->cars;
        if ($cars) {
            foreach ($cars as $car) {
                if (isset($car['id']) && $car['id']) {
                    $this->cars()->updateOrCreate(['id' => $car['id']], $car);
                } else {
                    $this->cars()->create($car);
                }
            }
        } else {
            $cars = [];
        }
        foreach ($existing_cars as $existing_car) {
            $exists = false;
            foreach ($cars as $car) {
                if (isset($car['id']) && $car['id']) {
                    if ($existing_car->id == $car['id']) {
                        $exists = true;
                    }
                }
            }
            if (!$exists) {
                $existing_car->delete();
            }
        }
    }

    public function createOrUpdateContacts($contacts)
    {
        $existing_contacts = $this->contacts;
        if ($contacts) {
            foreach ($contacts as $contact) {
                if ($contact['name'] || $contact['email'] || $contact['phone']) {
                    if (isset($contact['id']) && $contact['id']) {
                        $this->contacts()->updateOrCreate(['id' => $contact['id']], $contact);
                    } else {
                        $this->contacts()->create($contact);
                    }
                } elseif (isset($contact['id']) && $contact['id']) {
                    $this->contacts()->updateOrCreate(['id' => $contact['id']], $contact);
                }
            }
        } else {
            $contacts = [];
        }
        foreach ($existing_contacts as $existing_contact) {
            $exists = false;
            foreach ($contacts as $contact) {
                if (isset($contact['id']) && $contact['id']) {
                    if ($existing_contact->id == $contact['id']) {
                        $exists = true;
                    }
                }
            }
            if (!$exists) {
                $existing_contact->delete();
            }
        }
    }

    public function fillerObjects()
    {
        $this->transportations = (object)['name' => $this->name];
    }

    public function saveCompanyRegister($company_register)
    {
        if ($company_register) {
            $data = File::uploadFile($company_register, 'images', $this->id);
            if ($data) {
                $data['file_type'] = 'company_register';
                $query = [
                    'fileable_id' => $this->id,
                    'fileable_type' => static::class,
                    'file_type' => $data['file_type']
                ];
                $this->company_register()->updateOrCreate($query, $data);
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
