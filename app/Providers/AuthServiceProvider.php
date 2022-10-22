<?php

namespace App\Providers;

use App\Models\ActivityLog;
use App\Models\CashForm;
use App\Models\Commission;
use App\Models\DailySheet;
use App\Models\Department;
use App\Models\DraftInvoice;
use App\Models\Employee;
use App\Models\File;
use App\Models\Flight;
use App\Models\Gift;
use App\Models\Guide;
use App\Models\GuideVoucher;
use App\Models\Hotel;
use App\Models\HotelVoucher;
use App\Models\Invoice;
use App\Models\JobFile;
use App\Models\JobFileReview;
use App\Models\LKFriend;
use App\Models\NileCruise;
use App\Models\OperatingStatement;
use App\Models\PaymentMonthlyRequest;
use App\Models\PolicePermission;
use App\Models\Reminder;
use App\Models\Report;
use App\Models\Restaurant;
use App\Models\RestaurantVoucher;
use App\Models\Router;
use App\Models\Shop;
use App\Models\Sightseeing;
use App\Models\SLShow;
use App\Models\TrafficMonthlyCommission;
use App\Models\TrafficVoucher;
use App\Models\TrainTicket;
use App\Models\Transportation;
use App\Models\TravelAgent;
use App\Models\TravelVisa;
use App\Models\VBNight;
use App\Models\OperatorAssignment;
use App\Models\WorkOrder;
use App\Policies\ActivityLogPolicy;
use App\Policies\CashFormPolicy;
use App\Policies\CommissionPolicy;
use App\Policies\DailySheetPolicy;
use App\Policies\DraftInvoicePolicy;
use App\Policies\FlightPolicy;
use App\Policies\GiftPolicy;
use App\Policies\GuidePolicy;
use App\Policies\GuideVoucherPolicy;
use App\Policies\HotelPolicy;
use App\Policies\HotelVoucherPolicy;
use App\Policies\InvoicePolicy;
use App\Policies\JobFilePolicy;
use App\Policies\JobFileReviewPolicy;
use App\Policies\LKFriendPolicy;
use App\Policies\MediaLibPolicy;
use App\Policies\NileCruisePolicy;
use App\Policies\OperatingStatementPolicy;
use App\Policies\OperatorAssignmentPolicy;
use App\Policies\PaymentMonthlyRequestPolicy;
use App\Policies\PolicePermissionPolicy;
use App\Policies\ReportPolicy;
use App\Policies\RestaurantPolicy;
use App\Policies\RestaurantVoucherPolicy;
use App\Policies\RouterPolicy;
use App\Policies\ShopPolicy;
use App\Policies\SightseeingPolicy;
use App\Policies\SLShowPolicy;
use App\Policies\TrafficMonthlyCommissionPolicy;
use App\Policies\TrafficVoucherPolicy;
use App\Policies\TrainTicketPolicy;
use App\Policies\TransportationPolicy;
use App\Policies\TravelAgentPolicy;
use App\Policies\DepartmentPolicy;
use App\Policies\EmployeePolicy;
use App\Policies\ReminderPolicy;
use App\Policies\TravelVisaPolicy;
use App\Policies\VBNightPolicy;
use App\Policies\WorkOrderPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
//         'App\Model' => 'App\Policies\ModelPolicy',
        Employee::class => EmployeePolicy::class,
        Department::class => DepartmentPolicy::class,
        TravelAgent::class => TravelAgentPolicy::class,
        Reminder::class => ReminderPolicy::class,
        Hotel::class => HotelPolicy::class,
        Restaurant::class => RestaurantPolicy::class,
        Transportation::class => TransportationPolicy::class,
        Flight::class => FlightPolicy::class,
        Sightseeing::class => SightseeingPolicy::class,
        SLShow::class => SLShowPolicy::class,
        Router::class => RouterPolicy::class,
        VBNight::class => VBNightPolicy::class,
        LKFriend::class => LKFriendPolicy::class,
        Shop::class => ShopPolicy::class,
        TrainTicket::class => TrainTicketPolicy::class,
        NileCruise::class => NileCruisePolicy::class,
        Guide::class => GuidePolicy::class,
        JobFile::class => JobFilePolicy::class,
        File::class => MediaLibPolicy::class,
        TrafficVoucher::class => TrafficVoucherPolicy::class,
        RestaurantVoucher::class => RestaurantVoucherPolicy::class,
        GuideVoucher::class => GuideVoucherPolicy::class,
        HotelVoucher::class => HotelVoucherPolicy::class,
        PolicePermission::class => PolicePermissionPolicy::class,
        Gift::class => GiftPolicy::class,
        TravelVisa::class => TravelVisaPolicy::class,
        DraftInvoice::class => DraftInvoicePolicy::class,
        Invoice::class => InvoicePolicy::class,
        JobFileReview::class => JobFileReviewPolicy::class,
        PaymentMonthlyRequest::class => PaymentMonthlyRequestPolicy::class,
        TrafficMonthlyCommission::class => TrafficMonthlyCommissionPolicy::class,
        OperatingStatement::class => OperatingStatementPolicy::class,
        DailySheet::class => DailySheetPolicy::class,
        OperatorAssignment::class => OperatorAssignmentPolicy::class,
        Report::class => ReportPolicy::class,
        WorkOrder::class => WorkOrderPolicy::class,
        CashForm::class => CashFormPolicy::class,
        Commission::class => CommissionPolicy::class,
        ActivityLog::class => ActivityLogPolicy::class,

    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //
    }
}
