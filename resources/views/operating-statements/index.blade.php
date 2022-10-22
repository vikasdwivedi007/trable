@extends('layouts.main')

@section('script_top_before_base')
    <!-- prism css -->
    <link rel="stylesheet" href="{{asset('assets/plugins/prism/css/prism.min.css')}}">
    <!-- data tables css -->
    <link rel="stylesheet" href="{{asset('assets/plugins/data-tables/css/datatables.min.css')}}">
@endsection

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h5>{{__('main.operating_statement')}}</h5>
                    <div class="card-header-right">
                        <div class="btn-group card-option">
                            <button type="button" class="btn dropdown-toggle btn-icon" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="feather icon-more-horizontal"></i>
                            </button>
                            <ul class="list-unstyled card-option dropdown-menu dropdown-menu-right">
                                <li class="dropdown-item full-card"><a href="#!"><span><i class="feather icon-maximize"></i> maximize</span><span style="display:none"><i class="feather icon-minimize"></i> Restore</span></a></li>
                                <li class="dropdown-item minimize-card"><a href="#!"><span><i class="feather icon-minus"></i> collapse</span><span style="display:none"><i class="feather icon-plus"></i> expand</span></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="card-block">

                    <div class="row">
                        <div class="col-md-3">
                            <a href="{{route('operating-statements.create')}}"  class="btn btn-primary mb-4">
                                {{__('main.create_operating_statement')}}
                            </a>
                        </div>
                        <div class="col-md-2 align-self-center">
{{--                            <label class="font-weight-bold text-uppercase">Total Amount: </label>--}}
{{--                            <label class="font-weight-bold text-uppercase"> 4800 EGP</label>--}}
                        </div>
                        <div class="col-2">
                            <div class="form-group">
                                <select id="monthDDL" class="js-example-tags form-control" name="month">
                                    <option value="">{{__('main.month')}} *</option>
                                    <option value="01">January</option>
                                    <option value="02">Febuary</option>
                                    <option value="03">March</option>
                                    <option value="04">April</option>
                                    <option value="05">May</option>
                                    <option value="06">June</option>
                                    <option value="07">July</option>
                                    <option value="08">August</option>
                                    <option value="09">September</option>
                                    <option value="10">October</option>
                                    <option value="11">November</option>
                                    <option value="12">December</option>
                                </select>
                            </div>

                        </div>
                        <div class="col-2">
                            <div class="form-group">
                                <select id="YearDDL"
                                        class="js-example-tags form-control"
                                        name="year" required>
                                    <option value="">{{__('main.year')}} *</option>
                                    @for($i=\Carbon\Carbon::now()->year+1; $i>=\Carbon\Carbon::now()->subYears(10)->year;$i--)
                                        <option value="{{$i}}">{{$i}}</option>
                                    @endfor
                                </select>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <a href="#" onclick="printData();return false;" type="button" class="btn btn-primary mb-4 float-right">
                                {{__('main.print')}}
                            </a>
                            <a href="#" onclick="showData();return false;" type="button" class="btn btn-primary mb-4 float-right">
                                {{__('main.show_data')}}
                            </a>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table id="responsive-table" class="table table-striped table-hover table-bordered nowrap w-100">
                            <thead>
                            <tr>
                                <th>{{__('main.action')}}</th>
                                <th>{{__('main.date')}}</th>
                                <th>{{__('main.file_no')}}</th>
                                <th>{{__('main.representative')}}</th>
                            </tr>
                            </thead>
                            <tbody>
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

    <script>
        var datatable;

        function getDate(){
            let month_input = $("#monthDDL");
            let year_input = $("#YearDDL");
            let month = month_input.val().trim();
            let year = year_input.val().trim();
            return [month, year];
        }

        function showData(){
            let [month, year] = getDate();
            if(month && year){
                let query = year+"-"+month;

                datatable.search( query ).draw();
            }else{
                datatable.search( '' ).draw();
            }
        }

        function printData(){
            let [month, year] = getDate();
            if(month && year){
                let print_url = "{{ route('operating-statements.print') }}";
                let url =  print_url + "?month="+month+"&year="+year;
                // window.location.href = url;
                window.open(url,'_blank');
            }
        }
        $(function () {
            var edit_path = '{{ route('operating-statements.edit', ['operating_statement'=> 'operating_statement_id']) }}';
            var destroy_path = '{{ route('operating-statements.destroy', ['operating_statement'=> 'operating_statement_id']) }}';

            datatable = $('#responsive-table').DataTable({
                paging: true,
                "processing": true,
                "serverSide": true,
                "ajax": "{{ route('operating-statements.index') }}",
                "order": [[ 1, "desc" ]],
                "columns": [
                    {
                        "targets": -1,
                        "data": null,
                        "render": function(data, type, row){
                            @if(!auth()->user()->hasPermission(\App\Models\OperatingStatement::PERMISSION_NAME, 'write'))
                                return '';
                            @endif
                            var content = '<div class="dropdown text-center">\n' +
                                '    <a href="#" class="dropdown-toggle" data-toggle="dropdown">\n' +
                                '        <i class=\'feather icon-more-vertical\'></i>\n' +
                                '    </a>\n' +
                                '    <div class="dropdown-menu dropdown-menu-left profile-notification">\n' +
                                '        <ul class="pro-body">\n';

                            content +='            <li>\n' +
                            '                <a href="'+edit_path.replace('operating_statement_id', row.id)+'" class="dropdown-item">\n' +
                            '                    <i class="mdi mdi-square-edit-outline"></i> {{__("main.edit")}}' +
                            '                </a>\n' +
                            '            </li>\n' +
                            '            <li>\n' +
                            '                <form action="'+destroy_path.replace('operating_statement_id', row.id)+'" method="POST">\n' +
                            '                @method("DELETE")\n' +
                            '                @csrf'+
                            '                <a href="#" class="dropdown-item confirm_delete">\n' +
                            '                    <i class="mdi mdi-delete-forever"></i> {{__("main.delete")}}' +
                            '                </a>\n' +
                            '                </form>' +
                            '            </li>\n';

                                content += '</ul>\n' +
                                '</div>\n' +
                                '</div>';

                            return content;
                        }
                    },
                    { "data": "date" },
                    { "data": "job_file.file_no" },
                    { "data": "employee_user.name" },
                ]
            });
        });
    </script>
@endsection
