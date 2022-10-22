<?php

namespace App\Http\Controllers;

use App\Helpers;
use App\Models\Employee;
use App\Models\Reminder;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Validation\Rule;

class ReminderController extends Controller
{

    private $prefix = 'reminders.';
    private $middlewares = ['auth'];
    private $user;

    public function __construct()
    {
        $this->middleware($this->middlewares);
        $this->user = auth()->user();
    }

    public function index()
    {
        $this->authorize('viewAny', Reminder::class);
        if(request()->ajax()){
            $reminders = Reminder::reminderIndex();
            return $reminders;
        }
        return view($this->prefix.'index');
    }

    public function create()
    {
        $this->authorize('create', Reminder::class);
        $employees = Employee::where('active', 1)->with('user')->get();
        return view($this->prefix.'create', compact('employees'));
    }

    public function store(Request $request)
    {
        $this->authorize('create', Reminder::class);
        $data = $this->validateRequest();
        $data = Reminder::prepareData($data);
        $reminder = Reminder::create($data);
        $reminder->setJob();
        return redirect(route($this->prefix . 'index'))->with('success', __("main.reminder_added"));
    }

    public function edit(Reminder $reminder)
    {
        $this->authorize('update', $reminder);
        $employees = Employee::where('active', 1)->with('user')->get();
        return view($this->prefix . 'edit', compact('reminder', 'employees'));
    }

    public function update(Request $request, Reminder $reminder)
    {
        $this->authorize('update', $reminder);
        $data = $this->validateRequest();
        $reminder->update($data);
        $reminder->setJob();
        return redirect(route($this->prefix . 'index'))->with('success', __("main.reminder_updated"));
    }

    public function destroy(Reminder $reminder)
    {
        $this->authorize('delete', $reminder);
        $reminder->delete();
        return redirect(route($this->prefix.'index'))->with('success', __("main.reminder_deleted"));
    }



    private function validateRequest(){
        $rules = [
            'title' => 'required',
            'desc' => 'required',
            'assigned_to_id' => 'required|exists:employees,id',
            'status' => ['required', Rule::in([0,1,2])],
            'send_at' => 'required|date|date_format:l d F Y H:i|after:now',
            'send_by' => 'required|array',
            'send_by.*' => ['required', Rule::in(['db', 'mail', 'whatsapp'])]
        ];
        Helpers::formatReminderRequestParams();
        return request()->validate($rules);
    }
}
