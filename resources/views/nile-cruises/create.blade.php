@extends('layouts.main')

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h5>{{__('main.create_new_nile_cruise')}}</h5>
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
                    <form id="validation-form123" action="{{route('nile-cruises.store')}}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">                                    
                                    <label>{{__('main.company_name')}}</label>
                                    <input type="text" id="Name-of-Company" class="form-control @error('company_name') is-invalid @enderror"
                                           name="company_name" required value="{{old('company_name')}}">
                                    @error('company_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">                                    
                                    <label>{{__('main.name_of_nile_cruise')}}</label>
                                    <input type="text" id="Name-of-Nile-Cruise" class="form-control @error('name') is-invalid @enderror"
                                           name="name" required value="{{old('name')}}">
                                    @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-3">
                                <label>{{__('main.check_in_date')}}</label>
                                <input type="text" id="date-Cruise-Check-in" class="form-control @error('date_from') is-invalid @enderror"
                                       name="date_from" required value="{{old('date_from')}}">
                                @error('date_from')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror

                            </div>
                            <div class="col-md-3">
                                <label>{{__('main.check_out_date')}}</label>
                                <input type="text" id="date-Cruise-Check-out" class="form-control @error('date_to') is-invalid @enderror"
                                       name="date_to" required value="{{old('date_to')}}">
                                @error('date_to')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror

                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>{{__('main.from_city')}}</label>
                                    <select id="CityFromDDL"
                                            class="js-example-tags form-control @error('from_city_id') is-invalid @enderror"
                                            name="from_city_id" required>
                                        <option value="">{{__('main.from_city')}}</option>
                                        @foreach($cities as $city)
                                            <option value="{{$city->id}}" @if($city->id == old('from_city_id')) selected @endif>{{$city->name}}</option>
                                        @endforeach
                                    </select>
                                    @error('from_city_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>{{__('main.to_city')}}</label>
                                    <select id="CityToDDL"
                                            class="js-example-tags form-control @error('to_city_id') is-invalid @enderror"
                                            name="to_city_id" required>
                                        <option value="">{{__('main.to_city')}}</option>
                                        @foreach($cities as $city)
                                            <option value="{{$city->id}}" @if($city->id == old('to_city_id')) selected @endif>{{$city->name}}</option>
                                        @endforeach
                                    </select>
                                    @error('to_city_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>{{__('main.number_of_nights')}}</label>
                                    <input type="text" id="Num-Nights" class="form-control" disabled>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-md-3 pt-2">
                                <div class="form-group">
                                    <div class="radio radio-primary d-inline">
                                        <input type="radio" name="cabin_type" id="radio-Cabin" value="cabin" checked="" >
                                        <label for="radio-Cabin" class="cr">{{__("main.cabin")}}</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 pt-2">
                                <div class="form-group">
                                    <div class="radio radio-primary d-inline">
                                        <input type="radio" name="cabin_type" id="radio-Suite" value="suite"  >
                                        <label for="radio-Suite" class="cr">{{__("main.suite")}}</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-3 pt-2">
                                <div class="form-group">
                                    <div class="radio radio-primary d-inline">
                                        <input type="radio" name="deck_type" id="radio-Main-Deck" value="main" checked="" >
                                        <label for="radio-Main-Deck" class="cr">{{__("main.main_deck")}}</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 pt-2">
                                <div class="form-group">
                                    <div class="radio radio-primary d-inline">
                                        <input type="radio" name="deck_type" id="radio-Upper-Deck" value="upper"  >
                                        <label for="radio-Upper-Deck" class="cr">{{__("main.upper_deck")}}</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-3 pt-2">
                                <div class="form-group">
                                    <div class="radio radio-primary d-inline">
                                        <input type="radio" name="including_sightseeing" id="radio-Including-Sightseeing" value="1" checked="" >
                                        <label for="radio-Including-Sightseeing" class="cr">{{__("main.including_sightseeing")}}</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 pt-2">
                                <div class="form-group">
                                    <div class="radio radio-primary d-inline">
                                        <input type="radio" name="including_sightseeing" id="radio-Not-Including-Sightseeing" value="0"  >
                                        <label for="radio-Not-Including-Sightseeing" class="cr">{{__("main.not_including_sightseeing")}}</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <hr>

                        <div class="row">
                            <div class="col-md-3">
                                <label>{{__('main.sgl_cabin_suite')}}</label>
                                <div class="form-group">
                                <label>{{__('main.buying_price')}}</label>    
                                <input id="SGL-Cabin-buy-pric" type="text" class="form-control autonumber @error('sgl_buy_price') is-invalid @enderror"
                                           name="sgl_buy_price"
                                             value="{{old('sgl_buy_price')}}">
                                    @error('sgl_buy_price')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-3">
                                <label></label>
                                <div class="form-group mt-2">
                                    <label>{{__('main.currency')}}</label>
                                    <select
                                            class="js-example-tags form-control "
                                            name="sgl_buy_currency" required>
                                        @foreach(\App\Models\Currency::availableCurrencies() as $key => $value)
                                            <option value="{{$key}}" >{{$value}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <label></label>
                                <div class="form-group mt-2">
                                <label>{{__('main.selling_price')}}</label>    
                                <input id="SGL-Cabin-sell-pric" type="text" class="form-control autonumber @error('sgl_sell_price') is-invalid @enderror"
                                           name="sgl_sell_price"
                                             value="{{old('sgl_sell_price')}}">
                                    @error('sgl_sell_price')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-3">
                                <label></label>
                                <div class="form-group mt-2">
                                    <label>{{__('main.currency')}}</label>
                                    <select
                                            class="js-example-tags form-control "
                                            name="sgl_sell_currency" required>
                                        @foreach(\App\Models\Currency::availableCurrencies() as $key => $value)
                                            <option value="{{$key}}" >{{$value}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-md-3">
                                <label>{{__('main.per_person_dbl_cabin')}}</label>
                                <div class="form-group">
                                <label>{{__('main.buying_price')}}</label>    
                                <input id="DBL-Cabin-buy-pric" type="text" class="form-control autonumber @error('dbl_buy_price') is-invalid @enderror"
                                           name="dbl_buy_price"
                                             value="{{old('dbl_buy_price')}}">
                                    @error('dbl_buy_price')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-3">
                                <label></label>
                                <div class="form-group mt-2">
                                    <label>{{__('main.currency')}}</label>
                                    <select
                                        class="js-example-tags form-control "
                                        name="dbl_buy_currency" required>
                                        @foreach(\App\Models\Currency::availableCurrencies() as $key => $value)
                                            <option value="{{$key}}" >{{$value}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <label></label>
                                <div class="form-group mt-2">
                                <label>{{__('main.selling_price')}}</label>    
                                <input id="DBL-Cabin-sell-pric" type="text" class="form-control autonumber @error('dbl_sell_price') is-invalid @enderror"
                                           name="dbl_sell_price" value="{{old('dbl_sell_price')}}">
                                    @error('dbl_sell_price')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-3">
                                <label></label>
                                <div class="form-group mt-2">
                                    <label>{{__('main.currency')}}</label>
                                    <select
                                        class="js-example-tags form-control "
                                        name="dbl_sell_currency" required>
                                        @foreach(\App\Models\Currency::availableCurrencies() as $key => $value)
                                            <option value="{{$key}}" >{{$value}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-md-3">
                                <label>{{__('main.per_person_trpl_cabin')}}</label>
                                <div class="form-group">
                                <label>{{__('main.buying_price')}}</label>    
                                <input id="trpl_buy_price" type="text" class="form-control autonumber @error('trpl_buy_price') is-invalid @enderror"
                                           name="trpl_buy_price" value="{{old('trpl_buy_price')}}">
                                    @error('trpl_buy_price')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-3">
                                <label></label>
                                <div class="form-group mt-2">
                                    <label>{{__('main.currency')}}</label>
                                    <select
                                        class="js-example-tags form-control "
                                        name="trpl_buy_currency" required>
                                        @foreach(\App\Models\Currency::availableCurrencies() as $key => $value)
                                            <option value="{{$key}}" >{{$value}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <label></label>
                                <div class="form-group mt-2">
                                <label>{{__('main.selling_price')}}</label>    
                                <input id="trpl_sell_price" type="text" class="form-control autonumber @error('trpl_sell_price') is-invalid @enderror"
                                           name="trpl_sell_price" value="{{old('trpl_sell_price')}}">
                                    @error('trpl_sell_price')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-3">
                                <label></label>
                                <div class="form-group mt-2">
                                    <label>{{__('main.currency')}}</label>
                                    <select
                                        class="js-example-tags form-control "
                                        name="trpl_sell_currency" required>
                                        @foreach(\App\Models\Currency::availableCurrencies() as $key => $value)
                                            <option value="{{$key}}" >{{$value}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <hr>
                        <div class="row">
                            <div class="col-md-3">
                                <label>{{__('main.children')}}</label>
                                <div class="form-group">
                                <label>{{__('main.buying_price')}}</label>    
                                <input id="Children-buy-pric" type="text" class="form-control autonumber @error('child_buy_price') is-invalid @enderror"
                                           name="child_buy_price" value="{{old('child_buy_price')}}">
                                    @error('child_buy_price')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-3">
                                <label></label>
                                <div class="form-group mt-2">
                                    <label>{{__('main.currency')}}</label>
                                    <select
                                        class="js-example-tags form-control "
                                        name="child_buy_currency" required>
                                        @foreach(\App\Models\Currency::availableCurrencies() as $key => $value)
                                            <option value="{{$key}}" >{{$value}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <label></label>
                                <div class="form-group mt-2">
                                <label>{{__('main.selling_price')}}</label>    
                                <input id="Children-sell-pric" type="text" class="form-control autonumber @error('child_sell_price') is-invalid @enderror"
                                           name="child_sell_price" value="{{old('child_sell_price')}}">
                                    @error('child_sell_price')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-3">
                                <label></label>
                                <div class="form-group mt-2">
                                    <label>{{__('main.currency')}}</label>
                                    <select
                                        class="js-example-tags form-control "
                                        name="child_sell_currency" required>
                                        @foreach(\App\Models\Currency::availableCurrencies() as $key => $value)
                                            <option value="{{$key}}" >{{$value}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                        </div>

                        <hr>
                        <div class="row">
                            <div class="col-md-3">
                                <label>{{__('main.private_tour_guide')}}</label>
                                <div class="form-group">
                                <label>{{__('main.salary')}}</label>    
                                <input id="Buy-Privt-Salary" type="text" class="form-control autonumber @error('private_guide_salary') is-invalid @enderror"
                                           name="private_guide_salary" value="{{old('private_guide_salary')}}">
                                    @error('private_guide_salary')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-3">
                                <label></label>
                                <div class="form-group mt-2">
                                <label>{{__('main.accommodation')}}</label>    
                                <input id="Sell-Privt-Acc" type="text" class="form-control autonumber @error('private_guide_accommodation') is-invalid @enderror"
                                           name="private_guide_accommodation" value="{{old('private_guide_accommodation')}}">
                                    @error('private_guide_accommodation')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>


                            <div class="col-md-3">
                                <label></label>
                                <div class="form-group mt-2">
                                <label>{{__('main.buying_price')}}</label>    
                                <input id="Buy-Privt-Tur-Gid-pric" type="text" class="form-control autonumber @error('private_guide_buy_price') is-invalid @enderror"
                                           name="private_guide_buy_price" value="{{old('private_guide_buy_price')}}" disabled>
                                    @error('private_guide_buy_price')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-3">
                                <label></label>
                                <div class="form-group mt-2">
                                    <label>{{__('main.currency')}}</label>
                                    <select
                                        class="js-example-tags form-control "
                                        name="private_buy_currency" required>
                                        @foreach(\App\Models\Currency::availableCurrencies() as $key => $value)
                                            <option value="{{$key}}" >{{$value}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <label></label>
                                <div class="form-group mt-2">
                                <label>{{__('main.selling_price')}}</label>    
                                <input id="Sell-Privt-Tur-Gid-pric" type="text" class="form-control autonumber @error('private_guide_sell_price') is-invalid @enderror"
                                           name="private_guide_sell_price" value="{{old('private_guide_sell_price')}}">
                                    @error('private_guide_sell_price')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-3">
                                <label></label>
                                <div class="form-group mt-2">
                                    <label>{{__('main.currency')}}</label>
                                    <select
                                        class="js-example-tags form-control "
                                        name="private_sell_currency" required>
                                        @foreach(\App\Models\Currency::availableCurrencies() as $key => $value)
                                            <option value="{{$key}}" >{{$value}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-md-3">
                                <label>{{__('main.guide_on_the_boat')}}</label>
                                <div class="form-group">
                                <label>{{__('main.buying_price')}}</label>    
                                <input id="Buy-Gid-boat-pric" type="text" class="form-control autonumber @error('boat_guide_buy_price') is-invalid @enderror"
                                           name="boat_guide_buy_price" value="{{old('boat_guide_buy_price')}}">
                                    @error('boat_guide_buy_price')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-3">
                                <label></label>
                                <div class="form-group mt-2">
                                    <label>{{__('main.currency')}}</label>
                                    <select
                                        class="js-example-tags form-control "
                                        name="boat_guide_buy_currency" required>
                                        @foreach(\App\Models\Currency::availableCurrencies() as $key => $value)
                                            <option value="{{$key}}" >{{$value}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <label></label>
                                <div class="form-group mt-2">
                                <label>{{__('main.selling_price')}}</label>    
                                <input id="Sell-Gid-boat-pric" type="text" class="form-control autonumber @error('boat_guide_sell_price') is-invalid @enderror"
                                           name="boat_guide_sell_price" value="{{old('boat_guide_sell_price')}}">
                                    @error('boat_guide_sell_price')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-3">
                                <label></label>
                                <div class="form-group mt-2">
                                    <label>{{__('main.currency')}}</label>
                                    <select
                                        class="js-example-tags form-control "
                                        name="boat_guide_sell_currency" required>
                                        @foreach(\App\Models\Currency::availableCurrencies() as $key => $value)
                                            <option value="{{$key}}" >{{$value}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>


                        <button type="submit" class="btn btn-primary">{{__('main.create')}}</button>
                        <button type="button" onclick="window.location.href='{{route('suppliers.index').'#pills-Nile-Cruises-tab'}}';" class="btn btn-outline-primary">{{__('main.cancel')}}</button>
                    </form>

                </div>
            </div>

        </div>
    </div>
@endsection

@section ('script_bottom')
    <script>
        function calculateNights(){
            if($('#date-Cruise-Check-in').val().trim() && $('#date-Cruise-Check-out').val().trim()){
                var arrival_date = new Date($('#date-Cruise-Check-in').val());
                var departure_date = new Date($('#date-Cruise-Check-out').val());
                if(departure_date <= +arrival_date){
                    $('#date-Cruise-Check-out').val("");
                    console.log(0);
                    $("#Num-Nights").val(0+" Nights");
                }else{
                    var diffTime = Math.abs(departure_date - arrival_date);
                    var diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
                    console.log(diffDays);
                    $("#Num-Nights").val(diffDays+" {{__('main.night_s')}}");
                }
            }
        }
        $(function(){
            calculateNights();
            $('#date-Cruise-Check-in, #date-Cruise-Check-out').change(function(){
                if($('#date-Cruise-Check-in').val().trim()){
                    $('#date-Cruise-Check-out').bootstrapMaterialDatePicker('setMinDate', $('#date-Cruise-Check-in').val());
                }
                calculateNights();
            });


            $("[name='private_guide_accommodation'],[name='private_guide_salary']").change(function(){
                let salary =  parseFloat($("[name='private_guide_salary']").val().replaceAll(",", ''));
                let accommodation =  parseFloat($("[name='private_guide_accommodation']").val().replaceAll(",", ''));
                console.log(salary, accommodation);
                let total = 0;
                if(!isNaN(salary)){
                    total += salary;
                    $("[name='private_guide_buy_price']").val(total);
                }
                if(!isNaN(accommodation)){
                    total += accommodation;
                    $("[name='private_guide_buy_price']").val(total);
                }
            });
        });
    </script>
@endsection
