<?php
$user_info      = \App\Core\Check::getInfo();
$companyName    = \App\Core\Check::companyName();
$companyLogo    = \App\Core\Check::companyLogo();

?>
<!DOCTYPE html>
<!--[if IE 8]>
<html lang="en" class="ie8">
<![endif]-->
<!--[if !IE]><!-->
<html lang="en"  ng-app="aceplusApp">
<!--<![endif]-->
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Myanmar Polestar</title>

    <!-- for entire site font -->
    <link media="all" type="text/css" rel="stylesheet" href="/assets/shared/css/font-style.css">
    <!-- for entire site font -->


    <!-- Bootstrap Core CSS -->
    <link href="/assets/shared/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="/assets/shared/css/style.min.css" rel="stylesheet">
    <link href="/assets/shared/css/createacc.css" rel="stylesheet">
    <link href="/assets/shared/css/custom.css" rel="stylesheet">
    <link href="/assets/shared/css/profile.css" rel="stylesheet">
    <link href="/assets/shared/css/booking.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="/assets/shared/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Playfair+Display:700" rel="stylesheet">

    <!--Datepicker-->
    <link rel="stylesheet" href="/assets/shared/css/bootstrap-datepicker3.css"/>
    <link rel="stylesheet" href="/assets/shared/css/datepicker.min.css"/>

    <!--font-awesome-->
    <link rel="stylesheet" href="/assets/shared/css/font-awesome.css"/>
    <link rel="stylesheet" href="/assets/shared/css/font-awesome.min.css"/>

    <link media="all" type="text/css" rel="stylesheet" href="/assets/plugins/jquery-ui/themes/base/minified/jquery-ui.min.css">

    <!-- Sweet Alert -->
    <link media="all" type="text/css" rel="stylesheet" href="/assets/css/sweetalert.css">

    <!-- for select box with search function -->
    <link media="all" type="text/css" rel="stylesheet" href="/assets/css/select2.min.css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->


    <script src="/assets/shared/js/jquery.js"></script>
    <script src="/assets/plugins/jquery-ui/ui/minified/jquery-ui.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="/assets/shared/js/bootstrap.min.js"></script>

    <!-- Bootstrap Date-Picker Plugin -->
    <script type="text/javascript" src="/assets/shared/js/bootstrap-datepicker.min.js"></script>

    <!-- Jquery Validation -->
    <script src="/assets/shared/js/validation/jquery.validate.js"></script>
    <script src="/assets/shared/js/validation/additional-methods.js"></script>

    {{--<script src="http://maps.google.com/maps/api/js?key=AIzaSyAJLUg2IEbAOp4gMqRoXpSnjV0w1FDfYNk&sensor=false" type="text/javascript"></script>--}}

    <!-- for jssor slider -->
    <script src="/assets/shared/js/jssor.slider-23.1.5.min.js" type="text/javascript"></script>

    <!-- for stripe payment -->
    <script src="https://checkout.stripe.com/checkout.js"></script>

    <!-- for select box with search function -->
    <script src="/assets/js/select2.min.js"></script>

    <script src="/assets/js/crud.js"></script>

</head>

<body>
<section>
    <div id="nav_id">
        <!-- Navigation -->
        <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
            <div class="container">
                <!-- Brand and toggle get grouped for better mobile display -->
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <!-- <a class="navbar-brand" href="/"><img src="/assets/shared/images/mplogo.png"></a> -->
                    <a class="navbar-brand" href="/"><img src="{{$companyLogo}}"></a>
                </div>
                <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                    <ul class="nav navbar-nav navbar-right">
                        <li>
                            <a href="/">{{trans('frontend_header.home')}}</a>
                        </li>
                        <li>
                            {{--  <a href="/comingsoon"></a> Services --}}
                            <div class="login">
                                <ul>
                                    <li>
                                        <div class="dropdown">
                                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                               {{trans('frontend_header.services')}}
                                            </a>
                                            <ul class="dropdown-menu">
                                                <li><a href="/transportation_information">{{trans('frontend_header.transportation_information')}}</a></li>
                                                <li><a href="/tour_information">{{trans('frontend_header.tour_information')}}</a></li>
                                            </ul>
                                        </div>

                                    </li>
                                </ul>
                            </div>
                        </li>
                        <li>
                            <a href="/aboutus">{{trans('frontend_header.about_us')}}</a>
                        </li>
                        <li>
                            <a href="/faq_information">FAQ</a>
                        </li>
                         <li>
                            <a href="/visa_information">VISA</a>
                        </li>
                        <li>
                            <a href="/comingsoon">{{trans('frontend_header.contact_us')}}</a>
                        </li>
                        @if(!\Illuminate\Support\Facades\Session::has('customer'))
                        <li>
                            <a href="#" data-toggle="modal" data-target="#registerModal">{{trans('frontend_header.register')}}</a>
                            @include('frontend.registration')
                        </li>
                        @endif
                        <li>
                            <div class="login">
                                <ul>
                                    <li style="text-decoration:underline;">
                                        @if(\Illuminate\Support\Facades\Session::has('customer'))
                                            {{--<a href="\logout">--}}
                                                {{--Logout--}}
                                                {{--<span class="glyphicon glyphicon-arrow-left"></span>--}}
                                            {{--</a>--}}
                                            <div class="dropdown login">
                                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                                    <img src="/assets/shared/images/user1.png">
                                                    <span>
                                                        {{Auth::guard('Customer')->user()->first_name.' '.Auth::guard('Customer')->user()->last_name}}
                                                    </span>
                                                </a>
                                                <ul class="dropdown-menu">
                                                    <li><a href="\profile">{{trans('frontend_header.profile')}}</a></li>
                                                    <li><a href="\bookingList">{{trans('frontend_header.booking_list')}}</a></li>
                                                    <li><a href="\logout">{{trans('frontend_header.logout')}}</a></li>
                                                </ul>
                                            </div>
                                        @else
                                            <a href="#" data-toggle="modal" data-target="#loginModal">
                                               {{trans('frontend_header.login')}}
                                                <span class="glyphicon glyphicon-arrow-right"></span>
                                            </a>
                                            @include('frontend.login')
                                        @endif
                                    </li>
                                </ul>
                            </div>
                        </li>
                        <li>
                            <div class="language">
                                <ul>
                                    <li>
                                        <!-- <a href="#"><img src="/assets/shared/images/en_US.png"></a> -->
                                        <a href="#"><img src="/assets/shared/images/jp.png"></a>
                                    </li>
                                    <li style="text-decoration:underline;">
                                        <a href="#"><img src="/assets/shared/images/en_US.png"></a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                         
                <div class="navbar-header center">
                <form action="/frontend/language" method="post">
                    <select name="locale">
                        <option value="en" {{App::getLocale() == 'en'? 'selected':''}}>English</option>
                        <option value="jp" {{App::getLocale() == 'jp'? 'selected':''}}>Japan</option>
                    </select>
                    {{ csrf_field() }}
                    <input type="submit" value="Submit">
                </form>
            </div> 

                    </ul>
                </div>
                <!-- /.navbar-collapse -->
            </div>
            <!-- /.container -->
        </nav>
    </div>
