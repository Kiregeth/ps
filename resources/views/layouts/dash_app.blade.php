<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>mSuite | {{strtoupper($title)}} </title>

    <!-- Bootstrap -->
    <link href="{{asset('/css/bootstrap.min.css')}}" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="{{asset('/css/font-awesome.css')}}" rel="stylesheet">
    <!-- NProgress -->
    <link href="{{asset('/css/theme/nprogress.css')}}" rel="stylesheet">

    <!-- Custom Theme Style -->
    <link href="{{asset('/css/theme/custom.min.css')}}" rel="stylesheet">
</head>

<style type="text/css">
    .left_col *{
        display: block;
    }
</style>

<body class="nav-md">
<div class="container body">
    <div class="main_container">
        <div class="col-md-3 left_col">
            <div class="left_col scroll-view">

                <div class="navbar nav_title" style="border: 0; min-height: 80px; padding-top: 15px; background-color:white;">
                    <a  href="/" class="site_title" >
                        <img style="min-width:60%;margin-left:auto;margin-right:auto;" src="{{asset('images/pasa-logo.png')}}" height="50px" />
                    </a>
                </div>

                <div class="clearfix"></div>

                <!-- menu profile quick info -->
                <div class="profile clearfix">
                    <div class="profile_pic">
                        <img src="images/img.jpg" alt="..." class="img-circle profile_img">
                    </div>
                    <div class="profile_info">
                        <span>Welcome,</span>
                        <h2>John Doe</h2>
                    </div>
                </div>
                <!-- /menu profile quick info -->

                <br />

                <!-- sidebar menu -->
                <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">

                    @if(Auth::user()->role==='superadmin')
                        <div class="menu_section">
                            <h3>Setup</h3>
                            <ul class="nav side-menu">
                                <li><a href="/employee" @if($title==='employee') class="active" @endif><i class="fa fa-home"></i> Employee </a></li>
                                <li><a><i class="fa fa-home"></i> Manage Item <span class="fa fa-chevron-down"></span></a>
                                    <ul class="nav child_menu">
                                        <li><a href="index.html">Add Item Category</a></li>
                                        <li><a href="index2.html">Edit Item Category</a></li>
                                        <li><a href="index3.html">Manage Package</a></li>
                                        <li><a href="index3.html">Billing Item</a></li>
                                        <li><a href="index3.html">Billing Item Price</a></li>
                                    </ul>
                                </li>
                                <li><a><i class="fa fa-home"></i> System Config <span class="fa fa-chevron-down"></span></a>
                                    <ul class="nav child_menu">
                                        <li><a href="index.html">Settings</a></li>
                                        <li><a href="index2.html">Role</a></li>
                                        <li><a href="index3.html">Group</a></li>
                                        <li><a href="index3.html">Resource</a></li>
                                        <li><a href="index3.html">Menu</a></li>
                                        <li><a href="index3.html">Create Backup</a></li>
                                    </ul>
                                </li>
                                <li><a><i class="fa fa-home"></i> App Config <span class="fa fa-chevron-down"></span></a>
                                    <ul class="nav child_menu">
                                        <li><a href="index.html">Lab Specialist</a></li>
                                        <li><a href="index2.html">Test Advice group</a></li>
                                        <li><a href="index3.html">Test ResultItem</a></li>
                                        <li><a href="index3.html">Image Category</a></li>
                                    </ul>
                                </li>
                            </ul>
                        </div>
                    @elseif(Auth::user()->role==='admin')
                        <div class="menu_section">
                            <h3>Patient Workflow</h3>
                            <ul class="nav side-menu">
                                <li><a href="/patient" @if($title=="patient")class='active';}} @endif><i class="fa fa-home"></i> Search Patient </a></li>
                                <li><a href="index.html"><i class="fa fa-home"></i> Lab Investigation </a></li>
                                <li><a href="index.html"><i class="fa fa-home"></i> New Patient </a></li>
                                <li><a href="index.html"><i class="fa fa-home"></i> Lab Collection </a></li>
                            </ul>
                        </div>
                        <div class="menu_section">
                            <h3>Reports</h3>
                            <ul class="nav side-menu">
                                <li><a href="index.html"><i class="fa fa-home"></i> Report </a></li>
                                <li><a href="index.html"><i class="fa fa-home"></i> Discount Report </a></li>
                                <li><a href="index.html"><i class="fa fa-home"></i> Item Category Report </a></li>
                                <li><a href="index.html"><i class="fa fa-home"></i> Referer Analysis </a></li>
                                <li><a href="index.html"><i class="fa fa-home"></i> Sales Summary </a></li>
                                <li><a href="index.html"><i class="fa fa-home"></i> Consultant Referral </a></li>
                                <li><a href="index.html"><i class="fa fa-home"></i> Advance Report </a></li>
                                <li><a href="index.html"><i class="fa fa-home"></i> Item Group Report </a></li>
                                <li><a href="index.html"><i class="fa fa-home"></i> Refund Report </a></li>
                                <li><a href="index.html"><i class="fa fa-home"></i> Search By Bill No. </a></li>
                            </ul>
                        </div>
                        <div class="menu_section">
                            <h3>Appointments</h3>
                            <ul class="nav side-menu">
                                <li><a href="index.html"><i class="fa fa-home"></i> Appointment List </a></li>
                                <li><a href="index.html"><i class="fa fa-home"></i> Consultant Summary </a></li>
                                <li><a href="index.html"><i class="fa fa-home"></i> New Appointment </a></li>
                                <li><a href="index.html"><i class="fa fa-home"></i> Datewise Appointment List </a></li>
                            </ul>
                        </div>
                        <div class="menu_section">
                            <h3>Setup</h3>
                            <ul class="nav side-menu">
                                <li><a href="index.html"><i class="fa fa-home"></i> Employee </a></li>
                                <li><a><i class="fa fa-home"></i> Manage Item <span class="fa fa-chevron-down"></span></a>
                                    <ul class="nav child_menu">
                                        <li><a href="index.html">Add Item Category</a></li>
                                        <li><a href="index2.html">Edit Item Category</a></li>
                                        <li><a href="index3.html">Manage Package</a></li>
                                        <li><a href="index3.html">Billing Item</a></li>
                                        <li><a href="index3.html">Billing Item Price</a></li>
                                    </ul>
                                </li>
                                <li><a><i class="fa fa-home"></i> System Config <span class="fa fa-chevron-down"></span></a>
                                    <ul class="nav child_menu">
                                        <li><a href="index3.html">Create Backup</a></li>
                                    </ul>
                                </li>
                                <li><a><i class="fa fa-home"></i> App Config <span class="fa fa-chevron-down"></span></a>
                                    <ul class="nav child_menu">
                                        <li><a href="index.html">Lab Specialist</a></li>
                                        <li><a href="index2.html">Test Advice group</a></li>
                                        <li><a href="index3.html">Test ResultItem</a></li>
                                        <li><a href="index3.html">Image Category</a></li>
                                    </ul>
                                </li>
                            </ul>
                        </div>
                    @else
                        <div class="menu_section">
                            <h3>General</h3>
                            <ul class="nav side-menu">
                                <li><a><i class="fa fa-home"></i> Home <span class="fa fa-chevron-down"></span></a>
                                    <ul class="nav child_menu">
                                        <li><a href="index.html">Dashboard</a></li>
                                        <li><a href="index2.html">Dashboard2</a></li>
                                        <li><a href="index3.html">Dashboard3</a></li>
                                    </ul>
                            </ul>
                        </div>
                    @endif
                </div>
                <!-- /sidebar menu -->

                <!-- /menu footer buttons -->
                <div class="sidebar-footer hidden-small">
                    <a data-toggle="tooltip" data-placement="top" title="Settings">
                        <span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
                    </a>
                    <a data-toggle="tooltip" data-placement="top" title="FullScreen">
                        <span class="glyphicon glyphicon-fullscreen" aria-hidden="true"></span>
                    </a>
                    <a data-toggle="tooltip" data-placement="top" title="Lock">
                        <span class="glyphicon glyphicon-eye-close" aria-hidden="true"></span>
                    </a>

                    <a href="{{ route('logout') }}" data-toggle="tooltip" data-placement="top" title="Logout"
                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">

                        <span class="glyphicon glyphicon-off" aria-hidden="true"></span>
                    </a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        {{ csrf_field() }}
                    </form>

                </div>
                <!-- /menu footer buttons -->
            </div>
        </div>

        <!-- top navigation -->
        <div class="top_nav">
            <div class="nav_menu" style="min-height:80px;">
                <nav>
                    <div class="nav toggle">
                        <a id="menu_toggle"><i class="fa fa-bars"></i></a>
                    </div>


                </nav>
            </div>
        </div>
        <!-- /top navigation -->

        <!-- page content -->
        <div class="right_col" role="main">
                &nbsp;
                @section('content')
                @show

        </div>
        <!-- /page content -->

        <!-- footer content -->
        <footer>
            <div class="pull-right">
                Gentelella - Bootstrap Admin Template by <a href="https://colorlib.com">Colorlib</a>
            </div>
            <div class="clearfix"></div>
        </footer>
        <!-- /footer content -->
    </div>
</div>

<!-- jQuery -->
<script src="{{asset('/js/jquery.min.js')}}"></script>
<!-- Bootstrap -->
<script src="{{asset('/js/bootstrap.min.js')}}"></script>
<!-- FastClick -->
<script src="{{asset('/js/theme/fastclick.js')}}"></script>
<!-- NProgress -->
<script src="{{asset('/js/theme/nprogress.js')}}"></script>
{{--<!-- Chart.js -->--}}
{{--<script src="../vendors/Chart.js/dist/Chart.min.js"></script>--}}
{{--<!-- jQuery Sparklines -->--}}
{{--<script src="../vendors/jquery-sparkline/dist/jquery.sparkline.min.js"></script>--}}

<!-- Flot -->
<!--
<script src="../vendors/Flot/jquery.flot.js"></script>
<script src="../vendors/Flot/jquery.flot.pie.js"></script>
<script src="../vendors/Flot/jquery.flot.time.js"></script>
<script src="../vendors/Flot/jquery.flot.stack.js"></script>
<script src="../vendors/Flot/jquery.flot.resize.js"></script>
<!-- Flot plugins
<script src="../vendors/flot.orderbars/js/jquery.flot.orderBars.js"></script>
<script src="../vendors/flot-spline/js/jquery.flot.spline.min.js"></script>
<script src="../vendors/flot.curvedlines/curvedLines.js"></script>
<!-- DateJS
<script src="../vendors/DateJS/build/date.js"></script>
<!-- bootstrap-daterangepicker
<script src="../vendors/moment/min/moment.min.js"></script>
<script src="../vendors/bootstrap-daterangepicker/daterangepicker.js"></script>
-->
<!-- Custom Theme Scripts -->
<script src="{{asset('/js/theme/custom.min.js')}}"></script>


</body>
</html>