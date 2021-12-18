@extends('backend.layout.main')
@section('title', 'Danh sách ảnh sản phẩm')
@section('main-content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Thêm  Ảnh Sản Phẩm

            <span class="  text-white-50 ">
                <a href="{{ route('admin.product.index') }}" class="btn btn-primary"><i class="fa fa-list "></i> <span class="pl-2"> Danh Sách </span>  </a>
            </span>
        </h1>

    </section>
    <!-- Main content -->
    <div class="content">
        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif
            @include('sweetalert::alert')
        <div class="row">
            <div class="box">
                <!-- left column -->
                <form role="form" method="post" action="" enctype="multipart/form-data">
                    @csrf
                    <div class="col-md-4">
                        <!-- general form elements -->
                        <div class="box box-primary">
                            <div class="box-header with-border">
                                <h3 class="box-title">Thông tin </h3>
                            </div>
                            <!-- /.box-header -->
                            <!-- form start -->
                            <div class="box-body">

                                <div class="form-group image ">
                                    <label id="avatar">Hình ảnh</label>
                                    <img id="avatar" class="thumbnail" width="250px" height="auto" src="{{asset('public/backend/dist/img/import-img.png')}}">
                                    <input id="img" type="file" name="image" class="form-control src_img">
                                    @error('image')
                                    <small class="form-text text-danger ">
                                        {{$message}}
                                    </small>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="position">Vị trí</label>
                                    <input name="position" type="number" class="form-control" id="position" min="1" value="1">
                                    @error('position')
                                    <small class="form-text text-danger ">
                                        {{$message}}
                                    </small>
                                    @enderror

                                </div>
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="is_active" value="1"> Hiển thị
                                    </label>
                                    @error('is_active')
                                    <small class="form-text text-danger ">
                                        {{$message}}
                                    </small>
                                    @enderror
                                </div>
                            </div>
                            <!-- /.box-bo
                            dy -->

                            <div class="box-footer ">
                                <button type="submit" name="btn-add" class="btn btn-primary">Thêm mới</button>
                            </div>
                        </div>

                    </div>
                    <!-- /.box -->
                </form>
                <div class="col-md-8">
                    <div class="box-body table-responsive no-padding box box-primary">
                        <div class="dataTables_length " id="example1_length" style="margin: 10px;font-size: 17px;">
                            <div class="analytic " style="margin: 5px">
                                <a href="{{ request()->fullUrlWithQuery(['status' => 'all']) }}" class="text-primary">Tất cả
                                    <span class="text-muted"> ({{ $count['all'] }}) |</span></a>
                                <a href="{{ request()->fullUrlWithQuery(['status' => 'public']) }}" class="text-primary">
                                    Hoạt Động<span class="text-muted">  ({{ $count['public'] }}) |</span></a>
                                <a href="{{ request()->fullUrlWithQuery(['status' => 'pending']) }}" class="text-primary">Chờ
                                    duyệt<span class="text-muted" >  ({{ $count['pending'] }}) | </span></a>
                                <a href="{{ request()->fullUrlWithQuery(['status' => 'trash']) }}" class="text-primary">Vô
                                    hiệu hóa<span class="text-muted">  ({{ $count['trash'] }}) |</span></a>
                            </div>
                            <form action="{{ route('admin.image.action', ['id' => $product_id]) }}">
                                <div class="form-action form-inline py-3 ">
                                    <select class="form-control mr-1" name="act" id="">
                                        <option>Chọn</option>
                                        @foreach ($list_act as $key => $val)
                                            <option value="{{ $key }}">{{ $val }}</option>
                                        @endforeach
                                    </select>
                                    <input type="submit" name="btn-search" value="Áp dụng" class="btn btn-primary">
                                </div>
                                <table class="table table-hover table-checkall" style="align-items: center">
                                    <tr>
                                        <th>
                                            <input name="checkall"  id="checkall" value="" type="checkbox">
                                        </th>
                                        <th>ID</th>
                                        <th>Hình Ảnh</th>
                                        <th>Vị trí</th>
                                        <th>Trạng thái</th>
                                        <th>Ngày tạo</th>
                                        <th>Hành động</th>
                                    </tr>
                                                                    @if($productImages->total()>0)
                                                                        @foreach($productImages as $key => $row)
                                                                            <tr>
                                                                                <td><input type="checkbox" name="list_check[]" value="{{$row->id}}"></td>
                                                                                <td>{{ $key + 1 }}</td>
                                                                                <td><img width="80" src="{{asset($row->	image)}}" alt=""></td>
                                                                                <td> {{$row->position}}</td>
                                                                                <td> @if($row->is_active ==1 )
                                                                                        <span class=" badge bg-light-blue"> Hoạt động </span>
                                                                                    @elseif($row->is_active ==0)
                                                                                        <span class="   badge bg-info" >  Chờ duyệt</span>
                                                                                    @endif</td>
                                                                                <td>  {{$row->created_at}}</td>
                                                                                <td>
                                                                                    @if (request()->status != 'trash')
                                                                                    <button class="btn btn-danger  rounded-0 text-white" type="button"
                                                                                            data-placement="top" title="Delete" data-toggle="modal"
                                                                                            data-target="#modal-confirm-{{$row->id}}">Xóa
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
                                                                                                <div class='modal-body text-danger'>Bạn muốn xóa  danh mục này !
                                                                                                </div>
                                                                                                <div class='modal-footer'>
                                                                                                    <button type='button' class='btn btn-secondary' data-dismiss='modal'>Đóng</button>
                                                                                                    <a href="{{route('admin.image.delete',$row->id)}}" class='btn btn-primary'>Xác Nhận</a>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                    @endif
                                                                                </td>

                                                                            </tr>
                                                                        @endforeach
                                                                    @else
                                                                        <td colspan="9"> Không có bản ghi nào !!</td>
                                                                    @endif
                                </table>
                            </form>
                            <div class="text-center">
                                {{ $productImages->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>


        </div>
    </div>
    </section>

@endsection
@section('scripts')
    <script>
        (function( $ ){
            function changeImg(input) {
                //Nếu như tồn thuộc tính file, đồng nghĩa người dùng đã chọn file mới
                if (input.files && input.files[0]) {
                    var reader = new FileReader();
                    //Sự kiện file đã được load vào website
                    reader.onload = function (e) {
                        //Thay đổi đường dẫn ảnh
                        $('.form-group.image .thumbnail').attr('src', e.target.result);
                    }
                    reader.readAsDataURL(input.files[0]);
                }
            }
            function load_image(){
                var src_img = $(".form-group.image .src_img")
                $(src_img).change(function(){
                    if (this.files && this.files[0]) {
                        var reader = new FileReader();
                        //Sự kiện file đã được load vào website
                        reader.onload = function (e) {
                            //Thay đổi đường dẫn ảnh
                            $('.form-group.image .thumbnail').attr('src', e.target.result);
                        }
                        reader.readAsDataURL(this.files[0]);
                        console.log(this.files);
                    }
                })

            }

            $(document).ready(function(){
                load_image();
                $("input[name='checkall']").click(function () {
                    var checked = $(this).is(":checked");
                    $(".table-checkall tbody tr td input:checkbox").prop(
                        "checked",
                        checked
                    );
                });
            })
        })( jQuery );
    </script>
@stop
