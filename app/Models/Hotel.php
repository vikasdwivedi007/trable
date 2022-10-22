<?php

namespace App\Models;

use App\Traits\SerializeDate;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Pipeline\Pipeline;
use Spatie\Activitylog\Traits\LogsActivity;

class Hotel extends Model
{
    use SoftDeletes, LogsActivity, SerializeDate;

    protected $fillable = ['name', 'phone', 'email', 'city_id', 'tripadvisor_url'];

    protected static $logAttributes = ['*'];
    protected static $logAttributesToIgnore = ['created_at', 'updated_at'];
    protected static $logOnlyDirty = true;

    const PERMISSION_NAME = 'Hotel';

    public function file()
    {
        return $this->morphOne(File::class, 'fileable');
    }

    public function contacts()
    {
        return $this->morphMany(Contact::class, 'contactable');
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function rooms()
    {
        return $this->hasMany(Room::class);
    }

    public static function hotelsIndex()
    {
        $hotels = app(Pipeline::class)->send(self::query())
            ->through([
                \App\QueryFilters\FilterBy::class,
                \App\QueryFilters\Order::class,
                \App\QueryFilters\Paginate::class,//always last
            ])
            ->thenReturn();

        return $hotels->paginate();
    }

    public function editPath()
    {
        return route('hotels.edit', ['hotel' => $this->id]);
    }

    public function deletePath()
    {
        return route('hotels.destroy', ['hotel' => $this->id]);
    }

    public function saveContract($contract)
    {
        if ($contract) {
            $data = File::uploadFile($contract, 'contracts', $this->id);
            if ($data) {
                $query = [
                    'fileable_id' => $this->id,
                    'fileable_type' => static::class
                ];
                $this->file()->updateOrCreate($query, $data);
            }
        }
    }

    public function createOrUpdateContacts($contacts)
    {
        $existing_contacts = $this->contacts;
        if ($contacts) {
            foreach ($contacts as $contact) {
                if (isset($contact['id']) && $contact['id']) {
                    $this->contacts()->updateOrCreate(['id' => $contact['id']], $contact);
                } else {
                    $this->contacts()->create($contact);
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

    public function getRoomsSelectors()
    {
        $rooms_selectors = ['types' => [], 'meal_plans' => [], 'views' => []];
        $this->load('rooms');
        foreach ($this->rooms as $room) {
            if (!in_array($room->type, array_keys($rooms_selectors['types']))) {
                $rooms_selectors['types'][$room->type] = Room::room_types($room->type);
            }
            if (!in_array($room->meal_plan, array_keys($rooms_selectors['meal_plans']))) {
                $rooms_selectors['meal_plans'][$room->meal_plan] = Room::meal_plans($room->meal_plan);
            }
            if (!in_array($room->view, $rooms_selectors['views'])) {
                $rooms_selectors['views'][] = $room->view;
            }
        }
        return $rooms_selectors;
    }

}
