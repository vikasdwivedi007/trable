<!DOCTYPE html>
<html lang="en">

<head>
    <title>Voyageurs DU MONDE</title>
    <!-- HTML5 Shim and Respond.js IE10 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 10]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <!-- Meta -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="description" content=""/>
    <meta name="keywords" content=""/>
    <meta name="author" content="CodedThemes" />

    <!-- Favicon icon -->
    <link rel="icon" href="{{asset('assets/images/favicon.ico" type="image/x-icon')}}">
    <!-- fontawesome icon -->
    <link rel="stylesheet" href="{{asset('assets/fonts/fontawesome/css/fontawesome-all.min.css')}}">
    <!-- animation css -->
    <link rel="stylesheet" href="{{asset('assets/plugins/animation/css/animate.min.css')}}">

    <!-- vendor css -->
    <link rel="stylesheet" href="{{asset('assets/css/style.css')}}">
    <!-- dark css -->
    <link id="darkTheme" rel="stylesheet" href="{{asset('assets/css/layouts/dark.css')}}">

</head>

<body>
<div class="auth-wrapper">
    <div class="auth-content">
        <div class="auth-bg">
            <span class="r"></span>
            <span class="r s"></span>
            <span class="r s"></span>
            <span class="r"></span>
        </div>
        <div class="card">
            <div class="card-body text-center">
                <form method="POST" action="{{ route('password.email') }}">
                    @csrf
                    <div class="mb-4">
                        <!-- <i class="feather icon-unlock auth-icon"></i> -->
                        <img src="{{asset('assets/images/logo.png')}}" alt="Voyageurs DU MONDE">
                    </div>
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <h3 class="mb-4">Reset Password</h3>
                    <div class="input-group mb-3">
                        <input id="email" type="email"  placeholder="Email *"  class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                        @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <input type="submit" class="btn btn-primary shadow-2 mb-4" value="Send password reset link" />
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Required Js -->
<script src="{{asset('assets/js/vendor-all.min.js')}}"></script>
<script src="{{asset('assets/plugins/bootstrap/js/bootstrap.min.js')}}"></script>
<script src="{{asset('assets/js/pcoded.min.js?ver=4')}}"></script>

</body>
</html>
