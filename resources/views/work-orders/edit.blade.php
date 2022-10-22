@extends('layouts.main')

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h5> {{__("main.update_work_order")}}</h5>
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
                    <form id="validation-form123" action="{{route('work-orders.update', ['work_order'=>$workOrder->id])}}" method="POST">
                        @method('PATCH')
                        @csrf
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>{{__("main.request_date")}}</label> 
                                    <input type="text" id="date" class="form-control"
                                           name="date" placeholder="{{__("main.request_date")}}" value="{{$workOrder->toArray()['date']}}" required>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>{{__("main.representative_name")}}</label> 
                                    <select id="emp_id"
                                            class="js-example-tags form-control"
                                            name="emp_id" required>
                                        <option value="">{{__("main.representative_name")}}</option>
                                        @foreach($reps as $rep)
                                            <option value="{{$rep->id}}" data-phone="{{$rep->user->phone}}" @if($workOrder->emp_id == $rep->id) selected @endif>{{$rep->user->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>{{__("main.representative_phone")}}</label> 
                                    <input type="text" id="emp_phone"
                                           class="form-control" name="validation-required"
                                           placeholder="{{__("main.representative_phone")}}" disabled>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <label> {{__("main.file_info")}}
                            <small>({{__("main.data_autofilled_based_on_file")}})
                            </small>
                        </label>

                        <div class="row">

                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>{{__("main.file_no")}}</label> 
                                    <select id="job_id"
                                            class="js-example-tags form-control"
                                            name="job_id" required>
                                        <option value="">{{__("main.file_no")}}</option>
                                        @foreach($job_files as $job_file)
                                            <option value="{{$job_file->id}}" data-client-name="{{$job_file->client_name}}" data-country="{{$job_file->country->name}}" data-adults-count="{{$job_file->adults_count}}" data-children-count="{{$job_file->children_count}}" data-arrival-flight="{{$job_file->arrival_flight}}" data-arrival-date="{{$job_file->toArray()['arrival_date']}}" data-arrival-at="{{$job_file->airport_to_formatted['text']}}" @if($job_file->id == $workOrder->job_id) selected @endif>{{$job_file->file_no}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>{{__("main.client_name")}}</label> 
                                    <input type="text" id="client_name" class="form-control"
                                           name="validation-required" placeholder="{{__("main.client_name")}}" disabled>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>{{__("main.country")}}</label> 
                                    <input type="text"  class="form-control country"
                                           name="validation-required" placeholder="{{__("main.country")}}" disabled>
                                </div>

                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2 align-self-center ">
                                <h5 class="font-weight-bold">
                                    {{__("main.pax_count")}}
                                </h5>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>{{__("main.adult")}}</label> 
                                    <input type="text" id="adults_count" class="form-control"
                                           name="validation-required" placeholder="{{__("main.adult")}}" disabled>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>{{__("main.child")}}</label> 
                                    <input type="text" id="children_count" class="form-control"
                                           name="validation-required" placeholder="{{__("main.child")}}" disabled>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <label> {{__("main.flight_info")}}
                            <small>({{__("main.data_autofilled_based_on_file")}})
                            </small>
                        </label>

                        <div class="row">

                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>{{__("main.flight_number")}}</label> 
                                    <input type="text" id="arrival_flight" class="form-control"
                                           name="validation-required" placeholder="{{__("main.flight_number")}}" disabled>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                <label>{{__("main.arrival_date")}}</label> 
                                    <input type="text" id="arrival_date" class="form-control"
                                           name="validation-required" placeholder="{{__("main.arrival_date")}}" disabled>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>{{__("main.arrival_at")}}</label> 
                                    <input type="text"  class="form-control country"
                                           name="validation-required" placeholder="{{__("main.arrival_at")}}" disabled>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>{{__("main.departure_at")}}</label> 
                                    <input type="text" id="arrival_airport" class="form-control"
                                           name="validation-required" placeholder="{{__("main.departure_at")}}" disabled>
                                </div>
                            </div>

                        </div>

                        <button type="submit" id="submit_btn" class="btn btn-primary" disabled>{{__("main.update")}}</button>
                        <button type="button" class="btn btn-outline-primary" onclick="window.location.href='{{route('work-orders.index')}}';">{{__("main.cancel")}}</button>
                    </form>

                </div>
            </div>

        </div>
    </div>
@endsection
@section('script_bottom')
    <script>
        function loadRepData(emp_id_input){
            let emp_id = emp_id_input.val();
            let submit_btn = $("#submit_btn");
            submit_btn.attr('disabled', 'disabled');
            if(emp_id){
                let selected_option = emp_id_input.find('option[value="'+emp_id+'"]');
                let emp_phone = selected_option.attr('data-phone');
                $("#emp_phone").val(emp_phone);
                submit_btn.removeAttr('disabled');
            }else{
                $("#emp_phone").val('');
            }
        }

        function loadFileData(job_id_input){
            let job_id = job_id_input.val();
            let submit_btn = $("#submit_btn");
            submit_btn.attr('disabled', 'disabled');
            if(job_id){
                let selected_option = job_id_input.find('option[value="'+job_id+'"]');
                $("#client_name").val(selected_option.attr('data-client-name'));
                $(".country").val(selected_option.attr('data-country'));
                $("#adults_count").val(selected_option.attr('data-adults-count'));
                $("#children_count").val(selected_option.attr('data-children-count'));
                $("#arrival_flight").val(selected_option.attr('data-arrival-flight'));
                $("#arrival_date").val(selected_option.attr('data-arrival-date'));
                $("#arrival_airport").val(selected_option.attr('data-arrival-at'));
                submit_btn.removeAttr('disabled');
            }else{
                $("#client_name").val("");
                $(".country").val("");
                $("#adults_count").val("");
                $("#children_count").val("");
                $("#arrival_flight").val("");
                $("#arrival_date").val("");
                $("#arrival_airport").val("");
            }
        }
        $(function(){
            loadRepData($("#emp_id"));
            loadFileData($("#job_id"));

            $("#emp_id").change(function(){
                let emp_id_input = $(this);
                loadRepData(emp_id_input);
            });

            $("#job_id").change(function(){
                let job_id_input = $(this);
                loadFileData(job_id_input);
            });
        });
    </script>
@endsection
