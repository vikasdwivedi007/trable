@extends('layouts.main')

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h5>{{__('main.create_new_guide')}}</h5>
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
                    <form id="validation-form123" action="{{ route('guides.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>{{__('main.name')}}</label>
                                    <input type="text" id="Name-of-Guide" class="form-control @error('name') is-invalid @enderror"
                                           name="name" placeholder="{{__('main.name')}}" required value="{{old('name')}}">
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
                                    <input type="text" id="NameAr-of-Guide" class="form-control ar_only @error('name_ar') is-invalid @enderror"
                                           name="name_ar" placeholder="{{__('main.name_ar')}}" required value="{{old('name_ar')}}">
                                    @error('name_ar')
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
                                    <select id="LanguageDDL" class="js-example-basic-multiple"
                                            multiple="multiple" name="languages[]" required>
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
                                    <label>{{__('main.daily_fees')}}</label>
                                    <input id="Fees-Per-Day" type="text" class="form-control autonumber @error('daily_fee') is-invalid @enderror"
                                           name="daily_fee" placeholder="{{__('main.daily_fees')}}"  value="{{old('daily_fee')}}">
                                    @error('daily_fee')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>{{__('main.currency')}}</label>
                                    <select id="CurrencyCDDL"
                                            class="js-example-tags form-control @error('currency') is-invalid @enderror"
                                            name="currency" required>
                                        @foreach(\App\Models\Currency::availableCurrencies() as $key => $value)
                                            <option value="{{$key}}" @if(old('currency') == $key) selected @endif>{{$value}}</option>
                                        @endforeach
                                    </select>
                                    @error('currency')
                                    <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6"></div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>{{__('main.license_no')}}</label>
                                    <input id="Selling-Fees-Freind" type="text" class="form-control @error('license_no') is-invalid @enderror"
                                           name="license_no" placeholder="{{__('main.license_no')}}" required value="{{old('license_no')}}">
                                    @error('license_no')
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
                                        <label class="form-label">Value Added Certificate شهادة القيمة المضافة</label>
                                        <input type="file" id="Trnsprt-Co-Register" class="form-control @error('additional_value_cert') is-invalid @enderror"
                                               name="additional_value_cert" placeholder="Value Added Certificate شهادة القيمة المضافة" >
                                        @error('additional_value_cert')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror

                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6"></div>

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

                        </div>

                        <br>
                        <button type="submit" class="btn btn-primary">{{__('main.create')}}</button>
                        <button type="button" onclick="window.location.href='{{ route('suppliers.index').'#pills-Guides-tab' }}';" class="btn btn-outline-primary">{{__('main.cancel')}}</button>
                    </form>

                </div>
            </div>

        </div>
    </div>
@endsection
