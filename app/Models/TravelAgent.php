<?php

namespace App\Models;

use App\Helpers;
use App\Traits\SerializeDate;
use App\Traits\ServiceCanBeDeleted;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Pipeline\Pipeline;
use Spatie\Activitylog\Traits\LogsActivity;

class TravelAgent extends Model
{
    use SoftDeletes, LogsActivity, ServiceCanBeDeleted, SerializeDate;

    protected $fillable = ['name', 'email', 'phone', 'address', 'rate_amount', 'country_id', 'city_id'];

    protected static $logAttributes = ['*'];
    protected static $logAttributesToIgnore = ['created_at', 'updated_at'];
    protected static $logOnlyDirty = true;

    //will change this name
    const PERMISSION_NAME = 'TravelAgent';

    public $can_search_by = ['travel_agents.name', 'phone', 'email', 'city.name', 'country.name'];

    public function file()
    {
        return $this->morphOne(File::class, 'fileable');
    }

    public static function travelAgentsIndex()
    {
        $query = self::select([
            'travel_agents.*',
            'city.name as city.name',
            'country.name as country.name',
        ])->leftJoin('cities as city', 'travel_agents.city_id', '=', 'city.id')
            ->leftJoin('countries as country', 'travel_agents.country_id', '=', 'country.id');

        $travel_agents = app(Pipeline::class)->send($query)
            ->through([
                \App\QueryFilters\FilterBy::class,
                \App\QueryFilters\Order::class,
            ])
            ->thenReturn();
        $count = $travel_agents->count();
        $travel_agents = app(Pipeline::class)->send($travel_agents)
            ->through([
                \App\QueryFilters\Paginate::class,//always last
            ])
            ->thenReturn();
        $travel_agents = $travel_agents->with(['city', 'country'])->get();

        $travel_agents->map->CanBeDeletedFlag();
        return Helpers::FormatForDatatable($travel_agents, $count);
    }

    public function editPath()
    {
        return route('travel-agents.edit', ['travel_agent' => $this->id]);
    }

    public function deletePath()
    {
        return route('travel-agents.destroy', ['travel_agent' => $this->id]);
    }

    public function contacts()
    {
        return $this->morphMany(Contact::class, 'contactable');
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function job_files()
    {
        return $this->hasMany(JobFile::class, 'travel_agent_id');
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
