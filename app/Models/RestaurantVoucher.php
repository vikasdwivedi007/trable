<?php

namespace App\Models;

use App\Helpers;
use App\Traits\SerializeDate;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Pipeline\Pipeline;
use Spatie\Activitylog\Traits\LogsActivity;

class RestaurantVoucher extends Model
{
    use SoftDeletes, LogsActivity, SerializeDate;

    const PERMISSION_NAME = 'Voucher';

    protected $fillable = ['job_id', 'issued_by', 'to', 'details', 'serial_no'];

    protected static $logAttributes = ['*'];
    protected static $logAttributesToIgnore = ['created_at', 'updated_at'];
    protected static $logOnlyDirty = true;

    public $can_search_by = ['serial_no', 'job_file.file_no', 'issued_by', 'to', 'details', 'job_file.departure_date', 'job_file.arrival_date', 'job_file.client_name'];

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

    public static function vouchersIndex()
    {
        $query = self::select([
            'restaurant_vouchers.*',
            'job_file.file_no as job_file.file_no',
        ])->leftJoin('job_files as job_file', 'restaurant_vouchers.job_id', '=', 'job_file.id');

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

        $vouchers = $vouchers->with(['job_file', 'job_file.airport_from', 'job_file.airport_to'])->get();
        $vouchers->map(function($voucher){
            $voucher->formatSerialNo();
            $voucher->airport_from_formatted = $voucher->job_file->airport_from->format();
            $voucher->airport_to_formatted = $voucher->job_file->airport_to->format();
        });
        return Helpers::FormatForDatatable($vouchers, $count);
    }

    public function show_path()
    {
        return route('restaurant-vouchers.show', ['restaurant_voucher' => $this->id]);
    }

    public function formatSerialNo(){
        $this->serial_no = sprintf("%03d", $this->serial_no);
    }
}
