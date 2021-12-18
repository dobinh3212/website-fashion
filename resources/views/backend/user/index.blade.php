@extends('backend.layout.main')
@section('title', 'Danh sách thành viên')
@section('main-content')
    <section class="content-header">
        <h1>
            Danh Sách Người Dùng <a href="{{route('admin.user.create')}}" class="btn btn-info pull-right"><i class="fa fa-plus"></i> Thêm User</a>
        </h1>
    </section>
    <section class="content">
        @include('sweetalert::alert')
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <div class="box-tools">
                            <div class="input-group input-group-sm hidden-xs" style="width: 150px;">
                                <input type="text" name="table_search" class="form-control pull-right"
                                       placeholder="Search">

                                <div class="input-group-btn">
                                    <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body table-responsive no-padding">
                        <div class="analytic " style="margin: 5px">

                            <a href="{{request()->fullUrlWithQuery(['status'=>'active'])}}" class="text-primary">Kích Hoạt<span class="text-muted"> ({{$count[0]}})</span></a>
                            <a href="{{request()->fullUrlWithQuery(['status'=>'trash'])}}" class="text-primary"> | Vô hiệu hóa<span class="text-muted"> ({{$count[1]}})</span></a>
                        </div>
                        <form action="{{route('admin.user.action')}}" method="">
                            <div class="form-action form-inline py-3 ">
                                @if (Auth::user()->can('sua-thanh-vien'))
                                <select class="form-control mr-1" name="act" id="">
                                    <option value="">Chọn</option>
                                    @foreach($list_act as $k =>$act)
                                        <option value="{{$k}}"> {{$act}}</option>
                                    @endforeach
                                </select>
                                @endif
                                <input type="submit" name="btn-search" value="Áp dụng" class="btn btn-primary">
                            </div>
                        <table class="table table-hover">
                            <tbody>
                            <tr>
                                <th>
                                    <input name="checkall"  id="checkall" value="" type="checkbox">
                                </th>
                                <th>ID</th>
                                <th>Họ & Tên</th>
                                <th>Email</th>
                                <th>Hình ảnh</th>
                                <th>Phân Quyền</th>
                                <th>Trạng thái</th>
                                <th>Hành động</th>
                            </tr>
                            </tbody>
                            <!-- Lặp một mảng dữ liệu pass sang view để hiển thị -->
                            @foreach($data as $key => $item)
                                <tr class="">
                                    <td ><input type="checkbox" name="list_check[]" value="{{$item->id}}"></td>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $item->name }}</td>
                                    <td>{{ $item->email }}</td>
                                    <td>
                                    @if ($item->avatar) <!-- Kiểm tra hình ảnh tồn tại -->
                                        <img src="{{asset($item->avatar)}}" width="90" height="90">
                                        @endif
                                    </td>
                                    <td>{{ optional($item->role)->name }}</td>
                                    <td>{{ ($item->is_active == 1) ? 'Kích hoạt' : 'Vô hiệu hóa' }}</td>
                                    <td >
                                        @if (Auth::user()->can('sua-thanh-vien'))
                                            <a href="{{ route('admin.user.edit',$item->id) }}" class="btn btn-primary"><i class="fa fa-edit" style="font-style:17px!important;" aria-hidden="true"></i></a>
                                        @endif
                                            @if (Auth::user()->can('xoa-thanh-vien'))
                                                @if (Auth::id() != $item->id and $item->role->name != 'admin')

                                                    <a  href="javascript:void(0)"   title="Xóa"   class="confirmDelete btn btn-danger" record="user" recordid="{{$item->id}}">
                                                        <i class="fa fa-trash"></i>
                                                    </a>
                                                @endif
                                            @endif
                                    </td>
                                </tr>
                            @endforeach
                        </table>
                        </form>
                        <div class="text-center " style="margin-bottom: 10px!important;" >
                            {{$data->links()}}
                        </div>
                </div>
            </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </div>
        </div>
        <!-- /.row -->
    </section>
@endsection
@section('scripts')
    <script>
        $("#checkall").click(function(){
            $('input:checkbox').not(this).prop('checked', this.checked);
        });
    </script>
@stop
