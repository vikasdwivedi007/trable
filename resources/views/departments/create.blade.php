@extends('layouts.main')

@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header">
                <h5> {{__('main.create_new_department')}}</h5>
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
                <form id="validation-form123" action="{{route('departments.store')}}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>{{__('main.department_name')}}</label>
                                <input type="text" id="DepartmentName" class="form-control @error('name') is-invalid @enderror"
                                       name="name" required placeholder="{{__('main.department_name')}}" value="{{old('name')}}">
                                @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                    </div>

                    <button type="submit" class="btn btn-primary">{{__('main.create')}}</button>
                    <button type="button" class="btn btn-outline-primary" onclick="window.location.href='{{route('departments.index')}}';">{{__('main.cancel')}}</button>
                </form>

            </div>
        </div>

    </div>
</div>
@endsection
