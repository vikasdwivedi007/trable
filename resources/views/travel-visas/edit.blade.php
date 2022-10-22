@extends('layouts.main')

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h5>{{__("main.update_travel_visa")}}</h5>
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
                    <form id="validation-form123" action="{{route('travel-visas.update', ['travel_visa'=>$travelVisa->id])}}" method="POST"  >
                        @method("PATCH")
                        @csrf
                        <div class="row">

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{__('main.name')}}</label>
                                    <input type="text"  class="form-control @error('name') is-invalid @enderror"
                                           name="name" placeholder="{{__("main.name")}}" required value="{{$travelVisa->name}}">
                                    @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6"></div>
                        </div>
                        <hr>
                        <div class="row">

                        </div>

                        <hr>
                        <label for="">
                            {{__("main.price")}}
                        </label>
                        <div class="row">

                            <div class="col-md-3">

                                <div class="form-group">
                                    <label>{{__('main.buying_price')}}</label>
                                    <input id="adult-buy-pric" type="text" class="form-control autonumber @error('buy_price') is-invalid @enderror"
                                           name="buy_price"
                                           placeholder="{{__("main.buying_price")}}"  value="{{$travelVisa->buy_price}}">
                                    @error('buy_price')
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
                                            name="buy_currency" required>
                                        @foreach(\App\Models\Currency::availableCurrencies() as $key => $value)
                                            <option value="{{$key}}" @if($travelVisa->buy_currency == $key) selected @endif>{{$value}}</option>
                                        @endforeach
                                    </select>
                                    @error('buy_currency')
                                    <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6"></div>
                            <div class="col-md-3">

                                <div class="form-group">
                                    <label>{{__('main.selling_price')}}</label>
                                    <input type="text" class="form-control autonumber @error('sell_price') is-invalid @enderror"
                                           name="sell_price"
                                           placeholder="{{__("main.selling_price")}}"  value="{{$travelVisa->sell_price}}">
                                    @error('sell_price')
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
                                        name="sell_currency" required>
                                        @foreach(\App\Models\Currency::availableCurrencies() as $key => $value)
                                            <option value="{{$key}}" @if($travelVisa->sell_currency == $key) selected @endif>{{$value}}</option>
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
                        <hr>


                        <button type="submit" class="btn btn-primary">{{__("main.update")}}</button>
                        <button type="button" onclick="window.location.href='{{ route('services.index').'#pills-Travel-visa-tab' }}';" class="btn btn-outline-primary">{{__("main.cancel")}}</button>

                    </form>

                </div>
            </div>

        </div>
    </div>
@endsection
