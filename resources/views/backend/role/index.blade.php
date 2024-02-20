@extends('backend.layout.main')
@section('title', 'Danh sách   vai trò')
@section('main-content')
    <!-- Content Header (Page header) -->
    <section class="content-header  d-flex  justify-content-between align-items-center">
        <h1>
            Quản Lý Vai Trò
            <span class="  text-white-50 ">
                <a href="{{ route('admin.role.create') }}" class="btn btn-primary"><i class="fa fa-plus-square"></i> Thêm Vai Trò</a>
            </span>

        </h1>
    </section>
    <!-- Main content -->
    <section class="content">
        @if(session('error'))
            <div class="alert alert-warning">
                {{session('error')}}
            </div>
        @endif
        @include('sweetalert::alert')
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Danh Sách</h3>
                        <div class="box-tools">
                            <form action="" method="get">
                                <div class="input-group input-group-sm hidden-xs" style="width: 300px;">

                                    <input type="text" name="keyword" value="{{request()->input('keyword')}}" class="form-control pull-right" placeholder="Tìm Kiếm">

                                    <div class="input-group-btn">
                                        <button type="submit" name="btn-search" value="Tìm kiếm" class="btn btn-default"><i class="fa fa-search"></i></button>
                                    </div>

                                </div>
                            </form>
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body table-responsive no-padding">
                        <div class="dataTables_length " id="example1_length" style="margin: 10px;font-size: 17px;">
                                <div class="form-action form-inline py-3 ">
                                </div>
                                <table class="table table-hover d-block mt-3">
                                    <tr>
                                        <th>
                                            <input name="checkall"  id="checkall" value="" type="checkbox">
                                        </th>
                                        <th>#</th>
                                        <th width="15%">Tên Vai Trò</th>
                                        <th  width="50%" style="text-align: center">Các Quyền</th>
                                        <th>Miêu Tả</th>
                                        <th>Hành động</th>
                                    </tr>
                                    @if ($roles->count() > 0)
                                        @php
                                            $t = 1;
                                        @endphp
                                        @foreach ($roles as $item)
                                        <tr>
                                            <td><input type="checkbox" name="list_check[]" value="{{$item->id}}"></td>
                                            <td>{{ $t++ }}</td>
                                            <td>{{ $item->name }}</td>
                                            <td>
                                                @foreach ($item->permissions as $permission)
                                                    <span
                                                        class="badge bg-green text-white">{{ $permission->display_name }}</span>
                                                @endforeach
                                            </td>
                                            <td>{{ $item->description }}</td>
                                            <td>
                                                @if (Auth::user()->can('sua-vai-tro'))
                                                    <a href="{{ route('admin.role.edit',$item->id) }}" class="btn btn-primary"><i class="fa fa-edit" style="font-style:17px!important;" aria-hidden="true"></i></a>
                                                @endif
                                                    @if (Auth::user()->can('xoa-vai-tro'))
                                                        <a  href="javascript:void(0)"   title="Xóa"   class="confirmDelete btn btn-danger" record="role" recordid="{{$item->id}}">
                                                            <i class="fa fa-trash"></i>
                                                        </a>
                                                    @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                    @else
                                        <tr>
                                            <td colspan="5">Không có bản ghi nào</td>
                                        </tr>
                                    @endif
                                </table>


                        </div>
                        <!-- /.box-body -->
                    </div>
                    <!-- /.box -->
                </div>
            </div>
    </section>
    <!-- /.content -->
@endsection
@section('scripts')
    <script>
        $("#checkall").click(function(){
            $('input:checkbox').not(this).prop('checked', this.checked);
        });
    </script>
@stop
