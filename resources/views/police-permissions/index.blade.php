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
                    <h5>{{__("main.police_permissions")}}</h5>
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
                    <a href="{{route('police-permissions.create')}}"  class="btn btn-primary mb-4">
                        {{__("main.create_police_permission")}}
                    </a>

                    <div class="table-responsive">
                        <table id="responsive-table" class="table table-striped table-hover table-bordered nowrap w-100">
                            <thead>
                            <tr>
                                <th>{{__("main.action")}}</th>
                                <th>{{__("main.travel_agent")}}</th>
                                <th>{{__("main.file_no")}}</th>
                                <th>{{__("main.client_name")}}</th>
                                <th>{{__("main.arrival_date")}}</th>
                                <th>{{__("main.departure_date")}}</th>
                                <th>{{__("main.transportation_co")}}</th>
                                <th>{{__("main.driver_name")}}</th>
                                <th>{{__("main.tour_guide_name")}}</th>
                                <th>{{__("main.representative_name")}}</th>
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
        $(function () {
            var view_path = '{{ route('police-permissions.show', ['police_permission'=> 'police_permission_id']) }}';
            var print_path = '{{ route('police-permissions.show', ['police_permission'=> 'police_permission_id']). '?print=1' }}';
            var edit_path = '{{ route('police-permissions.edit', ['police_permission'=> 'police_permission_id']) }}';
            var destroy_path = '{{ route('police-permissions.destroy', ['police_permission'=> 'police_permission_id']) }}';

            $('#responsive-table').DataTable({
                paging: true,
                "processing": true,
                "serverSide": true,
                "ajax": "{{ route('police-permissions.index') }}",
                "columns": [
                    {
                        "targets": -1,
                        "data": null,
                        "render": function(data, type, row){
                            var content = '<div class="dropdown text-center">\n' +
                                '    <a href="#" class="dropdown-toggle" data-toggle="dropdown">\n' +
                                '        <i class=\'feather icon-more-vertical\'></i>\n' +
                                '    </a>\n' +
                                '    <div class="dropdown-menu dropdown-menu-left profile-notification">\n' +
                                '        <ul class="pro-body">\n';
                            content += '            <li>\n' +
                                '                <a target="_blank" href="'+view_path.replace('police_permission_id', row.id)+'" class="dropdown-item">\n' +
                                '                    <i class="mdi mdi-eye"></i> {{__("main.view")}}' +
                                '                </a>\n' +
                                '            </li>\n'+
                                '            <li>\n' +
                                '                <a target="_blank" href="'+print_path.replace('police_permission_id', row.id)+'" class="dropdown-item">\n' +
                                '                    <i class="mdi mdi-printer"></i> {{__("main.print")}}' +
                                '                </a>\n' +
                                '            </li>\n';
                            @if(auth()->user()->hasPermission(\App\Models\PolicePermission::PERMISSION_NAME, 'write'))
                                content +='            <li>\n' +
                                '                <a href="'+edit_path.replace('police_permission_id', row.id)+'" class="dropdown-item">\n' +
                                '                    <i class="mdi mdi-square-edit-outline"></i> {{__("main.edit")}}' +
                                '                </a>\n' +
                                '            </li>\n' +
                                '            <li>\n' +
                                '                <form action="'+destroy_path.replace('police_permission_id', row.id)+'" method="POST">\n' +
                                '                @method("DELETE")\n' +
                                '                @csrf'+
                                '                <a href="#" class="dropdown-item confirm_delete">\n' +
                                '                    <i class="mdi mdi-delete-forever"></i> {{__("main.delete")}}' +
                                '                </a>\n' +
                                '                </form>' +
                                '            </li>\n';
                            @endif
                                content += '</ul>\n' +
                                '</div>\n' +
                                '</div>'

                            return content;
                        }
                    },
                    { "data": "travel_agent.name" },
                    { "data": "job_file.file_no" },
                    { "data": "job_file.client_name" },
                    { "data": "job_file.arrival_date" },
                    { "data": "job_file.departure_date" },
                    { "data": "transportation.name" },
                    { "data": "car.driver_name" },
                    { "data": "guide.name" },
                    { "data": "representative_user.name" },

                ]
            });
        });
    </script>
@endsection
