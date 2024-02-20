
@extends('frontend.layout.main')
@section('main-content')
<div class="container grid-main">
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12 wow bounceInUp" data-wow-duration="2s">
            <div class="chekout-panel">
                <div class="panel-group" id="accordion">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h2 class="panel-title pt-2  font-17">
                                THỦ TỤC THANH TOÁN
                            </h2>
                        </div>
                        <div id="panel1" class="panel-collapse collapse in">
                            <div class="panel-body">
                                <div class="col-md-6 col-sm-12 col-xs-12">
                                    <form class="form-horizontal"  method="POST" action="{{url('/login-customer')}}" >
                                        @csrf
                                    <p class="font-16 font-bold text-uppercase mar-bot-20">ĐĂNG NHẬP</p>
                                    <p class="text-uppercase">Nếu bạn đã tạo tài khoản, vui lòng đăng nhập dưới đây:</p>
                                    <div class="line-full mar-bot-20"></div>
                                    <ul class="list-unstyled checkout-right">
                                        <li>
                                            <div class="">
                                                <p>Email  <span class="pink">*</span></p>
                                                <input type="text"  name="email"  value="{{old('email')}}" class="form-control">
                                            </div>
                                            @error('email')
                                            <small class="form-text text-danger" style="font-style:italic!important;">
                                                {{$message}}
                                            </small>
                                            @enderror
                                        </li>
                                        <li>
                                            <div class="">
                                                <p>Mật Khẩu  <span class="pink">*</span></p>
                                                <input type="password" name="password" class="form-control">
                                            </div>
                                            @error('password')
                                            <small class="form-text text-danger" style="font-style:italic!important;">
                                                {{$message}}
                                            </small>
                                            @enderror
                                        </li>
                                    </ul>
                                        <button class="cart pull-left" type="submit" name="btn-login" style="margin-right:16px;">Đăng Nhập</button>
                                    </form>
                                    <br>
                                </div>

                                <div class="col-md-6 col-sm-12 col-xs-12">
                                    <p class="font-16 font-bold text-uppercase mar-bot-20">Đăng Ký</p>
                                    <p class="text-uppercase">Nếu bạn chưa có tài khoản, vui lòng đăng ký dưới đây:</p>
                                    <form class="form-horizontal" action="{{url('/add-customer')}}" method="POST">
                                        @csrf
                                    <div class="line-full mar-bot-20"></div>
                                    <ul class="list-unstyled checkout-right">
                                        <li>
                                            <div class="">
                                                <p>Họ và tên <span class="pink">*</span></p>
                                                <input type="text" name="name"  value="{{old('name')}}" class="form-control">
                                            </div>
                                            @error('name')
                                            <small class="form-text text-danger" style="font-style:italic!important;">
                                                {{$message}}
                                            </small>
                                            @enderror
                                        </li>
                                        <li>
                                            <div class="">
                                                <p>Số điện thoại </p>
                                                <input type="text" name="phone"  value="{{old('phone')}}"  class="form-control">
                                            </div>
                                            @error('phone')
                                            <small class="form-text text-danger" style="font-style:italic!important;">
                                                {{$message}}
                                            </small>
                                            @enderror
                                        </li>
                                        <li>
                                            <div class="">
                                                <p>Email  <span class="pink">*</span></p>
                                                <input type="text"  name="email"  value="{{old('email')}}" class="form-control">
                                            </div>
                                            @error('email')
                                            <small class="form-text text-danger" style="font-style:italic!important;">
                                                {{$message}}
                                            </small>
                                            @enderror
                                        </li>
                                        <li>
                                            <div class="">
                                                <p>Mật Khẩu  <span class="pink">*</span></p>
                                                <input type="password" name="password" class="form-control">
                                            </div>
                                            @error('password')
                                            <small class="form-text text-danger" style="font-style:italic!important;">
                                                {{$message}}
                                            </small>
                                            @enderror
                                        </li>
                                        <li>
                                            <div class="">
                                                <p>Nhập Lại Mật Khẩu <span class="pink">*</span></p>
                                                <input type="password" name="password_confirmation" id="password-confirm" class="form-control">
                                            </div>
                                            @error('password_confirmation')
                                            <small class="form-text text-danger" style="font-style:italic!important;">
                                                {{$message}}
                                            </small>
                                            @enderror
                                        </li>
                                    </ul>
                                        <button class="cart pull-left" type="submit" name="btn-add" style="margin-right:16px;">Đăng Ký</button>
{{--                                    <a class="cart pull-left" href="#" style="margin-right:16px;">Đăng Ký</a>--}}
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    </div>
                </div>
            </div>
        </div>
</div>
<br>
<br>




@endsection
@section('scripts')




@stop
