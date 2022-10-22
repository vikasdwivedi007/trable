<?php

namespace App\Http\Controllers;

use App\Helpers;
use App\Models\Car;
use App\Models\City;
use App\Models\Currency;
use App\Models\Employee;
use App\Models\Guide;
use App\Models\JobFile;
use App\Models\JobTitle;
use App\Models\PolicePermission;
use App\Http\Controllers\Controller;
use App\Models\Transportation;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class PolicePermissionController extends Controller
{
    private $prefix = 'police-permissions.';
    private $middlewares = ['auth'];

    public function __construct()
    {
        $this->middleware($this->middlewares);
    }

    public function index()
    {
        $this->authorize('viewAny', PolicePermission::class);
        if(request()->ajax()){
            $permissions = PolicePermission::permissionsIndex();
            return $permissions;
        }
        return view($this->prefix . 'index');
    }

    public function show(PolicePermission $policePermission)
    {
        $this->authorize('view', $policePermission);
        $policePermission->load(['job_file', 'job_file.country','transportation', 'guide', 'driver', 'traffic_lines', 'representative', 'representative.user']);
        $policePermission->job_file->airport_from->format();
        $policePermission->job_file->airport_to->format();
        return view($this->prefix.'show', compact('policePermission'));
    }

    public function create()
    {
        $this->authorize('create', PolicePermission::class);
        $transportations = Transportation::orderBy('name')->get();
        $guides = Guide::with('languages')->get();
        $rep_job = JobTitle::where('title', JobTitle::REPRESENTATIVE_TITLE)->first();
        $employees = Employee::where('job_id', $rep_job->id)->with('user')->get();

        return view($this->prefix . 'create', compact('transportations', 'guides', 'employees'));
    }

    public function store(Request $request)
    {
        $this->authorize('create', PolicePermission::class);
        $data = $this->validateRequest();
        $data['job_id'] = JobFile::where('file_no', $data['file_no'])->first()->id;
        $permission = PolicePermission::create($data);
        $permission->addTrafficLines($data);
        return redirect(route($this->prefix . 'index'))->with('success', __("main.police_permission_added"));
    }

    public function edit(PolicePermission $policePermission)
    {
        $this->authorize('update', $policePermission);
        $transportations = Transportation::orderBy('name')->get();
        $guides = Guide::with('languages')->get();
        $rep_job = JobTitle::where('title', JobTitle::REPRESENTATIVE_TITLE)->first();
        $employees = Employee::where('job_id', $rep_job->id)->with('user')->get();
        $policePermission->load(['job_file', 'transportation', 'guide', 'driver', 'traffic_lines', 'representative', 'representative.user']);
        $car_no_seg = explode(' ', $policePermission->car_no);
        $available_drivers = Car::where('transportation_id', $policePermission->transportation_id)->get();
        return view($this->prefix . 'edit', compact('policePermission', 'transportations', 'guides', 'employees', 'car_no_seg', 'available_drivers'));
    }

    public function update(Request $request, PolicePermission $policePermission)
    {
        $this->authorize('update', $policePermission);
        $data = $this->validateRequest();
        $data['job_id'] = JobFile::where('file_no', $data['file_no'])->first()->id;
        $policePermission->update($data);
        $policePermission->addTrafficLines($data);
        return redirect(route($this->prefix . 'index'))->with('success', __("main.police_permission_updated"));
    }

    public function destroy(PolicePermission $policePermission)
    {
        $this->authorize('delete', $policePermission);
        $policePermission->traffic_lines()->delete();
        $policePermission->delete();
        return redirect(route($this->prefix . 'index'))->with('success', __("main.police_permission_deleted"));
    }



    private function validateRequest()
    {
        $rules = [
            'file_no' => 'required|exists:job_files,file_no',
            'travel_agent_ar' => 'required',
            'client_name_ar' => 'required',
            'coming_from_ar' => 'required',
            'nationality_ar' => 'required',
            'transportation_id' => 'required|exists:transportations,id',
            'guide_id' => 'required|exists:guides,id',
            'representative_id' => 'required|exists:employees,id',
            'driver_id' => 'required|exists:cars,id',
            'car_no' => 'required',
            'traffic_lines' => 'required|array',
            'traffic_lines.*.date' => 'required|date_format:l d F Y H:i',
            'traffic_lines.*.details' => 'required'
        ];
        $car_no = '';
        if (request('car_no_seg')) {
            foreach (request('car_no_seg') as $segment) {
                $car_no .= $segment . ' ';
            }
        }
        request()->request->set('car_no', trim($car_no));
        return request()->validate($rules);
    }
}
