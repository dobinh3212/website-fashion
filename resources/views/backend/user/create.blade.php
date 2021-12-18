@extends('backend.layout.main')
@section('title', 'Thêm thành viên')
@section('main-content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Thêm  Nhân Viên

            <span class="  text-white-50 ">
                <a href="{{ route('admin.user.index') }}" class="btn btn-primary"><i class="fa fa-list "></i> <span class="pl-2"> Danh Sách </span>  </a>
            </span>
        </h1>

    </section>
    <!-- Main content -->
    <div class="content">
        <div class="row">
            <!-- left column -->
            <form role="form" method="post" action="{{route('admin.user.store')}} " enctype="multipart/form-data">
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
                                <label for="name"> Họ Tên  <span class="text-danger  " style="font-style: italic; font-size:13px!important; ">* </span> </label>
                                <input name="name" type="text" class="form-control"  id="name" value="{{old('name')}}" placeholder="Nhập Tên Nhân Viên">
                                @error('name')
                                <small class="form-text text-danger ">
                                    {{$message}}
                                </small>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Email : <span class="text-danger  " style="font-style: italic; font-size:13px!important; ">(*) Email là username đăng nhập</span></label>
                                <input type="email" name="email" class="form-control" id="exampleInputEmail1" value="{{old('email')}}" placeholder="Nhập Email ">
                                @error('email')
                                <small class="form-text text-danger ">
                                    {{$message}}
                                </small>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="password">Mật khẩu</label>
                                <input type="password" name="password" placeholder="Mật khẩu"  class="form-control" id="password">
                                @error('password')
                                <small class="form-text text-danger ">
                                    {{$message}}
                                </small>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="phone">Số điện thoại</label>
                                <input type="text" name="phone" placeholder="Số điện thoại"  value="{{old('phone')}}" class="form-control" id="phone">
                                @error('phone')
                                <small class="form-text text-danger ">
                                    {{$message}}
                                </small>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>Chọn Quyền</label>
                                <select class="form-control" name="role_id">
                                    <option value="" >Chọn</option>
                                    @foreach ($roles as $item)
                                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                                    @endforeach
                                </select>
                                @error('role_id')
                                <small class="form-text text-danger ">
                                    {{$message}}
                                </small>
                                @enderror
                            </div>

                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" value="1" name="is_active"> Kích hoạt tài khoản
                                </label>
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
                    <div class="form-group image ">
                        <label id="avatar">Hình ảnh</label>
                        <img id="avatar" class="thumbnail" width="300px" height="auto" src="{{asset('public/backend/dist/img/import-img.png')}}">
                        <input id="img" type="file" name="image" class="form-control src_img">
                        @error('image')
                        <small class="form-text text-danger ">
                            {{$message}}
                        </small>
                        @enderror
                    </div>
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

            })
        })( jQuery );
    </script>



@stop
