@extends('layouts.main')

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h5>{{__("main.create_new_reminder")}}</h5>
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
                    <form id="validation-form123" action="{{route('reminders.store')}}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>{{__("main.name_of_memo")}}</label>
                                    <input type="text" id="NameMemo" class="form-control @error('title') is-invalid @enderror"
                                           name="title" placeholder="{{__("main.name_of_memo")}}" required value="{{old('title')}}">
                                    @error('title')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                <label>{{__("main.date")}}</label>
                                    <input type="text" id="date" class="form-control @error('send_at') is-invalid @enderror"
                                           name="send_at" placeholder="{{__("main.date")}}" value="{{old('send_at_date')}}" required>
                                    @error('send_at')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                <label>{{__("main.time")}}</label>
                                    <input type="text" id="time" class="form-control @error('time') is-invalid @enderror"
                                           name="time" placeholder="{{__("main.time")}}" required value="{{old('time')}}">
                                    @error('time')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">                                
                                    <select id="AssignDDL"
                                            class="js-example-tags form-control @error('assigned_to_id') is-invalid @enderror" name="assigned_to_id" required>
                                        <option value="{{auth()->user()->employee->id}}" @if(auth()->user()->employee->id == old('assigned_to_id')) selected @endif>{{__("main.assign_to_me")}}</option>
                                        @foreach($employees as $employee)
                                            @if($employee->id != auth()->user()->employee->id)
                                                <option value="{{$employee->id}}" @if($employee->id == old('assigned_to_id')) selected @endif>{{$employee->user->name}}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                    @error('assigned_to_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4 align-self-center">
                                <fieldset class="form-group ">

                                    <div class="form-group pr-4 @error('status') is-invalid @enderror">
                                        {{__("main.status")}}:
                                        @error('status')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                    <div class="form-group d-inline pr-4">

                                        <div class="radio radio-primary d-inline">                                          
                                            <input type="radio" name="status" id="radio-ToDo" value="0" checked="" required @if(old('status') == 0) checked @endif>
                                            <label for="radio-ToDo" class="cr">{{__("main.to_do")}}</label>
                                        </div>
                                    </div>
                                    <div class="form-group d-inline pr-4">
                                        <div class="radio radio-primary d-inline">                                            
                                            <input type="radio" name="status" id="radio-p-Pending" value="1" required @if(old('status') == 2) checked @endif>
                                            <label for="radio-p-Pending" class="cr">{{__("main.pending")}}</label>
                                        </div>
                                    </div>
                                    <div class="form-group d-inline pr-4">
                                        <div class="radio radio-primary d-inline">                                            
                                            <input type="radio" name="status" id="radio-p-Done" value="2" required @if(old('status') == 3) checked @endif>
                                            <label for="radio-p-Done" class="cr">{{__("main.done")}}</label>
                                        </div>
                                    </div>
                                </fieldset>
                            </div>
                            <div class="col-md-4">
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>{{__("main.description")}}</label>
                                    <textarea placeholder="{{__("main.description")}}" class="form-control @error('desc') is-invalid @enderror" rows="7" name="desc">{{old('desc')}}</textarea>
                                    @error('desc')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6 pt-3">
                                <fieldset class="form-group ">

                                    <div class="form-group pr-4 @error('send_by') is-invalid @enderror">
                                        {{__("main.send_notification")}}:
                                        @error('send_by')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>

                                    <div class="form-group d-inline pr-4">
                                        <div class="checkbox checkbox-fill d-inline">
                                            <input type="checkbox" name="send_by[]"
                                                   value="db"
                                                   id="checkbox-fill-System-Popup"
                                                   name="validation-checkbox-custom" required @if(old('send_by') && in_array('db', old('send_by'))) checked @endif>
                                            <label for="checkbox-fill-System-Popup"
                                                   class="cr">{{__("main.popup_in_system")}}</label>
                                        </div>
                                    </div>
                                    <div class="form-group d-inline pr-4">
                                        <div class="checkbox checkbox-fill d-inline">
                                            <input type="checkbox" name="send_by[]"
                                                   value="mail"
                                                   id="checkbox-fill-Send-Email"
                                                   name="validation-checkbox-custom" required @if(old('send_by') && in_array('mail', old('send_by'))) checked @endif>
                                            <label for="checkbox-fill-Send-Email"
                                                   class="cr">{{__("main.send_email")}}</label>
                                        </div>
                                    </div>
{{--                                    <div class="form-group d-inline pr-4">--}}
{{--                                        <div class="checkbox checkbox-fill d-inline">--}}
{{--                                            <input type="checkbox" name="send_by[]"--}}
{{--                                                   value="whatsapp"--}}
{{--                                                   id="checkbox-fill-Send-Whatsapp"--}}
{{--                                                   name="validation-checkbox-custom" required @if(old('send_by') && in_array('whatsapp', old('send_by'))) checked @endif>--}}
{{--                                            <label for="checkbox-fill-Send-Whatsapp"--}}
{{--                                                   class="cr">WhatsApp</label>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
                                </fieldset>
                            </div>
                            <div class="col-md-4"></div>

                        </div>




                        <button type="submit" class="btn btn-primary">{{__("main.create")}}</button>
                        <button type="button" onclick="window.location.href='{{route('reminders.index')}}';" class="btn btn-outline-primary">{{__("main.cancel")}}</button>
                    </form>

                </div>
            </div>

        </div>
    </div>
@endsection
