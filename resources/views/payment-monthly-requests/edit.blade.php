@extends('layouts.main')

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h5>{{__("main.update_payment_monthly_request")}}</h5>
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
                    <form id="validation-form123" action="{{route('payment-monthly-requests.update', ['payment_monthly_request'=>$payment_request->id])}}" method="POST">
                        @method('PATCH')
                        @csrf
                        <div class="row">
                            <div class="col-md-2">
                                <div class="form-group">
                                    @php
                                    $month = $payment_request->date->format('m');
                                    $year = $payment_request->date->format('Y');
                                    @endphp
                                    <label>{{__('main.month')}} </label>
                                    <select id="MonthDDL"
                                            class="js-example-tags form-control"
                                            name="month" required>
                                        <option value="">{{__("main.month")}} *</option>
                                        <option value="01" @if($month == '01') selected @endif>January</option>
                                        <option value="02" @if($month == '02') selected @endif>Febuary</option>
                                        <option value="03" @if($month == '03') selected @endif>March</option>
                                        <option value="04" @if($month == '04') selected @endif>April</option>
                                        <option value="05" @if($month == '05') selected @endif>May</option>
                                        <option value="06" @if($month == '06') selected @endif>June</option>
                                        <option value="07" @if($month == '07') selected @endif>July</option>
                                        <option value="08" @if($month == '08') selected @endif>August</option>
                                        <option value="09" @if($month == '09') selected @endif>September</option>
                                        <option value="10" @if($month == '10') selected @endif>October</option>
                                        <option value="11" @if($month == '11') selected @endif>November</option>
                                        <option value="12" @if($month == '12') selected @endif>December</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>{{__('main.year')}} </label>
                                    <select id="YearDDL"
                                            class="js-example-tags form-control"
                                            name="year" required>
                                        <option value="">{{__("main.year")}} *</option>
                                        @for($i=\Carbon\Carbon::now()->year+1; $i>=\Carbon\Carbon::now()->subYears(10)->year;$i--)
                                            <option value="{{$i}}" @if($year == $i) selected @endif>{{$i}}</option>
                                        @endfor
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>{{__('main.request_date')}} </label>
                                    <input type="text" id="date" class="form-control"
                                           name="request_date" value="{{$payment_request->toArray()['request_date']}}" required placeholder="{{__("main.request_date")}} *">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>{{__('main.number_of_files')}} </label>
                                    <input type="number" class="form-control" min="0"
                                           name="files_count"
                                           placeholder="{{__("main.number_of_files")}} *" required value="{{$payment_request->files_count}}">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>{{__('main.amount')}} </label>
                                    <input type="text" class="form-control autonumber"
                                           name="amount"
                                           placeholder="{{__("main.amount")}} *" data-a-sign="EGP " required value="{{$payment_request->amount}}">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                  <label>{{__('main.total_amount')}} </label>
                                    <input type="text" name="total" class="form-control autonumber"
                                           placeholder="{{__("main.total_amount")}}" data-a-sign="EGP " disabled value="{{$payment_request->total}}">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <input type="text" id="words-of-number" name="words"
                                           class="form-control form-control-asLabel" placeholder="{{__("main.amount_as_words")}}" value="{{$payment_request->words}}">
                                </div>
                            </div>
                        </div>


                        <hr>

                        <button type="submit" class="btn btn-primary">{{__("main.update")}}</button>
                        <button type="button" onclick="window.location.href='{{ route('payment-monthly-requests.index')}}';" class="btn btn-outline-primary">{{__("main.cancel")}}</button>
                    </form>

                </div>
            </div>

        </div>
    </div>
@endsection


@section('script_bottom')
    <script src="{{asset('assets/plugins/written-number/dist/written-number.min.js')}}"></script>

    <script>
        function delay(callback, ms) {
            var timer = 0;
            return function () {
                var context = this, args = arguments;
                clearTimeout(timer);
                timer = setTimeout(function () {
                    callback.apply(context, args);
                }, ms || 0);
            };
        }

        function calculateTotal(){
            let files_count_input = $("input[name='files_count']");
            let amount_input = $("input[name='amount']");
            let total_input = $("input[name='total']");
            let words_input = $("input[name='words']");

            let files_count = parseInt(files_count_input.val());
            let amount = parseFloat(amount_input.val().replace(/EGP/g, '').replace(/,/g, '').trim());

            if(files_count>0 && amount>0){
                let total = files_count * amount;
                total_input.val("EGP "+total);
                words_input.val(writtenNumber(total, {lang: 'ar'})+" جنيها");
            }else{
                total_input.val("");
                words_input.val("");
            }
        }

        $(function () {
            $(document).on("keyup", "input[name='files_count'], input[name='amount']", delay(function (e) {
                calculateTotal();
            }));
        });
    </script>
@endsection
