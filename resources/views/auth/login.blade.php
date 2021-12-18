<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{asset('public/login-form-05/fonts/icomoon/style.css')}}">

    <link rel="stylesheet" href="{{asset('public/login-form-05/css/owl.carousel.min.css')}}">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{asset('public/login-form-05/css/bootstrap.min.css')}}">

    <!-- Style -->
    <link rel="stylesheet" href="{{asset('public/login-form-05/css/style.css')}}">

    <title>Đăng Nhập</title>
</head>
<body>


<div class="d-md-flex half">
    <div class="bg" style="background-image: url(public/login-form-05/images/bg_1.jpg);"></div>
    <div class="contents">

        <div class="container">
            <div class="row align-items-center justify-content-center">
                <div class="col-md-12">
                    <div class="form-block mx-auto">
                        <div class="text-center mb-5">
                            <h3 class="text-uppercase"> <strong>Đăng Nhập</strong></h3>

                        </div>
                        <form action="{{ route('login') }}"  method="POST">
                            @csrf
                            <div class="form-group first">
                                <label for="email">Email</label>
                                <input id="email" type="email" class="form-control" placeholder="Email"  @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                @error('email')
                                <span class="invalid-feedback text-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror

                            </div>

                            <div class="form-group last mb-3">
                                <label for="password">Mật Khẩu</label>
                                <input id="password" type="password" placeholder="Mật khẩu" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                                @error('password')
                                <span class="invalid-feedback text-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="d-sm-flex mb-5 align-items-center">
                                <label class="control control--checkbox mb-3 mb-sm-0"><span class="caption">   {{ __('Remember Me') }} </span>
                                    <input type="checkbox"   name="remember" id="remember" {{ old('remember') ? 'checked' : '' }} />
                                    <div class="control__indicator"></div>
                                </label>
                                <span class="ml-auto">
                                    @if (Route::has('password.request'))
                                        <a href="{{ route('password.request') }}">
                                        {{ __('Forgot Your Password?') }}
                                    </a>
                                    @endif</span>

                            </div>

                            <button type="submit" value="Đăng Nhập" class="btn btn-block py-2 btn-primary">
                                {{ __('Login') }}
                            </button>

                            <span class="text-center my-3 d-block">Hoặc</span>


                            <div class="">
                                <a href="#" class="btn btn-block py-2 btn-facebook">
                                    <span class="icon-facebook mr-3"></span> Đăng nhập với facebook
                                </a>
                                <a href="#" class="btn btn-block py-2 btn-google"><span class="icon-google mr-3"></span> Đăng nhập với Google</a>
                            </div>
                            <div class="mt-2 text-center">
                               <span>  Chưa có tài khoản ?</span><a  class="pl-2 text-danger" style="text-decoration:none;" href="{{ route('register')}}" style="">Đăng ký </a>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>


</div>



<script src="{{asset('public/login-form-05/js/jquery-3.3.1.min.js')}} "></script>
<script src="{{asset('public/login-form-05/ js/popper.min.js')}}  "></script>
<script src=" {{asset('public/login-form-05/js/bootstrap.min.js')}}"></script>
<script src="{{asset('public/login-form-05/js/main.js')}}"></script>
</body>
</html>
