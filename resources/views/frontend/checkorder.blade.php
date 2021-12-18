
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
            <div class="col-md-12 col-sm-12 col-xs-12 wow bounceInUp" data-wow-duration="2s" style="padding-left:50px!important; ">
                <div class="chekout-panel"  >
                    <div class="panel-group" id="accordion">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h2 class="panel-title pt-2  font-17">
                                    THEO DÕI  ĐƠN HÀNG
                                </h2>
                            </div>
                            @if(isset($code))
                                <figure class="right-sec r-border">
                                    <div class="r-title-bar">
                                        <strong class="green-t">Đơn hàng của tôi</strong>
                                    </div>
                                    <div class="box" style="padding-left: 18px">

                                        <!-- /.box-header -->
                                        <div class="box-body" style="padding-left: 20px">
                                            <div class="row">
                                                <div class="col-md-6 " >
                                                    <div class="title">
                                                        <i class="fa fa-barcode text-primary ml-3 "></i>
                                                        <strong style="font-size:18px!important;" >Mã đơn hàng</strong>
                                                    </div>
                                                    <div class="content " style="min-height: 20px!important;">
                                                        {{$order->code}}
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="title">
                                                        <i class="fa fa-paypal text-primary"></i>
                                                        <strong style="font-size:18px!important;">Hình thức thanh toán</strong>
                                                    </div>
                                                    <div class="content " style="min-height: 20px!important;">
                                                        @if($order->payment == 'payment-home')
                                                            Thanh toán tại nhà
                                                        @else
                                                            Thanh toán tại cửa hàng
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="col-md-6 ">
                                                    <div class="title">
                                                        <i class="fa fa-map-marker text-primary mr-1"></i>
                                                        <strong style="font-size:18px!important;">Địa chỉ nhận</strong>
                                                    </div>
                                                    <div class="content " style="min-height: 20px!important;">
                                                        {{$order->address}}
                                                    </div>
                                                </div>

                                                <div class="col-md-6 ">
                                                    <div class="title">
                                                        <i class="fa fa-truck text-primary mr-1"></i>
                                                        <strong style="font-size:18px!important;">Trạng thái đơn hàng</strong>
                                                    </div>
                                                    <div class="content " style="min-height: 20px!important;" >
                                                        <div class="input-group">
                                                            @if($order->status =='pending') Đang xử lý
                                                            @elseif($order->status =='delivery')Đang vận chuyển
                                                            @elseif($order->status =='complete')Hoàn thành
                                                            @elseif($order->status =='canceled')
                                                                Bị Hủy
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                        <!-- /.box-body -->
                                    </div>
                                    <span class="box">
                                    <div class="box-header">
                                        <h3 class="box-title">TỔNG GIÁ TRỊ HÓA ĐƠN</h3>
                                    </div>
                                        <!-- /.box-header -->
                                    <div class="box-body no-padding">

                                        <div class="col-md-12">
                                            <div class="title">
                                                <strong style="font-size:18px!important;">Tổng số sản phẩm:</strong>
                                            </div>
                                            <div class="content text-danger font-weight-bold " style="min-height: 20px!important;">
                                                {{$order->product_qty}}

                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="title">
                                                <strong style="font-size:16px!important;">   Tổng giá trị:</strong>
                                            </div>
                                            <div class="content text-danger font-weight-bold" style="font-size: 20px!important;" >
                                                {{number_format($order->total)}} VNĐ
                                                <span class="card pl-3   pr-4">
                                </span>
                                            </div>

                                        </div>
                                    </div>
                                        <!-- /.box-body -->
                                </span>



                                    <div class="col-xs-12">
                                        <div class="box">
                                            <div class="box-header">
                                                <h3 class="box-title">DANH SÁCH SẢN PHẨM</h3>

                                            </div>
                                            <!-- /.box-header -->
                                            <div class="box-body table-responsive no-padding">
                                                <table class="table table-hover">
                                                    <tr>
                                                        <th class="thead-text">STT</th>
                                                        <th class="thead-text">Ảnh sản phẩm</th>
                                                        <th class="thead-text">Tên sản phẩm</th>
                                                        <th class="thead-text">Đơn giá</th>
                                                        <th class="thead-text">Số lượng</th>
                                                        <th class="thead-text">Thành tiền</th>
                                                    </tr>
                                                    @php
                                                        $ordinal=0;
                                                    @endphp
                                                    @foreach($products as $product)
                                                        @php
                                                            $ordinal++;
                                                        @endphp
                                                        <tr>
                                                            <td class="thead-text">{{$ordinal}}</td>
                                                            <td class="thead-text">
                                                                <div class="thumb">

                                                                    <img src="{{asset($product->image)}}" class="img-thumbnail" width="100" alt="">
                                                                </div>
                                                            </td>
                                                            <td class="thead-text">{{$product->name}}</td>
                                                            <td class="thead-text">{{number_format($product->price)}} VNĐ</td>
                                                            <td class="thead-text">{{$qty[$ordinal-1]}}</td>
                                                            <td class="thead-text">{{number_format($product->price * $qty[$ordinal-1])}} VNĐ</td>
                                                        </tr>
                                                    @endforeach
                                                </table>
                                            </div>
                                            <!-- /.box-body -->
                                        </div>
                                        <!-- /.box -->
                                    </div>



                                </figure>
                                <div class=" float-right d-block"  style="padding:10px;margin: 10px">
                                    <a href="{{url('/')}}" class="btn btn-danger btn-check"> Quay lại trang chủ</a>
                                </div>
                           @else
                            <figure class="left-sec" >
                                <span class="green-t" style="padding:10px 10px ">Cảm ơn bạn đã mua hàng!</span>
                                <form action="" style="padding:10px 10px ">
                                    <label for="code">Mời quý khách nhập mã vận đơn để tra cứu (VD: DT-1606,DT-1239)</label>
                                    <div class="input-group mt-2">
                                        <input type="text"  name="code" id="code" class="form-control" value="{{request()->input('code')}}" required>
                                        <button  class="btn btn-danger btn-check">Tìm đơn hàng</button>
                                    </div>
                                </form>
                            </figure>
                            @endif
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
