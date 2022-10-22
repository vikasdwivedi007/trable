@extends('layouts.main')

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h5>{{__('main.create_operating_statement')}}</h5>
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
                    <form id="validation-form123" action="{{route('operating-statements.store')}}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                  <label>{{__('main.date')}} *</label>
                                    <input type="text" id="date" name="date" class="form-control"
                                           placeholder="{{__('main.date')}} *" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>{{__('main.representative')}} *</label>
                                    <select id="EmployeeDDL"
                                            class="js-example-tags form-control"
                                            name="emp_id" required>
                                        <option value="">{{__('main.representative')}} *</option>
                                        @foreach($employees as $employee)
                                            <option value="{{$employee->id}}">{{$employee->user->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>{{__('main.job_file')}} *</label>
                                    <select id="JobFileDDL"
                                            class="js-example-tags form-control"
                                            name="job_id" required>
                                        <option value="">{{__('main.job_file')}} *</option>
                                        @foreach($job_files as $job_file)
                                            <option value="{{$job_file->id}}">{{$job_file->file_no}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <hr>

                        <button type="submit" class="btn btn-primary">{{__('main.create')}}</button>
                        <button type="button" onclick="window.location.href='{{ route('operating-statements.index')}}';" class="btn btn-outline-primary">{{__('main.cancel')}}</button>
                    </form>

                </div>
            </div>

        </div>
    </div>
@endsection
