@extends('layouts.main')

@section('script_top_before_base')
    <!-- prism css -->
    <link rel="stylesheet" href="{{asset('assets/plugins/prism/css/prism.min.css')}}">
@endsection

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h5>{{__("main.files")}}</h5>
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
                    <div class="row justify-content-end">
                        <div class="col-2">

                            <div class="form-group d-inline">

                                <div class="radio radio-primary d-inline">
                                    <input type="radio" name="files_chart_type" id="files_chart_column"
                                           value="column" onclick="chartfunc()" checked>
                                    <label for="files_chart_column" class="cr">{{__("main.column")}}</label>
                                </div>
                            </div>
                            <div class="form-group d-inline">
                                <div class="radio radio-primary d-inline">
                                    <input type="radio" name="files_chart_type" id="files_chart_pie" value="column" onclick="chartfunc()">
                                    <label for="files_chart_pie" class="cr">{{__("main.pie")}}</label>
                                </div>
                            </div>

                            <!-- <button class="btn btn-primary" id="bar">Bar chart</button>
                            <button class="btn btn-primary" id="pie">Pie chart</button> -->
                        </div>
                        <div class="col-2">
                            <div class="form-group">
                                <select id="FilesChartYearDDL" class="js-example-tags form-control"
                                        name="validation-select">
                                    @for($i=\Carbon\Carbon::now()->year;$i>=\Carbon\Carbon::now()->year-5;$i--)
                                        <option value="{{$i}}">{{$i}}</option>
                                    @endfor
                                </select>
                            </div>
                        </div>
                    </div>

                    <hr>

                    <div id="file-chart" class="highcharts" style="height: 350px;"></div>
                    <!-- <div id="am-pie-2" class="chart-white" style="height: 400px"></div>
                    <div id="bar-chart2" class="bar-chart2" style="height:350px;"></div> -->
                </div>
            </div>

        </div>

        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h5>{{__("main.room_nights")}}</h5>
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
                    <div class="row justify-content-end">
                        <div class="col-2">

                            <div class="form-group d-inline">

                                <div class="radio radio-primary d-inline">
                                    <input type="radio" name="rooms_chart_type" id="rooms_chart_column"
                                           value="column" onclick="roomschartfunc()" checked>
                                    <label for="rooms_chart_column" class="cr">{{__("main.column")}}</label>
                                </div>
                            </div>
                            <div class="form-group d-inline">
                                <div class="radio radio-primary d-inline">
                                    <input type="radio" name="rooms_chart_type" id="rooms_chart_pie" value="column" onclick="roomschartfunc()">
                                    <label for="rooms_chart_pie" class="cr">{{__("main.pie")}}</label>
                                </div>
                            </div>

                            <!-- <button class="btn btn-primary" id="bar">Bar chart</button>
                            <button class="btn btn-primary" id="pie">Pie chart</button> -->
                        </div>
                        <div class="col-2">
                            <div class="form-group">
                                <select id="RoomsChartHotelDDL" class="js-example-tags form-control"
                                        name="validation-select">
                                    @foreach($hotels as $hotel)
                                        <option value="{{$hotel->id}}" @if($loop->first) selected @endif>{{$hotel->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-2">
                            <div class="form-group">
                                <select id="RoomsChartYearDDL" class="js-example-tags form-control"
                                        name="validation-select">
                                    @for($i=\Carbon\Carbon::now()->year;$i>=\Carbon\Carbon::now()->year-5;$i--)
                                        <option value="{{$i}}">{{$i}}</option>
                                    @endfor
                                </select>
                            </div>
                        </div>
                    </div>

                    <hr>

                    <div id="room-chart" class="bar-chart2" style="height:330px;"></div>
                </div>
            </div>

        </div>

        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h5>{{__("main.clients")}}</h5>
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
                    <div class="row justify-content-end">
                        <div class="col-2">

                            <div class="form-group d-inline">

                                <div class="radio radio-primary d-inline">
                                    <input type="radio" name="clients_chart_type" id="clients_chart_column"
                                           value="column" onclick="clientschartfunc()" checked>
                                    <label for="clients_chart_column" class="cr">{{__("main.column")}}</label>
                                </div>
                            </div>
                            <div class="form-group d-inline">
                                <div class="radio radio-primary d-inline">
                                    <input type="radio" name="clients_chart_type" id="clients_chart_pie" value="column" onclick="clientschartfunc()">
                                    <label for="clients_chart_pie" class="cr">{{__("main.pie")}}</label>
                                </div>
                            </div>

                            <!-- <button class="btn btn-primary" id="bar">Bar chart</button>
                            <button class="btn btn-primary" id="pie">Pie chart</button> -->
                        </div>
                        <div class="col-2">
                            <div class="form-group">
                                <select id="ClientsChartYearDDL" class="js-example-tags form-control"
                                        name="validation-select">
                                    @for($i=\Carbon\Carbon::now()->year;$i>=\Carbon\Carbon::now()->year-5;$i--)
                                        <option value="{{$i}}">{{$i}}</option>
                                    @endfor
                                </select>
                            </div>
                        </div>
                    </div>

                    <hr>

                    <div id="client-chart" class="bar-chart2" style="height:330px;"></div>
                </div>
            </div>

        </div>
    </div>
@endsection


@section('script_bottom')
    <!-- datatable Js -->
    <script src="{{asset('assets/plugins/data-tables/js/datatables.min.js')}}"></script>
    <!-- prism Js -->
    <script src="{{asset('assets/plugins/prism/js/prism.min.js')}}"></script>

    <!-- highchart chart -->
    <script src="http://code.highcharts.com/highcharts.js"></script>

    <script>
        var files_report_url = "{{route('reports.getReport', ['report_type'=>'files-report'])}}";
        var clients_report_url = "{{route('reports.getReport', ['report_type'=>'clients'])}}";
        var rooms_report_url = "{{route('reports.getReport', ['report_type'=>'rooms'])}}";
    </script>
    <script src="{{asset('assets/js/reports.js')}}"></script>
@endsection
