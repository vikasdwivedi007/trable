@extends('layouts.main')

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h5>{{__('main.update_train_ticket')}}</h5>
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
                    <form id="validation-form123" action="{{route('train-tickets.update', ['train_ticket'=>$train_ticket->id])}}" method="POST">
                        @method('PATCH')
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{__('main.type')}}</label>
                                    <select id="TrainTypeDDL"
                                            class="js-example-tags form-control @error('type') is-invalid @enderror"
                                            name="type" required>
                                        <option value="1" @if($train_ticket->type == 1) selected @endif>Sleeping</option>
                                        <option value="2" @if($train_ticket->type == 2) selected @endif>Seating</option>
                                    </select>
                                    @error('type')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>{{__('main.from_city')}}</label>
                                    <select id="CityFromDDL"
                                            class="js-example-tags form-control @error('from_station_id') is-invalid @enderror"
                                            name="from_station_id" required>
                                        <option value="">{{__('main.from_city')}}</option>
                                        @foreach($stations as $station)
                                            <option value="{{$station->id}}" @if($train_ticket->from_station_id == $station->id) selected @endif>{{$station->name}}</option>
                                        @endforeach
                                    </select>
                                    @error('from_station_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>{{__('main.to_city')}}</label>
                                    <select id="CityToDDL"
                                            class="js-example-tags form-control @error('to_station_id') is-invalid @enderror"
                                            name="to_station_id" required>
                                        <option value="">{{__('main.to_city')}}</option>
                                        @foreach($stations as $station)
                                            <option value="{{$station->id}}" @if($train_ticket->to_station_id == $station->id) selected @endif>{{$station->name}}</option>
                                        @endforeach
                                    </select>
                                    @error('to_station_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>{{__('main.departure_date')}}</label>
                                    <input type="text" id="Train-Departure-date" class="form-control @error('depart_date') is-invalid @enderror"
                                           name="depart_date" placeholder="{{__('main.departure_date')}}" required value="{{$train_ticket->depart_at->format('l d F Y')}}">
                                    @error('depart_date')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>{{__('main.departure_time')}}</label>
                                    <input type="text" id="Train-Departure-Time" class="form-control @error('depart_time') is-invalid @enderror"
                                           name="depart_time" placeholder="{{__('main.departure_time')}}" required value="{{$train_ticket->depart_at->format('H:i')}}">
                                    @error('depart_time')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>{{__('main.arrival_date')}}</label>
                                    <input type="text" id="Train-Arrival-date" class="form-control @error('arrive_date') is-invalid @enderror"
                                           name="arrive_date" placeholder="{{__('main.arrival_date')}}"  required value="{{$train_ticket->arrive_at->format('l d F Y')}}">
                                    @error('arrive_date')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>{{__('main.arrival_time')}}</label>
                                    <input type="text" id="Train-Arrival-Time" class="form-control @error('arrive_time') is-invalid @enderror"
                                           name="arrive_time" placeholder="{{__('main.arrival_time')}}"  required value="{{$train_ticket->arrive_at->format('H:i')}}">
                                    @error('arrive_time')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>{{__('main.train_number')}}</label>
                                    <input type="text" id="Train-Number" class="form-control @error('number') is-invalid @enderror"
                                           name="number" placeholder="{{__('main.train_number')}}"   value="{{$train_ticket->number}}">
                                    @error('number')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>{{__('main.wagon_no')}}</label>
                                    <input type="number" id="Wagon-Number" class="form-control  @error('wagon_no') is-invalid @enderror"
                                           name="wagon_no" placeholder="{{__('main.wagon_no')}}"  value="{{$train_ticket->wagon_no}}">
                                    @error('wagon_no')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>{{__('main.seat_bed_no')}}</label>
                                    <input type="number" id="Seat-Number" class="form-control  @error('seat_no') is-invalid @enderror"
                                           name="seat_no" placeholder="{{__('main.seat_bed_no')}}"  value="{{$train_ticket->seat_no}}">
                                    @error('seat_no')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>{{__('main.class')}}</label>
                                    <select id="TrainClassDDL"
                                            class="js-example-tags form-control @error('class') is-invalid @enderror"
                                            name="class" >
                                        <option value="0">{{__('main.class')}}</option>
                                        <option value="1" @if($train_ticket->class == 1) selected @endif>First Class</option>
                                        <option value="2" @if($train_ticket->class == 2) selected @endif>Second Class</option>
                                    </select>
                                    @error('class')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-3 @if($train_ticket->type == 2) d-none @endif" id="cabin_no">
                                <div class="form-group">
                                    <label>{{__('main.cabin_no')}}</label>
                                    <input type="number" id="Cabin-Number"
                                           class="form-control  @error('cabin_no') is-invalid @enderror"
                                           name="cabin_no" placeholder="{{__("main.cabin_no")}}"
                                           value="{{$train_ticket->cabin_no}}">
                                    @error('cabin_no')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>


                        </div>

                        <hr>

                        <label>{{__('main.sgl_ticket')}}</label>
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>{{__('main.buying_price')}}</label>
                                    <input id="SGL-Cabin-buy-pric" type="text" class="form-control autonumber @error('sgl_buy_price') is-invalid @enderror"
                                           name="sgl_buy_price"
                                           placeholder="{{__('main.buying_price')}}"  value="{{$train_ticket->sgl_buy_price}}">
                                    @error('sgl_buy_price')
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
                                        class="js-example-tags form-control @error('sgl_buy_currency') is-invalid @enderror"
                                        name="sgl_buy_currency" required>
                                        @foreach(\App\Models\Currency::availableCurrencies() as $key => $value)
                                            <option value="{{$key}}" @if($train_ticket->sgl_buy_currency == $key) selected @endif>{{$value}}</option>
                                        @endforeach
                                    </select>
                                    @error('sgl_buy_currency')
                                    <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>{{__('main.selling_price')}}</label>
                                    <input id="SGL-Cabin-sell-pric" type="text" class="form-control autonumber @error('sgl_sell_price') is-invalid @enderror"
                                           name="sgl_sell_price"
                                           placeholder="{{__('main.selling_price')}}" value="{{$train_ticket->sgl_sell_price}}">
                                    @error('sgl_sell_price')
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
                                        class="js-example-tags form-control @error('sgl_sell_currency') is-invalid @enderror"
                                        name="sgl_sell_currency" required>
                                        @foreach(\App\Models\Currency::availableCurrencies() as $key => $value)
                                            <option value="{{$key}}" @if($train_ticket->sgl_sell_currency == $key) selected @endif>{{$value}}</option>
                                        @endforeach
                                    </select>
                                    @error('sgl_sell_currency')
                                    <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <hr>
                        <label>{{__('main.per_person_dbl_ticket')}}</label>
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>{{__('main.buying_price')}}</label>
                                    <input id="DBL-Cabin-buy-pric" type="text" class="form-control autonumber @error('dbl_buy_price') is-invalid @enderror"
                                           name="dbl_buy_price"
                                           placeholder="{{__('main.buying_price')}}"  value="{{$train_ticket->dbl_buy_price}}">
                                    @error('dbl_buy_price')
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
                                        class="js-example-tags form-control @error('dbl_buy_currency') is-invalid @enderror"
                                        name="dbl_buy_currency" required>
                                        @foreach(\App\Models\Currency::availableCurrencies() as $key => $value)
                                            <option value="{{$key}}" @if($train_ticket->dbl_buy_currency == $key) selected @endif>{{$value}}</option>
                                        @endforeach
                                    </select>
                                    @error('dbl_buy_currency')
                                    <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>{{__('main.selling_price')}}</label>
                                    <input id="DBL-Cabin-sell-pric" type="text" class="form-control autonumber @error('dbl_sell_price') is-invalid @enderror"
                                           name="dbl_sell_price"
                                           placeholder="{{__('main.selling_price')}}"  value="{{$train_ticket->dbl_sell_price}}">
                                    @error('dbl_sell_price')
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
                                        class="js-example-tags form-control @error('dbl_sell_currency') is-invalid @enderror"
                                        name="dbl_sell_currency" required>
                                        @foreach(\App\Models\Currency::availableCurrencies() as $key => $value)
                                            <option value="{{$key}}" @if($train_ticket->dbl_sell_currency == $key) selected @endif>{{$value}}</option>
                                        @endforeach
                                    </select>
                                    @error('dbl_sell_currency')
                                    <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                    @enderror
                                </div>
                            </div>
                        </div>


                        <button type="submit" class="btn btn-primary">{{__('main.update')}}</button>
                        <button type="button" onclick="window.location.href='{{route('suppliers.index').'#pills-Train-Tickets-tab'}}';" class="btn btn-outline-primary">{{__('main.cancel')}}</button>
                    </form>

                </div>
            </div>

        </div>
    </div>
@endsection

@section('script_bottom')
    <script>
        function handleTrainTypeChange(type, clear=false){
            if(type == '1'){
                if(clear){
                    $("#cabin_no input").val("");
                }
                $("#cabin_no").removeClass('d-none');
                $("#Seat-Number").attr('placeholder', "{{__('main.bed_no')}}");
            }else{
                if(clear){
                    $("#cabin_no input").val("");
                }
                $("#cabin_no").addClass('d-none');
                $("#Seat-Number").attr('placeholder', "{{__('main.seat_no')}}");
            }
        }
        $(function () {
            handleTrainTypeChange($("#TrainTypeDDL").val());

            $("#TrainTypeDDL").change(function () {
                let type = $(this).val();
                handleTrainTypeChange(type, true);
            });

            $('[name="depart_date"]').bootstrapMaterialDatePicker('setMaxDate', '{{$train_ticket->arrive_at->format("l d F Y")}}');
            $('[name="arrive_date"]').bootstrapMaterialDatePicker('setMinDate', '{{$train_ticket->depart_at->format("l d F Y")}}');

            $('[name="arrive_date"]').on('change', function (e, date) {
                $('[name="depart_date"]').bootstrapMaterialDatePicker('setMaxDate', date);
            });

            $('[name="depart_date"]').on('change', function (e, date) {
                $('[name="arrive_date"]').bootstrapMaterialDatePicker('setMinDate', date);
            });
        });
    </script>
@endsection
