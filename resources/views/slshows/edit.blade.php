@extends('layouts.main')

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h5>{{__("main.update_slshow")}}</h5>
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
                    <form id="validation-form123" action="{{ route('slshows.update', ['slshow'=>$slshow->id]) }}" method="POST">
                        @method('PATCH')
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{__('main.place')}}</label>  
                                    <select id="CityDDL"
                                            class="js-example-tags form-control @error('place') is-invalid @enderror"
                                            name="place" required>
                                        <option value="">{{__("main.place")}}</option>
                                        <option value="Pyramids" @if($slshow->place == 'Pyramids') selected @endif>Pyramids</option>
                                        <option value="Karnak" @if($slshow->place == 'Karnak') selected @endif>Karnak</option>
                                        <option value="Edfu" @if($slshow->place == 'Edfu') selected @endif>Edfu</option>
                                        <option value="Philae" @if($slshow->place == 'Philae') selected @endif>Philae</option>
                                        <option value="Abu Simbel" @if($slshow->place == 'Abu Simbel') selected @endif>Abu Simbel</option>
                                    </select>
                                    @error('place')
                                    <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6"></div>
                            <div class="col-md-3">
                                <div class="form-group">
                                  <label>{{__('main.date')}}</label>  
                                    <input type="text" id="date-sond-ligt-Show" class="form-control @error('date') is-invalid @enderror"
                                           name="date" placeholder="{{__("main.date")}}" required value="{{$slshow->toArray()['date']}}">
                                    @error('date')
                                    <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-3">
                              <label>{{__('main.time')}}</label>  
                                <input type="text" id="time-of-show" class="form-control @error('time') is-invalid @enderror" placeholder="{{__("main.time")}}" name="time" required value="{{$slshow->toArray()['time']}}">
                                @error('time')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-md-6"></div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{__('main.show_language')}}</label>  
                                    <select id="LanguageDDL" class="js-example-basic-multiple @error('language_id') is-invalid @enderror" name="language_id" required>
                                        <option value="">{{__("main.show_language")}}</option>
                                        @foreach($languages as $language)
                                            <option value="{{$language->id}}" @if($language->id == $slshow->language_id) selected @endif>{{$language->language}}</option>
                                        @endforeach
                                        <option value="{{\App\Models\Language::ALL_LANGUAGES_ID}}" @if($slshow->language_id == \App\Models\Language::ALL_LANGUAGES_ID) selected @endif>All Languages</option>
                                    </select>
                                    @error('language_id')
                                    <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                        </div>
                        <div class="col-md-6">
                            <fieldset class="form-group ">
                                <div class="form-group d-inline">
                                    {{__("main.ticket")}}:
                                </div>
                                <div class="form-group d-inline">

                                    <div class="radio radio-primary d-inline">
                                        <input type="radio" name="ticket_type" id="radio-p-Male" @if($slshow->ticket_type == "Regular")checked=""@endif  value="Regular">
                                        <label for="radio-p-Male" class="cr">Regular</label>
                                    </div>
                                </div>
                                <div class="form-group d-inline">
                                    <div class="radio radio-primary d-inline">
                                        <input type="radio" name="ticket_type" id="radio-p-Female" @if($slshow->ticket_type == "VIP") checked="" @endif value="VIP">
                                        <label for="radio-p-Female" class="cr">VIP</label>
                                    </div>
                                </div>
                            </fieldset>
                        </div>

                        <hr>
                        <label>{{__("main.adult_price")}}</label>
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                  <label>{{__('main.buying_price')}}</label>  
                                    <input id="adult-buy-pric" type="text" class="form-control autonumber @error('buy_price_adult') is-invalid @enderror"
                                           name="buy_price_adult"
                                           placeholder="{{__("main.buying_price")}}"  value="{{$slshow->buy_price_adult}}">
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
                                            <option value="{{$key}}" @if($slshow->adult_buy_currency == $key) selected @endif>{{$value}}</option>
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
                                           placeholder="{{__("main.selling_price")}}"  value="{{$slshow->sell_price_adult_vat_exc}}">
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
                                            <option value="{{$key}}" @if($slshow->adult_sell_currency == $key) selected @endif>{{$value}}</option>
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
                                           placeholder="{{__("main.buying_price")}}"  value="{{$slshow->buy_price_child}}">
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
                                            <option value="{{$key}}" @if($slshow->child_buy_currency == $key) selected @endif>{{$value}}</option>
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
                                           placeholder="{{__("main.selling_price")}}"  value="{{$slshow->sell_price_child_vat_exc}}">
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
                                            <option value="{{$key}}" @if($slshow->child_sell_currency == $key) selected @endif>{{$value}}</option>
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
                        <button type="button" onclick="window.location.href='{{ route('services.index').'#pills-Sound-Light-Show-tab' }}';" class="btn btn-outline-primary">{{__("main.cancel")}}</button>
                    </form>

                </div>
            </div>

        </div>
    </div>
@endsection
