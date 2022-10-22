@extends('layouts.main')

@section('script_top_before_base')
    <!-- prism css -->
    <link rel="stylesheet" href="{{asset('assets/plugins/prism/css/prism.min.css')}}">
    <!-- data tables css -->
    <link rel="stylesheet" href="{{asset('assets/plugins/data-tables/css/datatables.min.css')}}">
@endsection

@section('content')
    <!-- [ Main Content ] start -->
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h5>{{__('main.employees')}}</h5>
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
                    @if(auth()->user()->hasPermission(\App\Models\Employee::PERMISSION_NAME, 'write'))
                    <a href="{{ route('employees.create') }}" id="crt-Nw-emp" type="submit" class="btn btn-primary mb-4">
                        {{__('main.create_new_employee')}}
                    </a>
                    @endif

                    <div class="table-responsive">
                        <table id="responsive-table" class="table table-striped table-hover table-bordered nowrap w-100">
                            <thead>
                            <tr>
                                <th>{{__('main.action')}}</th>
                                <th>{{__('main.name')}}</th>
                                <th>{{__('main.email')}}</th>
                                <th>{{__('main.phone')}}</th>
                                <th>{{__('main.job_title')}}</th>
                                <th>{{__('main.date_of_hiring')}}</th>
                                <th>{{__('main.date_of_promotion')}}</th>
                                <th>{{__('main.yearly_points')}}</th>
                                <th>{{__('main.spoken_language')}}</th>
                                <th>{{__('main.department')}}</th>
                                <th>{{__('main.supervisor')}}</th>
                                <th>{{__('main.address')}}</th>
                            </tr>
                            </thead>

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
        $(function () {
            var edit_path = '{{ route('employees.edit', ['employee'=> 'emp_id']) }}';
            var activate_path = '{{ route('employees.activate', ['employee'=> 'emp_id']) }}';
            var deactivate_path = '{{ route('employees.deactivate', ['employee'=> 'emp_id']) }}';

            $('#responsive-table').DataTable({
                paging: true,
                "processing": true,
                "serverSide": true,
                "ajax": "{{ route('employees.index') }}",
                "columns": [
                    {
                        "targets": -1,
                        "data": null,
                        "render": function(data, type, row){
                            @if(!auth()->user()->hasPermission(\App\Models\Employee::PERMISSION_NAME, 'write'))
                                return '';
                                @endif
                            var content = '<div class="dropdown text-center">\n' +
                                '    <a href="#" class="dropdown-toggle" data-toggle="dropdown">\n' +
                                '        <i class=\'feather icon-more-vertical\'></i>\n' +
                                '    </a>\n' +
                                '    <div class="dropdown-menu dropdown-menu-left profile-notification">\n' +
                                '        <ul class="pro-body">\n' +
                                '            <li>\n' +
                                '                <a href="'+edit_path.replace('emp_id', row.id)+'" class="dropdown-item">\n' +
                                '                    <i class="mdi mdi-account-edit"></i> {{__("main.edit")}}' +
                                '                </a>\n' +
                                '            </li>\n' ;
                            if(!row.active){
                                content += '<li>\n' +
                                    '<a href="'+activate_path.replace('emp_id', row.id)+'" class="dropdown-item">\n' +
                                    '<i class="mdi mdi-account"></i> {{__("main.activate")}}' +
                                    '</a>\n' +
                                    '</li>\n' ;
                            }else{
                                content += '<li>\n' +
                                    '<a href="'+deactivate_path.replace('emp_id', row.id)+'" class="dropdown-item">\n' +
                                    '<i class="mdi mdi-account-outline"></i> {{__("main.deactivate")}}' +
                                    '</a>\n' +
                                    '</li>\n' ;
                            }
                            content += '</ul>\n' +
                                '</div>\n' +
                                '</div>'

                            return content;
                        }
                    },
                    { "data": "user.name" },
                    { "data": "user.email" },
                    { "data": "user.phone" },
                    { "data": "job.title" },
                    { "data": "hired_at" },
                    { "data": "promoted_at" },
                    { "data": "outsource" },
                    { "data": "languages_str", "defaultContent":"", "orderable": false },
                    { "data": "department.name", "defaultContent":"" },
                    { "data": "supervisor.title",  "defaultContent":"", "orderable":false },
                    { "data": "user.address" },
                ]
            });
        });
    </script>
@endsection
