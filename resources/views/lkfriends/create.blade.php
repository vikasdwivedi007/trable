@extends('layouts.main')

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h5>{{__('main.create_new_lkfriend')}}</h5>
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
                    <form id="validation-form123" action="{{ route('lkfriends.store') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                <label>{{__('main.name')}}</label>
                                    <input type="text" id="Name-of-Like-Friend" class="form-control @error('name') is-invalid @enderror"
                                           name="name" placeholder="{{__('main.name')}}" required value="{{old('name')}}">
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
                                  <label>{{__('main.phone')}}</label>
                                    <input type="text" class="form-control mob_no @error('phone') is-invalid @enderror"
                                           name="phone" placeholder="{{__('main.phone')}}"  required value="{{old('phone')}}">
                                    @error('phone')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6"></div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{__('main.spoken_language')}}</label>
                                    <select id="LanguageDDL" class="js-example-basic-multiple " multiple="multiple" name="languages[]" required >
                                        <option value="">{{__('main.spoken_language')}}</option>
                                        @foreach($languages as $language)
                                            <option value="{{$language->id}}" @if(is_array(old('languages')) && in_array($language->id, old('languages')))selected @endif>{{$language->language}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6"></div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{__('main.city')}}</label>
                                    <select id="CityDDL"
                                            class="js-example-tags form-control @error('city_id') is-invalid @enderror"
                                            name="city_id" required>
                                        <option value="">{{__('main.city')}}</option>
                                        @foreach($cities as $city)
                                            <option value="{{$city->id}}" @if($city->id == old('city_id')) selected @endif>{{$city->name}}</option>
                                        @endforeach
                                    </select>
                                    @error('city_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6"></div>

                            <div class="col-md-3">
                                <div class="form-group">
                                  <label>{{__('main.fees_per_day')}}</label>
                                    <input id="Fees-Per-Day" type="text" class="form-control autonumber @error('rent_day') is-invalid @enderror"
                                           name="rent_day"
                                           placeholder="{{__('main.fees_per_day')}}"  value="{{old('rent_day')}}">
                                    @error('rent_day')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>{{__('main.currency')}}</label>
                                    <select id="CurrencyCDDL1"
                                            class="js-example-tags form-control @error('rent_day_currency') is-invalid @enderror"
                                            name="rent_day_currency" required>
                                        @foreach(\App\Models\Currency::availableCurrencies() as $key => $value)
                                            <option value="{{$key}}" @if(old('rent_day_currency') == $key) selected @endif>{{$value}}</option>
                                        @endforeach
                                    </select>
                                    @error('rent_day_currency')
                                    <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6"></div>
                            <div class="col-md-3">
                                <div class="form-group">
                                  <label>{{__('main.selling_fees_per_day')}}</label>
                                    <input id="Selling-Fees-Freind" type="text" class="form-control autonumber @error('sell_rent_day_vat_exc') is-invalid @enderror"
                                           name="sell_rent_day_vat_exc"
                                           placeholder="{{__('main.selling_fees_per_day')}}"  value="{{old('sell_rent_day_vat_exc')}}">
                                    @error('sell_rent_day_vat_exc')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>{{__('main.currency')}}</label>
                                    <select id="CurrencyCDDL2"
                                            class="js-example-tags form-control @error('sell_rent_day_currency') is-invalid @enderror"
                                            name="sell_rent_day_currency" required>
                                        @foreach(\App\Models\Currency::availableCurrencies() as $key => $value)
                                            <option value="{{$key}}" @if(old('sell_rent_day_currency') == $key) selected @endif>{{$value}}</option>
                                        @endforeach
                                    </select>
                                    @error('sell_rent_day_currency')
                                    <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6"></div>
                        </div>

                        <button type="submit" class="btn btn-primary">{{__('main.create')}}</button>
                        <button type="button" onclick="window.location.href='{{ route('services.index').'#pills-Like-Friend-tab' }}';" class="btn btn-outline-primary">{{__('main.cancel')}}</button>

                    </form>

                </div>
            </div>

        </div>
    </div>
@endsection
