@extends('backend.layout.main')
@section('title', 'Danh sách  Liên Hệ')
@section('main-content')
    <!-- Content Header (Page header) -->
    <section class="content-header  d-flex  justify-content-between align-items-center">
        <h1>
            Quản Lý Liên Hệ
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
                                <table class="table table-hover d-block mt-3">
                                    <tr>
                                        <th>ID</th>
                                        <th>Họ tên</th>
                                        <th>Số điện thoại</th>
                                        <th>Email</th>
                                        <th>Ghi chú</th>
                                        <th>Hành động</th>
                                    </tr>
                                    @foreach($data as $key => $row)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{$row->name}}</td>
                                            <td>{{$row->phone}}</td>
                                            <td>{{ $row->email }}</td>
                                            <td>{{ $row->content }}</td>
                                            <td>
                                                <button class="btn btn-danger  rounded-0 text-white" type="button"
                                                        data-placement="top" title="Delete" data-toggle="modal"
                                                        data-target="#modal-confirm-{{$row->id}}">Xóa
                                                </button>
                                                <div class='modal fade' id='modal-confirm-{{$row->id}}' tabindex='-1' role='dialog' aria-labelledby='exampleModalLabel'
                                                     aria-hidden='true'>
                                                    <div class='modal-dialog' role='document'>
                                                        <div class='modal-content'>
                                                            <div class='modal-header'>
                                                                <h5 class='modal-title' id='exampleModalLabel'>Thông báo
                                                                    <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                                                                        <span aria-hidden='true'>&times;</span>
                                                                    </button>
                                                                </h5>
                                                            </div>
                                                            <div class='modal-body text-danger'>Bạn muốn xóa  danh mục này !
                                                            </div>
                                                            <div class='modal-footer'>
                                                                                                                        <form action="{{ route('admin.contact.destroy',$row->id ) }}" method="POST">
                                                                                                                            @csrf
                                                                                                                            @method('DELETE')
                                                                                                                            <button type='button' class='btn btn-secondary' data-dismiss='modal'>Đóng</button>
                                                                                                                            <button type="submit" class="btn btn-primary">Xác nhận</button>
                                                                                                                        </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                            </td>
                                        </tr>
                                    @endforeach

                                </table>
                            </div>
                        </div>
                    <div class="text-center " style="margin-bottom: 10px!important;" >
                       {{$data->links()}}
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
