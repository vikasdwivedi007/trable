@extends('layouts.main')

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h5>{{__('main.create_new_draft_invoice')}}</h5>
                    <div class="card-header-right">
                        <div class="btn-group card-option">
                            <button type="button" class="btn dropdown-toggle btn-icon"
                                    data-toggle="dropdown" aria-haspopup="true"
                                    aria-expanded="false">
                                <i class="feather icon-more-horizontal"></i>
                            </button>
                            <ul
                                class="list-unstyled card-option dropdown-menu dropdown-menu-right">
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
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="card-block">
                    <form id="validation-form123" action="#!">
                        <div class="bg-light px-2 py-3 my-4">
                            <div class="row">
                                <div class="col-md-6">
                                    <h4 class="font-weight-bold pb-3 text-uppercase">
                                        {{__('main.draft_invoice_info')}}
                                    </h4>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group float-right pr-4">
                                        <a href="#" id="nvoicDetalsEdit_updated">
                                            <i class="mdi mdi-square-edit-outline"></i>
                                            {{__('main.edit_draft_invoice')}}
                                        </a>
                                        <a href="#" class="d-none" id="nvoicDetalsShow_updated">
                                            <i class="mdi mdi-check-outline"></i>
                                            {{__('main.done_editing')}}
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
{{--                                <div class="col-md-2">--}}
{{--                                    <label class="text-info text-uppercase">Draft Invoice No.</label>--}}
{{--                                    <div class="form-group">--}}
{{--                                        <input id="invoiceNo" type="text"--}}
{{--                                               class="form-control form-control-asLabel"--}}
{{--                                               name="validation-required" value="" disabled>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
                                <div class="col-md-2">
                                    <label class="text-info text-uppercase">{{__('main.request_on_month')}}</label>
                                    <div class="form-group">
                                        <input id="Request-Month" type="text"
                                               class="form-control form-control-asLabel"
                                               name="validation-required" value="{{$job_file->request_date->format('M Y')}}"
                                               disabled>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <label class="text-info text-uppercase">{{__('main.client_name')}}</label>
                                    <div class="form-group">
                                        <input id="ClientName" type="text"
                                               class="form-control form-control-asLabel"
                                               name="validation-required" value="{{$job_file->client_name}}"
                                               disabled>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <label class="text-info text-uppercase">{{__('main.number_of_adults')}}</label>
                                    <div class="form-group">
                                        <input id="NoAdults" type="text"
                                               class="form-control form-control-asLabel"
                                               name="validation-required" value="{{$job_file->adults_count}}"
                                               disabled>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <label class="text-info text-uppercase">{{__('main.number_of_children')}}</label>
                                    <div class="form-group">
                                        <input id="NoChildren" type="text"
                                               class="form-control form-control-asLabel"
                                               name="validation-required" value="{{$job_file->children_count}}"
                                               disabled>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="bg-light px-2 py-3 my-4">
                            <h4 class="font-weight-bold pb-3 text-uppercase">{{__('main.destination_info')}}
                            </h4>
                            <div class="row">
                                <div class="col-md-3">
                                    <label class="text-info text-uppercase">{{__('main.travel_agent')}}</label>
                                    <div class="form-group">
                                        <input type="text"
                                               class="form-control form-control-asLabel"
                                               name="validation-required" value="{{$job_file->travel_agent->name}}" disabled>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                </div>
                                <div class="col-md-3">
                                    <label class="text-info text-uppercase">{{__('main.address')}}</label>
                                    <div class="form-group">
                                        <input type="text"
                                               class="form-control form-control-asLabel"
                                               name="validation-required" value="{{$job_file->travel_agent->address}}" disabled>
                                    </div>
                                </div>
                                <div class="col-md-3"></div>
                            </div>
                        </div>

                        <div class="bg-light px-2 py-3 my-4">
                            <div class="row">
                                <div class="col-md-6">
                                    <h4 class="font-weight-bold pb-3 text-uppercase">
                                        {{__('main.items_details')}}
                                    </h4>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group float-right pr-4">
                                        <a href="#" onclick="addNewItem_updated();return false;">
                                            + {{__('main.add_new_item')}}
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <div id="NewItemAdded" >
                                <div class="invoice_item d-none">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label class="text-info text-uppercase">{{__('main.item_description')}}</label>
                                            <div class="form-group changeLabel">
                                                <textarea class="form-control form-control-asLabel details"
                                                          name="validation-text" rows="3"
                                                          disabled></textarea>
                                            </div>
                                        </div>
{{--                                        <div class="col-md-3">--}}

{{--                                        </div>--}}
                                        <div class="col-md-3">
                                            <label class="text-info text-uppercase">{{__('main.item_price')}}</label>
                                            <div class="form-group changeLabel">
                                                <input type="text"
                                                       class="form-control form-control-asLabel price"
                                                       name="validation-required" value="" disabled>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <label class="text-info text-uppercase">{{__('main.currency')}}</label>
                                            <div class="form-group">
                                                <div class="form-group changeLabel">
                                                    <select disabled
                                                            class="js-example-tags form-control currency"
                                                            name="buy_price_currency" required>
                                                        @foreach(\App\Models\Currency::availableCurrencies() as $key => $value)
                                                            <option value="{{$key}}">{{$value}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-1"></div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label class="text-info text-uppercase">{{__('main.vat')}}</label>
                                            <div class="form-group changeLabel ">
                                                <input type="text"
                                                       class="form-control form-control-asLabel vat"
                                                       value="14%" disabled>
                                            </div>
                                        </div>
{{--                                        <div class="col-md-3">--}}

{{--                                        </div>--}}
                                        <div class="col-md-3">
                                            <label class="text-info text-uppercase">{{__('main.total_amount')}}</label>
                                            <div class="form-group">
                                                <label class="item_total"></label>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <a href="#" onclick="$(this).closest('.invoice_item').remove();calculateTotal();return false;">
                                                - {{__('main.remove_item')}}
                                            </a>
                                        </div>
                                    </div>
                                    <hr>
                                </div>

                                @if($job_file->job_router)
                                    <div class="invoice_item">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label class="text-info text-uppercase">{{__('main.item_description')}}</label>
                                                <div class="form-group changeLabel ">
                                                    <textarea class="form-control form-control-asLabel details"
                                                              name="validation-text" rows="3"
                                                              disabled>Router number: {{$job_file->job_router->router->number}}</textarea>
                                                </div>
                                            </div>
{{--                                            <div class="col-md-3">--}}

{{--                                            </div>--}}
                                            <div class="col-md-3">
                                                <label class="text-info text-uppercase">{{__('main.item_price')}}</label>
                                                <div class="form-group changeLabel ">
                                                    <input type="text"
                                                           class="form-control form-control-asLabel price"
                                                           name="validation-required" value="{{$job_file->job_router->router->package_sell_price_vat_exc}}" disabled>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <label class="text-info text-uppercase">{{__('main.currency')}}</label>
                                                <div class="form-group">
                                                    <div class="form-group changeLabel">
                                                        <select disabled
                                                                class="js-example-tags form-control currency"
                                                                name="buy_price_currency" required>
                                                            @foreach(\App\Models\Currency::availableCurrencies() as $key => $value)
                                                                <option value="{{$key}}" @if($job_file->job_router->router->package_sell_currency == $key) selected @endif>{{$value}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-1"></div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-3">
                                                <label class="text-info text-uppercase">{{__('main.vat')}}</label>
                                                <div  class="form-group changeLabel">
                                                    <input type="text"
                                                           class="form-control form-control-asLabel vat"
                                                           value="14%" disabled>
                                                </div>
                                            </div>
                                            <div class="col-md-3">

                                            </div>
                                            <div class="col-md-3">
                                                <label class="text-info text-uppercase">{{__('main.total_amount')}}</label>
                                                <div class="form-group">
                                                    <label class="item_total"></label>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <a href="#" onclick="$(this).closest('.invoice_item').remove();calculateTotal();return false;">
                                                    - {{__('main.remove_item')}}
                                                </a>
                                            </div>
                                        </div>
                                        <hr>
                                    </div>
                                @endif

                                @foreach($job_file->job_gifts as $job_gift)
                                    <div class="invoice_item">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label class="text-info text-uppercase">{{__('main.item_description')}}</label>
                                                <div  class="form-group changeLabel">
                                                    <textarea class="form-control form-control-asLabel details"
                                                              name="validation-text" rows="3"
                                                              disabled>Gift: {{$job_gift->gift->name}}</textarea>
                                                </div>
                                            </div>
                                            {{--                                            <div class="col-md-3">--}}

                                            {{--                                            </div>--}}
                                            <div class="col-md-3">
                                                <label class="text-info text-uppercase">{{__('main.item_price')}}</label>
                                                <div  class="form-group changeLabel">
                                                    <input type="text"
                                                           class="form-control form-control-asLabel price"
                                                           name="validation-required" value="{{$job_gift->gift->sell_price}}" disabled>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <label class="text-info text-uppercase">{{__('main.currency')}}</label>
                                                <div class="form-group">
                                                    <div class="form-group changeLabel">
                                                        <select disabled
                                                                class="js-example-tags form-control currency"
                                                                name="buy_price_currency" required>
                                                            @foreach(\App\Models\Currency::availableCurrencies() as $key => $value)
                                                                <option value="{{$key}}" @if($job_gift->gift->sell_currency == $key) selected @endif>{{$value}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-1"></div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-3">
                                                <label class="text-info text-uppercase">{{__('main.vat')}}</label>
                                                <div  class="form-group changeLabel">
                                                    <input type="text"
                                                           class="form-control form-control-asLabel vat"
                                                           value="14%" disabled>
                                                </div>
                                            </div>
                                            <div class="col-md-3">

                                            </div>
                                            <div class="col-md-3">
                                                <label class="text-info text-uppercase">{{__('main.total_amount')}}</label>
                                                <div class="form-group">
                                                    <label class="item_total"></label>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <a href="#" onclick="$(this).closest('.invoice_item').remove();calculateTotal();return false;">
                                                    - {{__('main.remove_item')}}
                                                </a>
                                            </div>
                                        </div>
                                        <hr>
                                    </div>
                                @endforeach

                                @if($job_file->job_visa)
                                    <div class="invoice_item">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label class="text-info text-uppercase">{{__('main.item_description')}}</label>
                                                <div  class="form-group changeLabel">
                                                    <textarea class="form-control form-control-asLabel details"
                                                              name="validation-text" rows="3"
                                                              disabled>Visa: {{$job_file->job_visa->visa->name}}</textarea>
                                                </div>
                                            </div>
                                            {{--                                            <div class="col-md-3">--}}

                                            {{--                                            </div>--}}
                                            <div class="col-md-3">
                                                <label class="text-info text-uppercase">{{__('main.item_price')}}</label>
                                                <div  class="form-group changeLabel">
                                                    <input type="text"
                                                           class="form-control form-control-asLabel price"
                                                           name="validation-required" value="{{$job_file->job_visa->visa->sell_price}}" disabled>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <label class="text-info text-uppercase">{{__('main.currency')}}</label>
                                                <div class="form-group changeLabel">
                                                    <div class="form-group">
                                                        <select disabled
                                                                class="js-example-tags form-control currency"
                                                                name="buy_price_currency" required>
                                                            @foreach(\App\Models\Currency::availableCurrencies() as $key => $value)
                                                                <option value="{{$key}}" @if($job_file->job_visa->visa->sell_currency == $key) selected @endif>{{$value}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-1"></div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-3">
                                                <label class="text-info text-uppercase">{{__('main.vat')}}</label>
                                                <div  class="form-group changeLabel">
                                                    <input type="text"
                                                           class="form-control form-control-asLabel vat"
                                                           value="14%" disabled>
                                                </div>
                                            </div>
                                            <div class="col-md-3">

                                            </div>
                                            <div class="col-md-3">
                                                <label class="text-info text-uppercase">{{__('main.total_amount')}}</label>
                                                <div class="form-group">
                                                    <label class="item_total"></label>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <a href="#" onclick="$(this).closest('.invoice_item').remove();calculateTotal();return false;">
                                                    - {{__('main.remove_item')}}
                                                </a>
                                            </div>
                                        </div>
                                        <hr>
                                    </div>
                                @endif

                                @foreach($job_file->accommodations as $accommodation)
                                    <div class="invoice_item">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label class="text-info text-uppercase">{{__('main.item_description')}}</label>
                                                <div  class="form-group changeLabel">
                                                    <textarea class="form-control form-control-asLabel details"
                                                              name="validation-text" rows="3"
                                                              disabled>Room: {{$accommodation->hotel->name}} - {{$accommodation->category}} - {{App\Models\Room::room_types($accommodation->room_type)}} - {{App\Models\Room::meal_plans($accommodation->meal_plan)}} - {{$accommodation->view}}</textarea>
                                                </div>
                                            </div>
                                            {{--                                            <div class="col-md-3">--}}

                                            {{--                                            </div>--}}
                                            <div class="col-md-3">
                                                <label class="text-info text-uppercase">{{__('main.item_price')}}</label>
                                                <div  class="form-group changeLabel">
                                                    <input type="text"
                                                           class="form-control form-control-asLabel price"
                                                           name="validation-required" @if($accommodation->room) value="{{$accommodation->check_in->diffInDays($accommodation->check_out) * $accommodation->room->details->base_rate}}" @endif disabled>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <label class="text-info text-uppercase">{{__('main.currency')}}</label>
                                                <div class="form-group">
                                                    <div class="form-group changeLabel">
                                                        <select disabled
                                                                class="js-example-tags form-control currency"
                                                                name="buy_price_currency" required>
                                                            @foreach(\App\Models\Currency::availableCurrencies() as $key => $value)
                                                                <option value="{{$key}}" @if($accommodation->room && $key == $accommodation->room->details->base_rate_currency) selected @endif >{{$value}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-1"></div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-3">
                                                <label class="text-info text-uppercase">{{__('main.vat')}}</label>
                                                <div  class="form-group changeLabel">
                                                    <input type="text"
                                                           class="form-control form-control-asLabel vat"
                                                           value="14%" disabled>
                                                </div>
                                            </div>
                                            <div class="col-md-3">

                                            </div>
                                            <div class="col-md-3">
                                                <label class="text-info text-uppercase">{{__('main.total_amount')}}</label>
                                                <div class="form-group">
                                                    <label class="item_total"></label>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <a href="#" onclick="$(this).closest('.invoice_item').remove();calculateTotal();return false;">
                                                    - {{__('main.remove_item')}}
                                                </a>
                                            </div>
                                        </div>
                                        <hr>
                                    </div>
                                @endforeach

                                @foreach($job_file->train_tickets as $job_train)
                                    <div class="invoice_item">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label class="text-info text-uppercase">{{__('main.item_description')}}</label>
                                                <div  class="form-group changeLabel">
                                                    <textarea class="form-control form-control-asLabel details"
                                                              name="validation-text" rows="3"
                                                              disabled>Train ticket: {{$job_train->train_ticket->number}} - {{$job_train->train_ticket->class == 1 ? "First Class" : "Second Class"}} - from {{$job_train->train_ticket->from_station->name}} to {{$job_train->train_ticket->to_station->name}}</textarea>
                                                </div>
                                            </div>

                                            <div class="col-md-3">
                                                <label class="text-info text-uppercase">{{__('main.item_price')}}</label>
                                                <div  class="form-group changeLabel">
                                                    <input type="text"
                                                           class="form-control form-control-asLabel price"
                                                           name="validation-required" value="{{$job_train->train_ticket->sgl_sell_price}}" disabled>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <label class="text-info text-uppercase">{{__('main.currency')}}</label>
                                                <div class="form-group">
                                                    <div class="form-group changeLabel">
                                                        <select disabled
                                                                class="js-example-tags form-control currency"
                                                                name="buy_price_currency" required>
                                                            @foreach(\App\Models\Currency::availableCurrencies() as $key => $value)
                                                                <option value="{{$key}}" @if($job_train->train_ticket->sgl_sell_currency == $key) selected @endif>{{$value}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-1"></div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-3">
                                                <label class="text-info text-uppercase">{{__('main.vat')}}</label>
                                                <div  class="form-group changeLabel">
                                                    <input type="text"
                                                           class="form-control form-control-asLabel vat"
                                                           value="14%" disabled>
                                                </div>
                                            </div>
                                            <div class="col-md-3">

                                            </div>
                                            <div class="col-md-3">
                                                <label class="text-info text-uppercase">{{__('main.total_amount')}}</label>
                                                <div class="form-group">
                                                    <label class="item_total"></label>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <a href="#" onclick="$(this).closest('.invoice_item').remove();calculateTotal();return false;">
                                                    - {{__('main.remove_item')}}
                                                </a>
                                            </div>
                                        </div>
                                        <hr>
                                    </div>
                                @endforeach

                                @foreach($job_file->nile_cruises as $job_cruise)
                                    @foreach($job_cruise->cabins as $cabin)
                                    <div class="invoice_item">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label class="text-info text-uppercase">{{__('main.item_description')}}</label>
                                                <div  class="form-group changeLabel">
                                                    <textarea class="form-control form-control-asLabel details"
                                                              name="validation-text" rows="3"
                                                              disabled>Nile Cruise: {{$job_cruise->nile_cruise->name}} - from {{$job_cruise->nile_cruise->from_city->name}} to {{$job_cruise->nile_cruise->to_city->name}}. Cabin: {{$cabin->calculatePrice()[0]}}
                                                    </textarea>
                                                </div>
                                            </div>

                                            <div class="col-md-3">
                                                <label class="text-info text-uppercase">{{__('main.item_price')}}</label>
                                                <div  class="form-group changeLabel">
                                                    <input type="text"
                                                           class="form-control form-control-asLabel price"
                                                           name="validation-required" value="{{$cabin->calculatePrice()[1]}}" disabled>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <label class="text-info text-uppercase">{{__('main.currency')}}</label>
                                                <div class="form-group">
                                                    <div class="form-group changeLabel">
                                                        <select disabled
                                                                class="js-example-tags form-control currency"
                                                                name="buy_price_currency" required>
                                                            @foreach(\App\Models\Currency::availableCurrencies() as $key => $value)
                                                                <option value="{{$key}}" @if($cabin->calculatePrice()[2] == $value) selected @endif>{{$value}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-1"></div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-3">
                                                <label class="text-info text-uppercase">{{__('main.vat')}}</label>
                                                <div  class="form-group changeLabel">
                                                    <input type="text"
                                                           class="form-control form-control-asLabel vat"
                                                           value="14%" disabled>
                                                </div>
                                            </div>
                                            <div class="col-md-3">

                                            </div>
                                            <div class="col-md-3">
                                                <label class="text-info text-uppercase">{{__('main.total_amount')}}</label>
                                                <div class="form-group">
                                                    <label class="item_total"></label>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <a href="#" onclick="$(this).closest('.invoice_item').remove();calculateTotal();return false;">
                                                    - {{__('main.remove_item')}}
                                                </a>
                                            </div>
                                        </div>
                                        <hr>
                                    </div>
                                    @endforeach
                                @endforeach

                                @foreach($job_file->flights as $job_flight)
                                    <div class="invoice_item">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label class="text-info text-uppercase">{{__('main.item_description')}}</label>
                                                <div  class="form-group changeLabel">
                                                    <textarea class="form-control form-control-asLabel details"
                                                              name="validation-text" rows="3"
                                                              disabled>{{ucfirst($job_flight->type)}} Flight: {{$job_flight->flight->number}}, from {{$job_flight->flight->airport_from->format()['text']}} to {{$job_flight->flight->airport_to->format()['text']}}</textarea>
                                                </div>
                                            </div>

                                            <div class="col-md-3">
                                                <label class="text-info text-uppercase">{{__('main.item_price')}}</label>
                                                <div  class="form-group changeLabel">
                                                    <input type="text"
                                                           class="form-control form-control-asLabel price"
                                                           name="validation-required" value="{{$job_flight->flight->sell_price_vat_exc}}" disabled>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <label class="text-info text-uppercase">{{__('main.currency')}}</label>
                                                <div class="form-group">
                                                    <div class="form-group changeLabel">
                                                        <select disabled
                                                                class="js-example-tags form-control currency"
                                                                name="buy_price_currency" required>
                                                            @foreach(\App\Models\Currency::availableCurrencies() as $key => $value)
                                                                <option value="{{$key}}" @if($job_flight->flight->sell_price_vat_exc_currency == $key) selected @endif>{{$value}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-1"></div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-3">
                                                <label class="text-info text-uppercase">{{__('main.vat')}}</label>
                                                <div  class="form-group changeLabel">
                                                    <input type="text"
                                                           class="form-control form-control-asLabel vat"
                                                           value="14%" disabled>
                                                </div>
                                            </div>
                                            <div class="col-md-3">

                                            </div>
                                            <div class="col-md-3">
                                                <label class="text-info text-uppercase">{{__('main.total_amount')}}</label>
                                                <div class="form-group">
                                                    <label class="item_total"></label>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <a href="#" onclick="$(this).closest('.invoice_item').remove();calculateTotal();return false;">
                                                    - {{__('main.remove_item')}}
                                                </a>
                                            </div>
                                        </div>
                                        <hr>
                                    </div>
                                @endforeach

                                @foreach($job_file->guides as $job_guide)
                                    <div class="invoice_item">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label class="text-info text-uppercase">{{__('main.item_description')}}</label>
                                                <div  class="form-group changeLabel">
                                                    <textarea class="form-control form-control-asLabel details"
                                                              name="validation-text" rows="3"
                                                              disabled>Guide: {{$job_guide->guide->name}} at {{$job_guide->sightseeing->name}}</textarea>
                                                </div>
                                            </div>

                                            <div class="col-md-3">
                                                <label class="text-info text-uppercase">{{__('main.item_price')}}</label>
                                                <div  class="form-group changeLabel">
                                                    <input type="text"
                                                           class="form-control form-control-asLabel price"
                                                           name="validation-required" value="" disabled>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <label class="text-info text-uppercase">{{__('main.currency')}}</label>
                                                <div class="form-group">
                                                    <div class="form-group changeLabel">
                                                        <select disabled
                                                                class="js-example-tags form-control currency"
                                                                name="buy_price_currency" required>
                                                            @foreach(\App\Models\Currency::availableCurrencies() as $key => $value)
                                                                <option value="{{$key}}" @if($loop->first) selected @endif>{{$value}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-1"></div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-3">
                                                <label class="text-info text-uppercase">{{__('main.vat')}}</label>
                                                <div  class="form-group changeLabel">
                                                    <input type="text"
                                                           class="form-control form-control-asLabel vat"
                                                           value="14%" disabled>
                                                </div>
                                            </div>
                                            <div class="col-md-3">

                                            </div>
                                            <div class="col-md-3">
                                                <label class="text-info text-uppercase">{{__('main.total_amount')}}</label>
                                                <div class="form-group">
                                                    <label class="item_total"></label>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <a href="#" onclick="$(this).closest('.invoice_item').remove();calculateTotal();return false;">
                                                    - {{__('main.remove_item')}}
                                                </a>
                                            </div>
                                        </div>
                                        <hr>
                                    </div>
                                @endforeach

                                @foreach($job_file->programs as $program)
                                    @foreach($program->items as $item)
                                    <div class="invoice_item">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label class="text-info text-uppercase">{{__('main.item_description')}}</label>
                                                <div  class="form-group changeLabel">
                                                    <textarea class="form-control form-control-asLabel details"
                                                              name="validation-text" rows="3"
                                                              disabled>{{$item->name}}</textarea>
                                                </div>
                                            </div>

                                            <div class="col-md-3">
                                                <label class="text-info text-uppercase">{{__('main.item_price')}}</label>
                                                <div  class="form-group changeLabel">
                                                    <input type="text"
                                                           class="form-control form-control-asLabel price"
                                                           name="validation-required" value="{{$item->program_itemable->sell_price_adult_vat_exc}}" disabled>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <label class="text-info text-uppercase">{{__('main.currency')}}</label>
                                                <div class="form-group">
                                                    <div class="form-group changeLabel">
                                                        <select disabled
                                                                class="js-example-tags form-control currency"
                                                                name="buy_price_currency" required>
                                                            @foreach(\App\Models\Currency::availableCurrencies() as $key => $value)
                                                                <option value="{{$key}}"
                                                                    @if($item->program_itemable_type == \App\Models\Sightseeing::class)
                                                                        @if($item->program_itemable->sell_price_adult_currency == $key) selected @endif
                                                                    @elseif($item->program_itemable_type == \App\Models\VBNight::class)
                                                                        @if($item->program_itemable->adult_sell_currency == $key) selected @endif
                                                                    @elseif($item->program_itemable_type == \App\Models\SLShow::class)
                                                                        @if($item->program_itemable->adult_sell_currency == $key) selected @endif
                                                                    @endif
                                                                >{{$value}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-1"></div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-3">
                                                <label class="text-info text-uppercase">{{__('main.vat')}}</label>
                                                <div  class="form-group changeLabel">
                                                    <input type="text"
                                                           class="form-control form-control-asLabel vat"
                                                           value="14%" disabled>
                                                </div>
                                            </div>
                                            <div class="col-md-3">

                                            </div>
                                            <div class="col-md-3">
                                                <label class="text-info text-uppercase">{{__('main.total_amount')}}</label>
                                                <div class="form-group">
                                                    <label class="item_total"></label>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <a href="#" onclick="$(this).closest('.invoice_item').remove();calculateTotal();return false;">
                                                    - {{__('main.remove_item')}}
                                                </a>
                                            </div>
                                        </div>
                                        <hr>
                                    </div>
                                    @endforeach
                                @endforeach
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group float-right pr-4">
                                        <a href="#" onclick="addNewItem_updated();return false;">
                                            + {{__('main.add_new_item')}}
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="bg-light px-2 py-3 my-4">
                            <h4 class="font-weight-bold pb-3 text-uppercase">
                                {{__('main.total')}}
                            </h4>
                            <div class="row">
                                <div class="col-md-3">
                                    <label class="font-weight-bold text-info text-uppercase">{{__('main.total_without_vat')}}</label>
                                </div>
                                <div class="col-md-3"></div>
                                <div class="col-md-3"></div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <input type="text" id="total_without_vat"
                                               class="form-control form-control-asLabel"
                                               name="validation-required" value="" disabled>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    <label class="font-weight-bold text-info text-uppercase">{{__('main.vat')}}</label>
                                </div>
                                <div class="col-md-3"></div>
                                <div class="col-md-3"></div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <input type="text" id="total_vat"
                                               class="form-control form-control-asLabel"
                                               name="validation-required" value="" disabled>
                                    </div>
                                </div>

                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-md-3">
                                    <label class="font-weight-bold text-info text-uppercase">{{__('main.total')}}</label>
                                </div>
                                <div class="col-md-3"></div>
                                <div class="col-md-3"></div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <input type="text" id="total"
                                               class="form-control form-control-asLabel font-weight-bold"
                                               name="validation-required" value="" disabled>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <button type="submit" id="saveInvoice" onclick="saveDraftInvoice('{{route("draft-invoices.store")}}', 'POST');return false;" class="btn btn-primary">{{__('main.create')}}</button>
                        <button type="button"  onclick="window.location.href='{{route('job-files.edit', ['job_file'=>$job_file->id])}}';" class="btn btn-outline-primary">{{__('main.cancel')}}</button>
                    </form>

                </div>
            </div>

        </div>
    </div>
@endsection
@section('script_bottom')
    <script src="{{asset('assets/js/invoices.js?ver=1.3')}}"></script>
    <script>
        var job_id = {{$job_file->id}};
        var currencies = "@php echo addslashes(json_encode(\App\Models\Currency::availableCurrencies())) @endphp";
        currencies = JSON.parse(currencies);
        var calculateTotalOnLoad = true;
        confirm_btn_text = '{{__('main.confirm')}}';
        cancel_btn_text = '{{__('main.cancel')}}';
        are_you_sure_text = '{{__('main.are_you_sure')}}';
    </script>
@endsection
