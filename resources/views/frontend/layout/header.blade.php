<header>
    <div class="up-header clearfix">
        <div class="container">
            <ul class="list-unstyled list-inline pull-left">
                <li><i class="fa fa-link pink"></i> <a href="#" title=""  class="pink fl-left"> Hình Thức Thanh Toán</a>  </li>
            </ul>
            <ul class="list-unstyled list-inline pull-right">
                @php
                    $customer_id = session('id');
                     $customer_name = session('name');
                @endphp
                @if($customer_id != NULL)
                <li>Xin chào !<strong> @php echo  $customer_name  @endphp </strong>  <span>&nbsp; || &nbsp;</span><a href="{{route('checkoutLogout')}}" class="pink">Đăng Xuất</a> </li>
                @else
                    <li> Xin chào ! <span>&nbsp; || &nbsp;</span> <a href="{{route('checkoutLogin')}}" class="pink"> Đăng Nhập</a>&nbsp;</li>
                @endif

            </ul>
        </div>
    </div>


    <div class="header clearfix">
        <div class="container">
            <div class="row">
                <div class="col-md-3 col-sm-3 hidden-sm hidden-xs">
                    <a href="{{url('/')}}"><img src="{{asset('public/frontend/assets/images/logo-no-line.jpg')}}" alt="" class="img-responsive"></a>
                </div>
                <div class="col-md-6 col-sm-7 col-xs-12">
                    <div class="header-search">
                        <div class="form-inline">
                            <div class="form-group">
                                <form action="{{ route('shop.search') }}" method="get"   class="search-form-cat">
                                <div class="input-group" >
                                    <input type="text" class="form-control item-header" {{ request()->input('tu-khoa') }}  name="tu-khoa"   placeholder="Nhập từ tìm kiếm...">
                                    <div class="input-group">
                                        <button type="submit"  value="Search" id="sm-s">Tìm Kiếm</button>
                                    </div>

                                </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-5 col-xs-12">
                    <div class="cart-text">
                        <div class="text-right ">
                            <ul class="list-unstyled list-inline wish">
                                <li>
                                    <a  class="dropdown-toggle social fa  fa-shopping-cart round-border pink-color" href="{{url('/dat-hang')}}" aria-expanded="true"></a>
                                    <div class="dropdown-menu items-drop">
                                        <br>
                                        <div class="line-full"></div>
                                        <br>
                                        <div class="clearfix mar-bot-10 font-weight-bold">
                                        </div>
                                        <div class="mar-top-30 clearfix mar-bot-10 btns">
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <p class="text-left"><span class="font-bold">Giỏ hàng</span>
                                        @if(Cart::count()>0)
                                            <span id="num" class="count-cart">
                                 ( {{Cart::count()}} )
                            </span>
                                        @endif
                                        <br>
                                        {{Cart::total(0, 0, '.')}} VNĐ</p>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="below-header">
        <div class="container wow bounceInLeft" data-wow-duration="1s">
            <div class="">
                <div class="hero">
                    <div class="clickablemenu ttmenu dark-style menu-red-gradient">
                        <div class="navbar navbar-default" role="navigation">
                            <div class="navbar-header">
                                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target=".navbar-collapse"> <span class="sr-only">Toggle navigation</span> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </button>
                                <a class="navbar-brand hidden-md hidden-lg visible-sm visible-xs" href="#">
                                    <img src="{{asset('frontend/assets/images/logo-no-line.jpg')}}" alt=""></a>
                            </div>
                            <!-- end navbar-header -->

                            <div  class="navbar-collapse collapse">
                                <ul class="nav navbar-nav">
                                    <li class="dropdown ttmenu-full"><a href="{{url('/')}}">Trang chủ</a> </li>
                                    <li class="dropdown ttmenu-full"><a href="{{url('/gioi-thieu.html')}}">Giới thiệu</a> </li>
                                    @foreach($categories as $parent)
                                        @if($parent->parent_id == 0 )
                                    <li class="dropdown ttmenu-full" >
                                        <a  href="{{ route('shop.category',$parent->slug) }}" >{{$parent->name}}
                                        </a>
                                        <ul class="dropdown-menu">
                                            @foreach($categories as $child)
                                                @if($child->parent_id == $parent->id)
                                            <li>
                                                <div class="ttmenu-content">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="box">
                                                                <ul>
                                                                    <li><a href="{{ route('shop.category', $child->slug) }}">{{ $child->name }}</a></li>
                                                                </ul>
                                                            </div>
                                                            <!-- end box -->
                                                        </div>
                                                        <!-- end col -->
                                                    </div>
                                                    <!-- end row -->
                                                </div>
                                                <!-- end ttmenu-content -->
                                            </li>
                                                @endif
                                            @endforeach
                                        </ul>
                                    </li>
                                    @endif
                                   @endforeach
                                    <!-- end mega menu -->
                                    <li class="dropdown"> <a href="{{url('/tin-tuc')}}" class="dropdown-toggle">Tin Tức</a> </li>
                                    <!-- end mega menu -->
                                    <li class="dropdown ttmenu-full"><a href="#" data-toggle="dropdown" class="dropdown-toggle">Liên Hệ <b class="dropme"></b></a>
                                        <ul class="dropdown-menu">
                                            <li>
                                                <div class="ttmenu-content">
                                                    <div class="row">
                                                        <div class="col-md-3">
                                                            <div class="box">
                                                                <ul>
                                                                    <li>
                                                                        <h4>LIÊN HỆ</h4>
                                                                    </li>
                                                                    <li><a href="#">Fashion@gmail.com <span class="fa fa-envelope-o"></span></a></li>
                                                                    <li><a href="#">www.fashion.com <span class="fa fa-link"></span></a></li>
                                                                    <li><a href="#">(0) +911 333 44 55 <span class="fa fa-phone"></span></a></li>
                                                                    <li><a href="#">(0) +911 333 44 80 <span class="fa fa-fax"></span></a></li>
                                                                    <li><a href="#">Trần Đại Nghĩa,<br>
                                                                            Hai Bà Trưng,Hà Nội</a></li>
                                                                </ul>
                                                            </div>
                                                            <!-- end box -->
                                                        </div>
                                                        <!-- end col -->
                                                        <div class="col-md-6">
                                                            <div class="row">
                                                                <div class="box"> <br>
                                                                    <form id="contact" action="{{url('/gui-lien-he')}}"  class="row" name="contactform" method="post">
                                                                       @csrf
                                                                        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                                                            <input type="text" name="name" id="name2" class="form-control" placeholder="Họ tên">
                                                                            @error('name')
                                                                            <small class="form-text text-danger " style="font-style:italic!important;">
                                                                                {{$message}}
                                                                            </small>
                                                                            @enderror
                                                                            <input type="text" name="email" id="email2" class="form-control" placeholder="Email">
                                                                            @error('email')
                                                                            <small class="form-text text-danger" style="font-style:italic!important;">
                                                                                {{$message}}
                                                                            </small>
                                                                            @enderror
                                                                        </div>
                                                                        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                                                            <input type="text" name="phone" id="phone2" class="form-control"  placeholder="Số điện thoại">
                                                                            {{--                                                                            <input type="text" name="subject" id="subject2" class="form-control" placeholder="Subject">--}}
                                                                            @error('phone')
                                                                            <small class="form-text text-danger " style="font-style:italic!important;">
                                                                                {{$message}}
                                                                            </small>
                                                                            @enderror
                                                                        </div>
                                                                        <div class="clearfix"></div>
                                                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                                            <textarea class="form-control" name="content" id="comments2" rows="6" placeholder="Ghi chú"></textarea>
                                                                            @error('content')
                                                                            <small class="form-text text-danger " style="font-style:italic!important;">
                                                                                {{$message}}
                                                                            </small>
                                                                            @enderror
                                                                        </div>
                                                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                                            <div class="pull-left">
                                                                                <input type="submit" value="Gửi" id="submit2" name="btn-send" class="btn btn-primary small">
                                                                            </div>
                                                                        </div>
                                                                    </form>
                                                                </div>
                                                                <!-- end box -->
                                                            </div>
                                                            <!-- end row -->
                                                        </div>
                                                        <!-- end col -->
                                                        <div class="col-md-3">
                                                            <div class="box">
                                                                <ul>
                                                                    <li>
                                                                        <h4>BẢNG TIN</h4>
                                                                    </li>
                                                                    <li>
                                                                        <p>Đăng ký với chung tôi để nhận được thông tin  sớm nhất</p>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                            <!-- end box -->
                                                        </div>
                                                        <!-- end col -->
                                                    </div>
                                                    <!-- end row -->
                                                </div>
                                                <!-- end ttmenu content -->
                                            </li>
                                        </ul>
                                    </li>
                                    <li class="dropdown ttmenu-full"><a href="{{route('checkOrder')}}">Tra cứu đơn hàng</a> </li>

                                    <!-- end mega menu -->
                                </ul>
                                <!-- end nav navbar-nav -->

                            </div>
                            <!--/.nav-collapse -->
                        </div>
                        <!-- end navbar navbar-default clearfix -->
                    </div>
                    <!-- end menu 1 -->
                </div>
                <!-- end hero -->

            </div>
        </div>
    </div>
</header>
