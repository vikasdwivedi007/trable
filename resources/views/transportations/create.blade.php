@extends('layouts.main')

@section('script_top')
    <style>
        .car-item, .contact-item{
            display: contents;
        }
    </style>
@endsection

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h5>{{__("main.create_new_transportation")}}</h5>
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
                    <form id="validation-form123" action="{{ route('transportations.store') }}" method="POST"  enctype="multipart/form-data">
                        @csrf
                        <label>{{__("main.transportation_company")}} </label>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{__('main.company_code')}}</label>
                                    <input type="text" id="Trnsprt-Co-Code" class="form-control @error('code') is-invalid @enderror"
                                           name="code" placeholder="{{__("main.company_code")}}" value="{{old('code')}}">
                                    @error('code')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror

                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>{{__('main.company_name')}}</label>
                                    <input type="text" id="Trnsprt-Co-Name" class="form-control @error('name') is-invalid @enderror"
                                           name="name" placeholder="{{__("main.company_name")}}" required value="{{old('name')}}">
                                    @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror

                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>{{__('main.name_ar')}}</label>
                                    <input type="text" id="Trnsprt-Co-NameAr" class="form-control ar_only @error('name_ar') is-invalid @enderror"
                                           name="name_ar" placeholder="{{__("main.name_ar")}}" required value="{{old('name_ar')}}">
                                    @error('name_ar')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror

                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{__('main.transportation_company_phone')}}</label>
                                    <input type="text" id="Trnsprt-Co-Phn" class="form-control mob_no @error('phone') is-invalid @enderror"
                                           name="phone" placeholder="{{__("main.transportation_company_phone")}}"  required value="{{old('phone')}}">
                                    @error('phone')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror

                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{__('main.transportation_company_email')}}</label>
                                    <input type="email" id="Trnsprt-Co-Email" class="form-control @error('email') is-invalid @enderror"
                                           name="email" placeholder="{{__("main.transportation_company_email")}}"  required value="{{old('email')}}">
                                    @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror

                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{__('main.city')}}</label>
                                    <select id="CityToDDL"
                                            class="js-example-tags form-control @error('city_id') is-invalid @enderror"
                                            name="city_id" required>
                                        <option value="">{{__("main.city")}}</option>
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
                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="form-group">
                                        <label class="form-label">Commercial Record (سجل تجاري)</label>
                                        <input type="file" id="Trnsprt-Co-Register" class="form-control @error('company_register') is-invalid @enderror"
                                               name="company_register" placeholder="Commercial Record (سجل تجاري)" >
                                        @error('company_register')
                                            <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror

                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="form-group">
                                        <label class="form-label">Tax Card (بطاقة ضريبية)</label>
                                        <input type="file" id="Trnsprt-Co-Tax" class="form-control @error('tax_id') is-invalid @enderror"
                                               name="tax_id" placeholder="Tax Card (بطاقة ضريبية)"  >
                                        @error('tax_id')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6"></div>
                        </div>
                        <hr>
                        <label>{{__("main.contact_info")}}</label>
                        <div id="contactsAdded" class="row">
                            @if(old('contacts'))
                                @foreach(old('contacts') as $key => $value)
                                    <div class="contact-item row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>{{__('main.contact_name')}}</label>
                                                <input type="text" id="Trnsprt-Contact-Name" class="form-control @error("contacts.{$key}.name") is-invalid @enderror"
                                                       name="contacts[{{$key}}][name]" placeholder="{{__("main.contact_name")}}" @isset(old('contacts')[$key]['name']) value="{{old('contacts')[$key]['name']}}" @endisset>
                                                @error("contacts.{$key}.name")
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>{{__('main.contact_phone')}}</label>
                                                <input type="text" id="Trnsprt-Contact-Mobile" class="form-control mob_no @error("contacts.{$key}.phone") is-invalid @enderror"
                                                       name="contacts[{{$key}}][phone]" placeholder="{{__("main.contact_phone")}}" @isset(old('contacts')[$key]['phone']) value="{{old('contacts')[$key]['phone']}}" @endisset>
                                                @error("contacts.{$key}.phone")
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>{{__('main.contact_email')}}</label>
                                                <input type="email" id="Trnsprt-Contact-Email" class="form-control @error("contacts.{$key}.email") is-invalid @enderror"
                                                       name="contacts[{{$key}}][email]" placeholder="{{__("main.contact_email")}}" @isset(old('contacts')[$key]['email']) value="{{old('contacts')[$key]['email']}}" @endisset>
                                                @error("contacts.{$key}.email")
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6 align-self-center">
                                            <div class="form-group">
                                                @if(!$loop->first)
                                                <a href="#" onclick="$(this).closest('.contact-item').remove();return false;">
                                                    {{__("main.remove_contact")}}
                                                </a>
                                                @else
                                                <a href="#" onclick="addNewContact();return false;">
                                                    + {{__("main.add_new_contact")}}
                                                </a>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <div class="contact-item row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>{{__('main.contact_name')}}</label>
                                            <input type="text" id="Trnsprt-Contact-Name" class="form-control"
                                                   name="contacts[0][name]" placeholder="{{__("main.contact_name")}}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>{{__('main.contact_phone')}}</label>
                                            <input type="text" id="Trnsprt-Contact-Mobile" class="form-control mob_no "
                                                   name="contacts[0][phone]" placeholder="{{__("main.contact_phone")}}" >
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>{{__('main.contact_email')}}</label>
                                            <input type="email" id="Trnsprt-Contact-Email" class="form-control"
                                                   name="contacts[0][email]" placeholder="{{__("main.contact_email")}}">
                                        </div>
                                    </div>
                                    <div class="col-md-6 align-self-center">
                                        <div class="form-group">
                                            <a href="#" onclick="addNewContact();return false;">
                                                + {{__("main.add_new_contact")}}
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                        <hr>
                        <div class="row">

                        </div>
                        <hr>
                        <label>{{__("main.car_and_driver_info")}}</label>
                        <div id="CarsAdded" class="row">
                            <div class="car-item row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                      <label>{{__('main.driver_name')}}</label>  
                                      <input type="text" id="Trnsprt-Driver-Name" class="form-control"
                                               name="cars[0][driver_name]" placeholder="{{__("main.driver_name")}}" required>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                      <label>{{__('main.name_ar')}}</label>  
                                      <input type="text" id="Trnsprt-Driver-NameAr" class="form-control ar_only"
                                               name="cars[0][driver_name_ar]" placeholder="{{__("main.name_ar")}}" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                      <label>{{__('main.driver_phone')}}</label>  
                                      <input type="text" id="Trnsprt-Driver-Mobile" class="form-control mob_no"
                                               name="cars[0][driver_phone]" placeholder="{{__("main.driver_phone")}}" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                      <label>{{__('main.car_type')}}</label>  
                                      <input type="text" id="CarTypeDDL" class="form-control"
                                               name="cars[0][car_type]" placeholder="{{__("main.car_type")}}" required>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>{{__('main.car_model')}}</label>  
                                        <select id="CarModelDDL-0"
                                                class="js-example-tags form-control"
                                                name="cars[0][car_model]" required>
                                            <option value="">{{__("main.car_model")}}</option>
                                            <option value="2021">2021</option>
                                            <option value="2020">2020</option>
                                            <option value="2019">2019</option>
                                            <option value="2018">2018</option>
                                            <option value="2017">2017</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="row form-group">
                                        <div class="col-md-3 align-self-center">
                                            <label for="">{{__("main.car_plate_no")}}</label>
                                        </div>
                                        <div class="col-md-3">
                                            <label>{{__('main.numbers')}}</label>  
                                            <input type="number" id="Trnsprt-Car-Plate-No" class="form-control Required "
                                                   name="cars[0][car_no_seg][0]" maxlength="4" min="0" required>
                                        </div>
                                        <div class="col-md-2">
                                            <label>{{__('main.character')}}</label>
                                            <input type="text" id="Trnsprt-Car-Plate-No" class="form-control "
                                                   name="cars[0][car_no_seg][1]" maxlength="1">
                                        </div>
                                        <div class="col-md-2">
                                            <label>{{__('main.character')}}</label>  
                                            <input type="text" id="Trnsprt-Car-Plate-No" class="form-control Required "
                                                   name="cars[0][car_no_seg][2]" maxlength="1">
                                        </div>
                                        <div class="col-md-2">
                                            <label>{{__('main.character')}}</label>  
                                            <input type="text" id="Trnsprt-Car-Plate-No" class="form-control Required"
                                                   name="cars[0][car_no_seg][3]" maxlength="1">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>{{__('main.driver_license_no')}}</label>    
                                        <input type="text" id="Trnsprt-Driver-License-No" class="form-control"
                                               name="cars[0][driver_no]" placeholder="{{__("main.driver_license_no")}}" required>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>{{__('main.buying_price')}}</label>    
                                        <input id="SGL-Cabin-buy-pric" type="text" class="form-control autonumber "
                                               name="cars[0][buy_price]"
                                               placeholder="{{__("main.buying_price")}}" >
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>{{__('main.currency')}}</label>
                                        <select
                                                class="js-example-tags form-control"
                                                name="cars[0][buy_currency]" required>
                                            @foreach(\App\Models\Currency::availableCurrencies() as $key => $value)
                                                <option value="{{$key}}" >{{$value}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6"></div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>{{__('main.selling_price')}}</label>
                                        <input id="SGL-Cabin-sell-pric" type="text" class="form-control autonumber "
                                               name="cars[0][sell_price_vat_exc]"
                                               placeholder="{{__("main.selling_price")}}" >
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>{{__('main.currency')}}</label>
                                        <select
                                            class="js-example-tags form-control"
                                            name="cars[0][sell_currency]" required>
                                            @foreach(\App\Models\Currency::availableCurrencies() as $key => $value)
                                                <option value="{{$key}}" >{{$value}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6 align-self-center">
                                    <div class="form-group">
                                        <a href="#" onclick="addNewCar();return false;">
                                            + {{__("main.add_car")}}
                                        </a>

                                    </div>
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary">{{__("main.create")}}</button>
                        <button type="button" onclick="window.location.href='{{ route('suppliers.index').'#pills-Transportations-tab' }}';" class="btn btn-outline-primary">{{__("main.cancel")}}</button>
                    </form>

                </div>
            </div>

        </div>
    </div>
@endsection

@section('script_bottom')
    <script>
        var currencies = "@php echo addslashes(json_encode(\App\Models\Currency::availableCurrencies())) @endphp";
        currencies = JSON.parse(currencies);

        var next_contact = 1;
        @if(old('contacts'))
            next_contact = {{max(array_keys(old('contacts'))) + 1}};
        @endif
        var next_car = 1;
        @if(old('cars'))
            next_car = {{max(array_keys(old('cars'))) + 1}};
        @endif
    </script>
@endsection
