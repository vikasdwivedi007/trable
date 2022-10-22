@extends('layouts.main')

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h5>{{__("main.create_new_router")}}</h5>
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
                    <form id="validation-form123" action="{{ route('routers.store') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                  <label>{{__('main.serial_no')}}</label>  
                                    <input type="text" id="SN-Devices" class="form-control @error('serial_no') is-invalid @enderror"
                                           name="serial_no" placeholder="{{__("main.serial_no")}}" value="{{old('serial_no')}}" required>
                                    @error('serial_no')
                                    <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6"></div>
                            <div class="col-md-3">
                                <div class="form-group">
                                  <label>{{__('main.number_of_router')}}</label>  
                                    <input type="text" id="No-of-Router" class="form-control @error('number') is-invalid @enderror"
                                           name="number" placeholder="{{__("main.number_of_router")}}"  value="{{old('number')}}" required>
                                    @error('number')
                                    <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                  <label>{{__('main.package_quota')}}</label>  
                                    <input type="text" id="Package-Quota" class="form-control @error('quota') is-invalid @enderror"
                                           name="quota" placeholder="{{__("main.package_quota")}} (GB)"  value="{{old('quota')}}" required>
                                    @error('quota')
                                    <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6"></div>
                            <div class="col-md-6">
                                <div class="form-group">
                                  <label>{{__('main.service_provider')}}</label>  
                                    <select id="ServiceProviderDDL"
                                            class="js-example-tags form-control @error('provider') is-invalid @enderror"
                                            name="provider" required>
                                        <option value="">{{__("main.service_provider")}}</option>
                                        <option value="1" @if(old('provider') == 1) selected @endif>Etislat</option>
                                        <option value="2" @if(old('provider') == 2) selected @endif>Orange</option>
                                        <option value="3" @if(old('provider') == 3) selected @endif>Vodafone</option>
                                        <option value="4" @if(old('provider') == 4) selected @endif>WE</option>
                                    </select>
                                    @error('provider')
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
                                            <option value="{{$city->id}}" @if(old('city_id') == $city->id) selected @endif>{{$city->name}}</option>
                                        @endforeach
                                    </select>
                                    @error('city_id')
                                    <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <hr>

                        <label>{{__('main.package_price_per_day')}}</label>
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                  <label>{{__('main.buying_price')}}</label>  
                                    <input id="router-buy-pric" type="text" class="form-control autonumber @error('package_buy_price') is-invalid @enderror"
                                           name="package_buy_price"
                                           placeholder="{{__("main.buying_price")}}" value="{{old('package_buy_price')}}" >
                                    @error('package_buy_price')
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
                                            class="js-example-tags form-control @error('package_buy_currency') is-invalid @enderror"
                                            name="package_buy_currency" required>
                                        @foreach(\App\Models\Currency::availableCurrencies() as $key => $value)
                                            <option value="{{$key}}" @if(old('package_buy_currency') == $key) selected @endif>{{$value}}</option>
                                        @endforeach
                                    </select>
                                    @error('package_buy_currency')
                                    <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6"></div>
                            <div class="col-md-3">
                                <div class="form-group">
                                <label>{{__('main.selling_price')}}</label>  
                                    <input id="router-sell-pric" type="text" class="form-control autonumber @error('package_sell_price_vat_exc') is-invalid @enderror"
                                           name="package_sell_price_vat_exc"
                                           placeholder="{{__("main.selling_price")}}" value="{{old('package_sell_price_vat_exc')}}" >
                                    @error('package_sell_price_vat_exc')
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
                                            class="js-example-tags form-control @error('package_sell_currency') is-invalid @enderror"
                                            name="package_sell_currency" required>
                                        @foreach(\App\Models\Currency::availableCurrencies() as $key => $value)
                                            <option value="{{$key}}" @if(old('package_sell_currency') == $key) selected @endif>{{$value}}</option>
                                        @endforeach
                                    </select>
                                    @error('package_sell_currency')
                                    <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary">{{__("main.create")}}</button>
                        <button type="button" onclick="window.location.href='{{ route('services.index').'#pills-Routers-tab' }}';" class="btn btn-outline-primary">{{__("main.cancel")}}</button>
                    </form>

                </div>
            </div>

        </div>
    </div>
@endsection
