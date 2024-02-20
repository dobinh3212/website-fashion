@extends('backend.layout.main')
@section('title', 'Thêm thương hiệu')
@section('main-content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Thêm  Thương Hiệu

            <span class="  text-white-50 ">
                <a href="{{ route('admin.brand.index') }}" class="btn btn-primary"><i class="fa fa-list "></i> <span class="pl-2"> Danh Sách </span>  </a>
            </span>
        </h1>

    </section>
    <!-- Main content -->
    <div class="content">
        <div class="row">
            <!-- left column -->
            <form role="form" method="post" action="{{route('admin.brand.store')}} " enctype="multipart/form-data">
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
                                <label for="name">Tên Thương Hiệu <span class="text-danger">*</span> </label>
                                <input name="name" type="text" class="form-control"  id="name" value="{{old('name')}}" placeholder="Nhập Tên Thương Hiệu">
                                @error('name')
                                <small class="form-text text-danger ">
                                    {{$message}}
                                </small>
                                @enderror
                            </div>
                            <div class="form-group image ">
                                <label id="avatar">Hình ảnh</label>
                                <img id="avatar" class="thumbnail" width="250px" height="auto" src="{{asset('/backend/dist/img/import-img.png')}}">
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
