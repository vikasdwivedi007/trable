<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\DailySheet;
use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\JobFile;
use App\Models\JobTitle;
use App\Models\OperatingStatement;
use App\Models\Sightseeing;
use App\Models\Transportation;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DailySheetController extends Controller
{
    private $prefix = 'daily-sheets.';
    private $middlewares = ['auth'];

    public function __construct()
    {
        $this->middleware($this->middlewares);
    }

    public function index()
    {
        $this->authorize('viewAny', DailySheet::class);
        if (request()->ajax()) {
            $sheets = DailySheet::viewIndex();
            return $sheets;
        }
        return view($this->prefix . 'index');
    }

    public function create()
    {
        $this->authorize('create', DailySheet::class);
        $cities = City::getEgyptianCities();
        $reps = Employee::whereHas('job', function ($inner) {
            $inner->where('title', JobTitle::REPRESENTATIVE_TITLE);
        })->with('user')->get();
        $transportations = Transportation::whereHas('cars')->with('cars')->get();
        return view($this->prefix . 'create', compact('cities', 'reps', 'transportations'));
    }

    public function store(Request $request)
    {
        $this->authorize('create', DailySheet::class);
        $data = $this->validateRequest();
        $data = DailySheet::prepareData($data);
        $sheet = DailySheet::create($data);
        $sheet->createOrUpdateFiles($data);
        if (request()->ajax()) {
            session()->flash('success', __('main.daily_sheets_added') );
            return response()->json(['success' => true, 'message' => __('main.daily_sheets_added') , 'redirect_to' => route($this->prefix . 'index')]);
        } else {
            return redirect(route($this->prefix . 'index'))->with('success', __('main.daily_sheets_added') );
        }
    }

    public function show(DailySheet $dailySheet)
    {
        $this->authorize('view', $dailySheet);
        $start = clone $dailySheet->date;
        $end = clone $dailySheet->date;
        $start = $start->startOfDay();
        $end = $end->endOfDay();
        $dailySheet->load(['job_files', 'city', 'job_files.representative', 'job_files.representative.user',
            'job_files.job_file', 'job_files.job_file.travel_agent',
            'job_files.job_file.guides' => function ($inner) use ($start, $end, $dailySheet) {
                $inner->where('date', '>=', $start)->where('date', '<=', $end);
                $inner->where('city_id', $dailySheet->city_id);
            }, 'job_files.job_file.guides.guide', 'job_files.job_file.guides.city', 'job_files.job_file.guides.sightseeing',
            'job_files.job_file.accommodations', 'job_files.job_file.accommodations.hotel'
        ]);
        return view($this->prefix . 'print', compact('dailySheet' ));
    }

    public function edit(DailySheet $dailySheet)
    {
        $this->authorize('update', $dailySheet);
        $start = clone $dailySheet->date;
        $end = clone $dailySheet->date;
        $start = $start->startOfDay();
        $end = $end->endOfDay();
        $dailySheet->load(['job_files', 'city', 'job_files.representative', 'job_files.representative.user',
            'job_files.job_file', 'job_files.job_file.travel_agent',
            'job_files.job_file.guides' => function ($inner) use ($start, $end, $dailySheet) {
                $inner->where('date', '>=', $start)->where('date', '<=', $end);
                $inner->where('city_id', $dailySheet->city_id);
            }, 'job_files.job_file.guides.guide', 'job_files.job_file.guides.city', 'job_files.job_file.guides.sightseeing',
            'job_files.job_file.accommodations', 'job_files.job_file.accommodations.hotel'
        ]);
        $cities = City::getEgyptianCities();
        $reps = Employee::whereHas('job', function ($inner) {
            $inner->where('title', JobTitle::REPRESENTATIVE_TITLE);
        })->with('user')->get();
        $transportations = Transportation::whereHas('cars')->with('cars')->get();
        return view($this->prefix . 'edit', compact('dailySheet', 'cities', 'reps', 'transportations'));
    }

    public function update(Request $request, DailySheet $dailySheet)
    {
        $this->authorize('update', $dailySheet);
        $data = $this->validateRequest();
        $data = DailySheet::prepareData($data);
        $dailySheet->update($data);
        $dailySheet->createOrUpdateFiles($data);
        if (request()->ajax()) {
            session()->flash('success', "Daily Sheet updated successfully");
            return response()->json(['success' => true, 'message' => __("main.daily_sheets_updated"), 'redirect_to' => route($this->prefix . 'index')]);
        } else {
            return redirect(route($this->prefix . 'index'))->with('success', __("main.daily_sheets_updated"));
        }
    }

    public function destroy(DailySheet $dailySheet)
    {
        $this->authorize('delete', $dailySheet);
        $dailySheet->delete();
        return redirect(route($this->prefix . 'index'))->with('success', __("main.daily_sheets_deleted"));
    }


    private function validateRequest()
    {
        $rules = [
            'date' => 'required|date_format:l d F Y',
            'city_id' => 'required|exists:cities,id',
            'job_files' => 'required|array',
            'job_files.*.file_no' => 'required|exists:job_files,file_no',
            'job_files.*.pnr' => 'nullable',
            'job_files.*.router_number' => 'nullable',
            'job_files.*.concierge' => 'required|in:0,1',
            'job_files.*.remarks' => 'nullable',
            'job_files.*.itinerary' => 'nullable',
            'job_files.*.transportation_id' => 'required|exists:transportations,id',
            'job_files.*.driver_name' => 'required',
            'job_files.*.driver_phone' => 'required',
            'job_files.*.representative_id' => 'required',
        ];
        return request()->validate($rules);
    }
}
