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
                    <h5>{{__("main.job_files")}}</h5>
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
                        @if(auth()->user()->hasPermission(\App\Models\JobFile::PERMISSION_NAME, 'write'))
                            <div class="col-md-3">
                                <a href="{{ route('job-files.create') }}"  class="btn btn-primary mb-4">
                                    {{__("main.create_new_file")}}
                                </a>
                            </div>
                        @endif
                        <div class="col-3">
                            <div class="form-group">
                                <input type="text" class="form-control" id="date_range_picker" value="" placeholder="{{__("main.search_by_date_range")}}">
                            </div>
                        </div>
                        <div class="col-md-3 text-left">
                            <a href="#" onclick="showData();return false;" type="button" class="btn btn-primary mb-4">
                                {{__("main.filter")}}
                            </a>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table id="fixed-columns-left" class="table table-striped table-hover table-bordered nowrap w-100">
                            <thead>
                            <tr>
                                <th>{{__("main.action")}}</th>
                                <th>{{__("main.created_at")}}</th>
                                <th>{{__("main.file_no")}}</th>
                                <th>{{__("main.invoice_no")}}</th>
                                <th>{{__("main.command_no")}}</th>
                                <th>{{__("main.travel_agent")}}</th>
                                <th>{{__("main.request_date")}}</th>
                                <th>{{__("main.client_name")}}</th>
                                <th>{{__("main.operator_name")}}</th>
                                <th>{{__("main.reviewer_name")}}</th>
                                <th>{{__("main.status")}}</th>
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
    <script type="text/javascript" src="{{asset('assets/plugins/daterangepicker/daterangepicker.min.js')}}"></script>

    <script>
        var datatable;

        function showData(){
            let range = $('#date_range_picker').val();
            if(range){
                let query = 'date-range:'+range;
                datatable.search( query ).draw();
            }else{
                datatable.search( '' ).draw();
            }
        }
        $(function () {
            $('#date_range_picker').val("");
            $('#date_range_picker').daterangepicker({
                autoUpdateInput: false,
                locale: {
                    cancelLabel: 'Clear'
                }
            });
            $('#date_range_picker').on('apply.daterangepicker', function(ev, picker) {
                $(this).val(picker.startDate.format('DD/MM/YYYY') + ' - ' + picker.endDate.format('DD/MM/YYYY'));
            });

            $('#date_range_picker').on('cancel.daterangepicker', function(ev, picker) {
                $(this).val('');
                showData();
            });

            $(document).on('click','.confirm_approve',function (e){
                e.preventDefault();
                Swal.fire({
                    icon: 'info',
                    title: 'Are you sure?',
                    showCancelButton: true,
                    confirmButtonColor: '#188250',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Yes, approve'
                }).then((result) => {
                    if (result.isConfirmed) {
                        this.closest('form').submit();
                    }
                })
            });

            var edit_path = '{{ route('job-files.edit', ['job_file'=> 'job_file_id']) }}';
            var view_path = '{{ route('job-files.show', ['job_file'=> 'job_file_id']) }}';
            var print_path = '{{ route('job-files.show', ['job_file'=> 'job_file_id']).'?print=1' }}';
            var approve_path = '{{ route('job-files.review', ['job_file'=> 'job_file_id', 'status' => 1]) }}';
            var delegate_path = '{{ route('job-files.delegate', ['job_file'=> 'job_file_id']) }}';

            datatable = $('#fixed-columns-left').DataTable({
                paging: true,
                "processing": true,
                "serverSide": true,
                "order": [[ 1, "desc" ]],
                "ajax": "{{ route('job-files.index') }}",
                "columns": [
                    {
                        "data": null,
                        "render": function(data, type, row){
                            var content = '<div class="dropdown text-center">\n' +
                                '    <a href="#" class="dropdown-toggle" data-toggle="dropdown">\n' +
                                '        <i class=\'feather icon-more-vertical\'></i>\n' +
                                '    </a>\n' +
                                '    <div class="dropdown-menu dropdown-menu-left profile-notification">\n' +
                                '        <ul class="pro-body">\n' ;
                            @if(auth()->user()->hasPermission(\App\Models\JobFile::PERMISSION_NAME, 'write'))
                            if(row.can_edit) {
                                content += '            <li>\n' +
                                    '                <a href="' + edit_path.replace('job_file_id', row.id) + '" class="dropdown-item">\n' +
                                    '<i class="mdi mdi-square-edit-outline"></i>' +
                                    '                    {{__("main.edit")}}' +
                                    '                </a>\n' +
                                    '            </li>\n';
                            }
                            @endif
                            @if(auth()->user()->hasPermission(\App\Models\JobFile::PERMISSION_NAME, 'read'))
                            content += '            <li>\n' +
                                '                <a target="_blank" href="'+view_path.replace('job_file_id', row.id)+'" class="dropdown-item">\n' +
                                '<i class="mdi mdi-eye"></i>' +
                                '                    {{__("main.view")}}' +
                                '                </a>\n' +
                                '            </li>\n' ;
                            content += '            <li>\n' +
                                '                <a target="_blank" href="'+print_path.replace('job_file_id', row.id)+'" class="dropdown-item">\n' +
                                '<i class="mdi mdi-printer"></i>'+
                                '                    {{__("main.print")}}' +
                                '                </a>\n' +
                                '            </li>\n' ;
                            @endif

                            @if(auth()->user()->hasPermission(\App\Models\JobFileReview::PERMISSION_NAME, 'write'))
                            if(row.status_num == 0) {
                                content += '            <li>\n' +
                                    '                <form action="' + approve_path.replace('job_file_id', row.id) + '" method="POST">\n' +
                                    '                @csrf' +
                                    '                <a href="#" class="dropdown-item confirm_approve">\n' +
                                    '                    <i class="mdi mdi-check"></i> {{__("main.approve")}}' +
                                    '                </a>\n' +
                                    '                </form>' +
                                    '            </li>\n';
                            }
                            @endif
                            @if(auth()->user()->hasPermission(\App\Models\JobFile::PERMISSION_NAME, 'write'))
                            if(row.can_delegate){
                                content += '            <li>\n' +
                                    '                <a href="'+delegate_path.replace('job_file_id', row.id)+'" class="dropdown-item">\n' +
                                    '<i class="mdi mdi-arrow-right"></i>' +
                                    '                    {{__("main.delegate")}}' +
                                    '                </a>\n' +
                                    '            </li>\n' ;
                            }
                            @endif

                            content += '</ul>\n' +
                                '</div>\n' +
                                '</div>';

                            return content;
                        }
                    },
                    { "data": "created_at" },
                    { "data": "file_no" },
                    { "data": "invoice_no", 'orderable':false },
                    { "data": "command_no" },
                    { "data": "travel_agent.name" },
                    { "data": "request_date" },
                    { "data": "client_name" },
                    { "data": "operator_name", 'orderable': false},
                    { "data": "reviewer_name", 'orderable':false },
                    { "data": "status", 'orderable':false },
                ]
            });
        });
    </script>
@endsection
