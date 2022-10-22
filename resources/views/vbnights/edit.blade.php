@extends('layouts.main')

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h5>{{__("main.update_vbnight")}}</h5>
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
                    <form id="validation-form123" action="{{ route('vbnights.update', ['vbnight'=>$vbnight->id]) }}" method="POST">
                        @method('PATCH')
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{__('main.name')}}</label>
                                    <input type="text" id="Name-of-Visit" class="form-control @error('name') is-invalid @enderror"
                                           name="name" placeholder="{{__("main.name")}}" required value="{{$vbnight->name}}">
                                    @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6"></div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{__('main.city')}}</label>
                                    <select id="CityDDL"
                                            class="js-example-tags form-control @error('city_id') is-invalid @enderror"
                                            name="city_id" required>
                                        <option value="">{{__("main.city")}}</option>
                                        @foreach($cities as $city)
                                            <option value="{{$city->id}}" @if($city->id == $vbnight->city_id) selected @endif>{{$city->name}}</option>
                                        @endforeach
                                        @error('city_id')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </select>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="row">

                        </div>
                        <hr>
                        <label>{{__("main.adult_price")}}</label>
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>{{__('main.buying_price')}}</label>
                                    <input id="adult-buy-pric" type="text" class="form-control autonumber @error('buy_price_adult') is-invalid @enderror"
                                           name="buy_price_adult"
                                           placeholder="{{__("main.buying_price")}}"  value="{{$vbnight->buy_price_adult}}">
                                    @error('buy_price_adult')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-3">

                                <div class="form-group">
                                    <label>{{__('main.currency')}}</label>
                                    <select
                                            class="js-example-tags form-control @error('adult_buy_currency') is-invalid @enderror"
                                            name="adult_buy_currency" required>
                                        @foreach(\App\Models\Currency::availableCurrencies() as $key => $value)
                                            <option value="{{$key}}" @if($vbnight->adult_buy_currency == $key) selected @endif>{{$value}}</option>
                                        @endforeach
                                    </select>
                                    @error('adult_buy_currency')
                                    <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>{{__('main.selling_price')}}</label>
                                    <input id="adult-sell-pric" type="text" class="form-control autonumber @error('sell_price_adult_vat_exc') is-invalid @enderror"
                                           name="sell_price_adult_vat_exc"
                                           placeholder="{{__("main.selling_price")}}"  value="{{$vbnight->sell_price_adult_vat_exc}}">
                                    @error('sell_price_adult_vat_exc')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-3">

                                <div class="form-group">
                                    <label>{{__('main.currency')}}</label>
                                    <select
                                        class="js-example-tags form-control @error('adult_sell_currency') is-invalid @enderror"
                                        name="adult_sell_currency" required>
                                        @foreach(\App\Models\Currency::availableCurrencies() as $key => $value)
                                            <option value="{{$key}}" @if($vbnight->adult_sell_currency == $key) selected @endif>{{$value}}</option>
                                        @endforeach
                                    </select>
                                    @error('adult_sell_currency')
                                    <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <hr>
                        <label>{{__("main.child_price")}}</label>
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>{{__('main.buying_price')}}</label>
                                    <input id="child-buy-pric" type="text" class="form-control autonumber @error('buy_price_child') is-invalid @enderror"
                                           name="buy_price_child"
                                           placeholder="{{__("main.buying_price")}}"  value="{{$vbnight->buy_price_child}}">
                                    @error('buy_price_child')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-3">

                                <div class="form-group">
                                <label>{{__('main.currency')}}</label>
                                    <select
                                        class="js-example-tags form-control @error('child_buy_currency') is-invalid @enderror"
                                        name="child_buy_currency" required>
                                        @foreach(\App\Models\Currency::availableCurrencies() as $key => $value)
                                            <option value="{{$key}}" @if($vbnight->child_buy_currency == $key) selected @endif>{{$value}}</option>
                                        @endforeach
                                    </select>
                                    @error('child_buy_currency')
                                    <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>{{__('main.selling_price')}}</label>
                                    <input id="child-sell-pric" type="text" class="form-control autonumber @error('sell_price_child_vat_exc') is-invalid @enderror"
                                           name="sell_price_child_vat_exc"
                                           placeholder="{{__("main.selling_price")}}"  value="{{$vbnight->sell_price_child_vat_exc}}">
                                    @error('sell_price_child_vat_exc')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-3">

                                <div class="form-group">
                                    <label>{{__('main.currency')}}</label>
                                    <select
                                        class="js-example-tags form-control @error('child_sell_currency') is-invalid @enderror"
                                        name="child_sell_currency" required>
                                        @foreach(\App\Models\Currency::availableCurrencies() as $key => $value)
                                            <option value="{{$key}}" @if($vbnight->child_sell_currency == $key) selected @endif>{{$value}}</option>
                                        @endforeach
                                    </select>
                                    @error('child_sell_currency')
                                    <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                    @enderror
                                </div>
                            </div>

                        </div>


                        <button type="submit" class="btn btn-primary">{{__("main.update")}}</button>
                        <button type="button" onclick="window.location.href='{{ route('services.index').'#pills-Visit-by-Night-tab' }}';" class="btn btn-outline-primary">{{__("main.cancel")}}</button>
                    </form>

                </div>
            </div>

        </div>
    </div>
@endsection
