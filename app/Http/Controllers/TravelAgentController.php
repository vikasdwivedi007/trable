<?php

namespace App\Http\Controllers;

use App\Helpers;
use App\Models\City;
use App\Models\Country;
use App\Models\File;
use App\Models\TravelAgent;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Validation\Rule;

class TravelAgentController extends Controller
{

    private $prefix = 'travel-agents.';
    private $middlewares = ['auth'];

    public function __construct()
    {
        $this->middleware($this->middlewares);
    }

    public function index()
    {
        $this->authorize('viewAny', TravelAgent::class);
        if(request()->ajax()){
            $travel_agents = TravelAgent::travelAgentsIndex();
            return $travel_agents;
        }
        return view($this->prefix.'index');
    }

    public function create()
    {
        $this->authorize('create', TravelAgent::class);
        $countries = Country::all();
        $cities = [];
        return view($this->prefix.'create', compact('countries', 'cities'));
    }

    public function store(Request $request)
    {
        $this->authorize('create', TravelAgent::class);
        $data = $this->validateRequest();
        $travel_agent = TravelAgent::create(Arr::except($data, ['contract']));
        $travel_agent->createOrUpdateContacts(isset($data['contacts']) ? $data['contacts'] : []);
        $travel_agent->saveContract(isset($data['contract']) ? $data['contract'] : null);
        return redirect(route($this->prefix . 'index'))->with('success', __("main.travel_agent_added"));
    }

    public function edit(TravelAgent $travel_agent)
    {
        $travel_agent->load('file', 'city');
        $this->authorize('update', $travel_agent);
        $countries = Country::all();
        $cities = City::where('country_id', $travel_agent->city->country_id)->get();
        return view($this->prefix.'edit', compact( 'travel_agent', 'countries', 'cities'));
    }

    public function update(Request $request, TravelAgent $travel_agent)
    {
        $this->authorize('update', $travel_agent);
        $data = $this->validateRequest();
        $travel_agent->update(Arr::except($data, ['contract']));
        $travel_agent->createOrUpdateContacts(isset($data['contacts']) ? $data['contacts'] : []);
        $travel_agent->saveContract(isset($data['contract']) ? $data['contract'] : null);
        return redirect(route($this->prefix . 'index'))->with('success', __("main.travel_agent_updated"));
    }

    public function destroy(TravelAgent $travel_agent)
    {
        $this->authorize('delete', $travel_agent);
        $result = $travel_agent->delete();
        if($result){
            if($travel_agent->file){
                $travel_agent->file->delete();
            }
            return redirect(route($this->prefix.'index'))->with('success', __("main.travel_agent_deleted"));
        }else{
            return redirect(route($this->prefix.'index'))->with('error', __("main.travel_agent_not_deleted_linked_job_file"));
        }
    }



    private function validateRequest()
    {
        $rules = [
            'name' => 'required|string|min:4',
            'email' => 'nullable|email',
            'phone' => 'required|numeric',
            'contacts.*.name' => 'nullable',
            'contacts.*.email' => 'nullable|email',
            'contacts.*.phone' => 'nullable|numeric',
            'country_id' => 'required|exists:countries,id',
            'city_id' => 'required|exists:cities,id',
            'address' => 'required',
            'rate_amount' => 'nullable|numeric',
            'contract' => 'nullable|file'
        ];
        Helpers::removeCurrencyFromNumericFields($rules);
        Helpers::formatTravelAgentRequestParams();
        return request()->validate($rules);
    }
}
