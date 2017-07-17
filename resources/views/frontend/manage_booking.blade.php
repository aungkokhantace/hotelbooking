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
                        <h3>Your confirmed booking at {{$hotel->name}}</h3>
                    </div>
                    <div class="row">
                        <div class="col-lg-4 col-md-4 col-sm-4">
                            <img src="/images/upload/{{$booking->hotel->logo}}" alt="img" style="width: 100%;height: auto;">
                            <p>{{$hotel->address}}</p>
                            <p>{{$hotel->phone}}</p>
                            <p>{{$hotel->email}}</p>
                            <p>{{$hotel->fax}}</p>

                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-4">
                            <p>Booking Number : {{$booking->booking_no}}</p>
                            <hr>
                            <p>
                                Check In <br>
                                <b>{{Carbon\Carbon::parse($booking->check_in_date)->format('M d, Y')}}</b><br/>
                                from <b>{{$booking->check_in_time}}</b>
                                <br/><br/>
                                Check Out <br>
                                <b>{{Carbon\Carbon::parse($booking->check_out_date)->format('M d, Y')}}</b><br/>
                                until <b>{{$booking->check_out_time}}</b>
                            </p>
                            <hr>
                            <p>
                                Price <br/>
                                <b>{{$booking->total_day}} night, {{$booking->room_count}} room</b>
                                <h4><b><i>{{$booking->total_payable_amt}} MMK</i></b></h4>
                            </p>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-4">
                            <a href="#">Change Date</a><br/>
                            <a href="#">View Policies</a><br/>
                            <a href="/booking/manage/congratulation/{{$hotel->id}}">View Confirmation</a><br/>
                            <a href="/booking/manage/print/{{$booking->id}}" target="_blank">Print Confirmation</a><br/>
                            <a href="#">Cancel Booking</a><br/>
                        </div>
                    </div>
                    <div class="row">
                        <p>Booking Cancel</p>
                    </div>
                    @foreach($booking->rooms as $room)
                    <div class="row"><!-- Booking Room Information -->
                        <div class="col-sm-3 col-md-3 col-lg-3">
                            <img src="{{$room->category_image}}" alt="room_image" style="width: 100%;height: auto;">
                        </div>
                        <div class="col-sm-6 col-md-6 col-lg-6">
                            <h4>{{$room->room_category}}</h4>
                            <p>
                                Guest : {{$room->guest_count}} <br/>
                                <b>Amenities</b><br/>

                                @foreach($room->amenities as $amenity)
                                    {{"* ".$amenity->name}}
                                @endforeach
                                <br/>

                                <b>Room Facilities</b><br/>
                                @foreach($room->facilities as $facility)
                                    {{"* ".$facility->name}}
                                @endforeach
                                <br/>
                                <b>Hotel Facilities</b><br/>
                                @foreach($hotel->h_facilities as $h_facility)
                                    {{"* ".$h_facility->facility->name}}
                                @endforeach
                            </p>
                        </div>
                    </div><!-- booking Room Information -->
                    <hr/><br/>
                    @endforeach
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