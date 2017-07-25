@extends('layouts_frontend.master_frontend')
@section('title','Booking Cancellation')
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
                <div class="col-md-9"><!-- Booking Cancellation Show Column-->
                    <div class="row">
                        <a href="/bookingList">Back to all bookings</a>
                    </div>
                    <div class="row">
                        <div class="col-md-12" style="border: solid 2px grey;">
                            <h4>Your reservation at {{$hotel->name}} has been cancelled.</h4>
                            <p>
                                We have been sent an email confirming your cancellation to {{$customer['email']}}.
                            </p>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-md-2">
                            <img src="/images/upload/{{$hotel->logo}}" style="width: 100%;height: 50%;" alt="hotel_logo">
                        </div>
                        <div class="col-md-10">
                            <div class="row">
                                <span style="font-size: 14pt;font-weight: bold;">{{$hotel->name}}</span>
                                <p>
                                    {{$hotel->address}}
                                </p>
                            </div>
                            <!-- -->
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-md-2" style="text-align: center;">
                            <span style="font-size:8pt;">CHECK IN</span><br/>
                                    <span style="font-size:11pt;font-weight: bold;">
                                        {{$booking->check_in_date_fmt}}
                                    </span>
                        </div>
                        <div class="col-md-3" style="text-align: center;">
                            <span style="font-size:8pt;">CHECK OUT</span><br>
                                    <span style="font-size:11pt;font-weight: bold;">
                                        {{$booking->check_out_date_fmt}}
                                    </span>
                        </div>
                        <div class="col-md-6">
                            <span style="font-size: 14pt;font-weight: bold;color: red;">Cancelled</span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-offset-1 col-md-10">
                            <span>{{$booking->total_day}} Night</span>
                            <span>{{$booking->room_count}} Rooms</span>
                        </div>
                    </div>
                </div><!-- Booking Cancellation Show Column-->
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