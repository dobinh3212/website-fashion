
@extends('backend.layout.main')
@section('title', 'Cập Nhật Đơn Hàng')
@section('main-content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            CẬP NHẬT  ĐƠN HÀNG
            <span class="  text-white-50 ">
                <a href="{{ route('admin.order.index') }}" class="btn btn-primary"><i class="fa fa-list"></i> Hóa Đơn</a>
            </span>
        </h1>

    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <form action="{{route('admin.order.update',$order->id)}}" method="POST">
                @method('PUT')
                @csrf
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
                                        <input class="form-control" type="text" name="address" id="address" value="{{$order->address}}">
                                        @error('address')
                                        <small class="text-danger">{{$message}}</small>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6 ">
                                    <div class="title">
                                        <i class="fa fa-truck text-primary mr-1"></i>
                                        <strong style="font-size:18px!important;">Trạng thái đơn hàng</strong>
                                    </div>
                                    <div class="content " style="min-height: 20px!important;" >
                                        <div class="input-group">
                                            <select class="form-control" id="status" name="status">
                                                <option value="" selected> -- Trạng thái -- </option>
                                                @if($order->status != 'canceled')
                                                    <option value="pending"
                                                            @if($order->status =="pending")  selected='selected' @endif>Chờ duyệt
                                                    </option>
                                                    <option value="delivery"
                                                            @if($order->status =="delivery")  selected='selected' @endif>Vận chuyển
                                                    </option>
                                                    <option value="complete"
                                                            @if($order->status =="complete")  selected='selected' @endif> Hoàn Thành
                                                    </option>
                                                    <option value="confirmed"
                                                            @if($order->status =="confirmed")  selected='selected' @endif>Đã xác nhận
                                                    </option>
                                                    <option value="canceled"
                                                            @if($order->status =="canceled")  selected='selected' @endif>Bị Hủy
                                                    </option>
                                                @elseif($order->status == 'canceled')
                                                    <option class="text-danger" value="canceled"
                                                            @if($order->status =="canceled")  selected='selected' @endif>Bị Hủy
                                                    </option>
                                                @endif
                                            </select>

                                            @error('status')
                                            <small class="text-danger">{{$message}}</small>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 text-center">
                                    <button type="submit"  class="btn btn-primary text-center" name="btn-update" value="Cập nhật">Cập nhật</button>
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
                                    {{$order->fullname}}
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
                                </div>

                            </div>
                        </div>
                        <!-- /.box-body -->
                    </div>
                    <!-- /.box -->
                </div>
                <!-- /.col -->
            </form>
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
