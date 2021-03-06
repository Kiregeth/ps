
<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="icon" href="{{asset('images/favicon.png')}}" />

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>PASA | {{strtoupper(preg_replace('/_+/', ' ', $title))}}</title>

    <!-- Scripts -->
    <script>
        window.Laravel = {!! json_encode([
            'csrfToken' => csrf_token(),
        ]) !!};
    </script>

    <!-- Global stylesheets -->
    <link href="{{ asset('css/theme/bootstrap.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('css/bootstrap-select.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{asset('/css/font-awesome.css')}}" rel="stylesheet">
    <link href="{{asset('/css/theme/core.css')}}" rel="stylesheet">
    <link href="{{asset('/css/theme/components.css')}}" rel="stylesheet">
    <link href="{{asset('/css/theme/colors.css')}}" rel="stylesheet">

    <link href="{{asset('/css/default.css')}}" rel="stylesheet">
    <link href="{{asset('/css/operation.css')}}" rel="stylesheet">
    <!-- /global stylesheets -->

    <!-- Core JS files -->
    <!-- jQuery -->
    <script src="{{asset('/js/jquery.min.js')}}"></script>
    <!-- Bootstrap -->
    <script src="{{asset('/js/bootstrap.min.js')}}"></script>
    <script src="{{asset('/js/bootstrap-select.min.js')}}"></script>
    <!-- /core JS files -->
    <script type="text/javascript" src="{{ asset('js/theme/app.js') }}"></script>

    <!-- /theme JS files -->
</head>

<style rel="stylesheet" type="text/css">

</style>

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

        <div class="pull-left">
            <button title="Show Sidebar" id="ToggleNavScriptRight" class="btn btn-link"
                    data-toggle="collapse" data-target=".navbar-collapse" >
                <i style="color:black !important;" class="fa fa-caret-square-o-right fa-2x" aria-hidden="true"></i>
            </button>
        </div>

        <!-- Main sidebar -->
        <div id="sidebar" class="sidebar sidebar-main">
            <div class="sidebar-content">

                <!-- User menu -->
                <div class="sidebar-user-material">
                    <div class="category-content">
                        <div class="sidebar-user-material-content">
                            {{--<a href="#">--}}
                            {{--<img src="assets/images/demo/users/face11.jpg" class="img-circle img-responsive" alt="">--}}
                            {{--</a>--}}
                            <div class="pull-right">
                                <button title="Hide Sidebar" id="ToggleNavScriptLeft" class="btn btn-link"
                                        data-toggle="collapse" data-target=".navbar-collapse" >
                                    <i style="color:white !important;" class="fa fa-caret-square-o-left fa-2x" aria-hidden="true"></i>
                                </button>
                            </div>
                            <h6>{{ Auth::user()->name }}</h6>
                            <span class="text-size-small">{{ Auth::user()->email }}</span>
                        </div>

                        <div class="sidebar-user-material-menu">
                            <a href="#user-nav" data-toggle="collapse" @if($title=='change_pwd' || $title=='change_dp')aria-expanded="true" @endif>
                                <span>My account</span> <i class="fa fa-chevron-circle-down" aria-hidden="true"></i>
                            </a>
                        </div>
                    </div>

                    <div class="navigation-wrapper collapse @if($title=='change_pwd' || $title=='change_dp')in @endif" id="user-nav">
                        <ul class="navigation">
                            <li><a href="#"><i class="icon-user-plus"></i> <span>Change Display Picture</span></a></li>
                            <li class="@if ($title === 'change_pwd') active @endif"><a href="/change_pwd"><i class="icon-cog5"></i> <span>Change Password</span></a></li>
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
                            @if(in_array('operation-view',session('permission')))
                            <li>
                                <a class="li-head" href="#operation-nav" data-toggle="collapse">
                                    <span>Operation Management</span> <i class="fa fa-chevron-circle-down" aria-hidden="true"></i>
                                </a>
                                <div class="navigation-wrapper collapse @if($title=='visitor_log' || $title=='application_form' || $title=='app_forms' || $title=='online_forms') in @endif" id="operation-nav">
                                    <ul class="navigation">
                                        <li class="@if ($title === 'visitor_log') active @endif">
                                            <a href="/reception"><i class="fa fa-university"></i> Visitor Log </a>
                                        </li>
                                        <li class="@if ($title === 'application_form') active @endif">
                                            <a href="/application_form"><i class="fa fa-plus-circle"></i> Add Applicants</a>
                                        </li>
                                        <li class="@if ($title === 'app_forms') active @endif">
                                            <a href="/app_forms"><i class="fa fa-table"></i> Application Forms</a>
                                        </li>
                                        <li class="@if ($title === 'online_forms') active @endif">
                                            <a href="/online_forms"><i class="fa fa-table"></i> Online Forms</a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                            @endif
                            @if(in_array('view',session('permission')))
                            <li>
                                <a class="li-head" href="#databank-nav" data-toggle="collapse">
                                    <span>Databank Management</span> <i class="fa fa-chevron-circle-down" aria-hidden="true"></i>
                                </a>
                                <div class="navigation-wrapper collapse @if($title=='new_databank' || $title=='new_visa' || $title=='new_deployment' || $title=='new_visa_receive' || $title=='new_preset' || $title='interviewweb')in @endif" id="databank-nav">
                                    <ul class="navigation">
                                        <li class="@if ($title === 'new_databank') active @endif">
                                            <a href="/new_databank"><i class="fa fa-database"></i>Databank </a>
                                        </li>
                                        <li class="@if ($title === 'interview') active @endif">
                                            <a href="/interview"><i class="fa fa-question-circle"></i>Interview </a>
                                        </li>
                                        <li class="@if ($title === 'new_visa') active @endif">
                                            <a href="/new_visa"><i class="fa fa-cc-visa"></i>Visa Process </a>
                                        </li>
                                        <li class="@if ($title === 'new_visa_receive') active @endif">
                                            <a href="/new_visa_receive"><i class="fa fa-life-ring"></i>Visa Receive </a>
                                        </li>
                                        <li class="@if ($title === 'new_deployment') active @endif">
                                            <a href="/new_deployment"><i class="fa  fa-share-square-o"></i>Deployment </a>
                                        </li>
                                        <li class="@if ($title === 'new_preset') active @endif">
                                            <a href="/new_preset"><i class="fa fa-cog"></i>Field Preset</a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                            <li>
                                <a class="li-head" href="#old-operation-nav" data-toggle="collapse">
                                    <span>Old Databank Management</span> <i class="fa fa-chevron-circle-down" aria-hidden="true"></i>
                                </a>
                                <div class="navigation-wrapper collapse @if($title=='databank' || $title=='visa' || $title=='deployment')in @endif" id="old-operation-nav">
                                    <ul class="navigation">
                                        <li class="@if ($title === 'databank') active @endif">
                                            <a href="/databank"><i class="fa  fa-database"></i>Old Databank </a>
                                        </li>
                                        <li class="@if ($title === 'visa') active @endif">
                                            <a href="/visa"><i class="fa fa-cc-visa"></i>Old Visa Process </a>
                                        </li>
                                        <li class="@if ($title === 'deployment') active @endif">
                                            <a href="/deployment"><i class="fa fa-share-square-o"></i>Old Deployment </a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                            @endif
                            {{--@if(Auth::user()->role==='admin' || Auth::user()->role==='superadmin')--}}
                            {{--<li>--}}
                                {{--<a class="li-head" href="#user-mgmt-nav" data-toggle="collapse">--}}
                                    {{--<span>User Management</span> <i class="fa fa-chevron-circle-down" aria-hidden="true"></i>--}}
                                {{--</a>--}}
                                {{--<div class="navigation-wrapper collapse @if($title=='add_user' || $title=='users')in @endif" id="user-mgmt-nav">--}}
                                    {{--<ul class="navigation">--}}
                                        {{--<li class="@if ($title === 'add_user') active @endif">--}}
                                            {{--<a href="/add_user"><i class="fa fa-user-plus"></i> Add User</a>--}}
                                        {{--</li>--}}
                                        {{--<li class="@if ($title === 'users') active @endif">--}}
                                            {{--<a href="/users"><i class="fa fa-users"></i> Users </a>--}}
                                        {{--</li>--}}
                                    {{--</ul>--}}
                                {{--</div>--}}
                            {{--</li>--}}
                            {{--@endif--}}
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
                <div class="footer">
                    &copy;Pasa IT Solution 2017 <a target="_blank" class="btn btn-link" href="http://itspasa.com.np" style="color:green">www.itspasa.com.np</a>
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

<script type="text/javascript">
    $("#ToggleNavScriptLeft").click(function() {
        $('#sidebar').hide();
    });
    $("#ToggleNavScriptRight").click(function() {
        $('#sidebar').show();
    });
</script>


</body>
</html>