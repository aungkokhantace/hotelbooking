<?php
$user_info = \App\Core\Check::getInfo();
$companyName = \App\Core\Check::companyName();
$companyLogo = \App\Core\Check::companyLogo();
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

    <title>Myanmar Polestar</title>

    <!-- Bootstrap Core CSS -->
    <link href="shared/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="shared/css/style.min.css" rel="stylesheet">
    <link href="shared/css/custom.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="shared/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Playfair+Display:700" rel="stylesheet">

    <!--Datepicker-->
    <link rel="stylesheet" href="shared/css/bootstrap-datepicker3.css"/>
    <link rel="stylesheet" href="shared/css/datepicker.min.css"/>

    <!--font-awesome-->
    <link rel="stylesheet" href="shared/css/font-awesome.css"/>
    <link rel="stylesheet" href="shared/css/font-awesome.min.css"/>

    <link media="all" type="text/css" rel="stylesheet" href="/assets/plugins/jquery-ui/themes/base/minified/jquery-ui.min.css">



    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

    <script src="shared/js/jquery.js"></script>

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
                    <a class="navbar-brand" href="/"><img src="/shared/images/mplogo.png"></a>
                </div>
                <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                    <ul class="nav navbar-nav navbar-right">
                        <li>
                            <a href="/">Home</a>
                        </li>
                        <li>
                            <a href="searchresult.html">Destinations</a>
                        </li>
                        <li>
                            <a href="aboutus.html">About Us</a>
                        </li>
                        <li>
                            <a href="#">FAQ</a>
                        </li>
                        <li>
                            <a href="#">Contact Us</a>
                        </li>
                        <li>
                            <div class="login">
                                <ul>
                                    <li style="text-decoration:underline;">
                                        <a href="contact.html">Login<span class="glyphicon glyphicon-arrow-right"></span></a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                        <li>
                            <div class="language">
                                <ul>
                                    <li>
                                        <a href="#"><img src="/shared/images/en_US.png"></a>
                                    </li>
                                    <li style="text-decoration:underline;">
                                        <a href="#"><img src="/shared/images/my_MM.png"></a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                    </ul>
                </div>
                <!-- /.navbar-collapse -->
            </div>
            <!-- /.container -->
        </nav>
    </div>