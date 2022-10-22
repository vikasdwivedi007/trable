<?php

namespace App\Models;

use App\Helpers;
use App\Traits\SerializeDate;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Pipeline\Pipeline;
use Spatie\Activitylog\Traits\LogsActivity;

class GuideVoucher extends Model
{
    use SoftDeletes, LogsActivity, SerializeDate;

    const PERMISSION_NAME = 'Voucher';

    protected $fillable = ['job_id', 'issued_by', 'guide_id', 'guide_address', 'serial_no', 'hotel_id', 'room_no', 'transport_by', 'pax_no', 'tour_operator', 'issue_date'];

    protected static $logAttributes = ['*'];
    protected static $logAttributesToIgnore = ['created_at', 'updated_at'];
    protected static $logOnlyDirty = true;

    public $can_search_by = ['serial_no', 'job_file.file_no', 'issued_by', 'hotel.name', 'guide.name', 'job_file.client_name', 'tour_operator'];

    protected $dates = ['issue_date'];
    protected $casts = [
        'issue_date' => 'datetime:l d F Y',
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
            $voucher->tours()->delete();
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

    public function tours()
    {
        return $this->hasMany(GuideVoucherTour::class, 'voucher_id');
    }

    public function hotel()
    {
        return $this->belongsTo(Hotel::class, 'hotel_id');
    }

    public function guide()
    {
        return $this->belongsTo(Guide::class, 'guide_id');
    }

    public static function vouchersIndex()
    {
        $query = self::select([
            'guide_vouchers.*',
            'job_file.file_no as job_file.file_no',
            'hotel.name as hotel.name',
            'guide.name as guide.name',
        ])->leftJoin('job_files as job_file', 'guide_vouchers.job_id', '=', 'job_file.id')
            ->leftJoin('hotels as hotel', 'guide_vouchers.hotel_id', '=', 'hotel.id')
            ->leftJoin('guides as guide', 'guide_vouchers.guide_id', '=', 'guide.id');

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

        $vouchers = $vouchers->with(['job_file', 'hotel', 'guide'])->get();
        $vouchers->map(function ($voucher) {
            $voucher->formatSerialNo();
            $voucher->guide->formatObject();
        });
        return Helpers::FormatForDatatable($vouchers, $count);
    }

    public function addTours($data)
    {
        if (isset($data['tours'])) {
            $this->tours()->delete();
            $this->tours()->createMany($data['tours']);
        }
    }

    public function show_path()
    {
        return route('guide-vouchers.show', ['guide_voucher' => $this->id]);
    }

    public function formatSerialNo(){
        $this->serial_no = sprintf("%03d", $this->serial_no);
    }
}
