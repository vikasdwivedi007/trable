@extends('layouts.main')

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h5>{{__('main.create_new_cash_form')}}</h5>
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
                    <form id="validation-form123" action="{{route('cash-forms.store')}}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>{{__("main.request_date")}}</label>
                                    <input type="text" id="date" class="form-control"
                                           name="date" placeholder="{{__('main.request_date')}}" required>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>{{__("main.additional_service_fees")}}</label>
                                    <input type="text" id="service-Fees" class="form-control autonumber" data-a-sign="EGP "
                                           name="additional_fees" placeholder="{{__('main.additional_service_fees')}}" required>

                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{__("main.additional_service_description")}}</label>
                                    <textarea class="form-control"
                                              name="additional_desc" rows="2"
                                              placeholder="{{__('main.additional_service_description')}}" required></textarea>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <label> {{__('main.file_info')}}
                            <small>({{__('main.data_autofilled_based_on_file')}})
                            </small>
                        </label>

                        <div class="row">

                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>{{__('main.file_no')}}</label>
                                    <select id="filesNoDDL"
                                            class="js-example-tags form-control"
                                            name="job_id" required>
                                        <option value="">{{__('main.file_no')}}</option>
                                        @foreach($job_files as $job_file)
                                            <option value="{{$job_file->id}}"
                                                data-client-name="{{$job_file->client_name}}"
                                                data-pax-count="{{$job_file->adults_count+$job_file->children_count}}"
                                                data-operator="{{$job_file->operator()->user->name}}"
                                                data-guide="{{$job_file->guides->count() ? $job_file->guides[0]->guide->name : ""}}"
                                            >{{$job_file->file_no}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>{{__('main.client_name')}}</label>
                                    <input type="text" id="client_name" class="form-control"
                                           placeholder="{{__('main.client_name')}}" disabled>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>{{__('main.pax_count')}}</label>
                                    <input type="text" id="pax_count" class="form-control"
                                           placeholder="{{__('main.pax_count')}}" disabled>
                                </div>
                            </div>

                        </div>

                        <div class="row">
                            <div class="col-md-2">
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                  <label>{{__('main.operator_name')}}</label>
                                    <input type="text" id="operator_name" class="form-control"
                                           placeholder="{{__('main.operator_name')}}" disabled>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>{{__('main.tour_guide_name')}}</label>
                                    <input type="text" id="guide_name" class="form-control"
                                           placeholder="{{__('main.tour_guide_name')}}" disabled>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="row">

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>{{__('main.representative_name')}}</label>
                                    <select id="repDDL"
                                            class="js-example-tags form-control"
                                            name="emp_id" required>
                                        <option value="">{{__('main.representative_name')}}</option>
                                        @foreach($reps as $rep)
                                            <option value="{{$rep->id}}">{{$rep->user->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <hr>

                        <button type="submit" class="btn btn-primary">{{__('main.create')}}</button>
                        <button type="button" onclick="window.location.href='{{ route('cash-forms.index') }}';" class="btn btn-outline-primary">{{__('main.cancel')}}</button>

                    </form>

                </div>
            </div>

        </div>
    </div>
@endsection

@section('script_bottom')
    <script>
        function loadFileData(files_input){
            let job_id = files_input.val();
            if(job_id){
                let selected_option = files_input.find('option[value="'+job_id+'"]');
                $("#client_name").val(selected_option.attr('data-client-name'));
                $("#pax_count").val(selected_option.attr('data-pax-count'));
                $("#operator_name").val(selected_option.attr('data-operator'));
                $("#guide_name").val(selected_option.attr('data-guide'));
            }else{
                $("#client_name").val('');
                $("#pax_count").val('');
                $("#operator_name").val('');
                $("#guide_name").val('');
            }
        }
        $(function(){
            $('#filesNoDDL').change(function(){
                let files_input = $(this);
                loadFileData(files_input);
            });
        });
    </script>
@endsection
