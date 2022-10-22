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
                    <h5>{{__('main.daily_sheet')}}</h5>
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
                    <label class="text-center">{{__('main.select_week_range')}}</label>
                    <div class="row justify-content-start">
                        <div class="col-3" id="week-picker-wrapper">
                            <div class="form-group">
                                <div class="input-group">
                                    <span class="input-group-btn">
                                        <button type="button" class="btn btn-rm week-prev">
                                            <i class="fas fa-angle-left"></i>
                                        </button>
                                    </span>
                                    <input type="text" class="form-control week-picker" placeholder="{{__('main.select_week')}}">
                                    <span class="input-group-btn">
                                        <button type="button" class="btn btn-rm week-next">
                                            <i class="fas fa-angle-right"></i>
                                        </button>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="col-2">
                            <a class="btn btn-primary mb-4"  onclick="showData();return false;">
                                {{__('main.show_sheet')}}
                            </a>
                        </div>
                        <div class="col-7">
                            <a class="btn btn-primary mb-4 float-right" href="{{route('daily-sheets.create')}}">
                                {{__('main.add_new_sheet')}}
                            </a>
                        </div>

                    </div>

                    <div class="table-responsive">
                        <table id="responsive-table"
                               class="table table-striped table-hover table-bordered nowrap w-100">
                            <thead>
                            <tr>
                                <th width="10%">{{__('main.action')}}</th>
                                <th width="40%">{{__('main.date')}}</th>
                                <th width="50%">{{__('main.city')}}</th>
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
    <script src="{{asset('assets/plugins/bootstrap-datetimepicker/js/bootstrap-datepicker.min.js')}}"></script>
    <script src="{{asset('assets/js/pages/ac-datepicker.js')}}"></script>

    <!-- prism Js -->
    <script src="{{asset('assets/plugins/prism/js/prism.min.js')}}"></script>

    <script>
        var datatable;

        function showData(){
            let range = $('.week-picker').val();
            if(range){
                let query = 'date-range:'+range;
                datatable.search( query ).draw();
            }else{
                datatable.search( '' ).draw();
            }
        }

        $(function () {
            $('.week-picker').val("");

            var edit_path = '{{ route('daily-sheets.edit', ['daily_sheet'=> 'daily_sheet_id']) }}';
            var destroy_path = '{{ route('daily-sheets.destroy', ['daily_sheet'=> 'daily_sheet_id']) }}';
            var view_path = '{{ route('daily-sheets.show', ['daily_sheet'=> 'daily_sheet_id']) }}';
            var print_path = '{{ route('daily-sheets.show', ['daily_sheet'=> 'daily_sheet_id']).'?print=1' }}';

            datatable = $('#responsive-table').DataTable({
                paging: true,
                "processing": true,
                "serverSide": true,
                "ajax": "{{ route('daily-sheets.index') }}",
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

                            @if(auth()->user()->hasPermission(\App\Models\DailySheet::PERMISSION_NAME, 'write'))
                                content += '            <li>\n' +
                                '                <a href="'+edit_path.replace('daily_sheet_id', row.id)+'" class="dropdown-item">\n' +
                                '                    <i class="mdi mdi-square-edit-outline"></i> {{__('main.edit')}}' +
                                '                </a>\n' +
                                '            </li>\n' ;
                                content += '            <li>\n' +
                                    '                <form action="' + destroy_path.replace('daily_sheet_id', row.id) + '" method="POST">\n' +
                                    '                @method("DELETE")\n' +
                                    '                @csrf'+
                                    '                <a href="#" class="dropdown-item confirm_delete">\n' +
                                    '                    <i class="mdi mdi-delete-forever"></i> {{__('main.delete')}}' +
                                    '                </a>\n' +
                                    '                </form>' +
                                    '            </li>\n';
                            @endif
                            content += '            <li>\n' +
                            '                <a target="_blank" href="'+view_path.replace('daily_sheet_id', row.id)+'" class="dropdown-item">\n' +
                            '                    <i class="mdi mdi-eye"></i> {{__('main.view')}}' +
                            '                </a>\n' +
                            '            </li>\n' ;
                            content += '            <li>\n' +
                                '                <a target="_blank" href="'+print_path.replace('daily_sheet_id', row.id)+'" class="dropdown-item">\n' +
                                '                    <i class="mdi mdi-printer"></i> {{__('main.print')}}' +
                                '                </a>\n' +
                                '            </li>\n' ;
                            content += '</ul>\n' +
                            '</div>\n' +
                            '</div>';

                            return content;
                        }
                    },
                    { "data": "date" },
                    { "data": "city.name" },
                ]
            });
        });
    </script>
@endsection
