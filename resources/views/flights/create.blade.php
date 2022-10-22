@extends('layouts.main')

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h5>{{__('main.create_new_flight')}}</h5>
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
                    <form id="validation-form123" action="{{ route('flights.store') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>{{__('main.flight_date')}}</label>
                                    <input type="text" id="flight-date" class="form-control @error('date') is-invalid @enderror"
                                           name="date" placeholder="{{__('main.flight_date')}}" required value="{{old('date')}}">
                                    @error('date')
                                    <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>{{__('main.flight_number')}}</label>
                                    <input type="text" id="Flight-No" class="form-control @error('number') is-invalid @enderror"
                                           name="number" placeholder="{{__('main.flight_number')}}" required value="{{old('number')}}">
                                    @error('number')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>{{__('main.reference_no')}}</label>
                                    <input id="Reference-No" type="text" class="form-control @error('reference') is-invalid @enderror"
                                           name="reference"
                                           placeholder="{{__('main.reference_no')}}"  value="{{old('reference')}}">
                                    @error('reference')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-4"></div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>{{__('main.search_for_airport')}}</label>
                                    <select id="DepartureAtDDL"
                                            class="form-control @error('from') is-invalid @enderror"
                                            name="from" required>
                                        <option value="">{{__('main.departure_from')}} ({{__('main.search_for_airport')}})</option>
                                        @if(old('from'))
                                            <option value="{{ \App\Models\Airport::find(old('from'))->id }}" selected>{{\App\Models\Airport::find(old('from'))->format()['text']}}</option>
                                        @endif
                                    </select>
                                    @error('from')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>{{__('main.departure_time')}}</label>
                                    <input type="text" name="depart_at" id="Time-From" class="form-control @error('depart_at') is-invalid @enderror" placeholder="{{__('main.departure_time')}}" required value="{{old('depart_at')}}">
                                    @error('depart_at')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-4"></div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>{{__('main.search_for_airport')}}</label>
                                    <select id="ArrivalAtDDL"
                                            class="form-control @error('to') is-invalid @enderror"
                                            name="to" required>
                                        <option value="">{{__('main.arrival_at_location')}} ({{__('main.search_for_airport')}})</option>
                                        @if(old('to'))
                                            <option value="{{ \App\Models\Airport::find(old('to'))->id }}" selected>{{\App\Models\Airport::find(old('to'))->format()['text']}}</option>
                                        @endif
                                    </select>
                                    @error('to')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>{{__('main.arrival_time')}}</label>
                                    <input type="text" name="arrive_at" id="Time-To" class="form-control @error('arrive_at') is-invalid @enderror" placeholder="{{__('main.arrival_time')}}" required value="{{old('arrive_at')}}">
                                    @error('arrive_at')
                                    <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-4"></div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>{{__('main.number_of_seats')}}</label>
                                    <input id="No-of-Seats" type="number" name="seats_count" class="form-control @error('seats_count') is-invalid @enderror"
                                           placeholder="{{__('main.number_of_seats')}}" value="{{old('seats_count')}}" min="1">
                                    @error('seats_count')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>{{__('main.status')}}</label>
                                    <select id="StatusDDL"
                                            class="js-example-tags form-control @error('status') is-invalid @enderror"
                                            name="status" required>
                                        <option value="">{{__('main.status')}}</option>
                                        @foreach(\App\Models\Flight::availableStatus() as $key => $value)
                                            <option value="{{$key}}" @if(old('status') == $key) selected @endif>{{$value}}</option>
                                        @endforeach
                                    </select>
                                    @error('status')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-4"></div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>{{__('main.buying_price')}}</label>
                                    <input id="adult-buy-pric" type="text" class="form-control autonumber @error('buy_price') is-invalid @enderror"
                                           name="buy_price"
                                           placeholder="{{__('main.buying_price')}}"  value="{{old('buy_price')}}">
                                    @error('buy_price')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <div class="form-group">
                                        <label>{{__('main.currency')}}</label>
                                        <select id="CurrencyCDDL"
                                                class="js-example-tags form-control @error('buy_price_currency') is-invalid @enderror"
                                                name="buy_price_currency" required>
                                            @foreach(\App\Models\Currency::availableCurrencies() as $key => $value)
                                                <option value="{{$key}}" @if(old('buy_price_currency') == $key) selected @endif>{{$value}}</option>
                                            @endforeach
                                        </select>
                                        @error('buy_price_currency')
                                            <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6"></div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>{{__('main.selling_price')}}</label>
                                    <input id="adult-sell-pric" type="text" class="form-control autonumber @error('sell_price_vat_exc') is-invalid @enderror"
                                           name="sell_price_vat_exc"
                                           placeholder="{{__('main.selling_price')}}"  value="{{old('sell_price_vat_exc')}}">
                                    @error('sell_price_vat_exc')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <div class="form-group">
                                        <label>{{__('main.currency')}}</label>
                                        <select id="CurrencyDDL"
                                                class="js-example-tags form-control @error('sell_price_vat_exc_currency') is-invalid @enderror"
                                                name="sell_price_vat_exc_currency" required>
                                            @foreach(\App\Models\Currency::availableCurrencies() as $key => $value)
                                                <option value="{{$key}}" @if(old('sell_price_vat_exc_currency') == $key) selected @endif>{{$value}}</option>
                                            @endforeach
                                        </select>
                                        @error('sell_price_vat_exc_currency')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                        </div>
                        <hr>

                        <button type="submit" class="btn btn-primary">{{__('main.create')}}</button>
                        <button type="button" onclick="window.location.href='{{ route('suppliers.index').'#pills-Flights-tab' }}';" class="btn btn-outline-primary">{{__('main.cancel')}}</button>
                    </form>

                </div>
            </div>

        </div>
    </div>
@endsection

@section('script_bottom')
<script>
    $(function () {
        $('#DepartureAtDDL, #ArrivalAtDDL').select2({
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
    });
</script>
@endsection
