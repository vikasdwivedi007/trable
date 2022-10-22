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
                    <h5> {{__("main.update_travel_agent")}}</h5>
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
                    <form id="validation-form123" action="{{route('travel-agents.update', ['travel_agent'=>$travel_agent->id])}}" method="POST"  enctype="multipart/form-data">
                        @method('PATCH')
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{__("main.name")}}</label>
                                    <input type="text" id="TravelAgentName" class="form-control @error('name') is-invalid @enderror"
                                           name="name" placeholder="{{__("main.name")}}" value="{{$travel_agent->name}}" required>
                                    @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{__("main.country")}}</label>
                                    <select id="CountryDDL"
                                            class="js-example-tags form-control @error('country_id') is-invalid @enderror"
                                            name="country_id" required>
                                        <option value="">{{__("main.country")}}</option>
                                        @foreach($countries as $country)
                                            <option value="{{$country->id}}" @if($country->id == $travel_agent->country_id) selected @endif>{{$country->name}}</option>
                                        @endforeach
                                    </select>
                                    @error('country_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                  <label>{{__("main.city")}}</label>
                                    <select id="CityDDL"
                                            class="js-example-tags form-control @error('city_id') is-invalid @enderror"
                                            name="city_id" required>
                                        <option value="">{{__("main.city")}}</option>
                                        @foreach($cities as $city)
                                            <option value="{{$city->id}}" @if($city->id == $travel_agent->city_id) selected @endif>{{$city->name}}</option>
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
                                <label>{{__("main.address")}}</label>
                                    <input type="text" id="ContactName" class="form-control @error('address') is-invalid @enderror"
                                           name="address" placeholder="{{__("main.address")}}" value="{{$travel_agent->address}}"  required>
                                    @error('address')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
{{--                            <div class="col-md-6">--}}
{{--                                <div class="form-group">--}}
{{--                                    <input type="text" class="form-control autonumber @error('rate_amount') is-invalid @enderror"--}}
{{--                                           name="rate_amount" data-a-sign=""--}}
{{--                                           placeholder="{{__("main.rate_amount")}}" value="{{$travel_agent->rate_amount}}" >--}}
{{--                                    @error('rate_amount')--}}
{{--                                    <span class="invalid-feedback" role="alert">--}}
{{--                                        <strong>{{ $message }}</strong>--}}
{{--                                    </span>--}}
{{--                                    @enderror--}}
{{--                                </div>--}}
{{--                            </div>--}}

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{__("main.phone")}}</label>
                                    <input type="text" class="form-control mob_no @error('phone') is-invalid @enderror"
                                           name="phone" placeholder="{{__("main.phone")}}" value="{{$travel_agent->phone}}"  required>
                                    @error('phone')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>


                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{__("main.email")}}</label>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror"
                                           name="email" placeholder="{{__("main.email")}}" value="{{$travel_agent->email}}"  >
                                    @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                        </div>
                        <hr>
                        <label>{{__("main.contact_info")}}</label>
                        <div id="restrntContactsAdded" class="row">
                            @if($travel_agent->contacts->toArray())
                                @foreach($travel_agent->contacts->toArray() as $key => $value)
                                    <div class="contact-item row">
                                        <input type="hidden" name="contacts[{{$key}}][id]" value="{{$value['id']}}">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>{{__("main.contact_name")}}</label>
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
                                                <label>{{__("main.contact_phone")}}</label>
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
                                                <label>{{__("main.contact_email")}}</label>
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
                                            <label>{{__("main.contact_name")}}</label>
                                            <input type="text" id="Trnsprt-Contact-Name" class="form-control"
                                                   name="contacts[0][name]" placeholder="{{__("main.contact_name")}}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>{{__("main.contact_phone")}}</label>
                                            <input type="text" id="Trnsprt-Contact-Mobile" class="form-control mob_no "
                                                   name="contacts[0][phone]" placeholder="{{__("main.contact_phone")}}" >
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>{{__("main.contact_email")}}</label>
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
                        <div class="card-header">
                            <h5>{{__("main.contract_upload")}}</h5>
                            @if($travel_agent->file)
                                <a href="{{url(\Illuminate\Support\Facades\Storage::url($travel_agent->file->url))}}" target="_blank" style="font-size:20px;">(<i class="feather icon-file"></i>)</a>
                            @endif
                        </div>

                        <div class="row">

                            <div class="col-md-6">

                                <div class="form-group">
                                    <label class="form-label"></label>
                                    <div>
                                        <input type="file" class="validation-file  @error('contract') is-invalid @enderror" name="contract">
                                    </div>

                                    @error('contract')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                        </div>


                        <button type="submit" class="btn btn-primary">{{__("main.update")}}</button>
                        <button type="button" class="btn btn-outline-primary" onclick="window.location.href='{{route('travel-agents.index')}}';">{{__("main.cancel")}}</button>
                    </form>

                </div>
            </div>

        </div>
    </div>
@endsection

@section('script_bottom')
    <script>
        var next_contact = 1;
        @if($travel_agent->contacts->count())
            next_contact = {{$travel_agent->contacts->count()}};
        @endif


        function getCountryCities(country_id){
            let cities_select = $("#CityDDL");
            if(country_id){
                $.post("{{route('getCountryCities')}}", {country_id: country_id})
                    .done(function(data){
                        cities_select.find('option[value!=""]').remove();
                        for(var i = 0; i<data.cities.length;i++){
                            cities_select.append("<option value='"+data.cities[i].id+"'>"+data.cities[i].name+"</option>");
                        }
                    })
                    .fail(function(err){
                        console.log(err);
                    });
            }else{
                cities_select.find('option[value!=""]').remove();
            }
        }

        $(function(){

            $("#CountryDDL").change(function(){
                let country_id = $(this).val();
                getCountryCities(country_id);
            });
        });

    </script>
@endsection
