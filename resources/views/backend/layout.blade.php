<!DOCTYPE html>
<html>
<meta http-equiv="content-type" content="text/html;charset=utf-8" />
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>@yield('title')</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.7 -->
    <meta name="csrf-token" content="{{csrf_token()}}">
    <link rel="stylesheet" href="{{url('public/asset/bower_components/bootstrap/dist/css/bootstrap.min.css')}}">
    <!-- Font Awesome -->
    <link rel="stylesheet"  href="{{url('public/asset/bower_components/font-awesome/css/font-awesome.min.css')}}">
    <!-- Ionicons -->
    <link rel="stylesheet"  href="{{url('public/asset/bower_components/Ionicons/css/ionicons.min.css')}}">
    <!-- daterange picker -->
{{--    <link rel="stylesheet"  href="{{url('public/asset/bower_components/bootstrap-daterangepicker/daterangepicker.css')}}">--}}
    <!-- bootstrap datepicker -->
{{--    <link rel="stylesheet"  href="{{url('public/asset/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css')}}">--}}
    <!-- iCheck for checkboxes and radio inputs -->
    <link rel="stylesheet"  href="{{url('public/asset/plugins/iCheck/all.css')}}">
    <!-- Bootstrap Color Picker -->
    <link rel="stylesheet"  href="{{url('public/asset/bower_components/bootstrap-colorpicker/dist/css/bootstrap-colorpicker.min.css')}}">
    <!-- Bootstrap time Picker -->
{{--    <link rel="stylesheet"  href="{{url('public/asset/plugins/timepicker/bootstrap-timepicker.min.css')}}">--}}
    <!-- Select2 -->
    <link rel="stylesheet"  href="{{url('public/asset/bower_components/select2/dist/css/select2.min.css')}}">
    <!-- Theme style -->
    <link rel="stylesheet"  href="{{url('public/asset/dist/css/AdminLTE.min.css')}}">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet"  href="{{url('public/asset/dist/css/skins/_all-skins.min.css')}}">
    <link rel="stylesheet"  href="{{url('public/asset/toast/jquery.toast.css')}}">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    @yield('extracss')
    <![endif]-->

    <!-- Google Font -->
    <link rel="stylesheet"
          href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
    <style>
        .col-lg-1, .col-lg-10, .col-lg-11, .col-lg-12, .col-lg-2, .col-lg-3, .col-lg-4, .col-lg-5, .col-lg-6, .col-lg-7, .col-lg-8, .col-lg-9, .col-md-1, .col-md-10, .col-md-11, .col-md-12, .col-md-2, .col-md-3, .col-md-4, .col-md-5, .col-md-6, .col-md-7, .col-md-8, .col-md-9, .col-sm-1, .col-sm-10, .col-sm-11, .col-sm-12, .col-sm-2, .col-sm-3, .col-sm-4, .col-sm-5, .col-sm-6, .col-sm-7, .col-sm-8, .col-sm-9, .col-xs-1, .col-xs-10, .col-xs-11, .col-xs-12, .col-xs-2, .col-xs-3, .col-xs-4, .col-xs-5, .col-xs-6, .col-xs-7, .col-xs-8, .col-xs-9 {
            position: relative;
            min-height: 1px;
            padding-right: 7px;
            padding-left: 7px;
        }
        .centered {
            height: 100px;
            width: 100px;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: 999;
        }
    </style>
</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">
    <div  id="loading" class="loading" style="">
        <img src="{{url('public/bs.png')}}" class="centered">
    </div>
    <header class="main-header">
        <!-- Logo -->
        <a href="" class="logo">
            <!-- mini logo for sidebar mini 50x50 pixels -->
            <span class="logo-mini"><b>B</b>S</span>
            <!-- logo for regular state and mobile devices -->
            <span class="logo-lg"><b>??????????????? ????????????</b></span>
        </a>
        <!-- Header Navbar: style can be found in header.less -->
        <nav class="navbar navbar-static-top">
            <!-- Sidebar toggle button-->
            <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </a>
            <div class="navbar-custom-menu">
                <ul class="nav navbar-nav">
                    <li class="dropdown notifications-menu">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <i class="fa fa-bell-o"></i>
                            <span class="label label-warning">{{$noti_count}}</span>
                        </a>
                        <ul class="dropdown-menu">
                            <li class="header">You have {{$noti_count}} notifications</li>
                            @if($product_order_count>0)
                            <li><ul class="menu"><li><a href="{{url($product_order_url)}}"><i class="fa fa-shopping-cart text-aqua"></i>{{$product_order_count}} New Product Order</a></li></ul></li>
                            @endif
                            @if($custom_order_count>0)
                            <li><ul class="menu"><li><a href="{{url($custom_order_url)}}"><i class="fa fa-shopping-cart text-aqua"></i>{{$custom_order_count}} New Custom Order</a></li></ul></li>
                            @endif
                            @if($ticket_order_count>0)
                            <li><ul class="menu"><li><a href="{{url($ticket_order_url)}}"><i class="fa fa-shopping-cart text-aqua"></i>{{$ticket_order_count}} New Ticket Order</a></li></ul></li>
                            @endif
                            @if($dr_order_count>0)
                            <li><ul class="menu"><li><a href="{{url($dr_order_url)}}"><i class="fa fa-shopping-cart text-aqua"></i>{{$dr_order_count}} New Dr Appointment</a></li></ul></li>
                            @endif
                            @if($therapy_order_count>0)
                            <li><ul class="menu"><li><a href="{{url($therapy_order_url)}}"><i class="fa fa-shopping-cart text-aqua"></i>{{$therapy_order_count}} New Therapy Appointment</a></li></ul></li>
                            @endif
                            @if($diagnostic_order_count>0)
                            <li><ul class="menu"><li><a href="{{url($diagnostic_order_url)}}"><i class="fa fa-shopping-cart text-aqua"></i>{{$diagnostic_order_count}} New Diagnostic Appointment</a></li></ul></li>
                            @endif
                            @if($medicine_order_count>0)
                            <li><ul class="menu"><li><a href="{{url($medicine_order_url)}}"><i class="fa fa-shopping-cart text-aqua"></i>{{$medicine_order_count}} New Medicine Order</a></li></ul></li>
                            @endif
                            @if($ride_order_count>0)
                            <li><ul class="menu"><li><a href="{{url($ride_order_url)}}"><i class="fa fa-shopping-cart text-aqua"></i>{{$ride_order_count}} New Ride Booking</a></li></ul></li>
                            @endif
                            @if($courier_order_count>0)
                            <li><ul class="menu"><li><a href="{{url($courier_order_url)}}"><i class="fa fa-shopping-cart text-aqua"></i>{{$courier_order_count}} New Courier Order Booking</a></li></ul></li>
                            @endif
                            @if($cooking_order_count>0)
                            <li><ul class="menu"><li><a href="{{url($cooking_order_url)}}"><i class="fa fa-shopping-cart text-aqua"></i>{{$cooking_order_count}} New Cooking Order Booking</a></li></ul></li>
                            @endif
                            @if($cleaning_order_count>0)
                            <li><ul class="menu"><li><a href="{{url($cleaning_order_url)}}"><i class="fa fa-shopping-cart text-aqua"></i>{{$cleaning_order_count}} New Cloth Cleaning Order </a></li></ul></li>
                            @endif
                            @if($room_order_count>0)
                            <li><ul class="menu"><li><a href="{{url($room_order_url)}}"><i class="fa fa-shopping-cart text-aqua"></i>{{$room_order_count}} New Room/Washroom/Tank Order </a></li></ul></li>
                            @endif
                            @if($laundry_order_count>0)
                            <li><ul class="menu"><li><a href="{{url($laundry_order_url)}}"><i class="fa fa-shopping-cart text-aqua"></i>{{$laundry_order_count}} New Laundry Order </a></li></ul></li>
                            @endif
                            @if($helpingHand_order_count>0)
                            <li><ul class="menu"><li><a href="{{url($helpingHand_order_url)}}"><i class="fa fa-shopping-cart text-aqua"></i>{{$helpingHand_order_count}} New Helping Hand Order </a></li></ul></li>
                            @endif
                            @if($gard_order_count>0)
                            <li><ul class="menu"><li><a href="{{url($gard_order_url)}}"><i class="fa fa-shopping-cart text-aqua"></i>{{$gard_order_count}} New Gard Order </a></li></ul></li>
                            @endif
                            @if($various_servicing_order_count>0)
                            <li><ul class="menu"><li><a href="{{url($various_servicing_order_url)}}"><i class="fa fa-shopping-cart text-aqua"></i>{{$various_servicing_order_count}} New various service Order </a></li></ul></li>
                            @endif
                            @if($parlor_order_count>0)
                            <li><ul class="menu"><li><a href="{{url($parlor_order_url)}}"><i class="fa fa-shopping-cart text-aqua"></i>{{$parlor_order_count}} New Parlor Order </a></li></ul></li>
                            @endif
                            @if($tour_order_count>0)
                            <li><ul class="menu"><li><a href="{{url($tour_order_url)}}"><i class="fa fa-shopping-cart text-aqua"></i>{{$tour_order_count}} New Tours & Travels Order </a></li></ul></li>
                            @endif
                        </ul>
                    </li>
                    @php
                        $Image =url("public/asset/images/noImage.jpg");
                        if(Cookie::get('user_photo'))
                            $Image = url(Cookie::get('user_photo'));
                    @endphp
                    <li class="dropdown user user-menu">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <img src="{{ $Image}}" class="user-image" alt="User Image">
                            <span class="hidden-xs">{{ Cookie::get('user_name') }}</span>
                        </a>
                        <ul class="dropdown-menu">
                            <!-- User image -->
                            <li class="user-header">
                                <img src="{{$Image}}" class="img-circle" alt="User Image">

                                <p>
                                    {{ Cookie::get('user_name') }}
                                </p>
                            </li>
                            <li class="user-footer">
                                <div class="pull-left">
                                    <a href="{{url('profile')}}" class="btn btn-default btn-flat">????????????????????????</a>
                                </div>
                                <div class="pull-right">
                                    <a href="{{ url('logout') }}" class="btn btn-default btn-flat">?????? ????????? </a>
                                </div>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </nav>
    </header>
    <!-- Left side column. contains the logo and sidebar -->
    <aside class="main-sidebar">
        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">
            <!-- Sidebar user panel -->
            <div class="user-panel">
                <div class="pull-left image">
                    <img src="{{$Image}}" class="img-circle" alt="User Image">
                </div>
                <div class="pull-left info">
                    <p>{{ Cookie::get('user_name') }}</p>
                    <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
                </div>
            </div>
            <!-- sidebar menu: : style can be found in sidebar.less -->
            <ul class="sidebar-menu" data-widget="tree">
                <li class="header">?????????????????????</li>
                @if(Cookie::get('user_type') == 4)
                    <li class="@yield('myShop')">
                        <a href ="{{ url('myShop') }}" >
                            <i class="fa fa-shopping-basket"></i> <span>???????????? ???????????????</span>
                        </a>
                    </li>
                    <li class="@yield('importProduct')">
                        <a href ="{{ url('importProduct') }}" >
                            <i class="fa fa-sellsy"></i> <span>???????????? ????????????????????????</span>
                        </a>
                    </li>
                    <li class="@yield('mySaleProduct')">
                        <a href ="{{ url('mySaleProduct') }}" >
                            <i class="fa fa-shopping-cart"></i> <span>???????????? ??????????????????</span>
                        </a>
                    </li>
                    <li class="@yield('sellerForm')">
                        <a href ="{{ url('sellerForm') }}" >
                            <i class="fa fa-shopping-cart"></i> <span>???????????? ????????????</span>
                        </a>
                    </li>
                @endif
                @if(Cookie::get('user_type') == 5)
                    <li class="@yield('deliveryProfile')">
                        <a href ="{{ url('deliveryProfile') }}" >
                            <i class="fa fa-book"></i> <span>???????????? ????????????????????????</span>
                        </a>
                    </li>
                @endif
                @if(Cookie::get('user_type') == 7)
                    <li class="@yield('mySaleProductDealer')">
                        <a href ="{{ url('mySaleProductDealer') }}" >
                            <i class="fa fa-shopping-basket"></i> <span>???????????? ??????????????????</span>
                        </a>
                    </li>
                    <li class="@yield('dealerProfile')">
                        <a href ="{{ url('dealerProfile') }}" >
                            <i class="fa fa-shopping-basket"></i> <span>???????????? ????????????</span>
                        </a>
                    </li>
                @endif
                @if(Cookie::get('user_type') == 13)
                    <li class="@yield('doctorServiceArea')">
                        <a href ="{{ url('doctorServiceArea') }}" >
                            <i class="fa fa-car"></i> <span>???????????? ????????????????????? ???????????????</span>
                        </a>
                    </li>
                    <li class="@yield('myPatientList')">
                        <a href ="{{ url('myPatientList') }}" >
                            <i class="fa fa-medkit"></i> <span>???????????? ?????????????????????</span>
                        </a>
                    </li>
                    <li class="@yield('patientHistory')">
                        <a href ="{{ url('patientHistory') }}" >
                            <i class="fa fa-medkit"></i> <span>????????????????????? ????????????????????????</span>
                        </a>
                    </li>
                @endif
                @if(Cookie::get('user_type') == 15)
                    <li class="@yield('myMedicineSelf')">
                        <a href ="{{ url('myMedicineSelf') }}" >
                            <i class="fa fa-book"></i> <span>???????????? ????????????</span>
                        </a>
                    </li>
                    <li class="@yield('myMedicineOrder')">
                        <a href ="{{ url('myMedicineOrder') }}" >
                            <i class="fa fa-book"></i> <span>???????????? ??????????????????</span>
                        </a>
                    </li>
                    <li class="@yield('myMedicineSalesReport')">
                        <a href ="{{ url('myMedicineSalesReport') }}" >
                            <i class="fa fa-book"></i> <span>?????????????????? ?????????????????????</span>
                        </a>
                    </li>
                @endif
                @if(Cookie::get('user_type') == 16)
                    <li class="@yield('cookerProfile')">
                        <a href ="{{ url('cookerProfile') }}" >
                            <i class="fa fa-dashboard"></i> <span>???????????? ????????????????????????</span>
                        </a>
                    </li>
                @endif
                @if(Cookie::get('user_type') == 17||Cookie::get('user_type') == 18||Cookie::get('user_type') == 19||Cookie::get('user_type') == 20||Cookie::get('user_type') == 32)
                    <li class="@yield('riderServiceArea')">
                        <a href ="{{ url('riderServiceArea') }}" >
                            <i class="fa fa-car"></i> <span>???????????? ????????????????????? ???????????????</span>
                        </a>
                    </li>
                    <li class="@yield('myRiding')">
                        <a href ="{{ url('myRiding') }}" >
                            <i class="fa fa-car"></i> <span>???????????? ??????????????????</span>
                        </a>
                    </li>
                @endif
                @if(Cookie::get('user_type') == 21)
                    <li class="@yield('clothCleanerProfile')">
                        <a href ="{{ url('clothCleanerProfile') }}" >
                            <i class="fa fa-dashboard"></i> <span>???????????? ????????????????????????</span>
                        </a>
                    </li>
                @endif
                @if(Cookie::get('user_type') == 22)
                    <li class="@yield('laundryProfile')">
                        <a href ="{{ url('laundryProfile') }}" >
                            <i class="fa fa-dashboard"></i> <span>???????????? ????????????????????????</span>
                        </a>
                    </li>
                @endif
                @if(Cookie::get('user_type') == 23)
                    <li class="@yield('roomCleanerProfile')">
                        <a href ="{{ url('roomCleanerProfile') }}" >
                            <i class="fa fa-dashboard"></i> <span>???????????? ????????????????????????</span>
                        </a>
                    </li>
                @endif
                @if(Cookie::get('user_type') == 24)
                    <li class="@yield('tankCleanerProfile')">
                        <a href ="{{ url('tankCleanerProfile') }}" >
                            <i class="fa fa-dashboard"></i> <span>???????????? ????????????????????????</span>
                        </a>
                    </li>
                @endif
                @if(Cookie::get('user_type') == 25)
                    <li class="@yield('helpingHandProfile')">
                        <a href ="{{ url('helpingHandProfile') }}" >
                            <i class="fa fa-dashboard"></i> <span>???????????? ????????????????????????</span>
                        </a>
                    </li>
                @endif
                @if(Cookie::get('user_type') == 26)
                    <li class="@yield('guardProfile')">
                        <a href ="{{ url('guardProfile') }}" >
                            <i class="fa fa-dashboard"></i> <span>???????????? ????????????????????????</span>
                        </a>
                    </li>
                @endif
                @if(Cookie::get('user_type') == 27)
                    <li class="@yield('stoveProfile')">
                        <a href ="{{ url('stoveProfile') }}" >
                            <i class="fa fa-dashboard"></i> <span>???????????? ????????????????????????</span>
                        </a>
                    </li>
                @endif
                @if(Cookie::get('user_type') == 28)
                    <li class="@yield('electronicsProfile')">
                        <a href ="{{ url('electronicsProfile') }}" >
                            <i class="fa fa-dashboard"></i> <span>???????????? ????????????????????????</span>
                        </a>
                    </li>
                @endif
                @if(Cookie::get('user_type') == 29)
                    <li class="@yield('sanitaryProfile')">
                        <a href ="{{ url('sanitaryProfile') }}" >
                            <i class="fa fa-dashboard"></i> <span>???????????? ????????????????????????</span>
                        </a>
                    </li>
                @endif
                @if(Cookie::get('user_type') == 30)
                    <li class="@yield('acProfile')">
                        <a href ="{{ url('acProfile') }}" >
                            <i class="fa fa-dashboard"></i> <span>???????????? ????????????????????????</span>
                        </a>
                    </li>
                @endif
                @if(Cookie::get('user_type') == 31 || Cookie::get('user_type') == 35)
                    <li class="@yield('parlorProfile')">
                        <a href ="{{ url('parlorProfile') }}" >
                            <i class="fa fa-dashboard"></i> <span>???????????? ????????????????????????</span>
                        </a>
                    </li>
                @endif
                @if(Cookie::get('user_type') == 33)
                    <li class="@yield('courierProfile')">
                        <a href ="{{ url('courierProfile') }}" >
                            <i class="fa fa-dashboard"></i> <span>???????????? ????????????????????????</span>
                        </a>
                    </li>
                @endif
                @if(Cookie::get('user_type') == 34)
                    <li class="@yield('tntProfile')">
                        <a href ="{{ url('tntProfile') }}" >
                            <i class="fa fa-dashboard"></i> <span>???????????? ????????????????????????</span>
                        </a>
                    </li>
                    <li class ="@yield('bookingTourAll1')"><a href="{{ url('bookingTourAllAgent1') }}"><i class="fa fa-circle-o"></i>???????????????/?????????/??????????????? ??????????????? ?????????-???</a></li>
                    <li class ="@yield('bookingTourAll2')"><a href="{{ url('bookingTourAllAgent2') }}"><i class="fa fa-circle-o"></i>???????????????/?????????/??????????????? ??????????????? ?????????-???</a></li>
                @endif
                <?php
                    $rows =DB::table('role_assign')
                        ->where('user_type', Cookie::get('user_type'))->first();
                    if($rows){
                        $roles = json_decode($rows->role);
                ?>
                @if(in_array(1, $roles))
                    <li class="@yield('dashLiAdd')">
                        <a href="{{ url('dashboard') }}">
                            <i class="fa fa-dashboard"></i> <span>???????????????????????????</span>
                        </a>
                    </li>
                @endif
                @if(in_array(2, $roles))
                    <li class="@yield('accountingLiAdd')">
                        <a href="{{ url('accounting') }}">
                            <i class="fa fa-dashboard"></i> <span>???????????????</span>
                        </a>
                    </li>
                @endif
                @if(in_array(3, $roles))
                    <li class="@yield('salesLiAdd')">
                        <a href="{{ url('salesReport') }}">
                            <i class="fa fa-shopping-bag"></i> <span>???????????? ?????????????????? ?????????????????????</span>
                        </a>
                    </li>
                @endif
                @if(in_array(38, $roles))
                    <li class="@yield('customOrderReport')">
                        <a href="{{ url('customOrderReport') }}">
                            <i class="fa fa-shopping-bag"></i> <span>?????????????????? ?????????????????? ?????????????????????</span>
                        </a>
                    </li>
                @endif
                @if(in_array(4, $roles))
                    <li class="@yield('productUploadReport')">
                        <a href="{{ url('productur') }}">
                            <i class="fa fa-upload"></i> <span>??????????????? ????????????</span>
                        </a>
                    </li>
                @endif
                @if(in_array(5, $roles))
                    <li class="@yield('ticketSalesLiAdd')">
                        <a href="{{ url('ticketSalesReport') }}">
                            <i class="fa fa-shopping-bag"></i> <span>??????????????? ?????????????????? ?????????????????????</span>
                        </a>
                    </li>
                @endif
                @if(in_array(6, $roles))
                    <li class="@yield('doctorAppointmentLiAdd')">
                        <a href="{{ url('doctorAppointmentReport') }}">
                            <i class="fa fa-shopping-bag"></i> <span>????????????????????? ?????????????????????????????? ?????????????????????</span>
                        </a>
                    </li>
                @endif
                @if(in_array(7, $roles))
                    <li class="@yield('therapyAppointmentLiAdd')">
                        <a href="{{ url('therapyAppointmentReport') }}">
                            <i class="fa fa-shopping-bag"></i> <span>?????????????????? ?????????????????????????????? ?????????????????????</span>
                        </a>
                    </li>
                @endif
                @if(in_array(8, $roles))
                    <li class="@yield('diagnosticAppointmentLiAdd')">
                        <a href="{{ url('diagnosticAppointmentReport') }}">
                            <i class="fa fa-shopping-bag"></i> <span>?????????????????????????????????  ?????????????????????</span>
                        </a>
                    </li>
                @endif
                @if(in_array(9, $roles))
                    <li class="@yield('medicineOrderReportAdmin')">
                        <a href="{{ url('medicineOrderReportAdmin') }}">
                            <i class="fa fa-shopping-bag"></i> <span>????????????????????? ??????????????????  ?????????????????????</span>
                        </a>
                    </li>
                @endif
                @if(in_array(10, $roles))
                    <li class="@yield('transportReportAdmin')">
                        <a href="{{ url('transportReportAdmin') }}">
                            <i class="fa fa-car"></i> <span>?????????????????? ?????????????????????</span>
                        </a>
                    </li>
                @endif
                @if(in_array(11, $roles))
                    <li class="@yield('courierReport')">
                        <a href="{{ url('courierReport') }}">
                            <i class="fa fa-car"></i> <span>????????????????????? ?????????????????????</span>
                        </a>
                    </li>
                @endif
                @if(in_array(12, $roles))
                    <li class="@yield('cookingReport')">
                        <a href="{{ url('cookingReport') }}">
                            <i class="fa fa-dashboard"></i> <span>??????????????? ?????????????????????</span>
                        </a>
                    </li>
                @endif
                @if(in_array(13, $roles))
                    <li class="@yield('clothWashingReport')">
                        <a href="{{ url('clothWashingReport') }}">
                            <i class="fa fa-dashboard"></i> <span>???????????? ???????????????????????? ?????????????????????</span>
                        </a>
                    </li>
                @endif
                @if(in_array(14, $roles))
                    <li class="@yield('laundryReport')">
                        <a href="{{ url('laundryReport') }}">
                            <i class="fa fa-dashboard"></i> <span>????????????????????? ?????????????????????</span>
                        </a>
                    </li>
                @endif
                @if(in_array(15, $roles))
                    <li class="@yield('roomCleaningReport')">
                        <a href="{{ url('roomCleaningReport') }}">
                            <i class="fa fa-dashboard"></i> <span>?????????/ ?????????????????????/ ????????????????????? ?????????????????????</span>
                        </a>
                    </li>
                @endif
                @if(in_array(16, $roles))
                    <li class="@yield('helpingHandReport')">
                        <a href="{{ url('helpingHandReport') }}">
                            <i class="fa fa-dashboard"></i> <span>??????????????????/ ???????????? ?????????????????? ?????????????????????</span>
                        </a>
                    </li>
                @endif
                @if(in_array(17, $roles))
                    <li class="@yield('guardReport')">
                        <a href="{{ url('guardReport') }}">
                            <i class="fa fa-dashboard"></i> <span>??????????????? ?????????????????????</span>
                        </a>
                    </li>
                @endif
                @if(in_array(18, $roles))
                    <li class="@yield('variousServicingReport')">
                        <a href="{{ url('variousServicingReport') }}">
                            <i class="fa fa-dashboard"></i> <span>????????????????????? ??????????????????????????? ?????????????????????</span>
                        </a>
                    </li>
                @endif
                @if(in_array(19, $roles))
                    <li class="@yield('parlorReport')">
                        <a href="{{ url('parlorReport') }}">
                            <i class="fa fa-dashboard"></i> <span>?????????????????? ?????????????????????</span>
                        </a>
                    </li>
                @endif
                @if(in_array(20, $roles))
                    <li class="@yield('toursNTravelsReport')">
                        <a href="{{ url('toursNTravelsReport') }}">
                            <i class="fa fa-plane"></i> <span>?????????????????? ???????????? ???????????????????????? ?????????????????????</span>
                        </a>
                    </li>
                @endif
                @if(in_array(21, $roles))
                    <li class="@yield('donationReportBackend')">
                        <a href="{{ url('donationReportBackend') }}">
                            <i class="fa fa-medkit"></i> <span>?????????????????? ?????????????????????</span>
                        </a>
                    </li>
                @endif
                @if(in_array(22, $roles))
                    <li class="@yield('dealerProductAdmin')">
                        <a href="{{ url('dealerProductAdmin') }}">
                            <i class="fa fa-user"></i> <span>??????????????? ???????????? ?????????????????????</span>
                        </a>
                    </li>
                @endif
                <li class="header">?????????????????????????????????</li>
                @if(in_array(23, $roles))
                    <li class="treeview  @yield('mainLiAdd')">
                        <a href="#">
                            <i class="fa fa-address-book"></i>
                            <span>??????????????????</span>
                            <span class="pull-right-container">
                              <i class="fa fa-angle-left pull-right"></i>
                            </span>
                        </a>
                        <ul class="treeview-menu">
                            <li class ="@yield('divLiAdd')"><a href="{{ url('division') }}"><i class="fa fa-circle-o"></i> ???????????????</a></li>
                            <li class="treeview  @yield('mainDisLiAdd')">
                                <a href="#"><i class="fa fa-circle-o"></i> ???????????? ?????????????????????
                                    <span class="pull-right-container">
                                      <i class="fa fa-angle-left pull-right"></i>
                                    </span>
                                </a>
                                <ul class="treeview-menu">
                                    <li class ="@yield('disLiAdd')"><a href="{{ url('district') }}"><i class="fa fa-circle-o"></i> ????????????</a></li>
                                    <li class ="@yield('upLiAdd')"><a href="{{ url('upazilla') }}"><i class="fa fa-circle-o"></i> ??????????????????</a></li>
                                    <li class ="@yield('uniLiAdd')"><a href="{{ url('union') }}"><i class="fa fa-circle-o"></i> ?????????????????? </a></li>
                                    <li class ="@yield('wardLiAdd')"><a href="{{ url('ward') }}"><i class="fa fa-circle-o"></i> ??????????????????  </a></li>
                                </ul>
                            </li>
                            <li class="treeview  @yield('mainCityLiAdd')">
                                <a href="#"><i class="fa fa-circle-o"></i> ????????? ?????????????????????
                                    <span class="pull-right-container">
                                      <i class="fa fa-angle-left pull-right"></i>
                                    </span>
                                </a>
                                <ul class="treeview-menu">
                                    <li class ="@yield('cityLiAdd')" ><a href="{{ url('city') }}"><i class="fa fa-circle-o"></i> ???????????? </a></li>
                                    <li class ="@yield('cityCorLiAdd')" ><a href="{{ url('city_corporation') }}"><i class="fa fa-circle-o"></i> ???????????? ??????????????????????????? </a></li>
                                    <li class ="@yield('thanaLiAdd')" ><a href="{{ url('thana') }}"><i class="fa fa-circle-o"></i> ????????????  </a></li>
                                    <li class ="@yield('cWardLiAdd')" ><a href="{{ url('c_ward') }}"><i class="fa fa-circle-o"></i> ??????????????????  </a></li>
                                </ul>
                            </li>
                            <li class="treeview  @yield('mainForeignLiAdd')">
                                <a href="#"><i class="fa fa-circle-o"></i> ??????????????? ?????????????????????
                                    <span class="pull-right-container">
                                      <i class="fa fa-angle-left pull-right"></i>
                                    </span>
                                </a>
                                <ul class="treeview-menu">
                                    <li class ="@yield('naming1')" ><a href="{{ url('naming1') }}"><i class="fa fa-circle-o"></i> ????????? (??????????????? ???)  </a></li>
                                    <li class ="@yield('naming2')" ><a href="{{ url('naming2') }}"><i class="fa fa-circle-o"></i> ??????????????? ??? </a></li>
                                    <li class ="@yield('naming3')" ><a href="{{ url('naming3') }}"><i class="fa fa-circle-o"></i> ??????????????? ??? </a></li>
                                    <li class ="@yield('naming4')" ><a href="{{ url('naming4') }}"><i class="fa fa-circle-o"></i> ??????????????? ???  </a></li>
                                    <li class ="@yield('naming5')" ><a href="{{ url('naming5') }}"><i class="fa fa-circle-o"></i> ??????????????? ???  </a></li>
                                </ul>
                            </li>
                        </ul>
                    </li>
                @endif
                @if(in_array(24, $roles))
                    <li class="treeview  @yield('mainUserLiAdd')">
                        <a href="#">
                            <i class="fa fa-address-book"></i>
                            <span>???????????????</span>
                            <span class="pull-right-container">
                              <i class="fa fa-angle-left pull-right"></i>
                            </span>
                        </a>
                        <ul class="treeview-menu">
                            <li class ="@yield('userTypeLiAdd')"><a href="{{ url('user_type') }}"><i class="fa fa-circle-o"></i> ??????????????? ????????? </a></li>
                            <li class ="@yield('userLiAdd')"><a href="{{ url('user') }}"><i class="fa fa-circle-o"></i> ???????????????  </a></li>

                        </ul>
                    </li>
                @endif
                @if(in_array(25, $roles))
                    <li class="@yield('catLiAdd')">
                        <a href ="{{ url('category') }}">
                            <i class="fa fa-bandcamp"></i> <span>??????????????????????????? </span>
                        </a>
                    </li>
                @endif
                @if(in_array(41, $roles))
                    <li class="@yield('sellerCatShop')">
                        <a href ="{{ url('sellerCatShop') }}">
                            <i class="fa fa-bandcamp"></i> <span>??????????????? ?????? ???????????????????????????</span>
                        </a>
                    </li>
                @endif
                @if(in_array(26, $roles))
                    <li class="@yield('sms')">
                        <a href ="{{ url('sms') }}">
                            <i class="fa fa-envelope-square"></i> <span>?????????????????? </span>
                        </a>
                    </li>
                @endif
                @if(in_array(27, $roles))
                    <li class="@yield('subCatLiAdd')">
                        <a href ="{{ url('subcategory') }}">
                            <i class="fa fa-bandcamp"></i> <span> ????????? ??????????????????????????? </span>
                        </a>
                    </li>
                @endif
                @if(in_array(28, $roles))
                    <li class="@yield('mainSlide')">
                        <a href ="{{ url('mainSlide') }}" >
                            <i class="fa fa-image"></i> <span>?????????????????? ?????????????????????????????????</span>
                        </a>
                    </li>
                @endif
                @if(in_array(29, $roles))
                    <li class="@yield('proLiAdd')">
                        <a href ="{{ url('product') }}" >
                            <i class="fa fa-shopping-cart"></i> <span>????????????</span>
                        </a>
                    </li>
                @endif
                @if(in_array(30, $roles))
                    <li class="@yield('couponLiAdd')">
                        <a href ="{{ url('coupon') }}" >
                            <i class="fa fa-shopping-cart"></i> <span>????????????</span>
                        </a>
                    </li>
                @endif
                @if(in_array(31, $roles))
                    <li class="@yield('allMedicineList')">
                        <a href ="{{ url('allMedicineList') }}" >
                            <i class="fa fa-medkit"></i> <span>?????????</span>
                        </a>
                    </li>
                @endif
                @if(in_array(32, $roles))
                    <li class="@yield('medicineCompanyEmail')">
                        <a href ="{{ url('medicineCompanyEmail') }}" >
                            <i class="fa fa-medkit"></i> <span>????????? ???????????????????????? ???????????????</span>
                        </a>
                    </li>
                @endif
                @if(in_array(33, $roles))
                    <li class="@yield('deliveryLiAdd')">
                        <a href ="{{ url('delivery_charge') }}" >
                            <i class="fa fa-delicious"></i> <span> ???????????? ???????????????????????? ???????????????</span>
                        </a>
                    </li>
                @endif
                @if(in_array(34, $roles))
                    <li class="@yield('transportCost')">
                        <a href ="{{ url('transportCost') }}" >
                            <i class="fa fa-delicious"></i> <span>?????????????????? ????????? ????????????????????????</span>
                        </a>
                    </li>
                @endif
                @if(in_array(35, $roles))
                    <li class="treeview  @yield('serviceMainLi')">
                        <a href="#">
                            <i class="fa fa-address-book"></i>
                            <span>????????????????????????</span>
                            <span class="pull-right-container">
                              <i class="fa fa-angle-left pull-right"></i>
                            </span>
                        </a>
                        <ul class="treeview-menu">
                            <li class="treeview  @yield('transportMainLi')">
                                <a href="#"><i class="fa fa-circle-o"></i> ?????????????????? ??? ???????????????
                                    <span class="pull-right-container">
                                      <i class="fa fa-angle-left pull-right"></i>
                                    </span>
                                </a>
                                <ul class="treeview-menu">
                                    <li class ="@yield('coachPage')"><a href="{{ url('coachPage') }}"><i class="fa fa-circle-o"></i> ????????????????????????????????????</a></li>
                                    <li class ="@yield('ticketRoute')"><a href="{{ url('ticketRoute') }}"><i class="fa fa-circle-o"></i> ??????????????? ?????????</a></li>
                                </ul>
                            </li>
                            <li class="treeview  @yield('qourierMainLi')">
                                <a href="#"><i class="fa fa-circle-o"></i> ?????????????????????
                                    <span class="pull-right-container">
                                      <i class="fa fa-angle-left pull-right"></i>
                                    </span>
                                </a>
                                <ul class="treeview-menu">
                                    <li class ="@yield('courierType')"><a href="{{ url('courierType') }}"><i class="fa fa-circle-o"></i>????????????????????? ?????????</a></li>
                                    <li class ="@yield('courierSettings')"><a href="{{ url('courierSettings') }}"><i class="fa fa-circle-o"></i>????????????????????? ??????????????????</a></li>
                                    <li class ="@yield('agentArea')"><a href="{{ url('agentArea') }}"><i class="fa fa-circle-o"></i>?????????????????? ???????????????</a></li>
                                </ul>
                            </li>
                            <li class="treeview  @yield('tntMainLi')">
                                <a href="#"><i class="fa fa-circle-o"></i> ?????????????????? ???????????? ????????????????????????
                                    <span class="pull-right-container">
                                      <i class="fa fa-angle-left pull-right"></i>
                                    </span>
                                </a>
                                <ul class="treeview-menu">
                                    <li class ="@yield('travelSlide')"><a href="{{ url('travelSlide') }}"><i class="fa fa-circle-o"></i>????????????????????? ?????????????????? </a></li>
                                    <li class ="@yield('bookingMainAddress')"><a href="{{ url('bookingMainAddress') }}"><i class="fa fa-circle-o"></i>??????????????? ?????????????????? ??????????????????</a></li>
                                    <li class ="@yield('bookingTourAll1')"><a href="{{ url('bookingTourAll1') }}"><i class="fa fa-circle-o"></i>???????????????/?????????/??????????????? ??????????????? ?????????-???</a></li>
                                    <li class ="@yield('bookingTourAll2')"><a href="{{ url('bookingTourAll2') }}"><i class="fa fa-circle-o"></i>???????????????/?????????/??????????????? ??????????????? ?????????-???</a></li>
                                </ul>
                            </li>
                            <li class="treeview  @yield('medicalMainLi')">
                                <a href="#"><i class="fa fa-circle-o"></i> ????????????????????? ?????????????????????
                                    <span class="pull-right-container">
                                      <i class="fa fa-angle-left pull-right"></i>
                                    </span>
                                </a>
                                <ul class="treeview-menu">
                                    <li class ="@yield('departmentList')"><a href="{{ url('departmentList') }}"><i class="fa fa-circle-o"></i> ???????????????????????????????????? </a></li>
                                    <li class ="@yield('hospitalList')"><a href="{{ url('hospitalList') }}"><i class="fa fa-circle-o"></i> ???????????????????????? </a></li>
                                    <li class ="@yield('doctorList')"><a href="{{ url('doctorList') }}"><i class="fa fa-circle-o"></i> ????????????????????? ???????????????</a></li>
                                    <li class ="@yield('privateChamberList')"><a href="{{ url('privateChamberList') }}"><i class="fa fa-circle-o"></i> ???????????????????????? ????????????????????? </a></li>
                                    <li class ="@yield('therapyServiceList')"><a href="{{ url('therapyServiceList') }}"><i class="fa fa-circle-o"></i> ?????????????????? ????????????????????? </a></li>
                                    <li class ="@yield('therapyCenterList')"><a href="{{ url('therapyCenterList') }}"><i class="fa fa-circle-o"></i> ?????????????????? ????????????????????? </a></li>
                                    <li class ="@yield('therapyFees')"><a href="{{ url('therapyFees') }}"><i class="fa fa-circle-o"></i> ?????????????????? ????????? </a></li>
                                    <li class ="@yield('diagnosticTestList')"><a href="{{ url('diagnosticTestList') }}"><i class="fa fa-circle-o"></i> ????????????????????????????????? ??????????????? </a></li>
                                    <li class ="@yield('diagnosticCenterList')"><a href="{{ url('diagnosticCenterList') }}"><i class="fa fa-circle-o"></i> ????????????????????????????????? ????????????????????? </a></li>
                                    <li class ="@yield('diagnosticFees')"><a href="{{ url('diagnosticFees') }}"><i class="fa fa-circle-o"></i> ????????????????????????????????? ????????? </a></li>
                                    <li class ="@yield('medicalCamp')"><a href="{{ url('medicalCampBack') }}"><i class="fa fa-circle-o"></i>????????????????????? ?????????????????????</a></li>
                                </ul>
                            </li>
                            <li class="treeview  @yield('homeAssistantMainLi')">
                                <a href="#"><i class="fa fa-circle-o"></i> ????????? ????????????????????????????????????
                                    <span class="pull-right-container">
                                      <i class="fa fa-angle-left pull-right"></i>
                                    </span>
                                </a>
                                <ul class="treeview-menu">
                                    <li class ="@yield('cookingPage')"><a href="{{ url('cookingPage') }}"><i class="fa fa-circle-o"></i> ???????????????</a></li>
                                    <li class ="@yield('clothWashing')"><a href="{{ url('clothWashing') }}"><i class="fa fa-circle-o"></i>???????????? ????????????????????????</a></li>
                                    <li class ="@yield('roomCleaning')"><a href="{{ url('roomCleaning') }}"><i class="fa fa-circle-o"></i>?????????/?????????????????????/?????????????????? ????????????????????????</a></li>
                                    <li class ="@yield('childCaring')"><a href="{{ url('childCaring') }}"><i class="fa fa-circle-o"></i>?????????????????? ???????????????????????? ??? ???????????? ??????????????????</a></li>
                                    <li class ="@yield('guardSetting')"><a href="{{ url('guardSetting') }}"><i class="fa fa-circle-o"></i>???????????????</a></li>
                                    <li class ="@yield('variousServicing')"><a href="{{ url('variousServicing') }}"><i class="fa fa-circle-o"></i> ????????????????????? ???????????????????????????</a></li>
                                    <li class ="@yield('parlorService')"><a href="{{ url('parlorService') }}"><i class="fa fa-circle-o"></i>????????????????????? ?????????????????????</a></li>
                                    <li class ="@yield('laundryService')"><a href="{{ url('laundryService') }}"><i class="fa fa-circle-o"></i>????????????????????? ?????????????????????</a></li>
                                </ul>
                            </li>
                        </ul>
                    </li>
                @endif
                @if(in_array(36, $roles))
                    <li class="@yield('aboutLiAdd')">
                        <a href ="{{ url('about_us') }}" >
                            <i class="fa fa-address-book-o"></i> <span>?????????????????? ????????????????????????</span>
                        </a>
                    </li>
                @endif
                @if(in_array(37, $roles))
                    <li class="@yield('contactLiAdd')">
                        <a href ="{{ url('contact_us') }}" >
                            <i class="fa fa-address-card"></i> <span>?????????????????????????????????</span>
                        </a>
                    </li>
                @endif
                @if(in_array(38, $roles))
                    <li class="@yield('roleAssign')">
                        <a href ="{{ url('roleAssign') }}" >
                            <i class="fa fa-address-card"></i> <span>????????? ???????????????</span>
                        </a>
                    </li>
                @endif
                @if(in_array(40, $roles))
                    <li class="@yield('pageSettings')">
                        <a href ="{{ url('pageSettings') }}" >
                            <i class="fa fa-hacker-news"></i> <span>????????? ??????????????????</span>
                        </a>
                    </li>
                @endif
                <?php
                    }
                    $rows =DB::table('user_type')
                        ->where('id', Cookie::get('user_type'))->first();
                    if($rows){
                    $type = $rows->type;
                ?>
                @if($type == 2)
                    <li class="header">?????????????????????????????????</li>
                @endif
                <?php } ?>
                @if(Cookie::get('user_type') == 15)
                    <li class="@yield('medicineSelfName')">
                        <a href ="{{ url('medicineSelfName') }}" >
                            <i class="fa fa-book"></i> <span>???????????? ?????????</span>
                        </a>
                    </li>
                    <li class="@yield('medicineSelfManagement')">
                        <a href ="{{ url('medicineSelfManagement') }}" >
                            <i class="fa fa-book"></i> <span>???????????? ?????????????????????</span>
                        </a>
                    </li>
                    <li class="@yield('myMedicineSale')">
                        <a href ="{{ url('myMedicineSale') }}" >
                            <i class="fa fa-book"></i> <span>???????????? ??????????????????</span>
                        </a>
                    </li>
                    <li class="@yield('medicineOrderManagement')">
                        <a href ="{{ url('medicineOrderManagement') }}" >
                            <i class="fa fa-book"></i> <span>?????????????????? ????????????</span>
                        </a>
                    </li>
                @endif
            </ul>
        </section>
        <!-- /.sidebar -->
    </aside>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                @yield('page_header')
            </h1>
        </section>
        <section class="content">
            @yield('content')
        </section>
    </div>
    <!-- /.content-wrapper -->
    <footer class="main-footer">
        <center><strong>&copy; ???????????????-????????????, ??????????????? ????????????????????? ???????????????????????????-  <a href="https://parallax-soft.com/" target="_blank">Parallax Soft Inc.</a></strong></center>
    </footer>
</div>

<!-- ./wrapper -->

<!-- jQuery 3 -->
<script src="{{url('public/asset/bower_components/jquery/dist/jquery.min.js')}}"></script>
<!-- Bootstrap 3.3.7 -->
<script src="{{url('public/asset/bower_components/bootstrap/dist/js/bootstrap.min.js')}}"></script>
<!-- Select2 -->
<script src="{{url('public/asset/bower_components/select2/dist/js/select2.full.min.js')}}"></script>
<!-- InputMask -->
<script src="{{url('public/asset/plugins/input-mask/jquery.inputmask.js')}}"></script>
<script src="{{url('public/asset/plugins/input-mask/jquery.inputmask.date.extensions.js')}}"></script>
<script src="{{url('public/asset/plugins/input-mask/jquery.inputmask.extensions.js')}}"></script>
<!-- date-range-picker -->
<script src="{{url('public/asset/bower_components/moment/min/moment.min.js')}}"></script>
{{--<script src="{{url('public/asset/bower_components/bootstrap-daterangepicker/daterangepicker.js')}}"></script>--}}
<!-- bootstrap datepicker -->
{{--<script src="{{url('public/asset/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js')}}"></script>--}}
<!-- bootstrap color picker -->
<script src="{{url('public/asset/bower_components/bootstrap-colorpicker/dist/js/bootstrap-colorpicker.min.js')}}"></script>
<!-- bootstrap time picker -->
{{--<script src="{{url('public/asset/plugins/timepicker/bootstrap-timepicker.min.js')}}"></script>--}}
<!-- SlimScroll -->
<script src="{{url('public/asset/bower_components/jquery-slimscroll/jquery.slimscroll.min.js')}}"></script>
<!-- iCheck 1.0.1 -->
<script src="{{url('public/asset/plugins/iCheck/icheck.min.js')}}"></script>
<!-- FastClick -->
<script src="{{url('public/asset/bower_components/fastclick/lib/fastclick.js')}}"></script>
<!-- AdminLTE App -->
<script src="{{url('public/asset/dist/js/adminlte.min.js')}}"></script>
<!-- AdminLTE for demo purposes -->
<script src="{{url('public/asset/dist/js/demo.js')}}"></script>
<script src="{{url('public/asset/toast/jquery.toast.js')}}"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script type="text/javascript">
    $(document).ajaxStart(function() {
        $(".loading").show();
    }).ajaxStop(function() {
        $(".loading").hide();
    });
    $(window).on('load', function () {
        $('#loading').hide();
    })
</script>
<!-- Page script -->
@yield('js')
</body>
</html>
