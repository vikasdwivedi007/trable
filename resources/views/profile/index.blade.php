@extends('layouts.main')

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h5>{{__("main.edit_your_profile")}}</h5>
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
                    <form id="validation-form123" action="{{route('profile.update')}}" method="POST"  enctype="multipart/form-data">
                        @method('PATCH')
                        @csrf
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <div class="pro-head">
                                    @if($user->profile_pic)
                                        <img src="{{url(\Illuminate\Support\Facades\Storage::url($user->profile_pic))}}" class="img-radius" alt="User-Profile-Image" height="100">
                                    @elseif(auth()->user()->employee->gender == 1)
                                        <img src="assets/images/user/avatar-1.jpg" class="img-radius" alt="User-Profile-Image" height="100">
                                    @else
                                        <img src="assets/images/user/avatar-2.jpg" class="img-radius" alt="User-Profile-Image" height="100">
                                    @endif
                                    <input class="d-none @error('profile_pic') is-invalid @enderror" id="file" name="profile_pic" accept="image/*" type="file"/>
                                    <a href="#" id="clicker">{{__("main.change")}}</a>
                                    @error('profile_pic')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6"></div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <input type="text" id="EmployeeFirstName" class="form-control @error('name') is-invalid @enderror"
                                           name="name" placeholder="{{__("main.name")}}" required value="{{$user->name}}">
                                    @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <input type="text" class="form-control mob_no @error('phone') is-invalid @enderror"
                                           name="phone" placeholder="{{__("main.phone")}}"  required value="{{$user->phone}}">
                                    @error('phone')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <input type="text" class="form-control  @error('email') is-invalid @enderror"
                                           name="email" placeholder="{{__("main.email")}}"  required value="{{$user->email}}" autofill="off">
                                    @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" placeholder="{{__("main.password")}}" title="Min 8 characters with 1 uppercase,1 lowercase and 1 special character" value="" autofill="off">
                                    @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                        </div>
                        <div class="row">

                            <div class="col-md-4">
                                <div class="form-group">
                                    <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror" name="password_confirmation" placeholder="{{__("main.confirm_password")}}" value="">
                                    @error('password_confirmation')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        @if($user->employee->guide)
                        <div class="row">
                            <div class="col-md-3 align-self-center">
                                <label for="">
                                    {{__("main.unavailable_at_these_days")}}:
                                </label>
                            </div>
                            <a href="#" id="add_date">+ Add date</a>
                        </div>

                        <div id="unavailable-dates">
                            @foreach($user->employee->guide->unavailable_at()->where('day', '>', \Carbon\Carbon::yesterday())->get() as $day)
                            <div class="unavailable-item row">
                                <div class="col-md-4 align-self-center" >
                                    <div class="form-group">
                                        <input type="text" class="form-control date-picker"
                                               name="unavailable_dates[]" placeholder="{{__("main.date")}}" value="{{$day->toArray()['day']}}">
                                    </div>
                                </div>
                                <div class="col-md-2 align-self-center">
                                    <a href="#" onclick="$(this).closest('.unavailable-item').remove();return false;">{{__("main.remove")}}</a>
                                </div>
                            </div>
                            @endforeach

                        </div>
                        @endif

                        <button type="submit" class="btn btn-primary">{{__("main.update")}}</button>
                        <button type="button" onclick="window.location.href='{{route('home')}}';" class="btn btn-outline-primary">{{__("main.cancel")}}</button>
                    </form>

                </div>
            </div>

        </div>
    </div>
@endsection

@section('script_bottom')
    <script>
        $(function () {
            $('[name="email"]').val("{{$user->email}}");
            $('[name="password"]').val("");

            @if($user->employee->guide)
            $('.date-picker').bootstrapMaterialDatePicker({
                weekStart: 0,
                format: 'dddd DD MMMM YYYY',
                time: false,
                minDate: moment()
            });

            $("#add_date").click(function(){
                var html = ' <div class="unavailable-item row">\n' +
                   '                                <div class="col-md-4 align-self-center" >\n' +
                   '                                    <div class="form-group">\n' +
                   '                                        <input type="text" class="form-control date-picker"\n' +
                   '                                               name="unavailable_dates[]" placeholder="Unavailable at date">\n' +
                   '                                    </div>\n' +
                   '                                </div>\n' +
                   '                                <div class="col-md-2 align-self-center">\n' +
                   '                                    <a href="#" onclick="$(this).closest(\'.unavailable-item\').remove();return false;">Remove date</a>\n' +
                   '                                </div>\n' +
                   '                            </div>';
                $("#unavailable-dates").prepend(html);
                $('.date-picker').bootstrapMaterialDatePicker({
                    weekStart: 0,
                    format: 'dddd DD MMMM YYYY',
                    time: false,
                    minDate: moment()
                });
                return false;
            });
            @endif
        });
    </script>
@endsection
