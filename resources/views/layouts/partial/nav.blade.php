<!-- begin #sidebar -->
<div id="sidebar" class="sidebar">
    <!-- begin sidebar scrollbar -->
    <div data-scrollbar="true" data-height="100%">
        <!-- begin sidebar nav -->
        <ul class="nav">
            <!-- begin sidebar minify button -->
            <li><a href="javascript:;" class="sidebar-minify-btn" data-click="sidebar-minify"><i class="fa fa-angle-double-left"></i></a></li>
            <!-- end sidebar minify button -->

            {{--Only Admin and Super Admin Access--}}
            @if (Auth::guard('User')->user()->role_id == 1 || Auth::guard('User')->user()->role_id == 2)
            <li  nav-id='modifier'  class="has-sub">
                <a href="javascript:;">
                    <b class="caret pull-right"></b>
                    <i class="fa fa-sitemap"></i>
                    <span>General</span>
                </a>
                <ul class="sub-menu">
                    {{--<li nav-id="modifier-manage" class="has-sub">--}}
                        {{--<a href="javascript:;">--}}
                            {{--<b class="caret pull-right"></b>--}}
                            {{--<span>Site Config</span>--}}
                        {{--</a>--}}

                        {{--<ul class="sub-menu">--}}
                            {{--<li nav-id="modifier-manage-modifier"><a href="/backend_mps/site_config">Edit Config</a></li>--}}

                        {{--</ul>--}}
                    {{--</li>--}}
                    <li nav-id="modifier-manage" class="has-sub">
                        <a href="/backend_mps/nearby_category">Nearby Category</a>
                        {{--  <a href="javascript:;">
                            <b class="caret pull-right"></b>
                            <span><a href="/backend_mps/nearby_category">Nearby Category</a></span>
                        </a>  --}}

                        {{--  <ul class="sub-menu">
                            <li nav-id="modifier-manage-modifier"><a href="/backend_mps/nearby_category/create">Entry</a></li>
                            <li nav-id="modifier-manage-modifierpanel"><a href="/backend_mps/nearby_category">List</a></li>
                        </ul>  --}}
                    </li>
                    <li nav-id="modifier-create" class="has-sub">
                        <a href="/backend_mps/hotel_nearby">Hotel Nearby</a>
                        {{--  <a href="javascript:;">
                            <b class="caret pull-right"></b>
                            <span>Hotel Nearby</span>
                        </a>

                        <ul class="sub-menu">
                            <li nav-id="modifier-create-modifier"><a href="/backend_mps/hotel_nearby/create">Entry</a></li>
                            <li nav-id="modifier-create-modifierpanel"><a href="/backend_mps/hotel_nearby">List</a></li>
                        </ul>  --}}
                    </li>
                    <li nav-id="modifier-create" class="has-sub">
                        <a href="/backend_mps/facility_group">Facility Group</a>
                        {{--  <a href="javascript:;">
                            <b class="caret pull-right"></b>
                            <span>Facility Group</span>
                        </a>

                        <ul class="sub-menu">
                            <li nav-id="modifier-create-modifier"><a href="/backend_mps/facility_group/create">Entry</a></li>
                            <li nav-id="modifier-create-modifierpanel"><a href="/backend_mps/facility_group">List</a></li>
                        </ul>  --}}
                    </li>
                    <li nav-id="modifier-create" class="has-sub">
                        <a href="/backend_mps/facilities">Facilities</a>
                        {{--  <a href="javascript:;">
                            <b class="caret pull-right"></b>
                            <span>Facilities</span>
                        </a>

                        <ul class="sub-menu">
                            <li nav-id="modifier-create-modifier"><a href="/backend_mps/facilities/create">Entry</a></li>
                            <li nav-id="modifier-create-modifierpanel"><a href="/backend_mps/facilities">List</a></li>
                        </ul>  --}}
                    </li>
                    <li nav-id="modifier-manage" class="has-sub">
                        <a href="/backend_mps/feature">Features</a>
                        {{--  <a href="javascript:;">
                            <b class="caret pull-right"></b>
                            <span>Features</span>
                        </a>

                        <ul class="sub-menu">
                            <li nav-id="modifier-manage-modifier"><a href="/backend_mps/feature/create">Entry</a></li>
                            <li nav-id="modifier-manage-modifierpanel"><a href="/backend_mps/feature">List</a></li>

                        </ul>  --}}
                    </li>
                    <li nav-id="modifier-create" class="has-sub">
                        <a href="/backend_mps/amenities">Amenities</a>
                        {{--  <a href="javascript:;">
                            <b class="caret pull-right"></b>
                            <span>Amenities</span>
                        </a>

                        <ul class="sub-menu">
                            <li nav-id="modifier-create-modifier"><a href="/backend_mps/amenities/create">Entry</a></li>
                            <li nav-id="modifier-create-modifierpanel"><a href="/backend_mps/amenities">List</a></li>
                        </ul>  --}}
                    </li>

                    <li nav-id="modifier-create" class="has-sub">
                        <a href="/backend_mps/landmark">Landmark</a>
                        {{--  <a href="javascript:;">
                            <b class="caret pull-right"></b>
                            <span>Landmark</span>
                        </a>

                        <ul class="sub-menu">
                            <li nav-id="modifier-create-modifier"><a href="/backend_mps/landmark/create">Entry</a></li>
                            <li nav-id="modifier-create-modifierpanel"><a href="/backend_mps/landmark">List</a></li>
                        </ul>  --}}
                    </li>

                    <li nav-id="modifier-manage" class="has-sub">
                        <a href="/backend_mps/country">Country</a>
                        {{--  <a href="javascript:;">
                            <b class="caret pull-right"></b>
                            <span>Country</span>
                        </a>

                        <ul class="sub-menu">
                            <li nav-id="modifier-manage-modifier"><a href="/backend_mps/country/create">Entry</a></li>
                            <li nav-id="modifier-manage-modifierpanel"><a href="/backend_mps/country">List</a></li>
                        </ul>  --}}
                    </li>
                    <li nav-id="modifier-create" class="has-sub">
                        <a href="javascript:;">
                            <b class="caret pull-right"></b>
                            <span>City</span>
                        </a>

                        <ul class="sub-menu">
                            {{--  <li nav-id="modifier-create-modifier"><a href="/backend_mps/city/create">Entry</a></li>  --}}
                            <li nav-id="modifier-create-modifierpanel"><a href="/backend_mps/city">City</a></li>
                            <li nav-id="modifier-create-modifierpanel"><a href="/backend_mps/popular_city/create">Set Popular City</a></li>
                        </ul>
                    </li>
                    <li nav-id="modifier-manage" class="has-sub">
                        <a href="/backend_mps/township">Township</a>
                        {{--  <a href="javascript:;">
                            <b class="caret pull-right"></b>
                            <span>Township</span>
                        </a>

                        <ul class="sub-menu">
                            <li nav-id="modifier-manage-modifier"><a href="/backend_mps/township/create">Entry</a></li>
                            <li nav-id="modifier-manage-modifierpanel"><a href="/backend_mps/township">List</a></li>

                        </ul>  --}}
                    </li>

                    {{--<li nav-id="modifier-manage" class="has-sub">--}}
                        {{--<a href="javascript:;">--}}
                            {{--<b class="caret pull-right"></b>--}}
                            {{--<span>Transportation Information</span>--}}
                        {{--</a>--}}

                        {{--<ul class="sub-menu">--}}
                            {{--<li nav-id="modifier-manage-modifier"><a href="backend_mps/transportation_information">Entry</a></li>--}}
                        {{--</ul>--}}
                    {{--</li>--}}

                    <li nav-id="">
                        <a href="/backend_mps/transportation_information">
                            {{--  <b class="caret pull-right"></b>  --}}
                            <span>Transportation Information</span>
                        </a>
                    </li>

                    <li nav-id="">
                        <a href="/backend_mps/tour_information">
                            {{--  <b class="caret pull-right"></b>  --}}
                            <span>Tour Guide Information</span>
                        </a>
                    </li>

                    {{--<li nav-id="modifier-manage" class="has-sub">--}}
                        {{--<a href="javascript:;">--}}
                            {{--<b class="caret pull-right"></b>--}}
                            {{--<span>Page</span>--}}
                        {{--</a>--}}

                        {{--<ul class="sub-menu">--}}
                            {{--<li nav-id="modifier-manage-modifierpanel"><a href="/backend_mps/page">List</a></li>--}}
                        {{--</ul>--}}
                    {{--</li>--}}
                </ul>
            </li>
            @endif
            <li  nav-id='modifier'  class="has-sub">
                <a href="javascript:;">
                    <b class="caret pull-right"></b>
                    <i class="fa fa-university"></i>
                    <span>Hotel Management</span>
                </a>
                <ul class="sub-menu">
                    <li nav-id="modifier-create" class="has-sub">
                        {{-- <a href="javascript:;">
                            <b class="caret pull-right"></b>
                            <span>Hotel</span>
                        </a> --}}
                    <a href="/backend_mps/hotel">Hotel</a></li>
                        {{-- <ul class="sub-menu">
                            <li nav-id="modifier-create-modifier"><a href="/backend_mps/hotel/create">Entry</a></li>
                            <li nav-id="modifier-create-modifierpanel"><a href="/backend_mps/hotel">List</a></li>
                            <li nav-id="modifier-create-modifierpanel"><a href="/backend_mps/recommend_hotel/create">Set Recommend Hotel</a></li>
                        </ul> --}}
                    </li>
                    @if (Auth::guard('User')->user()->role_id == 1 || Auth::guard('User')->user()->role_id == 2)
                    <li nav-id="modifier-create" class="has-sub">
                        <a href="/backend_mps/recommend_hotel/create">Set Recommend Hotel</a>
                    </li>
                  {{--  <li nav-id="modifier-create" class="has-sub">
                        <a href="javascript:;">
                            <b class="caret pull-right"></b>
                            <span>Hotel Config</span>
                        </a>

                        <ul class="sub-menu">
                            <li nav-id="modifier-create-modifier"><a href="/backend_mps/hotel_config/create">Entry</a></li>
                            <li nav-id="modifier-create-modifierpanel"><a href="/backend_mps/hotel_config">List</a></li>
                        </ul>
                    </li>
                    <li nav-id="modifier-create" class="has-sub">
                        <a href="javascript:;">
                            <b class="caret pull-right"></b>
                            <span>Hotel Landmark</span>
                        </a>

                        <ul class="sub-menu">
                            <li nav-id="modifier-create-modifier"><a href="/backend_mps/hotel_landmark/create">Entry</a></li>
                            <li nav-id="modifier-create-modifierpanel"><a href="/backend_mps/hotel_landmark">List</a></li>
                        </ul>
                    </li>
                    <li nav-id="modifier-create" class="has-sub">
                        <a href="javascript:;">
                            <b class="caret pull-right"></b>
                            <span>Hotel Feature</span>
                        </a>

                        <ul class="sub-menu">
                            <li nav-id="modifier-create-modifier"><a href="/backend_mps/hotel_feature/create">Entry</a></li>
                            <li nav-id="modifier-create-modifierpanel"><a href="/backend_mps/hotel_feature">List</a></li>
                        </ul>
                    </li>

                    <li nav-id="modifier-create" class="has-sub">
                        <a href="javascript:;">
                            <b class="caret pull-right"></b>
                            <span>Hotel Facility</span>
                        </a>

                        <ul class="sub-menu">
                            <li nav-id="modifier-create-modifier"><a href="/backend_mps/hotel_facility/create">Entry</a></li>
                            <li nav-id="modifier-create-modifierpanel"><a href="/backend_mps/hotel_facility">List</a></li>
                        </ul>
                    </li>--}}
                    <li nav-id="modifier-create" class="has-sub">
                       <!--  <a href="javascript:;">
                           <b class="caret pull-right"></b>
                           <span>Hotel Restaurant Category</span>
                       </a> -->
                        <a href="/backend_mps/hotel_restaurant_category">Hotel Restaurant Category</a>
                        <!-- <ul class="sub-menu">
                            <li nav-id="modifier-create-modifier"><a href="/backend_mps/hotel_restaurant_category/create">Entry</a></li>
                            <li nav-id="modifier-create-modifierpanel"><a href="/backend_mps/hotel_restaurant_category">List</a></li>
                        </ul> -->
                    </li>
                    <li nav-id="modifier-create" class="has-sub">
                       <!--  <a href="javascript:;">
                           <b class="caret pull-right"></b>
                           <span>Hotel Restaurant</span>
                       </a> -->
                        <a href="/backend_mps/hotel_restaurant">Hotel Restaurant</a>
                        <!-- <ul class="sub-menu">
                            <li nav-id="modifier-create-modifier"><a href="/backend_mps/hotel_restaurant/create">Entry</a></li>
                            <li nav-id="modifier-create-modifierpanel"><a href="/backend_mps/hotel_restaurant">List</a></li>
                        </ul> -->
                    </li>

                    @endif

                     <!-- Hotel Gallery -->
                     <li nav-id="modifier-create" class="has-sub">
                        <a href="/backend_mps/hotel_gallery">Hotel Gallery</a>
                    </li>
                </ul>
            </li>



            <li  nav-id='modifier'  class="has-sub">
                <a href="javascript:;">
                    <b class="caret pull-right"></b>
                    <i class="fa fa-key"></i>
                    <span>Room Management</span>
                </a>
                <ul class="sub-menu">
                    {{-- <li nav-id="modifier-create" class="has-sub">
                        <a href="javascript:;">
                            <b class="caret pull-right"></b>
                            <span>Room Type</span>
                        </a>
                        <a href="/backend_mps/hotel_room_type">Room Type</a>
                        <ul class="sub-menu">
                            <li nav-id="modifier-create-modifier"><a href="/backend_mps/hotel_room_type/create">Entry</a></li>
                            <li nav-id="modifier-create-modifierpanel"><a href="/backend_mps/hotel_room_type">List</a></li>
                        </ul>
                    </li> --}}
                    <li nav-id="modifier-create">
                        <a href="/backend_mps/hotel_room_type">Hotel Room Type</a>
                    </li>
                    <li nav-id="modifier-create" class="has-sub">
                        <!-- <a href="javascript:;">
                            <b class="caret pull-right"></b>
                            <span>Hotel Room Category</span>
                        </a> -->
                        <a href="/backend_mps/hotel_room_category">Hotel Room Category</a>
                        <!-- <ul class="sub-menu">
                            <li nav-id="modifier-create-modifier"><a href="/backend_mps/hotel_room_category/create">Entry</a></li>
                            <li nav-id="modifier-create-modifierpanel"><a href="/backend_mps/hotel_room_category">List</a></li>
                        </ul> -->
                    </li>
                    @if (Auth::guard('User')->user()->role_id == 1 || Auth::guard('User')->user()->role_id == 2)
                    <li nav-id="modifier-create" class="has-sub">
                        <!-- <a href="javascript:;">
                            <b class="caret pull-right"></b>
                            <span>Room View</span>
                        </a> -->
                        <a href="/backend_mps/room_view">Room View</a>
                        <!-- <ul class="sub-menu">
                            <li nav-id="modifier-create-modifier"><a href="/backend_mps/room_view/create">Entry</a></li>
                            <li nav-id="modifier-create-modifierpanel"><a href="/backend_mps/room_view">List</a></li>
                        </ul> -->
                    </li>
                    @endif
                    <li nav-id="modifier-create" class="has-sub">
                        <!-- <a href="javascript:;">
                            <b class="caret pull-right"></b>
                            <span>Room</span>
                        </a> -->
                        <a href="/backend_mps/room">Room</a>
                        <!-- <ul class="sub-menu">
                            <li nav-id="modifier-create-modifier"><a href="/backend_mps/room/create">Entry</a></li>
                            <li nav-id="modifier-create-modifierpanel"><a href="/backend_mps/room">List</a></li>
                        </ul> -->
                    </li>

                    @if (Auth::guard('User')->user()->role_id == 1 || Auth::guard('User')->user()->role_id == 2)
                    {{--<li nav-id="modifier-create" class="has-sub">
                        <a href="javascript:;">
                            <b class="caret pull-right"></b>
                            <span>Room Category Facilities</span>
                        </a>

                        <ul class="sub-menu">
                            <li nav-id="modifier-create-modifier"><a href="/backend_mps/room_category_facility/create">Entry</a></li>
                            <li nav-id="modifier-create-modifierpanel"><a href="/backend_mps/room_category_facility">List</a></li>
                        </ul>
                    </li>
                    <li nav-id="modifier-create" class="has-sub">
                        <a href="javascript:;">
                            <b class="caret pull-right"></b>
                            <span>Room Category Amenities</span>
                        </a>

                        <ul class="sub-menu">
                            <li nav-id="modifier-create-modifier"><a href="/backend_mps/room_category_amenity/create">Entry</a></li>
                            <li nav-id="modifier-create-modifierpanel"><a href="/backend_mps/room_category_amenity">List</a></li>
                        </ul>
                    </li>--}}
                    <li nav-id="modifier-create" class="has-sub">
                        <!-- <a href="javascript:;">
                            <b class="caret pull-right"></b>
                            <span>Room Discount</span>
                        </a> -->
                        <a href="/backend_mps/room_discount">Room Discount</a>
                        <!-- <ul class="sub-menu">
                            <li nav-id="modifier-create-modifier"><a href="/backend_mps/room_discount/create">Entry</a></li>
                            <li nav-id="modifier-create-modifierpanel"><a href="/backend_mps/room_discount">List</a></li>
                        </ul> -->
                    </li>
                @endif
                </ul>
            </li>

            <li  nav-id='modifier'  class="has-sub">
                <a href="javascript:;">
                    <b class="caret pull-right"></b>
                    <i class="fa fa-phone"></i>
                    <span>Booking Management</span>
                </a>
                <ul class="sub-menu">
                    <li nav-id="modifier-create" class="has-sub">
                        <!-- <a href="javascript:;">
                            <b class="caret pull-right"></b>
                            <span>Booking</span>
                        </a> -->
                        <a href="/backend_mps/booking">Booking</a>
                        <!-- <ul class="sub-menu">
                            <li nav-id="modifier-create-modifierpanel"><a href="/backend_mps/booking">List</a></li>
                        </ul> -->
                    </li>

                    <li nav-id="modifier-create" class="has-sub">
                        <!-- <a href="javascript:;">
                            <b class="caret pull-right"></b>
                            <span>Communication</span>
                        </a> -->
                        <a href="/backend_mps/communication">Communication</a>
                        <!-- <ul class="sub-menu">
                            <li nav-id="modifier-create-modifierpanel"><a href="/backend_mps/communication">List</a></li>
                        </ul> -->
                    </li>
                </ul>
            </li>

            @if (Auth::guard('User')->user()->role_id == 1 || Auth::guard('User')->user()->role_id == 2)

            <li nav-id="modifier-create" class="has-sub">
                <a href="javascript:;">
                    <b class="caret pull-right"></b>
                    <i class="fa fa-key"></i>
                    <span>Room Availability Management</span>
                </a>
                <ul class="sub-menu">

                    <li nav-id="modifier-create" class="has-sub">
                        <!-- <a href="javascript:;">
                            <b class="caret pull-right"></b>
                            <span>Room Available Period</span>
                        </a> -->
                        <a href="/backend_mps/room_available_period">Room Available Period</a>
                        <!-- <ul class="sub-menu">
                            <li nav-id="modifier-create-modifier"><a href="/backend_mps/room_available_period/create">Entry</a></li>
                            <li nav-id="modifier-create-modifierpanel"><a href="/backend_mps/room_available_period">List</a></li>
                        </ul> -->
                    </li>
                    <li nav-id="modifier-create" class="has-sub">
                        <!-- <a href="javascript:;">
                            <b class="caret pull-right"></b>
                            <span>Room Blackout Period</span>
                        </a> -->
                        <a href="/backend_mps/room_blackout_period">Room Blackout Period</a>
                        <!-- <ul class="sub-menu">
                            <li nav-id="modifier-create-modifier"><a href="/backend_mps/room_blackout_period/create">Entry</a></li>
                            <li nav-id="modifier-create-modifierpanel"><a href="/backend_mps/room_blackout_period">List</a></li>
                        </ul> -->
                    </li>
                </ul>
            </li>

            @if (Auth::guard('User')->user()->role_id == 1)
            <li nav-id="modifier-create" class="has-sub">
                <a href="javascript:;">
                    <b class="caret pull-right"></b>
                    <i class="fa fa-file-excel-o"></i>
                    <span>{{trans('menu.group-import')}}</span>
                </a>
                <ul class="sub-menu">

                    <li nav-id="modifier-create" class="has-sub">
                        <li nav-id="modifier-create-modifier"><a href="/backend_mps/import">CSV Import</a></li>
                    </li>
                </ul>
            </li>
            @endif

            @if (Auth::guard('User')->user()->role_id == 1 || Auth::guard('User')->user()->role_id == 2)
            <li  nav-id='modifier'  class="has-sub">
                <a href="javascript:;">
                    <b class="caret pull-right"></b>
                    <i class="fa fa-file-image-o"></i>
                    <span>Slider Management</span>
                </a>
                <ul class="sub-menu">
                    <li nav-id="modifier-manage" class="has-sub">
                        <!-- <a href="javascript:;">
                            <b class="caret pull-right"></b>
                            <span>Slider</span>
                        </a> -->
                        <a href="/backend_mps/slider">Slider</a>
                        <!-- <ul class="sub-menu">
                            <li nav-id="modifier-manage-modifier"><a href="/backend_mps/slider/create">Entry</a></li>
                            <li nav-id="modifier-manage-modifierpanel"><a href="/backend_mps/slider">List</a></li>
                        </ul> -->
                    </li>

                </ul>
            </li>
            @endif
            <li nav-id='report'  class="has-sub" >
                <a href="javascript:;">
                    <b class="caret pull-right"></b>
                    <i class="fa fa-line-chart"></i>
                    <span>{{trans('menu.group-report')}}</span>
                </a>

                <ul class="sub-menu">
                    <li nav-id="report-sale-summary"><a href="/backend_mps/salesummaryreport">Sale Summary Report</a></li>
                    <li nav-id="report-booking-summary"><a href="/backend_mps/bookingreport">Booking Detail Report</a></li>

                </ul>
            </li>
            @endif
            @if (Auth::guard('User')->user()->role_id != 3)
            <li  nav-id='modifier'  class="has-sub">
                <a href="javascript:;">
                    <b class="caret pull-right"></b>
                    <i class="fa fa-cog"></i>
                    <span>{{trans('menu.group-setup')}}</span>
                </a>
                <ul class="sub-menu">
                     @if (Auth::guard('User')->user()->role_id == 1)
                    <li nav-id="modifier-manage" class="has-sub">
                        <!-- <a href="javascript:;">
                            <b class="caret pull-right"></b>
                            <span>Role</span>
                        </a> -->
                        <a href="/backend_mps/role">Role</a>
                        <!-- <ul class="sub-menu">
                            <li nav-id="modifier-manage-modifier"><a href="/backend_mps/role/create">Entry</a></li>
                            <li nav-id="modifier-manage-modifierpanel"><a href="/backend_mps/role">List</a></li>
                        </ul> -->
                    </li>
                    @endif

                    @if (Auth::guard('User')->user()->role_id == 1)
                    <li nav-id="modifier-manage" class="has-sub">
                        <!-- <a href="javascript:;">
                            <b class="caret pull-right"></b>
                            <span>Permission</span>
                        </a> -->
                        <a href="/backend_mps/permission">Permission</a>
                        <!-- <ul class="sub-menu">
                            <li nav-id="modifier-manage-modifier"><a href="/backend_mps/permission/create">Entry</a></li>
                            <li nav-id="modifier-manage-modifierpanel"><a href="/backend_mps/permission">List</a></li>
                        </ul> -->
                    </li>
                    @endif

                    @if (Auth::guard('User')->user()->role_id == 1 || Auth::guard('User')->user()->role_id == 2)
                    <li nav-id="modifier-create" class="has-sub">
                        <!-- <a href="javascript:;">
                            <b class="caret pull-right"></b>
                            <span>Staff</span>
                        </a> -->
                        <a href="/backend_mps/user">Staff</a>
                        <!-- <ul class="sub-menu">
                            <li nav-id="modifier-create-modifier"><a href="/backend_mps/user/create">Entry</a></li>
                            <li nav-id="modifier-create-modifierpanel"><a href="/backend_mps/user">List</a></li>
                        </ul> -->
                    </li>
                    @endif

                    @if (Auth::guard('User')->user()->role_id == 1 || Auth::guard('User')->user()->role_id == 2)
                    <li nav-id="modifier-creat" class="has-sub">
                        <a href="/backend_mps/config">
                            {{-- <b class="caret pull-right"></b> --}}
                            <span>Site Config</span>
                        </a>
                    </li>
                    @endif
                </ul>

            </li>
            @endif
            @if (Auth::guard('User')->user()->role_id == 1 )
            <li  nav-id='modifier'  class="has-sub">
                <a href="javascript:;">
                    <b class="caret pull-right"></b>
                    <i class="fa fa-envelope"></i>
                    <span>Email Management</span>
                </a>
                <ul class="sub-menu">
                    <li nav-id="modifier-manage" class="has-sub">
                        <!-- <a href="javascript:;">
                            <b class="caret pull-right"></b>
                            <span>Event Email</span>
                        </a> -->
                        <a href="/backend_mps/eventemail">Event Email</a>
                        <!-- <ul class="sub-menu">
                            <li nav-id="modifier-manage-modifier"><a href="/backend_mps/eventemail/create">Entry</a></li>
                            <li nav-id="modifier-manage-modifierpanel"><a href="/backend_mps/eventemail">List</a></li>
                        </ul> -->
                    </li>

                    <li nav-id="modifier-manage" class="has-sub">
                        <a href="javascript:;">
                            <b class="caret pull-right"></b>
                            <span>Event Text</span>
                        </a>

                        <ul class="sub-menu">
                            <li nav-id="modifier-manage-modifier"><a href="/backend_mps/email_template_booking_confirm">Email Booking Confirm</a></li>
                            <li nav-id="modifier-manage-modifier"><a href="/backend_mps/email_template_booking_cancel">Email Booking Cancel</a></li>
                            <li nav-id="modifier-manage-modifier"><a href="/backend_mps/email_template_booking_edit">Email Booking Edit</a></li>
                        </ul>
                    </li>
                </ul>
            </li>
            @endif
            @if (Auth::guard('User')->user()->role_id == 1)
            <li  nav-id='modifier'  class="has-sub">
                <a href="javascript:;">
                    <b class="caret pull-right"></b>
                    <i class="fa fa-gears"></i>
                    <span>{{trans('menu.group-developer')}}</span>
                </a>
                <ul class="sub-menu">
                    <li nav-id="modifier-manage" class="has-sub">
                        <!-- <a href="javascript:;">
                            <b class="caret pull-right"></b>
                            <span>Reference</span>
                        </a> -->
                        <a href="/backend_mps/systemreference">System Reference</a>
                        <!-- <ul class="sub-menu">
                            <li nav-id="systemreference"><a href="/backend_mps/systemreference">System Reference</a></li>
                        </ul> -->
                    </li>

                    <li nav-id="modifier-manage" class="has-sub">
                        <!-- <a href="javascript:;">
                            <b class="caret pull-right"></b>
                            <span>Samples</span>
                        </a> -->
                        <a href="/samples/googlemap">Google Map Sample</a>
                        <!-- <ul class="sub-menu">
                            <li nav-id="samples_googlemap"><a href="/samples/googlemap">Google Map Sample</a></li>
                        </ul> -->
                    </li>
                </ul>
            </li>
            @endif

        </ul>
        <!-- end sidebar nav -->
    </div>
    <!-- end sidebar scrollbar -->
</div>
<div class="sidebar-bg"></div>    <!-- end #sidebar -->


<script type="text/javascript">
    $(document).ready(function() {
        //make sidebar active current tab when a page is selected
        var path = window.location.pathname;
//        path = path.replace(/\/$/, "");
//        path = decodeURIComponent(path);
        var submenu = '.sub-menu li';
        var hassub = '.has-sub';

        $(hassub).removeClass('active');
        $(submenu).removeClass('active');

        $(".sub-menu li a").each(function () {
            var href = $(this).attr('href');

            if (path === href) {
                $(this).closest('li').addClass('active');
                $(this).closest('.has-sub').addClass('active');
                $(this).parents(".has-sub:eq(1)").toggleClass("active");
            }
        });
    });
</script>
