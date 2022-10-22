@extends('layouts.main')

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h5>{{__("main.create_restaurant_voucher")}}</h5>
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
                    <form id="validation-form123" action="{{route('restaurant-vouchers.store')}}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                  <label>{{__("main.file_no")}}</label>  
                                  <input type="text" id="FileNo" class="form-control"
                                           name="file_no" placeholder="{{__("main.file_no")}}" required>
                                </div>
                            </div>
                            <div class="col-md-5">
                                <div class="form-group">
                                  <label>{{__("main.issued_by")}}</label>  
                                  <input type="text" id="IssuedBy" class="form-control"
                                           name="issued_by" placeholder="{{__("main.issued_by")}}" value="{{auth()->user()->name}}" required>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <label>Guest Information</label>
                        <div class="row">
                            <div class="col-md-5">
                                <div class="form-group">
                                  <label>{{__("main.to")}}</label>  
                                  <input type="text" id="to" class="form-control"
                                           name="to" placeholder="{{__("main.to")}}" required>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                  <label>{{__("main.client_name")}}</label>  
                                  <input type="text" id="client_name" class="form-control"
                                           name="validation-required" placeholder="{{__("main.client_name")}}" required disabled>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <label>Arrival & Departure Information</label>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                  <label>{{__("main.arrival_date")}}</label>  
                                  <input type="text" id="date-ArrivalOn" class="form-control"
                                           name="validation-required" placeholder="{{__("main.arrival_date")}}" disabled>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                  <label>{{__("main.arrival_at")}}</label>  
                                  <input type="text" id="airport_to" class="form-control"
                                           name="validation-required" placeholder="{{__("main.arrival_at")}}" disabled>

                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                  <label>{{__("main.departure_date")}}</label>  
                                  <input type="text" id="date-DepartureOn"
                                           class="form-control" name="validation-required"
                                           placeholder="{{__("main.departure_date")}}" disabled>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                  <label>{{__("main.departure_at")}}</label>  
                                  <input type="text" id="airport_from"
                                           class="form-control" name="validation-required"
                                           placeholder="{{__("main.departure_at")}}" disabled>
                                </div>
                            </div>

                        </div>
                        <hr>
                        <label>{{__("main.holder_with_service_below")}}</label>
                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <div class="form-group">
                                    <textarea class="form-control" name="details" rows="6" required></textarea>
                                </div>
                            </div>
                        </div>


                        <button id="save-voucher" type="submit" class="btn btn-primary" disabled>{{__("main.create")}}</button>
                        <button type="button" onclick="window.location.href='{{ route('vouchers.index').'#pills-Restaurant-tab' }}';" class="btn btn-outline-primary">{{__("main.cancel")}}</button>
                    </form>

                </div>
            </div>

        </div>
    </div>
@endsection

@section('script_bottom')
    <script>
        function delay(callback, ms) {
            var timer = 0;
            return function () {
                var context = this, args = arguments;
                clearTimeout(timer);
                timer = setTimeout(function () {
                    callback.apply(context, args);
                }, ms || 0);
            };
        }

        function searchJobFile(file_no){
            $.post('{{route('job-files.searchByFileNo')}}', {'file_no': file_no})
                .done(function (data) {
                    if(data.job_file){
                        var job_file = data.job_file;
                        $("#client_name").val(job_file.client_name);
                        $("#airport_to").val(job_file.airport_to_formatted.text);
                        $("#airport_from").val(job_file.airport_from_formatted.text);
                        $("#date-ArrivalOn").val(job_file.arrival_date);
                        $("#date-DepartureOn").val(job_file.departure_date);
                        $("#save-voucher").removeAttr('disabled');
                    }else{
                        resetFields();
                    }
                })
                .fail(function(err){
                    resetFields();
                });
        }

        function resetFields(){
            $("#client_name").val("");
            $("#airport_to").val("");
            $("#airport_from").val("");
            $("#date-ArrivalOn").val("");
            $("#date-DepartureOn").val("");
            $("#save-voucher").attr('disabled', 'disabled');
        }

        $(function () {
            if($("#FileNo").val().trim()){
                searchJobFile($("#FileNo").val().trim());
            }else{
                resetFields();
            }

            $(document).on("keyup", "#FileNo", delay(function (e) {
                var file_no_input = $(this);
                var file_no = file_no_input.val().trim();
                if(file_no){
                    searchJobFile(file_no);
                }else{
                    resetFields();
                }
            }));

        });
    </script>
@endsection
