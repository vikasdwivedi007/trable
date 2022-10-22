@extends('layouts.main')

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h5>{{__("main.create_police_permission")}}</h5>
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
                    <form id="validation-form123" action="{{route('police-permissions.store')}}" method="POST">
                        @csrf
                        <label>{{__("main.enter_job_file_auto")}}</label>
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                  <label>{{__("main.file_no")}} * </label>
                                    <input type="text" id="FileNo" class="form-control"
                                           name="file_no" placeholder="{{__("main.file_no")}} *" required>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>{{__("main.travel_agent")}}</label>
                                    <input type="text" id="Travel-Agent-Name" class="form-control"
                                           placeholder="{{__("main.travel_agent")}}" disabled>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="float-right">أسم شركة السياحة</label>
                                    <input type="text" id="Travel-Agent-NameAr" class="form-control ar_only drtl"
                                           name="travel_agent_ar" required placeholder="رجاء كتابة أسم شركة السياحة بالعربي">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="float-right">العميل قادم من</label>
                                    <input type="text" id="Coming-From" class="form-control ar_only drtl"
                                           name="coming_from_ar" required placeholder="رجاء كتابة العميل قادم من">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>{{__("main.client_name")}}</label>
                                    <input type="text" id="client_name" class="form-control"
                                           placeholder="{{__("main.client_name")}}" disabled>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="float-right">أسم العميل</label>
                                    <input type="text" id="client_name_ar" class="form-control ar_only drtl"
                                           name="client_name_ar" required placeholder="رجاء كتابة أسم العميل بالعربي">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                  <label>{{__("main.nationality_of_group")}}</label>
                                    <input type="text" id="Nationality-Group" class="form-control"
                                           placeholder="{{__("main.nationality_of_group")}}" disabled>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="float-right">جنسية العميل</label>
                                    <input type="text" id="Nationality-GroupAr" class="form-control ar_only drtl"
                                           name="nationality_ar" required placeholder="رجاء كتابة جنسية العميل بالعربي">
                                </div>
                            </div>
                            <div class="col-md-6"></div>
                        </div>
                        <div class="row pl-3">
                            <label>{{__("main.pax_count")}}</label>
                        </div>
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>{{__("main.number_of_adults")}}</label>
                                    <input type="text" id="Num-Adults" class="form-control"
                                           placeholder="{{__("main.number_of_adults")}}" disabled>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>{{__("main.number_of_children")}}</label>
                                    <input type="text" id="Num-Child" class="form-control"
                                           placeholder="{{__("main.number_of_children")}}" disabled>
                                </div>
                            </div>
                            <div class="col-md-6"></div>
                        </div>
                        <hr>
                        <label>{{__("main.flight_info")}}</label>
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
                        <label>{{__("main.tour_info")}}</label>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{__("main.company_of_transportation")}}</label>
                                    <select id="TrnsprtDDL"
                                            class="js-example-tags form-control"
                                            name="transportation_id" required>
                                        <option value="">{{__("main.company_of_transportation")}} *</option>
                                        @foreach($transportations as $transportation)
                                            <option value="{{$transportation->id}}">{{$transportation->name_ar ?: $transportation->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>{{__("main.tour_guide_name")}}</label>
                                    <select id="Guide-Name"
                                            class="js-example-tags form-control"
                                            name="guide_id" required>
                                        <option value="">{{__("main.tour_guide_name")}} *</option>
                                        @foreach($guides as $guide)
                                            <option value="{{$guide->id}}" data-phone="{{$guide->phone}}">{{$guide->name_ar ?: $guide->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>{{__("main.tour_guide_phone")}}</label>
                                    <input type="text" id="Guide-Phone-Number" class="form-control"
                                           name="validation-required" placeholder="{{__("main.tour_guide_phone")}}" disabled>

                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                <label>{{__("main.representative_name")}}</label>
                                    <select id="Trnsprt-Representative-Name"
                                            class="js-example-tags form-control"
                                            name="representative_id" required>
                                        <option value="">{{__("main.representative_name")}} *</option>
                                        @foreach($employees as $employee)
                                            <option value="{{$employee->id}}" data-phone="{{$employee->user->phone}}">{{$employee->user->name_ar ?: $employee->user->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                  <label>{{__("main.representative_phone")}}</label>
                                    <input type="text" id="Trnsprt-Representative-Mobile" class="form-control"
                                           name="validation-required" placeholder="{{__("main.representative_phone")}}" disabled>
                                </div>
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>{{__("main.driver_name")}}</label>
                                    <select id="Trnsprt-Driver-Name"
                                            class="js-example-tags form-control"
                                            name="driver_id" required disabled>
                                        <option value="">{{__("main.driver_name")}} *</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>{{__("main.driver_phone")}}</label>
                                    <input type="text" id="Trnsprt-Driver-Mobile" class="form-control"
                                           name="validation-required" placeholder="{{__("main.driver_phone")}}" disabled>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="row form-group">
                                    <div class="col-md-3 align-self-center">
                                        <label for="">{{__("main.car_plate_no")}}</label>
                                    </div>
                                    <div class="col-md-3">
                                        <label class="float-right">أرقام</label>
                                        <input type="text" class="form-control Trnsprt-Car-Plate-No"
                                               name="car_no_seg[0]" maxlength="4" required>
                                    </div>
                                    <div class="col-md-2">
                                        <label class="float-right">حرف</label>
                                        <input type="text" class="form-control Trnsprt-Car-Plate-No"
                                               name="car_no_seg[1]" maxlength="1" required>
                                    </div>
                                    <div class="col-md-2">
                                        <label class="float-right">حرف</label>
                                        <input type="text"  class="form-control Trnsprt-Car-Plate-No "
                                               name="car_no_seg[2]" maxlength="1" required>
                                    </div>
                                    <div class="col-md-2">
                                        <label class="float-right">حرف</label>
                                        <input type="text"  class="form-control Trnsprt-Car-Plate-No"
                                               name="car_no_seg[3]" maxlength="1" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <label>{{__("main.traffic_line")}}</label>
                        <div id="trafficLineAdded">
                            <div class="traffic-item">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">{{__("main.date")}}</label>
                                            <input type="text" class="form-control traffic_line_date"
                                                   name="traffic_lines[0][date]" placeholder="{{__("main.date")}}" required>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group float-right">
                                            <a href="#" onclick="addNewTrafficLineUpdated();return false;">+ {{__("main.add_new_traffic_line")}}</a>
                                            <br>
                                            <a class="remove-item" style="display: none;" href="#" onclick="$(this).closest('.traffic-item').remove();return false;">- {{__("main.remove")}}</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">{{__("main.traffic_line_details")}}</label>
                                            <textarea class="form-control" rows="6"
                                                      name="traffic_lines[0][details]" placeholder="{{__("main.traffic_line_details")}}" required></textarea>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>

                        <button type="submit" id="save-btn" class="btn btn-primary" disabled>{{__("main.create")}}</button>
                        <button type="button" onclick="window.location.href='{{ route('police-permissions.index')}}';" class="btn btn-outline-primary">{{__("main.cancel")}}</button>
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
                        $("#Travel-Agent-NameAr").val("");
                        $("#Coming-From").val("");
                        $("#Nationality-GroupAr").val("");
                        $("#client_name_ar").val("");
                        $("#client_name").val(job_file.client_name);
                        $("#airport_to").val(job_file.airport_to_formatted.text_ar ? job_file.airport_to_formatted.text_ar : job_file.airport_to_formatted.text);
                        $("#airport_from").val(job_file.airport_from_formatted.text_ar ? job_file.airport_from_formatted.text_ar : job_file.airport_from_formatted.text);
                        $("#date-ArrivalOn").val(job_file.arrival_date);
                        $("#date-DepartureOn").val(job_file.departure_date);
                        $("#Nationality-Group").val(job_file.country.name);
                        $("#Travel-Agent-Name").val(job_file.travel_agent.name);
                        $("#Num-Adults").val(job_file.adults_count);
                        $("#Num-Child").val(job_file.children_count);
                        $("#save-btn").removeAttr('disabled');
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
            $("#Nationality-Group").val("");
            $("#Travel-Agent-Name").val("");
            $("#Num-Adults").val("");
            $("#Num-Child").val("");
            $("#Travel-Agent-NameAr").val("");
            $("#Coming-From").val("");
            $("#Nationality-GroupAr").val("");
            $("#client_name_ar").val("");
            $("#save-btn").attr('disabled', 'disabled');
        }

        function resetGuideFields(){
            $("#Guide-Name").val("");
            $('#Guide-Phone-Number').val("");
        }

        function resetEmpFields(){
            $("#Trnsprt-Representative-Name").val("");
            $('#Trnsprt-Representative-Mobile').val("");
        }

        function resetCarFields(){
            $('.Trnsprt-Car-Plate-No').val("")
            $("#Trnsprt-Driver-Name option[value!='']").remove();
            $("#Trnsprt-Driver-Name").attr('disabled', 'disabled');
            $("#Trnsprt-Driver-Name").select2();
            $("#Trnsprt-Driver-Mobile").val("");
        }

        function searchCarsByCompany(transportation_id){
            $.post('{{route("searchCarsByCompany")}}', {'transportation_id':transportation_id})
                .done(function(data){
                    if(data.cars){
                        for(var i=0;i<data.cars.length;i++){
                            var car = data.cars[i];
                            $("#Trnsprt-Driver-Name").append('<option value="'+car.id+'" data-phone="'+car.driver_phone+'">'+(car.driver_name_ar ? car.driver_name_ar : car.driver_name)+'</option>');
                        }
                        $("#Trnsprt-Driver-Name").select2();
                        $("#Trnsprt-Driver-Name").removeAttr('disabled');
                    }
                })
                .fail(function(err){

                });
        }

        var current_item = 1;
        function addNewTrafficLineUpdated(){
            var existing_item = $('.traffic-item').first();
            var new_item = existing_item.clone();
            current_item++;
            new_item.find('.remove-item').css('display', 'block');
            new_item.find('input[type="hidden"]').remove();
            new_item.find('input,textarea').val("");
            new_item.find('input,textarea').each(function () {
                var input_name = $(this).attr("name");
                if (input_name && input_name.indexOf('][') > -1) {
                    input_name = input_name.replace('[' + (input_name.charAt(input_name.indexOf('][') - 1)) + ']', '[' + (current_item - 1) + ']');
                    $(this).attr('name', input_name);
                }
            });
            $("#trafficLineAdded").append(new_item);
            new_item.find('.traffic_line_date').bootstrapMaterialDatePicker({
                weekStart: 0,
                format: 'dddd DD MMMM YYYY HH:mm',
                shortTime : true,
                time: true
            });
        }

        $(function () {
            $("#Guide-Name").val("").trigger('change');
            $("#TrnsprtDDL").val("").trigger('change');
            resetGuideFields();
            resetEmpFields();
            resetCarFields();

            $('.traffic_line_date').bootstrapMaterialDatePicker({
                weekStart: 0,
                format: 'dddd DD MMMM YYYY HH:mm',
                shortTime : true,
                time: true
            });

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

            $("#Guide-Name").change(function(){
                var guide_id = $(this).val().trim();
                if(guide_id){
                    var guide_input = $(this).find('option[value="'+guide_id+'"]');
                    $('#Guide-Phone-Number').val(guide_input.attr('data-phone'));
                }else{
                    resetGuideFields();
                }
            });

            $("#Trnsprt-Representative-Name").change(function(){
                var emp_id = $(this).val().trim();
                if(emp_id){
                    var emp_input = $(this).find('option[value="'+emp_id+'"]');
                    $('#Trnsprt-Representative-Mobile').val(emp_input.attr('data-phone'));
                }else{
                    resetEmpFields();
                }
            });

            $("#TrnsprtDDL").change(function(){
                var comp_id = $(this).val().trim();
                resetCarFields();
                if(comp_id){
                    searchCarsByCompany(comp_id);
                }else{
                    // resetCarFields();
                }
            });

            $(document).on("change", "#Trnsprt-Driver-Name", function (e) {
                var driver_id = $(this).val().trim();
                if(driver_id){
                    var driver_input = $(this).find('option[value="'+driver_id+'"]');
                    $("#Trnsprt-Driver-Mobile").val(driver_input.attr('data-phone'));
                }else{
                    $("#Trnsprt-Driver-Mobile").val("");
                }
            });

        });
    </script>
@endsection
