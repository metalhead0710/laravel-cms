<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>@yield('title')</title>

    <link rel="stylesheet" href="{{asset('assets/components/bootstrap/dist/css/bootstrap.min.css')}}">
    <!-- Google fonts - Roboto -->
    <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Roboto:300,400,500,700">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ URL::asset('assets/components/font-awesome/css/font-awesome.min.css')}}">
    <!-- MetisMenu CSS -->
    <link href="{{ URL::asset('assets/components/metisMenu/metisMenu.min.css') }}" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="{{ URL::asset('assets/css/sb-admin-2.css') }}" rel="stylesheet">
    @yield('Stylesheets')
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>

<div id="wrapper">

    <!-- Navigation -->
    <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
    <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="{{ route('home') }}">Переглянути сайт</a>
    </div>
    <!-- /.navbar-header -->

    <ul class="nav navbar-top-links navbar-right">
    <li class="dropdown">
        <a class="dropdown-toggle" data-toggle="dropdown" href="#">
            @if($count > 0)
            <span class="badge badge-info">{{$count}}</span>
            @endif
            <i class="fa fa-envelope fa-fw"></i>
            <i class="fa fa-caret-down"></i>
        </a>
        <ul class="dropdown-menu dropdown-messages">
            @if($count < 1)
            <div class="note note-info text-center">
                <h5>
                    Нових повідомлень немає
                </h5>
            </div>
            @endif
            @foreach($newMsg as $msg)
            <li>
                <a href="#">
                    <div>
                        <strong>{{ $msg->sendname }} </strong>
                                        <span class="pull-right text-muted">
                                            <em>{{ $msg->created_at->format('d.m.Y') }}</em>
                                        </span>
                    </div>
                    <div>{{ str_limit($msg->content, 150, '...') }}</div>
                </a>
            </li>
            <li class="divider"></li>
            @endforeach
            <li>
                <a class="text-center" href="{{ route('admin.messages') }}">
                    <strong>Всі повідомлення</strong>
                    <i class="fa fa-angle-right"></i>
                </a>
            </li>
        </ul>
        <!-- /.dropdown-messages -->
    </li>

    <li class="dropdown">
        <a class="dropdown-toggle" data-toggle="dropdown" href="#">
            <i class="fa fa-user fa-fw"></i> <i class="fa fa-caret-down"></i>
        </a>
        <ul class="dropdown-menu dropdown-user">

            <li class="divider"></li>
            <li><a href="{{ route('auth.logout')}}"><i class="fa fa-sign-out fa-fw"></i> Вийти</a>
            </li>
        </ul>
        <!-- /.dropdown-user -->
    </li>
    <!-- /.dropdown -->
    </ul>
    <!-- /.navbar-top-links -->

    @include('layouts.backend.partials.navigation')
    <!-- /.navbar-static-side -->
    </nav>
        <div id="page-wrapper">
        @yield('content')
    </div>
    <!-- /#page-wrapper -->
    <footer class="text-center">
        <strong>©</strong> <?php echo date("Y");?>. Mik. На всі права покладено великий болт.
    </footer>
</div>
<!-- /#wrapper -->

<script src="{{ URL::asset('assets/components/jquery/dist/jquery.min.js') }}"></script>

<!-- Bootstrap 3.3.7 -->
<script src="{{ URL::asset('assets/components/bootstrap/dist/js/bootstrap.min.js') }}"></script>

<!-- Metis Menu Plugin JavaScript -->
<script src="{{ URL::asset('assets/components/metisMenu/metisMenu.min.js') }}"></script>

<!-- Custom Theme JavaScript -->
<script src="{{ asset('assets/js/sb-admin-2.js') }}"></script>

@yield('Scripts')

</body>

</html>