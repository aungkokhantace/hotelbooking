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
    <meta charset="utf-8" />

    <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport" />
    <meta content="" name="description" />
    <meta content="" name="author" />
    <title>{{$companyName}} - @yield('title')</title>

    <link href="/assets/css/AdminLTE.css" rel="stylesheet">
    <link media="all" type="text/css" rel="stylesheet" href="/assets/js/datepicker/datepicker3.css">
    <link media="all" type="text/css" rel="stylesheet" href="/assets/css/fullcalendar.css">
    <link media="all" type="text/css" rel="stylesheet" href="/assets/css/sweetalert.css">
    <link media="all" type="text/css" rel="stylesheet" href="/assets/css/multiple-select.css">
    <link media="all" type="text/css" rel="stylesheet" href="/assets/css/jktCuteDropdown.css">
    <link media="all" type="text/css" rel="stylesheet" href="/assets/css/style.css">
    <link href="http://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet">
    <link media="all" type="text/css" rel="stylesheet" href="/assets/plugins/jquery-ui/themes/base/minified/jquery-ui.min.css">
    <link media="all" type="text/css" rel="stylesheet" href="/assets/plugins/bootstrap/css/bootstrap.min.css">
    <link media="all" type="text/css" rel="stylesheet" href="/assets/plugins/font-awesome/css/font-awesome.min.css">
    <link media="all" type="text/css" rel="stylesheet" href="/assets/css/animate.min.css">
    <link media="all" type="text/css" rel="stylesheet" href="/assets/css/style.min.css">
    <link media="all" type="text/css" rel="stylesheet" href="/assets/css/style-custom.css">
    <link media="all" type="text/css" rel="stylesheet" href="/assets/css/plugin-prism.css">
    <link media="all" type="text/css" rel="stylesheet" href="/assets/css/style-responsive.min.css">
    <link media="all" type="text/css" rel="stylesheet" href="/assets/css/theme/default.css">
    <link media="all" type="text/css" rel="stylesheet" href="/assets/plugins/ionicons/css/ionicons.min.css">
    <link media="all" type="text/css" rel="stylesheet" href="/assets/plugins/DataTables/css/data-table.css">
    <link media="all" type="text/css" rel="stylesheet" href="/assets/plugins/gritter/css/jquery.gritter.css">
    <link media="all" type="text/css" rel="stylesheet" href="/assets/plugins/footable/footable.core.min.css">
    <link media="all" type="text/css" rel="stylesheet" href="/assets/plugins/footable/footable.metro.css">
    <link media="all" type="text/css" rel="stylesheet" href="/assets/plugins/switchery/switchery.min.css">
    <link media="all" type="text/css" rel="stylesheet" href="/assets/plugins/powerange/powerange.min.css">
    <link media="all" type="text/css" rel="stylesheet" href="/assets/plugins/jasny/css/jasny-bootstrap.css">
    <link media="all" type="text/css" rel="stylesheet" href="/assets/css/custom.css">
    <link media="all" type="text/css" rel="stylesheet" href="/assets/css/style-edit-navbar.css">

    {{--For summernote editor--}}
    <link rel="stylesheet" href="/assets/plugins/summernote/summernote.css" type="text/css" media="all" />

    <link media="all" type="text/css" rel="stylesheet" href="/assets/plugins/bootstrap-datepicker/css/datepicker3.css">
    <link media="all" type="text/css" rel="stylesheet" href="/assets/plugins/bootstrap-timepicker/css/bootstrap-timepicker.css">


    <script src="/assets/js/jquery.js"></script>
    <script src="/assets/js/apps.min.js"></script>
    <script src="/assets/plugins/jquery/jquery-1.9.1.min.js"></script>
    <script src="/assets/plugins/bootstrap/js/bootstrap.min.js"></script>
    <script src="/assets/plugins/jquery-cookie/jquery.cookie.js"></script>
    <script src="/assets/js/jquery-2.1.3.min.js"></script>
    <script src="/assets/js/bootstrap.min.js"></script>

    {{--<script src="/assets/plugins/jquery/jquery-1.9.1.min.js"></script>--}}
    <script src="/assets/plugins/jquery/jquery-migrate-1.1.0.min.js"></script>
    <script src="/assets/plugins/jquery-ui/ui/minified/jquery-ui.min.js"></script>
    <script src="/assets/plugins/bootstrap/js/bootstrap.min.js"></script>
    <script src="/assets/plugins/jquery-cookie/jquery.cookie.js"></script>
    <script src="/assets/plugins/DataTables/js/jquery.dataTables.js"></script>
    <script src="/assets/plugins/DataTables/js/dataTables.tableTools.js"></script>
    <script src="/assets/plugins/DataTables/js/dataTables.fixedHeader.js"></script>
    <script src="/assets/js/table-manage-tabletools.demo.min.js"></script>
    <script src="/assets/plugins/gritter/js/jquery.gritter.js"></script>
    <script src="/assets/plugins/slimscroll/jquery.slimscroll.min.js"></script>
    <script src="/assets/plugins/jasny/js/jasny-bootstrap.js"></script>
    <script src="/assets/plugins/footable/footable.all.min.js"></script>
    <script src="/assets/plugins/switchery/switchery.min.js"></script>
    <script src="/assets/plugins/switchery/switchery_function.js"></script>

    {{--For flash notification after create and update--}}
    <script src="/assets/js/aceplus.backend.functions.js"></script>

    {{--For summernote editor--}}
    <script src="/assets/plugins/summernote/summernote.min.js"></script>

    <script src="/assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
    <script src="/assets/plugins/bootstrap-timepicker/js/bootstrap-timepicker.js"></script>

    <script>
        $(document).ready(function() {
            App.init();
            TableManageTableTools.init();

            //check for notification
                    @if(Session::has('message'))
                        var message_title = "{{Session::get('message')['title']}}";
            var message_body = "{{Session::get('message')['body']}}";
            setTimeout(addNotification(message_title, message_body), 5000);
            @endif

            //set time out for the flash message..
            setTimeout(function(){
                $('#flash-message').hide("slow");
            }, 2000);
        });
    </script>

</head>

<body>
<!-- begin #header -->

<!-- end header>
<!-- begin #page-container -->
<div id="page-container" class="page-sidebar-fixed page-header-fixed">
    <!-- begin #sidebar -->
    <div id="sidebar" class="sidebar">
        <!-- begin sidebar scrollbar -->
        <div data-scrollbar="true" data-height="100%">
            <!-- begin sidebar nav -->
            <ul class="nav">
                <!-- begin sidebar minify button -->
                <li><a href="javascript:;" class="sidebar-minify-btn" data-click="sidebar-minify"><i class="fa fa-angle-double-left"></i></a></li>
                <!-- end sidebar minify button -->
                <li class="nav-header">{{trans('menu.title-report')}}</li>
                <li nav-id='report'  class="has-sub" >
                    <a href="javascript:;">
                        <b class="caret pull-right"></b>
                        <i class="fa fa-calendar"></i>
                        <span>{{trans('menu.group-report')}}</span>
                    </a>

                    <ul class="sub-menu">
                        <li nav-id="report-sale-summary"><a href="/backend/">Sale Summary Report</a></li>
                    </ul>
                </li>

                <li class="nav-header">{{trans('menu.title-backend')}}</li>


            </ul>
            <!-- end sidebar nav -->
        </div>
        <!-- end sidebar scrollbar -->
    </div>
    <div class="sidebar-bg"></div>    <!-- end #sidebar -->
    <!-- begin #content -->
    <div id="content" class="content">

        <h1 class="page-header">TEST</h1>


    </div>
    <!-- begin #Footer -->
    <div id="footer" class="footer">
        <div class="pull-right">&copy; <?php echo date('Y'); ?> AcePlus Solutions All Rights Reserved</div>
        Backend v1.0.0
    </div>        <!-- end #footer -->

    <!-- begin scroll to top btn -->
    <a href="javascript:;" class="btn btn-icon btn-circle btn-success btn-scroll-to-top fade" data-click="scroll-top"><i class="fa fa-angle-up"></i></a>
    <!-- end scroll to top btn -->
</div>
<!-- end page container -->

<script src="/assets/js/validation/jquery.validate.js"></script>
{{--<script src="/assets/js/validation/validation.js"></script>--}}
{{--<script src="/assets/js/checkall.js"></script>--}}
<script src="/assets/js/jktCuteDropdown.min.js"></script>
<script src="/assets/js/datepicker/bootstrap-datepicker.js"></script>
<script src="/assets/js/combodate.js"></script>
<script src="/assets/js/amcharts.min.js"></script>
<script src="/assets/js/serial.min.js"></script>
<script src="/assets/js/light.min.js"></script>

<script src="/assets/js/crud.js"></script>
{{--<script src="/assets/js/delete.js"></script>--}}

<script src="/assets/js/checkbox.js"></script>
<script src="/assets/js/sweetalert-dev.js"></script>
<script src="/assets/js/dropdown-checkbox.js"></script>
<script src="/assets/js/moment.min.js"></script>
<script src="/assets/js/custom.min.js"></script>
<script src="/assets/js/fileupload.js"></script>


{{--<script src="/assets/js/downloadexcel_redirect.js"></script>--}}
{{--<script src="/assets/js/date.js"></script>--}}


</body>
</html>