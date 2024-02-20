@extends('backend.layout.main')
@section('title', 'Danh sách danh mục')
@section('main-content')
    <!-- Content Header (Page header) -->
    <section class="content-header  d-flex  justify-content-between align-items-center">
        <h1>
            Quản Lý Danh Mục
            <span class="  text-white-50 ">
                <a href="{{ route('admin.category.create') }}" class="btn btn-primary"><i class="fa fa-plus-square"></i> Thêm Danh Mục</a>
            </span>

        </h1>
    </section>
    <!-- Main content -->
    <section class="content">
        @if(session('error'))
            <div class="alert alert-warning">
                {{session('error')}}
            </div>
        @endif
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
                                <a href="{{route('admin.category.index')}}" class="text-primary">Tất cả<span class="text-muted"> ({{$count[0]}})</span></a>
                                <a href="{{request()->fullUrlWithQuery(['status'=>'publish'])}}" class="text-primary"> | Hoạt động<span class="text-muted"> ({{$count[1]}})</span></a>
                                <a href="{{request()->fullUrlWithQuery(['status'=>'pending'])}}" class="text-primary"> | Chờ duyệt<span class="text-muted"> ({{$count[2]}})</span></a>
                                <a href="{{request()->fullUrlWithQuery(['status'=>'trash'])}}" class="text-primary"> | Xóa tạm thời<span class="text-muted"> ({{$count[3]}})</span></a>
                            </div>
                            <form action="{{route('admin.category.action')}}" method="">
                                <div class="form-action form-inline py-3 " style="padding: 10px;">
                                    @if (Auth::user()->can('sua-danh-muc-san-pham'))
                                    <select class="form-control mr-1" name="act" id="">
                                        <option>Chọn</option>
                                        @foreach($list_act as $k =>$act)
                                            <option value="{{$k}}"> {{$act}}</option>
                                        @endforeach
                                    </select>
                                    @endif
                                    <input type="submit" name="btn-search" value="Áp dụng" class="btn btn-primary">
                                </div>
                        <table class="table table-hover d-block mt-3">
                            <tr>
                                <th>
                                    <input name="checkall"  id="checkall" value="" type="checkbox">
                                </th>
                                <th>ID</th>
                                <th>Tên dạnh mục</th>
                                <th>Logo</th>
                                <th>Vị trí</th>
                                <th>Trạng thái</th>
                                <th>Ngày tạo</th>
                                <th>Hành động</th>
                            </tr>

                            @foreach($data as $key => $row)
                                <tr>
                                    <td><input type="checkbox" name="list_check[]" value="{{$row->id}}"></td>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{str_repeat('-- ', $row->level).' '.$row->name}}</td>
                                    <td>
                                        <img width="80" height="80"  src="{{asset($row->image)}}" alt="">
                                    </td>
                                    <td>{{ $row->position }}</td>
                                    <td> @if($row->is_active ==1 )
                                            <span class=" badge bg-light-blue"> Hoạt động </span>
                                        @elseif($row->is_active ==0)
                                            <span class="   badge bg-info" >  Chờ duyệt</span>
                                        @endif</td>
                                    <td>{{ $row->created_at }}</td>
                                    <td>
                                        @if (Auth::user()->can('sua-danh-muc-san-pham'))

                                            <a href="{{ route('admin.category.edit',$row->id) }}" class="btn btn-primary"><i class="fa fa-edit" style="font-style:17px!important;" aria-hidden="true"></i></a>
                                        @endif
                                            @if (Auth::user()->can('xoa-danh-muc-san-pham'))
                                                <a  href="javascript:void(0)"   title="Xóa"   class="confirmDelete btn btn-danger" record="category" recordid="{{$row->id}}">
                                                    <i class="fa fa-trash"></i>
                                                </a>
                                            @endif
                                    </td>
                                </tr>
                            @endforeach

                        </table>
                    </form>

                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </div>
        </div>
    </section>
    <!-- /.content -->
@endsection
@section('scripts')
    <script>
        $("#checkall").click(function(){
            $('input:checkbox').not(this).prop('checked', this.checked);
        });
    </script>
@stop
