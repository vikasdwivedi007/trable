<!DOCTYPE html>
<html lang="en">

<head>
    <title>{{ env('APP_NAME') }}</title>
    <!-- HTML5 Shim and Respond.js IE11 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 11]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <!-- Meta -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="description"
          content="Datta Able Bootstrap admin template made using Bootstrap 4 and it has huge amount of ready made feature, UI components, pages which completely fulfills any dashboard needs."/>
    <meta name="keywords"
          content="admin templates, bootstrap admin templates, bootstrap 4, dashboard, dashboard templets, sass admin templets, html admin templates, responsive, bootstrap admin templates free download,premium bootstrap admin templates, datta able, datta able bootstrap admin template">
    <meta name="author" content="Codedthemes"/>

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Favicon icon -->
    <link rel="icon" href="{{asset('assets/images/favicon.ico')}}" type="image/x-icon">
    <!-- fontawesome icon -->
    <link rel="stylesheet" href="{{asset('assets/fonts/fontawesome/css/fontawesome-all.min.css')}}">
    <!-- material icon -->
    <link rel="stylesheet" href="{{asset('assets/fonts/material/css/materialdesignicons.min.css')}}">
    <!-- animation css -->
    <link rel="stylesheet" href="{{asset('assets/plugins/animation/css/animate.min.css')}}">
    <!-- select2 css -->
    <link rel="stylesheet" href="{{asset('assets/plugins/select2/css/select2.min.css')}}">
    <!-- multi-select css -->
    <link rel="stylesheet" href="{{asset('assets/plugins/multi-select/css/multi-select.css')}}">
    <!-- material datetimepicker css -->
    <link rel="stylesheet"
          href="{{asset('assets/plugins/material-datetimepicker/css/bootstrap-material-datetimepicker.css')}}">
    <!-- Bootstrap datetimepicker css -->
<!-- <link rel="stylesheet" href="{{asset('assets/plugins/bootstrap-datetimepicker/css/bootstrap-datepicker3.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/fonts/material/css/materialdesignicons.min.css')}}"> -->


@yield('script_top_before_base')

<!-- vendor css -->
    <link rel="stylesheet" href="{{asset('assets/css/style.css')}}">
@if(!request()->cookie('theme') || request()->cookie('theme') == 'theme-dark')
    <!-- dark css -->
        <link id="darkTheme" rel="stylesheet" href="{{asset('assets/css/layouts/dark.css?ver=2.0')}}">
@endif
<!-- pnotify css -->
    <link rel="stylesheet" href="{{asset('assets/plugins/pnotify/css/pnotify.custom.min.css')}}">
    <!-- pnotify-custom css -->
    <link rel="stylesheet" href="{{asset('assets/css/pages/pnotify.css')}}">
    <style>
        .progress {
            height: 3px;
            position: fixed;
            top: 0;
            z-index: 9999;
        }
    </style>
    @yield('script_top')

</head>

<body>
<!-- [ Pre-loader ] start -->
<div class="loader-bg">
    <div class="loader-track">
        <div class="loader-fill"></div>
    </div>
</div>
<div class="progress" id="progress"></div>
<!-- [ Pre-loader ] End -->

<!-- [ navigation menu ] start -->
<nav class="pcoded-navbar icon-colored">
    <div class="navbar-wrapper">
        <div class="navbar-brand header-logo">
            <a href="/" class="b-brand">
                <div class="b-bg">
                    <i class="fab fa-vimeo-v"></i>
                </div>
                @if(!request()->cookie('theme') || request()->cookie('theme') == 'theme-dark')
                    <img id="navLogo" src="{{asset('assets/images/logo.png')}}" alt="Voyageurs DU MONDE" height="35"
                         width="104">
                @else
                    <img id="navLogo" src="{{asset('assets/images/logo-dark.png')}}" alt="Voyageurs DU MONDE"
                         height="35" width="104">
                @endif
            </a>
            <a class="mobile-menu" id="mobile-collapse" href="#!"><span></span></a>
        </div>
        <div class="navbar-content scroll-div">
            @include('partial.side-menu')
        </div>
    </div>
</nav>
<!-- [ navigation menu ] end -->

<!-- [ Header ] start -->
<header class="navbar pcoded-header navbar-expand-lg navbar-light">
    <div class="m-header">
        <a class="mobile-menu" id="mobile-collapse1" href="#!"><span></span></a>
        <a href="index.html" class="b-brand">
            <div class="b-bg">
                <i class="fab fa-vimeo-v"></i>
            </div>
            <img id="navLogo" src="{{asset('assets/images/logo.png')}}" alt="Voyageurs DU MONDE" height="35"
                 width="104">
        </a>
    </div>
    <a class="mobile-menu" id="mobile-header" href="#!">
        <i class="feather icon-more-horizontal"></i>
    </a>
    <div class="collapse navbar-collapse">
        <ul class="navbar-nav mr-auto">
            <li><a href="#!" class="full-screen" onclick="javascript:toggleFullScreen()"><i
                        class="feather icon-maximize"></i></a></li>
            <li><a title="Change Theme" href="#!" class="full-screen" onclick="changeTheme();return false;"><i
                        class="mdi mdi-theme-light-dark"></i></a></li>
            <li><a title="Switch Language" href="{{route('change-language')}}" class="full-screen"><i
                        class="fas fa-language"></i></a></li>
        </ul>
        <ul class="navbar-nav ml-auto">
            <li>
                <div class="dropdown">
                    <a class="dropdown-toggle" href="#" data-toggle="dropdown"><i class="mdi mdi-bell-ring-outline"></i></a>
                    @php list($notifications, $new_count) = \App\Models\Notification::getNotifications() @endphp
                    <div class="dropdown-menu dropdown-menu-right notification">
                        <div class="noti-head">
                            <h6 class="d-inline-block m-b-0">Notifications</h6>
                        </div>
                        <ul class="noti-body">
                            @if(!$notifications->count())
                                <li class="notification">
                                    <div class="media">
                                        <div class="media-body">
                                            <p>No notifications</p>
                                        </div>
                                    </div>
                                </li>
                            @endif
                            @foreach($notifications as $notification)
                                <li class="notification">
                                    <div class="media">
                                        <div class="media-body">
                                            <p><span class="n-time text-muted"><i
                                                        class="icon feather icon-clock m-r-10"></i>{{\App\Helpers::readableDate($notification->created_at)}}</span>
                                            </p>
                                            <p>{{$notification->toArray()['data']['title']}}</p>
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                        <div class="noti-footer">
                            {{--                                <a href="#!">show all</a>--}}
                        </div>
                    </div>
                </div>
            </li>
            <li>
                <div class="dropdown drp-user">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <div class="pro-head">
                            @if(auth()->user()->profile_pic)
                                <img
                                    src="{{url(\Illuminate\Support\Facades\Storage::url(auth()->user()->profile_pic))}}"
                                    class="img-radius" alt="User-Profile-Image" height="50">
                            @elseif(auth()->user()->employee->gender == 1)
                                <img src="{{asset('assets/images/user/avatar-1.jpg')}}" class="img-radius"
                                     alt="User-Profile-Image" height="50">
                            @else
                                <img src="{{asset('assets/images/user/avatar-2.jpg')}}" class="img-radius"
                                     alt="User-Profile-Image" height="50">
                            @endif
                            <span>{{auth()->user()->name}}</span>
                        </div>
                        <i class="mdi mdi-chevron-down"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right profile-notification">
                        <ul class="pro-body">
                            <li><a href="{{route('profile.index')}}" class="dropdown-item"><i
                                        class="feather icon-user"></i> {{__("main.profile")}}</a>
                            </li>
                            <li>
                                <form action="{{route('logout')}}" method="POST">
                                    @csrf
                                    <a href="#" onclick="this.closest('form').submit();return false;"
                                       class="dropdown-item">
                                        <i class="feather icon-log-out"></i> {{__("main.logout")}}
                                    </a>
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
            </li>
        </ul>
    </div>
</header>
<!-- [ Header ] end -->

<!-- [ chat user list ] start -->
<section class="header-user-list">
    <div class="h-list-header">
        <div class="input-group">
            <input type="text" id="search-friends" class="form-control" placeholder="Search Friend . . .">
        </div>
    </div>
    <div class="h-list-body">
        <a href="#!" class="h-close-text"><i class="feather icon-chevrons-right"></i></a>
        <div class="main-friend-cont scroll-div">
            <div class="main-friend-list">
                <div class="media userlist-box" data-id="1" data-status="online" data-username="Josephin Doe">
                    <a class="media-left" href="#!"><img class="media-object img-radius"
                                                         src="{{asset('assets/images/user/avatar-1.jpg')}}"
                                                         alt="Generic placeholder image ">
                        <div class="live-status">3</div>
                    </a>
                    <div class="media-body">
                        <h6 class="chat-header">Josephin Doe<small class="d-block text-c-green">Typing . . </small></h6>
                    </div>
                </div>
                <div class="media userlist-box" data-id="2" data-status="online" data-username="Lary Doe">
                    <a class="media-left" href="#!"><img class="media-object img-radius"
                                                         src="{{asset('assets/images/user/avatar-2.jpg')}}"
                                                         alt="Generic placeholder image">
                        <div class="live-status">1</div>
                    </a>
                    <div class="media-body">
                        <h6 class="chat-header">Lary Doe<small class="d-block text-c-green">online</small></h6>
                    </div>
                </div>
                <div class="media userlist-box" data-id="3" data-status="online" data-username="Alice">
                    <a class="media-left" href="#!"><img class="media-object img-radius"
                                                         src="{{asset('assets/images/user/avatar-3.jpg')}}"
                                                         alt="Generic placeholder image"></a>
                    <div class="media-body">
                        <h6 class="chat-header">Alice<small class="d-block text-c-green">online</small></h6>
                    </div>
                </div>
                <div class="media userlist-box" data-id="4" data-status="offline" data-username="Alia">
                    <a class="media-left" href="#!"><img class="media-object img-radius"
                                                         src="{{asset('assets/images/user/avatar-1.jpg')}}"
                                                         alt="Generic placeholder image">
                        <div class="live-status">1</div>
                    </a>
                    <div class="media-body">
                        <h6 class="chat-header">Alia<small class="d-block text-muted">10 min ago</small></h6>
                    </div>
                </div>
                <div class="media userlist-box" data-id="5" data-status="offline" data-username="Suzen">
                    <a class="media-left" href="#!"><img class="media-object img-radius"
                                                         src="{{asset('assets/images/user/avatar-4.jpg')}}"
                                                         alt="Generic placeholder image"></a>
                    <div class="media-body">
                        <h6 class="chat-header">Suzen<small class="d-block text-muted">15 min ago</small></h6>
                    </div>
                </div>
                <div class="media userlist-box" data-id="1" data-status="online" data-username="Josephin Doe">
                    <a class="media-left" href="#!"><img class="media-object img-radius"
                                                         src="{{asset('assets/images/user/avatar-1.jpg')}}"
                                                         alt="Generic placeholder image ">
                        <div class="live-status">3</div>
                    </a>
                    <div class="media-body">
                        <h6 class="chat-header">Josephin Doe<small class="d-block text-c-green">Typing . . </small></h6>
                    </div>
                </div>
                <div class="media userlist-box" data-id="2" data-status="online" data-username="Lary Doe">
                    <a class="media-left" href="#!"><img class="media-object img-radius"
                                                         src="{{asset('assets/images/user/avatar-2.jpg')}}"
                                                         alt="Generic placeholder image">
                        <div class="live-status">1</div>
                    </a>
                    <div class="media-body">
                        <h6 class="chat-header">Lary Doe<small class="d-block text-c-green">online</small></h6>
                    </div>
                </div>
                <div class="media userlist-box" data-id="3" data-status="online" data-username="Alice">
                    <a class="media-left" href="#!"><img class="media-object img-radius"
                                                         src="{{asset('assets/images/user/avatar-3.jpg')}}"
                                                         alt="Generic placeholder image"></a>
                    <div class="media-body">
                        <h6 class="chat-header">Alice<small class="d-block text-c-green">online</small></h6>
                    </div>
                </div>
                <div class="media userlist-box" data-id="4" data-status="offline" data-username="Alia">
                    <a class="media-left" href="#!"><img class="media-object img-radius"
                                                         src="{{asset('assets/images/user/avatar-1.jpg')}}"
                                                         alt="Generic placeholder image">
                        <div class="live-status">1</div>
                    </a>
                    <div class="media-body">
                        <h6 class="chat-header">Alia<small class="d-block text-muted">10 min ago</small></h6>
                    </div>
                </div>
                <div class="media userlist-box" data-id="5" data-status="offline" data-username="Suzen">
                    <a class="media-left" href="#!"><img class="media-object img-radius"
                                                         src="{{asset('assets/images/user/avatar-4.jpg')}}"
                                                         alt="Generic placeholder image"></a>
                    <div class="media-body">
                        <h6 class="chat-header">Suzen<small class="d-block text-muted">15 min ago</small></h6>
                    </div>
                </div>
                <div class="media userlist-box" data-id="1" data-status="online" data-username="Josephin Doe">
                    <a class="media-left" href="#!"><img class="media-object img-radius"
                                                         src="{{asset('assets/images/user/avatar-1.jpg')}}"
                                                         alt="Generic placeholder image ">
                        <div class="live-status">3</div>
                    </a>
                    <div class="media-body">
                        <h6 class="chat-header">Josephin Doe<small class="d-block text-c-green">Typing . . </small></h6>
                    </div>
                </div>
                <div class="media userlist-box" data-id="2" data-status="online" data-username="Lary Doe">
                    <a class="media-left" href="#!"><img class="media-object img-radius"
                                                         src="{{asset('assets/images/user/avatar-2.jpg')}}"
                                                         alt="Generic placeholder image">
                        <div class="live-status">1</div>
                    </a>
                    <div class="media-body">
                        <h6 class="chat-header">Lary Doe<small class="d-block text-c-green">online</small></h6>
                    </div>
                </div>
                <div class="media userlist-box" data-id="3" data-status="online" data-username="Alice">
                    <a class="media-left" href="#!"><img class="media-object img-radius"
                                                         src="{{asset('assets/images/user/avatar-3.jpg')}}"
                                                         alt="Generic placeholder image"></a>
                    <div class="media-body">
                        <h6 class="chat-header">Alice<small class="d-block text-c-green">online</small></h6>
                    </div>
                </div>
                <div class="media userlist-box" data-id="4" data-status="offline" data-username="Alia">
                    <a class="media-left" href="#!"><img class="media-object img-radius"
                                                         src="{{asset('assets/images/user/avatar-1.jpg')}}"
                                                         alt="Generic placeholder image">
                        <div class="live-status">1</div>
                    </a>
                    <div class="media-body">
                        <h6 class="chat-header">Alia<small class="d-block text-muted">10 min ago</small></h6>
                    </div>
                </div>
                <div class="media userlist-box" data-id="5" data-status="offline" data-username="Suzen">
                    <a class="media-left" href="#!"><img class="media-object img-radius"
                                                         src="{{asset('assets/images/user/avatar-4.jpg')}}"
                                                         alt="Generic placeholder image"></a>
                    <div class="media-body">
                        <h6 class="chat-header">Suzen<small class="d-block text-muted">15 min ago</small></h6>
                    </div>
                </div>
                <div class="media userlist-box" data-id="1" data-status="online" data-username="Josephin Doe">
                    <a class="media-left" href="#!"><img class="media-object img-radius"
                                                         src="{{asset('assets/images/user/avatar-1.jpg')}}"
                                                         alt="Generic placeholder image ">
                        <div class="live-status">3</div>
                    </a>
                    <div class="media-body">
                        <h6 class="chat-header">Josephin Doe<small class="d-block text-c-green">Typing . . </small></h6>
                    </div>
                </div>
                <div class="media userlist-box" data-id="2" data-status="online" data-username="Lary Doe">
                    <a class="media-left" href="#!"><img class="media-object img-radius"
                                                         src="{{asset('assets/images/user/avatar-2.jpg')}}"
                                                         alt="Generic placeholder image">
                        <div class="live-status">1</div>
                    </a>
                    <div class="media-body">
                        <h6 class="chat-header">Lary Doe<small class="d-block text-c-green">online</small></h6>
                    </div>
                </div>
                <div class="media userlist-box" data-id="3" data-status="online" data-username="Alice">
                    <a class="media-left" href="#!"><img class="media-object img-radius"
                                                         src="{{asset('assets/images/user/avatar-3.jpg')}}"
                                                         alt="Generic placeholder image"></a>
                    <div class="media-body">
                        <h6 class="chat-header">Alice<small class="d-block text-c-green">online</small></h6>
                    </div>
                </div>
                <div class="media userlist-box" data-id="4" data-status="offline" data-username="Alia">
                    <a class="media-left" href="#!"><img class="media-object img-radius"
                                                         src="{{asset('assets/images/user/avatar-1.jpg')}}"
                                                         alt="Generic placeholder image">
                        <div class="live-status">1</div>
                    </a>
                    <div class="media-body">
                        <h6 class="chat-header">Alia<small class="d-block text-muted">10 min ago</small></h6>
                    </div>
                </div>
                <div class="media userlist-box" data-id="5" data-status="offline" data-username="Suzen">
                    <a class="media-left" href="#!"><img class="media-object img-radius"
                                                         src="{{asset('assets/images/user/avatar-4.jpg')}}"
                                                         alt="Generic placeholder image"></a>
                    <div class="media-body">
                        <h6 class="chat-header">Suzen<small class="d-block text-muted">15 min ago</small></h6>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- [ chat user list ] end -->

<!-- [ chat message ] start -->
<section class="header-chat">
    <div class="h-list-header">
        <h6>Josephin Doe</h6>
        <a href="#!" class="h-back-user-list"><i class="feather icon-chevron-left"></i></a>
    </div>
    <div class="h-list-body">
        <div class="main-chat-cont scroll-div">
            <div class="main-friend-chat">
                <div class="media chat-messages">
                    <a class="media-left photo-table" href="#!"><img class="media-object img-radius img-radius m-t-5"
                                                                     src="{{asset('assets/images/user/avatar-2.jpg')}}"
                                                                     alt="Generic placeholder image"></a>
                    <div class="media-body chat-menu-content">
                        <div class="">
                            <p class="chat-cont">hello Datta! Will you tell me something</p>
                            <p class="chat-cont">about yourself?</p>
                        </div>
                        <p class="chat-time">8:20 a.m.</p>
                    </div>
                </div>
                <div class="media chat-messages">
                    <div class="media-body chat-menu-reply">
                        <div class="">
                            <p class="chat-cont">Ohh! very nice</p>
                        </div>
                        <p class="chat-time">8:22 a.m.</p>
                    </div>
                </div>
                <div class="media chat-messages">
                    <a class="media-left photo-table" href="#!"><img class="media-object img-radius img-radius m-t-5"
                                                                     src="{{asset('assets/images/user/avatar-2.jpg')}}"
                                                                     alt="Generic placeholder image"></a>
                    <div class="media-body chat-menu-content">
                        <div class="">
                            <p class="chat-cont">can you help me?</p>
                        </div>
                        <p class="chat-time">8:20 a.m.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="h-list-footer">
        <div class="input-group">
            <input type="file" class="chat-attach" style="display:none">
            <a href="#!" class="input-group-prepend btn btn-success btn-attach">
                <i class="feather icon-paperclip"></i>
            </a>
            <input type="text" name="h-chat-text" class="form-control h-send-chat" placeholder="Write hear . . ">
            <button type="submit" class="input-group-append btn-send btn btn-primary">
                <i class="feather icon-message-circle"></i>
            </button>
        </div>
    </div>
</section>
<!-- [ chat message ] end -->


<!-- [ Main Content ] start -->
<div class="pcoded-main-container">
    <div class="pcoded-wrapper">
        <div class="pcoded-content">
            <div class="pcoded-inner-content">
                <!-- [ breadcrumb ] start -->

                <!-- [ breadcrumb ] end -->
                <div class="main-body">
                    <div class="page-wrapper">
                        @yield('content')
                    </div>
                </div>
            </div>
        </div>
    </div>
    
</div>

<footer class="float-right pr-4">
      <p>Powered By <cite title="Source Title">CreaGital Company</cite></p>
    </footer>
<!-- [ Main Content ] end -->

<!-- Warning Section start -->
<!-- Older IE warning message -->
<!--[if lt IE 11]>
<div class="ie-warning">
    <h1>Warning!!</h1>
    <p>You are using an outdated version of Internet Explorer, please upgrade
        <br/>to any of the following web browsers to access this website.
    </p>
    <div class="iew-container">
        <ul class="iew-download">
            <li>
                <a href="http://www.google.com/chrome/">
                    <img src="{{asset('assets/images/browser/chrome.png')}}" alt="Chrome">
                    <div>Chrome</div>
                </a>
            </li>
            <li>
                <a href="https://www.mozilla.org/en-US/firefox/new/">
                    <img src="{{asset('assets/images/browser/firefox.png')}}" alt="Firefox">
                    <div>Firefox</div>
                </a>
            </li>
            <li>
                <a href="http://www.opera.com">
                    <img src="{{asset('assets/images/browser/opera.png')}}" alt="Opera">
                    <div>Opera</div>
                </a>
            </li>
            <li>
                <a href="https://www.apple.com/safari/">
                    <img src="{{asset('assets/images/browser/safari.png')}}" alt="Safari">
                    <div>Safari</div>
                </a>
            </li>
            <li>
                <a href="http://windows.microsoft.com/en-us/internet-explorer/download-ie">
                    <img src="{{asset('assets/images/browser/ie.png')}}" alt="">
                    <div>IE (11 & above)</div>
                </a>
            </li>
        </ul>
    </div>
    <p>Sorry for the inconvenience!</p>
</div>
<![endif]-->
<!-- Warning Section Ends -->



<!-- Required Js -->
<script src="{{asset('assets/js/vendor-all.min.js')}}"></script>
<script src="{{asset('assets/plugins/bootstrap/js/bootstrap.min.js')}}"></script>
<script src="{{asset('assets/js/pcoded.js?ver=4.6')}}"></script>
<!-- <script src="assets/js/pcoded.min.js"></script> -->


<!-- material datetimepicker Js -->
<script src="http://momentjs.com/downloads/moment-with-locales.min.js"></script>
<script src="{{asset('assets/plugins/material-datetimepicker/js/bootstrap-material-datetimepicker.js')}}"></script>

<!-- form-picker-custom Js -->
<script src="{{asset('assets/js/pages/form-picker-custom.js')}}"></script>

<!-- Input mask Js -->
<script src="{{asset('assets/plugins/inputmask/js/inputmask.min.js')}}"></script>
<script src="{{asset('assets/plugins/inputmask/js/jquery.inputmask.min.js')}}"></script>
<script src="{{asset('assets/plugins/inputmask/js/autoNumeric.js')}}"></script>

<!-- form-picker-custom Js -->
<script src="{{asset('assets/js/pages/form-masking-custom.js')}}"></script>

<!-- select2 Js -->
<script src="{{asset('assets/plugins/select2/js/select2.full.min.js')}}"></script>

<!-- multi-select Js -->
<script src="{{asset('assets/plugins/multi-select/js/jquery.quicksearch.js')}}"></script>
<script src="{{asset('assets/plugins/multi-select/js/jquery.multi-select.js')}}"></script>

<!-- form-select-custom Js -->
<script src="{{asset('assets/js/pages/form-select-custom.js?ver=3')}}"></script>


<!-- jquery-validation Js -->
<script src="{{asset('assets/plugins/jquery-validation/js/jquery.validate.min.js')}}"></script>
<!-- form-picker-custom Js -->
<script src="{{asset('assets/js/pages/form-validation.js')}}"></script>


<!-- pnotify Js -->
<script src="{{asset('assets/plugins/pnotify/js/pnotify.custom.min.js')}}"></script>
<script src="{{asset('assets/plugins/pnotify/js/notify-event.js')}}"></script>
<script src="{{asset('assets/plugins/sweetalert2/js/sweetalert.min.js')}}"></script>
<script src="{{asset('assets/js/progressbar.min.js')}}"></script>
<script>
    edit_btn_text = '{{__("main.edit")}}';
    view_btn_text = '{{__("main.view")}}';
    print_btn_text = '{{__("main.print")}}';
    delete_btn_text = '{{__("main.delete")}}';
    approve_btn_text = '{{__("main.approve")}}';
    deny_btn_text = '{{__("main.deny")}}';
    delegate_btn_text = '{{__("main.delegate")}}';

    var current_theme = 'theme-dark';
    @if(request()->cookie('theme') == 'theme-light')
        current_theme = 'theme-light';

    @endif
    function refreshToken() {
        $.get('/refresh-csrf').done(function (data) {
            let csrfToken = data; // the new token
            $('meta[name="csrf-token"]').attr('content', csrfToken);
        });
    }

    function isArabic(text) {
        // var arabic = /[\u0600-\u06FF]/;
        var arabic = /^[\u0621-\u064A\s0-9]+$/;
        result = arabic.test(text);
        return result;
    }

    $(function () {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            statusCode: {
                419: function () {
                    refreshToken();
                }
            },
            error: function (x, status, error) {
                if (status == 'abort') {
                    return;
                }
                console.log(x.responseJSON);
                new PNotify({
                    title: 'Error',
                    text: x.status && x.status == 422 ? "Invalid Data" : "{{__('main.server_error')}}!",
                    type: 'error'
                });
            }
        });

        var progress_line;
        progress_line = new ProgressBar.Line('#progress', {
            color: '#1de9b6',
            easing: 'easeInOut'
        });
        $(document)
            .ajaxStart(function () {
                $(".progress").show();
                progress_line.animate(0.5);
            })
            .ajaxStop(function () {
                progress_line.animate(1, {}, function () {
                    $(".progress").hide();
                    progress_line.animate(0);
                });

            });

        @if(session('success'))
        new PNotify({
            title: 'Success',
            text: "{{session('success')}}",
            type: 'info'
        });
        @elseif(session('error'))
        new PNotify({
            title: 'Error',
            text: "{{session('error')}}",
            type: 'error'
        });
        @endif

        @if(!request()->is('job-files*'))
        $(document).on('submit', 'form', function (e) {
            $('form [type="submit"]').attr('disabled', 'disabled');
            $('form [type="submit"]').addClass('disabled');
        });
        @endif
        $(document).on('click', 'form [type="submit"]', function (e) {
            setTimeout(function () {
                if ($(".error:visible").length) {
                    $('html, body').animate({
                        scrollTop: $(".error:visible").offset().top - 50
                    }, 500);
                }
            }, 250);
        });

        $(document).on('click', '.confirm_delete', function (e) {
            e.preventDefault();
            Swal.fire({
                icon: 'warning',
                title: "{{__('main.are_you_sure')}}",
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: '{{__("main.yes_delete_it")}}',
                cancelButtonText: '{{__("main.cancel")}}'
            }).then((result) => {
                if (result.isConfirmed) {
                    this.closest('form').submit();
                }
            })
        });

        var reminders = [];
        @foreach($notifications->toArray() as $notification)
        @if(!$notification['read_at'] && isset($notification['data']['popup']) && $notification['data']['popup'])
        reminders.push(
            {
                title: "{{$notification['data']['title']}}",
                icon: "info",
                html: "{{$notification['data']['content']}}",
                preConfirm: function (value) {
                    if (value) {
                        $.get("{{route('notifications.read-one',['id'=>$notification['id']])}}");
                    }
                },
                // onOpen: () => {
                // }
            }
        );
        @endif
            @endforeach
        if (reminders.length) {
            Swal.queue(reminders);
        }

        $(document).on('input', '.ar_only', function (e) {
            let value = $(this).val();
            if (!isArabic(value)) {
                let str = value.split('');
                for (var i = 0; i < value.length; i++) {
                    if (!isArabic(value.charAt(i))) {
                        str.splice(i, 1);
                    }
                }
                value = str.join('');
                $(this).val(value);
            }
        });
    });
</script>
@yield('script_bottom')

</body>

</html>
