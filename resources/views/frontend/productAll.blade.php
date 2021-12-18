@extends('frontend.layout.main')
@section('main-content')
    <div class="container">
        <div class="">
            <div class="row">
                <img src="{{asset('public/frontend/assets/images/carousel-img.png')}}')}}" alt="" class="img-responsive">

            </div>
        </div>
    </div>
    <div class="container grid-main">
        <div class="row">
            <div class="col-md-9 grid-right  col-md-push-3 wow bounceInUp" data-wow-duration="2s">
                <div class="row">
                    <div class="clearfix grid-sorting col-md-4 col-sm-4 col-xs-12" >
                        <h3>Tất cả sản phẩm</h3>
                        <div class="">
                            <div class="pull-left ">

                            </div>
                            <div class="pull-left">

                            </div>
                        </div>
                    </div>
                    <div class="clearfix grid-sorting col-md-4 col-sm-4 col-xs-12" >
                    </div>
                    <div class="clearfix grid-sorting col-md-4 col-sm-4 col-xs-12">
                        <div class="">
                            <div class="pull-right pull-left-xs" style="border-bottom:2px solid slategray">
                                <p>Hiện tại có <span class="text-danger" style="color: red;font-weight: bold"> {{count($products)}} </span>  sản phẩm !!!</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <ul class="list-unstyled grid-items clearfix">
                        @foreach($products as $product)
                            <li class="col-md-4 col-sm-4 wow bounceInUp" data-wow-duration="2s">
                                <div class="img-about">
                                    <a href="{{ route('shop.product',$product->slug) }}"><img  style="max-width:250px!important;max-height:250px;!important;" src="{{asset($product->image)}}" class="img-responsive img-hover" alt=""></a>
                                    <div class="desc text-center">
                                        <p class="font-13 mar-bot-0">{{ $product->name }}</p>
                                        <p class="font-15 orange font-bold"><del class="light-grey lighter">{{ number_format($product->sale,0,",",".") }} ₫ </del>{{ number_format($product->sale,0,",",".") }} ₫</p>
                                        <div class="clearfix mar-top-10">
{{--                                            <a href="{{ route('shop.product',$product->slug) }}" title="Xem Chi Tiết" class="cart ">Xem Chi Tiết</a>--}}
                                        </div>
                                    </div>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                    <div class="clearfix grid-sorting col-md-4 col-sm-4 col-xs-12" >
                    </div>
                    <div class="clearfix grid-sorting col-md-4 col-sm-4 col-xs-12">
                    </div>
                    <div class="clearfix grid-sorting col-md-4 col-sm-4 col-xs-12">
                        <div class="">

                            <div class="pull-right pull-left-xs">
                                {{$products->links()}}

                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <div class="col-md-3 grid-left  col-md-pull-9 wow bounceInUp" data-wow-duration="2s">
                <p class="font-20 text-uppercase font-bold line-long">DANH MỤC</p>
                <div id="vertical-menu">
                    <ul class="simple">
                        <li>
                            <h3 class="text-danger font-weight-bold" >TẤT CẢ</h3>

                        </li>
                    </ul>
                </div>
                <img src="{{asset('public/frontend/assets/images/collection.jpg')}}" alt="" class="img-responsive"> </div>

            <div class="banner hidden-xs hidden-sm"> <img src=" {{asset('public/frontend/assets/images/banner-long.jpg')}}  " alt="" class="img-responsive"></div>
    </div>
@endsection
@section('scripts')
    <script>
        $("#vertical-menu h3").click(function () {
            //slide up all the link lists
            $("#vertical-menu ul ul").slideUp();
            $('.plus',this).html('+');
            //slide down the link list below the h3 clicked - only if its closed
            if (!$(this).next().is(":visible")) {
                $(this).next().slideDown();
                //$(this).remove("span").append('<span class="minus">-</span>');
                $('.plus').html('+');
                $('.plus',this).html('-');
            }
        })</script>
@stop
