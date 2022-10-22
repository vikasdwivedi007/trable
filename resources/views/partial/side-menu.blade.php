<ul class="nav pcoded-inner-navbar">

    @if(auth()->user()->hasPermission(\App\Models\JobFile::PERMISSION_NAME))
    <li data-username="Job File" class="nav-item @if(request()->is('job-files*')) active @endif">
        <a href="{{ route('job-files.index') }}" class="nav-link">
            <span class="pcoded-micon">
                <span class="ico-jobsFile"></span>
            </span>
            <span class="pcoded-mtext">{{__("main.job_files")}}</span>
        </a>
    </li>
    @endif
    @if(auth()->user()->hasPermission(\App\Models\Employee::PERMISSION_NAME))
    <li data-username="Employees" class="nav-item @if(request()->is('employees*')) active @endif">
        <a href="{{ route('employees.index') }}" class="nav-link">
            <span class="pcoded-micon">
                <span class="ico-employees"></span>
            </span>
            <span class="pcoded-mtext">{{__("main.employees")}}</span>
        </a>
    </li>
    @endif

    @if(auth()->user()->hasPermission(\App\Models\Department::PERMISSION_NAME))
    <li data-username="Departments" class="nav-item @if(request()->is('departments*')) active @endif">
        <a href="{{ route('departments.index') }}" class="nav-link">
            <span class="pcoded-micon">
                <span class="ico-departments"></span>
            </span>
            <span class="pcoded-mtext">{{__("main.departments")}}</span>
        </a>
    </li>
    @endif
    @if(auth()->user()->hasAnyPermission(\App\Models\Permission::getSuppliersPermissions()))
    <li data-username="Suppliers" class="nav-item
            @if(
                request()->is('suppliers*') ||
                request()->is('hotels*') ||
                request()->is('rooms*') ||
                request()->is('restaurants*') ||
                request()->is('transportations*') ||
                request()->is('flights*') ||
                request()->is('train-tickets*') ||
                request()->is('nile-cruises*')
            ) active @endif">
        <a href="{{route('suppliers.index')}}" class="nav-link">
                            <span class="pcoded-micon">
                                <span class="ico-suppliers"></span>
                            </span>
            <span class="pcoded-mtext">{{__("main.suppliers")}}</span>
        </a>
    </li>
    @endif
    @if(auth()->user()->hasAnyPermission(\App\Models\Permission::getServicesPermissions()))
    <li data-username="Services and Facilities" class="nav-item
            @if(
                request()->is('services*') ||
                request()->is('sightseeings*') ||
                request()->is('routers*') ||
                request()->is('slshows*') ||
                request()->is('vbnights*') ||
                request()->is('lkfriends*') ||
                request()->is('shops*')
            ) active @endif">
        <a href="{{ route('services.index') }}" class="nav-link">
                            <span class="pcoded-micon">
                                <span class="ico-services"></span>
                            </span>
            <span class="pcoded-mtext">{{__("main.services_facilities")}}</span>
        </a>
    </li>
    @endif
    @if(auth()->user()->hasPermission(\App\Models\TrafficVoucher::PERMISSION_NAME))
    <li data-username="Vouchers" class="nav-item
            @if(
                request()->is('vouchers*') ||
                request()->is('traffic-vouchers*') ||
                request()->is('restaurant-vouchers*') ||
                request()->is('guide-vouchers*') ||
                request()->is('hotel-vouchers*')
            ) active @endif">
        <a href="{{ route('vouchers.index') }}" class="nav-link">
            <span class="pcoded-micon">
                <span class="ico-vouchers"></span>
            </span>
            <span class="pcoded-mtext">{{__("main.vouchers")}}</span>
        </a>
    </li>
    @endif
    @if(auth()->user()->hasPermission(\App\Models\DraftInvoice::PERMISSION_NAME)
    ||
    auth()->user()->hasPermission(\App\Models\Invoice::PERMISSION_NAME))
    <li data-username="Invoices" class="nav-item pcoded-hasmenu @if(request()->is('draft-invoices*') || request()->is('invoices*')) active pcoded-trigger @endif">
        <a href="#!" class="nav-link">
            <span class="pcoded-micon">
                <span class="ico-invoices"></span>
            </span>
            <span class="pcoded-mtext">{{__("main.invoices")}}</span>
        </a>
        <ul class="pcoded-submenu">
            @if(auth()->user()->hasPermission(\App\Models\DraftInvoice::PERMISSION_NAME))
            <li @if(request()->is('draft-invoices*')) class="active" @endif>
                <a href="{{route('draft-invoices.index')}}">{{__("main.draft_invoice_details")}}</a>
            </li>
            @endif
            @if(auth()->user()->hasPermission(\App\Models\Invoice::PERMISSION_NAME))
            <li @if(request()->is('invoices*') && !request()->is('invoices/list*')) class="active" @endif>
                <a href="{{route('invoices.index')}}">{{__("main.invoice_details")}}</a>
            </li>
            <li @if(request()->is('invoices/list*')) class="active" @endif>
                <a href="{{route('invoices.list')}}">{{__("main.list_of_invoices")}}</a>
            </li>
            @endif

        </ul>
    </li>
    @endif

    @if(
auth()->user()->hasPermission(\App\Models\PaymentMonthlyRequest::PERMISSION_NAME)
||
auth()->user()->hasPermission(\App\Models\TrafficMonthlyCommission::PERMISSION_NAME)
||
auth()->user()->hasPermission(\App\Models\OperatingStatement::PERMISSION_NAME)
||
auth()->user()->hasPermission(\App\Models\DailySheet::PERMISSION_NAME)
||
auth()->user()->hasPermission(\App\Models\OperatorAssignment::PERMISSION_NAME)
||
auth()->user()->hasPermission(\App\Models\WorkOrder::PERMISSION_NAME)


)
        <li data-username="Traffic Department" class="nav-item pcoded-hasmenu @if(
request()->is('payment-monthly-requests*')
||
request()->is('traffic-monthly-commissions*')
||
request()->is('operating-statements*')
||
request()->is('daily-sheets*')
||
request()->is('operator-assignments*')
||
request()->is('work-orders*')

) active pcoded-trigger @endif">
            <a href="#!" class="nav-link">
        <span class="pcoded-micon">
            <i class="fas fa-train"></i>

        </span>
                <span class="pcoded-mtext">{{__('main.traffic_department')}}</span>
            </a>
            <ul class="pcoded-submenu">
                @if(auth()->user()->hasPermission(\App\Models\DailySheet::PERMISSION_NAME))
                    <li @if(request()->is('daily-sheets*')) class="active" @endif>
                        <a href="{{route('daily-sheets.index')}}">{{__("main.daily_sheet")}}</a>
                    </li>
                @endif

                @if(auth()->user()->hasPermission(\App\Models\OperatorAssignment::PERMISSION_NAME))
                    <li @if(request()->is('operator-assignments*')) class="active" @endif>
                        <a href="{{route('operator-assignments.index')}}">{{__("main.operator_approval")}}</a>
                    </li>
                @endif
                @if(auth()->user()->hasPermission(\App\Models\CashForm::PERMISSION_NAME))
                    <li @if(request()->is('cash-forms*')) class="active" @endif>
                        <a href="{{route('cash-forms.index')}}">{{__("main.cash_form_additional_service")}}</a>
                    </li>
                @endif
                @if(auth()->user()->hasPermission(\App\Models\TrafficMonthlyCommission::PERMISSION_NAME))
                    <li @if(request()->is('traffic-monthly-commissions*')) class="active" @endif>
                        <a href="{{route('traffic-monthly-commissions.index')}}">{{__("main.monthly_commissions")}}</a>
                    </li>
                @endif
                @if(auth()->user()->hasPermission(\App\Models\PaymentMonthlyRequest::PERMISSION_NAME))
                    <li @if(request()->is('payment-monthly-requests*')) class="active" @endif>
                        <a href="{{route('payment-monthly-requests.index')}}">{{__("main.payment_monthly_requests")}}</a>
                    </li>
                @endif
                @if(auth()->user()->hasPermission(\App\Models\WorkOrder::PERMISSION_NAME))
                    <li @if(request()->is('work-orders*')) class="active" @endif>
                        <a href="{{route('work-orders.index')}}">{{__("main.work_orders")}}</a>
                    </li>
                @endif
                @if(auth()->user()->hasPermission(\App\Models\OperatingStatement::PERMISSION_NAME))
                    <li @if(request()->is('operating-statements*')) class="active" @endif>
                        <a href="{{route('operating-statements.index')}}">{{__("main.operating_statement")}}</a>
                    </li>
                @endif
            </ul>
        </li>
    @endif
    @if(auth()->user()->hasPermission(\App\Models\TravelAgent::PERMISSION_NAME))
    <li data-username="Travel Agent" class="nav-item @if(request()->is('travel-agents*')) active @endif">
        <a href="{{ route('travel-agents.index') }}" class="nav-link">
                             <span class="pcoded-micon">
                                <span class="ico-travelAgent"></span>
                            </span>
            <span class="pcoded-mtext">{{__("main.travel_agents")}}</span>
        </a>
    </li>
    @endif
    @if(auth()->user()->hasPermission(\App\Models\PolicePermission::PERMISSION_NAME))
        <li data-username="Media Library" class="nav-item  @if(request()->is('police-permissions*')) active @endif">
            <a href="{{ route('police-permissions.index') }}" class="nav-link">
     <span class="pcoded-micon">
        <span class="ico-police"></span>
    </span>
                <span class="pcoded-mtext">{{__("main.police_permissions")}}</span>
            </a>
        </li>
    @endif
    @if(auth()->user()->hasPermission(\App\Models\Reminder::PERMISSION_NAME))
        <li data-username="Reminders" class="nav-item @if(request()->is('reminders*')) active @endif">
            <a href="{{ route('reminders.index') }}" class="nav-link">
                             <span class="pcoded-micon">
                                <span class="ico-reminder"></span>
                            </span>
                <span class="pcoded-mtext">{{__("main.reminders")}}</span>
            </a>
        </li>
    @endif
    @if(auth()->user()->hasPermission(\App\Models\Report::PERMISSION_NAME))
    <li data-username="Reports" class="nav-item @if(request()->is('reports*')) active @endif">
        <a href="{{ route('reports.index') }}" class="nav-link">
                             <span class="pcoded-micon">
                                <span class="ico-reports"></span>
                            </span>
            <span class="pcoded-mtext">{{__("main.reports")}}</span>
        </a>
    </li>
    @endif
    @if(auth()->user()->hasPermission(\App\Models\Commission::PERMISSION_NAME))
    <li data-username="Commissions" class="nav-item @if(request()->is('commissions*')) active @endif">
        <a href="{{ route('commissions.index') }}" class="nav-link">
             <span class="pcoded-micon">
                <span class="ico-commissions"></span>
            </span>
            <span class="pcoded-mtext">{{__("main.commissions")}}</span>
        </a>
    </li>
    @endif

    @if(auth()->user()->hasPermission(\App\Models\File::PERMISSION_NAME))
    <li data-username="Media Library" class="nav-item  @if(request()->is('media*')) active @endif">
        <a href="{{ route('media.index') }}" class="nav-link">
             <span class="pcoded-micon">
                <span class="ico-media"></span>
            </span>
            <span class="pcoded-mtext">{{__("main.media_library")}}</span>
        </a>
    </li>
    @endif




    @if(auth()->user()->hasPermission(\App\Models\ActivityLog::PERMISSION_NAME))
        <li data-username="Activity Logs" class="nav-item @if(request()->is('activity-logs*')) active @endif">
            <a href="{{ route('activity-logs.index') }}" class="nav-link">
        <span class="pcoded-micon">
            <span class="ico-jobsFile"></span>
        </span>
                <span class="pcoded-mtext">{{__("main.activity_logs")}}</span>
            </a>
        </li>
    @endif
</ul>
