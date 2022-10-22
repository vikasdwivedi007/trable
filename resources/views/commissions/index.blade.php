@extends('layouts.main')

@section('script_top_before_base')
    <!-- prism css -->
    <link rel="stylesheet" href="{{asset('assets/plugins/prism/css/prism.min.css')}}">
    <!-- data tables css -->
    <link rel="stylesheet" href="{{asset('assets/plugins/data-tables/css/datatables.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('assets/plugins/daterangepicker/daterangepicker.css')}}"/>

@endsection

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h5>{{__("main.commissions")}}</h5>
                    <div class="card-header-right">
                        <div class="btn-group card-option">
                            <button type="button" class="btn dropdown-toggle btn-icon" data-toggle="dropdown"
                                    aria-haspopup="true" aria-expanded="false">
                                <i class="feather icon-more-horizontal"></i>
                            </button>
                            <ul class="list-unstyled card-option dropdown-menu dropdown-menu-right">
                                <li class="dropdown-item full-card"><a href="#!"><span><i
                                                class="feather icon-maximize"></i> maximize</span><span
                                            style="display:none"><i
                                                class="feather icon-minimize"></i> Restore</span></a></li>
                                <li class="dropdown-item minimize-card"><a href="#!"><span><i
                                                class="feather icon-minus"></i> collapse</span><span
                                            style="display:none"><i class="feather icon-plus"></i> expand</span></a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="card-block">
                    <div class="row justify-content-center">
                        <div class="col-2">
                            <div class="form-group">
                                <select id="monthDDL" class="js-example-tags form-control" name="month">
                                    <option value="">{{__("main.month")}} *</option>
                                    <option @if($date->format('m') == '01') selected @endif value="01">January</option>
                                    <option @if($date->format('m') == '02') selected @endif value="02">Febuary</option>
                                    <option @if($date->format('m') == '03') selected @endif value="03">March</option>
                                    <option @if($date->format('m') == '04') selected @endif value="04">April</option>
                                    <option @if($date->format('m') == '05') selected @endif value="05">May</option>
                                    <option @if($date->format('m') == '06') selected @endif value="06">June</option>
                                    <option @if($date->format('m') == '07') selected @endif value="07">July</option>
                                    <option @if($date->format('m') == '08') selected @endif value="08">August</option>
                                    <option @if($date->format('m') == '09') selected @endif value="09">September
                                    </option>
                                    <option @if($date->format('m') == '10') selected @endif value="10">October</option>
                                    <option @if($date->format('m') == '11') selected @endif value="11">November</option>
                                    <option @if($date->format('m') == '12') selected @endif value="12">December</option>
                                </select>
                            </div>

                        </div>
                        <div class="col-2">
                            <div class="form-group">
                                <select id="YearDDL"
                                        class="js-example-tags form-control"
                                        name="year" required>
                                    <option value="">{{__("main.year")}} *</option>
                                    @for($i=\Carbon\Carbon::now()->year+1; $i>=\Carbon\Carbon::now()->subYears(10)->year;$i--)
                                        <option @if($date->format('Y') == $i) selected
                                                @endif value="{{$i}}">{{$i}}</option>
                                    @endfor
                                </select>
                            </div>
                        </div>
                        <div class="col-2">
                            <a href="#" onclick="printData();return false;" type="button"
                               class="btn btn-primary mb-4 float-right">
                                {{__("main.show_data")}}
                            </a>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table id="key-print-button"
                               class="table table-striped table-hover table-bordered nowrap w-100">
                            <thead>
                            <tr>
                                <th>{{__("main.serial_no")}}</th>
                                <th>{{__("main.file_no")}}</th>
                                <th>{{__("main.client_name")}}</th>
                                @foreach($operators as $op)
                                    <th>{{$op['user']['name']}} ({{$op['total']}})</th>
                                @endforeach
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($commissions as $comm)
                                <tr>
                                    <td>{{$loop->index+1}}</td>
                                    <td>{{$comm['job_file']['file_no']}}</td>
                                    <td>{{$comm['job_file']['client_name']}}</td>
                                    @for ($i = 0; $i < count($operators); $i++)
                                        @php $current_index = $comm['job_file']['file_no'] . '---' . $i; @endphp
                                        @if (in_array($current_index, $operators[$i]['indexes']))
                                            <td>{{$comm['amount']}}</td>
                                        @else
                                            <td></td>
                                        @endif
                                    @endfor
                                </tr>
                            @endforeach

                            </tbody>
                        </table>
                    </div>
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
    <script type="text/javascript" src="{{asset('assets/plugins/daterangepicker/daterangepicker.min.js')}}"></script>

    <script>
        function getDate() {
            let month_input = $("#monthDDL");
            let year_input = $("#YearDDL");
            let month = month_input.val().trim();
            let year = year_input.val().trim();
            return [month, year];
        }

        function printData() {
            let [month, year] = getDate();
            if (month && year) {
                let print_url = "{{ route('commissions.index') }}";
                let date = month + '-' + year;
                let url = print_url + "?date=" + date;
                window.location.href = url;
            }
        }

        $(function () {
            $('#key-print-button').DataTable({
                // Hide Search Bar
                //sDom: 'lrtip',
                bFilter: false,
                dom: 'Bfrtip',
                paging: false,
                buttons: [
                    'print'
                ]
            });
        })
    </script>
@endsection
