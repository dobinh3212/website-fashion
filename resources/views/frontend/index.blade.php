@extends('frontend.layout.main')
@section('main-content')
    <style>

    </style>
    <div data-example-id="simple-carousel" class="below-headeer hidden-xs">

        <div data-ride="carousel" class="carousel slide" id="carousel-example-generic">
            <ol class="carousel-indicators">
                <li class="active" data-slide-to="0" data-target="#carousel-example-generic"></li>
                <li data-slide-to="1" data-target="#carousel-example-generic"></li>
                <li data-slide-to="2" data-target="#carousel-example-generic"></li>
            </ol>

            <div role="listbox" class="carousel-inner">
                @foreach($banners as $key => $banner)
                    <div class="item  {{$key == 0 ? 'active' : '' }}">
                        <img src="{{asset($banner->image)}}" alt="" class="img-responsive hidden-lg">
                        <img src="{{asset($banner->image)}}" alt="" class="img-responsive visible-lg">
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    <div class="clearfix"></div>
    <div class="container">
        <div class="pro-sec clearfix wow bounceInUp" data-wow-duration="2s">
            <div class="col-md-3 col-sm-3 ">
                <div class="row">
                    <!-- Carousel -->
                    <div id="carousel-example-generic-3" class="carousel slide" data-ride="carousel">
                        <!-- Indicators -->
                        <ol class="carousel-indicators">
                            <li data-target="#carousel-example-generic-3" data-slide-to="0" class="active"></li>
                            <li data-target="#carousel-example-generic-3" data-slide-to="1"></li>
                            <li data-target="#carousel-example-generic-3" data-slide-to="2"></li>
                        </ol>
                        <!-- Wrapper for slides -->
                        <div class="carousel-inner">
                            <div class="item active">
                                <div class="black-bg">
                                    <p class="font-25 font-bold text-uppercase">
                                        SẢN PHẨM BÁN CHẠY NHẤT</p>
                                    <p class="font-13">Cập nhật liên tục các sản phẩm được bán chạy trong  tuần .</p>
                                    <p><a href="{{route('shop.productAll')}}" class="view text-uppercase">Xem tất cả sản phẩm </a></p>
                                </div>
                            </div>
                            <div class="item">
                                <div class="black-bg">
                                    <p class="font-25 font-bold text-uppercase"> SẢN PHẨM BÁN CHẠY NHẤT</p>
                                    <p class="font-13">Cập nhật liên tục các sản phẩm được bán chạy trong  tuần  .</p>
                                    <p><a href="{{route('shop.productAll')}}" class="view text-uppercase">Xem tất cả sản phẩm</a></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /carousel -->
                </div>
            </div>
                  @foreach($productHosts as $product)
            <div class="pro-item col-md-3 col-sm-3 "><a href="{{ route('shop.product',$product->slug) }}"><img  style="width:auto!important;max-height:180px!important;" src="{{asset($product->image)}}" alt="" class="img-responsive img-hover"></a>
                <p class="font-15 d-block pt-2">{{$product->name}}</p>
                <p class="font-15 orange font-bold"><del class="light-grey lighter">{{ number_format($product->price,0,",",".") }} ₫</del>{{ number_format($product->price,0,",",".") }} ₫</p>
                    <div class="clearfix mar-top-10">
                        <a href="{{ route('shop.product', $product->slug) }}" title="Xem Chi Tiết" class="cart ">Xem Chi Tiết</a>
                    </div>

            </div>
            @endforeach
        </div>
        <div class="clearfix"></div>
        <div class="row wow home-1 bounceInLeft hidden-sm hidden-xs" data-wow-duration="2s">
            <div class="col-md-6 col-sm-12"> <img src="{{asset('/frontend/assets/images/b-4.jpg')}}" alt="" class="img-responsive  hvr-float" style="height:332px;"></div>
            <div class="col-md-3 col-sm-3">
                <div class="row">
                    <ul class="list-unstyled man-li">
                        <li><img src="{{asset('/frontend/assets/images/b-7.jpg')}}" alt="" class="img-responsive hvr-float"></li>
                        <li><img src="{{asset('/frontend/assets/images/b-9.jpg')}}" alt="" class="img-responsive hvr-float"></li>
                    </ul>
                </div>
            </div>
            <div class="col-md-3 col-sm-3 last-item">
                <div class="row"> <img src="{{asset('/frontend/assets/images/b-5.jpg')}}" alt="" class="img-responsive hvr-float"></div>
            </div>
        </div>
        <div class="clearfix"></div>
        <div class="timer-sec">
            <div class="row wow bounceInRight" data-wow-duration="2s">
                <div class="col-md-3 col-sm-12">
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="feature">
                                <p class="font-18 text-uppercase deals"><span class="font-bold">Supper</span> deals</p>
                            </div>
                        </div>
                    </div>
                    <div class="pro-item">
                        <div class="counter-timer">
                            <ul class="list-unstyled">
                                <li>
                                    <div id="daysBox" class="font-bold font-16">15</div>
                                    Ngày  </li>
                                <li>
                                    <div id="hoursBox" class="font-bold font-16">8</div>
                                    Giờ </li>
                                <li>
                                    <div id="minsBox" class="font-bold font-16">0</div>
                                    Phút </li>
                                <li>
                                    <div id="secsBox" class="font-bold font-16">35</div>
                                    Giây </li>
                            </ul>
                        </div>
                        @foreach($productSupper as $product)
                        <div class="">
                            <a href="{{ route('shop.product',$product->slug) }}"><img style="max-width: 170px;height: auto"   src="{{$product->image}}" alt="" class="img-responsive " ></a> <br>
                            <p class="font-15">{{$product->name}}</p>
                            <img  src="{{asset('/frontend/assets/images/star-rating.png')}}" alt="" class="img-responsive mar-bot-7">
                            <p class="font-15 orange font-bold"><del class="light-grey lighter">{{ number_format($product->price,0,",",".") }} ₫</del>{{ number_format($product->sale,0,",",".") }} ₫</p>
                        </div>
                            @endforeach
                    </div>
                </div>
                <div class="col-md-9 col-sm-12">
                    <div class="row">
                        <div class="col-xs-12 clearfix">
                            <div class="feature clearfix">
                                <p class="font-18 text-uppercase deals pull-left"><span class="font-bold">SẢN PHẨM</span> NỔI BẬT</p>
                                <ul role="tablist" class="tab-links pull-right list-inline" id="myTab">
                                    @foreach($data as $key => $value)
                                    <li class="{{$key == 0 ? 'active' : '' }}" role="presentation"><a aria-expanded="true" aria-controls="{{$value['slug']}}" data-toggle="tab" role="tab" id="{{$value['slug']}}-tab" href="#{{$value['slug']}}">{{$value['name']}}<span class="slash-spacing">/</span></a></li>
{{--                                    <li role="presentation" class=""><a aria-controls="profile" data-toggle="tab" id="profile-tab" role="tab" href="#profile" aria-expanded="false">Đồ Nam<span class="slash-spacing">/</span></a></li>--}}
{{--                                    <li class="active" role="presentation"><a aria-expanded="true" aria-controls="acc" data-toggle="tab" role="tab" id="acc-tab" href="#acc"> Đồ trẻ em<span class="slash-spacing">/</span></a></li>--}}
{{--                                    <li class="active" role="presentation"><a aria-expanded="true" aria-controls="kids" data-toggle="tab" role="tab" id="kids-tab" href="#kids">Phụ Kiện </a></li>--}}
                                    @endforeach
                                </ul>

                            </div>
                        </div>
                    </div>
                    <div class="bs-example bs-example-tabs" role="tabpanel" data-example-id="togglable-tabs">
                        <div id="myTabContent" class="tab-content">
                            @foreach($data as $key=> $value)
                            <div role="tabpanel" class="tab-pane fade in {{$key == 0 ? ' active'  : '' }} " id="{{$value['slug']}}" aria-labelledby="{{$value['slug']}}-tab">
                             @foreach($value['products'] as $item)
                                <div class="col-md-3 col-sm-6 pro-item "  >
                                    <a href="{{ route('shop.product',$item->slug) }}"><img style="width:auto!important;max-height:181px!important;"   class="img-hover img-responsive"  alt=""  src="{{asset($item->image)}}"></a>
                                    <p class="font-15">{{$item->name}}</p>
                                    <p class="font-15 orange font-bold"><del class="light-grey lighter">{{ number_format($item->price,0,",",".") }} ₫ </del>{{ number_format($item->sale,0,",",".") }} ₫</p>
                                    <div class="clearfix ">
                                        <a href="{{ route('shop.product',$item->slug) }}" title="Xem Chi Tiết" class="cart ">Xem Chi Tiết</a>
                                    </div>
{{--                                addCart--}}
                                </div>
                             @endforeach
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="banner hidden-xs hidden-sm"> <img src="{{asset('/frontend/assets/images/banner-long.jpg')}}" alt="" class="img-responsive"></div>
@endsection
