
@extends('frontend.layout.main')
@section('main-content')
    <style>

        #payment_methods li {
            padding-bottom: 10px;
            list-style: none;
        }
        #payment_methods li input[type="radio"] {
            position: relative;
            top: 1px;
        }
       #payment_methods li label {
            display: inline-block;
            padding-left: 5px;
        }
    </style>
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
                                <form action="{{route('checkout.order')}}" method="post">
                                    @csrf
                                <div class="panel-body">
                                    <div class="col-md-6 col-sm-12 col-xs-12">
                                        <form class="form-horizontal"  method="POST" action="{{url('/login-customer')}}" >
                                            @csrf
                                            <p class="font-16 font-bold text-uppercase mar-bot-20">THÔNG TIN KHÁCH HÀNG</p>
                                            <div class="line-full mar-bot-20"></div>

                                            <ul class="list-unstyled checkout-right">
                                               <div class="row">
                                                   <div class="col-md-6">
                                                       <li>
                                                           <div class="">
                                                               <p>Họ  và tên   <span class="pink">*</span></p>
                                                               <input type="text"  name="name"  value="{{old('name')}}" class="form-control">
                                                           </div>
                                                           @error('name')
                                                           <small class="form-text text-danger" style="font-style:italic!important;">
                                                               {{$message}}
                                                           </small>
                                                           @enderror
                                                       </li>
                                                   </div>
                                                   <div class="col-md-6">
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
                                                   </div>
                                                   <div class="col-md-12">
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
                                                   </div>
                                                       <div class="col-md-6">
                                                           <li>
                                                               <div class="">
                                                                   <label class="control-label" for="inputCity">Tỉnh/Thành phố <sup>*</sup></label>
                                                                   <div class="controls">
                                                                       <select name="provinces"  id="provinces" class="form-control required select-address">
                                                                           <option value="">Chọn Tỉnh Thành Phố</option>
                                                                           @foreach($data as $provinces)
                                                                               <option  value="{{ $provinces->id }}">
                                                                                   {{ ucfirst($provinces->name) }}</option>
                                                                           @endforeach
                                                                       </select>
                                                                   </div>
                                                                   @error('provinces')
                                                                   <small class="form-text text-danger" style="font-style:italic!important;">
                                                                       {{$message}}
                                                                   </small>
                                                                   @enderror
                                                               </div>
                                                           </li>
                                                       </div>
                                                       <div class="col-md-6">
                                                           <li>
                                                               <div class="">
                                                                   <label class="control-label" for="inputState/Province">Quận/Huyện<sup>*</sup></label>
                                                                   <div class="controls">
                                                                       <select name="districts"   id="districts"  placeholder="Chọn quận huyện"  class="form-control required select-address">
                                                                       </select>
                                                                   </div>
                                                                   @error('districts')
                                                                   <small class="form-text text-danger" style="font-style:italic!important;">
                                                                       {{$message}}
                                                                   </small>
                                                                   @enderror
                                                               </div>
                                                           </li>
                                                       </div>

                                                   <div class="col-md-6">
                                                       <li>
                                                           <div class="">
                                                               <label class="control-label" for="inputCity">Phường/Xã  <sup>*</sup></label>
                                                               <div class="controls">
                                                                   <select name="wards" id="wards" placeholder="Chọn phường xã"  class="form-control select-address">
                                                                   </select>
                                                               </div>
                                                               @error('wards')
                                                               <small class="form-text text-danger" style="font-style:italic!important;">
                                                                   {{$message}}
                                                               </small>
                                                               @enderror
                                                           </div>
                                                       </li>
                                                   </div>
                                                   <div class="col-md-6">
                                                       <li>
                                                           <div class="">
                                                               <p>Địa chỉ  <span class="pink">*</span></p>
                                                               <input type="text" class="form-control"   name="address" id="address"  value="{{old('address')}}" placeholder="Số nhà ,tên đường ...">
                                                           </div>
                                                       </li>
                                                   </div>
                                                   <div class="col-md-12">
                                                   <li>
                                                       <div class="">
                                                       <label class="control-label" for="notes">Ghi chú</label>
                                                       <div class="controls">
                                                           <textarea class="address-field" name="notes"  cols="62" rows="5" value="{{old('notes')}}" id="notes"></textarea>
                                                       </div>
                                                       </div>
                                                   </li>
                                                   </div>

                                                   </div>

                                            </ul>

                                        </form>
                                        <br>
                                    </div>

                                    <div class="col-md-6 col-sm-12 col-xs-12">
                                        <p class="font-16 font-bold text-uppercase mar-bot-20">THÔNG TIN ĐƠN HÀNG</p>
                                            <div class="line-full mar-bot-20"></div>
                                            <div class="table-responsive wow bounceInUp" data-wow-duration="2s">
                                                <table class="table table-bordered">
                                                    <thead>
                                                    <tr>

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

                                                            <td ><img style="max-width:90px;max-height:100px" src="{{asset($item->options->image)}}" alt=""></td>
                                                            <td>
                                                                <a href="{{ route('shop.product',$item->options->slug) }}"
                                                                   title="" class="font-bold font-13">{{ $item->name }}</a>

                                                                {{--                            <p class="font-bold font-13">{{$item->name}}</p>--}}

                                                            </td>

                                                            <td>
                                                                {{--                            <input type="number" class="form-control" value="{{$item->qty}}">--}}
                                                                <p class="font-bold font-18">{{$item->qty}}</p>

                                                            </td>
                                                            <td>
                                                                <p class="font-bold font-18">{{number_format($item->price,0,'','.')}}đ</p>
                                                            </td>
                                                            <td><p id="{{$item->rowId}}" class="pink font-bold font-18">{{number_format($item->subtotal,0,'','.')}}đ</p></td>
                                                        </tr>
                                                    @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        <div class="row" style="margin-top:10px;">
                                            <div class="col-md-6 col-sm-6 ">
                                                <ul id="payment_methods">
                                                    <li>
                                                        <input type="radio" id="direct-payment" name="payment-method" value="direct-payment" checked @if(old('payment-method') == 'direct-payment') checked
                                                            @endif>
                                                        <label for="direct-payment">Thanh toán tại cửa hàng</label>
                                                    </li>
                                                    <li>
                                                        <input type="radio" id="payment-home" name="payment-method" value="payment-home" @if(old('payment-method') == 'payment-home') checked
                                                            @endif>
                                                        <label for="payment-home">Thanh toán tại nhà</label>
                                                    </li>
                                                </ul>
                                            </div>
                                            <div class="col-md-6 col-sm-6">
                                                    <ul class="list-unstyled  ">
                                                        <li>
                                                            <p  id="total-price" class="font-15 font-bold grand">TỔNG ĐƠN HÀNG:
                                                                <span class="pull-right d-block mt-3">{{Cart::total()}} VNĐ</span>

                                                            </p>
                                                        </li>
                                                        <li>
                                                            <input type="submit" class="pink-btn pull-right" id="order-now" name="btn-order" value="Đặt hàng">

                                                             <div class="clearfix"></div>
                                                        </li>

                                                    </ul>
                                            </div>
                                        </div>

                                        </div>
                            </div>
                                </form>
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
