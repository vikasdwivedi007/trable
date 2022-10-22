@extends('layouts.main')

@section('script_top_before_base')
    <!-- prism css -->
    <link rel="stylesheet" href="{{asset('assets/plugins/prism/css/prism.min.css')}}">
    <!-- data tables css -->
    <link rel="stylesheet" href="{{asset('assets/plugins/data-tables/css/datatables.min.css')}}">
@endsection

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h5>{{__('main.suppliers')}}</h5>
                    <div class="card-header-right">
                        <div class="btn-group card-option">
                            <button type="button" class="btn dropdown-toggle btn-icon"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="feather icon-more-horizontal"></i>
                            </button>
                            <ul class="list-unstyled card-option dropdown-menu dropdown-menu-right">
                                <li class="dropdown-item full-card"><a href="#!"><span><i
                                                class="feather icon-maximize"></i>
                                                                maximize</span><span style="display:none"><i
                                                class="feather icon-minimize"></i>
                                                                Restore</span></a></li>
                                <li class="dropdown-item minimize-card"><a href="#!"><span><i
                                                class="feather icon-minus"></i>
                                                                collapse</span><span style="display:none"><i
                                                class="feather icon-plus"></i> expand</span></a>
                                </li>
                                <li class="dropdown-item reload-card"><a href="#!"><i
                                            class="feather icon-refresh-cw"></i> reload</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="card-block">
                    <div class="col-sm-12">
                        <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                            @if(in_array(\App\Models\Hotel::PERMISSION_NAME, $available_tabs))
                            <li class="nav-item">
                                <a class="nav-link @if($active_tab == \App\Models\Hotel::PERMISSION_NAME) active @endif" id="pills-Hotels-tab"
                                   data-toggle="pill" href="#pills-Hotels" role="tab"
                                   aria-controls="pills-Hotels"
                                   aria-selected="true">{{__("main.hotels")}}</a>
                            </li>
                            @endif
                            @if(in_array(\App\Models\Restaurant::PERMISSION_NAME, $available_tabs))
                            <li class="nav-item ">
                                <a class="nav-link @if($active_tab == \App\Models\Restaurant::PERMISSION_NAME) active @endif" id="pills-Restaurants-tab" data-toggle="pill"
                                   href="#pills-Restaurants" role="tab" aria-controls="pills-Restaurants"
                                   aria-selected="false">{{__("main.restaurants")}}</a>
                            </li>
                            @endif
                            @if(in_array(\App\Models\Transportation::PERMISSION_NAME, $available_tabs))
                            <li class="nav-item ">
                                <a class="nav-link @if($active_tab == \App\Models\Transportation::PERMISSION_NAME) active @endif" id="pills-Transportations-tab" data-toggle="pill"
                                   href="#pills-Transportations" role="tab" aria-controls="pills-Transportations"
                                   aria-selected="false">{{__("main.transportations")}}</a>
                            </li>
                            @endif
                            @if(in_array(\App\Models\TrainTicket::PERMISSION_NAME, $available_tabs))
                            <li class="nav-item ">
                                <a class="nav-link @if($active_tab == \App\Models\TrainTicket::PERMISSION_NAME) active @endif" id="pills-Train-Tickets-tab" data-toggle="pill"
                                   href="#pills-Train-Tickets" role="tab" aria-controls="pills-Train-Tickets"
                                   aria-selected="false">{{__("main.train_tickets")}}</a>
                            </li>
                            @endif
                            @if(in_array(\App\Models\Guide::PERMISSION_NAME, $available_tabs))
                                <li class="nav-item ">
                                    <a class="nav-link @if($active_tab == \App\Models\Guide::PERMISSION_NAME) active @endif" id="pills-Guides-tab" data-toggle="pill"
                                       href="#pills-Guides" role="tab" aria-controls="pills-Guides"
                                       aria-selected="false">{{__('main.guides')}}</a>
                                </li>
                            @endif
                            @if(in_array(\App\Models\NileCruise::PERMISSION_NAME, $available_tabs))
                            <li class="nav-item">
                                <a class="nav-link @if($active_tab == \App\Models\NileCruise::PERMISSION_NAME) active @endif" id="pills-Nile-Cruises-tab" data-toggle="pill"
                                   href="#pills-Nile-Cruises" role="tab"
                                   aria-controls="pills-Nile-Cruises" aria-selected="false">{{__('main.nile_cruises')}}</a>
                            </li>
                            @endif
                            @if(in_array(\App\Models\Flight::PERMISSION_NAME, $available_tabs))
                            <li class="nav-item">
                                <a class="nav-link @if($active_tab == \App\Models\Flight::PERMISSION_NAME) active @endif" id="pills-Flights-tab" data-toggle="pill"
                                   href="#pills-Flights" role="tab"
                                   aria-controls="pills-Flights" aria-selected="false">{{__('main.flights')}}</a>
                            </li>
                            @endif
                        </ul>
                        <div class="tab-content" id="pills-tabContent">
                            @if(in_array(\App\Models\Hotel::PERMISSION_NAME, $available_tabs))
                            <div class="tab-pane fade @if($active_tab == \App\Models\Hotel::PERMISSION_NAME) show active @endif" id="pills-Hotels"
                                 role="tabpanel" aria-labelledby="pills-Hotels-tab">
                                @if(in_array(\App\Models\Hotel::PERMISSION_NAME, $write_permissions))
                                <a id="crt-Nw-shtsing" href="{{ route('hotels.create') }}" class="btn btn-primary mb-4">
                                    {{__('main.create_new_hotel')}}
                                </a>
                                <a id="crt-Nw-room" href="{{route('rooms.create')}}"
                                   class="btn btn-primary mb-4">
                                    {{__("main.create_new_room")}}
                                </a>
                                @endif

                                <div class="table-responsive">
                                    <table id="rooms-table"
                                           class="table table-striped table-hover table-bordered nowrap w-100">
                                        <thead>
                                        <tr>
                                            <th>{{__("main.action")}}</th>
                                            <th>{{__("main.city")}}</th>
                                            <th>{{__("main.hotel_name")}}</th>
                                            <th>{{__("main.room_category")}}</th>
                                            <th>{{__("main.type")}}</th>
                                            <th>{{__("main.meal_plan")}}</th>
                                            <th>{{__("main.date_from")}}</th>
                                            <th>{{__("main.date_to")}}</th>
                                            <th>{{__("main.room_base_rate")}}</th>
                                            <th>{{__("main.discount")}}</th>
                                            <th>{{__("main.room_rate")}}</th>
                                            <th>{{__("main.extra_bed")}}</th>
                                            <th>{{__("main.single_parent_adult")}}</th>
                                            <th>{{__("main.single_parent_child")}}</th>
                                            <th>{{__("main.hotel_phone")}}</th>
                                            <th>{{__("main.hotel_email")}}</th>
                                        </tr>
                                        </thead>

                                    </table>
                                </div>
                            </div>
                            @endif
                            @if(in_array(\App\Models\Restaurant::PERMISSION_NAME, $available_tabs))
                            <div class="tab-pane fade @if($active_tab == \App\Models\Restaurant::PERMISSION_NAME) show active @endif" id="pills-Restaurants" role="tabpanel"
                                 aria-labelledby="pills-Restaurants-tab">
                                @if(in_array(\App\Models\Restaurant::PERMISSION_NAME, $write_permissions))
                                <a href="{{ route('restaurants.create') }}" id="crt-Nw-rutr" class="btn btn-primary mb-4">
                                    Create New Restaurant
                                </a>
                                @endif

                                <div class="table-responsive">
                                    <table id="restaurants-table"
                                           class="table table-striped table-hover table-bordered nowrap w-100">
                                        <thead>
                                        <tr>
                                            <th>Action</th>
                                            <th>Name</th>
                                            <th>City</th>
                                            <th>Phone</th>
                                            <th>Email</th>
                                        </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                            @endif
                            @if(in_array(\App\Models\Transportation::PERMISSION_NAME, $available_tabs))
                            <div class="tab-pane fade @if($active_tab == \App\Models\Transportation::PERMISSION_NAME) show active @endif" id="pills-Transportations" role="tabpanel"
                                 aria-labelledby="pills-Transportations-tab">
                                @if(in_array(\App\Models\Transportation::PERMISSION_NAME, $write_permissions))
                                <a id="crt-Nw-Trnsprtn" href="{{ route('transportations.create') }}" class="btn btn-primary mb-4">
                                    {{__("main.create_new_transportation")}}
                                </a>
                                @endif

                                <div class="table-responsive">
                                    <table id="transportations-table"
                                           class="table table-striped table-hover table-bordered nowrap w-100">
                                        <thead>
                                        <tr>
                                            <th>{{__("main.action")}}</th>
                                            <th>{{__("main.company_code")}}</th>
                                            <th>{{__("main.company_name")}}</th>
                                            <th>{{__("main.phone")}}</th>
                                            <th>{{__("main.email")}}</th>
                                            <th>{{__("main.city")}}</th>
                                        </tr>
                                        </thead>

                                    </table>
                                </div>
                            </div>
                            @endif
                            @if(in_array(\App\Models\TrainTicket::PERMISSION_NAME, $available_tabs))
                            <div class="tab-pane fade @if($active_tab == \App\Models\TrainTicket::PERMISSION_NAME) show active @endif" id="pills-Train-Tickets" role="tabpanel"
                                 aria-labelledby="pills-Train-Ticket-tab">
                                @if(in_array(\App\Models\TrainTicket::PERMISSION_NAME, $write_permissions))
                                <a id="crt-Nw-Trn-Tckt" href="{{ route('train-tickets.create') }}" class="btn btn-primary mb-4">
                                    {{__("main.create_train_ticket")}}
                                </a>
                                @endif

                                <div class="table-responsive">
                                    <table id="train-tickets-table"
                                           class="table table-striped table-hover table-bordered nowrap w-100">
                                        <thead>
                                        <tr>
                                            <th>{{__("main.action")}}</th>
                                            <th>{{__("main.number")}}</th>
                                            <th>{{__("main.type")}}</th>
                                            <th>{{__("main.class")}}</th>
                                            <th>{{__("main.wagon_no")}}</th>
                                            <th>{{__("main.seat_bed_no")}}</th>
                                            <th>{{__("main.from_city")}}</th>
                                            <th>{{__("main.to_city")}}</th>
                                            <th>{{__("main.departure_at")}}</th>
                                            <th>{{__("main.arrival_at")}}</th>
                                            @if(in_array(\App\Models\TrainTicket::PERMISSION_NAME, $write_permissions))
                                            <th>{{__("main.sgl_buying_price")}}</th>
                                            @endif
                                            <th>{{__("main.sgl_selling_price")}}</th>
                                        </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                            @endif

                            @if(in_array(\App\Models\Guide::PERMISSION_NAME, $available_tabs))
                                <div class="tab-pane fade @if($active_tab == \App\Models\Guide::PERMISSION_NAME) show active @endif" id="pills-Guides" role="tabpanel"
                                     aria-labelledby="pills-Guides-tab">
                                    @if(in_array(\App\Models\Guide::PERMISSION_NAME, $write_permissions))
                                        <a id="crt-Nw-Gid" href="{{ route('guides.create') }}" class="btn btn-primary mb-4">
                                            {{__('main.create_new_guide')}}
                                        </a>
                                    @endif

                                    <div class="table-responsive">
                                        <table id="guides-table"
                                               class="table table-striped table-hover table-bordered nowrap w-100">
                                            <thead>
                                            <tr>
                                                <th>{{__('main.action')}}</th>
                                                <th>{{__('main.name')}}</th>
                                                <th>{{__('main.city')}}</th>
                                                <th>{{__('main.phone')}} </th>
                                                <th>{{__('main.spoken_language')}}</th>
                                                <th>{{__('main.email')}}</th>
                                                <th>{{__('main.license_no')}}</th>
                                                <th>{{__('main.daily_fees')}}</th>
                                            </tr>
                                            </thead>
                                        </table>
                                    </div>
                                </div>
                            @endif

                            @if(in_array(\App\Models\NileCruise::PERMISSION_NAME, $available_tabs))
                            <div class="tab-pane fade @if($active_tab == \App\Models\NileCruise::PERMISSION_NAME) show active @endif" id="pills-Nile-Cruises" role="tabpanel"
                                 aria-labelledby="pills-Nile-Cruises-tab">
                                @if(in_array(\App\Models\NileCruise::PERMISSION_NAME, $write_permissions))
                                <a id="crt-Nw-Nil-Crus" href="{{ route('nile-cruises.create') }}" class="btn btn-primary mb-4">
                                    {{__('main.create_new_nile_cruise')}}
                                </a>
                                @endif

                                <div class="table-responsive">
                                    <table id="nile-cruises-table"
                                           class="table table-striped table-hover table-bordered nowrap w-100">
                                        <thead>
                                        <tr>
                                            <th>{{__('main.action')}}</th>
                                            <th>{{__('main.company_name')}}</th>
                                            <th>{{__('main.from_city')}}</th>
                                            <th>{{__('main.to_city')}}</th>
                                            <th>{{__('main.name')}}</th>
                                            <th>{{__('main.date_from')}}</th>
                                            <th>{{__('main.date_to')}}</th>
                                            <th>{{__('main.type')}}</th>
                                            @if(in_array(\App\Models\NileCruise::PERMISSION_NAME, $write_permissions))
                                            <th>{{__('main.sgl_room_buying_price')}}</th>
                                            @endif
                                            <th>{{__('main.sgl_room_selling_price')}}</th>
                                            @if(in_array(\App\Models\NileCruise::PERMISSION_NAME, $write_permissions))
                                            <th>{{__('main.per_person_dbl_room_buying_price')}}</th>
                                            @endif
                                            <th>{{__('main.per_person_dbl_room_selling_price')}}</th>
                                            @if(in_array(\App\Models\NileCruise::PERMISSION_NAME, $write_permissions))
                                            <th>{{__('main.per_person_trpl_room_buying_price')}}</th>
                                            @endif
                                            <th>{{__('main.per_person_trpl_room_selling_price')}}</th>
                                            @if(in_array(\App\Models\NileCruise::PERMISSION_NAME, $write_permissions))
                                            <th>{{__('main.children_buying_price')}}</th>
                                            @endif
                                            <th>{{__('main.children_selling_price')}}</th>
                                        </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                            @endif
                            @if(in_array(\App\Models\Flight::PERMISSION_NAME, $available_tabs))
                            <div class="tab-pane fade @if($active_tab == \App\Models\Flight::PERMISSION_NAME) show active @endif" id="pills-Flights" role="tabpanel"
                                 aria-labelledby="pills-Flights-tab">
                                @if(in_array(\App\Models\Flight::PERMISSION_NAME, $write_permissions))
                                <a id="crt-Nw-Flights" href="{{ route('flights.create') }}" class="btn btn-primary mb-4">
                                    {{__('main.create_new_flight')}}
                                </a>
                                @endif

                                <div class="table-responsive">
                                    <table id="flights-table"
                                           class="table table-striped table-hover table-bordered nowrap w-100">
                                        <thead>
                                        <tr>
                                            <th>{{__('main.action')}}</th>
                                            <th>{{__('main.flight_number')}}</th>
                                            <th>{{__('main.flight_date')}}</th>
                                            <th>{{__('main.from')}}</th>
                                            <th>{{__('main.to')}}</th>
                                            <th>{{__('main.departure_at')}} </th>
                                            <th>{{__('main.arrival_at')}}</th>
                                            <th>{{__('main.number_of_seats')}}</th>
                                            <th>{{__('main.reference_no')}}</th>
                                            <th>{{__('main.status')}}</th>
                                            @if(in_array(\App\Models\Flight::PERMISSION_NAME, $write_permissions))
                                            <th>{{__('main.buying_price')}}</th>
                                            @endif
                                            <th>{{__('main.selling_price')}}</th>
                                        </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                            @endif

                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>
@endsection

@section('script_bottom')
    <!-- datatable Js -->
    <script src="{{asset('assets/plugins/data-tables/js/datatables.min.js')}}"></script>

    <!-- prism Js -->
    <script src="{{asset('assets/plugins/prism/js/prism.min.js')}}"></script>
    <script>
        var csrf = '@csrf';
        var delete_method = '@method('DELETE')';
        @if(in_array(\App\Models\Hotel::PERMISSION_NAME, $available_tabs))
            var hotels_index_path = '{{ route('hotels.index') }}';
            var rooms_edit_path = '{{ route('rooms.edit', ['room'=> 'room_id']) }}';
            var rooms_destroy_path = '{{ route('rooms.destroy', ['room'=> 'room_id']) }}';
            var rooms_write = false;
            @if(in_array(\App\Models\Hotel::PERMISSION_NAME, $write_permissions))
            rooms_write = true;
            @endif
        @endif
        @if(in_array(\App\Models\Restaurant::PERMISSION_NAME, $available_tabs))
            var restaurants_index_path = '{{ route('restaurants.index') }}';
            var restaurants_edit_path = '{{ route('restaurants.edit', ['restaurant'=> 'restaurant_id']) }}';
            var restaurants_destroy_path = '{{ route('restaurants.destroy', ['restaurant'=> 'restaurant_id']) }}';
            var restaurants_write = false;
            @if(in_array(\App\Models\Restaurant::PERMISSION_NAME, $write_permissions))
            restaurants_write = true;
            @endif
        @endif
        @if(in_array(\App\Models\Transportation::PERMISSION_NAME, $available_tabs))
            var transportations_index_path = '{{ route('transportations.index') }}';
            var transportations_edit_path = '{{ route('transportations.edit', ['transportation'=> 'transportation_id']) }}';
            var transportations_destroy_path = '{{ route('transportations.destroy', ['transportation'=> 'transportation_id']) }}';
            var transportations_write = false;
            @if(in_array(\App\Models\Transportation::PERMISSION_NAME, $write_permissions))
            transportations_write = true;
            @endif
        @endif
        @if(in_array(\App\Models\TrainTicket::PERMISSION_NAME, $available_tabs))
            var train_tickets_index_path = '{{ route('train-tickets.index') }}';
            var train_tickets_edit_path = '{{ route('train-tickets.edit', ['train_ticket'=> 'train_ticket_id']) }}';
            var train_tickets_destroy_path = '{{ route('train-tickets.destroy', ['train_ticket'=> 'train_ticket_id']) }}';
            var train_tickets_write = false;
            @if(in_array(\App\Models\TrainTicket::PERMISSION_NAME, $write_permissions))
            train_tickets_write = true;
            @endif
        @endif
        @if(in_array(\App\Models\Guide::PERMISSION_NAME, $available_tabs))
            var guides_index_path = '{{ route('guides.index') }}';
            var guides_edit_path = '{{ route('guides.edit', ['guide'=> 'guide_id']) }}';
            var guides_destroy_path = '{{ route('guides.destroy', ['guide'=> 'guide_id']) }}';
            var guides_write = false;
            @if(in_array(\App\Models\Guide::PERMISSION_NAME, $write_permissions))
                guides_write = true;
            @endif
        @endif
        @if(in_array(\App\Models\NileCruise::PERMISSION_NAME, $available_tabs))
            var nile_cruises_index_path = '{{ route('nile-cruises.index') }}';
            var nile_cruises_edit_path = '{{ route('nile-cruises.edit', ['nile_cruise'=> 'nile_cruise_id']) }}';
            var nile_cruises_destroy_path = '{{ route('nile-cruises.destroy', ['nile_cruise'=> 'nile_cruise_id']) }}';
            var nile_cruises_write = false;
            @if(in_array(\App\Models\NileCruise::PERMISSION_NAME, $write_permissions))
            nile_cruises_write = true;
            @endif
        @endif
        @if(in_array(\App\Models\Flight::PERMISSION_NAME, $available_tabs))
            var flights_index_path = '{{ route('flights.index') }}';
            var flights_edit_path = '{{ route('flights.edit', ['flight'=> 'flight_id']) }}';
            var flights_destroy_path = '{{ route('flights.destroy', ['flight'=> 'flight_id']) }}';
            var flights_write = false;
            @if(in_array(\App\Models\Flight::PERMISSION_NAME, $write_permissions))
            flights_write = true;
            @endif
        @endif
    </script>
    <script src="{{asset('assets/js/suppliers.js?ver=4.7')}}"></script>
@endsection
