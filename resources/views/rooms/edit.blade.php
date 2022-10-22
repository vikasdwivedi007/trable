@extends('layouts.main')

@section('script_top')
    <style>
        .cancel-item{
            display: contents;
        }
    </style>
@endsection

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h5>{{__("main.update_room")}}</h5>
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
                    <form id="validation-form123" action="{{ route('rooms.update', ['room'=>$room->id]) }}" method="POST">
                        @method('PATCH')
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{__('main.hotel')}}</label>
                                    <select id="HotelListDDL" class="js-example-tags form-control @error('hotel_id') is-invalid @enderror" name="hotel_id" required>
                                        <option value="">{{__("main.hotel")}}</option>
                                        @foreach($hotels as $hotel)
                                            <option value="{{$hotel->id}}" @if($hotel->id == $room->hotel_id) selected @endif>{{$hotel->name}}</option>
                                        @endforeach
                                    </select>
                                    @error('hotel_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-3">
                                <label>{{__('main.price_valid_from')}}</label>
                                <input type="text" id="date-Valid-From" class="form-control @error('price_valid_from') is-invalid @enderror"
                                      name="price_valid_from" required value="{{$room->details->toArray()['price_valid_from']}}"
                                      placeholder="{{__("main.price_valid_from")}}">
                                @error('price_valid_from')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror

                            </div>
                            <div class="col-md-3">
                                <label>{{__('main.price_valid_to')}}</label>
                                <input type="text" id="date-Valid-To" class="form-control @error('price_valid_to') is-invalid @enderror" 
                                      name="price_valid_to" required value="{{$room->details->toArray()['price_valid_to']}}" 
                                      placeholder="{{__("main.price_valid_to")}}">
                                @error('price_valid_to')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror

                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{__('main.room_category')}}</label>
                                    <input type="text" id="Room-Name" class="form-control @error('name') is-invalid @enderror" name="name"  required value="{{$room->name}}"
                                           placeholder="{{__("main.room_category")}}">
                                    @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">

                                <div id="CustodianName">
                                </div>

                                <div id="hid-shw" class="form-group">
                                    <label>{{__('main.room_view')}}</label>

                                    <select id="RoomCategDDL" class="js-example-tags form-control @error('view') is-invalid @enderror" name="view" required>
                                        <option value="">{{__("main.room_view")}}</option>
                                        <option value="-1">
                                            {{__("main.add_view")}}
                                        </option>
                                        <option value="Garden View" @if($room->view == 'Garden View') selected @endif>Garden View</option>
                                        <option value="Nile View" @if($room->view == 'Nile View') selected @endif>Nile View</option>
                                        <option value="Pool View" @if($room->view == 'Pool View') selected @endif>Pool View</option>
                                        <option value="Pyramids View" @if($room->view == 'Pyramids View') selected @endif>Prymids View</option>
                                    </select>
                                    @error('view')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <div class="form-group pt-4">
                                        <h5>{{__("main.type_of_room")}}</h5>
                                    </div>
                                    <div class="form-group">
                                        <div class="radio radio-primary d-inline">
                                            <input type="radio" name="type" id="radio-SGL" value="1" class="@error('type') is-invalid @enderror" required @if($room->type == 1) checked="" @endif>
                                            <label for="radio-SGL" class="cr">Single</label>
                                            @error('type')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="radio radio-primary d-inline">
                                            <input type="radio" name="type" id="radio-DBL" value="2" @if($room->type == 2) checked="" @endif>
                                            <label for="radio-DBL" class="cr">Double</label>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="radio radio-primary d-inline">
                                            <input type="radio" name="type" id="radio-TRPL" value="3" @if($room->type == 3) checked="" @endif>
                                            <label for="radio-TRPL" class="cr">Triple</label>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="radio radio-primary d-inline">
                                            <input type="radio" name="type" id="radio-Quad" value="4" @if($room->type == 4) checked="" @endif>
                                            <label for="radio-Quad" class="cr">Quad</label>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="radio radio-primary d-inline">
                                            <input type="radio" name="type" id="radio-King" value="6" @if($room->type == 6) checked="" @endif>
                                            <label for="radio-King" class="cr">King</label>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="radio radio-primary d-inline">
                                            <input type="radio" name="type" id="radio-Twin" value="7" @if($room->type == 7) checked="" @endif>
                                            <label for="radio-Twin" class="cr">Twin</label>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="radio radio-primary d-inline">
                                            <input type="radio" name="type" id="radio-Suite" value="8" @if($room->type == 8) checked="" @endif>
                                            <label for="radio-Suite" class="cr">Suite</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <div class="form-group pt-4">
                                        <h5>{{__("main.meal_plan")}}</h5>
                                    </div>
                                    <div class="form-group">
                                        <div class="radio radio-primary d-inline">
                                            <input type="radio" name="meal_plan" id="radio-BB" value="1" class="@error('meal_plan') is-invalid @enderror" required @if($room->meal_plan == 1) checked="" @endif>
                                            <label for="radio-BB" class="cr">BB</label>
                                            @error('meal_plan')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="radio radio-primary d-inline">
                                            <input type="radio" name="meal_plan" id="radio-HB" value="2" @if($room->meal_plan == 2) checked="" @endif>
                                            <label for="radio-HB" class="cr">HB</label>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="radio radio-primary d-inline">
                                            <input type="radio" name="meal_plan" id="radio-FB" value="3" @if($room->meal_plan == 3) checked="" @endif>
                                            <label for="radio-FB" class="cr">FB</label>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="radio radio-primary d-inline">
                                            <input type="radio" name="meal_plan" id="radio-AI" value="4" @if($room->meal_plan == 4) checked="" @endif>
                                            <label for="radio-AI" class="cr">AI</label>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div class="col-md-6">
                                <label>{{__('main.room_info')}}</label>
                                <textarea placeholder="{{__("main.room_info")}}" class="form-control @error('info') is-invalid @enderror" rows="10" name="info">{{$room->info}}</textarea>
                                @error('info')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-md-3">
                                <label>{{__('main.room_base_rate')}}</label>
                                <input type="text" id="Room-Base-Rate" class="form-control autonumber @error('base_rate') is-invalid @enderror" value="{{$room->details->toArray()['base_rate']}}"
                                       name="base_rate"
                                       placeholder="{{__("main.room_base_rate")}}" required >
                                @error('base_rate')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror

                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <div class="form-group">
                                        <label>{{__('main.currency')}}</label>
                                        <select id="CurrenciesDDL"
                                                class="js-example-tags form-control @error('base_rate_currency') is-invalid @enderror"
                                                name="base_rate_currency" required>
                                            @foreach(\App\Models\Currency::availableCurrencies() as $key => $value)
                                                <option value="{{$key}}" @if($room->details->toArray()['base_rate_currency'] == $key) selected @endif>{{$value}}</option>
                                            @endforeach
                                        </select>
                                        @error('base_rate_currency')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3"></div>
                            <div class="col-md-3"></div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <h5 class="my-4">{{__("main.discount_room_select_discount_type")}}</h5>
                            </div>
                            <div class="col-md-3 pt-2">
                                <div class="form-group">
                                    <div class="radio radio-primary d-inline">
                                        <input type="radio" name="discount_type" id="radio-Amount" value="2" class="@error('discount_type') is-invalid @enderror" @if(!$room->discount || $room->discount->type == 2) checked="" @endif>
                                        <label for="radio-Amount" class="cr">{{__("main.amount")}}</label>
                                        @error('discount_type')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>

                                    <input type="text" id="discount-Amount" class="form-control autonumber @error('discount_value') is-invalid @enderror"
                                           name="discount_value_amount" @if($room->discount && $room->discount->type == 2) value="{{$room->discount->value}}" @endif @if($room->discount && $room->discount->type == 1) disabled @endif>
                                    @error('discount_value')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-3 pt-2">
                                <div class="form-group">
                                    <div class="radio radio-primary d-inline">
                                        <input type="radio" name="discount_type" id="radio-Precentage" value="1" class="@error('discount_type') is-invalid @enderror" @if($room->discount && $room->discount->type == 1) checked="" @endif>
                                        <label for="radio-Precentage" class="cr">{{__("main.percentage")}}</label>
                                        @error('discount_type')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>

                                    <input type="text" id="discount-precentage" class="form-control autonumber @error('discount_value') is-invalid @enderror"
                                           name="discount_value_perc"  data-a-sign="% " @if($room->discount && $room->discount->type == 1 ) value="{{$room->discount->value}}" @endif @if(!$room->discount || $room->discount->type == 2) disabled @endif>
                                    @error('discount_value')
                                    <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <h5 class="my-4">{{__("main.room_rate_after_discount")}}</h5>
                                    <label>
                                        (Automated Calculated)
                                    </label>
                                    <input type="text" id="Amount-after-discount" class="form-control autonumber" disabled>
                                </div>
                            </div>
                        </div>
                        <div id="CancelationAdded" class="row">
                            <div class="col-md-12">
                                <h5 class="my-4">{{__("main.cancellation_fees_select_type")}}</h5>
                                <a href="#" id="basic_add_cancel" onclick="addNewCancelFees('{{__('main.amount')}}', '{{__('main.percentage')}}', '{{__('main.period_time')}}', '{{__('main.before')}}', '{{__('main.day')}}', '{{__('main.days')}}', '{{__('main.remove_period_time')}}');return false;">
                                    + {{__("main.add_new_period_time")}}
                                </a>
                                <div class="col-md-2 align-self-center">
                                    <div class="form-group pt-4"></div>
                                </div>
                            </div>

                            @if($room->cancellations->toArray())
                                @foreach($room->cancellations->toArray() as $key => $value)
                                    <div class="cancel-item row">
                                        <input type="hidden" name="cancels[{{$key}}][id]" value="{{$value['id']}}">
                                        <div class="col-md-3 pt-2">
                                            <div class="form-group">
                                                <div class="radio radio-primary d-inline">
                                                    <input type="radio" name="cancels[{{$key}}][type]" id="radio-Cancel-Amount-{{$key}}" class="radio-Cancel-Amount @error("cancels.{$key}.value") is-invalid @enderror" value="2" @if($value['type'] == 2) checked="" @endif>
                                                    <label for="radio-Cancel-Amount-{{$key}}" class="cr">{{__("main.amount")}}</label>
                                                </div>

                                                <input type="text" id="Cancel-Amount" class="form-control autonumber Cancel-Amount"
                                                       name="cancels[{{$key}}][cancel_value_amount]" @if($value['type'] == 2) value="{{$value['value']}}" @else disabled @endif>
                                                @error("cancels.{$key}.value")
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-md-3 pt-2">
                                            <div class="form-group">
                                                <div class="radio radio-primary d-inline">
                                                    <input type="radio" name="cancels[{{$key}}][type]" id="radio-Cancel-Precentage-{{$key}}" class="radio-Cancel-Precentage" value="1" @if($value['type'] == 1) checked @endif>
                                                    <label for="radio-Cancel-Precentage-{{$key}}" class="cr">{{__("main.percentage")}}</label>
                                                </div>

                                                <input type="text" id="Cancel-precentage" class="form-control autonumber Cancel-precentage @error("cancels.{$key}.value") is-invalid @enderror"
                                                       name="cancels[{{$key}}][cancel_value_perc]"  data-a-sign="% " @if($value['type'] == 1) value="{{$value['value']}}" @else disabled @endif>
                                                @error("cancels.{$key}.value")
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-2 pt-2">
                                            <label  class="cr">{{__("main.period_time")}}</label>
                                            <div class="form-group">
                                                <select id="CurrenciesDisDDL-{{$key}}"
                                                        class="js-example-tags form-control @error("cancels.{$key}.time") is-invalid @enderror"
                                                        name="cancels[{{$key}}][time]">
                                                    <option value="1" @if($value['time'] == 1) selected @endif >{{__('main.before')}} 1 {{__('main.day')}}</option>
                                                    <option value="2" @if($value['time'] == 2) selected @endif >{{__('main.before')}} 2 {{__('main.days')}}</option>
                                                    <option value="3" @if($value['time'] == 3) selected @endif >{{__('main.before')}} 3 {{__('main.days')}}</option>
                                                    <option value="4" @if($value['time'] == 4) selected @endif >{{__('main.before')}} 4 {{__('main.days')}}</option>
                                                    <option value="5" @if($value['time'] == 5) selected @endif >{{__('main.before')}} 5 {{__('main.days')}}</option>
                                                </select>
                                            </div>
                                            @error("cancels.{$key}.time")
                                            <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="col-md-2 align-self-center">
                                            <div class="form-group pt-4">
                                                <a href="#" onclick="$(this).closest('.cancel-item').remove();return false;">
                                                    {{__("main.remove_period_time")}}
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        </div>

                        <div class="row pb-4">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <h5 class="my-4">{{__("main.extra_bed_adult_price")}}</h5>
                                </div>
                            </div>
                            <div class="col-md-2 align-self-center">
                                <div class="form-group">
                                    <input type="text" id="Extra-Bed-Adult" class="form-control autonumber @error('extra_bed_exc') is-invalid @enderror" name="extra_bed_exc"  value="{{$room->details->toArray()['extra_bed_exc']}}">
                                    @error('extra_bed_exc')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6"></div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <h5 class="my-4">{{__("main.number_of_children_with_2_adults")}}</h5>
                                </div>
                            </div>
                            <div class="col-md-2 align-self-center">
                                <div class="form-group">
                                    <input type="number" id="No-child-with-adults" class="form-control @error('max_children_with_two_parents') is-invalid @enderror" name="max_children_with_two_parents"  value="{{$room->details->toArray()['max_children_with_two_parents']}}">
                                    @error('max_children_with_two_parents')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6"></div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <h5 class="my-4">{{__("main.price_of_child_with_2_adults")}}</h5>
                                </div>
                            </div>
                            <div class="col-md-2 align-self-center">
                                <div class="form-group">
                                    <input type="text" id="Single-parent-Adultt" class="form-control autonumber @error('child_with_two_parents_exc') is-invalid @enderror" name="child_with_two_parents_exc"  value="{{$room->details->toArray()['child_with_two_parents_exc']}}">
                                    @error('child_with_two_parents_exc')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6"></div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <h5 class="my-4">{{__("main.single_parent_adult")}}</h5>
                                </div>
                            </div>
                            <div class="col-md-2 align-self-center">
                                <div class="form-group">
                                    <input type="text" id="Single-Parent-Adult" class="form-control autonumber @error('single_parent_exc') is-invalid @enderror" name="single_parent_exc"  value="{{$room->details->toArray()['single_parent_exc']}}">
                                    @error('single_parent_exc')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6"></div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <h5 class="my-4">{{__("main.single_parent_child")}}</h5>
                                </div>
                            </div>

                            <div class="col-md-2 align-self-center">
                                <div class="form-group">
                                    <input type="text" id="Single-parent-Child" class="form-control autonumber @error('single_parent_child_exc') is-invalid @enderror"  value="{{$room->details->toArray()['single_parent_child_exc']}}" name="single_parent_child_exc">
                                    @error('single_parent_child_exc')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6"></div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <h5 class="my-4">{{__("main.child_free_until_age")}}</h5>
                                </div>
                            </div>
                            <div class="col-md-2 align-self-center">
                                <div class="form-group">
                                    <select id="childFreeDDL"
                                            class="js-example-tags form-control @error('child_free_until') is-invalid @enderror"
                                            name="child_free_until" required >
                                        <option value="3" @if($room->details->toArray()['child_free_until'] == 3) selected @endif>3</option>
                                        <option value="4" @if($room->details->toArray()['child_free_until'] == 4) selected @endif>4</option>
                                        <option value="5" @if($room->details->toArray()['child_free_until'] == 5) selected @endif>5</option>
                                        <option value="6" @if($room->details->toArray()['child_free_until'] == 6) selected @endif>6</option>
                                    </select>
                                    @error('child_free_until')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6"></div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <h5 class="my-4">{{__("main.min_age_child")}}</h5>
                                </div>
                            </div>
                            <div class="col-md-2 align-self-center">
                                <div class="form-group">
                                    <select id="MinChildDDL"
                                            class="js-example-tags form-control @error('min_child_age') is-invalid @enderror"
                                            name="min_child_age" required >
                                        <option value="3" @if($room->details->toArray()['min_child_age'] == 3) selected @endif>6</option>
                                        <option value="4" @if($room->details->toArray()['min_child_age'] == 4) selected @endif>7</option>
                                        <option value="5" @if($room->details->toArray()['min_child_age'] == 5) selected @endif>8</option>
                                    </select>
                                    @error('min_child_age')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6"></div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <h5 class="my-4">{{__("main.max_age_child")}}</h5>
                                </div>
                            </div>
                            <div class="col-md-2 align-self-center">
                                <div class="form-group">
                                    <select id="MaxChildDDL"
                                            class="js-example-tags form-control @error('max_child_age') is-invalid @enderror"
                                            name="max_child_age" required>
                                        <option value="10" @if($room->details->toArray()['max_child_age'] == 10) selected @endif>10</option>
                                        <option value="11" @if($room->details->toArray()['max_child_age'] == 11) selected @endif>11</option>
                                        <option value="12" @if($room->details->toArray()['max_child_age'] == 12) selected @endif>12</option>
                                        <option value="13" @if($room->details->toArray()['max_child_age'] == 13) selected @endif>13</option>
                                    </select>
                                    @error('max_child_age')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6"></div>
                        </div>
                        <div class="row pt-4">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{__('main.promo_special_offers')}}</label>
                                    <textarea placeholder="{{__("main.promo_special_offers")}}" class="form-control @error('special_offer') is-invalid @enderror" name="special_offer" rows="10">{{$room->details->toArray()['special_offer']}}</textarea>
                                    @error('special_offer')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6"></div>
                        </div>



                        <button type="submit" class="btn btn-primary">{{__("main.update")}}</button>
                        <button type="button" onclick="window.location.href='{{ route('suppliers.index').'#pills-Hotels-tab' }}';" class="btn btn-outline-primary">{{__("main.cancel")}}</button>

                    </form>

                </div>
            </div>

        </div>
    </div>
@endsection

@section('script_bottom')
    <script>
        var next_cancel = 1;
        @if($room->cancellations->count())
            next_cancel = {{$room->cancellations->count()}};
        @endif
        function calculateRateAfterDiscount(){
            var base_rate = $('[name="base_rate"]').val();
            if(base_rate){
                base_rate = base_rate.replace('EGP ', '').replace(',','');
                base_rate = parseFloat(base_rate);
                if(!isNaN(base_rate)){
                    var selected_type = $('[name="discount_type"]:checked').val();
                    if(selected_type == 1){//percentage
                        var discount_value = $('[name="discount_value_perc"]').val();
                        if(discount_value){
                            discount_value = discount_value.replace('%', '').replace(',','');
                            discount_value = parseFloat(discount_value);
                            if(!isNaN(discount_value)){
                                base_rate = base_rate - (base_rate * discount_value / 100);
                            }
                        }
                    }else{
                        var discount_value = $('[name="discount_value_amount"]').val();
                        if(discount_value){
                            discount_value = discount_value.replace('EGP ', '').replace(',','');
                            discount_value = parseFloat(discount_value);
                            if(!isNaN(discount_value)){
                                base_rate = base_rate - discount_value;
                            }
                        }
                    }
                }
                $("#Amount-after-discount").val(base_rate);
            }
        }
        $(function () {
            calculateRateAfterDiscount();

            $('[name="discount_type"]').change(function(){
                calculateRateAfterDiscount();
            });
            $('[name="discount_value_amount"]').change(function(){
                calculateRateAfterDiscount();
            });
            $('[name="discount_value_perc"]').change(function(){
                calculateRateAfterDiscount();
            });
            $('[name="base_rate"]').change(function(){
                calculateRateAfterDiscount();
            });

            $(document).on('click','.radio-Cancel-Precentage',function (e) {
                $(this).closest('.form-group').find('.Cancel-precentage').removeAttr('disabled');
                $(this).closest('.cancel-item').find('.Cancel-Amount').attr("disabled","disabled");
            });

            $(document).on('click','.radio-Cancel-Amount',function (e) {
                $(this).closest('.form-group').find('.Cancel-Amount').removeAttr('disabled');
                $(this).closest('.cancel-item').find('.Cancel-precentage').attr("disabled","disabled");
            });

        });
    </script>
@endsection
