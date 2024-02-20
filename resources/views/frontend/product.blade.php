@extends('frontend.layout.main')
@section('main-content')
    <style>
        #imageGallery .img-product {
            width: 400px;
            height: 400px;
            object-fit: cover;
        }
     .lSSlideOuter  ul.lSPager  li{
         width: 100%;
         width: 55.15833333333333px!important;
         margin-right: 5px;
     }
    </style>
<div class="container grid-main">
    <div class="row">
        <div class="col-md-12 detail-right wow bounceInDown" data-wow-duration="4s">
            <form action="{{route('cart.add',$product->id)}}" >
            <div class="row">
                <div class="col-md-5 col-sm-6 col-xs-12">
                 <div class="slider-pro">
                           <ul id="imageGallery">
                               @foreach ($productImgs as $item)
                                   <li data-thumb="{{ asset($item->image) }}"
                                       data-src="{{ asset($item->image) }}">
                                       <img class="img-thumbnail img-product" src="{{asset($item->image) }}" />
                                   </li>
                               @endforeach
                           </ul>
                    </div>
                </div>
                <div class="col-md-7 col-sm-6 col-xs-12">
                    <p class="font-26 mar-bot-0">{{ $product->name }}</p>
                    <img src= "{{asset('/frontend/assets/images/star-rating.png')}} " alt="">
                    <div class="clearfix mar-top-10"></div>
                    <p class="font-20 orange pull-left">

                        <input type="hidden" name="getPrice" class="getPrice"  value="">
                        <span class="getAttrPrice"> {{ number_format($product->sale,0,",",".") }}₫ </span>  <del class="light-grey">{{ number_format($product->price,0,",",".") }}₫</del>

                    <div class="clearfix"></div>
                    <br>
                     <p>Mã hàng :<span class="text-danger"> {{$product->sku}}</span></p>
                    <p>{!! $product->summary !!} </p>
                    <br>
                    <div class="single-product-size">
                        <p class="small-title">Kích thước </p>
                        @if(session('error'))
                            <div class="alert alert-danger text-danger small-title">
                                {{session('error')}}
                            </div>
                        @endif
                        <select name="productSize" id="product-size" product-id="{{$product->id}}" >

                            <option  value="">Chọn Size</option>
                               @foreach($product['attributes'] as $attribute)
                                   @if($attribute ->status ==1)
                            <option value="{{$attribute->size}}">{{$attribute->size}}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                    <div class="line-full"></div>
                    <div class="clearfix"></div>

                    <br>
                    <div class="quantity-sec">
                        <div class="pull-left">
                            <label>Số lượng:</label>
                            <input type="number" name="num-order" value="1" class="qty">
                        </div>
                        <div class="pull-left cart-sec">
                            <button class="cart-pink pull-left"  type="submit" >Thêm giỏ hàng</button>
                        </div>
{{--                        <div class="pull-left cart-sec"> <a class="cart-pink pull-left" href="#">Mua ngay</a> </div>--}}
                        <div class="clearfix"></div>
                        <br>
                        <br>
                        <div class="line-full mar-bot-10"></div>
                        <p>Danh mục  :<span class="pink">&nbsp;{{ isset($product->categories) ? $product->categories->name : ''}}</span></p>
                        <div class="line-full mar-bot-10"></div>

                    </div>
                </div>
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="row mar-top-20">
                        <div class="col-xs-12 clearfix">
                            <div class="feature clearfix">
                                <ul id="myTab" class="tab-links list-inline" role="tablist">
                                    <li role="presentation" class="active"><a href="#home" id="home-tab" role="tab" data-toggle="tab" aria-controls="home" aria-expanded="true">Mô tả<span class="slash-spacing">/</span></a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div data-example-id="togglable-tabs" role="tabpanel" class="bs-example bs-example-tabs">
                        <div class="tab-content feature-border" id="myTabContent">
                            <div aria-labelledby="home-tab" id="home" class="tab-pane fade active in" role="tabpanel">
                                 <div class="detail">
                                     {!! $product->description !!}
                                 </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            </form>
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-xs-12 clearfix">
            <div class="feature clearfix">
                <p class="font-18 text-uppercase deals pull-left"><span class="font-bold">Sản phẩm</span> Đã Xem</p>
            </div>
        </div>
    </div>
    <div data-example-id="togglable-tabs" role="tabpanel" class="bs-example bs-example-tabs">
        <div class="tab-content">
            <div aria-labelledby="home-tab"  class="tab-pane fade active in" role="tabpanel">
                @foreach($viewedProducts as $product)
                <div class="col-md-3 col-sm-6 pro-item" style="max-height:350px!important;" >
                    <a href="{{ route('shop.product', $product->slug) }}"><img style="width:auto!important;max-height:181px!important;"   src="{{ asset($product->image) }}" alt=""   class="img-responsive img-hover"></a>
                    <p class="font-14"><a href="{{ route('shop.product', $product->slug) }}"></a>{{ $product->name }}</p>
                    <p class="font-15 orange font-bold"><del class="light-grey lighter">{{ number_format($product->price,0,",",".") }} ₫ </del>{{ number_format($product->sale,0,",",".") }} ₫</p>
                    <div class="clearfix mar-top-10">
                        <a href="{{ route('shop.product', $product->slug) }}" title="Xem Chi Tiết" class="cart ">Xem Chi Tiết</a>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
<br>
<br>
<br>
<div class="banner hidden-xs hidden-sm"> <img src="{{asset('/frontend/assets/images/banner-long.jpg')}}" alt="" class="img-responsive"></div>
@endsection
@section('scripts')

    <script>
        $(document).ready(function () {
            $('.detail').readmore({
                speed: 100,
                moreLink: '<a href="#" class="accordion" style=" border: 1px solid #2f80ed; border-radius: 5px;    color: #2f80ed;    display: block;    margin: 0 auto;    max-width: 340px;    padding: 10px 5px; text-align: center;margin-top: 40px;">XEM THÊM</a>',
                lessLink: '<a href="#" class="accordion" style=" border: 1px solid #2f80ed; border-radius: 5px;    color: #2f80ed;    display: block;    margin: 0 auto;    max-width: 340px;    padding: 10px 5px; text-align: center;margin-top: 40px;">ẨN BỚT</a>',
                collapsedHeight: 900,
                heightMargin:1,
            });
        })
    </script>

    <script>
        $(document).ready(function () {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
           $("#product-size").change(function () {
                var size = $(this).val();
                var product_id= $(this).attr('product-id');
                $.ajax({
                   url :'/get-product-price',
                   data:{size:size,product_id:product_id},
                    type:"get",
                    success:function (resp) {
                           $(".getAttrPrice").html(""+resp+"₫");
                           $(".getPrice").val(""+resp+"");
                    },error:function () {
                            alert('Lỗi');
                    }
                });
           })
        })
    </script>



@stop
