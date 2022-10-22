@extends('layouts.main')

@section("script_top")
    <style>
        li[aria-disabled='true'] {
            display: none;
        }
    </style>
@endsection

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h5>{{__("main.assign_to_operator")}}</h5>
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
                    <form id="validation-form123" action="#!">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                  <label>{{__("main.date")}}</label>
                                    <input type="text" id="date" class="form-control"
                                           placeholder="{{__("main.date")}}" required value="{{$operatorAssignment->toArray()['date']}}">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                  <label>{{__("main.operator")}}</label>
                                    <select id="emp_id"
                                            class="js-example-tags form-control"
                                            name="emp_id" required>
                                        <option value="">{{__("main.operator")}}</option>
                                        @foreach($operators as $operator)
                                            <option value="{{$operator->id}}" @if($operator->id == $operatorAssignment->emp_id) selected @endif>{{$operator->user->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div id="job_files_container">
                            <div class="job_item">
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                          <label>{{__("main.job_file")}}</label>
                                            <input type="text"  class="form-control FileNo"
                                                   placeholder="{{__("main.job_file")}}" value="{{$operatorAssignment->job_file->file_no}}">
                                            <p class="text-monospace">
                                                {{__("main.enter_job_file_auto")}}
                                            </p>
                                        </div>
                                    </div>
                                    <div class="col-md-2" style="margin-top: 2rem;">
                                        <button type="button" class="btn btn-primary show_data_btn" onclick="loadFileData($(this));return false;" disabled>{{__("main.show_details")}}</button>
                                    </div>
                                </div>
                                <div class="row item_details justify-content-center ">
                                    <div id="fileDetls" class="bg-light col-sm-12 px-2 py-3 py-4 mx-4">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <h4 class="font-weight-bold pb-3 text-uppercase">
                                                    {{__("main.job_file_info")}}
                                                </h4>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group float-right pr-4">
                                                    <a href="#" id="sheetDetalsEdit_updated">
                                                        <i class="mdi mdi-square-edit-outline"></i>
                                                        {{__("main.edit_info")}}
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-3">
                                                <label class="text-info text-uppercase">{{__("main.travel_agent")}}</label>
                                                <div class="form-group">
                                                    <input type="text"
                                                           class="form-control form-control-asLabel travel_agent"
                                                           name="validation-required" value="{{$operatorAssignment->job_file->travel_agent->name}}"
                                                           disabled>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <label class="text-info text-uppercase">{{__("main.client_name")}}</label>
                                                <div class="form-group">
                                                    <input type="text"
                                                           class="form-control form-control-asLabel client_name"
                                                           name="validation-required" value="{{$operatorAssignment->job_file->client_name}}"
                                                           disabled>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <label class="text-info text-uppercase">{{__("main.client_phone")}}</label>
                                                <div class="form-group">
                                                    <input type="text"
                                                           class="form-control form-control-asLabel client_phone"
                                                           name="validation-required" value="{{$operatorAssignment->job_file->client_phone}}"
                                                           disabled>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <label class="text-info text-uppercase">{{__("main.pax_count")}}</label>
                                                <div class="form-group">
                                                    <input type="text"
                                                           class="form-control form-control-asLabel pax"
                                                           name="validation-required" value="{{$operatorAssignment->job_file->children_count + $operatorAssignment->job_file->adults_count}}" disabled>
                                                </div>
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="row">
                                            <div class="col-md-3">
                                                <label class="text-info text-uppercase">{{__("main.router_number")}}</label>
                                                <div  class="form-group changeLabel">
                                                    <input  type="text"
                                                            class="form-control form-control-asLabel router_number"
                                                            name="validation-required" value="{{$operatorAssignment->router_number}}" disabled>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <label class="text-info text-uppercase">{{__("main.flight_number")}}</label>
                                                <div class="form-group">
                                                    <input type="text"
                                                           class="form-control form-control-asLabel flight_number"
                                                           name="validation-required"
                                                           disabled value="{{$operatorAssignment->job_file->arrival_flight}}">
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <label class="text-info text-uppercase">{{__("main.flight_time")}}</label>
                                                <div class="form-group">
                                                    <input type="text"
                                                           class="form-control form-control-asLabel flight_time"
                                                           name="validation-required" value="{{$operatorAssignment->job_file->toArray()['arrival_date']}}"
                                                           disabled>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <label class="text-info text-uppercase">P.N.R</label>
                                                <div class="form-group">
                                                    <input type="text"
                                                           class="form-control form-control-asLabel pnr"
                                                           name="validation-required" value="{{$operatorAssignment->pnr}}" disabled>
                                                </div>
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="row">
                                            <div class="col-md-3">
                                                <label class="text-info text-uppercase">
                                                    {{__("main.tour_guide_name")}}
                                                </label>
                                                <div id="" class="form-group">
                                                    <input id="HotelName" type="text"
                                                           class="form-control form-control-asLabel guide_name"
                                                           name="validation-required" value="{{$operatorAssignment->job_file->guides->count() ? $operatorAssignment->job_file->guides[0]->guide->name : ""}}"
                                                           disabled>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <label class="text-info text-uppercase">
                                                    {{__("main.tour_guide_phone")}}
                                                </label>
                                                <div id="" class="form-group">
                                                    <input id="HotelName" type="text"
                                                           class="form-control form-control-asLabel guide_phone"
                                                           name="validation-required" value="{{$operatorAssignment->job_file->guides->count() ? $operatorAssignment->job_file->guides[0]->guide->phone : ""}}"
                                                           disabled>
                                                </div>
                                            </div>
                                            <div class="col-md-3">

                                                <label class="text-info text-uppercase">
                                                    {{__("main.transfer_man_name")}}
                                                </label>
                                                <div class="form-group">
                                                    <input id="HotelName" type="text"
                                                           class="form-control form-control-asLabel transfer_man_name"
                                                           name="validation-required" value="{{$operatorAssignment->daily_sheet ? $operatorAssignment->daily_sheet->representative->user->name : ""}}"
                                                           disabled>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <label class="text-info text-uppercase">
                                                    {{__("main.transfer_man_phone")}}
                                                </label>
                                                <div class="form-group">
                                                    <input id="HotelName" type="text"
                                                           class="form-control form-control-asLabel transfer_man_phone"
                                                           name="validation-required" value="{{$operatorAssignment->daily_sheet ? $operatorAssignment->daily_sheet->representative->user->phone : ""}}"
                                                           disabled>
                                                </div>
                                            </div>

                                        </div>
                                        <hr>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <label class="text-info text-uppercase">{{__("main.remarks")}}</label>
                                                <div class="form-group changeLabel">
                                                    <textarea rows="6" class="form-control form-control-asLabel remarks" disabled
                                                              placeholder="{{__("main.remarks")}}">{{$operatorAssignment->remarks}}</textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <label class="text-info text-uppercase">{{__("main.itinerary")}}</label>
                                                <div class="form-group changeLabel">
                                                    <textarea rows="6" class="form-control form-control-asLabel itinerary" disabled
                                                              placeholder="{{__("main.itinerary")}}">{{$operatorAssignment->itinerary}}</textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="row justify-content-center">
                                            <div class="col-md-3">

                                                <label class="text-info text-uppercase">
                                                    {{__("main.company_of_transportation")}}
                                                </label>
                                                <div class="form-group">
                                                    <input id="HotelName" type="text"
                                                           class="form-control form-control-asLabel transportation_company"
                                                           name="validation-required" value="{{$operatorAssignment->daily_sheet ? $operatorAssignment->daily_sheet->transportation->name : ""}}" disabled>
                                                </div>

                                            </div>
                                            <div class="col-md-3">

                                                <label class="text-info text-uppercase">
                                                    {{__("main.driver_name")}}
                                                </label>
                                                <div class="form-group">
                                                    <input id="HotelName" type="text"
                                                           class="form-control form-control-asLabel driver_name"
                                                           name="validation-required" value="{{$operatorAssignment->daily_sheet ? $operatorAssignment->daily_sheet->driver_name : ""}}" disabled>
                                                </div>

                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label class="text-info text-uppercase">
                                                        {{__("main.driver_phone")}}
                                                    </label>
                                                    <div class="form-group">
                                                        <input id="HotelName" type="text"
                                                               class="form-control form-control-asLabel driver_phone"
                                                               name="validation-required" value="{{$operatorAssignment->daily_sheet ? $operatorAssignment->daily_sheet->driver_phone : ""}}"
                                                               disabled>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <label class="text-info text-uppercase">
                                                    {{__("main.concierge_service")}}
                                                </label>
                                                <div class="form-group">
                                                    <input id="HotelName" type="text"
                                                           class="form-control form-control-asLabel concierge"
                                                           name="validation-required" @if($operatorAssignment->daily_sheet) value="{{$operatorAssignment->daily_sheet->concierge ? 'Yes' : 'No'}}" @endif disabled>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>


                        <div class="row mt-4">
                            <button type="submit" id="saveData_btn" onclick="saveData('{{route("operator-assignments.update", ['operator_assignment'=>$operatorAssignment->id])}}', 'PATCH');return false;" class="btn btn-primary">{{__("main.update")}}</button>
                            <button class="btn btn-outline-primary" type="button" onclick="window.location.href='{{ route('operator-assignments.index') }}';">{{__("main.cancel")}}</button>
                        </div>
                    </form>

                </div>
            </div>

        </div>
    </div>
@endsection
@section('script_bottom')
    <script src="{{asset('assets/js/operator_assignments.js?ver=1.0')}}"></script>
    <script>
        var search_job_file_route = "{{route('job-files.searchByFileNoAndDate')}}";
    </script>
@endsection
