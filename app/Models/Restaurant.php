<?php

namespace App\Models;

use App\Helpers;
use App\Traits\SerializeDate;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Pipeline\Pipeline;
use Spatie\Activitylog\Traits\LogsActivity;

class Restaurant extends Model
{
    use SoftDeletes, LogsActivity, SerializeDate;

    const PERMISSION_NAME = 'Restaurant';

    protected $fillable = ['name', 'email', 'phone', 'address', 'city_id'];

    protected static $logAttributes = ['*'];
    protected static $logAttributesToIgnore = ['created_at', 'updated_at'];
    protected static $logOnlyDirty = true;

    public $can_search_by = ['restaurants.name', 'email', 'phone', 'address', 'city.name'];

    public static function restaurantsIndex()
    {
        $query = self::select([
            'restaurants.*',
            'restaurants.name as restaurants.name',
            'city.name as city.name',
        ])->leftJoin('cities as city', 'restaurants.city_id', '=', 'city.id');

        $restaurants = app(Pipeline::class)->send($query)
            ->through([
                \App\QueryFilters\FilterBy::class,
                \App\QueryFilters\FilterByRelationship::class,
                \App\QueryFilters\Order::class,
            ])
            ->thenReturn();
        $count = $restaurants->count();
        $restaurants = app(Pipeline::class)->send($query)
            ->through([
                \App\QueryFilters\Paginate::class,//always last
            ])
            ->thenReturn();

        $restaurants = $restaurants->with('city')->get();
        return Helpers::FormatForDatatable($restaurants, $count);
    }

    public function contacts()
    {
        return $this->morphMany(Contact::class, 'contactable');
    }

    public function menus()
    {
        return $this->hasMany(RestaurantMenu::class);
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function editPath()
    {
        return route('restaurants.edit', ['restaurant' => $this->id]);
    }

    public function deletePath()
    {
        return route('restaurants.destroy', ['restaurant' => $this->id]);
    }

    public function createOrUpdateMenus($menus)
    {
        $existing_menus = $this->menus;
        if ($menus) {
            foreach ($menus as $menu) {
                if(isset($menu['id']) && $menu['id']){
                    $this->menus()->updateOrCreate(['id'=>$menu['id']], $menu);
                }else{
                    $this->menus()->create($menu);
                }
            }
        }else{
            $menus = [];
        }
        foreach($existing_menus as $existing_menu){
            $exists = false;
            foreach($menus as $menu){
                if(isset($menu['id']) && $menu['id']) {
                    if ($existing_menu->id == $menu['id']) {
                        $exists = true;
                    }
                }
            }
            if(!$exists){
                $existing_menu->delete();
            }
        }
    }

    public function createOrUpdateContacts($contacts)
    {
        $existing_contacts = $this->contacts;
        if ($contacts) {
            foreach ($contacts as $contact) {
                if($contact['name'] || $contact['email'] || $contact['phone']){
                    if (isset($contact['id']) && $contact['id']) {
                        $this->contacts()->updateOrCreate(['id' => $contact['id']], $contact);
                    } else {
                        $this->contacts()->create($contact);
                    }
                }elseif(isset($contact['id']) && $contact['id']) {
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
}
