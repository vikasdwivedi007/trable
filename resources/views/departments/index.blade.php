@extends('layouts.main')

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h5>{{__('main.departments')}}</h5>
                    <div class="card-header-right">
                        <div class="btn-group card-option">
                            <button type="button" class="btn dropdown-toggle btn-icon" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="feather icon-more-horizontal"></i>
                            </button>
                            <ul class="list-unstyled card-option dropdown-menu dropdown-menu-right">
                                <li class="dropdown-item full-card"><a href="#!"><span><i class="feather icon-maximize"></i> maximize</span><span style="display:none"><i class="feather icon-minimize"></i> Restore</span></a></li>
                                <li class="dropdown-item minimize-card"><a href="#!"><span><i class="feather icon-minus"></i> collapse</span><span style="display:none"><i class="feather icon-plus"></i> expand</span></a></li>
{{--                                <li class="dropdown-item reload-card"><a href="#!"><i class="feather icon-refresh-cw"></i> reload</a></li>--}}
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="card-block">
                    @if(auth()->user()->hasPermission(\App\Models\Department::PERMISSION_NAME, 'write'))
                    <a id="crt-Nw-Dprtmnt" href="{{ route('departments.create') }}" class="btn btn-primary mb-4">
                        {{__('main.create_new_department')}}
                    </a>
                    @endif

                    <div id="departments-Sections" class="row">
                        <!-- [ Department ] starts-->
                        @foreach($departments as $department)
                        <div class="col-md-3 col-xs-6">
                            <div class="card">
                                <div class="card-header">
                                    <h5 id="department-Name" class="text-info">{{$department->name}}</h5>
                                    @if(auth()->user()->hasPermission(\App\Models\Department::PERMISSION_NAME, 'write'))
                                    <div class="card-header-right">
                                        <div class="btn-group card-option">
                                            <button type="button" class="btn dropdown-toggle" data-toggle="dropdown" aria-haspopup="true"
                                                    aria-expanded="false">
                                                <i class="feather icon-more-vertical"></i>
                                            </button>
                                            <ul class="list-unstyled card-option dropdown-menu dropdown-menu-right">
                                                <li class="dropdown-item ">
                                                    <a href="{{ $department->editPath() }}">
                                                       <span><i class="mdi mdi-square-edit-outline"></i>
                                                            {{__('main.edit')}}
                                                       </span>
                                                    </a>
                                                </li>
                                                <li class="dropdown-item">
                                                    @if($department->active)
                                                    <a href="{{ route('departments.deactivate', ['department'=>$department->id]) }}">
                                                        <span><i class="mdi mdi-toggle-switch-off-outline"></i>
                                                            {{__('main.deactivate')}}
                                                        </span>
                                                    @else
                                                    <a href="{{ route('departments.activate', ['department'=>$department->id]) }}">
                                                        <span><i class="mdi mdi-toggle-switch-off"></i>
                                                            {{__('main.activate')}}
                                                        </span>
                                                    @endif
                                                    </a>
                                                </li>

                                            </ul>
                                        </div>
                                    </div>
                                    @endif
                                </div>
                                <div class="card-block">
                                    <div class="row align-items-center justify-content-center">
                                        <div class="col-12">
                                            <h5 id="no-of-employees" class="d-block pt-2 pb-4 text-muted">{{$department->employees_count}} {{__('main.dep_employees')}}</h5>
{{--                                            <h5 id="city" class="f-w-300 mb-0">CAIRO</h5>--}}
                                        </div>
{{--                                        <div class="col-6">--}}
{{--                                            <div id="transactions" style="height:80px;width:80px;margin:0 auto;"></div>--}}
{{--                                        </div>--}}
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                        <!-- [ Department ] end -->

                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
