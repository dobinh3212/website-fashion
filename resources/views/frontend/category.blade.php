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
            <img src="{{asset(' /frontend/assets/images/carousel-img.png')}}" alt="" class="img-responsive">

        </div>
    </div>
</div>
<div class="container grid-main">
    <div class="row">
        <div class="col-md-9 grid-right  col-md-push-3 wow bounceInUp" data-wow-duration="2s">
            <div class="row">
                <div class="clearfix grid-sorting col-md-4 col-sm-4 col-xs-12" >
                    <div class="">
                        <div class="pull-left ">
                            <form method="GET" action="" id="filter-arrange" >
                            <select class="grid-controll form-control form-search "  name="orderBy" id="orderBy">
                                <option  {{Request::get('orderBy') == '' ? "selected='selected'":""}} value="">Mặc định</option>
                                <option   {{Request::get('orderBy') == '1' ? "selected='selected'":""}} value="1" >Từ A-Z</option>
                                <option  {{Request::get('orderBy') == '2' ? "selected='selected'":""}} value="2">Từ Z-A</option>
                                <option {{Request::get('orderBy') == '3' ? "selected='selected'":""}} value="3" >Giá ( Cao > Thấp )</option>
                                <option {{Request::get('orderBy') == '4' ? "selected='selected'":""}} value="4">Giá ( Thấp < Cao )</option>
                            </select>
                            </form>
                        </div>
                        <div class="pull-left">
                            <p class="mar-top-7"> Sắp Xếp</p>
                        </div>
                    </div>
                </div>
                <div class="clearfix grid-sorting col-md-4 col-sm-4 col-xs-12">
                </div>
                <div class="clearfix grid-sorting col-md-4 col-sm-4 col-xs-12">
                    <div class="">
                        <div class="pull-right pull-left-xs" style="border-bottom: 2px solid slategray">
                            <p>Hiện tại có <span class="text-danger" style="color: red;font-weight: bold"> {{count($data['products'])}} </span>  sản phẩm !!!</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                @if ($data['products']->count()> 0)
                <ul class="list-unstyled grid-items clearfix">
                    @foreach($data['products'] as $product)
                    <li class="col-md-4 col-sm-4 wow bounceInUp" data-wow-duration="2s">
                        <div class="img-about">
                            <a href="{{ route('shop.product',$product->slug) }}"><img  style="width:auto;height:250px;!important;" src="{{asset($product->image)}}" class="img-responsive img-hover" alt=""></a>
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
                        <img src="{{ asset('/frontend/assets/images/noti-search.png') }}" alt="">
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
                            {{$data['products']->links()}}

                        </div>
                    </div>
                </div>
            </div>
        </div>


{{--   Side-Bar--}}
        <div class="col-md-3 grid-left  col-md-pull-9 wow bounceInUp" data-wow-duration="2s">

            <p class="font-20 text-uppercase font-bold line-long">DANH MỤC</p>
            <div id="vertical-menu">
                <ul class="simple">
                    <li>
                        <h3>{{ $data['name']  }}</h3>

                    </li>
                </ul>
            </div>
            <p class="font-20 text-uppercase font-bold line-long">LỌC </p>
                <form method="GET" action="" id="filter-price">
                    <input type="hidden" name="orderBy" value="{{Request::get('orderBy')}}">
            <p class="font-18 text-uppercase font-bold orange">Giá</p>
            <ul class="list-unstyled simple" >
                <li>
                    <i class="fa fa-caret-right " aria-hidden="true" style="font-size:14px;padding-right:5px"></i>
                    <span class="">
                            <input type="radio" class="filter-price" name="r-price" value="0" {{Request::get('r-price') == '0' ? "checked":""}} />
            </span>
                    <span class="pull-right font-13"> Tất Cả</span>
                </li>

                <li>
                  <i class="fa fa-caret-right " aria-hidden="true" style="font-size:14px;padding-right:5px"></i>
                  <span class="">
                            <input type="radio" class="filter-price" name="r-price" value="1" {{Request::get('r-price') == '1' ? "checked":""}} />
            </span>
                  <span class="pull-right font-13"> Dưới 100.000đ</span>
              </li>
                <li>
                    <i class="fa fa-caret-right " aria-hidden="true" style="font-size:14px;padding-right:5px"></i>
                    <span class="">
                            <input type="radio" class="filter-price" name="r-price" value="2" {{Request::get('r-price') == '2' ? "checked":""}}/>
            </span>
                    <span class="pull-right"> 100.000đ -300.000đ </span>
                </li>
                <li>
                    <i class="fa fa-caret-right "  aria-hidden="true" style="font-size:14px;padding-right:5px"></i>
                    <span class="">
                            <input type="radio" class="filter-price" name="r-price" value="3" {{Request::get('r-price') == '3' ? "checked":""}}/>
            </span>
                    <span class="pull-right"> 300.000đ -500.000đ </span>
                </li>
                <li>
                    <i class="fa fa-caret-right " aria-hidden="true" style="font-size:14px;padding-right:5px"></i>
                    <span class="">
                            <input type="radio" class="filter-price" name="r-price" value="4" {{Request::get('r-price') == '4' ? "checked":""}}/>
            </span>
                    <span class="pull-right"> 500.000đ -800.000đ </span>
                </li>
                <li>
                    <i class="fa fa-caret-right " aria-hidden="true" style="font-size:14px;padding-right:5px"></i>
                    <span class="">
                            <input type="radio"  class="filter-price" name="r-price" value="5" {{Request::get('r-price') == '5' ? "checked":""}}/>
            </span>
                    <span class="pull-right"> Trên 800.000đ </span>
                </li>
            </ul>
                    <p class="font-18 text-uppercase font-bold orange">THƯƠNG HIỆU</p>
                    <ul class="list-unstyled simple" >
                        <li>
                            <i class="fa fa-caret-right " aria-hidden="true" style="font-size:14px;padding-right:5px"></i>
                            <span class="">
                            <input type="radio" class="filter-brand"  name="r-brand" value="all"  {{Request::get('r-brand') == 'all' ? "checked":""}} />
                        </span>
                            <span class="pull-right"> Tất Cả </span>
                        </li>
                        @if($brands)
                            @foreach($brands as $item)
                                <li>
                                    <i class="fa fa-caret-right " aria-hidden="true" style="font-size:14px;padding-right:5px"></i>
                                    <span class="">
                            <input type="radio" class="filter-brand"  name="r-brand" value="{{$item->id}}" {{Request::get('r-brand') == $item->id ?"checked":""}} />
                        </span>
                                    <span class="pull-right">{{$item->name}} </span>
                                </li>
                            @endforeach
                        @endif
                    </ul>


            <br>
            <div class="clearfix"></div>
            <br>
{{--        End side-bar--}}
</form>
    </div>
</div>

    <div class="banner hidden-xs hidden-sm"> <img src=" {{asset('/frontend/assets/images/banner-long.jpg')}}  " alt="" class="img-responsive"></div>
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
    })

</script>
@stop
