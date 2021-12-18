@extends('backend.layout.main')
@section('title', 'Cập nhật thương hiệu')
@section('main-content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Cập Nhật  Thương Hiệu

            <span class="  text-white-50 ">
                <a href="{{ route('admin.brand.index') }}" class="btn btn-primary"><i class="fa fa-list "></i> <span class="pl-2"> Danh Sách </span>  </a>
            </span>
        </h1>

    </section>
    <!-- Main content -->
    <div class="content">
        <div class="row">
            <!-- left column -->
            <form role="form" method="post" action="{{route('admin.brand.update',$data->id)}} " enctype="multipart/form-data">
                @method('PUT')
                @csrf

                <div class="col-md-10">
                    <!-- general form elements -->
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">Thông tin </h3>
                        </div>
                        <!-- /.box-header -->
                        <!-- form start -->

                        <div class="box-body">
                            <div class="form-group">
                                <label for="name">Tên Thương Hiệu </label>
                                <input name="name" type="text" class="form-control"  id="name" value="{{$data->name}}" placeholder="Nhập Tên Nhà Cung Cấp">
                                @error('name')
                                <small class="form-text text-danger ">
                                    {{$message}}
                                </small>
                                @enderror
                            </div>
                            <div class="form-group image ">
                                <label id="avatar">Hình ảnh</label>
                                <img id="avatar" class="thumbnail" width="250px" height="auto" src="{{asset($data->image)}}">
                                <input id="img" type="file" name="image" class="form-control src_img"   >
                                @error('image')
                                <small class="form-text text-danger ">
                                    {{$message}}
                                </small>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="position">Vị trí</label>
                                <input name="position" type="number" class="form-control"  id="position" min="1" value="{{$data->position}}">
                                @error('position')
                                <small class="form-text text-danger ">
                                    {{$message}}
                                </small>
                                @enderror

                            </div>
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox"  {{ $data->is_active == 1 ? 'checked' : '' }} name="is_active" value="1"> Hiển thị
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
                            <button type="submit" name="btn-update" class="btn btn-primary">Cập nhật</button>
                        </div>
                    </div>

                </div>
                <!-- /.box -->
            </form>
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

            })
        })( jQuery );
    </script>
@stop
