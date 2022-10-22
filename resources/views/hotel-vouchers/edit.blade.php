@extends('layouts.main')

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h5>{{__('main.update_hotel_voucher')}}</h5>
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
                    <form id="validation-form123" action="{{route('hotel-vouchers.update', ['hotel_voucher'=>$voucher->id])}}" method="POST">
                        @method('PATCH')
                        @csrf
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>{{__("main.file_no")}}</label>
                                    <input type="text" id="FileNo" class="form-control"
                                           name="file_no"  placeholder="{{__('main.file_no')}}" required value="{{$voucher->job_file->file_no}}">
                                </div>
                            </div>
                            <div class="col-md-5">
                                <div class="form-group">
                                    <label>{{__("main.issued_by")}}</label>
                                    <input type="text" id="IssuedBy" class="form-control"
                                           name="issued_by" placeholder="{{__('main.issued_by')}}" value="{{$voucher->issued_by}}" required>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <label>{{__('main.guest_information')}}</label>
                        <div class="row">
                            <div class="col-md-3 pt-2" >
                                <div class="form-group">
                                    <div class="radio radio-primary d-inline">
                                        <input type="radio" name="res_type" id="radio-Hotel" value="2" @if($voucher->hotel_id) checked @endif>
                                        <label for="radio-Hotel" class="cr">{{__('main.hotel')}}</label>
                                    </div>

                                    <select id="To-Hotel-Ship"
                                            class="js-example-tags form-control"
                                            name="hotel_id" required>
                                        <option value="">{{__('main.hotel')}}</option>
                                        @foreach($hotels as $hotel)
                                            <option value="{{$hotel->id}}" @if($voucher->hotel_id == $hotel->id) selected @endif>{{$hotel->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3 pt-2">
                                <div class="form-group">
                                    <div class="radio radio-primary d-inline">
                                        <input type="radio" name="res_type" id="radio-Cruise" value="1" @if($voucher->cruise_id) checked @endif>
                                        <label for="radio-Cruise" class="cr">{{__('main.cruise')}}</label>
                                    </div>

                                    <select id="To-Cruise-Ship"
                                            class="js-example-tags form-control"
                                            name="cruise_id" disabled required>
                                        <option value="">{{__('main.cruise')}}</option>
                                        @foreach($cruises as $cruise)
                                            <option value="{{$cruise->id}}" @if($voucher->cruise_id == $cruise->id) selected @endif>{{$cruise->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3" >
                                <div class="form-group">
                                    <label>{{__("main.number_of_guests")}}</label>
                                    <input type="text" id="Num-Guests" class="form-control" placeholder="{{__('main.number_of_guests')}}" disabled>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>{{__("main.client_name")}}</label>
                                    <input type="text" id="Client-Name" class="form-control"
                                           placeholder="{{__('main.client_name')}}" disabled>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <label>{{__('main.residence_information')}}</label>
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>{{__("main.arrival_date")}}</label>
                                    <input type="text" id="Arrival-Date" class="form-control" placeholder="{{__('main.arrival_date')}}" name="arrival_date" required value="{{$voucher->toArray()['arrival_date']}}">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>{{__("main.departure_date")}}</label>
                                    <input type="text" id="Departure-Date" class="form-control"
                                           placeholder="{{__('main.departure_date')}}" name="departure_date" value="{{$voucher->toArray()['departure_date']}}" required>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>{{__("main.number_of_nights")}}</label>
                                    <input type="text" id="Num-Nights" class="form-control"
                                           placeholder="{{__('main.number_of_nights')}}" disabled>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <label>Room Types</label>
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                  <label>{{__("main.number_of_single_rooms")}}</label>
                                    <input type="text" name="single_rooms_count"  id="No-Single-Rooms" class="form-control" placeholder="{{__('main.number_of_single_rooms')}}" value="{{$voucher->single_rooms_count}}">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>{{__("main.number_of_double_rooms")}}</label>
                                    <input type="text"  name="double_rooms_count" id="No-Double-Rooms" class="form-control" placeholder="{{__('main.number_of_double_rooms')}}" value="{{$voucher->double_rooms_count}}">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>{{__("main.number_of_triple_rooms")}}</label>
                                    <input type="text"  name="triple_rooms_count" id="No-Triple-Rooms" class="form-control" placeholder="{{__('main.number_of_triple_rooms')}}" value="{{$voucher->triple_rooms_count}}">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>{{__("main.number_of_suite_rooms")}}</label>
                                    <input type="text"  name="suite_rooms_count" id="No-Suite-Rooms" class="form-control" placeholder="{{__('main.number_of_suite_rooms')}}"  value="{{$voucher->suite_rooms_count}}">
                                </div>
                            </div>
                        </div>
                        <hr>
                        <label>{{__('main.served_meals_date_types')}}</label>
                        <div id="daysAdded" >
                            @foreach($voucher->meals as $meal)
                            <div class="day_item row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>{{__("main.date")}}</label>
                                        <input type="text" data-day-num="{{$loop->index+1}}" class="Day-Date form-control" name="meals[{{$loop->index+1}}][date]" placeholder="{{__('main.date')}}" required value="{{$meal->toArray()['date']}}">
                                    </div>
                                </div>
                                <div class="col-md-7" style="margin-top: 2rem;">
                                    <div class="form-group">
                                        <div class="checkbox checkbox-fill d-inline">
                                            <input type="hidden" name="meals[{{$loop->index+1}}][american_breakfast]" value="0">
                                            <input type="checkbox" name="meals[{{$loop->index+1}}][american_breakfast]"
                                                   id="checkbox-fill-American-Breakfast-1" value="1" @if($meal->american_breakfast) checked @endif>
                                            <label for="checkbox-fill-American-Breakfast-1"
                                                   class="cr">{{__('main.american_breakfast')}}</label>
                                        </div>
                                        <div class="checkbox checkbox-fill d-inline">
                                            <input type="hidden" name="meals[{{$loop->index+1}}][continental_breakfast]" value="0">
                                            <input type="checkbox" name="meals[{{$loop->index+1}}][continental_breakfast]"
                                                   id="checkbox-fill-Continental-Breakfast-1" value="1" @if($meal->continental_breakfast) checked @endif>
                                            <label for="checkbox-fill-Continental-Breakfast-1"
                                                   class="cr">{{__('main.continental_breakfast')}}</label>
                                        </div>
                                        <div class="checkbox checkbox-fill d-inline">
                                            <input type="hidden" name="meals[{{$loop->index+1}}][lunch]" value="0">
                                            <input type="checkbox" name="meals[{{$loop->index+1}}][lunch]"
                                                   id="checkbox-fill-Lunch-1" value="1" @if($meal->lunch) checked @endif>
                                            <label for="checkbox-fill-Lunch-1"
                                                   class="cr">{{__('main.lunch')}}</label>
                                        </div>
                                        <div class="checkbox checkbox-fill d-inline">
                                            <input type="hidden" name="meals[{{$loop->index+1}}][dinner]" value="0">
                                            <input type="checkbox" name="meals[{{$loop->index+1}}][dinner]"
                                                   id="checkbox-fill-Dinner-1" value="1" @if($meal->dinner) checked @endif>
                                            <label for="checkbox-fill-Dinner-1"
                                                   class="cr">{{__('main.dinner')}}</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-2" style="margin-top: 2rem;"> 
                                    <div class="form-group @if($loop->first) d-inline @else d-none @endif add_day">
                                        <button type="button" onclick="addMealDay();return false;" class="btn btn-success">{{__('main.add_new_day')}}</button>
                                    </div>
                                    <div class="form-group @if(!$loop->first) d-inline @else d-none @endif remove_day" >
                                        <button type="button" onclick="$(this).closest('.day_item').remove();return false;" class="btn btn-danger">{{__('main.remove_day')}}</button>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        <hr>
                        <label>{{__('main.remarks')}}</label>
                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <div class="form-group">
                                    <textarea class="form-control" name="remarks" rows="6">{{$voucher->remarks}}</textarea>
                                </div>
                            </div>
                        </div>


                        <button id="save-voucher" type="submit" class="btn btn-primary">{{__('main.update')}}</button>
                        <button class="btn btn-outline-primary" type="button" onclick="window.location.href='{{ route('vouchers.index').'#pills-Hotel-tab' }}';" >{{__('main.cancel')}}</button>
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
                        $("#Client-Name").val(job_file.client_name);
                        $("#Num-Guests").val(job_file.adults_count+job_file.children_count);
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
            $("#Client-Name").val("");
            $("#Num-Guests").val("");
            $("#save-voucher").attr('disabled', 'disabled');
        }

        function addMealDay(){
            var current_item = $('.day_item').length;
            if(current_item >= 7){
                return false;
            }
            var existing_item = $('.day_item').first();
            var new_item = existing_item.clone();
            current_item++;
            var existing_day_num = existing_item.find('.Day-Date').attr('data-day-num');
            new_item.find('.add_day').removeClass('d-inline').addClass('d-none');
            new_item.find('.remove_day').removeClass('d-none').addClass('d-inline');
            new_item.find('input[type="text"]').val("");
            var day_input = new_item.find('.Day-Date');
            day_input.attr('name',  day_input.attr('name').replace('['+(existing_day_num)+']', '['+(current_item)+']') );
            day_input.attr('data-day-num', current_item);
            new_item.find('.checkbox').each(function(){
                var checkbox_input = $(this).find('input[type="checkbox"]');
                var hidden_input = $(this).find('input[type="hidden"]');
                var checkbox_label = $(this).find('label');
                checkbox_input.prop('checked', false);
                checkbox_input.attr('name', checkbox_input.attr('name').replace('['+existing_day_num+']', '['+current_item+']'));
                hidden_input.attr('name', hidden_input.attr('name').replace('['+existing_day_num+']', '['+current_item+']'));
                checkbox_input.attr('id', checkbox_input.attr('id').replace('-'+existing_day_num, '-'+current_item));
                checkbox_label.attr('for', checkbox_label.attr('for').replace('-'+existing_day_num, '-'+current_item));
            });

            $("#daysAdded").append(new_item);
            new_item.find('.Day-Date').bootstrapMaterialDatePicker({
                weekStart: 0,
                format: 'dddd DD MMMM YYYY',
                time: false
            });
        }

        function calculateNights(){
            if($('#Arrival-Date').val().trim() && $('#Departure-Date').val().trim()){
                var arrival_date = new Date($('#Arrival-Date').val());
                var departure_date = new Date($('#Departure-Date').val());
                if(departure_date <= +arrival_date){
                    $('#Departure-Date').val("");
                    $("#Num-Nights").val(0);
                }else{
                    var diffTime = Math.abs(departure_date - arrival_date);
                    var diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
                    $("#Num-Nights").val(diffDays);
                }
            }
        }

        $(function () {

            $('#radio-Hotel').click(function () {
                $('#To-Hotel-Ship').removeAttr("disabled");
                $('#To-Cruise-Ship').attr("disabled", "disabled");
            });

            $('#radio-Cruise').click(function () {
                $('#To-Hotel-Ship').attr("disabled", "disabled");
                $('#To-Cruise-Ship').removeAttr("disabled");
            });

            if($('#radio-Hotel').is(":checked")){
                $('#To-Hotel-Ship').removeAttr("disabled");
                $('#To-Cruise-Ship').attr("disabled", "disabled");
            }

            if($('#radio-Cruise').is(":checked")){
                $('#To-Hotel-Ship').attr("disabled", "disabled");
                $('#To-Cruise-Ship').removeAttr("disabled");
            }

            $('#Arrival-Date, #Departure-Date, .Day-Date').bootstrapMaterialDatePicker({
                weekStart: 0,
                format: 'dddd DD MMMM YYYY',
                time: false
            });

            calculateNights();
            $('#Arrival-Date, #Departure-Date').change(function(){
                if($('#Arrival-Date').val().trim()){
                    $('#Departure-Date').bootstrapMaterialDatePicker('setMinDate', $('#Arrival-Date').val());
                }
                calculateNights();
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

        });
    </script>
@endsection
