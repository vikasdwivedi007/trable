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
                    <h5>{{__('main.list_of_invoices')}}</h5>
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
                    <div class="table-responsive">
                        <table id="responsive-table" class="table table-striped table-hover table-bordered nowrap w-100">
                            <thead>
                            <tr>
                                <th>{{__('main.serial_no')}}</th>
                                <th>{{__('main.total')}}</th>
                                <th>{{__('main.travel_agent')}}</th>
                                <th>{{__('main.file_no')}}</th>
                                <th>{{__('main.client_name')}}</th>
                                <th>{{__('main.arrival_date')}}</th>
                                <th>{{__('main.departure_date')}}</th>
                                <th>{{__('main.pax_count')}}</th>
                                <th>{{__('main.command_no')}}</th>
                                <th>{{__('main.invoice_no')}}</th>
                                <th>{{__('main.operator')}}</th>
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

            $('#responsive-table').DataTable({
                dom: 'Bfrtip',
                pageLength: {{$total_count}},
                buttons: [
                    'excelHtml5',
                    'pdfHtml5',
                    'print'
                ],
                paging: true,
                "processing": true,
                "serverSide": true,
                "order": [[ 0, "desc" ]],
                "ajax": "{{ route('invoices.index') }}",
                "columns": [
                    { "data": "serial_no" },
                    { "data": "total" },
                    { "data": "travel_agent.name" },
                    { "data": "job_file.file_no" },
                    { "data": "job_file.client_name" },
                    { "data": "job_file.arrival_date" },
                    { "data": "job_file.departure_date" },
                    { "data": "pax", "orderable":false },
                    { "data": "job_file.command_no" },
                    { "data": "number" },
                    { "data": "operator_name", "orderable": false },
                ]
            });
        });
    </script>
@endsection
