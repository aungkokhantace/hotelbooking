@extends('layouts_frontend.master_frontend')
@section('title','Manage Booking')
@section('content')
    <div id="header_id">
        <img class="img-responsive img-hover" src="/assets/shared/images/slider1.png">
    </div>
    </div>

    <section id="popular">
        <!-- Page Content -->
        <div class="container">
            <div class="row">
                <!-- Blog Sidebar Widgets Column -->
                <div class="col-md-3">
                    <!-- Blog-->
                    <div>
                        <div class="side_profile">
                            <img src="/assets/shared/images/user.png">
                            <h3>{{isset($customer)&&count($customer)?$customer['display_name']:''}}</h3>
                        </div>
                        <div class="side_gmail">
                            <p>{{isset($customer)?$customer['email']:''}}</p>
                        </div>
                        <div class="left_menu">
                            <ul>
                                <li><a class="active"href="#">Booking List</a></li>
                                <li><a href="/profile">My Profile</a></li>
                            </ul>
                        </div>
                    </div>

                </div><!-- Blog Entries Column -->
                <div class="col-md-9"><!-- Manage Booking Column-->
                    <div class="row">
                        <div class="col-lg-4 col-md-4 col-sm-4">
                            aaaa
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-4">
                            bbbb
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-4">
                            cccc
                        </div>
                    </div>
                </div><!-- Manage Booking Column-->
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container -->
    </section>
@stop

@section('page_script')

    <script>
        $(document).ready(function(){
            //
        });
    </script>

@stop