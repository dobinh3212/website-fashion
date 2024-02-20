
@extends('backend.layout.main')
@section('title', 'Thêm   thuộc tính sản phẩm ')
@section('main-content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Thêm  Thuộc Tính
            <span class="  text-white-50 ">
                <a href="{{ route('admin.product.index') }}" class="btn btn-primary"><i class="fa fa-list "></i> <span class="pl-2">   Danh Sách </span>  </a>
            </span>
        </h1>

    </section>
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <!-- left column -->
            <div class="col-md-10 d-flex justify-content-sm-between">
                <!-- general form elements -->
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Thông tin</h3>
                    </div>
                    <!-- /.box-header -->
                    <!-- form start -->
                    <form role="form" method="post" action="{{ url('admin/product/add-attributes/'.$productDetail['id']) }}" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="product_id" value="{{$productDetail['id']}}">
                        <div class="box-body">

                            <div class="row">
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label for="name">Tên sản phẩm :</label> {{$productDetail['name']}}
                                    </div>
                                    <div class="form-group">
                                        <label for="name">Mã sản phẩm :</label> {{$productDetail['sku']}}
                                    </div>
                                    <div class="form-group">
                                        <label for="name">Giá sản phẩm  :</label> {{number_format($productDetail['price'],0,'đ','.')}} vnđ
                                    </div>
                                    <div class="form-group">
                                        <label for="name">Màu sản phẩm:</label>  {{$productDetail['color']}}
                                    </div>
                                    <div class="form-group">
                                        <label for="name">Số lượng   :</label>  {{$productDetail['stock']}}
                                    </div>
                                    @include('sweetalert::alert')
                                    @if (session('error'))
                                        <div class="alert alert-danger">
                                            {{ session('error') }}
                                        </div>
                                    @endif
                                    <div class="form-group">
                                        <div class="field_wrapper">
                                            <div style="display: flex;padding:5px;" >
                                                <input class="form-control" style="max-width: 100px;border-radius:5px;" type="text" name="sku[]" value="{{old('sku')}}" required placeholder="Mã" />
                                                <input class="form-control" style="max-width: 100px;margin-left:5px!important;border-radius:5px; " type="text" name="size[]" placeholder="Size " value="{{old('size')}}" required />
                                                <input class="form-control" style="max-width: 100px;margin-left:5px!important;border-radius:5px; " type="number" name="price[]" placeholder="Giá" value="{{old('price')}}" required />
                                                <input class="form-control" style="max-width: 100px;margin-left:5px!important;border-radius:5px;" type="number" name="stock[]"  placeholder="Số lượng" value="{{old('stock')}}" required />
                                                <a href="javascript:void(0);" class="btn btn-success  add_button" title="Thêm thuộc tính"  style="max-width: 100px;margin-left:5px!important;"><i class="fa fa-plus-square"></i> Thêm </a>
                                            </div>
                                        </div>

                                    </div>


                                </div>

                                <div class="col-md-4">
                                    <div class="  form-group image ">
                                        <label id="avatar">Hình ảnh</label>
                                        <img id="avatar" class="thumbnail" width="250px" height="auto" src="{{asset($productDetail['image'])}}">
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary">Thêm Mới</button>

                        </div>
                    </form>
                        <!-- /.box-body -->
                        <div class="box-footer ">
                            <form role="form"  name="editAttributeForm" method="post" action="{{ url('admin/product/edit-attributes/'.$productDetail['id']) }}">
                            @csrf
                            <div class="box">
                                <div class="box-header">
                                    <h3 class="box-title">Bảng Thuộc Tính Sản Phẩm</h3>
                                </div>
                                <!-- /.box-header -->
                                <div class="box-body">
                                    <table id="example1" class="table table-bordered table-striped">
                                        <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Mã sản phẩm</th>
                                            <th>Size</th>
                                            <th>Giá</th>
                                            <th>Số lượng</th>
                                            <th class="text-center">Trạng Thái</th>
                                            <th class="text-center">Hành động</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($productDetail['attributes'] as $attribute)
                                            <input type="hidden" name="attrId[]" value="{{$attribute['id']}}">
                                        <tr>
                                            <td>{{ $attribute['id'] }}</td>
                                            <td>{{ $attribute['sku'] }}
                                            </td>
                                            <td>
                                                {{ $attribute['size']}}
                                                  </td>
                                            <td>
                                                <input type="number" name="price[]" value="{{ $attribute['price']}}" required>
{{--                                                {{number_format($attribute['price'],0,'đ','.')}}đ--}}
                                            </td>
                                            <td>
                                                <input type="number" name="stock[]" value="{{ $attribute['stock']}}" required>
                                            </td>
                                            <td class="text-center">
                                                @if($attribute['status']==1)
                                                <a class="updateAttributeStatus"  id="attribute-{{$attribute['id']}}"  data-url="{{url('admin/update-attribute-status')}}"  attribute_id="{{$attribute['id']}}"
                                                    href="javascript:void(0)">  <span class="badge bg-light-blue"> Hiển Thị </span></a>
                                                @else
                                                    <a class="updateAttributeStatus " id="attribute-{{$attribute['id']}}"  data-url="{{url('admin/update-attribute-status')}}"  attribute_id="{{$attribute['id']}}"
                                                       href="javascript:void(0)"><span class="badge bg-info" >Chờ duyệt</span></a>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                <a  href="javascript:void(0)"   title="Xóa"   class="confirmDelete btn btn-danger" record="attribute" recordid="{{$attribute['id']}}">
                                                    <i class="fa fa-trash"></i>
                                                </a>
                                            </td>


                                        </tr>
                                      @endforeach

                                        </tbody>

                                    </table>
                                </div>
                                <!-- /.box-body -->

                            </div>
                                <button type="submit" class="btn btn-primary">Cập Nhật</button>
                            </form>
                        </div>
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

@stop

