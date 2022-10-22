<?php

namespace App\Http\Controllers;

use App\Helpers;
use App\Models\City;
use App\Models\Country;
use App\Models\File;
use App\Models\Hotel;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Validation\Rule;

class HotelController extends Controller
{
    private $prefix = 'hotels.';
    private $redirect_prefix = 'suppliers.';
    private $tab_hash = '#pills-Hotels-tab';
    private $middlewares = ['auth'];

    public function __construct()
    {
        $this->middleware($this->middlewares);
    }

    public function index()
    {
        $this->authorize('viewAny', Hotel::class);
        if (request()->ajax()) {
            $rooms = Room::roomsIndex();
            return $rooms;
        }
        return view($this->prefix . 'index');
    }

    public function sort_by_hotel_name()
    {
        $this->authorize('viewAny', Hotel::class);
        $rooms = Room::sort();
        return view($this->prefix . 'index', compact('rooms'));
    }

    public function create()
    {
        $this->authorize('create', Hotel::class);
        //Egypt cities
        $cities = City::where('country_id', Country::EGYPT_ID)->get();
        return view($this->prefix . 'create', compact('cities'));
    }

    public function store(Request $request)
    {
        $this->authorize('create', Hotel::class);
        $data = $this->validateRequest();
        $hotel = Hotel::create($data);
        $hotel->saveContract(isset($data['contract']) ? $data['contract'] : null);
        $hotel->createOrUpdateContacts(isset($data['contacts']) ? $data['contacts'] : []);
        return redirect(route($this->redirect_prefix . 'index') . $this->tab_hash)->with('success', __('main.hotel_added'));
    }

    public function edit(Hotel $hotel)
    {
        $hotel->load(['file', 'contacts']);
        $this->authorize('update', $hotel);
        $cities = City::where('country_id', Country::EGYPT_ID)->get();
        return view($this->prefix . 'edit', compact('hotel', 'cities'));
    }

    public function update(Request $request, Hotel $hotel)
    {
        $this->authorize('update', $hotel);
        $data = $this->validateRequest();
        $hotel->update($data);
        $hotel->saveContract(isset($data['contract']) ? $data['contract'] : null);
        $hotel->createOrUpdateContacts(isset($data['contacts']) ? $data['contacts'] : []);
        return redirect(route($this->redirect_prefix . 'index') . $this->tab_hash)->with('success', __('main.hotel_updated'));
    }

    public function destroy(Hotel $hotel)
    {
        $this->authorize('delete', $hotel);
        $hotel->file()->delete();
        $hotel->rooms()->delete();
        $hotel->delete();
        return redirect(route($this->redirect_prefix . 'index') . $this->tab_hash)->with('success', __('main.hotel_deleted'));
    }

    public function searchHotelsByCity()
    {
        if (request('city_id')) {
            $hotels = Hotel::where('city_id', request('city_id'))->orderBy('name')->get();
            return response()->json(['hotels' => $hotels]);
        }
    }

    public function getRoomsSelectors(Hotel $hotel)
    {
        return $hotel->getRoomsSelectors();
    }


    private function validateRequest()
    {
        $rules = [
            'name' => 'required',
            'email' => 'required|email',
            'phone' => 'required|numeric',
            'contacts' => 'array',
            'contacts.*.name' => 'required',
            'contacts.*.email' => 'required|email',
            'contacts.*.phone' => 'required|numeric',
            'city_id' => 'required|exists:cities,id',
            'contract' => 'nullable|file',
            'tripadvisor_url' => 'nullable|url',
        ];
        Helpers::formatHotelRequestParams();
        return request()->validate($rules);
    }
}
