
<!DOCTYPE html>
<html>
<head>
	<!-- Global site tag (gtag.js) - Google Analytics -->
	<script async src="https://www.googletagmanager.com/gtag/js?id=UA-109277679-1"></script>
	<script>
	  window.dataLayer = window.dataLayer || [];
	  function gtag(){dataLayer.push(arguments);}
	  gtag('js', new Date());

	  gtag('config', 'UA-109290406-1');

	</script>
    <script type="text/javascript">
        window.App = {
            Settings: {
                root: "/"
            }
        };
    </script>

    <meta charset="utf-8">
    <title> @yield('title') - Продюсерський центр МіК</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="keywords" content="{{ $meta->meta_keywords }}"/>
    <meta name="description" content="{{ $meta->meta_description }}"/>
    <link href="{{ asset('assets/img/mik_icon.png') }}" rel="shortcut icon" type="image/png" />
    <link rel="stylesheet" href="{{asset('assets/components/bootstrap/dist/css/bootstrap.min.css')}}">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ URL::asset('assets/components/font-awesome/css/font-awesome.min.css')}}">

    <link type="text/css" rel="stylesheet" href="{{ asset('assets/css/style.css') }}"/>
    <link type="text/css" rel="stylesheet" href="{{ asset('assets/css/font-awesome-animation.min.css') }}"/>
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300,700' rel='stylesheet' type='text/css' />
    <link href='https://fonts.googleapis.com/css?family=Raleway:400,300italic,400italic,500italic,500,300,600,600italic,200' rel='stylesheet' type='text/css'>
    @yield('Stylesheets')
</head>
<body>
<div id="content">
    <header class="clearfix">
        <div class="container">
            <div class="logo">
                <a href="/"><img src="{{ asset('assets/img/mik_logo.png') }}" class="img-responsive" /> </a>

            </div>
            <a type="button" class="navbar-toggle pull-right" data-toggle="collapse" data-target="#mainMenu">
                <i class="fa fa-bars fa-2x"></i>
            </a>

            <div class="heading">
                @include('layouts.frontend.partials.navigation')
            </div>
        </div>
    </header>
    @yield('content')
</div>
<script src="{{ URL::asset('assets/components/jquery/dist/jquery.min.js') }}"></script>
<script src="{{ URL::asset('assets/components/bootstrap/dist/js/bootstrap.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/js/common.js') }}"></script>
@yield('Scripts')
<script>
    $(function() {
        App.Page._common();
    });
</script>
</body>
</html>