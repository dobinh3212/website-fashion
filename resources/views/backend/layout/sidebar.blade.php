<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="{{asset('public/backend/dist/img/user2-160x160.jpg')}}" class="img-circle" alt="User Image">
            </div>
            <div class="pull-left info">
                <p> @if (Auth::check())
                    {{Auth::user()->name}}
                    @endif</span></p>
                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>
        <!-- search form -->
        <form action="#" method="get" class="sidebar-form">
            <div class="input-group">
                <input type="text" name="q" class="form-control" placeholder="Tìm Kiếm...">
                <span class="input-group-btn">
                <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
            </div>
        </form>
        <!-- /.search form -->
        <!-- sidebar menu: : style can be found in sidebar.less -->
        @php
            $module_active=session('module_active');
        @endphp
        <ul class="sidebar-menu" data-widget="tree">
            <li class="{{$module_active =='category' ? 'active': ''}}  treeview ">
                <a href="{{route('admin.category.index')}}">
                    <i class="fa fa-th"></i> <span>QL Danh Mục</span>
                    <span class="pull-right-container">
                    <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li  class="{{(request()->is('admin/category')) ? 'active':''}}" > <a   href="{{route('admin.category.index')}}"  ><i class="fa fa-circle-o"></i>Danh sách</a></li>
                    <li class="{{(request()->is('admin/category/create')) ? 'active':''}}"> <a href="{{route('admin.category.create')}}"  ><i class="fa fa-circle-o"></i>Thêm mới</a></li>
                </ul>
            </li>


            <li class="{{$module_active =='product' ? 'active': ''}}  treeview ">
                <a href="{{route('admin.product.index')}}">
                    <i class="fa fa-th"></i> <span>QL Sản Phẩm</span>
                    <span class="pull-right-container">
                    <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li  class="{{(request()->is('admin/product')) ? 'active':''}}" > <a   href="{{route('admin.product.index')}}"  ><i class="fa fa-circle-o"></i>Danh sách</a></li>
                    <li class="{{(request()->is('admin/product/create')) ? 'active':''}}"> <a href="{{route('admin.product.create')}}"  ><i class="fa fa-circle-o"></i>Thêm mới</a></li>
                </ul>
            </li>
            <li class="{{$module_active =='brand' ? 'active': ''}}  treeview ">
                <a href="{{route('admin.brand.index')}}">
                    <i class="fa fa-th"></i> <span>QL Thương Hiệu</span>
                    <span class="pull-right-container">
                    <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li  class="{{(request()->is('admin/brand')) ? 'active':''}}" > <a   href="{{route('admin.brand.index')}}"  ><i class="fa fa-circle-o"></i>Danh sách</a></li>
                    <li class="{{(request()->is('admin/brand/create')) ? 'active':''}}"> <a href="{{route('admin.brand.create')}}"  ><i class="fa fa-circle-o"></i>Thêm mới</a></li>
                </ul>
            </li>
            <li class="{{$module_active =='banner' ? 'active': ''}}  treeview ">
                <a href="{{route('admin.banner.index')}}">
                    <i class="fa fa-th"></i> <span>QL Thư Viện</span>
                    <span class="pull-right-container">
                    <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li  class="{{(request()->is('admin/banner')) ? 'active':''}}" > <a   href="{{route('admin.banner.index')}}"  ><i class="fa fa-circle-o"></i>Danh sách</a></li>
                    <li class="{{(request()->is('admin/banner/create')) ? 'active':''}}"> <a href="{{route('admin.banner.create')}}"  ><i class="fa fa-circle-o"></i>Thêm mới</a></li>
                </ul>
            </li>
            <li class="{{$module_active =='article' ? 'active': ''}}  treeview ">
                <a href="">
                    <i class="fa fa-th"></i> <span>QL Tin Tức</span>
                    <span class="pull-right-container">
                    <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li  class="{{(request()->is('admin/article')) ? 'active':''}}" > <a   href="{{route('admin.article.index')}}"  ><i class="fa fa-circle-o"></i>Danh sách</a></li>
                    <li class="{{(request()->is('admin/article/create')) ? 'active':''}}"> <a href="{{route('admin.article.create')}}"  ><i class="fa fa-circle-o"></i>Thêm mới</a></li>
                </ul>
            </li>
            <li class="{{$module_active =='order' ? 'active': ''}} treeview" >
                <a href="{{route('admin.order.index')}}">
                    <i class="fa fa-th"></i> <span>QL Đặt Hàng</span>
                    <span class="pull-right-container">
                    <i class="fa fa-angle-left pull-right"></i>
                    </span>
                    <ul class="treeview-menu">
                        <li  class="{{(request()->is('admin/order')) ? 'active':''}}" > <a   href="{{route('admin.order.index')}}"  ><i class="fa fa-circle-o"></i>Danh sách đơn hàng</a></li>
                    </ul>
                </a>
            </li>
            <li class="{{$module_active =='user' ? 'active': ''}} treeview" >
                <a href="{{route('admin.user.index')}}">
                    <i class="fa fa-th"></i> <span>QL Người Dùng</span>
                    <span class="pull-right-container">
                    <i class="fa fa-angle-left pull-right"></i>
                    </span>
                    <ul class="treeview-menu">
                        <li  class="{{(request()->is('admin/user')) ? 'active':''}}" > <a   href="{{route('admin.user.index')}}"  ><i class="fa fa-circle-o"></i>Danh sách</a></li>
                        <li class="{{(request()->is('admin/user/create')) ? 'active':''}}"> <a href="{{route('admin.user.create')}}"  ><i class="fa fa-circle-o"></i>Thêm mới</a></li>
                    </ul>

                </a>
            </li>
            <li class="{{$module_active =='permission' ? 'active': ''}} treeview" >
                <a href="{{route('admin.permission.index')}}">
                    <i class="fa fa-th"></i> <span>QL  Quyền </span>
                    <span class="pull-right-container">
                    <i class="fa fa-angle-left pull-right"></i>
                    </span>
                    <ul class="treeview-menu">
                        <li  class="{{(request()->is('admin/permission')) ? 'active':''}}" > <a   href="{{route('admin.permission.index')}}"  ><i class="fa fa-circle-o"></i>Danh sách</a></li>
                        <li class="{{(request()->is('admin/permission/group')) ? 'active':''}}"> <a href="{{route('admin.groupPermission.index')}}"  ><i class="fa fa-circle-o"></i>Nhóm quyền</a></li>
                    </ul>

                </a>
            </li>
            <li class="{{$module_active =='role' ? 'active': ''}} treeview" >
                <a href="{{route('admin.role.index')}}">
                    <i class="fa fa-th"></i> <span>QL Vai Trò </span>
                    <span class="pull-right-container">
                    <i class="fa fa-angle-left pull-right"></i>
                    </span>
                    <ul class="treeview-menu">
                        <li  class="{{(request()->is('admin/role')) ? 'active':''}}" > <a   href="{{route('admin.role.index')}}"  ><i class="fa fa-circle-o"></i>Danh sách</a></li>
                        <li class="{{(request()->is('admin/role/create')) ? 'active':''}}"> <a href="{{route('admin.role.create')}}"  ><i class="fa fa-circle-o"></i>Thêm Mới</a></li>
                    </ul>

                </a>
            </li>


            <li class="{{$module_active =='contact' ? 'active': ''}} " >
                <a href="{{route('admin.contact.index')}}">
                    <i class="fa fa-th"></i> <span>QL Liên Hệ</span>
                </a>
            </li>

        </ul>
    </section>
    <!-- /.sidebar -->
</aside>
