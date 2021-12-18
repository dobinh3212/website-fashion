<!DOCTYPE html>
<html lang="en">

<!-- Mirrored from levantech.com/workdemo/fashion/html/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 17 Aug 2015 02:18:10 GMT -->
<head>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" sizes="16x16"  href="{{asset('public/frontend/assets/images/favicon-16x16.png')}}">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="theme-color" content="#ffffff">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Fashion</title>

    <!-- Bootstrap -->
    <link href="{{ asset('public/frontend/assets/css/bootstrap/bootstrap-theme.min.css') }} " rel="stylesheet"
          type="text/css" />
    <link href="{{asset('public/frontend/assets/css/bootstrap.min.css')}}" rel="stylesheet">

    <!-- Font Awesome Styles -->
    <link type="text/css" rel="stylesheet" href="{{asset('public/frontend/assets/css/font-awesome.css')}}">
    <link href="{{ asset('public/frontend/assets/css/carousel/owl.carousel.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('public/frontend/assets/css/carousel/owl.theme.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('public/frontend/assets/css/lightgallery.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('public/frontend/assets/css/lightslider.css') }}" rel="stylesheet" type="text/css" />
    <!-- Bootstrap Styles -->
    <link href="{{asset('public/frontend/assets/css/menu-horizontal.css')}}" rel="stylesheet">


    <link href="{{asset('public/frontend/assets/css/style-horizontal.css')}}   " rel="stylesheet">
    <!--animations-->
    <link href="{{asset('public/frontend/assets/css/animate.css')}}   " rel="stylesheet" type="text/css">
    <link href="{{asset('public/frontend/assets/css/hover.css')}}" rel="stylesheet" type="text/css">

</head>
<body>
@include('frontend.layout.header')
@include('sweetalert::alert')
@yield('main-content')


@include('frontend.layout.footer')


<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="{{asset('public/frontend/assets/js/jquery-v11.js')}}"></script>

<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="{{asset('public/frontend/assets/js/bootstrap.min.js')}}   "></script>
<script src="{{ asset('public/frontend/assets/js/elevatezoom-master/jquery.elevatezoom.js') }}" type="text/javascript">
</script>
<script src="{{ asset('public/frontend/assets/js/carousel/owl.carousel.js') }}" type="text/javascript"></script>
<script src="{{asset('public/frontend/assets/js/sweetalert2.all.min.js')  }} "></script>

<!-- Main Scripts-->

<script src="{{asset('public/frontend/assets/js/search.js')}}"></script>
<script src="{{asset('public/frontend/assets/js/ttmenu.js')}}"></script>
<script src="{{asset('public/frontend/assets/js/readmore.js')}}"></script>

<script src="{{asset('public/frontend/assets/js/main.js')}}"></script>
<script src="{{asset('public/frontend/assets/js/custom.js')}}"></script>
<script src="{{asset('public/frontend/assets/js/cart.js')}}"></script>
<script src="{{ asset('public/frontend/assets/js/lightgallery-all.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('public/frontend/assets/js/lightslider.js') }}" type="text/javascript"></script>


{{--<script>--}}

{{--    cdtd();--}}
{{--</script>--}}

<!--animations-->
<script src="{{asset('public/frontend/assets/js/wow.min.js')}}"></script>
<script>
    new WOW().init();
</script>
<!-- Messenger Plugin chat Code -->
<div id="fb-root"></div>

<!-- Your Plugin chat code -->
<div id="fb-customer-chat" class="fb-customerchat">
</div>

<script>
    var chatbox = document.getElementById('fb-customer-chat');
    chatbox.setAttribute("page_id", "105433425274904");
    chatbox.setAttribute("attribution", "biz_inbox");

    window.fbAsyncInit = function() {
        FB.init({
            xfbml            : true,
            version          : 'v12.0'
        });
    };

    (function(d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) return;
        js = d.createElement(s); js.id = id;
        js.src = 'https://connect.facebook.net/vi_VN/sdk/xfbml.customerchat.js';
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));
</script>
@yield('scripts')




</body>

<!-- Mirrored from levantech.com/workdemo/fashion/html/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 17 Aug 2015 02:20:02 GMT -->
</html>
