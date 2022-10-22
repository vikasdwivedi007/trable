<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Country;
use App\Models\Guide;
use App\Models\GuideVoucher;
use App\Http\Controllers\Controller;
use App\Models\JobFile;
use Illuminate\Http\Request;

class GuideVoucherController extends Controller
{
    private $prefix = 'guide-vouchers.';
    private $redirect_prefix = 'vouchers.';
    private $tab_hash = '#pills-Guide-tab';
    private $middlewares = ['auth'];

    public function __construct()
    {
        $this->middleware($this->middlewares);
    }

    public function index()
    {
        $this->authorize('viewAny', GuideVoucher::class);
        $vouchers = GuideVoucher::vouchersIndex();
        return $vouchers;
    }

    public function create()
    {
        $this->authorize('create', GuideVoucher::class);
        $guides = Guide::with('languages')->get();
        $guides->map->formatObject();
        $cities = City::where('country_id', Country::EGYPT_ID)->get();
        return view($this->prefix . 'create', compact('guides', 'cities'));
    }

    public function store(Request $request)
    {
        $this->authorize('create', GuideVoucher::class);
        $data = $this->validateRequest();
        $data['job_id'] = JobFile::where('file_no', $data['file_no'])->first()->id;
        $voucher = GuideVoucher::create($data);
        $voucher->addTours($data);
        return redirect(route($this->redirect_prefix . 'index') . $this->tab_hash)->with('success', __('main.voucher_added'));
    }

    public function show(GuideVoucher $guideVoucher)
    {
        $this->authorize('view', $guideVoucher);
        $guideVoucher->load(['job_file', 'job_file.language', 'hotel', 'guide']);
        $guideVoucher->guide->formatObject();
        $guideVoucher->formatSerialNo();
        return view($this->prefix . 'show', ['voucher' => $guideVoucher]);
    }

    public function edit(GuideVoucher $guideVoucher)
    {
        $this->authorize('update', $guideVoucher);
        $guideVoucher->load(['job_file', 'tours']);
        $guides = Guide::with('languages')->get();
        $guides->map->formatObject();
        $guideVoucher->guide->formatObject();
        $cities = City::where('country_id', Country::EGYPT_ID)->get();
        return view($this->prefix . 'edit', ['voucher' => $guideVoucher, 'guides' => $guides, 'cities' => $cities]);
    }

    public function update(Request $request, GuideVoucher $guideVoucher)
    {
        $this->authorize('update', $guideVoucher);
        $data = $this->validateRequest();
        $data['job_id'] = JobFile::where('file_no', $data['file_no'])->first()->id;
        $guideVoucher->update($data);
        $guideVoucher->addTours($data);
        return redirect(route($this->redirect_prefix . 'index') . $this->tab_hash)->with('success', __('main.voucher_updated'));
    }

    public function destroy(GuideVoucher $guideVoucher)
    {
        $this->authorize('delete', $guideVoucher);
        $guideVoucher->delete();
        return redirect(route($this->redirect_prefix . 'index') . $this->tab_hash)->with('success', __('main.voucher_deleted'));
    }


    private function validateRequest()
    {
        $rules = [
            'file_no' => 'required|exists:job_files,file_no',
            'issued_by' => 'required',
            'guide_id' => 'required|exists:guides,id',
            'guide_address' => 'nullable',
            'hotel_id' => 'required|exists:hotels,id',
            'room_no' => 'nullable',
            'transport_by' => 'nullable',
            'pax_no' => 'required|numeric|min:0',
            'tour_operator' => 'required',
            'issue_date' => 'required|date_format:l d F Y',
            'tours' => 'required|array',
            'tours.*.date' => 'required|date_format:l d F Y H:i',
            'tours.*.desc' => 'required'
        ];
        return request()->validate($rules);
    }

}
