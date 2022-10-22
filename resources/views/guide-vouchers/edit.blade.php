@extends('layouts.main')

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h5>{{__('main.update_guide_voucher')}}</h5>
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
                    <form id="validation-form123" action="{{route('guide-vouchers.update', ['guide_voucher'=>$voucher->id])}}" method="POST">
                        @method('PATCH')
                        @csrf
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                   <label>{{__('main.file_no')}}</label>
                                    <input type="text" id="FileNo" class="form-control"
                                           name="file_no" placeholder="{{__('main.file_no')}} *" value="{{$voucher->job_file->file_no}}" required>
                                </div>
                            </div>
                            <div class="col-md-5">
                                <div class="form-group">
                                   <label>{{__('main.issued_by')}}</label>
                                    <input type="text" id="IssuedBy" class="form-control"
                                           name="issued_by" placeholder="{{__('main.issued_by')}} *" value="{{$voucher->issued_by}}" required>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <label>Guide Information</label>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label value="">{{__('main.tour_guide_name')}} *</label>
                                    <select id="Guide-Name"
                                            class="js-example-tags form-control"
                                            name="guide_id" required>
                                        <option value="">{{__('main.tour_guide_name')}} *</option>
                                        @foreach($guides as $guide)
                                            <option value="{{$guide->id}}" data-langs="{{$guide->languages_str}}" data-phone="{{$guide->phone}}" @if($guide->id == $voucher->guide_id) selected @endif>{{$guide->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-5">
                                <div class="form-group">
                                   <label>{{__('main.guide_address')}}</label>
                                    <input type="text" id="Guide-Address" class="form-control"
                                           placeholder="{{__('main.guide_address')}}" name="guide_address" value="{{$voucher->guide_address}}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                   <label>{{__('main.guide_language')}}</label>
                                    <input type="text" id="Guide-Language" class="form-control"
                                           placeholder="{{__('main.guide_language')}}" disabled value="{{$voucher->guide->languages_str}}">
                                </div>
                            </div>
                            <div class="col-md-5">
                                <div class="form-group">
                                   <label>{{__('main.tour_guide_phone')}}</label>
                                    <input type="text" id="Guide-Phone-Number" class="form-control"
                                           placeholder="{{__('main.tour_guide_phone')}}" disabled value="{{$voucher->guide->phone}}">
                                </div>
                            </div>
                        </div>
                        <hr>
                        <label>{{__('main.guest_information')}}</label>
                        <div class="row">

                            <div class="col-md-4">
                                <div class="form-group">
                                   <label>{{__('main.client_name')}}</label>
                                    <input type="text" id="Client-Name" class="form-control"
                                           placeholder="{{__('main.client_name')}}" disabled>
                                </div>
                            </div>
                            <div class="col-md-5">
                                <div class="form-group">
                                   <label>{{__('main.client_language')}}</label>
                                    <input type="text" id="Client-Language" class="form-control"
                                           placeholder="{{__('main.client_language')}}" disabled>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>{{__('main.city')}} *</label>
                                    <select id="City"
                                            class="js-example-tags form-control"
                                            name="city_id" required>
                                        <option value="">{{__('main.city')}} *</option>
                                        @foreach($cities as $city)
                                            <option value="{{$city->id}}" @if($city->id == $voucher->hotel->city_id) selected @endif>{{$city->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-5">
                                <div class="form-group">
                                    <label>{{__('main.hotel')}} *</label>
                                    <select id="Hotel-Name"
                                            class="js-example-tags form-control"
                                            name="hotel_id" required>
                                        <option value="">{{__('main.hotel')}} *</option>
                                        <option value="{{$voucher->hotel_id}}" selected>{{$voucher->hotel->name}}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                   <label>{{__('main.client_phone')}}</label>
                                    <input type="text" id="Client-Room-Number" class="form-control"
                                           name="room_no" placeholder="{{__('main.client_phone')}}" value="{{$voucher->room_no}}">
                                </div>
                            </div>
                        </div>
                        <hr>
                        <label>{{__('main.transportation_tour_operator_info')}}</label>
                        <div class="row">
                            <div class="col-md-5">
                                <div class="form-group">
                                   <label>{{__('main.transportation_by')}}</label>
                                    <input type="text" id="Transportation-By" class="form-control" placeholder="{{__('main.transportation_by')}}" name="transport_by" value="{{$voucher->transport_by}}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                   <label>{{__('main.pax_count')}}</label>
                                    <input type="number" min="0" id="Number-of-PAX" class="form-control"
                                           placeholder="{{__('main.pax_count')}} *" name="pax_no" required value="{{$voucher->pax_no}}">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-5">
                                <div class="form-group">
                                   <label>{{__('main.tour_operator')}}</label>
                                    <input type="text" id="Tour-Operator" class="form-control"
                                           placeholder="{{__('main.tour_operator')}} *" name="tour_operator" required value="{{$voucher->tour_operator}}">
                                </div>
                            </div>
                        </div>
                        <hr>
                        <label>{{__('main.tour_information')}}</label>
                        <div id="tour-wrapper">
                            @foreach($voucher->tours as $tour)
                            <div class="tour-item">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                           <label>{{__('main.tour_date')}}</label>
                                            <input name="tours[{{$loop->index}}][date]" type="text" id="Tour-Date" class="Tour-Date form-control" placeholder="{{__('main.tour_date')}} *" value="{{$tour->toArray()['date']}}" required>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <a href="#" onclick="addTourItem();return false;">+ {{__('main.add_new_item')}}</a>
                                        <br>
                                        <a class="remove-item" @if($loop->first) style="display: none;" @endif href="#" onclick="$(this).closest('.tour-item').remove();return false;">- {{__('main.remove_item')}}</a>
                                    </div>
                                </div>
                                <label>{{__('main.tour_description')}} *</label>
                                <div class="row">
                                    <div class="col-md-6 mb-4">
                                        <div class="form-group">
                                            <textarea  name="tours[{{$loop->index}}][desc]" class="form-control" rows="6" required >{{$tour->desc}}</textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>

                        <hr>
                        <label>{{__('main.enter_issue_date_guide_service_acceptance')}}</label>
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                   <label>{{__('main.date_of_issue')}}</label>
                                    <input name="issue_date" type="text" id="Date-of-Issue" class="form-control" placeholder="{{__('main.date_of_issue')}} *" required value="{{$voucher->toArray()['issue_date']}}">
                                </div>
                            </div>
                        </div>


                        <button id="save-voucher" type="submit" class="btn btn-primary">{{__('main.update')}}</button>
                        <button class="btn btn-outline-primary" type="button" onclick="window.location.href='{{ route('vouchers.index').'#pills-Guide-tab' }}';" >{{__('main.cancel')}}</button>

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
                        $("#Client-Language").val(job_file.language.language);
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
            $("#Client-Language").val("");
            $("#save-voucher").attr('disabled', 'disabled');
        }

        function resetGuideFields(){
            $("#Guide-Name").val("");
            $('#Guide-Language').val("");
            $('#Guide-Phone-Number').val("");
        }

        function resetHotelFields(){
            $("#Hotel-Name").attr('disabled', 'disblaed');
            $("#Client-Room-Number").attr('disabled', 'disabled');
            $("#Hotel-Name").val('').trigger('change');
            $("#Client-Room-Number").val('');
        }

        function searchHotelByCity(city_id){
            $.post('/hotels/search-by-city', {'city_id':city_id})
                .done(function(data){
                    var hotels_input = $("#Hotel-Name");
                    hotels_input.find('option[value!=""]').remove();
                    for(var i=0;i<data.hotels.length;i++){
                        var hotel = data.hotels[i];
                        hotels_input.append('<option value="'+hotel.id+'">'+hotel.name+'</option>');
                    }
                    hotels_input.removeAttr('disabled');
                    $("#Client-Room-Number").removeAttr('disabled');
                })
                .fail(function(err){

                });
        }

        var current_item = {{$voucher->tours->count() + 1}};
        function addTourItem(){
            var existing_item = $('.tour-item').first();
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
            $("#tour-wrapper").append(new_item);
            new_item.find('.Tour-Date').bootstrapMaterialDatePicker({
                weekStart: 0,
                format: 'dddd DD MMMM YYYY HH:mm',
                time: true
            });
        }

        $(function () {
            $('.Tour-Date').bootstrapMaterialDatePicker({
                weekStart: 0,
                format: 'dddd DD MMMM YYYY HH:mm',
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
                    $('#Guide-Language').val(guide_input.attr('data-langs'));
                    $('#Guide-Phone-Number').val(guide_input.attr('data-phone'));
                }else{
                    resetGuideFields();
                }
            });

            $("#City").change(function(){
                var city_id = $(this).val().trim();
                if(city_id){
                    searchHotelByCity(city_id);
                }else{
                    resetHotelFields();
                }
            });

        });
    </script>
@endsection
