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
                    <h5>{{__('main.vouchers')}}</h5>
                    <div class="card-header-right">
                        <div class="btn-group card-option">
                            <button type="button" class="btn dropdown-toggle btn-icon" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="feather icon-more-horizontal"></i>
                            </button>
                            <ul class="list-unstyled card-option dropdown-menu dropdown-menu-right">
                                <li class="dropdown-item full-card"><a href="#!"><span><i class="feather icon-maximize"></i> maximize</span><span style="display:none"><i class="feather icon-minimize"></i> Restore</span></a></li>
                                <li class="dropdown-item minimize-card"><a href="#!"><span><i class="feather icon-minus"></i> collapse</span><span style="display:none"><i class="feather icon-plus"></i> expand</span></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="card-block">
                    <div class="col-sm-12">
                        <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="pills-Traffic-tab" data-toggle="pill" href="#pills-Traffic" role="tab" aria-controls="pills-Traffic" aria-selected="true">{{__("main.traffic")}}</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="pills-Restaurant-tab" data-toggle="pill" href="#pills-Restaurant" role="tab" aria-controls="pills-Restaurant" aria-selected="false">{{__("main.restaurant")}}</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="pills-Hotel-tab" data-toggle="pill" href="#pills-Hotel" role="tab" aria-controls="pills-Hotel" aria-selected="false">{{__('main.hotel')}}</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="pills-Guide-tab" data-toggle="pill" href="#pills-Guide" role="tab" aria-controls="pills-Guide" aria-selected="false">{{__('main.guide')}}</a>
                            </li>
                        </ul>
                        <div class="tab-content" id="pills-tabContent">
                            <div class="tab-pane fade show active" id="pills-Traffic" role="tabpanel" aria-labelledby="pills-Traffic-tab">
                                <a id="crt-Nw-voc-trf" href="{{route('traffic-vouchers.create')}}" class="btn btn-primary mb-4">
                                    {{__("main.create_traffic_voucher")}}
                                </a>

                                <div class="table-responsive">
                                    <table id="traffic-vouchers-table" class="table table-striped table-hover table-bordered nowrap w-100">
                                        <thead>
                                        <tr>
                                            <th>{{__("main.action")}}</th>
                                            <th>{{__("main.serial_no")}}</th>
                                            <th>{{__("main.file_no")}}</th>
                                            <th>{{__("main.issued_by")}}</th>
                                            <th>{{__("main.to")}}</th>
                                            <th>{{__("main.client_name")}}</th>
                                            <th>{{__("main.arrival_date")}}</th>
                                            <th>{{__("main.arrival_at")}}</th>
                                            <th>{{__("main.departure_date")}}</th>
                                            <th>{{__("main.departure_at")}}</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="pills-Restaurant" role="tabpanel" aria-labelledby="pills-Restaurant-tab">
                                <a id="crt-Nw-voc-res"  href="{{route('restaurant-vouchers.create')}}" class="btn btn-primary mb-4">
                                    {{__("main.create_restaurant_voucher")}}
                                </a>

                                <div class="table-responsive">
                                    <table id="restaurant-vouchers-table" class="table table-striped table-hover table-bordered nowrap w-100">
                                        <thead>
                                        <tr>
                                            <th>{{__("main.action")}}</th>
                                            <th>{{__("main.serial_no")}}</th>
                                            <th>{{__("main.file_no")}}</th>
                                            <th>{{__("main.issued_by")}}</th>
                                            <th>{{__("main.to")}}</th>
                                            <th>{{__("main.client_name")}}</th>
                                            <th>{{__("main.arrival_date")}}</th>
                                            <th>{{__("main.arrival_at")}}</th>
                                            <th>{{__("main.departure_date")}}</th>
                                            <th>{{__("main.departure_at")}}</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="pills-Hotel" role="tabpanel" aria-labelledby="pills-Hotel-tab">
                                <a id="crt-Nw-voc-hot" href="{{route('hotel-vouchers.create')}}" class="btn btn-primary mb-4">
                                    {{__('main.create_new_hotel_voucher')}}
                                </a>

                                <div class="table-responsive">
                                    <table id="hotel-vouchers-table" class="table table-striped table-hover table-bordered nowrap w-100">
                                        <thead>
                                        <tr>
                                            <th>{{__('main.action')}}</th>
                                            <th>{{__('main.serial_no')}}</th>
                                            <th>{{__('main.file_no')}}</th>
                                            <th>{{__('main.issued_by')}}</th>
                                            <th>{{__('main.hotel')}}/{{__('main.cruise')}}</th>
                                            <th>{{__('main.client_name')}}</th>
                                            <th>{{__('main.arrival_date')}}</th>
                                            <th>{{__('main.departure_date')}}</th>
                                            <th>{{__('main.number_of_nights')}}</th>
                                            <th>{{__('main.number_of_guests')}}</th>
                                        </tr>
                                        </thead>
                                        <tbody>

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="pills-Guide" role="tabpanel" aria-labelledby="pills-Guide-tab">
                                <a id="crt-Nw-voc-gid" href="{{route('guide-vouchers.create')}}" class="btn btn-primary mb-4">
                                    {{__('main.create_new_guide_voucher')}}
                                </a>

                                <div class="table-responsive">
                                    <table id="guide-vouchers-table" class="table table-striped table-hover table-bordered nowrap w-100">
                                        <thead>
                                        <tr>
                                            <th>{{__('main.action')}}</th>
                                            <th>{{__('main.serial_no')}}</th>
                                            <th>{{__('main.file_no')}}</th>
                                            <th>{{__('main.issued_by')}}</th>
                                            <th>{{__('main.client_name')}}</th>
                                            <th>{{__('main.hotel_name')}}</th>
                                            <th>{{__('main.pax_count')}}</th>
                                            <th>{{__('main.tour_guide_name')}}</th>
                                            <th>{{__('main.guide_language')}}</th>
                                            <th>{{__('main.tour_operator')}}</th>
                                        </tr>
                                        </thead>
                                        <tbody>

                                        </tbody>
                                    </table>
                                </div>
                            </div>
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
        var traffic_index_path = '{{ route('traffic-vouchers.index') }}';
        var traffic_view_path = '{{ route('traffic-vouchers.show', ['traffic_voucher'=> 'voucher_id']) }}';
        var traffic_print_path = '{{ route('traffic-vouchers.show', ['traffic_voucher'=> 'voucher_id']). '?print=1' }}';
        var traffic_edit_path = '{{ route('traffic-vouchers.edit', ['traffic_voucher'=> 'voucher_id']) }}';
        var traffic_destroy_path = '{{ route('traffic-vouchers.destroy', ['traffic_voucher'=> 'voucher_id']) }}';

        //only one var for all tabs because they all have the same permission
        var traffic_write = false;
        @if($write_perm)
        var traffic_write = true;
        @endif

        var restaurant_index_path = '{{ route('restaurant-vouchers.index') }}';
        var restaurant_view_path = '{{ route('restaurant-vouchers.show', ['restaurant_voucher'=> 'voucher_id']) }}';
        var restaurant_print_path = '{{ route('restaurant-vouchers.show', ['restaurant_voucher'=> 'voucher_id']) . '?print=1' }}';
        var restaurant_edit_path = '{{ route('restaurant-vouchers.edit', ['restaurant_voucher'=> 'voucher_id']) }}';
        var restaurant_destroy_path = '{{ route('restaurant-vouchers.destroy', ['restaurant_voucher'=> 'voucher_id']) }}';

        var hotel_index_path = '{{ route('hotel-vouchers.index') }}';
        var hotel_view_path = '{{ route('hotel-vouchers.show', ['hotel_voucher'=> 'voucher_id']) }}';
        var hotel_print_path = '{{ route('hotel-vouchers.show', ['hotel_voucher'=> 'voucher_id']) . '?print=1' }}';
        var hotel_edit_path = '{{ route('hotel-vouchers.edit', ['hotel_voucher'=> 'voucher_id']) }}';
        var hotel_destroy_path = '{{ route('hotel-vouchers.destroy', ['hotel_voucher'=> 'voucher_id']) }}';

        var guide_index_path = '{{ route('guide-vouchers.index') }}';
        var guide_view_path = '{{ route('guide-vouchers.show', ['guide_voucher'=> 'voucher_id']) }}';
        var guide_print_path = '{{ route('guide-vouchers.show', ['guide_voucher'=> 'voucher_id']) . '?print=1' }}';
        var guide_edit_path = '{{ route('guide-vouchers.edit', ['guide_voucher'=> 'voucher_id']) }}';
        var guide_destroy_path = '{{ route('guide-vouchers.destroy', ['guide_voucher'=> 'voucher_id']) }}';

    </script>

    <script src="{{asset('assets/js/vouchers.js?ver=1.2')}}"></script>

@endsection
