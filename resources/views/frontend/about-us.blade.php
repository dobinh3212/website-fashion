@extends('frontend.layout.main')
@section('main-content')
    <div class="container mega-main clearfix">

        <br>
        <div class="row">
            <div class="col-md-9 col-md-push-3 col-sm-push-4 col-sm-8 wow bounceInLeft" data-wow-duration="2s">
                <div data-example-id="simple-carousel" class="below-headeer hidden-xs"> <img src="" alt="" class="img-responsive"> </div>
                <p class="font-14  text-center mar-top-20">{!!$article ->summary !!}</p>
                <div class="line-full mar-bot-10"></div>
                <p class="text-center"><i class="fa fa-calendar" aria-hidden="true"></i> <span class="pink"> {{$article->created_at}}</span></p>
                <div class="clearfix"></div>
                <div class="line-full mar-bot-10"></div>
                <p ><img class="img-thumbnail img-responsive" width="100%" src="{{asset($article->image)}}" alt=""> </p>
                <blockquote>{!!$article ->description !!}</blockquote>
                <br>
                <br>
                <div class="line-full mar-bot-10"></div>
                <p><i class="fa fa-calendar" aria-hidden="true"></i> <span class="pink"> &nbsp;{{$article->created_at}}</span></p>
                <div class="clearfix"></div>
                <div class="line-full mar-bot-10"></div>
                <br>
                <br>
                <br>
            </div>
            <div class="col-md-3 col-sm-4 col-md-pull-9 col-sm-pull-8 col-xs-pull-0 wow bounceInRight" data-wow-duration="2s">
                <p class="font-18 text-uppercase font-bold line-long">TIN TỨC</p>
                <br>
                <p class="font-18 text-uppercase font-bold line-long">DANH MỤC </p>

                <ul class="list-unstyled simple">
                    @foreach($categories as $parent)
                        @if($parent->parent_id == 0 )
                            <li><a href="frontend/#"> {{$parent->name}}</a></li>
                        @endif
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
    <div class="clearfix"></div>

@endsection
