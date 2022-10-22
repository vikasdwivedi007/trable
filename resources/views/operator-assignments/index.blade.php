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
                    <h5>{{__('main.operator_assignments')}}</h5>
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
                        @if(auth()->user()->hasPermission(\App\Models\OperatorAssignment::PERMISSION_NAME, 'write'))
                            <div class="col-md-3">
                                <a href="{{ route('operator-assignments.create') }}"  class="btn btn-primary mb-4">
                                    {{__('main.assign_to_operator')}}
                                </a>
                            </div>
                        @endif
                        <div class="col-3">
                            <div class="form-group">
                                <input type="text" class="form-control" id="date_range_picker" value="" placeholder="{{__('main.search_by_date_range')}}">
                            </div>
                        </div>
                        @isset($operators)
                        <div class="col-3">
                            <div class="form-group">
                                <select id="emp_id" class="form-control js-example-tags ">
                                    <option value="">{{__('main.operator')}}</option>
                                    @foreach($operators as $operator)
                                        <option value="{{$operator->id}}">{{$operator->user->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        @endisset
                        <div class="col-md-1 text-left">
                            <a href="#" onclick="showData();return false;" type="button" class="btn btn-primary mb-4">
                                {{__('main.filter')}}
                            </a>
                        </div>
                        @if(auth()->user()->can('create', \App\Models\OperatorAssignment::class))
                        <div class="col-md-1 text-left">
                            <a href="#" onclick="printData();return false;" type="button" class="btn btn-primary mb-4">
                                {{__('main.print')}}
                            </a>
                        </div>
                        @endif
                    </div>


                    <div class="table-responsive">
                        <table id="responsive-table"
                               class="table table-striped table-hover table-bordered nowrap w-100">
                            <thead>
                            <tr>
                                <th >{{__('main.action')}}</th>
                                <th >{{__('main.date')}}</th>
                                <th >{{__('main.file_no')}}</th>
                                <th >{{__('main.travel_agent')}}</th>
                                <th >{{__('main.client_name')}}</th>
                                <th >{{__('main.operator')}}</th>
                                <th >{{__('main.status')}}</th>
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
        var datatable;

        function showData(){
            let range = $('#date_range_picker').val();
            let emp_id = '';
            if($("#emp_id").length){
                emp_id = $("#emp_id").val();
            }
            if(range){
                let query = 'date-range:'+range;
                if(emp_id){
                    query += "&emp-id:"+emp_id;
                }
                datatable.search( query ).draw();
            }else{
                $('#date_range_picker').val("");
                $('#emp_id').val("").trigger('change');
                datatable.search( '' ).draw();
            }
        }
        @if(auth()->user()->can('create', \App\Models\OperatorAssignment::class))
        function printData(){
            let range = $('#date_range_picker').val();
            let emp_id = '';
            if($("#emp_id").length){
                emp_id = $("#emp_id").val();
            }
            if(range && emp_id){
                let query = 'date-range='+range;
                if(emp_id){
                    query += "&emp-id="+emp_id;
                }
                let print_url = "{{ route('operator-assignments.print') }}";
                let url =  print_url + '?' +query;
                window.open(url,'_blank');
            }else{
                $('#date_range_picker').val("");
                $('#emp_id').val("").trigger('change');
                datatable.search( '' ).draw();
            }
        }
        @endif


        $(function () {
            $('#date_range_picker').val("");
            $('#emp_id').val("").trigger('change');

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


            var edit_path = '{{ route('operator-assignments.edit', ['operator_assignment'=> 'operator_assignment_id']) }}';
            var destroy_path = '{{ route('operator-assignments.destroy', ['operator_assignment'=> 'operator_assignment_id']) }}';
            var approve_path = '{{ route('operator-assignments.review', ['operator_assignment'=> 'operator_assignment_id', 'status'=> \App\Models\OperatorAssignment::STATUS_APPROVED]) }}';
            var deny_path = '{{ route('operator-assignments.review', ['operator_assignment'=> 'operator_assignment_id', 'status'=> \App\Models\OperatorAssignment::STATUS_DENIED]) }}';

            datatable = $('#responsive-table').DataTable({
                paging: true,
                "processing": true,
                "serverSide": true,
                "ajax": "{{ route('operator-assignments.index') }}",
                "order": [[ 1, "desc" ]],
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

                            @if(auth()->user()->hasPermission(\App\Models\OperatorAssignment::PERMISSION_NAME, 'write'))
                                content += '            <li>\n' +
                                '                <a href="'+edit_path.replace('operator_assignment_id', row.id)+'" class="dropdown-item">\n' +
                                '                    <i class="mdi mdi-square-edit-outline"></i> {{__('main.edit')}}' +
                                '                </a>\n' +
                                '            </li>\n' ;
                                content += '            <li>\n' +
                                    '                <form action="' + destroy_path.replace('operator_assignment_id', row.id) + '" method="POST">\n' +
                                    '                @method("DELETE")\n' +
                                    '                @csrf'+
                                    '                <a href="#" class="dropdown-item confirm_delete">\n' +
                                    '                    <i class="mdi mdi-delete-forever"></i> {{__('main.delete')}}' +
                                    '                </a>\n' +
                                    '                </form>' +
                                    '            </li>\n';
                            @endif
                            if(row.can_reveiew){
                                if(row.status == {{\App\Models\OperatorAssignment::STATUS_APPROVED}}){
                                    content += '            <li>\n' +
                                        '                <a  href="'+deny_path.replace('operator_assignment_id', row.id)+'" class="dropdown-item">\n' +
                                        '                    <i class="mdi mdi-cancel"></i> {{__('main.deny')}}' +
                                        '                </a>\n' +
                                        '            </li>\n' ;
                                } else if (row.status == {{\App\Models\OperatorAssignment::STATUS_DENIED}}) {
                                    content += '            <li>\n' +
                                        '                <a  href="'+approve_path.replace('operator_assignment_id', row.id)+'" class="dropdown-item">\n' +
                                        '                    <i class="mdi mdi-check"></i> {{__('main.approve')}}' +
                                        '                </a>\n' +
                                        '            </li>\n' ;
                                } else {
                                    content += '            <li>\n' +
                                        '                <a  href="'+approve_path.replace('operator_assignment_id', row.id)+'" class="dropdown-item">\n' +
                                        '                    <i class="mdi mdi-check"></i> {{__("main.approve")}}' +
                                        '                </a>\n' +
                                        '            </li>\n' ;
                                    content += '            <li>\n' +
                                        '                <a href="'+deny_path.replace('operator_assignment_id', row.id)+'" class="dropdown-item">\n' +
                                            '                    <i class="mdi mdi-cancel"></i> {{__("main.deny")}}' +
                                        '                </a>\n' +
                                        '            </li>\n' ;
                                }
                            }

                            content += '</ul>\n' +
                            '</div>\n' +
                            '</div>';

                            return content;
                        }
                    },
                    { "data": "date" },
                    { "data": "job_file.file_no" },
                    { "data": "travel_agent.name" },
                    { "data": "job_file.client_name" },
                    { "data": "operator_user.name" },
                    { "data": "status" },
                ]
            });
        });
    </script>
@endsection
