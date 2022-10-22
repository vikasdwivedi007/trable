@extends('layouts.main')

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h5>{{__("main.update_monthly_commission")}} </h5>
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
                    <form id="validation-form123" action="{{route('traffic-monthly-commissions.update', ['traffic_monthly_commission'=>$commission->id])}}" method="POST">
                        @method('PATCH')
                        @csrf
                        <div class="row">
                            <div class="col-md-2">
                                <div class="form-group">
                                    @php
                                        $month = $commission->date->format('m');
                                        $year = $commission->date->format('Y');
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
                            <div class="col-md-4">
                                <div class="form-group">
                                  <label>{{__('main.job_file')}} </label>
                                    <select id="JobFileDDL"
                                            class="js-example-tags form-control"
                                            name="job_id" required>
                                        <option value="">{{__("main.job_file")}} *</option>
                                        @foreach($job_files as $job_file)
                                            <option value="{{$job_file->id}}" @if($commission->job_id == $job_file->id) selected @endif>{{$job_file->file_no}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>{{__('main.amount')}} </label>
                                    <input type="text" class="form-control autonumber"
                                           name="amount"
                                           placeholder="{{__("main.amount")}} *" data-a-sign="EGP " value="{{$commission->amount}}" required>
                                </div>
                            </div>
                        </div>

                        <hr>

                        <button type="submit" class="btn btn-primary">{{__("main.update")}}</button>
                        <button type="button" onclick="window.location.href='{{ route('traffic-monthly-commissions.index')}}';" class="btn btn-outline-primary">{{__("main.cancel")}}</button>
                    </form>

                </div>
            </div>

        </div>
    </div>
@endsection
