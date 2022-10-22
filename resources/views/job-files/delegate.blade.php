@extends('layouts.main')

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h5>{{__("main.delegate_to")}}</h5>
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
                    <form id="validation-form123" action="{{route('job-files.delegate', ['job_file'=>$job_file->id])}}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <label for="">
                                    {{__("main.select_employee")}}
                                </label>
                                <div class="form-group">
                                    <select id="CurrencyCDDL"
                                            class="js-example-tags form-control "
                                            name="assigned_to" required>
                                        <option value="">{{__("main.select_employee")}}</option>
                                        @foreach($employees as $employee)
                                            <option value="{{$employee->id}}" >{{$employee->user->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>


                        <button type="submit" class="btn btn-primary">{{__("main.delegate")}}</button>
                        <button type="button" onclick="window.location.href='{{ route('job-files.index') }}';" class="btn btn-outline-primary">{{__("main.cancel")}}</button>

                    </form>

                </div>
            </div>

        </div>
    </div>
@endsection
