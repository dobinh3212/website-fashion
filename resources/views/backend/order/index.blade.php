
@extends('backend.layout.main')
@section('title', 'Danh sách  Đơn Hàng')
@section('main-content')
    <!-- Content Header (Page header) -->
    <section class="content-header  d-flex  justify-content-between align-items-center">
        <h1>
            Quản Lý Đơn Hàng
        </h1>

    </section>
    <!-- Main content -->
    <section class="content">
        @include('sweetalert::alert')
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Danh Sách</h3>

                        <div class="box-tools">
                            <form action="" method="get">
                                <div class="input-group input-group-sm hidden-xs" style="width: 300px;">

                                    <input type="text" name="keyword" value="{{request()->input('keyword')}}" class="form-control pull-right" placeholder="Tìm Kiếm">

                                    <div class="input-group-btn">
                                        <button type="submit" name="btn-search" value="Tìm kiếm" class="btn btn-default"><i class="fa fa-search"></i></button>
                                    </div>

                                </div>
                            </form>
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body table-responsive no-padding">
                        <div class="dataTables_length " id="example1_length" style="margin: 10px;font-size: 17px;">
                        <div class="analytic " style="margin: 5px">
                            <a href="{{route('admin.order.index')}}" class="text-primary">Tất cả <span class="text-muted">({{$count[0]}})</span></a>
                            <a href="{{request()->fullUrlwithQuery(['status'=>'complete'])}}" class="text-primary"> |Hoàn thành <span class="text-muted">({{$count[1]}})</span></a>
                            <a href="{{request()->fullUrlwithQuery(['status'=>'confirmed'])}}" class="text-primary">| Đã xác nhận <span class="text-muted">({{$count[2]}})</span></a>
                            <a href="{{request()->fullUrlwithQuery(['status'=>'pending'])}}" class="text-primary">| Chờ duyệt <span class="text-muted">({{$count[3]}})</span></a>
                            <a href="{{request()->fullUrlwithQuery(['status'=>'delivery'])}}" class="text-primary">| Vận chuyển <span class="text-muted">({{$count[4]}})</span></a>
                            <a href="{{request()->fullUrlwithQuery(['status'=>'canceled'])}}" class="text-primary">| Hủy <span class="text-muted">({{$count[5]}})</span></a>
                        </div>
                        <form action="{{route('admin.category.action')}}" method="">
                            <div class="form-action form-inline py-3 " style="padding: 10px;">
                                @if (Auth::user()->can('cap-nhat-don-hang'))
                                    <select class="form-control mr-1" name="act" id="">
                                        <option>Chọn</option>
                                        @foreach($list_act as $k =>$act)
                                            <option value="{{$k}}"> {{$act}}</option>
                                        @endforeach
                                    </select>
                                @endif
                                <input type="submit" name="btn-search" value="Áp dụng" class="btn btn-primary">
                            </div>
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
                            @foreach($data as $key => $row)
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
                                        <a  href="javascript:void(0)"   title="Xóa"   class="confirmDelete btn btn-danger" record="order" recordid="{{$row->id}}">
                                            <i class="fa fa-trash"></i>
                                        </a>

                                    </td>

                                </tr>
                            @endforeach
                        </table>
                        </form>
                        </div>
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </div>
        </div>
    </section>
    <!-- /.content -->
@endsection
