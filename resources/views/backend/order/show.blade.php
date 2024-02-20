
@extends('backend.layout.main')
@section('main-content')
    <!-- Content Header (Page header) -->
    <section class="content-header">

        <h1>
            THÔNG TIN ĐƠN HÀNG
            <span class="  text-white-50 ">
                <a href="{{ route('admin.order.index') }}" class="btn btn-primary"><i class="fa fa-list"></i> Hóa Đơn</a>
            </span>
        </h1>

    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-5">
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">Thông tin đơn hàng</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body" >
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
                <!-- /.box -->

                <!-- /.box -->
            </div>
            <!-- /.col -->
            <div class="col-md-4">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">THÔNG TIN KHÁCH HÀNG</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body no-padding">

                        <div class="col-md-6">
                            <div class="title">
                                <i class="fa fa-user text-primary"></i>
                                <strong style="font-size:18px!important;">Tên khách hàng</strong>
                            </div>
                            <div class="content " style="min-height: 30px!important;">
                                {{$order->name}}
                            </div>
                        </div>
                        <div class="col-md-6 " >
                            <div class="title">
                                <i class="fa fa-barcode text-primary ml-3 "></i>
                                <strong style="font-size:18px!important;" >Điện thoại</strong>
                            </div>
                            <div class="content " style="min-height:  30px!important;">
                                {{$order->phone}}
                            </div>
                        </div>
                        <div class="col-md-6 ">
                            <div class="title">
                                <i class="fa fa-envelope-o text-primary mr-1"></i>
                                <strong style="font-size:18px!important;">Email</strong>
                            </div>
                            <div class="content " style="min-height:  30px!important;">
                                {{$order->email}}
                            </div>
                        </div>

                        <div class="col-md-6 ">
                            <div class="title">
                                <i class="fa fa-truck text-primary mr-1"></i>
                                <strong style="font-size:18px!important;">Ghi chú</strong>
                            </div>
                            <div class="content " style="min-height:  30px!important;" >
                                {!!$order->	note!!}
                            </div>
                        </div>
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </div>
            <div class="col-md-3">
                <div class="box">
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
                                <strong style="font-size:18px!important;">   Tổng giá trị:</strong>
                            </div>
                            <div class="content text-danger font-weight-bold  " style="min-height: 20px!important;" >
                                {{number_format($order->total)}} VNĐ
                                <span class="card pl-3   pr-4">
                                    <a  target="_blank" class="btn btn-success py-2" href="{{url('admin/print-order/'.$order->id)}}">    In hóa đơn</a>
                                </span>
                            </div>

                        </div>
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
        <div class="row">
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
        </div>
    </section>
@endsection
