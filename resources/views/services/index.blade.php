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
                    <h5>{{__('main.services_facilities')}}</h5>
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
                            @if(in_array(\App\Models\Sightseeing::PERMISSION_NAME, $available_tabs))
                            <li class="nav-item">
                                <a class="nav-link @if($active_tab == \App\Models\Sightseeing::PERMISSION_NAME) active @endif" id="pills-Sightseeing-tab"
                                   data-toggle="pill" href="#pills-Sightseeing" role="tab"
                                   aria-controls="pills-Sightseeing"
                                   aria-selected="true">{{__("main.excursions")}}</a>
                            </li>
                            @endif
                            @if(in_array(\App\Models\Router::PERMISSION_NAME, $available_tabs))
                            <li class="nav-item ">
                                <a class="nav-link @if($active_tab == \App\Models\Router::PERMISSION_NAME) active @endif" id="pills-Routers-tab" data-toggle="pill"
                                   href="#pills-Routers" role="tab" aria-controls="pills-Routers"
                                   aria-selected="false">{{__("main.routers")}}</a>
                            </li>
                            @endif
                            @if(in_array(\App\Models\SLShow::PERMISSION_NAME, $available_tabs))
                            <li class="nav-item ">
                                <a class="nav-link @if($active_tab == \App\Models\SLShow::PERMISSION_NAME) active @endif" id="pills-Sound-Light-Show-tab" data-toggle="pill"
                                   href="#pills-Sound-Light-Show" role="tab" aria-controls="pills-Sound-Light-Show"
                                   aria-selected="false">{{__("main.slshows")}}</a>
                            </li>
                            @endif
                            @if(in_array(\App\Models\VBNight::PERMISSION_NAME, $available_tabs))
                            <li class="nav-item ">
                                <a class="nav-link @if($active_tab == \App\Models\VBNight::PERMISSION_NAME) active @endif" id="pills-Visit-by-Night-tab" data-toggle="pill"
                                   href="#pills-Visit-by-Night" role="tab" aria-controls="pills-Visit-by-Night"
                                   aria-selected="false">{{__("main.vbnight")}}</a>
                            </li>
                            @endif
                            @if(in_array(\App\Models\LKFriend::PERMISSION_NAME, $available_tabs))
                            <li class="nav-item">
                                <a class="nav-link @if($active_tab == \App\Models\LKFriend::PERMISSION_NAME) active @endif" id="pills-Like-Friend-tab" data-toggle="pill"
                                   href="#pills-Like-Friend" role="tab"
                                   aria-controls="pills-Like-Friend" aria-selected="false">{{__('main.like_a_friend')}}</a>
                            </li>
                            @endif
                            @if(in_array(\App\Models\Shop::PERMISSION_NAME, $available_tabs))
                            <li class="nav-item">
                                <a class="nav-link @if($active_tab == \App\Models\Shop::PERMISSION_NAME) active @endif" id="pills-Shops-tab" data-toggle="pill"
                                   href="#pills-Shops" role="tab"
                                   aria-controls="pills-Shops" aria-selected="false">{{__("main.shops")}}</a>
                            </li>
                            @endif
                            @if(in_array(\App\Models\Gift::PERMISSION_NAME, $available_tabs))
                                <li class="nav-item">
                                    <a class="nav-link @if($active_tab == \App\Models\Gift::PERMISSION_NAME) active @endif" id="pills-Gifts-tab" data-toggle="pill"
                                       href="#pills-Gifts" role="tab"
                                       aria-controls="pills-Gifts" aria-selected="false">{{__('main.gifts')}}</a>
                                </li>
                            @endif
                            @if(in_array(\App\Models\TravelVisa::PERMISSION_NAME, $available_tabs))
                                <li class="nav-item">
                                    <a class="nav-link @if($active_tab == \App\Models\TravelVisa::PERMISSION_NAME) active @endif" id="pills-Travel-visa-tab" data-toggle="pill"
                                       href="#pills-Travel-visa" role="tab"
                                       aria-controls="pills-Travel-visa" aria-selected="false">{{__("main.travel_visa")}}</a>
                                </li>
                            @endif
                        </ul>
                        <div class="tab-content" id="pills-tabContent">
                            @if(in_array(\App\Models\Sightseeing::PERMISSION_NAME, $available_tabs))
                            <div class="tab-pane fade @if($active_tab == \App\Models\Sightseeing::PERMISSION_NAME) show active @endif" id="pills-Sightseeing"
                                 role="tabpanel" aria-labelledby="pills-Sightseeing-tab">
                                @if(in_array(\App\Models\Sightseeing::PERMISSION_NAME, $write_permissions))
                                <a id="crt-Nw-shtsing" href="{{ route('sightseeings.create') }}" class="btn btn-primary mb-4">
                                    {{__("main.create_new_excursion")}}
                                </a>
                                @endif

                                <div class="table-responsive">
                                    <table id="responsive-table"
                                           class="table table-striped table-hover table-bordered nowrap w-100">
                                        <thead>
                                        <tr>
                                            <th>{{__("main.action")}}</th>
                                            <th>{{__("main.name")}}</th>
                                            <th>{{__("main.description")}}</th>
                                            <th>{{__("main.city")}}</th>
                                            @if(in_array(\App\Models\Sightseeing::PERMISSION_NAME, $write_permissions))
                                            <th>{{__("main.adult_buying_price")}}</th>
                                            @endif
                                            <th>{{__("main.adult_selling_price")}}</th>
                                            @if(in_array(\App\Models\Sightseeing::PERMISSION_NAME, $write_permissions))
                                            <th>{{__("main.child_buying_price")}}</th>
                                            @endif
                                            <th>{{__("main.child_selling_price")}}</th>
                                        </tr>
                                        </thead>

                                    </table>
                                </div>
                            </div>
                            @endif
                            @if(in_array(\App\Models\Router::PERMISSION_NAME, $available_tabs))
                            <div class="tab-pane fade @if($active_tab == \App\Models\Router::PERMISSION_NAME) show active @endif" id="pills-Routers" role="tabpanel"
                                 aria-labelledby="pills-Routers-tab">
                                @if(in_array(\App\Models\Router::PERMISSION_NAME, $write_permissions))
                                <a href="{{ route('routers.create') }}" id="crt-Nw-rutr" class="btn btn-primary mb-4">
                                    {{__("main.create_new_router")}}
                                </a>
                                @endif

                                <div class="table-responsive">
                                    <table id="col-reorder"
                                           class="table table-striped table-hover table-bordered nowrap w-100">
                                        <thead>
                                        <tr>
                                            <th>{{__("main.action")}}</th>
                                            <th>{{__("main.city")}}</th>
                                            <th>{{__("main.serial_no")}}</th>
                                            <th>{{__("main.number_of_router")}}</th>
                                            <th>{{__("main.service_provider")}}</th>
                                            <th>{{__("main.package_quota")}}</th>
                                            @if(in_array(\App\Models\Router::PERMISSION_NAME, $write_permissions))
                                            <th>{{__("main.buying_price")}}</th>
                                            @endif
                                            <th>{{__("main.selling_price")}}</th>
                                        </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                            @endif
                            @if(in_array(\App\Models\SLShow::PERMISSION_NAME, $available_tabs))
                            <div class="tab-pane fade @if($active_tab == \App\Models\SLShow::PERMISSION_NAME) show active @endif" id="pills-Sound-Light-Show" role="tabpanel"
                                 aria-labelledby="pills-Sound-Light-Show-tab">
                                @if(in_array(\App\Models\SLShow::PERMISSION_NAME, $write_permissions))
                                <a id="crt-Nw-sond-ligt-shw" href="{{ route('slshows.create') }}" class="btn btn-primary mb-4">
                                    {{__("main.create_new_slshow")}}
                                </a>
                                @endif

                                <div class="table-responsive">
                                    <table id="fixed-header"
                                           class="table table-striped table-hover table-bordered nowrap w-100">
                                        <thead>
                                        <tr>
                                            <th>{{__("main.action")}}</th>
                                            <th>{{__("main.place")}}</th>
                                            <th>{{__("main.date")}}</th>
                                            <th>{{__("main.time")}}</th>
                                            <th>{{__("main.show_language")}}</th>
                                            <th>{{__("main.ticket_type")}}</th>
                                            @if(in_array(\App\Models\SLShow::PERMISSION_NAME, $write_permissions))
                                            <th>{{__("main.adult_buying_price")}}</th>
                                            @endif
                                            <th>{{__("main.adult_selling_price")}}</th>
                                            @if(in_array(\App\Models\SLShow::PERMISSION_NAME, $write_permissions))
                                            <th>{{__("main.child_buying_price")}}</th>
                                            @endif
                                            <th>{{__("main.child_selling_price")}}</th>
                                        </tr>
                                        </thead>

                                    </table>
                                </div>
                            </div>
                            @endif
                            @if(in_array(\App\Models\VBNight::PERMISSION_NAME, $available_tabs))
                            <div class="tab-pane fade @if($active_tab == \App\Models\VBNight::PERMISSION_NAME) show active @endif" id="pills-Visit-by-Night" role="tabpanel"
                                 aria-labelledby="pills-Visit-by-Night-tab">
                                @if(in_array(\App\Models\VBNight::PERMISSION_NAME, $write_permissions))
                                <a id="crt-Nw-vst-by-nigt" href="{{ route('vbnights.create') }}" class="btn btn-primary mb-4">
                                    {{__("main.create_new_vbnight")}}
                                </a>
                                @endif

                                <div class="table-responsive">
                                    <table id="vbnights-table"
                                           class="table table-striped table-hover table-bordered nowrap w-100">
                                        <thead>
                                        <tr>
                                            <th>{{__("main.action")}}</th>
                                            <th>{{__("main.city")}}</th>
                                            <th>{{__("main.name")}}</th>
                                            @if(in_array(\App\Models\VBNight::PERMISSION_NAME, $write_permissions))
                                            <th>{{__("main.adult_buying_price")}}</th>
                                            @endif
                                            <th>{{__("main.adult_selling_price")}}</th>
                                            @if(in_array(\App\Models\VBNight::PERMISSION_NAME, $write_permissions))
                                            <th>{{__("main.child_buying_price")}}</th>
                                            @endif
                                            <th>{{__("main.child_selling_price")}}</th>
                                        </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                            @endif
                            @if(in_array(\App\Models\LKFriend::PERMISSION_NAME, $available_tabs))
                            <div class="tab-pane fade @if($active_tab == \App\Models\LKFriend::PERMISSION_NAME) show active @endif" id="pills-Like-Friend" role="tabpanel"
                                 aria-labelledby="pills-Like-Friend-tab">
                                @if(in_array(\App\Models\LKFriend::PERMISSION_NAME, $write_permissions))
                                <a id="crt-Nw-lik-frnd" href="{{ route('lkfriends.create') }}" class="btn btn-primary mb-4">
                                    {{__('main.create_new_lkfriend')}}
                                </a>
                                @endif

                                <div class="table-responsive">
                                    <table id="lkfriends-table"
                                           class="table table-striped table-hover table-bordered nowrap w-100">
                                        <thead>
                                        <tr>
                                            <th>{{__('main.action')}}</th>
                                            <th>{{__('main.name')}}</th>
                                            <th>{{__('main.city')}}</th>
                                            <th>{{__('main.phone')}}</th>
                                            <th>{{__('main.spoken_language')}}</th>
                                            @if(in_array(\App\Models\LKFriend::PERMISSION_NAME, $write_permissions))
                                            <th>{{__('main.fees_per_day')}}</th>
                                            @endif
                                            <th>{{__('main.selling_fees_per_day')}}</th>
                                        </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                            @endif
                            @if(in_array(\App\Models\Shop::PERMISSION_NAME, $available_tabs))
                            <div class="tab-pane fade @if($active_tab == \App\Models\Shop::PERMISSION_NAME) show active @endif" id="pills-Shops" role="tabpanel"
                                 aria-labelledby="pills-Shops-tab">
                                @if(in_array(\App\Models\Shop::PERMISSION_NAME, $write_permissions))
                                <a id="crt-Nw-Shop" href="{{ route('shops.create') }}" class="btn btn-primary mb-4">
                                    {{__("main.create_new_shop")}}
                                </a>
                                @endif

                                <div class="table-responsive">
                                    <table id="shops-table"
                                           class="table table-striped table-hover table-bordered nowrap w-100">
                                        <thead>
                                        <tr>
                                            <th>{{__("main.action")}}</th>
                                            <th>{{__("main.city")}}</th>
                                            <th>{{__("main.name")}}</th>
                                            <th>{{__("main.phone")}}</th>
                                            <th>{{__("main.commission")}} %</th>
                                        </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                            @endif
                            @if(in_array(\App\Models\Gift::PERMISSION_NAME, $available_tabs))
                                <div class="tab-pane fade @if($active_tab == \App\Models\Gift::PERMISSION_NAME) show active @endif" id="pills-Gifts" role="tabpanel"
                                     aria-labelledby="pills-Gifts-tab">
                                    @if(in_array(\App\Models\Gift::PERMISSION_NAME, $write_permissions))
                                        <a id="crt-Nw-Gift" href="{{ route('gifts.create') }}" class="btn btn-primary mb-4">
                                            {{__('main.create_new_gift')}}
                                        </a>
                                    @endif

                                    <div class="table-responsive">
                                        <table id="gifts-table"
                                               class="table table-striped table-hover table-bordered nowrap w-100">
                                            <thead>
                                            <tr>
                                                <th>{{__('main.action')}}</th>
                                                <th>{{__('main.name')}}</th>
                                                <th>{{__('main.buying_price')}}</th>
                                                <th>{{__('main.selling_price')}}</th>
                                            </tr>
                                            </thead>
                                        </table>
                                    </div>
                                </div>
                            @endif
                            @if(in_array(\App\Models\TravelVisa::PERMISSION_NAME, $available_tabs))
                                <div class="tab-pane fade @if($active_tab == \App\Models\TravelVisa::PERMISSION_NAME) show active @endif" id="pills-Travel-visa" role="tabpanel"
                                     aria-labelledby="pills-Travel-visa-tab">
                                    @if(in_array(\App\Models\TravelVisa::PERMISSION_NAME, $write_permissions))
                                        <a id="crt-Nw-Travel-visa" href="{{ route('travel-visas.create') }}" class="btn btn-primary mb-4">
                                            {{__("main.create_travel_visa")}}
                                        </a>
                                    @endif

                                    <div class="table-responsive">
                                        <table id="travel-visass-table"
                                               class="table table-striped table-hover table-bordered nowrap w-100">
                                            <thead>
                                            <tr>
                                                <th>{{__("main.action")}}</th>
                                                <th>{{__("main.name")}}</th>
                                                <th>{{__("main.buying_price")}}</th>
                                                <th>{{__("main.selling_price")}}</th>
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
        @if(in_array(\App\Models\Sightseeing::PERMISSION_NAME, $available_tabs))
            var sightseeings_index_path = '{{ route('sightseeings.index') }}';
            var sightseeings_edit_path = '{{ route('sightseeings.edit', ['sightseeing'=> 'sightseeing_id']) }}';
            var sightseeings_destroy_path = '{{ route('sightseeings.destroy', ['sightseeing'=> 'sightseeing_id']) }}';
            var sightseeings_write = false;
            @if(in_array(\App\Models\Sightseeing::PERMISSION_NAME, $write_permissions))
            var sightseeings_write = true;
            @endif
        @endif
        @if(in_array(\App\Models\Router::PERMISSION_NAME, $available_tabs))
            var routers_index_path = '{{ route('routers.index') }}';
            var routers_edit_path = '{{ route('routers.edit', ['router'=> 'router_id']) }}';
            var routers_destroy_path = '{{ route('routers.destroy', ['router'=> 'router_id']) }}';
            var routers_write = false;
            @if(in_array(\App\Models\Router::PERMISSION_NAME, $write_permissions))
            var routers_write = true;
            @endif
        @endif
        @if(in_array(\App\Models\SLShow::PERMISSION_NAME, $available_tabs))
            var slshows_index_path = '{{ route('slshows.index') }}';
            var slshows_edit_path = '{{ route('slshows.edit', ['slshow'=> 'slshow_id']) }}';
            var slshows_destroy_path = '{{ route('slshows.destroy', ['slshow'=> 'slshow_id']) }}';
            var slshows_write = false;
            @if(in_array(\App\Models\SLShow::PERMISSION_NAME, $write_permissions))
            var slshows_write = true;
            @endif
        @endif
        @if(in_array(\App\Models\VBNight::PERMISSION_NAME, $available_tabs))
            var vbnights_index_path = '{{ route('vbnights.index') }}';
            var vbnights_edit_path = '{{ route('vbnights.edit', ['vbnight'=> 'vbnight_id']) }}';
            var vbnights_destroy_path = '{{ route('vbnights.destroy', ['vbnight'=> 'vbnight_id']) }}';
            var vbnights_write = false;
            @if(in_array(\App\Models\VBNight::PERMISSION_NAME, $write_permissions))
            var vbnights_write = true;
            @endif
        @endif
        @if(in_array(\App\Models\LKFriend::PERMISSION_NAME, $available_tabs))
            var lkfriends_index_path = '{{ route('lkfriends.index') }}';
            var lkfriends_edit_path = '{{ route('lkfriends.edit', ['lkfriend'=> 'lkfriend_id']) }}';
            var lkfriends_destroy_path = '{{ route('lkfriends.destroy', ['lkfriend'=> 'lkfriend_id']) }}';
            var lkfriends_write = false;
            @if(in_array(\App\Models\LKFriend::PERMISSION_NAME, $write_permissions))
            var lkfriends_write = true;
            @endif
        @endif
        @if(in_array(\App\Models\Shop::PERMISSION_NAME, $available_tabs))
            var shops_index_path = '{{ route('shops.index') }}';
            var shops_edit_path = '{{ route('shops.edit', ['shop'=> 'shop_id']) }}';
            var shops_destroy_path = '{{ route('shops.destroy', ['shop'=> 'shop_id']) }}';
            var shops_write = false;
            @if(in_array(\App\Models\Shop::PERMISSION_NAME, $write_permissions))
            var shops_write = true;
            @endif
        @endif
        @if(in_array(\App\Models\Gift::PERMISSION_NAME, $available_tabs))
            var gifts_index_path = '{{ route('gifts.index') }}';
            var gifts_edit_path = '{{ route('gifts.edit', ['gift'=> 'gift_id']) }}';
            var gifts_destroy_path = '{{ route('gifts.destroy', ['gift'=> 'gift_id']) }}';
            var gifts_write = false;
            @if(in_array(\App\Models\Gift::PERMISSION_NAME, $write_permissions))
            var gifts_write = true;
            @endif
        @endif
        @if(in_array(\App\Models\TravelVisa::PERMISSION_NAME, $available_tabs))
            var visas_index_path = '{{ route('travel-visas.index') }}';
            var visas_edit_path = '{{ route('travel-visas.edit', ['travel_visa'=> 'visa_id']) }}';
            var visas_destroy_path = '{{ route('travel-visas.destroy', ['travel_visa'=> 'visa_id']) }}';
            var visas_write = false;
            @if(in_array(\App\Models\TravelVisa::PERMISSION_NAME, $write_permissions))
            var visas_write = true;
            @endif
        @endif
    </script>
    <script src="{{asset('assets/js/services.js?ver=3.7')}}"></script>
@endsection
