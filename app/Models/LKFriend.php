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
use Spatie\Activitylog\Traits\LogsActivity;

class LKFriend extends Model
{
    use SoftDeletes, LogsActivity, ServiceCanBeDeleted, SerializeDate, SaveInitialPrices, AddCurrenciesToPrices;

    const PERMISSION_NAME = 'Like-a-Friend';

    protected $fillable = ['name', 'phone', 'language_id', 'city_id', 'rent_day', 'sell_rent_day_vat_exc', 'sell_rent_day_currency', 'rent_day_currency'];

    protected static $logAttributes = ['*'];
    protected static $logAttributesToIgnore = ['created_at', 'updated_at'];
    protected static $logOnlyDirty = true;

    public $can_search_by = ['l_k_friends.name', 'phone', 'language.language', 'city.name'];

    public static function lkfriendsIndex()
    {
        $query = self::select([
            'l_k_friends.*',
            'city.name as city.name',
        ])->leftJoin('cities as city', 'l_k_friends.city_id', '=', 'city.id');

        $lkfriends = app(Pipeline::class)->send($query)
            ->through([
                \App\QueryFilters\FilterBy::class,
                \App\QueryFilters\FilterByRelationship::class,
                \App\QueryFilters\Order::class,
            ])
            ->thenReturn();
        $count = $lkfriends->count();
        $lkfriends = app(Pipeline::class)->send($lkfriends)
            ->through([
                \App\QueryFilters\Paginate::class,//always last
            ])
            ->thenReturn();

        $lkfriends = $lkfriends->with(['city', 'languages'])->get();
        $lkfriends->map->languagesToStr();
        $lkfriends->map->addCurrencyToPrices();
        $lkfriends->map->CanBeDeletedFlag();
        return Helpers::FormatForDatatable($lkfriends, $count);
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function languages()
    {
        return $this->belongsToMany(Language::class, 'lkfriend_languages', 'lkfriend_id', 'lang_id')->withTimestamps();
    }

    public function editPath()
    {
        return route('lkfriends.edit', ['lkfriend' => $this->id]);
    }

    public function deletePath()
    {
        return route('lkfriends.destroy', ['lkfriend' => $this->id]);
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

    public function languagesToStr()
    {
        $languages_str = '';
        foreach ($this->languages as $lang) {
            $languages_str .= $lang->language . ', ';
        }
        $this->languages_str = trim($languages_str, ', ');
    }

    public static function pricesFields()
    {
        return ['rent_day', 'sell_rent_day_vat_exc'];
    }

    public static function pricesFieldsWithCurrencies()
    {
        return [
            'rent_day' => 'rent_day_currency',
            'sell_rent_day_vat_exc' => 'sell_rent_day_currency',
        ];
    }
}
