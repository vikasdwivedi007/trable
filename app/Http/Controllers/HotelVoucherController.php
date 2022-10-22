<?php

namespace App\Http\Controllers;

use App\Models\Hotel;
use App\Models\HotelVoucher;
use App\Http\Controllers\Controller;
use App\Models\JobFile;
use App\Models\NileCruise;
use Illuminate\Http\Request;

class HotelVoucherController extends Controller
{
    private $prefix = 'hotel-vouchers.';
    private $redirect_prefix = 'vouchers.';
    private $tab_hash = '#pills-Hotel-tab';
    private $middlewares = ['auth'];

    public function __construct()
    {
        $this->middleware($this->middlewares);
    }

    public function index()
    {
        $this->authorize('viewAny', HotelVoucher::class);
        $vouchers = HotelVoucher::vouchersIndex();
        return $vouchers;
    }

    public function create()
    {
        $this->authorize('create', HotelVoucher::class);
        $hotels = Hotel::orderBy('name', 'asc')->get();
        $cruises = [];
        $all_cruises = NileCruise::orderBy('name', 'asc')->get();
        foreach($all_cruises as $cruise){
            if(!array_key_exists($cruise->name, $cruises)){
                $cruises[$cruise->name] = $cruise;
            }
        }
        return view($this->prefix . 'create', compact('hotels', 'cruises'));
    }

    public function store(Request $request)
    {
        $this->authorize('create', HotelVoucher::class);
        $data = $this->validateRequest();
        $data['job_id'] = JobFile::where('file_no', $data['file_no'])->first()->id;
        $voucher = HotelVoucher::create($data);
        $voucher->addMeals($data);
        return redirect(route($this->redirect_prefix . 'index') . $this->tab_hash)->with('success', __('main.voucher_added'));
    }

    public function show(HotelVoucher $hotelVoucher)
    {
        $this->authorize('view', $hotelVoucher);
        $hotelVoucher->load(['job_file', 'job_file.language', 'hotel', 'cruise']);
        $hotelVoucher->formatSerialNo();

        preg_match_all('!\d+!', $hotelVoucher->single_rooms_count, $sgl);
        preg_match_all('!\d+!', $hotelVoucher->double_rooms_count, $double);
        preg_match_all('!\d+!', $hotelVoucher->triple_rooms_count, $triple);
        preg_match_all('!\d+!', $hotelVoucher->suite_rooms_count, $suite);

        $total_rooms = 0;
        if ($sgl[0]) {
            $total_rooms += $sgl[0][0];
        }
        if ($double[0]) {
            $total_rooms += $double[0][0];
        }
        if ($triple[0]) {
            $total_rooms += $triple[0][0];
        }
        if ($suite[0]) {
            $total_rooms += $suite[0][0];
        }

        return view($this->prefix . 'show', ['voucher' => $hotelVoucher, 'total_rooms' => $total_rooms]);
    }

    public function edit(HotelVoucher $hotelVoucher)
    {
        $this->authorize('update', $hotelVoucher);
        $hotelVoucher->load(['job_file', 'meals']);
        $hotels = Hotel::orderBy('name', 'asc')->get();
        $cruises = [];
        $all_cruises = NileCruise::orderBy('name', 'asc')->get();
        foreach($all_cruises as $cruise){
            if(!array_key_exists($cruise->name, $cruises)){
                $cruises[$cruise->name] = $cruise;
            }
        }
        return view($this->prefix . 'edit', ['voucher' => $hotelVoucher, 'hotels' => $hotels, 'cruises' => $cruises]);
    }

    public function update(Request $request, HotelVoucher $hotelVoucher)
    {
        $this->authorize('update', $hotelVoucher);
        $data = $this->validateRequest();
        $data['job_id'] = JobFile::where('file_no', $data['file_no'])->first()->id;
        if (isset($data['hotel_id'])) {
            $data['cruise_id'] = null;
        } else {
            $data['hotel_id'] = null;
        }
        $hotelVoucher->update($data);
        $hotelVoucher->addMeals($data);
        return redirect(route($this->redirect_prefix . 'index') . $this->tab_hash)->with('success', __('main.voucher_updated'));
    }

    public function destroy(HotelVoucher $hotelVoucher)
    {
        $this->authorize('delete', $hotelVoucher);
        $hotelVoucher->delete();
        return redirect(route($this->redirect_prefix . 'index') . $this->tab_hash)->with('success', __('main.voucher_deleted'));
    }


    private function validateRequest()
    {
        $rules = [
            'file_no' => 'required|exists:job_files,file_no',
            'issued_by' => 'required',
            'hotel_id' => 'required_without:cruise_id|exists:hotels,id',
            'cruise_id' => 'required_without:hotel_id|exists:nile_cruises,id',
            'arrival_date' => 'required|date_format:l d F Y',
            'departure_date' => 'required|date_format:l d F Y|after:arrival_date',
            'single_rooms_count' => 'nullable',
            'double_rooms_count' => 'nullable',
            'triple_rooms_count' => 'nullable',
            'suite_rooms_count' => 'nullable',
            'remarks' => 'nullable',
            'meals' => 'required|array',
            'meals.*.date' => 'required|date_format:l d F Y',
            'meals.*.american_breakfast' => 'nullable|in:0,1',
            'meals.*.continental_breakfast' => 'nullable|in:0,1',
            'meals.*.lunch' => 'nullable|in:0,1',
            'meals.*.dinner' => 'nullable|in:0,1',
        ];
        return request()->validate($rules);
    }

}
