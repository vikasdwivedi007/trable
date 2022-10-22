@extends('layouts.main')

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h5>{{__('main.update_invoice')}}</h5>
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

                    <div class="row">

                        <div class="col-md-3">
                            <div class="form-group">

                                <input type="text" id="Job-File-Number"
                                       class="form-control" name="draft-invoice"
                                       placeholder="{{__('main.draft_invoice_number')}}" value="Draft Invoice: {{$invoice->draft_invoice->number}}" disabled>
                            </div>
                        </div>

                        <div class="col-md-5">
                            <div class="form-group d-inline">
{{--                                <button type="submit" class="btn btn-primary " >--}}
{{--                                    Show Detials--}}
{{--                                </button>--}}
                                <button type="button" id="nvoicDetalsEdit_updated" class="btn btn-primary ">
                                    {{__('main.edit_invoice')}}
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="bg-light px-2 py-3 my-4 ">
                        <h4 class="font-weight-bold pb-3 text-uppercase">{{__('main.invoice_info')}}</h4>
                        <div class="row">
                            <div class="col-md-2">
                                <label class="text-info text-uppercase">{{__('main.invoice_no')}}</label>
                                <div id="" class="form-group">
                                    <input id="invoiceNo" type="text"
                                           class="form-control form-control-asLabel"
                                           name="validation-required" value="{{$invoice->number}}" disabled>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <label class="text-info text-uppercase">{{__('main.invoice_date')}}</label>
                                <div id="changeLabel" class="form-group">
                                    <input id="date-invoice" type="text"
                                           class="form-control form-control-asLabel"
                                           name="validation-required" value="{{$invoice->date->format('d F Y')}}"
                                           disabled>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <label class="text-info text-uppercase">{{__('main.arrival_date')}}</label>
                                <div id="" class="form-group">
                                    <input id="arrivalDate" type="text"
                                           class="form-control form-control-asLabel"
                                           name="validation-required"  value="{{$invoice->draft_invoice->job_file->arrival_date->format('d F Y')}}"
                                           disabled>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <label class="text-info text-uppercase">{{__('main.departure_date')}}</label>
                                <div id="" class="form-group">
                                    <input id="departureDate" type="text"
                                           class="form-control form-control-asLabel"
                                           name="validation-required" value="{{$invoice->draft_invoice->job_file->departure_date->format('d F Y')}}"
                                           disabled>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <label class="text-info text-uppercase">{{__('main.command_no')}}</label>
                                <div class="form-group">
                                    <input type="text"
                                           class="form-control form-control-asLabel"
                                           name="validation-required"  value="{{$invoice->draft_invoice->job_file->command_no}}"  disabled>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="bg-light px-2 py-3 my-4 ">
                        <h4 class="font-weight-bold pb-3 text-uppercase">{{__('main.destination_info')}}
                        </h4>
                        <div class="row">
                            <div class="col-md-3">
                                <label class="text-info text-uppercase">{{__('main.travel_agent')}}</label>
                                <div id="" class="form-group">
                                    <input type="text"
                                           class="form-control form-control-asLabel"
                                           name="validation-required" value="{{$invoice->draft_invoice->job_file->travel_agent->name}}"disabled>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <label class="text-info text-uppercase">{{__('main.address')}}</label>
                                <div id="" class="form-group">
                                    <input type="text"
                                           class="form-control form-control-asLabel"
                                           name="validation-required"  value="{{$invoice->draft_invoice->job_file->travel_agent->address}}" disabled>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <label class="text-info text-uppercase">{{__('main.client_name')}}</label>
                                <div class="form-group">
                                    <input type="text"
                                           class="form-control form-control-asLabel"
                                           name="validation-required"  value="{{$invoice->draft_invoice->job_file->client_name}}" disabled>
                                </div>

                            </div>
                        </div>
                    </div>

                    <div class="bg-light px-2 py-3 my-4 ">
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

                            @foreach($invoice->items as $item)
                                <div class="invoice_item">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label class="text-info text-uppercase">{{__('main.item_description')}}</label>
                                            <div  class="form-group changeLabel">
                                            <textarea class="form-control form-control-asLabel details"
                                                      name="validation-text" rows="3"
                                                      disabled>{{$item->details}}</textarea>
                                            </div>
                                        </div>
                                        {{--                                            <div class="col-md-3">--}}

                                        {{--                                            </div>--}}
                                        <div class="col-md-3">
                                            <label class="text-info text-uppercase">{{__('main.item_price')}}</label>
                                            <div  class="form-group changeLabel">
                                                <input type="text"
                                                       class="form-control form-control-asLabel price"
                                                       name="validation-required" value="{{$item->price_without_vat}}" disabled>
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
                                                            <option value="{{$key}}" @if($item->currency == $key) selected @endif>{{$value}}</option>
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
                                                       value="{{$item->vat}}%" disabled>
                                            </div>
                                        </div>
                                        <div class="col-md-3">

                                        </div>
                                        <div class="col-md-3">
                                            <label class="text-info text-uppercase">{{__('main.total_amount')}}</label>
                                            <div class="form-group">
                                                <label class="item_total">{{$item->price}}</label>
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

                    <div class="row my-4 mx-1">
                        <div class="col-md-6 ">
                            <div
                                class="form-group d-inline font-weight-bolder text-info text-uppercase">
                                {{__('main.status')}}:
                            </div>
                            <div class="form-group d-inline">
                                <div class="radio radio-primary d-inline">
                                    <input type="radio" name="Status" id="radio-p-fill-5"
                                           @if($invoice->status == 1) checked @endif value="1">
                                    <label for="radio-p-fill-5" class="cr">{{__('main.paid')}}</label>
                                </div>
                            </div>
                            <div class="form-group d-inline">
                                <div class="radio radio-primary d-inline">
                                    <input type="radio" name="Status" id="radio-p-fill-6" value="0" @if($invoice->status == 0) checked @endif>
                                    <label for="radio-p-fill-6" class="cr">{{__('main.unpaid')}}</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <button type="button" class="btn btn-primary" id="saveInvoice" onclick="saveInvoice('{{route("invoices.update", ['invoice'=>$invoice->id])}}', 'PATCH');return false;"  >{{__('main.update')}}</button>
                    <button type="button"  onclick="window.location.href='{{route('invoices.index')}}';" class="btn btn-outline-primary">{{__('main.cancel')}}</button>

                </div>
            </div>

        </div>
    </div>
@endsection
@section('script_bottom')
    <script src="{{asset('assets/js/invoices.js?ver=1.3')}}"></script>
    <script>
        var draft_invoice_id = {{$invoice->draft_invoice_id}};
        var currencies = "@php echo addslashes(json_encode(\App\Models\Currency::availableCurrencies())) @endphp";
        currencies = JSON.parse(currencies);
        var calculateTotalOnLoad = false;
        confirm_btn_text = '{{__('main.confirm')}}';
        cancel_btn_text = '{{__('main.cancel')}}';
        are_you_sure_text = '{{__('main.are_you_sure')}}';
    </script>
@endsection
