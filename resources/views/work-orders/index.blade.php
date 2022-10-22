@extends('layouts.main')

@section('script_top_before_base')
    <!-- prism css -->
    <link rel="stylesheet" href="{{asset('assets/plugins/prism/css/prism.min.css')}}">
    <!-- data tables css -->
    <link rel="stylesheet" href="{{asset('assets/plugins/data-tables/css/datatables.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('assets/plugins/daterangepicker/daterangepicker.css')}}" />
@endsection

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h5>{{__("main.work_orders")}}</h5>
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
                    <div class="row">
                        @if(auth()->user()->can('create', \App\Models\WorkOrder::class))
                            <div class="col-md-3">
                                <a href="{{ route('work-orders.create') }}"  class="btn btn-primary mb-4">
                                    {{__("main.create_work_order")}}
                                </a>
                            </div>
                        @endif

                    </div>


                    <div class="table-responsive">
                        <table id="responsive-table"
                               class="table table-striped table-hover table-bordered nowrap w-100">
                            <thead>
                            <tr>
                                <th >{{__("main.action")}}</th>
                                <th >{{__("main.serial_no")}}</th>
                                <th >{{__("main.file_no")}}</th>
                                <th >{{__("main.representative_name")}}</th>
                                <th >{{__("main.representative_phone")}}</th>
                                <th >{{__("main.request_date")}}</th>
                                <th >{{__("main.flight_number")}}</th>
                                <th >{{__("main.arrival_date")}}</th>
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

    <script src="{{asset('assets/plugins/prism/js/prism.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('assets/plugins/daterangepicker/daterangepicker.min.js')}}"></script>

    <script>

        $(function () {

            $('#responsive-table').DataTable({
                paging: true,
                "processing": true,
                "serverSide": true,
                "ajax": "{{ route('work-orders.index') }}",
                "order": [[ 4, "desc" ]],
                "columns": [
                    {
                        "data": null,
                        "render": function(data, type, row){
                            var content = '<div class="dropdown text-center">\n' +
                                '    <a href="#" class="dropdown-toggle" data-toggle="dropdown">\n' +
                                '        <i class=\'feather icon-more-vertical\'></i>\n' +
                                '    </a>\n' +
                                '    <div class="dropdown-menu dropdown-menu-left profile-notification">\n' +
                                '        <ul class="pro-body">\n';
                            if(row.can_edit){
                                content += '            <li>\n' +
                                    '                <a href="'+row.edit_path+'" class="dropdown-item">\n' +
                                    '                    <i class="mdi mdi-square-edit-outline"></i> {{__("main.edit")}}' +
                                    '                </a>\n' +
                                    '            </li>\n' ;
                            }

                            if(row.can_view){
                                content += '            <li>\n' +
                                    '                <a target="_blank" href="'+row.view_path+'" class="dropdown-item">\n' +
                                    '                    <i class="mdi mdi-eye"></i> {{__("main.view")}}' +
                                    '                </a>\n' +
                                    '            </li>\n' ;
                                content += '            <li>\n' +
                                    '                <a target="_blank" href="'+row.view_path+"?print=1"+'" class="dropdown-item">\n' +
                                    '                    <i class="mdi mdi-printer"></i> {{__("main.print")}}' +
                                    '                </a>\n' +
                                    '            </li>\n' ;
                            }

                            if(row.can_delete){
                                content += '            <li>\n' +
                                    '                <form action="' + row.delete_path + '" method="POST">\n' +
                                    '                @method("DELETE")\n' +
                                    '                @csrf'+
                                    '                <a href="#" class="dropdown-item confirm_delete">\n' +
                                    '                    <i class="mdi mdi-delete-forever"></i> {{__("main.delete")}}' +
                                    '                </a>\n' +
                                    '                </form>' +
                                    '            </li>\n';
                            }


                            content += '</ul>\n' +
                            '</div>\n' +
                            '</div>';

                            return content;
                        }
                    },
                    { "data": "serial_no" },
                    { "data": "job_file.file_no" },
                    { "data": "representative_user.name" },
                    { "data": "representative_user.phone" },
                    { "data": "date" },
                    { "data": "job_file.arrival_flight" },
                    { "data": "job_file.arrival_date" },
                ]
            });
        });
    </script>
@endsection
