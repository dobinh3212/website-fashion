@extends('backend.layout.main')
@section('title', 'Cập nhật thư viện')
@section('main-content')
    <section class="content-header">
        <h1>
            Cập Nhật Banner <span class="  text-white-50 ">
                <a href="{{ route('admin.banner.index') }}" class="btn btn-primary"><i class="fa fa-list "></i> <span class="pl-2"> Danh Sách </span>  </a>
            </span>
        </h1>
    </section>
    <section class="content">
        <div class="row">
            <form role="form" action="{{route('admin.banner.update',$banner->id)}}" method="post" enctype="multipart/form-data">
            @csrf
            @method('PUT')
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
                                <input type="text" class="form-control" value="{{$banner->title }}" id="title" name="title" placeholder="Nhập tên tiêu đề">
                                @error('title')
                                <small class="form-text text-danger ">
                                    {{$message}}
                                </small>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="exampleInputEmail1">Tùy chỉnh liên kết Url</label>
                                <input type="text" class="form-control" id="url" value="{{ $banner->url }}" name="url" placeholder="Url">
                                @error('url')
                                <small class="form-text text-danger ">
                                    {{$message}}
                                </small>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>Target</label>
                                <select class="form-control" name="target">
                                    <option {{ ($banner->target == 1) ? 'selected' : '' }} value="1">_blank</option>
                                    <option   {{ ($banner->target == 2) ? 'selected' : '' }} value="2">_self</option>
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
                                    <option  {{ ($banner->type == 1) ? 'selected' : '' }}  value="1">slide</option>
                                    <option {{ ($banner->type == 2) ? 'selected' : '' }}  value="2">background</option>
                                    <option {{ ($banner->type == 3) ? 'selected' : '' }}  value="2">banner right</option>
                                </select>
                            </div>
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" value="1" {{ ($banner->is_active == 1) ? 'checked' : '' }}  name="is_active"> Trạng thái hiển thị
                                </label>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Vị trí</label>
                                <input type="number" class="form-control" id="position"  name="position" value="{{ $banner->position }}">
                                @error('position')
                                <small class="form-text text-danger ">
                                    {{$message}}
                                </small>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>Mô tả</label>
                                <textarea id="editor1" name="description" class="form-control" rows="10" placeholder="Enter ...">
                                    {!! $banner->description !!}
                                </textarea>
                            </div>
                        </div>
                        <!-- /.box-body -->

                        <div class="box-footer">
                            <button type="submit" name="btn-update" class="btn btn-primary">Cập Nhật</button>
                        </div>

                    </div>
                    <!-- /.box -->

                </div>
                <div class="col-md-4">
                    <div class="form-group image ">
                        <label id="avatar">Hình ảnh</label>
                        <img id="avatar" class="thumbnail" width="250px" height="auto" src="{{asset($banner->image)}}">
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
