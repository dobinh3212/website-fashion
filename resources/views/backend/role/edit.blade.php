@extends('backend.layout.main')
@section('title', 'Cập Nhật Vai Trò ')
@section('main-content')
    <style>
        .card-header {
            padding: .75rem 1.25rem;
            margin-bottom: 1rem;
            background-color: rgba(0, 0, 0, .03);
            border-bottom: 1px solid rgba(0, 0, 0, .125);
        }
        .card-body {
            -ms-flex: 1 1 auto;
            flex: 1 1 auto;
            padding: 1.25rem;
        }
    </style>



    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Cập Nhật Vai Trò
            <span class="  text-white-50 ">
                <a href="{{ route('admin.role.index') }}" class="btn btn-primary"><i class="fa fa-list "></i> <span class="pl-2">   Danh Sách </span>  </a>
            </span>
        </h1>

    </section>
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <!-- left column -->
            <div class="col-md-12 d-flex justify-content-sm-between">
                <!-- general form elements -->
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Thông tin</h3>
                    </div>
                    <!-- /.box-header -->
                    <!-- form start -->
                    <form role="form"   action="{{route('admin.role.update',$role->id)}}" method="post">
                        @csrf
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="name">Tên vai trò</label>
                                        <input class="form-control" type="text" name="name" id="name" value="{{ $role->name }}"
                                               placeholder="Vui lòng nhập tên vai trò">
                                        @error('name')
                                        <small class="text-danger" style="font-size: 16px;font-style: italic;">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="description">Mô tả vai trò</label>
                                        <textarea name="description" placeholder="Vui lòng nhập mô tả vai trò"
                                                  class="form-control " id="description" cols="30" rows="2">{!!  $role-> description!!}</textarea>
                                        @error('description')
                                        <small class="text-danger" style="font-size: 16px;font-style: italic;">{{ $message }}</small>
                                        @enderror
                                    </div>

                                </div>

                            </div>
                            <div class="col-xs-12">
                                <div class="row">
                                    <div class="box">
                                        <div class="box-header">
                                            <h1 class="box-title mb-3"  style="font-weight: bold" >Chọn Các Quyền</h1>

                                            <input type="checkbox" class="checkall" value=""> Check ALL

                                        </div>
                                        @error('permission_id')
                                        <small class="text-danger" style="font-size: 16px;font-style: italic;">{{ $message }}</small>
                                        @enderror
                                    <!-- /.box-header -->
                                        @foreach ($groupPermissions as $item)
                                            <div class="box-body card table-responsive no-padding">
                                                <div class="card-header">
                                                    <input type="checkbox" class="check_parent_group" value="{{ $item->id }}">
                                                    <span style="font-weight: bold;font-size: 15px;" > {{ $item->name }} </span>
                                                </div>
                                                @foreach ($item->permissions as $permission)
                                                    <div class="card-body text-dark col-md-3">
                                                        <h5 class="card-title">
                                                            <input
                                                                {{ $permissionsChecked->contains('id', $permission->id) ? 'checked' : '' }}
                                                                type="checkbox" class="check_child_{{ $item->id }}"
                                                                data-id="{{ $item->id }}" name="permission_id[]"
                                                                value="{{ $permission->id }}">
                                                            {{ $permission->display_name }}
                                                        </h5>
                                                    </div>
                                                @endforeach
                                            </div>
                                    @endforeach
                                    <!-- /.box-body -->
                                    </div>
                                </div>

                                <!-- /.box -->
                            </div>
                        </div>

                        <!-- /.box-body -->
                        <div class="box-footer ">
                            <button type="submit" class="btn btn-primary">Cập Nhật</button>
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
        $(document).ready(function () {
            $(".card-header .check_parent_group").click(function () {
                //Gán checked của .check_child dựa vào checked của cha là .check_parent dựa vào phương thức prop()
                //Nếu .check_parent checked --> true prop('checked', true) ngước lại là false
                var v = $(this).val();
                $(this)
                    .parents(".card")
                    .find("input.check_child_" + v + "")
                    .prop("checked", $(this).prop("checked"));
            });
        });

        $(".checkall").click(function () {
            $(this)
                .parents()
                .find("input[type=checkbox]")
                .prop("checked", $(this).prop("checked"));
        });
    </script>
@stop
