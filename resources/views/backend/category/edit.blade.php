@extends('backend.layout.main')
@section('title', 'Cập nhật danh mục')
@section('main-content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Cập Nhật Danh Mục
            <span class="  text-white-50 ">
                <a href="{{ route('admin.category.index') }}" class="btn btn-primary"><i class="fa fa-list "></i> <span class="pl-2">   Danh Sách </span>  </a>
            </span>
        </h1>

    </section>
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <!-- left column -->
            <div class="col-md-8 d-flex justify-content-sm-between">
                <!-- general form elements -->
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Thông tin</h3>
                    </div>
                    <!-- /.box-header -->
                    <!-- form start -->
                    <form role="form" method="post" action="{{ route('admin.category.update',$data->id) }}" enctype="multipart/form-data">
                        @method('PUT')
                        @csrf
                        <div class="box-body">

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name">Tên</label>
                                        <input name="name" type="text" value="{{$data->name}}" class="form-control" id="name" placeholder="Nhập Tên">
                                        @error('name')
                                        <small class="form-text text-danger ">
                                            {{$message}}
                                        </small>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="parent_id">Danh Mục Cha  <span class="text-danger" style="font-style: italic;font-size: 13px;">
                                                         (*) Mặc định không chọn là danh mục cha
                                </span></label>
                                        <select class="form-control" name="parent_id">
                                            <option value=''>Chọn danh mục</option>
                                            @foreach($categories as $item)
                                                <option {{ $item->id == $data->id ? 'selected' : '' }} value="{{ $item->id}}" >
                                                    {{str_repeat('-- ', $item->level).' '.$item->name}}
                                                </option>
                                            @endforeach
                                        </select>

                                        @error('parent_id')
                                        <small class="form-text text-danger ">
                                            {{$message}}
                                        </small>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="position">Vị trí</label>
                                        <input name="position" type="number" class="form-control" id="position" min="1" value="{{$data->position}}" >
                                        @error('position')
                                        <small class="form-text text-danger ">
                                            {{$message}}
                                        </small>
                                        @enderror

                                    </div>
                                    <div class="checkbox ">
                                        <label>
                                            <input  {{ $data->is_active == 1 ? 'checked' : '' }}  type="checkbox" name="is_active" value="1"> Hiển thị
                                        </label>
                                        @error('is_active')
                                        <small class="form-text text-danger ">
                                            {{$message}}
                                        </small>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="  form-group image  ">
                                        <label id="avatar">Hình ảnh</label>
                                        <img id="avatar" class="thumbnail" width="250px" height="auto" src="{{asset($data->image)}}">
                                        <input    id="img"  type="file" name="image" class=" form-control src_img">
                                        @error('image')
                                        <small class="form-text text-danger ">
                                            {{$message}}
                                        </small>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                        </div>
                        <!-- /.box-body -->

                        <div class="box-footer ">
                            <button type="submit" name="btn-update" class="btn btn-primary">Cập Nhật</button>
                        </div>
                    </form>
                </div>
                <!-- /.box -->
            </div>
            <!--/.col (left) -->
        </div>
        <!-- /.row -->
    </section>
    <!-- /.content -->
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
