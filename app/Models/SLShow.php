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
use Spatie\Activitylog\Traits\LogsActivity;

class SLShow extends Model
{
    use SoftDeletes, LogsActivity, ServiceCanBeDeleted, SerializeDate, SaveInitialPrices, AddCurrenciesToPrices;

    const PERMISSION_NAME = 'S&L-Show';

    protected $fillable = ['date', 'place', 'language_id', 'time', 'buy_price_adult', 'sell_price_adult_vat_exc', 'buy_price_child', 'sell_price_child_vat_exc', 'ticket_type', 'adult_buy_currency', 'adult_sell_currency', 'child_buy_currency', 'child_sell_currency'];

    protected static $logAttributes = ['*'];
    protected static $logAttributesToIgnore = ['created_at', 'updated_at'];
    protected static $logOnlyDirty = true;

    public $can_search_by = ['place', 'language.language'];

    protected $dates = ['date', 'time'];

    protected $casts = [
        'date' => 'date:l d F Y',
        'time' => 'datetime:H:i'
    ];

    public static function slshowsIndex()
    {
        $query = self::select([
            's_l_shows.*',
            'language.language as language.language',
        ])->leftJoin('languages as language', 's_l_shows.language_id', '=', 'language.id');

        $slshows = app(Pipeline::class)->send($query)
            ->through([
                \App\QueryFilters\FilterBy::class,
                \App\QueryFilters\FilterByRelationship::class,
                \App\QueryFilters\Order::class,
            ])
            ->thenReturn();
        $count = $slshows->count();
        $slshows = app(Pipeline::class)->send($slshows)
            ->through([
                \App\QueryFilters\Paginate::class,//always last
            ])
            ->thenReturn();

        $slshows = $slshows->with('language')->get();
        $slshows->map->fillIfAllLanguages();
        $slshows->map->addCurrencyToPrices();
        $slshows->map->CanBeDeletedFlag();
        return Helpers::FormatForDatatable($slshows, $count);
    }

    public function language()
    {
        return $this->belongsTo(Language::class);
    }

    public function setDateAttribute($date)
    {
        $this->attributes['date'] = Carbon::createFromFormat('l d F Y', $date);
    }

    public function setTimeAttribute($time)
    {
        $date_str = $this->date->format('l d F Y') . ' ' . $time;
        $this->attributes['time'] = Carbon::createFromFormat('l d F Y H:i', $date_str);
    }

    public function program_itemable()
    {
        return $this->morphOne(ProgramItem::class, 'program_itemable');
    }

    public function editPath()
    {
        return route('slshows.edit', ['slshow' => $this->id]);
    }

    public function deletePath()
    {
        return route('slshows.destroy', ['slshow' => $this->id]);
    }

    public function fillIfAllLanguages()
    {
        if ($this->language_id == Language::ALL_LANGUAGES_ID) {
            $this->unsetRelation('language');
            $this->language = (object)['language' => 'All Languages'];
        }
    }

    public static function pricesFields()
    {
        return ['buy_price_adult', 'sell_price_adult_vat_exc', 'buy_price_child', 'sell_price_child_vat_exc',];
    }

    public static function pricesFieldsWithCurrencies()
    {
        return [
            'buy_price_adult' => 'adult_buy_currency',
            'sell_price_adult_vat_exc' => 'adult_sell_currency',
            'buy_price_child' => 'child_buy_currency',
            'sell_price_child_vat_exc' => 'child_sell_currency',
        ];
    }

    public static function getLangsByCityAndDate($date, $place)
    {
        $data = ['langs' => []];
        $slshows = SLShow::where('date', $date)->where('place', $place)->with('language')->orderBy('language_id')->get();
        foreach ($slshows as $slshow) {
            if ($slshow->language_id == Language::ALL_LANGUAGES_ID) {
                $lang = ['id' => $slshow->language_id, 'lang' => 'All Languages'];
            } else {
                $lang = ['id' => $slshow->language_id, 'lang' => $slshow->language->language];
            }
            if (!in_array($lang, $data['langs'])) {
                $data['langs'][] = $lang;
            }
        }
        return $data;
    }
}
