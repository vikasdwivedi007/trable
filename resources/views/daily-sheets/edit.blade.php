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
                    <h5>{{__('main.update_daily_sheet')}}</h5>
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
                                  <label>{{__('main.select_date')}} </label>*
                                    <input type="text" id="date" class="form-control"
                                            placeholder="{{__('main.select_date')}}" value="{{$dailySheet->toArray()['date']}}" required>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>{{__('main.city')}} </label>
                                    <select id="city_id"
                                            class="js-example-tags form-control"
                                            name="city_id" required>
                                        <option value="">{{__('main.city')}}</option>
                                        @foreach($cities as $city)
                                            <option value="{{$city->id}}" @if($dailySheet->city_id == $city->id) selected @endif>{{$city->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div id="job_files_container">
                            @foreach($dailySheet->job_files as $sheet_file)
                            <div class="job_item">
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>{{__('main.job_file')}} </label>
                                            <input type="text"  class="form-control FileNo"
                                                   placeholder="{{__('main.job_file')}}" value="{{$sheet_file->job_file->file_no}}">
                                            <p class="text-monospace">
                                                {{__('main.enter_job_file_auto')}}
                                            </p>
                                        </div>
                                    </div>
                                    <div class="col-md-2" style="margin-top: 2rem;">
                                        <button type="button" class="btn btn-primary show_data_btn" onclick="loadFileData($(this));return false;" disabled>{{__('main.show_details')}}</button>
                                    </div>
                                    <div class="col-md-2 remove_item @if($loop->first) d-none @endif">
                                        <button type="button" class="btn btn-danger" onclick="$(this).closest('.job_item').remove();return false;">{{__('main.remove_item')}}</button>
                                    </div>
                                </div>
                                <div class="row item_details justify-content-center ">
                                    <div id="fileDetls" class="bg-light col-sm-12 px-2 py-3 py-4 mx-4">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <h4 class="font-weight-bold pb-3 text-uppercase">
                                                    {{__('main.job_file_info')}}
                                                </h4>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group float-right pr-4">
                                                    <a href="#" id="sheetDetalsEdit_updated">
                                                        <i class="mdi mdi-square-edit-outline"></i>
                                                        {{__('main.edit_info')}}
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-3">
                                                <label class="text-info text-uppercase">{{__('main.travel_agent')}}</label>
                                                <div class="form-group">
                                                    <input type="text"
                                                           class="form-control form-control-asLabel travel_agent"
                                                           name="validation-required" value="{{$sheet_file->job_file->travel_agent->name}}"
                                                           disabled>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <label class="text-info text-uppercase">{{__('main.client_name')}}</label>
                                                <div class="form-group">
                                                    <input type="text"
                                                           class="form-control form-control-asLabel client_name"
                                                           name="validation-required" value="{{$sheet_file->job_file->client_name}}"
                                                           disabled>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <label class="text-info text-uppercase">{{__('main.client_phone')}}</label>
                                                <div class="form-group">
                                                    <input type="text"
                                                           class="form-control form-control-asLabel client_phone"
                                                           name="validation-required" value="{{$sheet_file->job_file->client_phone}}"
                                                           disabled>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <label class="text-info text-uppercase">{{__('main.pax_count')}}</label>
                                                <div class="form-group">
                                                    <input type="text"
                                                           class="form-control form-control-asLabel pax"
                                                           name="validation-required" value="{{$sheet_file->job_file->adults_count + $sheet_file->job_file->children_count}}" disabled>
                                                </div>
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="row">
                                            <div class="col-md-3">
                                                <label class="text-info text-uppercase">{{__('main.router_number')}}</label>
                                                <div  class="form-group changeLabel">
                                                    <input  type="text"
                                                           class="form-control form-control-asLabel router_number"
                                                           name="validation-required" value="{{$sheet_file->router_number}}" disabled>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <label class="text-info text-uppercase">{{__('main.flight_number')}}</label>
                                                <div class="form-group">
                                                    <input type="text"
                                                           class="form-control form-control-asLabel flight_number"
                                                           name="validation-required" value="{{$sheet_file->job_file->arrival_flight}}"
                                                           disabled>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <label class="text-info text-uppercase">F{{__('main.flight_time')}}</label>
                                                <div class="form-group">
                                                    <input type="text"
                                                           class="form-control form-control-asLabel flight_time"
                                                           name="validation-required" value="{{$sheet_file->job_file->toArray()['arrival_date']}}"
                                                           disabled>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <label class="text-info text-uppercase">P.N.R</label>
                                                <div class="form-group">
                                                    <input type="text"
                                                           class="form-control pnr"
                                                           name="validation-required" value="{{$sheet_file->pnr}}">
                                                </div>
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="row">
                                            <div class="col-md-3">
                                                <label class="text-info text-uppercase">
                                                    {{__('main.hotel_name')}}
                                                </label>
                                                <div id="" class="form-group">
                                                    <input type="text"
                                                           class="form-control form-control-asLabel hotel_name"
                                                           name="validation-required" value="{{$sheet_file->job_file->accommodations->count() ? $sheet_file->job_file->accommodations[0]->hotel->name : ""}}"
                                                           disabled>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <label class="text-info text-uppercase">
                                                    {{__('main.tour_guide_name')}}
                                                </label>
                                                <div id="" class="form-group">
                                                    <input type="text"
                                                           class="form-control form-control-asLabel guide_name"
                                                           name="validation-required" value="{{$sheet_file->job_file->guides->count() ? $sheet_file->job_file->guides[0]->guide->name : ""}}"
                                                           disabled>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <label class="text-info text-uppercase">
                                                    {{__('main.tour_guide_phone')}}
                                                </label>
                                                <div id="" class="form-group">
                                                    <input type="text"
                                                           class="form-control form-control-asLabel guide_phone"
                                                           name="validation-required" {{$sheet_file->job_file->guides->count() ? $sheet_file->job_file->guides[0]->guide->phone : ""}}
                                                           disabled>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <label class="text-info text-uppercase">
                                                    {{__('main.concierge_service')}}
                                                </label>
                                                <div class="form-group">

                                                    <div class="checkbox checkbox-fill d-inline mr-4">
                                                        <input type="checkbox"
                                                               id="checkbox-fill-Service-Conciergerie"
                                                               name="service_conciergerie" class="concierge" @if($sheet_file->job_file->service_conciergerie) checked @endif>
                                                        <label for="checkbox-fill-Service-Conciergerie"
                                                               class="cr">Service Conciergerie</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <label class="text-info text-uppercase">{{__('main.remarks')}}</label>
                                                <div class="form-group changeLabel">
                                                    <textarea rows="6" class="form-control form-control-asLabel remarks" disabled
                                                              placeholder="Remarks">{{$sheet_file->remarks}}</textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <label class="text-info text-uppercase">{{__('main.itinerary')}}</label>
                                                <div class="form-group changeLabel">
                                                    <textarea rows="6" class="form-control form-control-asLabel itinerary" disabled
                                                              placeholder="Itinerary">{{$sheet_file->itinerary}}</textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="row justify-content-center">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                  <label>{{__('main.company_of_transportation')}}</label>
                                                    <select
                                                            class="js-example-tags form-control transportation_id"
                                                            name="validation-select">
                                                        <option value="">{{__('main.company_of_transportation')}} *
                                                        </option>
                                                        @foreach($transportations as $transportation)
                                                            <option @if($sheet_file->transportation_id == $transportation->id) selected @endif value="{{$transportation->id}}">{{$transportation->name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                  <label>{{__('main.driver_name')}}</label>
                                                    <select
                                                            class="js-example-tags form-control driver_id"
                                                            name="validation-select" >
                                                        <option value="">{{__('main.driver_name')}}
                                                        </option>
                                                        @foreach($transportations as $transportation)
                                                            <option value="x13dg" data-name="{{$sheet_file->driver_name}}"  data-phone="{{$sheet_file->driver_phone}}"  selected>{{$sheet_file->driver_name}}</option>
                                                            @foreach($transportation->cars as $car)
                                                                <option value="{{$car->id}}" data-name="{{$car->driver_name}}"  data-transportation-id="{{$transportation->id}}" data-phone="{{$car->driver_phone}}" disabled>{{$car->driver_name}}</option>
                                                            @endforeach
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                  <label>{{__('main.driver_phone')}}</label>
                                                    <input type="text"  class="form-control driver_phone"
                                                           name="validation-required"
                                                           placeholder="{{__('main.driver_phone')}}" disabled value="{{$sheet_file->driver_phone}}">
                                                </div>
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="row justify-content-center">

                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>{{__('main.transfer_man_name')}}</label>
                                                    <select
                                                            class="js-example-tags form-control representative_id"
                                                            name="validation-select">
                                                        <option value="">{{__('main.transfer_man_name')}}
                                                        </option>
                                                        @foreach($reps as $rep)
                                                            <option @if($sheet_file->representative_id == $rep->id) selected @endif value="{{$rep->id}}" data-phone="{{$rep->user->phone}}">{{$rep->user->name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                  <label>{{__('main.transfer_man_phone')}}</label>
                                                    <input type="text" class="form-control representative_phone"
                                                           name="validation-required"
                                                           placeholder="{{__('main.transfer_man_phone')}}" disabled value="{{$sheet_file->representative->user->phone}}">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mt-4">
                                        <div class="col-md-12">
                                            <div class="form-group float-right pr-4">
                                                <a class="btn btn-primary" onclick="addNewJobItem()">
                                                    + {{__('main.add_new_job_file')}}
                                                </a>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            @endforeach
                        </div>


                        <button type="submit" id="saveData_btn" onclick="saveData('{{route("daily-sheets.update", ['daily_sheet'=>$dailySheet->id])}}', 'PATCH');return false;" class="btn btn-primary">{{__('main.update')}}</button>
                        <button class="btn btn-outline-primary" type="button" onclick="window.location.href='{{ route('daily-sheets.index') }}';">{{__('main.cancel')}}</button>
                    </form>

                </div>
            </div>

        </div>
    </div>
@endsection
@section('script_bottom')
    <script src="{{asset('assets/js/daily_sheets.js?ver=1.0')}}"></script>
    <script>
        var search_job_file_route = "{{route('job-files.searchByFileNoAndDate')}}";
        var current_item = {{$dailySheet->job_files->count() + 1}};
    </script>
@endsection
