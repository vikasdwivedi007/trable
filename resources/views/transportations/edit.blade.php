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
                    <h5>{{__("main.update_transportation")}}</h5>
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
                    <form id="validation-form123" action="{{ route('transportations.update', ['transportation'=>$transportation]) }}" method="POST"  enctype="multipart/form-data">
                        @method('PATCH')
                        @csrf
                        <label>Transportation Company </label>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{__('main.company_code')}}</label>
                                    <input type="text" id="Trnsprt-Co-Code" class="form-control @error('code') is-invalid @enderror"
                                           name="code" placeholder="{{__("main.company_code")}}" value="{{$transportation->code}}">
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
                                           name="name" placeholder="{{__("main.company_name")}}" required value="{{$transportation->name}}">
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
                                           name="name_ar" placeholder="{{__("main.name_ar")}}" required value="{{$transportation->name_ar}}">
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
                                           name="phone" placeholder="{{__("main.transportation_company_phone")}}"  required value="{{$transportation->phone}}">
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
                                           name="email" placeholder="{{__("main.transportation_company_email")}}"  required value="{{$transportation->email}}">
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
                                            <option value="{{$city->id}}" @if($city->id == $transportation->city_id) selected @endif>{{$city->name}}</option>
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
                                    <label class="form-label">Commercial Record (سجل تجاري)</label>
                                    @if($transportation->company_register)
                                        <a href="{{url(\Illuminate\Support\Facades\Storage::url($transportation->company_register->url))}}" target="_blank" style="font-size:20px;">(<i class="feather icon-file"></i>)</a>
                                    @endif
                                    <input type="file" id="Trnsprt-Co-Register" class="form-control @error('company_register') is-invalid @enderror"
                                           name="company_register" placeholder="Commercial Record (سجل تجاري)">
                                    @error('company_register')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror

                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Tax Card (بطاقة ضريبية)</label>
                                    @if($transportation->tax_id)
                                        <a href="{{url(\Illuminate\Support\Facades\Storage::url($transportation->tax_id->url))}}" target="_blank" style="font-size:20px;">(<i class="feather icon-file"></i>)</a>
                                    @endif
                                    <input type="file" id="Trnsprt-Co-Tax" class="form-control @error('tax_id') is-invalid @enderror"
                                           name="tax_id" placeholder="Tax Card (بطاقة ضريبية)" >
                                    @error('tax_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror

                                </div>
                            </div>
                            <div class="col-md-6"></div>
                        </div>
                        <hr>
                        <label>{{__("main.contact_info")}}</label>
                        <div id="contactsAdded" class="row">
                            @if($transportation->contacts->toArray())
                                @foreach($transportation->contacts->toArray() as $key => $value)
                                    <div class="contact-item row">
                                        <input type="hidden" name="contacts[{{$key}}][id]" value="{{$value['id']}}">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>{{__('main.contact_name')}}</label>
                                                <input type="text" id="Trnsprt-Contact-Name" class="form-control @error("contacts.{$key}.name") is-invalid @enderror"
                                                       name="contacts[{{$key}}][name]" placeholder="{{__("main.contact_name")}}" @isset($value['name']) value="{{$value['name']}}" @endisset>
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
                                                       name="contacts[{{$key}}][phone]" placeholder="{{__("main.contact_phone")}}" @isset($value['phone']) value="{{$value['phone']}}" @endisset>
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
                                                       name="contacts[{{$key}}][email]" placeholder="{{__("main.contact_email")}}" @isset($value['email']) value="{{$value['email']}}" @endisset>
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
                        <label>{{__("main.car_and_driver_info")}}</label>
                        <div id="CarsAdded" class="row">

                            @if($transportation->cars->toArray())
                                @foreach($transportation->cars->toArray() as $key => $value)
                                    <div class="car-item row">
                                        <input type="hidden" name="cars[{{$key}}][id]" value="{{$value['id']}}">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>{{__('main.driver_name')}}</label>  
                                                <input type="text" id="Trnsprt-Driver-Name" class="form-control @error("cars.{$key}.driver_name") is-invalid @enderror" required
                                                       name="cars[{{$key}}][driver_name]" placeholder="{{__("main.driver_name")}}" @isset($value['driver_name']) value="{{$value['driver_name']}}" @endisset>
                                                @error("cars.{$key}.driver_name")
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror

                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>{{__('main.name_ar')}}</label>  
                                                <input type="text" id="Trnsprt-Driver-NameAr" class="form-control ar_only @error("cars.{$key}.driver_name_ar") is-invalid @enderror" required
                                                       name="cars[{{$key}}][driver_name_ar]" placeholder="{{__("main.name_ar")}}" @isset($value['driver_name_ar']) value="{{$value['driver_name_ar']}}" @endisset>
                                                @error("cars.{$key}.driver_name_ar")
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror

                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>{{__('main.driver_phone')}}</label>  
                                                <input type="text" id="Trnsprt-Driver-Mobile" class="form-control mob_no @error("cars.{$key}.driver_phone") is-invalid @enderror" required
                                                       name="cars[{{$key}}][driver_phone]" placeholder="{{__("main.driver_phone")}}" @isset($value['driver_phone']) value="{{$value['driver_phone']}}" @endisset>
                                                @error("cars.{$key}.driver_phone")
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>{{__('main.car_type')}}</label>  
                                                <input type="text" id="CarTypeDDL" class="form-control @error("cars.{$key}.car_type") is-invalid @enderror" required
                                                       name="cars[{{$key}}][car_type]" placeholder="{{__("main.car_type")}}" @isset($value['car_type']) value="{{$value['car_type']}}" @endisset>
                                                @error("cars.{$key}.car_type")
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror

                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>{{__('main.car_model')}}</label>
                                                <select id="CarModelDDL-{{$key}}"
                                                        class="js-example-tags form-control @error("cars.{$key}.car_model") is-invalid @enderror" required
                                                        name="cars[{{$key}}][car_model]">
                                                    <option value="">{{__("main.car_model")}}</option>
                                                    <option value="2021" @if($value['car_model'] == 2021) selected @endif>2021</option>
                                                    <option value="2020" @if($value['car_model'] == 2020) selected @endif>2020</option>
                                                    <option value="2019" @if($value['car_model'] == 2019) selected @endif>2019</option>
                                                    <option value="2018" @if($value['car_model'] == 2018) selected @endif>2018</option>
                                                    <option value="2017" @if($value['car_model'] == 2017) selected @endif>2017</option>
                                                </select>
                                                @error("cars.{$key}.car_model")
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="row form-group">
                                                <div class="col-md-3 align-self-center">
                                                    <label for="">{{__("main.car_plate_no")}}</label>
                                                </div>
                                                <div class="col-md-3">
                                                    @php $segments = explode(' ', $value['car_no']) @endphp
                                                    <label>{{__('main.numbers')}}</label>  
                                                    <input type="number" id="Trnsprt-Car-Plate-No" class="form-control Required @error("cars.{$key}.car_no") is-invalid @enderror" required
                                                           name="cars[{{$key}}][car_no_seg][0]" maxlength="4" min="0" @isset($segments[0]) value="{{$segments[0]}}" @endisset>
                                                    @error("cars.{$key}.car_no")
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                    @enderror
                                                </div>
                                                <div class="col-md-2">
                                                    <label>{{__('main.character')}}</label>
                                                    <input type="text" id="Trnsprt-Car-Plate-No" class="form-control "
                                                           name="cars[{{$key}}][car_no_seg][1]" maxlength="1" @isset($segments[1]) value="{{$segments[1]}}" @endisset>
                                                </div>
                                                <div class="col-md-2">
                                                    <label>{{__('main.character')}}</label>
                                                    <input type="text" id="Trnsprt-Car-Plate-No" class="form-control Required "
                                                           name="cars[{{$key}}][car_no_seg][2]" maxlength="1" @isset($segments[2]) value="{{$segments[2]}}" @endisset>
                                                </div>
                                                <div class="col-md-2">
                                                    <label>{{__('main.character')}}</label>
                                                    <input type="text" id="Trnsprt-Car-Plate-No" class="form-control Required"
                                                           name="cars[{{$key}}][car_no_seg][3]" maxlength="1" @isset($segments[3]) value="{{$segments[3]}}" @endisset>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <input type="text" id="Trnsprt-Driver-License-No" class="form-control @error("cars.{$key}.driver_no") is-invalid @enderror" required
                                                       name="cars[{{$key}}][driver_no]" placeholder="{{__("main.driver_license_no")}}" @isset($value['driver_no']) value="{{$value['driver_no']}}" @endisset>
                                                @error("cars.{$key}.driver_no")
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror

                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>{{__('main.buying_price')}}</label>
                                                <input id="SGL-Cabin-buy-pric" type="text" class="form-control autonumber @error("cars.{$key}.buy_price") is-invalid @enderror"
                                                       name="cars[{{$key}}][buy_price]"
                                                       placeholder="{{__("main.buying_price")}}" @isset($value['buy_price']) value="{{$value['buy_price']}}" @endisset>
                                                @error("cars.{$key}.buy_price")
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
                                                    class="js-example-tags form-control"
                                                    name="cars[{{$key}}][buy_currency]" required>
                                                    @foreach(\App\Models\Currency::availableCurrencies() as $keyC => $valueC)
                                                        <option value="{{$keyC}}" @if($value['buy_currency'] == $keyC) selected @endif>{{$valueC}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6"></div>

                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>{{__('main.selling_price')}}</label>
                                                <input id="SGL-Cabin-sell-pric" type="text" class="form-control autonumber @error("cars.{$key}.sell_price_vat_exc") is-invalid @enderror"
                                                       name="cars[{{$key}}][sell_price_vat_exc]"
                                                       placeholder="{{__("main.selling_price")}}" @isset($value['sell_price_vat_exc']) value="{{$value['sell_price_vat_exc']}}" @endisset>
                                                @error("cars.{$key}.sell_price_vat_exc")
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
                                                    class="js-example-tags form-control"
                                                    name="cars[{{$key}}][sell_currency]" required>
                                                    @foreach(\App\Models\Currency::availableCurrencies() as $keyC => $valueC)
                                                        <option value="{{$keyC}}" @if($value['sell_currency'] == $keyC) selected @endif>{{$valueC}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6 align-self-center">
                                            <div class="form-group">
                                                @if(!$loop->first)
                                                    <a href="#" onclick="$(this).closest('.car-item').remove();return false;">
                                                        {{__("main.remove_car")}}
                                                    </a>
                                                @else
                                                    <a href="#" onclick="addNewCar();return false;">
                                                        + {{__("main.add_car")}}
                                                    </a>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <div class="car-item row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <input type="text" id="Trnsprt-Driver-Name" class="form-control"
                                                   name="cars[0][driver_name]" placeholder="{{__("main.driver_name")}}" required>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <input type="text" id="Trnsprt-Driver-NameAr" class="form-control ar_only"
                                                   name="cars[0][driver_name_ar]" placeholder="{{__("main.name_ar")}}" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <input type="text" id="Trnsprt-Driver-Mobile" class="form-control mob_no"
                                                   name="cars[0][driver_phone]" placeholder="{{__("main.driver_phone")}}" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
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
                                                <input type="number" id="Trnsprt-Car-Plate-No" class="form-control Required "
                                                       name="cars[0][car_no_seg][0]" maxlength="4" min="0" required>
                                            </div>
                                            <div class="col-md-2">
                                                <input type="text" id="Trnsprt-Car-Plate-No" class="form-control "
                                                       name="cars[0][car_no_seg][1]" maxlength="1">
                                            </div>
                                            <div class="col-md-2">
                                                <input type="text" id="Trnsprt-Car-Plate-No" class="form-control Required "
                                                       name="cars[0][car_no_seg][2]" maxlength="1">
                                            </div>
                                            <div class="col-md-2">
                                                <input type="text" id="Trnsprt-Car-Plate-No" class="form-control Required"
                                                       name="cars[0][car_no_seg][3]" maxlength="1">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <input type="text" id="Trnsprt-Driver-License-No" class="form-control"
                                                   name="cars[0][driver_no]" placeholder="{{__("main.driver_license_no")}}" required>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <input id="SGL-Cabin-buy-pric" type="text" class="form-control autonumber "
                                                   name="cars[0][buy_price]"
                                                   placeholder="{{__("main.buying_price")}}" required>
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
                                            <input id="SGL-Cabin-sell-pric" type="text" class="form-control autonumber "
                                                   name="cars[0][sell_price_vat_exc]"
                                                   placeholder="{{__("main.selling_price")}}" required>
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
                            @endif
                        </div>

                        <button type="submit" class="btn btn-primary">{{__("main.update")}}</button>
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
        @if($transportation->contacts->count())
            next_contact = {{$transportation->contacts->count()}};
        @endif
        var next_car = 1;
        @if($transportation->cars->count())
            next_car = {{$transportation->cars->count()}};
        @endif
    </script>
@endsection
