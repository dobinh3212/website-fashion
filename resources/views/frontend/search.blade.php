@extends('frontend.layout.main')
@section('main-content')
    <style>
        .not-search {
            text-align: center;
            background-color: white;
            padding: 28px;
            font-size: 18px;
        }
    </style>
    <div class="container">
        <div class="">
            <div class="row">
                <img src="{{asset(' public/frontend/assets/images/carousel-img.png')}}" alt="" class="img-responsive">

            </div>
        </div>
    </div>
    <div class="container grid-main">
        <div class="row">
            @include('sweetalert::alert')
            <div class="col-md-9 grid-right  col-md-push-3 wow bounceInUp" data-wow-duration="2s">
                <h3 class="mb-2" >Từ Khóa Tìm Kiếm    <span style="font-weight: bold;">"{{request()->input('tu-khoa')}}"  </span></h3>
                <div class="row">
                    <div class="clearfix grid-sorting col-md-4 col-sm-4 col-xs-12" >
                    </div>
                    <div class="clearfix grid-sorting col-md-4 col-sm-4 col-xs-12">
                    </div>
                    <div class="clearfix grid-sorting col-md-4 col-sm-4 col-xs-12">
                        <div class="">
                            <div class="pull-right pull-left-xs" style="border-bottom: 2px solid slategray">
                                <p>Hiện tại có <span class="text-danger" style="color: red;font-weight: bold"> {{count($productSearchs)}} </span>  sản phẩm !!!</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    @if($productSearchs->total()> 0)
                    <ul class="list-unstyled grid-items clearfix">
                        @foreach($productSearchs as $product)
                            <li class="col-md-4 col-sm-4 wow bounceInUp" data-wow-duration="2s">
                                <div class="img-about"style="max-width:25                        0px!important;">
                                    <a href="{{ route('shop.product',$product->slug) }}"><img  style="width:auto!important;height:250px;!important;" src="{{asset($product->image)}}" class="img-responsive img-hover" alt=""></a>
                                    <div class="desc text-center">
                                        <p class="font-13 mar-bot-0">{{ $product->name }}</p>
                                        <p class="font-15 orange font-bold"><del class="light-grey lighter">{{ number_format($product->sale,0,",",".") }} ₫ </del>{{ number_format($product->sale,0,",",".") }} ₫</p>
                                    </div>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                    @else
                        <div class="not-search clearfix">
                            <img src="{{ asset('public/frontend/assets/images/noti-search.png') }}" alt="">
                            <p>Rất tiếc chúng tôi không tìm thấy kết quả theo yêu cầu của bạn</p>
                            <p>Vui lòng thử lại .</p>
                        </div>
                    @endif
                    <br>

                    <div class="clearfix grid-sorting col-md-4 col-sm-4 col-xs-12" >
                    </div>
                    <div class="clearfix grid-sorting col-md-4 col-sm-4 col-xs-12">
                    </div>
                    <div class="clearfix grid-sorting col-md-4 col-sm-4 col-xs-12">
                        <div class="">
                            <div class="pull-right pull-left-xs">
                                {{$productSearchs->links()}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 grid-left  col-md-pull-9 wow bounceInUp" data-wow-duration="2s">
                <p class="font-20 text-uppercase font-bold ">Kết Quả Tìm Kiếm</p>
                <div id="vertical-menu">
                    <ul class="simple">
                        <li>
                            <h3 class="text-danger font-weight-bold"> Tất Cả </h3>

                        </li>
                    </ul>
                </div>
                <img src="{{asset('public/frontend/assets/images/collection.jpg')}}" alt="" class="img-responsive"> </div>

        <div class="banner hidden-xs hidden-sm"> <img src=" {{asset('public/frontend/assets/images/banner-long.jpg')}}  " alt="" class="img-responsive"></div>
    </div>
@endsection
@section('script')
    <script>$("#vertical-menu h3").click(function () {
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
