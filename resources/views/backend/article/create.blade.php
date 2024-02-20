@extends('backend.layout.main')
@section('title', 'Thêm bài viết')
@section('main-content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Thêm  Bài Viết

            <span class="  text-white-50 ">
                <a href="{{ route('admin.article.index') }}" class="btn btn-primary"><i class="fa fa-list "></i> <span class="pl-2"> Danh Sách </span>  </a>
            </span>
        </h1>

    </section>
    <!-- Main content -->
    <div class="content">
        <div class="row">
            <!-- left column -->
            <form role="form" method="post" action="{{route('admin.article.store')}} " enctype="multipart/form-data">
                @csrf
                <div class="col-md-7">
                    <!-- general form elements -->
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">Thông tin </h3>
                        </div>
                        <!-- /.box-header -->
                        <!-- form start -->
                        <div class="box-body">
                            <div class="form-group">
                                <label for="title">Tên Bài Viết(<span style="color: red">*</span>)</label>
                                <input name="title" type="text" class="form-control"  id="title" value="{{old('title')}}" placeholder="Nhập Tên Bài Viết">
                                @error('title')
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
                            <div class="row">
                                <div class="col-md-6 form-group">
                                    <div class="form-group image ">
                                        <label id="avatar">Hình ảnh</label>
                                        <img id="avatar" class="thumbnail" width="300px" height="auto" src="{{asset('/backend/dist/img/import-img.png')}}">
                                        <input id="img" type="file" name="image" class="form-control src_img">
                                        @error('image')
                                        <small class="form-text text-danger ">
                                            {{$message}}
                                        </small>
                                        @enderror
                                    </div>
                                </div>

                            </div>

                            <div class="form-group">
                                <label for="description">Chi tiết bài viết(<span style="color: red">*</span>)</label>
                                <textarea name="description" class="form-control" id="description" cols="30" rows="5">{{old('description')}}</textarea>
                                @error('description')
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
                        <!-- /.box-body -->
                        <div class="box-footer ">
                            <button type="submit" name="btn-add" class="btn btn-primary">Thêm mới</button>
                        </div>
                    </div>
                </div>
                <!-- /.box -->

                <div class="col-md-5">

                    <div class="form-group">
                        <label for="summary">Mô tả bài viết(<span style="color: red">*</span>)</label>
                        <textarea name="summary" class="form-control" id="summary" cols="30" rows="5">{{old('summary')}}</textarea>
                    </div>
                    @error('summary')
                    <small class="form-text text-danger ">
                        {{$message}}
                    </small>
                    @enderror


                </div>

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
                var _ckeditor1 = CKEDITOR.replace('description');
                // _ckeditor1.config.height = 200; // thiết lập chiều cao
                var _ckeditor2 = CKEDITOR.replace('summary');
                //_ckeditor2.config.height = 650; // thiết lập chiều cao
            })
        })( jQuery );
    </script>
@stop
