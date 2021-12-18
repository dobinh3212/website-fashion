@extends('backend.layout.main')
@section('title', 'Cập nhật sản phẩm')
@section('main-content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Thêm Sản Phẩm <a href="{{ route('admin.product.index') }}" class="btn btn-primary"><i class="fa fa-list "></i>  Danh Sách</a>
        </h1>
    </section>

    <section class="content">
        <div class="row">

            <!-- left column -->
            <form role="form" action="{{ route('admin.product.update',$data->id) }}" method="post" enctype="multipart/form-data">
                @method('PUT')
                @csrf
                <div class="col-md-9 col-lg-9">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">Thông tin sản phẩm</h3>
                        </div>
                        <!-- /.box-header -->
                        <!-- form start -->
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name">Tên sản phẩm <span style="color: red">*</span></label>
                                        <input type="text" class="form-control"  value="{{$data->name}}" id="name" name="name">
                                        @error('name')
                                        <small class="form-text text-danger ">
                                            {{$message}}
                                        </small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="sku">Mã sản phẩm <span style="color: red">*</span></label>
                                        <input type="text" class="form-control" value="{{$data->sku}}" id="sku" name="sku">
                                        @error('sku')
                                        <small class="form-text text-danger ">
                                            {{$message}}
                                        </small>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group image ">
                                        <label id="avatar">Hình ảnh</label>
                                        <img id="avatar" class="thumbnail" width="150px" height="auto" src="{{asset($data->image)}}">
                                        <input id="img" type="file" name="image" class="form-control src_img">
                                        @error('image')
                                        <small class="form-text text-danger ">
                                            {{$message}}
                                        </small>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="color">Màu Sản Phẩm (<span style="color: red">*</span>)</label>
                                        <input type="text" class="form-control" id="color" name="color"  value="{{$data->color}}">
                                        @error('color')
                                        <small class="form-text text-danger ">
                                            {{$message}}
                                        </small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="number">Số lượng</label>
                                        <input style="width: 100px" type="number" class="form-control" id="stock" name="stock" value="{{$data->stock}}" min="1">
                                        @error('number')
                                        <small class="form-text text-danger ">
                                            {{$message}}
                                        </small>
                                        @enderror
                                    </div>


                                    <div class="form-group">
                                        <label for="price">Giá gốc (vnđ)(<span style="color: red">*</span>)</label>
                                        <input type="number" class="form-control" id="price" name="price"  value="{{$data->price}}" min="0">
                                        @error('price')
                                        <small class="form-text text-danger ">
                                            {{$message}}
                                        </small>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="sale">Giá khuyến mại (vnđ)(<span style="color: red">*</span>)</label>
                                        <input type="number" class="form-control" value="{{$data->sale}}" id="sale" name="sale"  min="0">
                                        @error('sale')
                                        <small class="form-text text-danger ">
                                            {{$message}}
                                        </small>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Danh mục sản phẩm (<span style="color: red">*</span>)</label>
                                        <select class="form-control w-50" name="category_id">
                                            <option value="0">-- Chọn danh mục --</option>
                                            @foreach($categories as $item)
                                                <option {{ $item->id == $data->category_id ? 'selected' : '' }} value="{{ $item->id}}" >
                                                    {{str_repeat('-- ', $item->level).' '.$item->name}}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('category_id')
                                        <small class="form-text text-danger ">
                                            {{$message}}
                                        </small>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Thương Hiệu (<span style="color: red">*</span>)</label>
                                        <select class="form-control w-50" name="brand_id">
                                            <option value="0">-- Chọn thương hiệu --</option>
                                            @foreach($brands as $brand)
                                                <option value="{{ $brand->id}}" {{ $brand->id == $data->brand_id ? 'selected' : '' }}>
                                                    {{ $brand->name }}

                                                </option>
                                            @endforeach
                                        </select>
                                        @error('brand_id')
                                        <small class="form-text text-danger ">
                                            {{$message}}
                                        </small>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="position">Vị trí</label>
                                        <input type="number" class="form-control w-50" id="position" name="position" value="{{$data->position}}">
                                    </div>
                                    @error('position')
                                    <small class="form-text text-danger ">
                                        {{$message}}
                                    </small>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" value="1" name="is_active"  {{ $data->is_active == 1 ? 'checked' : '' }} > <b>Hiển Thị</b>
                                            </label>
                                        </div>
                                        @error('is_active')
                                        <small class="form-text text-danger ">
                                            {{$message}}
                                        </small>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" value="1" name="is_hot"  {{ $data->is_hot == 1 ? 'checked' : '' }}> <b>Sản phẩm Hot</b>
                                            </label>
                                            @error('is_hot')
                                            <small class="form-text text-danger ">
                                                {{$message}}
                                            </small>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="url">Liên kết (url) tùy chỉnh</label>
                                <input type="text" class="form-control" id="url" name="url" placeholder="" value="{{$data->url}}">
                                @error('url')
                                <small class="form-text text-danger ">
                                    {{$message}}
                                </small>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>Tóm tắt</label>
                                <textarea id="editor2" name="summary" class="form-control" rows="10" >{!! $data->summary !!}</textarea>
                                @error('summary')
                                <small class="form-text text-danger ">
                                    {{$message}}
                                </small>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label>Mô tả</label>
                                <textarea id="editor1" name="description" class="form-control" rows="10" >{!! $data->description !!}</textarea>
                                @error('description')
                                <small class="form-text text-danger ">
                                    {{$message}}
                                </small>
                                @enderror
                            </div>
                        </div>
                        <!-- /.box-body -->
                        <div class="box-footer">
                            <button type="submit" class="btn btn-primary">Cập nhật</button>
                            <input type="reset" class="btn btn-default pull-right" value="Reset">
                        </div>
                    </div>
                    <!-- /.box -->
                </div>

                <div class="col-md-3">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Meta Title</label>
                        <textarea name="meta_title" class="form-control" rows="3" >{!! $data->meta_title !!}</textarea>
                    </div>
                    <div class="form-group">
                        <label>Meta Description</label>
                        <textarea name="meta_description" class="form-control" rows="5" >{!! $data->meta_description !!}</textarea>
                    </div>
                </div>
            </form>
        </div>
        <!-- /.row -->
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
                var _ckeditor1 = CKEDITOR.replace('summary');
                _ckeditor1.config.height = 200; // thiết lập chiều cao
                var _ckeditor2 = CKEDITOR.replace('description');
                _ckeditor2.config.height = 250; // thiết lập chiều cao
            })
        })( jQuery );
    </script>
@stop
