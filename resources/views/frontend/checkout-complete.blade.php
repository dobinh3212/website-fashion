
@extends('frontend.layout.main')
@section('main-content')
    <style>
        #content-complete {
            max-width: 600px;
            margin: 0px auto;
            font-size: 15px;
        }

        #content-complete .info {
            font-size: 19px!important;
            text-transform: uppercase;
            text-align: center;
            color: red;
        }
    </style>
    <div class="container grid-main">
        <div class="row">
            <div id="content-complete">
                <img class="img-thumbnail img-responsive" src="{{ asset('/frontend/assets/images/thank-you.png') }}" alt="">
                <h3 class="info">Quý khách đã đặt hàng thành công!</h3>
                <p>• Cảm ơn quý khách đã sử dụng sản phẩm của cửa hàng chúng tôi.</p>
                <p>• Nhân viên cửa hàng sẽ liên hệ cho khách hàng trong thời gian sớm nhất để xác nhận đơn hàng của quý khách 1 lần
                    nữa.</p>
                <p>• Nhân viên giao hàng sẽ liên hệ với quý khách qua SĐT trước khi giao hàng 24 tiếng.</p>
                <p>• Địa chỉ cửa hàng: Trần Đại Nghĩa - Hai Bà Trưng - Hà Nội.</p>
                <p>• Số điện thoại cửa hàng: 1900 1900</p>
                <p class="text-right return" style="text-align: center">
                    <a class="btn btn-primary" title="Quay lại trang chủ"
                                                href="{{ url('/') }}">Quay lại trang chủ</a>
                </p>
            </div>

        </div>
    </div>
@endsection
@section('scripts')




@stop
