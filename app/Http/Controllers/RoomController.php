<?php

namespace App\Http\Controllers;

use App\Helpers;
use App\Models\Airport;
use App\Models\City;
use App\Models\CompareHotelPrices;
use App\Models\Currency;
use App\Models\Discount;
use App\Models\Hotel;
use App\Models\Room;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class RoomController extends Controller
{
    private $prefix = 'rooms.';
    private $redirect_prefix = 'suppliers.';
    private $tab_hash = '#pills-Hotels-tab';
    private $middlewares = ['auth'];

    public function __construct()
    {
        $this->middleware($this->middlewares);
    }

    public function create()
    {
        $this->authorize('create', Hotel::class);
        $hotels = Hotel::all();
        return view($this->prefix . 'create', compact('hotels'));
    }

    public function store(Request $request)
    {
        $this->authorize('create', Hotel::class);
        $data = $this->validateRequest();
        $room = Room::create($data);
        $room->details()->create($data);
        if ($data['discount_type'] && $data['discount_value']) {
            $room->discount()->create($data);
        }
        $room->createOrUpdateCancels(isset($data['cancels']) ? $data['cancels'] : []);
        return redirect(route($this->redirect_prefix . 'index') . $this->tab_hash)->with('success', __("main.room_added"));
    }

    public function edit(Room $room)
    {
        $this->authorize('create', Hotel::class);
        $hotels = Hotel::all();
        $room->load(['details', 'discount']);
        return view($this->prefix . 'edit', compact('room', 'hotels'));
    }

    public function update(Request $request, Room $room)
    {
        $this->authorize('create', Hotel::class);
        $data = $this->validateRequest();
        $room->update($data);
        $room->details->update($data);
        if ($data['discount_type'] && $data['discount_value']) {
            if (!$room->discount) {
                $room->discount()->create($data);
            } else {
                $room->discount->update($data);
            }
        }
        $room->createOrUpdateCancels(isset($data['cancels']) ? $data['cancels'] : []);
        return redirect(route($this->redirect_prefix . 'index') . $this->tab_hash)->with('success', __("main.room_updated"));
    }

    public function destroy(Room $room)
    {
        $this->authorize('create', Hotel::class);
        $room->details()->delete();
        $room->discount()->delete();
        $room->cancellations()->delete();
        $room->delete();
        return redirect(route($this->redirect_prefix . 'index') . $this->tab_hash)->with('success', __("main.room_deleted"));
    }

    public function getAvailableRooms()
    {
        $data = ['views' => [], 'categories' => []];
        if (request('hotel_id')) {
            $rooms = Room::where('hotel_id', request('hotel_id'))->get();
            foreach ($rooms as $room) {
                if (!in_array($room->view, $data['views'])) {
                    $data['views'][] = $room->view;
                }
                if (!in_array($room->name, $data['categories'])) {
                    $data['categories'][] = $room->name;
                }
            }
        }
        return response()->json($data);
    }

    public function checkIfRoomIsAvailable()
    {
        $rules = [
            'accommodations' => 'required|array',
            'accommodations.*.hotel_id' => 'required|exists:hotels,id',
            'accommodations.*.room_type' => 'required|numeric',
            'accommodations.*.meal_plan' => 'required|numeric',
            'accommodations.*.view' => 'required',
            'accommodations.*.category' => 'required',
            'accommodations.*.check_in' => 'required|date|date_format:l d F Y',
            'accommodations.*.check_out' => 'required|date|after:accommodations.*.check_in|date_format:l d F Y',
        ];
        $search_data = request()->validate($rules);
        $search_data = $search_data['accommodations'][array_key_first($search_data['accommodations'])];
        $room = Room::isAvailable($search_data);
        $response = ['other_options' => [], 'rooms' => []];
        if ($room) {
            $response['rooms'] = [$room];
            $response['other_options'] = $room->findOtherPrices($search_data);
        }
        return response()->json($response);
    }

    private function validateRequest()
    {
//        dd(request()->all());
        $rules = [

            //room
            'hotel_id' => 'required|numeric|exists:hotels,id',
            'name' => 'required',
            'type' => ['required', 'numeric', Rule::in(array_keys(Room::room_types()))],
            'meal_plan' => ['required', 'numeric', Rule::in(array_keys(Room::meal_plans()))],
            'view' => 'required',
            'info' => 'nullable',

            //room details
            'base_rate' => 'required|numeric',
            'base_rate_currency' => ['required', Rule::in(array_keys(Currency::availableCurrencies()))],
            'price_valid_from' => 'required|date|date_format:l d F Y',
            'price_valid_to' => 'required|date|date_format:l d F Y|after_or_equal:price_valid_from',
            'extra_bed_exc' => 'nullable|numeric',
            'child_free_until' => 'numeric',
            'child_with_two_parents_exc' => 'nullable|numeric',
            'max_children_with_two_parents' => 'nullable|numeric',
            'single_parent_exc' => 'nullable|numeric',
            'single_parent_child_exc' => 'nullable|numeric',
            'min_child_age' => 'numeric',
            'max_child_age' => 'numeric',
            'special_offer' => 'nullable',

            //discount
            'discount_type' => ['nullable', Rule::in([Discount::TYPE_AMOUNT, Discount::TYPE_PERCENTAGE])],
            'discount_value' => 'nullable|required_with:discount_type|numeric',

            //cancels
            'cancels' => 'array',
            'cancels.*.type' => 'required|numeric',
            'cancels.*.value' => 'required|numeric|min:0',
            'cancels.*.time' => 'required|numeric|min:0',
        ];
        Helpers::removeCurrencyFromNumericFields($rules);
        Helpers::formatRoomRequestParams();
        return request()->validate($rules);
    }
}
