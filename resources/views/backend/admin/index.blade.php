@extends('backend.layout.main')
@section('main-content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Dashboard
            <small>FASHION</small>
        </h1>
    </section>

    <!-- Main content -->
    <section class="content">
        <!-- Small boxes (Stat box) -->
        <div class="row">
            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-aqua">
                    <div class="inner">
                        <h3>{{$count[2]}}</h3>

                        <p>Đơn hàng thành công</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-truck"></i>
                    </div>
                    <a href="{{route('admin.order.index')}}" class="small-box-footer">Chi tiết <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>

            <!-- ./col -->
            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-red">
                    <div class="inner">
                        <h3>{{$count[0]}}</h3>

                        <p>Đang Xử Lý</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-pie-graph"></i>
                    </div>
                    <a href="{{route('admin.order.index')}}" class="small-box-footer">Chi tiết <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>


            <!-- ./col -->
            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-green">
                    <div class="inner">
                        <h4>{{number_format($proceeds,0,'đ','.')}} VNĐ</h4>

                        <p style="padding-top:10px ">Doanh Thu hệ thống</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-stats-bars"></i>
                    </div>
                    <a href="{{url('admin/statistic')}}" class="small-box-footer">Chi tiết <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box  bg bg-black " >
                    <div class="inner">
                        <h3>{{$count[1]}}</h3>

                        <p>Đơn hàng bị hủy</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-times"></i>
                    </div>
                    <a href="{{route('admin.order.index')}}" class="small-box-footer">Chi tiết <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
        </div>
        <!-- /.row -->
        <!-- Main row -->
        <div class="row">
            <div class="box-body table-responsive no-padding">
                <table class="table table-hover">
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Mã</th>
                        <th scope="col">Khách hàng</th>
                        <th scope="col" >Điện thoại</th>
                        <th scope="col">Địa chỉ</th>
                        <th scope="col">Trạng thái</th>
                        <th scope="col">Thời gian</th>
                        <th scope="col">Tác vụ</th>
                    </tr>
                    @foreach($orders as $key => $row)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td><a href="{{route('admin.order.show',$row->id)}}">{{$row->code}}</a></td>
                            <td>
                                {{$row->fullname}}<br>
                            </td>
                            <td>{{$row->phone}}</td>
                            <td><a href="{{route('admin.order.edit',$row->id)}}">{{$row->address}}</a></td>
                            <td><span class="  @if($row->status == 'pending') badge bg-yellow text-black
                                       @elseif($row->status == 'delivery') badge bg-red
                                        @elseif($row->status == 'complete')badge bg-green
                                        @elseif($row->status == 'confirmed') badge bg-light-blue

                                        @else  badge badge-dark

                                       @endif">
                                           @if($row->status =="pending")   Chờ duyệt
                                    @elseif($row->status =="delivery") Vận chuyển
                                    @elseif($row->status =="complete")   Hoàn Thành
                                    @elseif($row->status =="confirmed") Đã xác nhận
                                    @else Bị hủy
                                    @endif
                                        </span></td>
                            <td>{{$row->created_at}}</td>
                            <td>
                                <a href="{{ route('admin.order.edit',$row->id) }}" class="btn btn-primary"><i class="fa fa-edit" style="font-style:17px!important;" aria-hidden="true"></i></a>

                                <button class="btn btn-danger  rounded-0 text-white" type="button"
                                        data-placement="top" title="Delete" data-toggle="modal"
                                        data-target="#modal-confirm-{{$row->id}}"> <i class="fa fa-trash"></i>
                                </button>
                                <div class='modal fade' id='modal-confirm-{{$row->id}}' tabindex='-1' role='dialog' aria-labelledby='exampleModalLabel'
                                     aria-hidden='true'>
                                    <div class='modal-dialog' role='document'>
                                        <div class='modal-content'>
                                            <div class='modal-header'>
                                                <h5 class='modal-title' id='exampleModalLabel'>Thông báo
                                                    <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                                                        <span aria-hidden='true'>&times;</span>
                                                    </button>
                                                </h5>

                                            </div>
                                            <div class='modal-body text-danger'>Bạn muốn xóa vĩnh viễn danh mục này !
                                            </div>
                                            <div class='modal-footer'>
                                                <form action="{{ route('admin.order.destroy',$row->id ) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type='button' class='btn btn-secondary' data-dismiss='modal'>Đóng</button>
                                                    <button type="submit" class="btn btn-primary">Xác nhận</button>

                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </td>

                        </tr>
                    @endforeach
                </table>
            </div>
            <!-- /.row (main row) -->

    </section>
    <!-- /.content -->
    <!-- /.content-wrapper -->
@endsection
