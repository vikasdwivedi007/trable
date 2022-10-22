@extends('layouts.main')

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h5>{{__("main.create_new_shop")}}</h5>
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
                    <form id="validation-form123" action="{{route('shops.store')}}" method="POST"  enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{__('main.city')}}</label>
                                    <select id="CityDDL"
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
                                    <label>{{__('main.name')}}</label>
                                    <input type="text" id="NameOfShop" class="form-control @error('name') is-invalid @enderror"
                                           name="name" placeholder="{{__("main.name")}}" required value="{{old('name')}}">
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
                                    <label>{{__('main.address')}}</label>
                                    <input type="text" class="form-control @error('address') is-invalid @enderror"
                                           name="address" placeholder="{{__("main.address")}}" required value="{{old('address')}}">
                                    @error('address')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6"></div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>{{__('main.phone')}}</label>
                                    <input type="text" class="form-control mob_no @error('phone') is-invalid @enderror"
                                           name="phone" placeholder="{{__("main.phone")}}"  required value="{{old('phone')}}">
                                    @error('phone')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <hr>
                        <label>{{__("main.commission")}} %</label>
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>{{__('main.percentage')}}</label>
                                    <input id="Percentage" type="text" class="form-control autonumber @error('commission') is-invalid @enderror"
                                           name="commission" data-a-sign="% "
                                           placeholder="{{__("main.percentage")}}"  required value="{{old('commission')}}">
                                    @error('commission')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="card-header">
                            <h5>{{__("main.contract_upload")}}</h5>
                        </div>
                        <div class="row">

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label"></label>
                                    <div>
                                        <input type="file" class="@error('contract') is-invalid @enderror" name="contract">
                                        @error('contract')
                                            <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>


                        <button type="submit" class="btn btn-primary">{{__("main.create")}}</button>
                        <button type="button" onclick="window.location.href='{{ route('services.index').'#pills-Shops-tab' }}';" class="btn btn-outline-primary">{{__("main.cancel")}}</button>

                    </form>

                </div>
            </div>

        </div>
    </div>
@endsection
