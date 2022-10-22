<?php

namespace App\Models;

use App\Helpers;
use App\Traits\AddCurrenciesToPrices;
use App\Traits\SaveInitialPrices;
use App\Traits\SerializeDate;
use App\Traits\ServiceCanBeDeleted;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Pipeline\Pipeline;
use Illuminate\Support\Arr;
use Spatie\Activitylog\Traits\LogsActivity;

class Flight extends Model
{
    use SoftDeletes, LogsActivity, ServiceCanBeDeleted, SerializeDate, SaveInitialPrices, AddCurrenciesToPrices;

    const PERMISSION_NAME = 'Flight';

    const STATUS_OK = 1;
    const STATUS_WAITING = 2;

    protected $fillable = ['number', 'date', 'from', 'to', 'depart_at', 'arrive_at', 'reference', 'seats_count', 'status', 'buy_price', 'sell_price_vat_exc', 'buy_price_currency', 'sell_price_vat_exc_currency'];

    protected static $logAttributes = ['*'];
    protected static $logAttributesToIgnore = ['created_at', 'updated_at'];
    protected static $logOnlyDirty = true;

    public $can_search_by = ['number', 'airport_from.state', 'airport_to.state', 'airport_from.city', 'airport_to.city', 'airport_from.name', 'airport_to.name', 'reference', 'status'];

    protected $dates = ['date', 'depart_at', 'arrive_at'];

    protected $casts = [
        'date' => 'date:l d F Y',
        'depart_at' => 'datetime:H:i',
        'arrive_at' => 'datetime:H:i',
    ];

    public static function flightsIndex()
    {
        $query = self::select([
            'flights.*',
            'airport_from.state as airport_from.state',
            'airport_to.state as airport_to.state',
            'airport_from.city as airport_from.city',
            'airport_to.city as airport_to.city',
            'airport_from.name as airport_from.name',
            'airport_to.name as airport_to.name',
        ])->join('airports as airport_from', 'flights.from', '=', 'airport_from.id')
            ->join('airports as airport_to', 'flights.to', '=', 'airport_to.id');

        $flights = app(Pipeline::class)->send($query)
            ->through([
                \App\QueryFilters\FilterBy::class,
                \App\QueryFilters\FilterByRelationship::class,
                \App\QueryFilters\Order::class,
            ])
            ->thenReturn();
        $count = $flights->count();
        $flights = app(Pipeline::class)->send($flights)
            ->through([
                \App\QueryFilters\Paginate::class,//always last
            ])
            ->thenReturn();

        $flights = $flights->get();
        $flights->map->formatObject();
        $flights->map->addCurrencyToPrices();
        $flights->map->CanBeDeletedFlag();
        return Helpers::FormatForDatatable($flights, $count);
    }

    public function setDateAttribute($date)
    {
        $this->attributes['date'] = Carbon::createFromFormat('l d F Y', $date);
    }

    public function setDepartAtAttribute($depart_at)
    {
        $this->attributes['depart_at'] = Carbon::createFromFormat('l d F Y H:i', $this->date->format('l d F Y') . ' ' . $depart_at);
    }

    public function setArriveAtAttribute($arrive_at)
    {
        $this->attributes['arrive_at'] = Carbon::createFromFormat('l d F Y H:i', $this->date->format('l d F Y') . ' ' . $arrive_at);
    }

    public function airport_from()
    {
        return $this->belongsTo(Airport::class, 'from');
    }

    public function airport_to()
    {
        return $this->belongsTo(Airport::class, 'to');
    }

    public function editPath()
    {
        return route('flights.edit', ['flight' => $this->id]);
    }

    public function deletePath()
    {
        return route('flights.destroy', ['flight' => $this->id]);
    }

    public function job_flights()
    {
        return $this->hasMany(JobFlight::class, 'flight_id');
    }

    public static function availableStatus()
    {
        return [
            self::STATUS_OK => 'OK',
            self::STATUS_WAITING => 'Waiting List',
        ];
    }

    public function formatObject()
    {
        $this->status = self::availableStatus()[$this->status];

        $this->airport_from = (object)['city' => $this->{"airport_from.city"}, 'state' => $this->{"airport_from.state"}];
        $this->airport_to = (object)['city' => $this->{"airport_to.city"}, 'state' => $this->{"airport_to.state"}];
        if ($this->airport_from->city && $this->airport_from->state != $this->airport_from->city) {
            $this->airport_from->state = $this->airport_from->city . ' - ' . $this->airport_from->state;
        }
        if ($this->airport_to->city && $this->airport_to->state != $this->airport_to->city) {
            $this->airport_to->state = $this->airport_to->city . ' - ' . $this->airport_to->state;
        }
    }

    public static function searchForTypes($filter_q)
    {
        return Arr::where(self::availableStatus(), function ($value, $key) use ($filter_q) {
            if (stripos(strtolower($value), strtolower($filter_q)) !== false) {
                return true;
            }
        });
    }

    public static function pricesFields()
    {
        return ['buy_price', 'sell_price_vat_exc'];
    }

    public static function pricesFieldsWithCurrencies()
    {
        return [
            'buy_price' => 'buy_price_currency',
            'sell_price_vat_exc' => 'sell_price_vat_exc_currency'
        ];
    }

}
