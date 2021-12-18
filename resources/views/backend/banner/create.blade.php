@extends('backend.layout.main')
@section('title', 'Thêm thư viện')
@section('main-content')
    <section class="content-header">
        <h1>
            Thêm mới Banner <span class="  text-white-50 ">
                <a href="{{ route('admin.banner.index') }}" class="btn btn-primary"><i class="fa fa-list "></i> <span class="pl-2"> Danh Sách </span>  </a>
            </span>
        </h1>
    </section>
    <section class="content">
        <div class="row">
            <form role="form" action="{{route('admin.banner.store')}}" method="post" enctype="multipart/form-data">
            @csrf
            <!-- left column -->
            <div class="col-md-8">
                <!-- general form elements -->
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Thông tin </h3>
                    </div>
                    <!-- /.box-header -->
                    <!-- form start -->

                        <div class="box-body">

                            <div class="form-group">
                                <label for="exampleInputEmail1">Tiêu đề <span style="color: red">*</span></label>
                                <input type="text" class="form-control" value="{{old('title')}}" id="title" name="title" placeholder="Nhập tên tiêu đề">
                                @error('title')
                                <small class="form-text text-danger ">
                                    {{$message}}
                                </small>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="exampleInputEmail1">Tùy chỉnh liên kết Url</label>
                                <input type="text" class="form-control" id="url" value="{{old('url')}}" name="url" placeholder="Url">
                                @error('url')
                                <small class="form-text text-danger ">
                                    {{$message}}
                                </small>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>Target</label>
                                <select class="form-control" name="target">
                                    <option value="1">_blank</option>
                                    <option value="2">_self</option>
                                </select>
                                @error('target')
                                <small class="form-text text-danger ">
                                    {{$message}}
                                </small>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>Loại <span style="color: red">*</span> </label>
                                <select class="form-control" name="type">
                                    <option value="1">slide</option>
                                    <option value="2">background</option>
                                    <option value="2">banner right</option>
                                </select>
                            </div>
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" value="1" name="is_active"> Trạng thái hiển thị
                                </label>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Vị trí</label>
                                <input type="number" class="form-control" id="position" name="position" value="0">
                                @error('position')
                                <small class="form-text text-danger ">
                                    {{$message}}
                                </small>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>Mô tả</label>
                                <textarea id="editor1" name="description" class="form-control" rows="10" placeholder="Enter ..."></textarea>
                            </div>
                        </div>
                        <!-- /.box-body -->

                        <div class="box-footer">
                            <button type="submit" name="btn-add" class="btn btn-primary">Thêm mới</button>
                        </div>

                </div>
                <!-- /.box -->

            </div>
            <div class="col-md-4">
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
            </div>
            <!--/.col (right) -->
            </form>
        </div>
        <!-- /.row -->
    </section>
@endsection
@section('scripts')
    <script type="text/javascript">
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
                // setup textarea sử dụng plugin CKeditor
                var _ckeditor = CKEDITOR.replace('editor1');
                _ckeditor.config.height = 300; // thiết lập chiều cao
            })
        })( jQuery );
    </script>

@endsection
