@extends('layouts.main')

@section('script_top_before_base')
    <link rel="stylesheet" href="{{asset('assets/plugins/smart-wizard/css/smart_wizard.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/plugins/smart-wizard/css/smart_wizard_theme_arrows.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/plugins/smart-wizard/css/smart_wizard_theme_circles.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/plugins/smart-wizard/css/smart_wizard_theme_dots.min.css')}}">
    <style>
        .room_prices .table-borderedtable, .room_prices .table-bordered th, .room_prices .table-bordered td {
            border: 1px solid #3B6EAF;
            border-collapse: collapse;
        }
        .room_prices .table-bordered th, .room_prices .table-bordered td{
            padding: 0.5rem 0.5rem;
            font-weight: 900;
        }
        .accommodation-item{
            border-bottom: 1px solid #727272;
            margin-bottom: 15px;
        }
        .accommodation-item:last-of-type{
            border-bottom: 0px;
        }
    </style>
@endsection

@section('content')
    <div class="row">
        <!-- [ Smart-Wizard ] start -->
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h5>{{__("main.create_new_file")}}</h5>
                </div>
                <div class="card-block">
                    <!-- [ SmartWizard html ] start -->
                    <div id="smartwizard">
                        <ul>
                            <li>
                                <a href="#Basic-Information">
                                    <h6>1</h6>
                                    <p class="m-0">{{__("main.basic_information")}}</p>
                                </a>
                            </li>
                            <li>
                                <a href="#Additional-Information">
                                    <h6>2</h6>
                                    <p class="m-0">{{__("main.additional_information")}}</p>
                                </a>
                            </li>
                            <li>
                                <a href="#Accommodations">
                                    <h6>3</h6>
                                    <p class="m-0">{{__("main.accommodations")}}</p>
                                </a>
                            </li>
                            <li>
                                <a href="#Flights">
                                    <h6>4</h6>
                                    <p class="m-0">{{__("main.flights")}}</p>
                                </a>
                            </li>
                            <li>
                                <a href="#Tour-Guide">
                                    <h6>5</h6>
                                    <p class="m-0">{{__("main.tour_guide")}}</p>
                                </a>
                            </li>
                            <li>
                                <a href="#Program">
                                    <h6>6</h6>
                                    <p class="m-0">{{__("main.program")}}</p>
                                </a>
                            </li>
                        </ul>
                        <div>
                            <div id="Basic-Information">
                                <form method="POST" action="#">
                                    <button type="submit" style="display: none;"></button>
                                    <div class="row justify-content-center">
                                        <div class="col-xl-4 col-lg-12">
                                            <div class="form-group">
                                                <label>{{__('main.travel_agent')}} *</label>
                                                <select id="joTravelAgentDDL"
                                                        class="js-example-tags form-control"
                                                        name="travel_agent_id" required>
                                                    <option value="">{{__("main.travel_agent")}} *</option>
                                                    @foreach($travel_agents as $travel_agent)
                                                        <option
                                                            value="{{$travel_agent->id}}">{{$travel_agent->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-xl-3 col-lg-12">
                                            <div class="form-group">
                                                <label>{{__('main.file_no')}}</label>
                                                <input type="text" id="FileNo" class="form-control" disabled>
                                            </div>
                                        </div>
                                        <div class="col-xl-3 col-lg-12">
                                            <div class="form-group">
                                            <label>{{__('main.command_no')}}</label>
                                            <input type="text" id="CommandNo"
                                                       class="form-control" name="command_no">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row justify-content-center">
                                        <div class="col-xl-4 col-lg-12">
                                            <div class="form-group">
                                                <label>{{__('main.client_name')}} *</label>
                                                <input type="text" id="ClientName"
                                                       class="form-control" name="client_name" required>
                                            </div>
                                        </div>
                                        <div class="col-xl-3 col-lg-12">
                                            <div class="form-group">
                                                <label>{{__('main.number_of_adults')}} *</label>
                                                <select id="joNoAdultsDDL"
                                                        class="js-example-tags form-control"
                                                        name="adults_count" required>
                                                    <option value="">{{__("main.number_of_adults")}} *</option>
                                                    <option value="1">1</option>
                                                    <option value="2">2</option>
                                                    <option value="3">3</option>
                                                    <option value="4">4</option>
                                                    <option value="5">5</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-xl-3 col-lg-12">
                                            <div class="form-group">
                                                <label>{{__('main.number_of_children')}} *</label>
                                                <select id="joNoChildrentDDL"
                                                        class="js-example-tags form-control"
                                                        name="children_count" required>
                                                    <option value="">{{__("main.number_of_children")}} *</option>
                                                    <option value="0">0</option>
                                                    <option value="1">1</option>
                                                    <option value="2">2</option>
                                                    <option value="3">3</option>
                                                    <option value="4">4</option>
                                                    <option value="5">5</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row justify-content-center">
                                        <div class="col-xl-5 col-lg-12">
                                            <div class="form-group">
                                                <label>{{__('main.nationality_of_group')}}</label>
                                                <select id="joNationalityGroupDDL"
                                                        class="js-example-tags form-control"
                                                        name="country_id" required>
                                                    <option value="">{{__("main.nationality_of_group")}}</option>
                                                    @foreach($countries as $country)
                                                        <option value="{{$country->id}}">{{$country->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-xl-5 col-lg-12">
                                            <div class="form-group">
                                                <div class="form-group">
                                                    <label>{{__('main.client_language')}}</label>
                                                    <select id="joCustomerLanguageDDL"
                                                            class="js-example-tags form-control"
                                                            name="language_id" required>
                                                        <option value="">{{__("main.client_language")}}</option>
                                                        @foreach($languages as $language)
                                                            <option
                                                                value="{{$language->id}}">{{$language->language}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row justify-content-center">
                                        <div class="col-xl-3 col-lg-12">
                                            <div class="form-group">
                                                <label>{{__('main.arrival_date')}} *</label>
                                                <input type="text" id="Arrival-date-job"
                                                       class="form-control" name="arrival_date" required>
                                            </div>
                                        </div>
                                        <div class="col-xl-3 col-lg-12">
                                            <div class="form-group">
                                                <div class="form-group">
                                                    <label>{{__('main.search_for_airport')}}</label>
                                                    <select id="joAirArrivalByDDL"
                                                            class="js-example-tags form-control"
                                                            name="airport_to_id" required>
                                                        <option value="">{{__("main.arrival_at")}} ({{__("main.search_for_airport")}})*</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xl-2 col-lg-12">
                                            <div class="form-group">
                                                <label>{{__('main.arrival_flight')}}</label>
                                                <input type="text" id="Arrival-flight"
                                                       class="form-control" name="arrival_flight" >
                                            </div>
                                        </div>
                                        <div class="col-xl-2 col-lg-12">
                                            <div class="form-group">
                                                <label>{{__('main.arrival_time')}} *</label>
                                                <input type="text" id="Arrival-time"
                                                       class="form-control time"
                                                        name="arrival_time" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row justify-content-center">
                                        <div class="col-xl-3 col-lg-12">
                                            <div class="form-group">
                                                <label>{{__('main.departure_date')}} *</label>
                                                <input type="text" id="Departure-date-job"
                                                       class="form-control"
                                                       name="departure_date" required>
                                            </div>
                                        </div>

                                        <div class="col-xl-3 col-lg-12">

                                            <div class="form-group">
                                                <label>{{__('main.search_for_airport')}}</label>
                                                <select id="joAirDepartureByDDL"
                                                        class="js-example-tags form-control"
                                                        name="airport_from_id" required>
                                                    <option value="">{{__("main.departure_at")}} ({{__("main.search_for_airport")}})*</option>
                                                </select>
                                            </div>

                                        </div>
                                        <div class="col-xl-2 col-lg-12">
                                            <div class="form-group">
                                                <label>{{__('main.departure_flight')}}</label>
                                                <input type="text" id="Departure-flight"
                                                       class="form-control"
                                                       name="departure_flight" >
                                            </div>
                                        </div>
                                        <div class="col-xl-2 col-lg-12">
                                            <div class="form-group">
                                                <label>{{__('main.departure_time')}} *</label>
                                                <input type="text" id="Departure-time"
                                                       class="form-control time"
                                                       name="departure_time" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row justify-content-center">
                                        <div class="col-xl-5 col-lg-12">
                                            <div class="form-group">
                                                <label>{{__('main.client_phone')}}</label>
                                                <input type="text" id="ClientMobNo"
                                                       class="form-control mob_no" name="client_phone">
                                            </div>
                                        </div>
                                        <div class="col-xl-5 col-lg-12">
                                            <div class="form-group">
                                                <label>{{__('main.request_date')}}</label>
                                                <input type="text" id="Request-date"
                                                       class="form-control" name="request_date" required>
                                            </div>
                                        </div>
                                    </div>

                                </form>
                            </div>
                            <div id="Additional-Information">
                                <form method="POST" action="#">
                                    <button type="submit" style="display: none;"></button>
                                    <div class="row justify-content-center">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>{{__('main.profiling')}}</label>
                                                <textarea class="form-control"
                                                          name="profiling" rows="6"></textarea>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                            <label>{{__('main.remarks')}}</label>
                                                <textarea class="form-control"
                                                          name="remarks" rows="6"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row justify-content-center">
                                        <div class="col-md-10 text-center">
                                            <div class="checkbox checkbox-fill d-inline mr-3 mt-3">
                                            <input type="checkbox"
                                                       id="checkbox-fill-Notify-Police"
                                                       name="notify_police">
                                                <label for="checkbox-fill-Notify-Police"
                                                       class="cr">{{__("main.notify_police")}}</label>
                                            </div>
                                            <div class="checkbox checkbox-fill d-inline mr-3 mt-3">
                                            <input type="checkbox"
                                                       id="checkbox-fill-Service-Conciergerie"
                                                       name="service_conciergerie">
                                                <label for="checkbox-fill-Service-Conciergerie"
                                                       class="cr">{{__("main.concierge_service")}}</label>
                                            </div>
                                            <div class="checkbox checkbox-fill d-inline mr-3 mt-3">
                                            <input type="checkbox"
                                                       id="checkbox-fill-Router"
                                                       name="router">
                                                <label for="checkbox-fill-Router"
                                                       class="cr">{{__("main.router")}}</label>
                                            </div>
                                            <div class="checkbox checkbox-fill d-inline mr-3 mt-3">
                                            <input type="checkbox"
                                                       id="checkbox-fill-Pro-forma"
                                                       name="proforma">
                                                <label for="checkbox-fill-Pro-forma"
                                                       class="cr">{{__("main.pro_forma")}}</label>
                                            </div>
                                            <div class="checkbox checkbox-fill d-inline mr-3 mt-3">
                                            <input type="checkbox"
                                                       id="checkbox-fill-Travel-Visa"
                                                       name="visa">
                                                <label for="checkbox-fill-Travel-Visa"
                                                       class="cr">{{__("main.travel_visa")}}</label>
                                            </div>
                                            <div class="checkbox checkbox-fill d-inline mr-6 mt-6">
                                            <input type="checkbox"
                                                       id="checkbox-fill-Gift"
                                                       name="gifts">
                                                <label for="checkbox-fill-Gift"
                                                       class="cr">{{__("main.gift")}}</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="RouterDetails" class="d-none">
                                        <div class="row justify-content-center">
                                            <div class="col-md-8">
                                                <div class="card-header">
                                                    <h5>{{__("main.router_details")}}</h5>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row justify-content-center">
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label>{{__('main.routers')}}</label>
                                                    <select id="joRoutersDDL"
                                                            class="js-example-tags form-control"
                                                            name="router_id">
                                                        <option value="">{{__("main.routers")}} *</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label>{{__('main.days_count')}}</label>
                                                    <input type="text" id="Router-Days-Count"
                                                           class="form-control mob_no" name="days_count" required>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label>{{__('main.package_quota')}}</label>
                                                    <input type="text" id="Package-Quota"
                                                           class="form-control" disabled>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label>{{__('main.package_price')}}</label>
                                                    <input type="text" id="Package-Price"
                                                           class="form-control" disabled>
                                                </div>
                                            </div>

                                        </div>
                                        <hr>
                                    </div>
                                    <div id="ServiceDetails" class="d-none">
                                        <div class="row justify-content-center">
                                            <div class="col-md-8">
                                                <div class="card-header">
                                                    <h5>{{__("main.concierge_details")}}</h5>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row justify-content-center">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>{{__('main.available_employees')}}</label>
                                                    <select id="joServiceEmpDDL"
                                                            class="js-example-tags form-control"
                                                            name="concierge_emp_id">
                                                        <option value="">{{__("main.available_employees")}} *</option>
                                                        @foreach($concierge_emps as $emp)
                                                            <option value="{{$emp->id}}">{{$emp->user->name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                            </div>
                                        </div>
                                        <hr>
                                    </div>
                                    <div id="VisaDetails" class="d-none">
                                        <div class="row justify-content-center">
                                            <div class="col-md-8">
                                                <div class="card-header">
                                                    <h5>{{__("main.visa_details")}}</h5>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row justify-content-center">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>{{__('main.available_visas')}}</label>
                                                    <select id="joVisasDDL"
                                                            class="js-example-tags form-control"
                                                            name="visa_id">
                                                        <option value="">{{__("main.available_visas")}} *</option>
                                                        @foreach($visas as $visa)
                                                            <option value="{{$visa->id}}" data-price="{{$visa->sell_price}}" data-currency="{{\App\Models\Currency::currencyName($visa->sell_currency)}}">{{$visa->name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label>{{__('main.visas_count')}}</label>
                                                    <input type="text" id="Visa-Count"
                                                           class="form-control mob_no" name="visas_count" required>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                  <label>{{__('main.visas_price')}}</label>
                                                  <input type="text" id="Visa-Price"
                                                           class="form-control" disabled>
                                                </div>
                                            </div>

                                        </div>
                                        <hr>
                                    </div>
                                    <div id="GiftDetails" class="d-none">
                                        <div class="row justify-content-center">
                                            <div class="col-md-8">
                                                <div class="card-header">
                                                    <h5>{{__("main.gift_details")}}</h5>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row justify-content-center gift_item">
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label>{{__('main.gifts')}}</label>
                                                    <select
                                                            class="js-example-tags form-control joGiftsDDL" required>
                                                        <option value="">{{__("main.gifts")}} *</option>
                                                        @foreach($gifts as $gift)
                                                            <option value="{{$gift->id}}" data-price="{{$gift->sell_price}}" data-currency="{{\App\Models\Currency::currencyName($gift->sell_currency)}}">{{$gift->name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label>{{__('main.gifts_count')}}</label>
                                                    <input type="text"
                                                           class="form-control Gifts-Count mob_no" required>
                                                </div>
                                            </div>

                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label>{{__('main.gifts_price')}}</label>
                                                    <input type="text"
                                                           class="form-control Gift-Price" disabled>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <a href="#" class="add_item" onclick="AddNewGift();return false;">+ {{__("main.add_new_gift")}}</a>
                                                    <a href="#" style="display: none;" class="remove_item" onclick="$(this).closest('.row').remove();return false;">- {{__("main.remove_gift")}}</a>
                                                </div>
                                            </div>

                                        </div>
                                        <hr>
                                    </div>
                                </form>
                            </div>
                            <div id="Accommodations">
                                <div id="acc_wrapper">
                                    <form class="accommodation-item" method="POST" action="#">
                                        <button type="submit" style="display: none;"></button>

                                        <div class="row justify-content-center">
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label>{{__('main.city')}} *</label>
                                                    <select class="js-example-tags form-control joHCitiesDDL"
                                                            name="city_id" >
                                                        <option value="">{{__("main.city")}} *</option>
                                                        @foreach($cities as $city)
                                                            <option value="{{$city->id}}">{{$city->name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label>{{__('main.hotel_name')}} *</label>
                                                    <select class="js-example-tags form-control joHotelsDDL"
                                                            name="accommodations[0][hotel_id]" required disabled>
                                                        <option value="">{{__("main.hotel_name")}} *</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label>{{__('main.room_view')}} *</label>
                                                    <select class="js-example-tags form-control joRoomViewsDDL"
                                                            name="accommodations[0][view]" required disabled>
                                                        <option value="">{{__("main.room_view")}} *</option>
                                                        <option value="Garden View">Garden View</option>
                                                        <option value="Nile View">Nile View</option>
                                                        <option value="Pool View">Pool View</option>
                                                        <option value="Pyramids View">Pyramids View</option>
                                                    </select>
                                                </div>
                                            </div>


                                        </div>
                                        <div class="row justify-content-center">
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label>{{__('main.room_category')}} *</label>
                                                    <select class="js-example-tags form-control joRoomCategoriesDDL"
                                                            name="accommodations[0][category]" required disabled>
                                                        <option value="">{{__("main.room_category")}} *</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label>{{__('main.type')}} *</label>
                                                    <select class="js-example-tags form-control joRoomTypesDDL"
                                                            name="accommodations[0][room_type]" required disabled>
                                                        <option value="">{{__("main.type")}} *</option>
                                                        <option value="1">Single</option>
                                                        <option value="2">Double</option>
                                                        <option value="3">Triple</option>
                                                        <option value="4">Quad</option>
                                                        <option value="6">King</option>
                                                        <option value="7">Twin</option>
                                                        <option value="8">suite</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row justify-content-center">
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label>{{__('main.meal_plan')}} *</label>
                                                    <select class="js-example-tags form-control joMealPlansDDL"
                                                            name="accommodations[0][meal_plan]" required disabled>
                                                        <option value="">{{__("main.meal_plan")}} *</option>
                                                        <option value="1">BB</option>
                                                        <option value="2">HB</option>
                                                        <option value="3">FB</option>
                                                        <option value="4">AI</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label>{{__('main.situation')}} *</label>
                                                    <select class="js-example-tags form-control joSituationDDL"
                                                            name="accommodations[0][situation]" required disabled>
                                                        <option value="">{{__("main.situation")}} *</option>
                                                        <option value="OK">OK</option>
                                                        <option value="Waiting List">Waiting List</option>
                                                        <option value="Not Available">Not Available</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row justify-content-center">
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                <label>{{__('main.check_in_date')}} *</label>
                                                <input type="text"
                                                           class="form-control date-Valid-From"
                                                           disabled name="accommodations[0][check_in]" required>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                <label>{{__('main.check_out_date')}} *</label>
                                                <input type="text"
                                                           class="form-control date-Valid-To"
                                                           name="accommodations[0][check_out]" disabled required>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="row justify-content-center">
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <div class="form-group">
                                                        <label>{{__('main.payment_date')}}</label>
                                                        <input type="text"
                                                               class="form-control HotelPaymentDate"
                                                               name="accommodations[0][payment_date]" disabled >
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <div class="form-group">
                                                        <label>{{__('main.voucher_date')}}</label>
                                                        <input type="text"
                                                               class="form-control HotelVoucherDate"
                                                               name="accommodations[0][voucher_date]"
                                                               disabled >
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row justify-content-center">
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <div class="form-group">
                                                    <label>{{__('main.cancellation_fees')}}</label>
                                                    <input type="text"
                                                               class="form-control autonumber CancelationFees" disabled>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                <label>Before 1 day</label>
                                                <input type="text"
                                                           class="form-control autonumber TimePreiod" disabled>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row justify-content-center room_prices d-none">

                                        </div>
                                        <div class="row justify-content-center">
                                            <div class="col-md-6">
                                                <div class="reset_item form-group float-left">
                                                    <a href="#" onclick="resetAccommodationForm($(this));return false;">
                                                        {{__("main.clear")}}
                                                    </a>
                                                </div>
                                                <div class="remove_item form-group float-left" style="display:none;">
                                                    <a href="#" onclick="$(this).closest('form').remove();return false;">
                                                        {{__("main.remove_accommodation")}}
                                                    </a>
                                                </div>
                                                <div class="form-group float-right">
                                                    <a href="#" onclick="addNewAccommodation();return false;">
                                                        + {{__("main.add_new_accommodation")}}
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>

                                <hr>
                                <form id="train-form" method="POST" action="#">
                                    <button type="submit" style="display: none;"></button>

                                    <div class="row justify-content-center">
                                        <div class="col-md-8">
                                            <div
                                                class="checkbox checkbox-fill d-inline mr-3 mt-3">
                                                <input type="checkbox" name="checkbox-fill-1"
                                                       id="checkbox-fill-Train-Ticket"
                                                       class="checkbox-fill-Train-Ticket">
                                                <label for="checkbox-fill-Train-Ticket"
                                                       class="cr">{{__("main.train_ticket")}}</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="TrainTicketDetails bg-light mx-4 py-3 my-2 d-none">
                                        <div class="train-item">
                                        <input type="hidden" class="train_id" name="train_tickets[]" value="">
                                            <div class="row justify-content-center">
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                    <label>{{__('main.train_number')}}</label>
                                                    <input type="text"
                                                               class="form-control Train-Number" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                    <label>{{__('main.type')}}</label>
                                                    <input type="text"
                                                               class="form-control Train-Type" disabled>
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                    <label>{{__('main.from_city')}}</label>
                                                    <input type="text"
                                                               class="form-control City-From" disabled>
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                    <label>{{__('main.to_city')}}</label>
                                                    <input type="text"
                                                               class="form-control City-To" disabled>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row justify-content-center">
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                    <label>{{__('main.departure_date')}}</label>
                                                    <input type="text"
                                                               class="form-control Train-Departure-date">
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                    <label>{{__('main.departure_time')}}</label>
                                                    <input type="text"
                                                               class="form-control Train-Departure-Time" disabled>
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                    <label>{{__('main.arrival_date')}}</label>
                                                    <input type="text"
                                                               class="form-control Train-Arrival-date" disabled>
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                    <label>{{__('main.arrival_time')}}</label>
                                                    <input type="text"
                                                               class="form-control Train-Arrival-Time" disabled>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row justify-content-center">

                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                    <label>{{__('main.wagon_no')}}</label>
                                                    <input type="text"
                                                               class="form-control  Wagon-Number" disabled>
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                    <label>{{__('main.seat_bed_no')}}</label>
                                                    <input type="text"
                                                               class="form-control  Seat-Number" disabled>
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                    <label>{{__('main.class')}}</label>
                                                    <input type="text"
                                                               class="form-control Train-Class" disabled>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row justify-content-center">
                                                <div class="col-md-1 align-self-center">
                                                    <div class="form-group">
                                                        {{__("main.price")}}
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                    <input type="text" class="form-control adult_price"
                                                               disabled>
                                                    </div>
                                                </div>
                                                <div class="col-md-1 align-self-center">
                                                    <div class="form-group">
                                                        {{__("main.total")}}
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                    <input type="text" class="form-control total_price"
                                                               disabled>
                                                    </div>
                                                </div>

                                            </div>

                                            <div class="row justify-content-center">
                                                <div class="col-md-7">
                                                    <div class="remove_item form-group float-left" style="display:none;">
                                                        <a href="#" onclick="$(this).closest('.train-item').remove();return false;">
                                                            {{__("main.remove_ticket")}}
                                                        </a>
                                                    </div>
                                                    <div class="form-group float-right">
                                                        <a href="#" onclick="addTrainTicket($(this));return false;">
                                                            + {{__("main.add_another_ticket")}}
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </form>
                                <hr>

                                <form  id="cruise-form" method="POST" action="#">
                                    <button type="submit" style="display: none;"></button>

                                    <div class="row justify-content-center">
                                        <div class="col-md-8">
                                            <div
                                                class="checkbox checkbox-fill d-inline mr-3 mt-3">
                                                <input type="checkbox" name="checkbox-fill-1"
                                                       id="checkbox-fill-Nile-Curise"
                                                       class="checkbox-fill-Nile-Curise">
                                                <label for="checkbox-fill-Nile-Curise"
                                                       class="cr">{{__("main.nile_cruise")}}</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="NileCuriseDetails bg-light mx-4 py-3 my-2 d-none">
                                        <h6 style="text-align: center;">{{__("main.cruises_based_on_arrival_departure_dates")}}</h6>
                                        <div class="cruise-item">

                                            <div class="row justify-content-center ">
                                                <div class="col-md-5">
                                                    <div class="form-group">
                                                        <div class="form-group">
                                                            <label>{{__('main.from_city')}}</label>
                                                            <select class="js-example-tags form-control joNileCruisesCitiesDDL"
                                                            name="city_from" >
                                                                <option value="">{{__("main.from_city")}} *</option>
                                                                @foreach($cities as $city)
                                                                    <option value="{{$city->id}}">{{$city->name}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-5">
                                                    <div class="form-group">
                                                        <label>{{__('main.select_nile_cruise')}}</label>
                                                        <select
                                                            class="js-example-tags form-control joNileCruisesDDL"
                                                            name="validation-select" disabled>
                                                            <option value="">{{__("main.select_nile_cruise")}}
                                                            </option>
                                                        </select>
                                                    </div>
                                                </div>

                                            </div>

                                            <div class="row justify-content-center ">

                                                <div class="col-md-5">
                                                    <div class="form-group">
                                                        <label>{{__('main.available_dates')}}</label>
                                                        <select
                                                            class="js-example-tags form-control nile_cruise_date"
                                                            name="validation-select" disabled>
                                                            <option value="">{{__("main.available_dates")}}
                                                            </option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="col-md-5">
                                                    <div class="form-group">
                                                        <div class="form-group">
                                                        <label>{{__('main.to_city')}}</label>
                                                        <input type="text" class="form-control city_to" disabled>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                            <div class="row justify-content-center ">

                                                <div class="col-md-5">
                                                    <div class="form-group">
                                                        <label>{{__('main.type')}}</label>
                                                        <select
                                                            class="js-example-tags form-control cabin_type"
                                                            name="validation-select" disabled>
                                                            <option value="">{{__("main.type")}}
                                                            </option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-5">
                                                    <div class="form-group">
                                                        <label>{{__('main.cabin_suite_type')}}</label>
                                                        <select
                                                            class="js-example-tags form-control room_type"
                                                            name="validation-select" disabled>
                                                            <option value="">{{__("main.cabin_suite_type")}}
                                                            </option>
                                                        </select>
                                                    </div>
                                                </div>

                                            </div>
                                            <div class="row justify-content-center ">
                                                <div class="col-md-5">
                                                    <div class="form-group">
                                                        <label>{{__('main.deck')}}</label>
                                                        <select
                                                            class="js-example-tags form-control deck_type"
                                                            name="validation-select" disabled>
                                                            <option value="">{{__("main.deck")}}
                                                            </option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-5">
                                                    <div class="form-group">
                                                        <label>{{__('main.including_sightseeing')}}</label>
                                                        <select
                                                            class="js-example-tags form-control including_sightseeing"
                                                            name="validation-select" disabled>
                                                            <option value="">{{__("main.including_sightseeing")}}
                                                            </option>
                                                        </select>
                                                    </div>
                                                </div>

                                            </div>
                                            <div class="row justify-content-center cabin_item">
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label>{{__('main.number_of_adults')}}</label>
                                                        <select
                                                            class="js-example-tags form-control cruise_adults_count"
                                                            name="adults_count" disabled required>
                                                            <option value="">{{__("main.number_of_adults")}} *</option>
                                                            <option value="1">1</option>
                                                            <option value="2">2</option>
                                                            <option value="3">3</option>
                                                            <option value="4">4</option>
                                                            <option value="5">5</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label>{{__('main.number_of_children')}}</label>
                                                        <select
                                                            class="js-example-tags form-control cruise_children_count"
                                                            name="children_count" disabled required>
                                                            <option value="">{{__("main.number_of_children")}} *</option>
                                                            <option value="0">0</option>
                                                            <option value="1">1</option>
                                                            <option value="2">2</option>
                                                            <option value="3">3</option>
                                                            <option value="4">4</option>
                                                            <option value="5">5</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="col-md-3 text-right">
                                                    <div class="form-group ">
                                                        <a href="#" onclick="addCabinItem($(this));return false;">+ {{__("main.add")}}</a>
                                                        <br>
                                                        <a href="#" class="remove_cabin" style="display: none;" onclick="var cruise_item=$(this).closest('.cruise-item');$(this).closest('.cabin_item').remove();calculateTotalCruise(cruise_item);return false;">{{__("main.remove")}}</a></div>
                                                </div>
                                            </div>

                                            <div class="row justify-content-center cruise_checkboxes_row">

                                                <div
                                                    class="checkbox checkbox-fill d-inline mr-3 mt-3 ">
                                                    <input type="checkbox" name="checkbox-fill-1"
                                                           id="checkbox-Private-Guide" class="checkbox-Private-Guide">
                                                    <label for="checkbox-Private-Guide" class="cr">
                                                        {{__("main.private_tour_guide")}}
                                                    </label>
                                                </div>
                                                <div
                                                    class="checkbox checkbox-fill d-inline mr-3 mt-3 ">
                                                    <input type="checkbox" name="checkbox-fill-1"
                                                           id="checkbox-Guide-Boat" class="checkbox-Guide-Boat">
                                                    <label for="checkbox-Guide-Boat" class="cr">
                                                        {{__("main.guide_on_the_boat")}}
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="row justify-content-center ">
                                                <div class="col-md-2 align-self-center">
                                                    <div class="form-group">
                                                        {{__("main.adult_price")}}
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                    <input type="text" class="form-control adult_price"
                                                               disabled>
                                                    </div>
                                                </div>
                                                <div class="col-md-2 align-self-center">
                                                    <div class="form-group">
                                                        {{__("main.child_price")}}
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                    <input type="text" class="form-control child_price"
                                                               disabled>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row justify-content-center ">

                                                <div class="col-md-2 align-self-center">
                                                    <div class="form-group">
                                                        {{__("main.total")}}
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                    <input type="text" class="form-control total_price"
                                                               disabled>
                                                    </div>
                                                </div>
                                                <div class="col-md-4"></div>
                                            </div>
                                            <div class="row justify-content-center">
                                                <div class="col-md-10">
                                                    <div class="remove_item form-group float-left" style="display:none;">
                                                        <a href="#" onclick="$(this).closest('.cruise-item').remove();return false;">
                                                            {{__("main.remove_cruise")}}
                                                        </a>
                                                    </div>
                                                    <div class="form-group float-right">
                                                        <a href="#" onclick="addNileCruise($(this));return false;">
                                                            + {{__("main.add_another_cruise")}}
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </form>
                            </div>

                            <div id="Flights">
                                <div class="card-header">
                                    <h5>{{__("main.domestic_flights")}}</h5>
                                </div>
                                <div id="DomesticFlightsAdded">
                                    <form class="domestic_flight_item" method="POST" action="#">
                                        <button type="submit" style="display: none;"></button>
                                        <input type="hidden" class="flight_id" value="">
                                        <input type="hidden" value="domestic" name="flights[0][type]">

                                        <div class="row justify-content-center">
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <div class="form-group">
                                                    <label>{{__('main.flight_number')}}</label>
                                                    <input type="text"
                                                               class="form-control FlightNo" name="flights[0][flight_no]" >
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <div class="form-group">
                                                    <label>{{__('main.reference_no')}}</label>
                                                    <input type="text"
                                                               class="form-control ReferenceNo" disabled>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <div class="form-group">
                                                    <label>{{__('main.flight_date')}} *</label>
                                                    <input type="text"
                                                               class="form-control flight-date"  disabled>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="row justify-content-center">
                                            <div class="col-md-4">

                                                <div class="form-group">
                                                <label>{{__('main.departure_at')}}</label>
                                                <input type="text"
                                                           class="form-control joDepartureBy"  disabled>
                                                </div>

                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                <label>{{__('main.departure_time')}}</label>
                                                <input type="text"
                                                           class="form-control Time-From"  disabled>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="row justify-content-center">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <div class="form-group">
                                                    <label>{{__('main.arrival_at')}}</label>
                                                    <input type="text"
                                                               class="form-control joArrivalBy"  disabled>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                <label>{{__('main.arrival_time')}}</label>
                                                <input type="text"
                                                           class="form-control Time-To"  disabled>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row justify-content-center">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                <label>{{__('main.number_of_seats')}}</label>
                                                <input  type="text"
                                                           class="form-control No-of-Seats"  disabled>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                <label>{{__('main.status')}}</label>
                                                <input type="text"
                                                           class="form-control joStatusDDL"  disabled>

                                                </div>
                                            </div>
                                        </div>
                                        <div class="row justify-content-center">
                                            <div class="col-md-7">
                                                <div class="remove_item form-group float-left" style="display:none;">
                                                    <a href="#" onclick="$(this).closest('form').remove();return false;">
                                                        {{__("main.remove_flight")}}
                                                    </a>
                                                </div>
                                                <div class="form-group float-right">
                                                    <a href="#" onclick="addNewDomisticFlgiht();return false;">
                                                        + {{__("main.add_new_flight")}}
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>


                                <hr>
                                <div class="card-header">
                                    <h5>{{__("main.international_flights")}}</h5>
                                </div>
                                <div id="InternationalFlightsAdded">
                                    <form class="international_flight_item" method="POST" action="#">
                                        <button type="submit" style="display: none;"></button>
                                        <input type="hidden" class="flight_id" value="">
                                        <input type="hidden" value="international" name="flights[1][type]">

                                        <div class="row justify-content-center">
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <div class="form-group">
                                                    <label>{{__('main.flight_number')}}</label>
                                                    <input type="text" class="form-control FlightNo" name="flights[1][flight_no]" >
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <div class="form-group">
                                                    <label>{{__('main.reference_no')}}</label>
                                                    <input type="text"
                                                               class="form-control ReferenceNo"  disabled>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <div class="form-group">
                                                    <label>{{__('main.flight_date')}} *</label>
                                                    <input type="text"
                                                               class="form-control flight-date"  disabled>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="row justify-content-center">
                                            <div class="col-md-4">

                                                <div class="form-group">
                                                <label>{{__('main.departure_at')}}</label>
                                                <input type="text"
                                                           class="form-control joDepartureBy"  disabled>
                                                </div>

                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                <label>{{__('main.departure_time')}}</label>
                                                <input type="text"
                                                           class="form-control Time-From"  disabled>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="row justify-content-center">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <div class="form-group">
                                                    <label>{{__('main.arrival_at')}}</label>
                                                    <input type="text"
                                                               class="form-control joArrivalBy"  disabled>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                <label>{{__('main.arrival_time')}}</label>
                                                <input type="text"
                                                           class="form-control Time-To"  disabled>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row justify-content-center">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                <label>{{__('main.number_of_seats')}}</label>
                                                <input  type="text"
                                                            class="form-control No-of-Seats"  disabled>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                <label>{{__('main.status')}}</label>
                                                <input type="text"
                                                           class="form-control joStatusDDL" disabled>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row justify-content-center">
                                            <div class="col-md-7">
                                                <div class="remove_item form-group float-left" style="display:none;">
                                                    <a href="#" onclick="$(this).closest('form').remove();return false;">
                                                        {{__("main.remove_flight")}}
                                                    </a>
                                                </div>
                                                <div class="form-group float-right">
                                                    <a href="#" onclick="addNewInternationalFlgiht();return false;">
                                                        + {{__("main.add_new_flight")}}
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>

                            </div>

                            <div id="Tour-Guide">
                                <form class="guide_item" method="POST" action="#">
                                    <button type="submit" style="display: none;"></button>
                                    <div class="row justify-content-center">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <div class="form-group">
                                                <label>{{__('main.tour_date')}} *</label>
                                                <input type="text"
                                                           name="guides[0][date]"
                                                           class="form-control tourDate">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>{{__('main.select_guide')}}</label>
                                                <select
                                                        class="js-example-tags form-control joGuidesDDL"
                                                        name="guides[0][guide_id]" disabled required>
                                                    <option value="">{{__("main.select_guide")}}</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                            <label>{{__('main.phone')}}</label>
                                            <input type="text" class="form-control mob_no"  disabled>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="row justify-content-center">
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label>{{__('main.city')}}</label>
                                                <select
                                                        class="js-example-tags form-control joCitiesDDL"
                                                        name="guides[0][city_id]" disabled required >
                                                    <option value="">{{__("main.city")}}</option>
                                                    @foreach($cities as $city)
                                                        <option value="{{$city->id}}">{{$city->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>{{__('main.select_visits_excursion')}}</label>
                                                <select
                                                        class="js-example-tags form-control joVisitsDDL"
                                                        name="guides[0][sightseeing_id]" required disabled>
                                                    <option value="">{{__("main.select_visits_excursion")}}</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                            <label>{{__('main.guide_language')}}</label>
                                            <input type="text" class="form-control joGLanguages"  disabled>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row justify-content-center">
                                        <div class="col-md-8">
                                            <div class="reset_item form-group float-left">
                                                <a href="#" onclick="resetGuideForm($(this));return false;">
                                                    {{__("main.clear")}}
                                                </a>
                                            </div>
                                            <div class="remove_item form-group float-left" style="display:none;">
                                                <a href="#" onclick="$(this).closest('form').remove();return false;">
                                                    {{__("main.remove_tour_guide")}}
                                                </a>
                                            </div>
                                            <div class="form-group float-right">
                                                <a href="#" onclick="addNewTourGuide_updated();return false;">
                                                    + {{__("main.add_new_tour_guide")}}
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div id="Program">
                                <div id="ProgramAdded">
                                    <form class="program_item">
                                        <button type="submit" style="display: none;"></button>

                                        <div class="row justify-content-center">
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <div class="form-group">
                                                    <label>{{__('main.date')}} *</label>
                                                    <input type="text"
                                                               name="programs[0][day]"
                                                               class="form-control program_date">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label>{{__('main.city')}}</label>
                                                    <select
                                                            class="js-example-tags form-control joCitiesDDL"
                                                            name="programs[0][city_id]">
                                                        <option value="">{{__("main.city")}}</option>
                                                        @foreach($cities as $city)
                                                            <option value="{{$city->id}}">{{$city->name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row justify-content-center">
                                            <div class="col-md-8">
                                                <div
                                                    class="checkbox checkbox-fill d-inline mr-3 mt-3">
                                                    <input type="checkbox" name="checkbox-fill-1"
                                                           id="checkbox-fill-SightSeeing"
                                                           class="checkbox-fill-SightSeeing">
                                                    <label for="checkbox-fill-SightSeeing"
                                                           class="cr">{{__("main.excursion")}}</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="SightSeeingDetails bg-light mx-4 py-3 my-2 d-none">
                                            <div class="sightseeing_item">
                                            <input type="hidden" class="item_type" name="programs[0][items][0][item_type]" value="sightseeing">
                                                <div class="row justify-content-center">
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label>{{__('main.select_excursion')}}</label>
                                                            <select
                                                                    class="js-example-tags form-control joSightSeeingsDDL"
                                                                    name="programs[0][items][0][item_id]">
                                                                <option value="">{{__("main.select_excursion")}}
                                                                </option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <div class="form-group">
                                                        <label>{{__('main.time_from')}} *</label>
                                                        <input type="text"
                                                                   class="form-control Time-From"
                                                                   name="programs[0][items][0][time_from]">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <div class="form-group">
                                                        <label>{{__('main.time_to')}} *</label>
                                                        <input type="text"
                                                                   class="form-control Time-To"
                                                                   name="programs[0][items][0][time_to]" >
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row justify-content-center">
                                                    <div class="col-md-1 align-self-center">
                                                        <div class="form-group">
                                                            {{__("main.adult_price")}}
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <div class="form-group">
                                                        <input type="text" class="form-control adult_price"
                                                                   disabled>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-1 align-self-center">
                                                        <div class="form-group">
                                                            {{__("main.child_price")}}
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <div class="form-group">
                                                        <input type="text" class="form-control child_price"
                                                                   disabled>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-1 align-self-center">
                                                        <div class="form-group">
                                                            {{__("main.total")}}
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <div class="form-group">
                                                        <input type="text" class="form-control total_price"
                                                                   disabled>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row justify-content-center">
                                                <div class="col-md-7">
                                                    <div class="remove_item form-group float-left" style="display:none;">
                                                        <a href="#" onclick="$(this).closest('.sightseeing_item').remove();return false;">
                                                            {{__("main.remove_excursion")}}
                                                        </a>
                                                    </div>
                                                    <div class="form-group float-right">
                                                        <a href="#" onclick="addSightSeeing_updated($(this));return false;">
                                                            + {{__("main.add_another_excursion")}}
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                            </div>
                                        </div>

                                        <div class="row justify-content-center">
                                            <div class="col-md-8">
                                                <div
                                                    class="checkbox checkbox-fill d-inline mr-3 mt-3">
                                                    <input type="checkbox" name="checkbox-fill-1"
                                                           id="checkbox-fill-Visit-Night"
                                                           class="checkbox-fill-Visit-Night">
                                                    <label for="checkbox-fill-Visit-Night"
                                                           class="cr">{{__("main.vbnight")}}</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="Visit-Night-Details bg-light mx-4 py-3 my-2 d-none">
                                            <div class="vbnight_item">
                                            <input type="hidden" class="item_type" name="programs[0][items][1][item_type]" value="vbnight">
                                                <div class="row justify-content-center">
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label>{{__('main.select_vbnight')}}</label>
                                                            <select
                                                                    class="js-example-tags form-control joVisitsNightDDL"
                                                                    name="programs[0][items][1][item_id]">
                                                                <option value="">{{__("main.select_vbnight")}}
                                                                </option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <div class="form-group">
                                                        <label>{{__('main.time_from')}} *</label>
                                                        <input type="text"
                                                                   class="form-control Time-From"
                                                                   name="programs[0][items][1][time_from]">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <div class="form-group">
                                                        <label>{{__('main.time_to')}} *</label>
                                                        <input type="text"
                                                                   class="form-control Time-To"
                                                                   name="programs[0][items][1][time_to]">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row justify-content-center">
                                                    <div class="col-md-1 align-self-center">
                                                        <div class="form-group">
                                                            {{__("main.adult_price")}}
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <div class="form-group">
                                                        <input type="text" class="form-control adult_price"
                                                                   disabled>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-1 align-self-center">
                                                        <div class="form-group">
                                                            {{__("main.child_price")}}
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <div class="form-group">
                                                        <input type="text" class="form-control child_price"
                                                                   disabled>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-1 align-self-center">
                                                        <div class="form-group">
                                                            {{__("main.total")}}
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <div class="form-group">
                                                        <input type="text" class="form-control total_price"
                                                                   disabled>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row justify-content-center">
                                                    <div class="col-md-7">
                                                        <div class="remove_item form-group float-left" style="display:none;">
                                                            <a href="#" onclick="$(this).closest('.vbnight_item').remove();return false;">
                                                                {{__("main.remove_vbnight")}}
                                                            </a>
                                                        </div>
                                                        <div class="form-group float-right">
                                                            <a href="#" onclick="addVisitNight_updated($(this));return false;">
                                                                + {{__("main.add_another_vbnight")}}
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row justify-content-center">
                                            <div class="col-md-8">
                                                <div
                                                    class="checkbox checkbox-fill d-inline mr-3 mt-3">
                                                    <input type="checkbox" name="checkbox-fill-1"
                                                           id="checkbox-fill-Light-Show"
                                                           class="checkbox-fill-Light-Show">
                                                    <label for="checkbox-fill-Light-Show"
                                                           class="cr">{{__("main.slshow")}}</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="SoundLightShowDetails bg-light mx-4 py-3 my-2 d-none">
                                            <input type="hidden" class="item_type" name="programs[0][items][2][item_type]" value="slshow">
                                            <input type="hidden" class="item_id" name="programs[0][items][2][item_id]" value="">
                                            <div class="row justify-content-center">
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label>{{__('main.place')}}</label>
                                                        <select
                                                                class="js-example-tags form-control place"
                                                                name="place" required>
                                                            <option value="">{{__("main.place")}}</option>
                                                            <option value="Pyramids" >Pyramids</option>
                                                            <option value="Karnak" >Karnak</option>
                                                            <option value="Edfu" >Edfu</option>
                                                            <option value="Philae">Philae</option>
                                                            <option value="Abu Simbel">Abu Simbel</option>
                                                        </select>

                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label>{{__('main.show_language')}}</label>
                                                        <select
                                                                class="js-example-tags form-control joLanguagesDDL"
                                                                name="" disabled>
                                                            <option value="">{{__("main.show_language")}}
                                                            </option>
                                                            @foreach($languages as $language)
                                                                <option value="{{$language->id}}" >{{$language->language}}</option>
                                                            @endforeach
                                                            <option value="{{\App\Models\Language::ALL_LANGUAGES_ID}}" >{{__("main.all_languages")}}</option>

                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label>{{__('main.select_time')}}</label>
                                                        <select
                                                            class="js-example-tags form-control time"
                                                            name="" disabled>
                                                            <option value="">{{__("main.select_time")}}
                                                            </option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row justify-content-center">
                                                <div class="col-md-1 align-self-center">
                                                    <div class="form-group">
                                                        {{__("main.adult_price")}}
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                    <input type="text" class="form-control adult_price"
                                                               disabled>
                                                    </div>
                                                </div>
                                                <div class="col-md-1 align-self-center">
                                                    <div class="form-group">
                                                        {{__("main.child_price")}}
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                    <input type="text" class="form-control child_price"
                                                               disabled>
                                                    </div>
                                                </div>
                                                <div class="col-md-1 align-self-center">
                                                    <div class="form-group">
                                                        {{__("main.total")}}
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                    <input type="text" class="form-control total_price"
                                                               disabled>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>

                                        <div class="row justify-content-center">
                                            <div class="col-md-8">
                                                <div
                                                    class="checkbox checkbox-fill d-inline mr-3 mt-3">
                                                    <input type="checkbox" name="checkbox-fill-1"
                                                           id="checkbox-fill-Lift"
                                                           class="checkbox-fill-Lift">
                                                    <label for="checkbox-fill-Lift"
                                                           class="cr">{{__("main.transfer")}}</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="LiftDetails bg-light mx-4 py-3 my-2 d-none">
                                            <div class="lift_item">
                                                <input type="hidden" class="item_type" name="programs[0][items][5][item_type]" value="lift">
                                                <input type="hidden" class="item_id" name="programs[0][items][5][item_id]" value="9999">
                                                <div class="row justify-content-center">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                        <label>{{__('main.details')}} *</label>
                                                        <input type="text" class="form-control details"
                                                        name="programs[0][items][5][details]">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <div class="form-group">
                                                        <label>{{__('main.time')}} *</label>
                                                        <input type="text"
                                                                   class="form-control Time-From"
                                                                   name="programs[0][items][5][time_from]">

                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row justify-content-center">
                                                    <div class="col-md-7">
                                                        <div class="remove_item form-group float-left" style="display:none;">
                                                            <a href="#" onclick="$(this).closest('.lift_item').remove();return false;">
                                                                {{__("main.remove_transfer")}}
                                                            </a>
                                                        </div>
                                                        <div class="form-group float-right">
                                                            <a href="#" onclick="addLift($(this));return false;">
                                                                + {{__("main.add_another_transfer")}}
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row justify-content-center">
                                            <div class="col-md-8 my-3">
                                                <div class="remove_main_item form-group float-left" style="display:none;">
                                                    <a href="#" onclick="$(this).closest('form').remove();return false;">
                                                        {{__("main.remove_day")}}
                                                    </a>
                                                </div>
                                                <div class="form-group float-right">
                                                    <a href="#" onclick="addAnotherDay_updated();return false;">
                                                        + {{__("main.add_another_day")}}
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>

                                <div class="row justify-content-end">
                                    <div class="col-md-6">
                                        <button type="submit" onclick="saveJobFile('{{route("job-files.store")}}', 'POST', '?save_then_draft=1');"
                                                class="btn btn-primary mb-4  float-right" id="save_job_then_draft">
                                            {{__("main.save_create_draft_invoice")}}
                                        </button>
                                        <button type="submit"
                                                class="btn btn-primary mb-4  float-right" id="save_job" onclick="saveJobFile('{{route("job-files.store")}}', 'POST');">
                                            {{__("main.save_close")}}
                                        </button>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- [ Smart-Wizard ] end -->

    </div>
@endsection

@section('script_bottom')
    <script src="{{asset('assets/plugins/smart-wizard/js/jquery.smartWizard.min.js')}}"></script>
    <script src="{{asset('assets/js/pages/wizard-custom.js')}}"></script>
    <script src="{{asset('assets/js/jobs_updates.js?ver=4.2')}}"></script>
    <script>
        var accommodation_items_count = 1;
        var cruise_items_count = 1;
        var flight_items_count = 2;
        var guide_items_count = 1;
        var program_days_count = 1;
        var program_sightseeing_count = 1;
        var program_vbnights_count = 1;
        var program_lift_count = 1;
        var job_id = '';
        function init_search_airports(){
            $('#joAirArrivalByDDL, #joAirDepartureByDDL').select2({
                ajax: {
                    delay: 500,
                    url: '{{route('airports.search')}}',
                    data: function (params) {
                        var query = {
                            search: params.term,
                            type: 'public'
                        }

                        // Query parameters will be ?search=[term]&type=public
                        return query;
                    },
                    processResults: function (data) {
                        // Transforms the top-level key of the response object from 'items' to 'results'
                        return {
                            results: data.results
                        };
                    }
                }
            });
        }
        $(function () {
            // setTimeout(function(){
            //     for(var x=1;x<=2;x++){
            //         $('#smartwizard').smartWizard("next");
            //     }
            // }, 1000);

            init_search_airports();
            $("#Accommodations .joHCitiesDDL").each(function(){
                resetAccommodationForm($(this));
            });
            resetFlightForm();
            $("#Tour-Guide .tourDate").each(function(){
                resetGuideForm($(this));
            });
            resetProgramForm();

            var routers_loaded = "";
            var arrival_date, departure_date;

            if ($("#checkbox-fill-Router").is(':checked')) {
                $('#RouterDetails').removeClass('d-none');
                $('#RouterDetails [name="router_id"]').attr('required', 'required');
                $('#RouterDetails [name="days_count"]').attr('required', 'required');
            } else {
                $('#RouterDetails').addClass('d-none');
                $('#RouterDetails [name="router_id"]').removeAttr('required');
                $('#RouterDetails [name="days_count"]').removeAttr('required');
            }
            if ($("#checkbox-fill-Service-Conciergerie").is(':checked')) {
                $('#ServiceDetails').removeClass('d-none');
                $('#ServiceDetails [name="concierge_emp_id"]').attr('required', 'required');
            } else {
                $('#ServiceDetails').addClass('d-none');
                $('#ServiceDetails [name="concierge_emp_id"]').removeAttr('required');
            }
            if ($("#checkbox-fill-Travel-Visa").is(':checked')) {
                $('#VisaDetails').removeClass('d-none');
                $('#VisaDetails [name="visa_id"]').attr('required', 'required');
                $('#VisaDetails [name="visas_count"]').attr('required', 'required');
            } else {
                $('#VisaDetails').addClass('d-none');
                $('#VisaDetails [name="visa_id"]').removeAttr('required');
                $('#VisaDetails [name="visas_count"]').removeAttr('required');
            }
            if ($("#checkbox-fill-Gift").is(':checked')) {
                $('#GiftDetails').removeClass('d-none');
                $('#GiftDetails .joGiftsDDL').attr('required', 'required');
                $('#GiftDetails .Gifts-Count').attr('required', 'required');
            } else {
                $('#GiftDetails').addClass('d-none');
                $('#GiftDetails .joGiftsDDL ').removeAttr('required');
                $('#GiftDetails .Gifts-Count').removeAttr('required');
            }
            $("#joRoutersDDL").val("");
            $("#joServiceEmpDDL").val("");
            $("#joVisasDDL").val("");
            $("#Package-Quota").val("");
            $("#Router-Days-Count").val("");
            $("#Package-Price").val("");
            $("#Visa-Price").val("");
            $("#Visa-Count").val("");



            $("#smartwizard").on("showStep", function (e, anchorObject, stepIndex, stepDirection) {
                //second step -> load routers
                arrival_date = $("#Arrival-date-job").val();
                departure_date = $("#Departure-date-job").val();
                var from_to = arrival_date+departure_date;
                if (stepIndex == 1 && routers_loaded != from_to) {

                    $.post('/routers/available', {'from': arrival_date, 'to': departure_date})
                        .done(function (data) {
                            $("#joRoutersDDL option[value!='']").remove();
                            for (var i = 0; i < data.routers.length; i++) {
                                var router = data.routers[i];
                                $("#joRoutersDDL").append('<option value="' + router.id + '" data-quota="' + router.quota + '" data-price="' + router.package_sell_price_vat_exc + '" data-currency="'+router.currency_str+'">' + router.number + '</option>');
                            }
                            if(data.routers.length){
                                routers_loaded = from_to;
                            }
                        });
                }
            });

            $(document).on("change", "#joRoutersDDL, #Router-Days-Count" , function() {
                let router_id_input = $("#joRoutersDDL");
                let days_count_input = $("#Router-Days-Count");
                var router_id = router_id_input.val();
                let days_count = parseInt(days_count_input.val());
                if(router_id && days_count){
                    var selected_option = $('option[value="'+router_id+'"]', router_id_input);
                    $("#Package-Quota").val(selected_option.attr('data-quota'));
                    let price = parseFloat(selected_option.attr('data-quota')) * days_count;
                    $("#Package-Price").val(price + " " + selected_option.attr('data-currency'));
                }else{
                    if(!days_count){
                        days_count_input.val("");
                    }
                    $("#Package-Quota").val("");
                    $("#Package-Price").val("");
                }
            });

            $(document).on("change", "#joVisasDDL, #Visa-Count" , function() {
                let visa_id_input = $("#joVisasDDL");
                let visa_count_input = $("#Visa-Count");
                let visa_id = visa_id_input.val();
                let visas_count = parseInt(visa_count_input.val());
                if(visa_id && visas_count){
                    var selected_option = $('option[value="'+visa_id+'"]', visa_id_input);
                    let price = parseFloat(selected_option.attr('data-price')) * visas_count;
                    $("#Visa-Price").val(price + " " + selected_option.attr('data-currency'));
                }else{
                    if(!visas_count){
                        visa_count_input.val("");
                    }
                    $("#Visa-Price").val("");
                }
            });

            $(document).on("change", ".joGiftsDDL, .Gifts-Count" , function() {
                let parent = $(this).closest('.gift_item');
                let gift_id_input = parent.find(".joGiftsDDL");
                let gifts_count_input = parent.find(".Gifts-Count");
                var row = $(this).closest('.row');
                var gift_id = gift_id_input.val();
                var gifts_count = parseInt(gifts_count_input.val());
                if(gift_id && gifts_count){
                    var selected_option = row.find('option[value="'+gift_id+'"]', $(this));
                    let price = parseFloat(selected_option.attr('data-price')) * gifts_count;
                    row.find(".Gift-Price").val(price + " " + selected_option.attr('data-currency'));
                }else{
                    if(!gifts_count){
                        gifts_count_input.val("");
                    }
                    row.find(".Gift-Price").val("");
                }
            });

            var validate_steps = true;
            var form_1_submitted, form_2_submitted, form_3_submitted, form_4_submitted, form_5_submitted;
            form_1_submitted = form_2_submitted = form_3_submitted = form_4_submitted = form_5_submitted = false;

            $("#smartwizard").on("showStep", function(e, anchorObject, stepIndex, stepDirection) {
                $('form button[type="submit"]').removeAttr('disabled');
                $('form button[type="submit"]').removeClass('disabled');
                if(stepIndex == 0){
                    form_1_submitted = false;
                }else if(stepIndex == 1){
                    form_2_submitted = false;
                } else if(stepIndex == 2){
                    form_3_submitted = false;
                    go_to_flights = 0;
                    checked_forms = 0;
                } else if(stepIndex == 4){
                    form_5_submitted = false;
                    go_to_program = 0;
                    checked_forms = 0;
                }
            });

            $("#smartwizard").on("leaveStep", function (e, anchorObject, currentStepIndex, nextStepIndex, stepDirection) {
                $('form button[type="submit"]').removeAttr('disabled');
                $('form button[type="submit"]').removeClass('disabled');
                if (validate_steps && nextStepIndex == 'forward' && currentStepIndex == 0 && !form_1_submitted) {
                    $('#Basic-Information form button[type="submit"]').click();//not form.submit to make it apply required rules
                    return false;
                }else if (validate_steps && nextStepIndex == 'forward' && currentStepIndex == 1 && !form_2_submitted) {
                    $('#Additional-Information button[type="submit"]').click();
                    return false;
                }else if (validate_steps && nextStepIndex == 'forward' && currentStepIndex == 2 && !form_3_submitted) {
                    checked_forms = 0;
                    $('#Accommodations form.accommodation-item button[type="submit"]').click();
                    return false;
                }else if (validate_steps && nextStepIndex == 'forward' && currentStepIndex == 4 && !form_5_submitted) {
                    checked_forms = 0;
                    $('#Tour-Guide button[type="submit"]').click();
                    return false;
                }
            });

            $("#Basic-Information form").submit(function(){
                form_1_submitted = true;
                $('#smartwizard').smartWizard("next");
                return false;
            });

            $("#Additional-Information form").submit(function(){
                form_2_submitted = true;
                $('#smartwizard').smartWizard("next");
                return false;
            });

            var go_to_flights = 0;
            var go_to_program = 0;
            var checked_forms = 0;
            $(document).on("submit", "#Accommodations form.accommodation-item" , function() {
                checked_forms++;
                if(checked_forms == $("#Accommodations form.accommodation-item").length){
                    form_3_submitted = true;
                    if(go_to_flights == 0){
                        $('#smartwizard').smartWizard("next");
                        go_to_flights++;
                    }
                }

                return false;
            });

            $(document).on("submit", "#Tour-Guide form" , function() {
                if(validateTourForm($(this))){
                    checked_forms++;
                    if(checked_forms == $("#Tour-Guide form").length){
                        form_5_submitted = true;
                        if(go_to_program == 0){
                            $('#smartwizard').smartWizard("next");
                            go_to_program++;
                        }
                    }
                }

                return false;
            });


        });

    </script>
@endsection
