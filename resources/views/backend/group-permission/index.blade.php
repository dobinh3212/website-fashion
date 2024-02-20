@extends('backend.layout.main')
@section('title', 'Danh sách nhóm quyền ')
@section('main-content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Thêm  Nhóm Quyền

            <span class="  text-white-50 ">
                <a href="{{ route('admin.permission.index') }}" class="btn btn-primary"><i class="fa fa-list "></i> <span class="pl-2"> Danh Sách Quyền </span>  </a>
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
                @if (Auth::user()->can('them-nhom-quyen'))
                <form role="form" method="post" action="" >
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

                                <div class="form-group">
                                    <label for="name">Thêm nhóm quyền <span class="text-danger"> *</span></label>
                                    <input name="name" type="text" class="form-control"  @error('name') is-invalid @enderror   id="name" value="{{ old('name') }}">
                                    @error('name')
                                    <small class="form-text text-danger ">
                                        {{$message}}
                                    </small>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label>Mô tả</label>
                                    <textarea id="description" name="description" class="form-control" rows="10" ></textarea>
                                    @error('description')
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
                @endif
                <div class="col-md-8">
                    <div class="box-body table-responsive no-padding box box-primary">
                        <div class="dataTables_length " id="example1_length" style="margin: 10px;font-size: 17px;">
                            <div class="analytic " style="margin: 5px">

                            </div>
                            <form action="">
                                <div class="form-action form-inline py-3 ">
                                </div>
                                <table class="table table-hover table-checkall" style="align-items: center">
                                    <tr>
                                        <th>ID</th>
                                        <th>Tên nhóm quyền</th>
                                        <th>Mô tả</th>
                                        <th>Hành động</th>
                                    </tr>
                                    @if($groupPermissions->total()>0)
                                        @foreach($groupPermissions as $key => $row)
                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                                <td> {{$row->name}}</td>
                                                <td>  {{$row->description}}</td>
                                                <td ">
                                                    @if (Auth::user()->can('xoa-nhom-quyen'))
                                                        <a  href="javascript:void(0)"   title="Xóa"   class="confirmDelete btn btn-danger" record="group-permission" recordid="{{$row->id}}">
                                                            <i class="fa fa-trash"></i>
                                                        </a>
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
                                {{ $groupPermissions->links() }}
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
