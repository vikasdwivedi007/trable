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
                    <h5>{{__("main.payment_monthly_requests")}}</h5>
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
                    <a href="{{route('payment-monthly-requests.create')}}"  class="btn btn-primary mb-4">
                        {{__("main.create_payment_request")}}
                    </a>

                    <div class="table-responsive">
                        <table id="responsive-table" class="table table-striped table-hover table-bordered nowrap w-100">
                            <thead>
                            <tr>
                                <th>{{__("main.action")}}</th>
                                <th>{{__("main.month")}}</th>
                                <th>{{__("main.request_date")}}</th>
                                <th>{{__("main.number_of_files")}}</th>
                                <th>{{__("main.amount")}}</th>
                                <th>{{__("main.total_amount")}}</th>
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
            var view_path = '{{ route('payment-monthly-requests.show', ['payment_monthly_request'=> 'payment_monthly_request_id']) }}';
            var print_path = '{{ route('payment-monthly-requests.show', ['payment_monthly_request'=> 'payment_monthly_request_id']). '?print=1' }}';
            var edit_path = '{{ route('payment-monthly-requests.edit', ['payment_monthly_request'=> 'payment_monthly_request_id']) }}';
            var destroy_path = '{{ route('payment-monthly-requests.destroy', ['payment_monthly_request'=> 'payment_monthly_request_id']) }}';

            $('#responsive-table').DataTable({
                paging: true,
                "processing": true,
                "serverSide": true,
                "ajax": "{{ route('payment-monthly-requests.index') }}",
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
                                '                <a target="_blank" href="'+view_path.replace('payment_monthly_request_id', row.id)+'" class="dropdown-item">\n' +
                                '                    <i class="mdi mdi-eye"></i> {{__("main.view")}}' +
                                '                </a>\n' +
                                '            </li>\n'+
                                '            <li>\n' +
                                '                <a target="_blank" href="'+print_path.replace('payment_monthly_request_id', row.id)+'" class="dropdown-item">\n' +
                                '                    <i class="mdi mdi-printer"></i> {{__("main.print")}}' +
                                '                </a>\n' +
                                '            </li>\n';
                            @if(auth()->user()->hasPermission(\App\Models\PaymentMonthlyRequest::PERMISSION_NAME, 'write'))
                                content +='            <li>\n' +
                                '                <a href="'+edit_path.replace('payment_monthly_request_id', row.id)+'" class="dropdown-item">\n' +
                                '                    <i class="mdi mdi-square-edit-outline"></i> {{__("main.edit")}}' +
                                '                </a>\n' +
                                '            </li>\n' +
                                '            <li>\n' +
                                '                <form action="'+destroy_path.replace('payment_monthly_request_id', row.id)+'" method="POST">\n' +
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
                    { "data": "month" },
                    { "data": "request_date" },
                    { "data": "files_count" },
                    { "data": "amount" },
                    { "data": "total" },

                ]
            });
        });
    </script>
@endsection
