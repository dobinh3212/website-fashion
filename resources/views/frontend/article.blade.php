@extends('frontend.layout.main')
@section('main-content')
    <style>
        .readmore-button {
            display: inline-block;
            vertical-align: top;
            color: #fff;
            background-color: #d8922b;
            padding: 10px 20px;
            text-transform: uppercase;
            list-style: none;
            text-decoration: none;
            font-weight: 500;
        }
        a.readmore-button{
            text-decoration: none;
        }
        .readmore-button:hover {
            background: #333;
            color: #fff;
        }
    </style>
<div class="container">
  @foreach($data as $item)
        <div class="blog-item wow bounceInUp" data-wow-duration="2s"><img style="" src="{{asset($item->image)}}" alt="" class="img-responsive mar-bot-20">
            <div class="blog-disc">
                <div class="col-md-12 col-sm-12 mar-bot-20">
                    <p class="font-22"> {{$item->title}} </p>
                    <p>{!! $item->summary !!} [...]. </p>
                    <div class="clearfix"></div>
                </div>
            </div>
            <div class="line-full mar-bot-10"></div>
            <p class="pull-left"><i class="fa fa-calendar"> {{$item->created_at}}</i></p>
            <p class="pull-right pink"><a href="{{route('shop.detailArticle',$item->slug)}}" class="readmore-button">Xem chi tiết</a></p>
            <div class="clearfix"></div>
            <div class="line-full mar-bot-10"></div>
        </div>
    @endforeach
    <br>
    <br>
      <div class="pull-right pull-left-xs">
          {{$data->links()}}

      </div>

{{--    <a href="frontend/#" class="next-btn pull-right">NEXT&nbsp;►</a> </div>--}}
<br>
<br>
<div class="line-full"></div>
@endsection
