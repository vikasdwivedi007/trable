@extends('layouts.main')

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h5> {{__('main.create_new_employee')}}</h5>
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
                    <form id="validation-form123" action="{{ route('employees.store') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>{{__('main.name')}}</label>
                                    <input type="text" id="EmployeeName" class="form-control  @error('name') is-invalid @enderror"
                                           name="name" placeholder="{{__('main.name')}}" required value="{{old('name')}}">
                                    @error('name')
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>{{__('main.name_ar')}}</label>
                                    <input type="text" id="EmployeeNameAr" class="form-control ar_only @error('name_ar') is-invalid @enderror"
                                           name="name_ar" placeholder="{{__('main.name_ar')}}" required value="{{old('name_ar')}}">
                                    @error('name_ar')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{__('main.spoken_language')}}</label>
                                    <select id="LanguageDDL" class="js-example-basic-multiple"
                                            multiple="multiple" name="languages[]" required >
                                        @foreach($languages as $language)
                                            <option value="{{$language->id}}" @if(is_array(old('languages')) && in_array($language->id, old('languages')))selected @endif>{{$language->language}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{__('main.phone')}}</label>
                                    <input type="text" class="form-control mob_no @error('phone') is-invalid @enderror"
                                           name="phone" placeholder="{{__('main.phone')}}" required value="{{old('phone')}}">
                                    @error('phone')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{__('main.email')}}</label>
                                    <input type="text" class="form-control @error('email') is-invalid @enderror"
                                           name="email" placeholder="{{__('main.email')}}" required value="{{old('email')}}">
                                    @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{__('main.address')}}</label>
                                    <input type="text" class="form-control @error('address') is-invalid @enderror"
                                           name="address" placeholder="{{__('main.address')}}" required value="{{old('address')}}">
                                    @error('address')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{__('main.city')}}</label>
                                    <select id="CityDDL"
                                            class="js-example-tags form-control"
                                            name="city_id"  required >
                                        <option value="">{{__('main.city')}}</option>
                                        @foreach($cities as $city)
                                            <option value="{{$city->id}}" @if($city->id == old('city_id')) selected @endif>{{$city->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{__('main.department')}}</label>
                                    <select id="departmentsDDL"
                                            class="js-example-tags form-control"
                                            name="department_id"  required>
                                        <option value="">{{__('main.department')}}</option>
                                        @foreach($departments as $department)
                                            <option value="{{$department->id}}" @if($department->id == old('department_id')) selected @endif>{{$department->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div id="CustodianName"></div>
                                <div id="hid-shw" class="form-group">
                                    <label>{{__('main.job_title')}}</label>
                                    <select id="jobTitleDDL"
                                            class="js-example-tags form-control"
                                            name="job_id"  required >
                                        <option value="">{{__('main.job_title')}}</option>
                                        <option value="-1">
                                            {{__('main.add_new')}}
                                        </option>
                                        @foreach($job_titles as $job_title)
                                        <option value="{{$job_title->id}}" @if($job_title->id == old('job_id')) selected @endif>{{$job_title->title}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{__('main.supervisor_job_title')}}</label>
                                    <select id="supervisorJobTitleDDL"
                                            class="js-example-tags form-control"
                                            name="supervisor_id" >
                                        <option value="">{{__('main.supervisor_job_title')}}</option>
                                        @foreach($available_supervisors as $job_title)
                                            <option value="{{$job_title->id}}" @if($job_title->id == old('supervisor_id')) selected @endif>{{$job_title->title}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{__('main.date_of_hiring')}}</label>
                                    <input type="text" id="date-Hiring" class="form-control @error('hired_at') is-invalid @enderror"
                                           name="hired_at" placeholder="{{__('main.date_of_hiring')}}" value="{{old('hired_at')}}">
                                    @error('hired_at')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{__('main.date_of_promotion')}}</label>
                                    <input type="text" id="date-Promotion" class="form-control @error('promoted_at') is-invalid @enderror"
                                           name="promoted_at" placeholder="{{__('main.date_of_promotion')}}" value="{{old('promoted_at')}}">
                                    @error('promoted_at')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{__('main.salary')}}</label>
                                    <input type="text" class="form-control autonumber @error('salary') is-invalid @enderror"
                                           name="salary" data-a-sign="EGP "
                                           placeholder="{{__('main.salary')}}"  required  value="{{old('salary')}}">
                                    @error('salary')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{__('main.points')}}</label>
                                    <input type="text" class="form-control autonumber @error('points') is-invalid @enderror"
                                           name="points" placeholder="{{__('main.points')}}" value="{{old('points')}}">
                                    @error('points')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">

                            </div>
                            <div class="col-md-6">
                                <fieldset class="form-group ">

                                    <div class="form-group d-inline">
                                        {{__('main.gender')}}:
                                    </div>
                                    <div class="form-group d-inline">

                                        <div class="radio radio-primary d-inline">
                                            <input type="radio" name="gender" id="radio-p-Male" @if(!old('gender'))checked=""@endif  value="0">
                                            <label for="radio-p-Male" class="cr">{{__('main.male')}}</label>
                                        </div>
                                    </div>
                                    <div class="form-group d-inline">
                                        <div class="radio radio-primary d-inline">
                                            <input type="radio" name="gender" id="radio-p-Female" @if(old('gender') == 1)checked=""@endif value="1">
                                            <label for="radio-p-Female" class="cr">{{__('main.female')}}</label>
                                        </div>
                                    </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group d-inline">
                                    {{__('main.outsourcing')}}:
                                </div>
                                <div class="form-group d-inline">

                                    <div class="radio radio-primary d-inline">
                                        <input type="radio" name="outsource" id="radio-p-fill-5" value="1" @if(old('outsource') == 1)checked=""@endif>
                                        <label for="radio-p-fill-5" class="cr">{{__('main.yes')}}:</label>
                                    </div>
                                </div>
                                <div class="form-group d-inline">
                                    <div class="radio radio-primary d-inline">
                                        <input type="radio" name="outsource" id="radio-p-fill-6"  value="0" @if(old('outsource') == 0)checked=""@endif>
                                        <label for="radio-p-fill-6" class="cr">{{__('main.no')}}:</label>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="card-header">
                            <h5>{{__('main.add_permissions')}}</h5>
                        </div>
                        <div class="row">
                            <div class="col-md-3">
                                <h6 class="mt-4">
                                    <strong>
                                        {{__('main.check_all')}}
                                    </strong>
                                </h6>
                                <hr>
                                <div class="form-group">
                                    <div class="checkbox checkbox-fill d-inline">
                                        <input type="checkbox" name="check_all"
                                               id="check_all">
                                        <label for="check_all"
                                               class="cr">{{__('main.check_all')}}</label>
                                    </div>
                                </div>
                            </div>
                            @foreach($permissions as $permission)
                            <div class="col-md-3">
                                <h6 class="mt-4">
                                    <strong>
                                        {{$permission->name}}
                                    </strong>
                                </h6>
                                <hr>
                                @if($permission->name != \App\Models\JobFileReview::PERMISSION_NAME)
                                <div class="form-group">
                                    <div class="checkbox checkbox-fill d-inline">
                                        <input type="checkbox" name="permissions[{{$permission->name}}][read]"
                                               id="checkbox-fill-{{$permission->name}}-read"
                                                @if(isset(old('permissions')[$permission->name]['read'])) checked @endif>
                                        <label for="checkbox-fill-{{$permission->name}}-read"
                                               class="cr">Read</label>
                                    </div>
                                </div>
                                @endif

                                @if(
                                $permission->name != \App\Models\Report::PERMISSION_NAME
                                &&
                                $permission->name != \App\Models\Commission::PERMISSION_NAME
                                &&
                                $permission->name != \App\Models\ActivityLog::PERMISSION_NAME
                                )
                                <div class="form-group">
                                    <div class="checkbox checkbox-fill d-inline">
                                        <input type="checkbox" name="permissions[{{$permission->name}}][write]"
                                               id="checkbox-fill-{{$permission->name}}-write"
                                                @if(isset(old('permissions')[$permission->name]['write'])) checked @endif>
                                        <label for="checkbox-fill-{{$permission->name}}-write"
                                               class="cr">Write</label>
                                    </div>
                                </div>
                                @endif
                            </div>
                            @endforeach

                        </div>


                        <button type="submit" class="btn btn-primary">{{__('main.create')}}</button>
                        <button type="button" class="btn btn-outline-primary" onclick="window.location.href='{{route('employees.index')}}';">{{__('main.cancel')}}</button>
                    </form>

                </div>
            </div>

        </div>
    </div>
@endsection

@section('script_bottom')
    <script>
        $(function () {
            $("#check_all").change(function(){
                if($(this).is(':checked')){
                    $(".checkbox input").prop('checked', true);
                } else {
                    $(".checkbox input").prop('checked', false);
                }
            });
        });
    </script>
@endsection
