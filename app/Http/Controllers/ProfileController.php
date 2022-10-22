<?php

namespace App\Http\Controllers;

use App\Helpers;
use App\Models\Department;
use App\Models\JobTitle;
use App\Rules\Active;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class ProfileController extends Controller
{

    private $prefix = 'profile.';
    private $user;

    public function __construct()
    {
        $this->middleware('auth');
    }


    public function index()
    {
        $user = auth()->user()->load(['employee', 'employee.job']);
        return view($this->prefix.'index', ['user'=>$user]);
    }


    public function update()
    {
        $data = $this->validateRequest();
        auth()->user()->update($data);
        auth()->user()->employee->save();
        if(auth()->user()->employee->guide){
            auth()->user()->employee->guide->update(Arr::only($data, ['name', 'phone']));
            auth()->user()->employee->guide->saveUnavailable_at($data);
        }
        return redirect(route($this->prefix.'index'))->with('success', __("main.profile_updated"));
    }


    private function validateRequest(){
        $rules = [
            'name' => 'required|string|min:4',
            'email' => 'required|email|unique:users,email,'.auth()->user()->id,
            'phone' => 'required|numeric',
            'password' => [
                'nullable',
                'confirmed',
                'min:8',             // must be at least 10 characters in length
                'regex:/[a-z]/',      // must contain at least one lowercase letter
                'regex:/[A-Z]/',      // must contain at least one uppercase letter
                'regex:/[0-9]/',      // must contain at least one digit
                'regex:/[$&+,:;=?@#|"\'<>.^*()%!_-]/', // must contain a special character
            ],
            'profile_pic' => 'image',
            'unavailable_dates' => 'nullable|array',
            'unavailable_dates.*' => 'nullable|date|date_format:l d F Y'
        ];
        $messages = [
            'regex' => 'Password should be alphanumeric with at least 1 special character, 1 uppercase letter and 1 lowercase letter'
        ];
        Helpers::removeCurrencyFromNumericFields($rules);
        return request()->validate($rules, $messages);
    }

}
