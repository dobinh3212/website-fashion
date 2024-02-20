@extends('backend.layout.main')
@section('title', 'Danh sách thư viện')
@section('main-content')
    <section class="content-header">
        <h1>
            Danh Sách Banner <a href="{{route('admin.banner.create')}}" class="btn btn-info pull-right"><i class="fa fa-plus"></i> Thêm Banner</a>
        </h1>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                @if(session('error'))
                    <div class="alert alert-warning">
                        {{session('error')}}
                    </div>
                @endif
                @include('sweetalert::alert')
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
                        <div class="dataTables_length " id="example1_length" style="margin: 10px;font-size: 17px;">
                            <div class="analytic " style="margin: 5px">
                                <a href="{{route('admin.banner.index')}}" class="text-primary">Tất cả<span class="text-muted"> ({{$count[0]}})</span></a>
                                <a href="{{request()->fullUrlWithQuery(['status'=>'publish'])}}" class="text-primary"> | Hoạt động<span class="text-muted"> ({{$count[1]}})</span></a>
                                <a href="{{request()->fullUrlWithQuery(['status'=>'pending'])}}" class="text-primary"> | Chờ duyệt<span class="text-muted"> ({{$count[2]}})</span></a>
                                <a href="{{request()->fullUrlWithQuery(['status'=>'trash'])}}" class="text-primary"> | Xóa tạm thời<span class="text-muted"> ({{$count[3]}})</span></a>
                            </div>
                            <form action="{{route('admin.banner.action')}}" method="">
                                <div class="form-action form-inline py-3 ">
                                    <select class="form-control mr-1" name="act" id="">
                                        <option>Chọn</option>
                                        @foreach($list_act as $k =>$act)
                                            <option value="{{$k}}"> {{$act}}</option>
                                        @endforeach
                                    </select>
                                    <input type="submit" name="btn-search" value="Áp dụng" class="btn btn-primary">
                                </div>
                        <table class="table table-hover">
                            <tbody>
                            <tr>
                                <th>
                                    <input name="checkall"  id="checkall" value="" type="checkbox">
                                </th>
                                 <th>ID</th>
                                <th>Tiêu đề</th>
                                <th>Hình ảnh</th>
                                <th>Target</th>
                                <th>Loại</th>
                                <th>Vị trí</th>
                                <th>Trạng thái</th>
                                <th >Hành động</th>
                            </tr>
                            </tbody>
                            <!-- Lặp một mảng dữ liệu pass sang view để hiển thị -->
                            @if($data->total()>0)
                            @foreach($data as $key => $item)
                                <tr> <!-- Thêm Class Cho Dòng -->
                                    <td><input type="checkbox" name="list_check[]" value="{{$item->id}}"></td>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $item->title }}</td>
                                    <td>
                                    @if ($item->image)
                                        <img src="{{asset($item->image)}}" width="150" >
                                        @endif
                                    </td>
                                    <td>{{ ($item->target == 1) ? '_blank' : '_self' }}</td>
                                    <td>{{ ($item->type == 1) ? 'slide' : 'background' }}</td>
                                    <td>{{ $item->position }}</td>
                                    <td>
                                        @if($item->is_active ==1 )
                                            <span class="badge bg-light-blue"> Hoạt động </span>
                                        @elseif($item->is_active==0)
                                            <span class="badge bg-info" >  Chờ duyệt</span>
                                        @endif</td>
                                    <td>
                                        <a href="{{ route('admin.banner.edit',$item->id) }}" class="btn btn-primary"><i class="fa fa-edit" style="font-style:17px!important;" aria-hidden="true"></i></a>
                                        <a  href="javascript:void(0)"   title="Xóa"   class="confirmDelete btn btn-danger" record="banner" recordid="{{$item->id}}">
                                            <i class="fa fa-trash"></i>
                                        </a>


                                    </td>
                                </tr>
                            @endforeach
                            @else
                                <td colspan="8"> Không có bản ghi nào !!</td>
                            @endif
                        </table>
                            </form>
                        </div>
                    </div>
                        <div class="text-center">
                            {{$data->links()}}
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
