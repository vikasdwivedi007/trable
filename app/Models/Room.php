<?php

namespace App\Models;

use App\Helpers;
use App\Traits\SerializeDate;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Pipeline\Pipeline;
use Illuminate\Support\Arr;
use Spatie\Activitylog\Traits\LogsActivity;

class Room extends Model
{
    use SoftDeletes, LogsActivity, SerializeDate;
    //name in db is category in blade views
    protected $fillable = ['hotel_id', 'name', 'type', 'meal_plan', 'view', 'info'];
    protected static $logAttributes = ['*'];
    protected static $logAttributesToIgnore = ['created_at', 'updated_at'];
    protected static $logOnlyDirty = true;
    const PERMISSION_NAME = 'Hotel';//shares permission with Hotel model
    public $can_search_by = ['rooms.name', 'type', 'meal_plan', 'hotel.name', 'hotel.phone', 'hotel.email', 'city.name'];
    protected $dates = ['price_valid_from', 'price_valid_to'];
    protected $casts = [
        'price_valid_from' => 'date:l d F Y',
        'price_valid_to' => 'date:l d F Y'
    ];

    public static function room_types($key = 0)
    {
        $types = [
            1 => 'Single',
            2 => 'Double',
            3 => 'Triple',
            4 => 'Quad',
            //5 => 'Queen',
            6 => 'King',
            7 => 'Twin',
            8 => 'Suite',
        ];
        if ($key) {
            return isset($types[$key]) ? $types[$key] : null;
        } else {
            return $types;
        }
    }

    public static function meal_plans($key = 0)
    {
        $plans = [
            1 => 'bb',
            2 => 'hb',
            3 => 'fb',
            4 => 'ai',
        ];
        if ($key) {
            return isset($plans[$key]) ? $plans[$key] : null;
        } else {
            return $plans;
        }
    }

    public static function roomsIndex()
    {
        //add object city -> name to room for sorting and search
        $query = self::select([
            'hotel.name as hotel.name',
            'hotel.phone as hotel.phone',
            'hotel.email as hotel.email',
            'city.name as city.name',
            'details.*',
            'rooms.*',
        ])->join('hotels as hotel', 'rooms.hotel_id', '=', 'hotel.id')
            ->join('cities as city', 'hotel.city_id', '=', 'city.id')
            ->leftjoin('room_details as details', 'rooms.id', '=', 'details.room_id');

        $rooms = app(Pipeline::class)->send($query)
            ->through([
                \App\QueryFilters\FilterBy::class,
                \App\QueryFilters\FilterByRelationship::class,
                \App\QueryFilters\Order::class,
            ])
            ->thenReturn();
        $count = $rooms->count();
        $rooms = app(Pipeline::class)->send($rooms)
            ->through([
                \App\QueryFilters\Paginate::class,//always last
            ])
            ->thenReturn();

        $rooms = $rooms->with(['discount'])->get();
        $rooms->map->formatObject();
        return Helpers::FormatForDatatable($rooms, $count);
    }

    public function hotel()
    {
        return $this->belongsTo(Hotel::class);
    }

    public function details()
    {
        return $this->hasOne(RoomDetails::class);
    }

    public function cancellations()
    {
        return $this->hasMany(Cancellation::class);
    }

    public function discount()
    {
        return $this->morphOne(Discount::class, 'discountable');
    }

    public function editPath()
    {
        return route('rooms.edit', ['room' => $this->id]);
    }

    public function deletePath()
    {
        return route('rooms.destroy', ['room' => $this->id]);
    }

    public function formatObject()
    {
        $this->hotel = (object)['name' => $this->{'hotel.name'}, 'phone' => $this->{'hotel.phone'}, 'email' => $this->{'hotel.email'}];
        $this->city = (object)['name' => $this->{'city.name'}];
        $has_discount = $this->discount()->count() ? $this->discount->toArray() : false;
        if ($has_discount) {
            $this->formatted_discount = $has_discount['value'];
            $this->formatted_discount .= $has_discount['type'] == Discount::TYPE_PERCENTAGE ? '%' : '';
        } else {
            $this->formatted_discount = '';
        }
        $this->rate_after_discount = $this->base_rate;
        if ($this->formatted_discount) {
            if ($has_discount['type'] == Discount::TYPE_PERCENTAGE) {
                $this->rate_after_discount = $this->base_rate - ($this->base_rate * $has_discount['value'] / 100);
            } else {
                $this->rate_after_discount = $this->base_rate - $has_discount['value'];
            }
        }
        $this->type = self::room_types($this->type);
        $this->meal_plan = strtoupper(self::meal_plans($this->meal_plan));
    }

    public static function searchForType($filter_q)
    {
        return Arr::where(self::room_types(), function ($value, $key) use ($filter_q) {
            if (stripos(strtolower($value), strtolower($filter_q)) !== false) {
                return true;
            }
        });
    }

    public static function searchForPlans($filter_q)
    {
        return Arr::where(self::meal_plans(), function ($value, $key) use ($filter_q) {
            if (stripos(strtolower($value), strtolower($filter_q)) !== false) {
                return true;
            }
        });
    }

    public function createOrUpdateCancels($cancels)
    {
        $existing_cancels = $this->cancellations;
        if ($cancels) {
            foreach ($cancels as $cancel) {
                if (isset($cancel['id']) && $cancel['id']) {
                    $this->cancellations()->updateOrCreate(['id' => $cancel['id']], $cancel);
                } else {
                    $this->cancellations()->create($cancel);
                }
            }
        } else {
            $cancels = [];
        }
        foreach ($existing_cancels as $existing_cancel) {
            $exists = false;
            foreach ($cancels as $cancel) {
                if (isset($cancel['id']) && $cancel['id']) {
                    if ($existing_cancel->id == $cancel['id']) {
                        $exists = true;
                    }
                }
            }
            if (!$exists) {
                $existing_cancel->delete();
            }
        }
    }

    public static function availableRooms($from, $to, $city_id)
    {
        $rooms = self::whereHas('hotel', function ($query) use ($city_id) {
            $query->where('city_id', $city_id);
        })
            ->whereHas('details', function ($query2) use ($from, $to) {
                $query2->where('price_valid_from', '<=', $from)
                    ->where('price_valid_to', '>=', $to);
            })->with(['hotel', 'details'])->get();
//        $rooms->pluck('hotel')->toArray();
        return $rooms;
    }

    public static function isAvailable($data)
    {
        $query = self::query();
        $room = $query->where('hotel_id', $data['hotel_id'])
            ->where('type', $data['room_type'])
            ->where('meal_plan', $data['meal_plan'])
            ->where('view', $data['view'])
            ->where('name', $data['category'])
            ->whereHas('details', function ($query2) use ($data) {
                $query2->where('price_valid_from', '<=', Carbon::createFromFormat('l d F Y', $data['check_in']))
                    ->where('price_valid_to', '>=', Carbon::createFromFormat('l d F Y', $data['check_out']));
            })
            ->with([
                'hotel',
                'hotel.city',
                'details',
                'cancellations' => function ($query) {
                    $query->orderBy('time', 'asc');
                },
            ])
            ->first();
        if ($room) {
            $room->currency = Currency::currencyName($room->details->base_rate_currency);
        }
        return $room;
    }

    public function findOtherPrices($search_data)
    {
        if (Carbon::createFromFormat('l d F Y', $search_data['check_in']) < now()->startOfDay()) {
            return [];
        }
        if ($this->hotel->tripadvisor_url) {
            $id = CompareHotelPrices::getIDFromURL($this->hotel->tripadvisor_url);
            logger('found id');
        } else {
            $id = CompareHotelPrices::getHotelID($this->hotel->name . ' Egypt ' . $this->hotel->city->name, $this->hotel->id);
            logger('retrieved id from beginning');
        }
        $other_options = [];
        if ($id) {
            $tries = 1;
            $search_data['hotel_id'] = $id;
            $search_data['currency'] = $this->currency;
            logger($search_data);
            $other_options = CompareHotelPrices::getHotelPrices($search_data);
            while ($tries <= 3 && count(array_keys($other_options, 'Not available')) == 4) {
                logger($tries);
                $other_options = CompareHotelPrices::getHotelPrices($search_data);
                $tries++;
            }
            logger($other_options);
        }
        return $other_options;
    }
}
