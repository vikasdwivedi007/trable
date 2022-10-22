@extends('layouts.main')

@section('script_top')
    <style>
        .contact-item{
            display: contents;
        }
    </style>
@endsection

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h5>{{__('main.create_new_hotel')}}</h5>
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
                    <form id="validation-form123" action="{{ route('hotels.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{__('main.city')}}</label>
                                    <select id="CityToDDL" class="js-example-tags form-control @error('city_id') is-invalid @enderror"
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
                            <div class="col-md-6">
                                <div class="form-group">
                                  <label>{{__('main.hotel_name')}}</label>
                                  <input type="text" id="Hotel-Name" class="form-control @error('name') is-invalid @enderror"
                                           name="name" required value="{{old('name')}}"
                                           placeholder="{{__('main.hotel_name')}}">
                                    @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                  <label>{{__('main.hotel_phone')}}</label>
                                  <input type="text" id="Hotel-Phn"
                                           class="form-control mob_no @error('phone') is-invalid @enderror" name="phone"
                                           placeholder="{{__('main.hotel_phone')}}" required value="{{old('phone')}}">
                                    @error('phone')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                  <label>{{__('main.hotel_email')}}</label>
                                  <input type="email" id="Hotel-Email"
                                           class="form-control @error('email') is-invalid @enderror" placeholder="{{__('main.hotel_email')}}" name="email" required value="{{old('email')}}">
                                    @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Hotel Trip Advisor URL</label>
                                    <input type="text" id="Hotel-Tripadvisor-URL"
                                           class="form-control @error('tripadvisor_url') is-invalid @enderror" placeholder="Hotel Trip Advisor URL" name="tripadvisor_url" required value="{{old('tripadvisor_url')}}">
                                    @error('tripadvisor_url')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <hr>
                        <label>{{__('main.contact_info')}}</label>
                        <div id="HotelContactsAdded" class="row">
                            @if(old('contacts'))
                                @foreach(old('contacts') as $key => $value)
                                    <div class="contact-item row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                              <label>{{__('main.contact_name')}}</label>
                                              <input type="text" id="Trnsprt-Contact-Name" class="form-control @error("contacts.{$key}.name") is-invalid @enderror"
                                                       name="contacts[{{$key}}][name]" placeholder="{{__('main.contact_name')}}" @isset(old('contacts')[$key]['name']) value="{{old('contacts')[$key]['name']}}" @endisset>
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
                                                       name="contacts[{{$key}}][phone]" placeholder="{{__('main.contact_phone')}}" @isset(old('contacts')[$key]['phone']) value="{{old('contacts')[$key]['phone']}}" @endisset>
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
                                                       name="contacts[{{$key}}][email]" placeholder="{{__('main.contact_email')}}" @isset(old('contacts')[$key]['email']) value="{{old('contacts')[$key]['email']}}" @endisset>
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
                                                        {{__('main.remove_contact')}}
                                                    </a>
                                                @else
                                                    <a href="#" onclick="addNewHotelContact();return false;">
                                                        + {{__('main.add_new_contact')}}
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
                                                   name="contacts[0][name]" placeholder="{{__('main.contact_name')}}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                          <label>{{__('main.contact_phone')}}</label>
                                          <input type="text" id="Trnsprt-Contact-Mobile" class="form-control mob_no "
                                                   name="contacts[0][phone]" placeholder="{{__('main.contact_phone')}}" >
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                          <label>{{__('main.contact_email')}}</label>
                                          <input type="email" id="Trnsprt-Contact-Email" class="form-control"
                                                   name="contacts[0][email]" placeholder="{{__('main.contact_email')}}">
                                        </div>
                                    </div>
                                    <div class="col-md-6 align-self-center">
                                        <div class="form-group">
                                            <a href="#" onclick="addNewHotelContact();return false;">
                                                + {{__('main.add_new_contact')}}
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                        <hr>
                        <label>{{__('main.contract_upload')}}</label>
                        <div class="row">

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label"></label>
                                    <div>
                                      <input type="file" class=" @error('contract') is-invalid @enderror" name="contract">
                                    </div>
                                    @error('contract')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary">{{__('main.create')}}</button>
                        <button type="button" onclick="window.location.href='{{ route('suppliers.index').'#pills-Hotels-tab' }}';" class="btn btn-outline-primary">{{__('main.cancel')}}</button>
                    </form>

                </div>
            </div>

        </div>
    </div>
@endsection

@section('script_bottom')
    <script>
        var next_contact = 1;
        @if(old('contacts'))
            next_contact = {{max(array_keys(old('contacts'))) + 1}};
        @endif

    </script>
@endsection
