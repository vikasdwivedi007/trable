<?php

namespace App\Models;

use App\Helpers;
use App\Traits\SerializeDate;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Pipeline\Pipeline;
use Spatie\Activitylog\Traits\LogsActivity;

class HotelVoucher extends Model
{
    use SoftDeletes, LogsActivity, SerializeDate;

    const PERMISSION_NAME = 'Voucher';

    protected $fillable = ['job_id', 'issued_by', 'hotel_id', 'cruise_id', 'serial_no', 'arrival_date', 'departure_date', 'single_rooms_count', 'double_rooms_count', 'triple_rooms_count', 'suite_rooms_count', 'remarks'];

    protected static $logAttributes = ['*'];
    protected static $logAttributesToIgnore = ['created_at', 'updated_at'];
    protected static $logOnlyDirty = true;

    public $can_search_by = ['serial_no', 'job_file.file_no', 'issued_by', 'hotel.name', 'cruise.name', 'job_file.client_name'];

    protected $dates = ['arrival_date', 'departure_date'];
    protected $casts = [
        'arrival_date' => 'date:l d F Y',
        'departure_date' => 'date:l d F Y',
    ];

    public static function boot()
    {
        parent::boot();

        self::created(function ($voucher) {
            $voucher->vserial()->create([]);
            $voucher->serial_no = $voucher->vserial->id;
            $voucher->save();
        });

        self::deleting(function ($voucher) {
            $voucher->vserial()->delete();
            $voucher->meals()->delete();
        });
    }

    public function job_file()
    {
        return $this->belongsTo(JobFile::class, 'job_id');
    }

    public function vserial()
    {
        return $this->morphOne(VoucherSerialized::class, 'vserialable');
    }

    public function meals()
    {
        return $this->hasMany(HotelVoucherMeal::class, 'voucher_id');
    }

    public function hotel()
    {
        return $this->belongsTo(Hotel::class, 'hotel_id');
    }

    public function cruise()
    {
        return $this->belongsTo(NileCruise::class, 'cruise_id');
    }

    public static function vouchersIndex()
    {
        $query = self::select([
            'hotel_vouchers.*',
            'job_file.file_no as job_file.file_no',
            'hotel.name as hotel.name',
            'cruise.name as cruise.name',
        ])->leftJoin('job_files as job_file', 'hotel_vouchers.job_id', '=', 'job_file.id')
            ->leftJoin('hotels as hotel', 'hotel_vouchers.hotel_id', '=', 'hotel.id')
            ->leftJoin('nile_cruises as cruise', 'hotel_vouchers.cruise_id', '=', 'cruise.id');

        $vouchers = app(Pipeline::class)->send($query)
            ->through([
                \App\QueryFilters\FilterBy::class,
                \App\QueryFilters\FilterByRelationship::class,
                \App\QueryFilters\Order::class,
            ])
            ->thenReturn();

        $count = $vouchers->count();
        $vouchers = app(Pipeline::class)->send($vouchers)
            ->through([
                \App\QueryFilters\Paginate::class
            ])
            ->thenReturn();

        $vouchers = $vouchers->with(['job_file', 'hotel', 'cruise'])->get();
        $vouchers->map(function ($voucher) {
            $voucher->formatSerialNo();
            $voucher->guests_count = $voucher->job_file->adults_count + $voucher->job_file->children_count;
            $voucher->nights_count = $voucher->arrival_date->diffInDays($voucher->departure_date);
        });
        return Helpers::FormatForDatatable($vouchers, $count);
    }

    public function addMeals($data)
    {
        if (isset($data['meals'])) {
            $this->meals()->delete();
            $this->meals()->createMany($data['meals']);
        }
    }

    public function show_path()
    {
        return route('hotel-vouchers.show', ['hotel_voucher' => $this->id]);
    }

    public function formatSerialNo(){
        $this->serial_no = sprintf("%03d", $this->serial_no);
    }
}
