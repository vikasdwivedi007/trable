<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Permission extends Model
{

    /*
     * $param $permission (name of the model)
     * $param $type (read or write)
     * @return bool
     */
    public static function hasPermission($permission, $type)
    {
        return auth()->user()->isAdmin() || auth()->user()->hasPermission($permission, $type);
    }

    public static function getAllPermissions()
    {
        return [
            JobFile::PERMISSION_NAME,
            Employee::PERMISSION_NAME,
            Department::PERMISSION_NAME,
            TravelAgent::PERMISSION_NAME,
            Reminder::PERMISSION_NAME,
            Sightseeing::PERMISSION_NAME,
            Router::PERMISSION_NAME,
            SLShow::PERMISSION_NAME,
            VBNight::PERMISSION_NAME,
            LKFriend::PERMISSION_NAME,
            Shop::PERMISSION_NAME,
            Hotel::PERMISSION_NAME,
            Restaurant::PERMISSION_NAME,
            Transportation::PERMISSION_NAME,
            TrainTicket::PERMISSION_NAME,
            Guide::PERMISSION_NAME,
            NileCruise::PERMISSION_NAME,
            Flight::PERMISSION_NAME,
            File::PERMISSION_NAME,
            TrafficVoucher::PERMISSION_NAME,
            PolicePermission::PERMISSION_NAME,
            Gift::PERMISSION_NAME,
            TravelVisa::PERMISSION_NAME,
            DraftInvoice::PERMISSION_NAME,
            Invoice::PERMISSION_NAME,
            JobFileReview::PERMISSION_NAME,
            PaymentMonthlyRequest::PERMISSION_NAME,
            TrafficMonthlyCommission::PERMISSION_NAME,
            OperatingStatement::PERMISSION_NAME,
            DailySheet::PERMISSION_NAME,
            OperatorAssignment::PERMISSION_NAME,
            Report::PERMISSION_NAME,
            WorkOrder::PERMISSION_NAME,
            CashForm::PERMISSION_NAME,
            Commission::PERMISSION_NAME,
            ActivityLog::PERMISSION_NAME,

        ];
    }

    public static function getServicesPermissions()
    {
        return [
            Sightseeing::PERMISSION_NAME,
            Router::PERMISSION_NAME,
            SLShow::PERMISSION_NAME,
            VBNight::PERMISSION_NAME,
            LKFriend::PERMISSION_NAME,
            Shop::PERMISSION_NAME,
            Gift::PERMISSION_NAME,
            TravelVisa::PERMISSION_NAME,
        ];
    }

    public static function getSuppliersPermissions()
    {
        return [
            Hotel::PERMISSION_NAME,
            Restaurant::PERMISSION_NAME,
            Transportation::PERMISSION_NAME,
            TrainTicket::PERMISSION_NAME,
            Guide::PERMISSION_NAME,
            NileCruise::PERMISSION_NAME,
            Flight::PERMISSION_NAME,
        ];
    }

    public static function getPermissionsRoutes()
    {
        return [
            JobFile::PERMISSION_NAME => route('job-files.index'),
            Employee::PERMISSION_NAME => route('employees.index'),
            Department::PERMISSION_NAME => route('departments.index'),
            TravelAgent::PERMISSION_NAME => route('travel-agents.index'),
            Reminder::PERMISSION_NAME => route('reminders.index'),
            Sightseeing::PERMISSION_NAME => route('services.index'),
            Router::PERMISSION_NAME => route('services.index'),
            SLShow::PERMISSION_NAME => route('services.index'),
            VBNight::PERMISSION_NAME => route('services.index'),
            LKFriend::PERMISSION_NAME => route('services.index'),
            Shop::PERMISSION_NAME => route('services.index'),
            Gift::PERMISSION_NAME => route('services.index'),
            TravelVisa::PERMISSION_NAME => route('services.index'),
            Hotel::PERMISSION_NAME => route('suppliers.index'),
            Restaurant::PERMISSION_NAME => route('suppliers.index'),
            Transportation::PERMISSION_NAME => route('suppliers.index'),
            TrainTicket::PERMISSION_NAME => route('suppliers.index'),
            Guide::PERMISSION_NAME => route('suppliers.index'),
            NileCruise::PERMISSION_NAME => route('suppliers.index'),
            Flight::PERMISSION_NAME => route('suppliers.index'),
            File::PERMISSION_NAME => route('media.index'),
            TrafficVoucher::PERMISSION_NAME => route('vouchers.index'),
            PolicePermission::PERMISSION_NAME => route('police-permissions.index'),
            DraftInvoice::PERMISSION_NAME => route('draft-invoices.index'),
            Invoice::PERMISSION_NAME => route('invoices.index'),
            PaymentMonthlyRequest::PERMISSION_NAME => route('payment-monthly-requests.index'),
            TrafficMonthlyCommission::PERMISSION_NAME => route('traffic-monthly-commissions.index'),
            OperatingStatement::PERMISSION_NAME => route('operating-statements.index'),
            DailySheet::PERMISSION_NAME => route('daily-sheets.index'),
            OperatorAssignment::PERMISSION_NAME => route('operator-assignments.index'),
            Report::PERMISSION_NAME => route('reports.index'),
            WorkOrder::PERMISSION_NAME => route('work-orders.index'),
            CashForm::PERMISSION_NAME => route('cash-forms.index'),
            Commission::PERMISSION_NAME => route('commissions.index'),
            ActivityLog::PERMISSION_NAME => route('activity-logs.index'),
        ];
    }

    public static function getGuidePermissions()
    {
        return [
            Reminder::PERMISSION_NAME => ['read' => 'on', 'write' => 'on'],
        ];
    }
}
