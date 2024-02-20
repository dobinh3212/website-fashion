@extends('frontend.layout.main')
@section('main-content')
    <style>
         .not-cart {
            background-color: #fff;
            text-align: center;
            font-size: 16px;
            padding: 3rem;
        }
         .not-cart img {
            margin: 0px auto;
        }

    </style>
    @php
        $customer_id = session('id');
         $customer_name = session('name');
    @endphp
<div class="container grid-main">
    <div class="row">

        <div class="col-md-12">

            @if(Cart::count()>0)
            <div class="table-responsive wow bounceInUp" data-wow-duration="2s">
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th  style=" width:9%" >Tác Vụ</th>
                        <th  style="width:14%">Hình Ảnh</th>
                        <th  style="width:30%">Tên Sản Phẩm</th>

                        <th  style="width:5%">Số Lượng</th>
                        <th  style="width:10%">Giá Sản Phẩm</th>
                        <th  style="width:12%">Thành Tiền</th>
                    </tr>
                    </thead>
                    <tbody>
                    @php

                            $t=0
                    @endphp
                    @foreach(Cart::content() as $item )
                        @php
                            $t++
                        @endphp
                        <tr>
                        <th scope="row">
                            <a href="{{route('cart.remove',$item->rowId)}}" style="color:#00c5bb!important;text-decoration: none;">
                                <img src="{{asset('/frontend/assets/images/trash.png')}} " alt="">
                            </a>
                           </th>
                        <td ><img style="max-width:90px;max-height:100px" src="{{asset($item->options->image)}}" alt=""></td>
                        <td>
                            <a href="{{ route('shop.product',$item->options->slug) }}"
                               title="" class="font-bold font-13">{{ $item->name }}</a>

{{--                            <p class="font-bold font-13">{{$item->name}}</p>--}}

                        </td>

                        <td>
{{--                            <input type="number" class="form-control" value="{{$item->qty}}">--}}
                            <input type="number"  name="num-order"  data-price="{{$item->price}}" data-url="{{route('cart.update',$item->rowId)}}"   class="num-order" min="1"  style="width:50px; text-align: center" value="{{$item->qty}}">

                        </td>
                        <td><p class="font-bold font-18">{{number_format($item->price,0,'','.')}}đ</p></td>
                        <td><p id="{{$item->rowId}}" class="pink font-bold font-18">{{number_format($item->subtotal,0,'','.')}}đ</p></td>
                    </tr>
                    @endforeach
                    </tbody>
                </table>

            </div>
            <div class="below-table clearfix">
                <a class="cart left-cart" href="{{route('cart.destroy')}}">XÓA GIỎ HÀNG</a>
                <a class="cart right-cart" href="{{url('/')}}">TIẾP TỤC MUA SẮM</a>
            </div>

            <div class="voucher-main wow bounceInUp" data-wow-duration="2s">
                <div class="row">
                    <div class="col-md-4 col-sm-12">
                    </div>
                    <div class="col-md-4 col-sm-12">
                    </div>
                    <div class="col-md-4 col-sm-12">
                        <div class="total">
                            <ul class="list-unstyled">
{{--                                <li>--}}
{{--                                    <p class="font-16 font-bold">TỔNG PHỤ: <span class="pull-right">369.000 VNĐ</span></p>--}}
{{--                                </li>--}}
                                <li>
                                    <p  id="total-price" class="font-20 font-bold grand">TỔNG ĐƠN HÀNG:
                                        <span class="pull-right d-block mt-3">{{Cart::total()}} VNĐ</span>

                                    </p>
                                </li>
                                <li>
                                    @if($customer_id != NULL)
                                    <a href="{{url('thanh-toan')}}" class="pink-btn pull-right">Tiến hành Thanh Toán</a>
                                    @else
                                        <a href="{{route('checkoutLogin')}}" class="pink-btn pull-right">Tiến hành Thanh Toán</a>
                                    @endif
                                    <div class="clearfix"></div>
                                </li>
                                <li>
                                    <p class="font-13 pull-right">Thanh toán với nhiều địa chỉ.</p>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            @else
                <div class="not-cart">
                    <img src="{{ asset('/frontend/assets/images/cart-empty.png') }}" alt="">
                    <p>Không có sản phẩm nào trong giỏ hàng của bạn</p>
                    <a href="{{ url('/') }}" class="btn btn-outline-success" title="trang chủ">Quay trở về trang
                        chủ </a>
                </div>
                    @endif
        </div>

    </div>
</div>
@endsection
