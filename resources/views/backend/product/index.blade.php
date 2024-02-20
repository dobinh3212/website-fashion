@extends('backend.layout.main')
@section('title', 'Danh sách sản phẩm')
@section('main-content')
    <!-- Content Header (Page header) -->
    <section class="content-header  d-flex  justify-content-between align-items-center">
        <h1>
            Quản Lý Sản Phẩm
            <span class="  text-white-50 ">
                <a href="{{ route('admin.product.create') }}" class="btn btn-primary"><i class="fa fa-plus-square"></i> Thêm Sản Phẩm</a>
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
                        <div class="analytic " style="margin: 5px ;">
                            <a href="{{route('admin.product.index')}}" class="text-primary">Tất cả<span class="text-muted"> ({{$count[0]}})</span></a>
                            <a href="{{request()->fullUrlWithQuery(['status'=>'publish'])}}" class="text-primary"> | Hoạt động<span class="text-muted"> ({{$count[1]}})</span></a>
                            <a href="{{request()->fullUrlWithQuery(['status'=>'pending'])}}" class="text-primary"> | Chờ duyệt<span class="text-muted"> ({{$count[2]}})</span></a>
                            <a href="{{request()->fullUrlWithQuery(['status'=>'trash'])}}" class="text-primary"> | Xóa tạm thời<span class="text-muted"> ({{$count[3]}})</span></a>
                        </div>
                        <form action="{{route('admin.product.action')}}" method="">
                            <div class="form-action form-inline py-3 " style="padding-bottom:10px;padding-left: 15px;">
                                @if (Auth::user()->can('sua-san-pham'))
                                <select class="form-control mr-1" name="act" id="">
                                    <option value="">Chọn</option>
                                    @foreach($list_act as $k =>$act)
                                        <option value="{{$k}}"> {{$act}}</option>
                                    @endforeach
                                </select>

                                <input type="submit" name="btn-search" value="Áp dụng" class="btn btn-primary">
                                @endif

                            </div>
                        <table class="table table-hover">
                            <tr>
                                <th>
                                    <input name="checkall"  id="checkall" value="" type="checkbox">
                                </th>
                                <th scope="col">ID</th>
                                <th scope="col">Ảnh</th>
                                <th scope="col" style="max-width:120px">Tên sản phẩm</th>
                                <th scope="col">Ảnh chi tiết</th>
                                <th scope="col">Giá Gốc</th>
                                <th scope="col">Giá khuyến mại</th>
                                <th scope="col">Số lượng</th>
                                <th scope="col">Danh mục</th>
                                <th scope="col">Trạng thái</th>
                                <th scope="col"> Hành động</th>
                            </tr>
                            @if($data->total()>0)
                            @foreach($data as $key => $row)
                                <tr>
                                    <td ><input type="checkbox" name="list_check[]" value="{{$row->id}}"></td>
                                    <td>{{ $key + 1 }}</td>
                                    <td class="text-center">
                                        <img width="80" height="80"  src="{{ asset($row->image) }}" alt="">
                                    </td>
                                    <td  style="max-width: 200px; height: auto">{{$row->name}}</td>
                                    <td class="text-center">
                                        <a href="{{route('admin.image.index',$row->id)}}"
                                           class="btn btn-outline-info" data-toggle="tooltip" title="Ảnh chi tiết"><i
                                                class="fas fa-images"></i></a>
                                    </td>
                                    <td class="text-center">{{number_format($row->price,0,'đ','.')}} vnđ</td>
                                    <td >{{number_format($row->sale,0,'đ','.')}} vnđ</td>
                                    <td >{{$row->stock}}</td>
                                    <td class="text-center">{{ isset($row->categories) ? $row->categories->name : ''}}</td>
                                    <td > @if($row->is_active == 1)
                                            <span class=" badge bg-light-blue"> Hoạt Động </span>
                                        @elseif($row->is_active == 0)
                                            <span class="   badge bg-info" >  Chờ duyệt</span>
                                        @endif
                                        @if($row->is_hot == 1)<div class="badge bg-yellow text-black">Nổi bật </div>@endif
                                    </td>
                                    <td>
                                        @if (Auth::user()->can('sua-san-pham'))
                                            <a href="{{url('admin/product/add-attributes/'.$row->id)}}" class="btn btn-warning"><i class="fa fa-list" style="font-style:17px!important;" aria-hidden="true"></i></a>
                                        <a href="{{ route('admin.product.edit',$row->id) }}" class="btn btn-primary"><i class="fa fa-edit" style="font-style:17px!important;" aria-hidden="true"></i></a>
                                        @endif
                                            @if (Auth::user()->can('xoa-san-pham'))
                                                <a  href="javascript:void(0)"   title="Xóa"   class="confirmDelete btn btn-danger" record="product" recordid="{{$row->id}}">
                                                    <i class="fa fa-trash"></i>
                                                </a>

                                            @endif
                                    </td>

                                </tr>
                            @endforeach
                            @else
                                <td colspan="10"> Không có bản ghi nào !!</td>
                            @endif
                        </table>
                        </form>
                        <div class="text-center " style="margin-bottom: 10px!important;" >
                            {{$data->links()}}
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
@section('scripts')
    <script>
        $("#checkall").click(function(){
            $('input:checkbox').not(this).prop('checked', this.checked);
        });
    </script>




@stop
