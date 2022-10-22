<?php

namespace App\Http\Controllers;

use App\Mail\ReminderMail;
use App\Models\City;
use App\Models\Employee;
use App\Models\GuideVoucher;
use App\Models\HotelVoucher;
use App\Models\JobFile;
use App\Models\Permission;
use App\Models\Reminder;
use App\Models\RestaurantVoucher;
use App\Models\TrafficVoucher;
use App\Models\VoucherSerialized;
use App\Notifications\GenericNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Mail;

class HomeController extends Controller
{
    private $user;

    public function __construct()
    {
        $this->middleware('auth');
        $this->user = auth()->user();
    }

    public function index()
    {
        foreach (Permission::getPermissionsRoutes() as $permission => $route) {
            if (auth()->user()->hasPermission($permission, 'read')) {
                return redirect($route);
            }
        }
        return redirect(route('profile.index'));
    }

    public function services()
    {
        $available_tabs = [];
        $write_permissions = [];
        $active_tab = '';
        foreach (Permission::getServicesPermissions() as $permission) {
            if (auth()->user()->hasPermission($permission, 'read')) {
                $available_tabs[] = $permission;
                if (auth()->user()->hasPermission($permission, 'write')) {
                    $write_permissions[] = $permission;
                }
                if (!$active_tab) {
                    $active_tab = $permission;
                }
            }
        }
        return view('services.index', compact('available_tabs', 'write_permissions', 'active_tab'));
    }

    public function suppliers()
    {
        $available_tabs = [];
        $write_permissions = [];
        $active_tab = '';
        foreach (Permission::getSuppliersPermissions() as $permission) {
            if (auth()->user()->hasPermission($permission, 'read')) {
                $available_tabs[] = $permission;
                if (auth()->user()->hasPermission($permission, 'write')) {
                    $write_permissions[] = $permission;
                }
                if (!$active_tab) {
                    $active_tab = $permission;
                }
            }
        }
        return view('suppliers.index', compact('available_tabs', 'write_permissions', 'active_tab'));
    }

    public function vouchers()
    {
        $this->authorize('viewAny', TrafficVoucher::class);
        $write_perm = auth()->user()->hasPermission(TrafficVoucher::PERMISSION_NAME, 'write');
        return view('vouchers.index', compact('write_perm'));
    }

    public function showVoucherBySerialNo($serial_no)
    {
        $this->authorize('viewAny', TrafficVoucher::class);
        $voucher = VoucherSerialized::findOrFail($serial_no)->load('vserialable');
        return redirect($voucher->vserialable->show_path());
    }

    public function test()
    {
        exit;
        $emp = Employee::find(19);
        $emp->user->notify(new GenericNotification('test', 'description'));

        exit;
        $job_file = JobFile::find(22);
        $existing_data = $job_file->programs()->get()->map(function ($inner) {
            $items = $inner->items()->get()->map(function ($inner2) {
                return join('|', Arr::except($inner2->toArray(), ['id', 'updated_at', 'created_at']));
            })->toArray();
            return join('|', Arr::except($inner->toArray(), ['id', 'updated_at', 'created_at'])) . '|' . join('|', $items);
        })->toArray();
        dd($existing_data);
        dd(join(',', $existing_data));
        $new_data = $job_file->accommodations()->get()->map(function ($inner) {
            return join('|', Arr::except($inner->toArray(), ['id', 'updated_at', 'created_at']));
        })->toArray();
//        $existing_data = Arr::except($job_file->accommodations()->get()->toArray(), ['id', 'updated_at', 'created_at']);
//        dd([$existing_data, $new_data]);
        dd(array_intersect($existing_data, $new_data));
    }
}
