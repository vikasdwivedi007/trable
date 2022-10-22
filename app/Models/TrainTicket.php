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

class TrainTicket extends Model
{
    use SoftDeletes, LogsActivity, ServiceCanBeDeleted, SerializeDate, SaveInitialPrices, AddCurrenciesToPrices;

    const PERMISSION_NAME = 'Train-Ticket';

    protected $fillable = ['type', 'number', 'wagon_no', 'seat_no', 'class', 'sgl_buy_price', 'sgl_sell_price', 'dbl_buy_price', 'dbl_sell_price', 'from_station_id', 'to_station_id', 'depart_at', 'arrive_at', 'cabin_no', 'sgl_buy_currency', 'sgl_sell_currency', 'dbl_buy_currency', 'dbl_sell_currency'];

    protected static $logAttributes = ['*'];
    protected static $logAttributesToIgnore = ['created_at', 'updated_at'];
    protected static $logOnlyDirty = true;

    protected $dates = ['depart_at', 'arrive_at'];
    protected $casts = [
        'depart_at' => 'datetime:l d F Y H:i',
        'arrive_at' => 'datetime:l d F Y H:i',
    ];

    public $can_search_by = ['number', 'wagon_no', 'seat_no', 'from_station.name', 'to_station.name', 'type', 'class'];

    public static $price_fields = ['sgl_buy_price', 'sgl_sell_price', 'dbl_buy_price', 'dbl_sell_price'];

    public static function boot()
    {
        parent::boot();

        self::saving(function ($ticket) {
            foreach (self::$price_fields as $field) {
                if (!$ticket->{$field}) {
                    $ticket->{$field} = 0;
                }
            }
        });
    }

    public static function trainTicketsIndex()
    {
        $query = self::select([
            'train_tickets.*',
            'from_station.name as from_station.name',
            'to_station.name as to_station.name',
        ])->join('train_stations as from_station', 'train_tickets.from_station_id', '=', 'from_station.id')
            ->join('train_stations as to_station', 'train_tickets.to_station_id', '=', 'to_station.id');

        $train_tickets = app(Pipeline::class)->send($query)
            ->through([
                \App\QueryFilters\FilterBy::class,
                \App\QueryFilters\FilterByRelationship::class,
                \App\QueryFilters\Order::class,
            ])
            ->thenReturn();
        $count = $train_tickets->count();
        $train_tickets = app(Pipeline::class)->send($train_tickets)
            ->through([
                \App\QueryFilters\Paginate::class,//always last
            ])
            ->thenReturn();
        $train_tickets = $train_tickets->with(['from_station', 'to_station'])->get();
        $train_tickets->map->attributesToStr();
        $train_tickets->map->addCurrencyToPrices();
        $train_tickets->map->CanBeDeletedFlag();
        return Helpers::FormatForDatatable($train_tickets, $count);
    }

    public function from_station()
    {
        return $this->belongsTo(TrainStation::class, 'from_station_id');
    }

    public function to_station()
    {
        return $this->belongsTo(TrainStation::class, 'to_station_id');
    }

    public function job_trains()
    {
        return $this->hasMany(JobTrainTicket::class, 'train_ticket_id');
    }

    public function setDepartTimeAttribute($depart_time)
    {
        $this->attributes['depart_at'] = Carbon::createFromFormat('l d F Y H:i', $this->depart_date . ' ' . $depart_time);
        unset($this->attributes['depart_date']);
    }

    public function setArriveTimeAttribute($arrive_time)
    {
        $this->attributes['arrive_at'] = Carbon::createFromFormat('l d F Y H:i', $this->arrive_date . ' ' . $arrive_time);
        unset($this->attributes['arrive_date']);
    }

    public static function combineDates($data)
    {
        $data['depart_at'] = Carbon::createFromFormat('l d F Y H:i', $data['depart_date'] . ' ' . $data['depart_time']);
        $data['arrive_at'] = Carbon::createFromFormat('l d F Y H:i', $data['arrive_date'] . ' ' . $data['arrive_time']);
        return $data;
    }

    public function editPath()
    {
        return route('train-tickets.edit', ['train_ticket' => $this->id]);
    }

    public function deletePath()
    {
        return route('train-tickets.destroy', ['train_ticket' => $this->id]);
    }

    public function attributesToStr()
    {
        $this->type = $this->type == 1 ? 'Sleeping' : 'Seating';
        $this->class = $this->class == 1 ? 'First Class' : 'Second Class';
    }

    public static function searchForClass($filter_q)
    {
        return Arr::where([1 => 'First Class', 2 => 'Second Class'], function ($value, $key) use ($filter_q) {
            if (stripos(strtolower($value), strtolower($filter_q)) !== false) {
                return true;
            }
        });
    }

    public static function searchForType($filter_q)
    {
        return Arr::where([1 => 'Seating', 2 => 'Sleeping'], function ($value, $key) use ($filter_q) {
            if (stripos(strtolower($value), strtolower($filter_q)) !== false) {
                return true;
            }
        });
    }

    public static function pricesFields()
    {
        return ['sgl_buy_price', 'sgl_sell_price', 'dbl_buy_price', 'dbl_sell_price'];
    }

    public static function pricesFieldsWithCurrencies()
    {
        return [
            'sgl_buy_price' => 'sgl_buy_currency',
            'sgl_sell_price' => 'sgl_sell_currency',
            'dbl_buy_price' => 'dbl_buy_currency',
            'dbl_sell_price' => 'dbl_sell_currency'
        ];
    }

    public function formatObject()
    {
        $this->depart_at_date = $this->depart_at->format('l d F Y');
        $this->depart_at_time = $this->depart_at->format('H:i');
        $this->arrive_at_date = $this->arrive_at->format('l d F Y');
        $this->arrive_at_time = $this->arrive_at->format('H:i');
        $this->attributesToStr();
        $this->sgl_sell_currency = Currency::currencyName($this->sgl_sell_currency);
        $this->dbl_sell_currency = Currency::currencyName($this->dbl_sell_currency);
        return $this;
    }
}
