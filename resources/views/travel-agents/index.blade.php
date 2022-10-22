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
                    <h5>{{__("main.travel_agents")}}</h5>
                    <div class="card-header-right">
                        <div class="btn-group card-option">
                            <button type="button" class="btn dropdown-toggle btn-icon" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="feather icon-more-horizontal"></i>
                            </button>
                            <ul class="list-unstyled card-option dropdown-menu dropdown-menu-right">
                                <li class="dropdown-item full-card"><a href="#!"><span><i class="feather icon-maximize"></i> maximize</span><span style="display:none"><i class="feather icon-minimize"></i> Restore</span></a></li>
                                <li class="dropdown-item minimize-card"><a href="#!"><span><i class="feather icon-minus"></i> collapse</span><span style="display:none"><i class="feather icon-plus"></i> expand</span></a></li>
                                <li class="dropdown-item reload-card"><a href="#!"><i class="feather icon-refresh-cw"></i> reload</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="card-block">
                    @if(auth()->user()->hasPermission(\App\Models\TravelAgent::PERMISSION_NAME, 'write'))
                    <a id="crt-Nw-Tra-Agn" href="{{ route('travel-agents.create') }}" class="btn btn-primary mb-4">
                        {{__("main.create_travel_agent")}}
                    </a>
                    @endif

                    <div class="table-responsive">
                        <table id="fixed-columns-left" class="table table-striped table-hover table-bordered nowrap w-100">
                            <thead>
                            <tr>
                                <th>{{__("main.action")}}</th>
                                <th>{{__("main.name")}}</th>
                                <th>{{__("main.country")}}</th>
                                <th>{{__("main.city")}}</th>
                                <th>{{__("main.address")}}</th>
                                <th>{{__("main.phone")}}</th>
                                <th>{{__("main.email")}}</th>
                                <th>{{__("main.rate_amount")}}</th>
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
            var edit_path = '{{ route('travel-agents.edit', ['travel_agent'=> 'travel_agent_id']) }}';
            var destroy_path = '{{ route('travel-agents.destroy', ['travel_agent'=> 'travel_agent_id']) }}';

            $('#fixed-columns-left').DataTable({
                paging: true,
                "processing": true,
                "serverSide": true,
                "ajax": "{{ route('travel-agents.index') }}",
                "columns": [
                    {
                        "data": null,
                        "render": function(data, type, row){
                            @if(!auth()->user()->hasPermission(\App\Models\TravelAgent::PERMISSION_NAME, 'write'))
                                return '';
                                @endif
                            var content = '<div class="dropdown text-center">\n' +
                                '    <a href="#" class="dropdown-toggle" data-toggle="dropdown">\n' +
                                '        <i class=\'feather icon-more-vertical\'></i>\n' +
                                '    </a>\n' +
                                '    <div class="dropdown-menu dropdown-menu-left profile-notification">\n' +
                                '        <ul class="pro-body">\n' +
                                '            <li>\n' +
                                '                <a href="'+edit_path.replace('travel_agent_id', row.id)+'" class="dropdown-item">\n' +
                                '                    <i class="mdi mdi-square-edit-outline"></i> {{__("main.edit")}}' +
                                '                </a>\n' +
                                '            </li>\n' ;
                            if(row.can_be_deleted){
                                content += '            <li>\n' +
                                '                <form action="'+destroy_path.replace('travel_agent_id', row.id)+'" method="POST">\n' +
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
                    { "data": "name" },
                    { "data": "country.name" },
                    { "data": "city.name" },
                    { "data": "address" },
                    { "data": "phone" },
                    { "data": "email" },
                    { "data": "rate_amount" },
                ]
            });
        });
    </script>
@endsection
