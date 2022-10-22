@extends('layouts.main')

@section('script_top')
    <style>
        .contact-item, .menu-item{
            display: contents;
        }
    </style>
@endsection

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h5>{{__("main.create_new_restaurant")}}</h5>
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
                    <form id="validation-form123" action="{{ route('restaurants.store') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{__('main.restaurant_name')}}</label>
                                    <input type="text" id="Restaurant-Name" class="form-control @error('name') is-invalid @enderror" 
                                            name="name" placeholder="{{__("main.restaurant_name")}}" required value="{{old('name')}}">
                                    @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{__('main.city')}}</label>
                                    <select id="CityToDDL" class="js-example-tags form-control @error('city_id') is-invalid @enderror" name="city_id" required">
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
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{__('main.restaurant_address')}}</label>
                                    <input type="text" id="Restaurant-Address"
                                           class="form-control @error('address') is-invalid @enderror" placeholder="{{__("main.restaurant_address")}}" name="address" required value="{{old('address')}}">
                                    @error('address')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror

                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{__('main.restaurant_phone')}}</label>
                                    <input type="text" id="Restaurant-Phn" class="form-control mob_no @error('phone') is-invalid @enderror" 
                                          name="phone" placeholder="{{__("main.restaurant_phone")}}" required value="{{old('phone')}}">
                                    @error('phone')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{__('main.Restaurant_Email')}}</label>
                                    <input type="email" id="Restaurant-Email" class="form-control @error('email') is-invalid @enderror" 
                                    name="email" placeholder="{{__('main.Restaurant_Email')}}"  value="{{old('email')}}">
                                    @error('email')
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
                        <div id="restrntContactsAdded" class="row">
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
                                                    <a href="#" onclick="addNewRestrntContact();return false;">
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
                                            <a href="#" onclick="addNewRestrntContact();return false;">
                                                + {{__("main.add_new_contact")}}
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                        <hr>

                        <label>{{__("main.menu_info")}}</label>
                        <div id="FoodMenuAdded" class="row">
                            @if(old('menus'))
                                @foreach(old('menus') as $key => $value)
                                    <div class="menu-item row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>{{__('main.food_menu_name')}}</label>                                                
                                                <input type="text" id="Food-Menu-Name" class="form-control @error("menus.{$key}.name") is-invalid @enderror" 
                                                        name="menus[{{$key}}][name]" placeholder="{{__("main.food_menu_name")}}" @isset(old('menus')[$key]['name']) value="{{old('menus')[$key]['name']}}" @endisset>
                                                @error("menus.{$key}.name")
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
                                                    {{__("main.remove_food_menu")}}
                                                </a>
                                                @else
                                                <a href="#" onclick="addNewFoodMenu();return false;">
                                                    + {{__("main.add_food_menu")}}
                                                </a>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>{{__('main.menu_items')}}</label>
                                                <textarea placeholder="{{__("main.menu_items")}}" class="form-control @error("menus.{$key}.items") is-invalid @enderror" name="menus[{{$key}}][items]" rows="7">@isset(old('menus')[$key]['items']) {{old('menus')[$key]['items']}} @endisset</textarea>
                                                @error("menus.{$key}.items")
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6"></div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>{{__('main.buying_price')}}</label>
                                                <input id="Food-Menu-buy-pric" type="text"
                                                       class="form-control autonumber @error("menus.{$key}.buy_price") is-invalid @enderror"
                                                       name="menus[{{$key}}][buy_price]"
                                                       placeholder="{{__("main.buying_price")}}" @isset(old('menus')[$key]['buy_price']) value="{{old('menus')[$key]['buy_price']}}" @endisset>
                                                @error("menus.{$key}.buy_price")
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
                                                    class="js-example-tags form-control @error('menus.{$key}.buy_currency') is-invalid @enderror"
                                                    name="menus[{{$key}}][buy_currency]" required>
                                                    @foreach(\App\Models\Currency::availableCurrencies() as $keyC => $valueC)
                                                        <option value="{{$keyC}}" @if(isset(old('menus')[$key]['buy_currency']) && old('menus')[$key]['buy_currency'] == $keyC) selected @endif>{{$valueC}}</option>
                                                    @endforeach
                                                </select>
                                                @error("menus.{$key}.buy_currency")
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>{{__('main.selling_price')}}</label>
                                                <input id="Food-Menu-sell-pric" type="text"
                                                       class="form-control autonumber @error("menus.{$key}.sell_price_vat_exc") is-invalid @enderror"
                                                       name="menus[{{$key}}][sell_price_vat_exc]"
                                                       placeholder="{{__("main.selling_price")}}" @isset(old('menus')[$key]['sell_price_vat_exc']) value="{{old('menus')[$key]['sell_price_vat_exc']}}" @endisset>
                                                @error("menus.{$key}.sell_price_vat_exc")
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
                                                    class="js-example-tags form-control @error('menus.{$key}.sell_currency') is-invalid @enderror"
                                                    name="menus[{{$key}}][sell_currency]" required>
                                                    @foreach(\App\Models\Currency::availableCurrencies() as $keyC => $valueC)
                                                        <option value="{{$keyC}}" @if(isset(old('menus')[$key]['sell_currency']) && old('menus')[$key]['sell_currency'] == $keyC) selected @endif>{{$valueC}}</option>
                                                    @endforeach
                                                </select>
                                                @error("menus.{$key}.sell_currency")
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <div class="menu-item row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>{{__('main.food_menu_name')}}</label>
                                            <input type="text" id="Food-Menu-Name" class="form-control @error("menus.0.name") is-invalid @enderror" name="menus[0][name]" placeholder="{{__("main.food_menu_name")}}" @isset(old('menus')[0]['name']) value="{{old('menus')[0]['name']}}" @endisset>
                                            @error("menus.{0}.name")
                                            <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6 align-self-center">
                                        <div class="form-group">
                                            <a href="#" onclick="addNewFoodMenu();return false;">
                                                + {{__("main.add_food_menu")}}
                                            </a>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>{{__('main.menu_items')}}</label>
                                            <textarea placeholder="{{__("main.menu_items")}}" class="form-control @error("menus.0.items") is-invalid @enderror" name="menus[0][items]" rows="7">@isset(old('menus')[0]['items']) {{old('menus')[0]['items']}} @endisset</textarea>
                                            @error("menus.0.items")
                                            <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6"></div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>{{__('main.buying_price')}}</label>
                                            <input id="Food-Menu-buy-pric" type="text"
                                                   class="form-control autonumber @error("menus.0.buy_price") is-invalid @enderror"
                                                   name="menus[0][buy_price]"
                                                   placeholder="{{__("main.buying_price")}}" @isset(old('menus')[0]['buy_price']) value="{{old('menus')[0]['buy_price']}}" @endisset>
                                            @error("menus.0.buy_price")
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
                                                class="js-example-tags form-control @error('buy_currency') is-invalid @enderror"
                                                name="menus[0][buy_currency]" required>
                                                @foreach(\App\Models\Currency::availableCurrencies() as $key => $value)
                                                    <option value="{{$key}}" @if(old('buy_currency') == $key) selected @endif>{{$value}}</option>
                                                @endforeach
                                            </select>
                                            @error('buy_currency')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>{{__('main.selling_price')}}</label>
                                            <input id="Food-Menu-sell-pric" type="text"
                                                   class="form-control autonumber @error("menus.0.sell_price_vat_exc") is-invalid @enderror"
                                                   name="menus[0][sell_price_vat_exc]"
                                                   placeholder="{{__("main.selling_price")}}" @isset(old('menus')[0]['sell_price_vat_exc']) value="{{old('menus')[0]['sell_price_vat_exc']}}" @endisset>
                                            @error("menus.0.sell_price_vat_exc")
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
                                                class="js-example-tags form-control @error('sell_currency') is-invalid @enderror"
                                                name="menus[0][sell_currency]" required>
                                                @foreach(\App\Models\Currency::availableCurrencies() as $key => $value)
                                                    <option value="{{$key}}" @if(old('sell_currency') == $key) selected @endif>{{$value}}</option>
                                                @endforeach
                                            </select>
                                            @error('sell_currency')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>



                        <button type="submit" class="btn btn-primary">{{__("main.create")}}</button>
                        <button type="button" onclick="window.location.href='{{ route('suppliers.index').'#pills-Restaurants-tab' }}';" class="btn btn-outline-primary">{{__("main.cancel")}}</button>

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
        var next_menu = 1;
        @if(old('menu'))
            next_menu = {{max(array_keys(old('menu'))) + 1}};
        @endif
    </script>
@endsection
