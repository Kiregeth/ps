
<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>PASA | {{strtoupper($title)}}</title>

    <!-- Scripts -->
    <script>
        window.Laravel = {!! json_encode([
            'csrfToken' => csrf_token(),
        ]) !!};
    </script>

    <!-- Global stylesheets -->
    <link href="{{ asset('css/theme/bootstrap.css') }}" rel="stylesheet" type="text/css">
    <link href="{{asset('/css/font-awesome.css')}}" rel="stylesheet">
    <link href="{{asset('/css/theme/core.css')}}" rel="stylesheet">
    <link href="{{asset('/css/theme/components.css')}}" rel="stylesheet">
    <link href="{{asset('/css/theme/colors.css')}}" rel="stylesheet">
    <!-- /global stylesheets -->

    <!-- Core JS files -->
    <!-- jQuery -->
    <script src="{{asset('/js/jquery.min.js')}}"></script>
    <!-- Bootstrap -->
    <script src="{{asset('/js/bootstrap.min.js')}}"></script>
    <!-- /core JS files -->
    <script type="text/javascript" src="{{ asset('js/theme/app.js') }}"></script>

    <!-- /theme JS files -->
</head>
<body>

<!-- Main navbar -->
<div class="navbar navbar-default header-highlight">
    <div class="navbar-header">
        <a class="navbar-brand" href="{{'/'}}"><img src="{{ asset('images/pasa-logo.png') }}" alt=""></a>
        <ul class="nav navbar-nav visible-xs-block">
            <li><a data-toggle="collapse" data-target="#navbar-mobile"><i class="icon-tree5"></i></a></li>
            <li><a class="sidebar-mobile-main-toggle"><i class="icon-paragraph-justify3"></i></a></li>
        </ul>
    </div>

    <div class="navbar-collapse collapse" id="navbar-mobile">

    </div>
</div>
<!-- /main navbar -->


<!-- Page container -->
<div class="page-container">

    <!-- Page content -->
    <div class="page-content">

        <!-- Main sidebar -->
        <div class="sidebar sidebar-main">
            <div class="sidebar-content">

                <!-- User menu -->
                <div class="sidebar-user-material">
                    <div class="category-content">
                        <div class="sidebar-user-material-content">
                            {{--<a href="#">--}}
                            {{--<img src="assets/images/demo/users/face11.jpg" class="img-circle img-responsive" alt="">--}}
                            {{--</a>--}}
                            <h6>{{ Auth::user()->name }}</h6>
                            <span class="text-size-small">{{ Auth::user()->email }}</span>
                        </div>

                        <div class="sidebar-user-material-menu">
                            <a href="#user-nav" data-toggle="collapse"><span>My account</span> <i class="caret"></i></a>
                        </div>
                    </div>

                    <div class="navigation-wrapper collapse" id="user-nav">
                        <ul class="navigation">
                            <li><a href="#"><i class="icon-user-plus"></i> <span>My profile</span></a></li>
                            <li><a href="#"><i class="icon-cog5"></i> <span>Account settings</span></a></li>
                            <li>
                                <a href="{{ route('logout') }}"
                                   onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                    <i class="icon-switch2"></i> <span>Logout</span>
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    {{ csrf_field() }}
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
                <!-- /user menu -->


                <!-- Main navigation -->
                <div class="sidebar-category sidebar-category-visible">
                    <div class="category-content no-padding">
                        <ul class="navigation navigation-main navigation-accordion">

                            <!-- Main -->
                            <li class="@if ($title === 'dashboard') active @endif">
                                <a href="/" ><i class="fa fa-home"></i> Dashboard </a>
                            </li>
                            <h5>Operational Management</h5>
                            <li class="@if ($title === 'visitor_log') active @endif">
								<a href="/reception"><i class="fa fa-home"></i> Visitor Log </a>
                            </li>
                        </ul>
                    </div>
                </div>
                <!-- /main navigation -->

            </div>
        </div>
        <!-- /main sidebar -->


        <!-- Main content -->
        <div class="content-wrapper">

            <!-- Content area -->
            <div class="content">

                <!-- Main charts -->
            @section('content')
            @show
            <!-- /main charts -->





                <!-- Footer -->
                <div class="footer text-muted pull-right">
                    &copy;Pasa IT Solution 2017 <a class="btn btn-link" href="http://itspasa.com.np" style="color:green">www.itspasa.com.np</a>
                </div>
                <!-- /footer -->

            </div>
            <!-- /content area -->

        </div>
        <!-- /main content -->
    </div>
    <!-- /page content -->
</div>
<!-- /page container -->
</body>
</html>