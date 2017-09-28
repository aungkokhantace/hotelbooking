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
            @if (Auth::guard('User')->user()->role_id == 1)
            <li  nav-id='modifier'  class="has-sub">
                <a href="javascript:;">
                    <b class="caret pull-right"></b>
                    <i class="fa fa-users"></i>
                    <span>General</span>
                </a>
                <ul class="sub-menu">
                    {{--<li nav-id="modifier-manage" class="has-sub">--}}
                        {{--<a href="javascript:;">--}}
                            {{--<b class="caret pull-right"></b>--}}
                            {{--<span>Site Config</span>--}}
                        {{--</a>--}}

                        {{--<ul class="sub-menu">--}}
                            {{--<li nav-id="modifier-manage-modifier"><a href="/backend/site_config">Edit Config</a></li>--}}

                        {{--</ul>--}}
                    {{--</li>--}}
                    <li nav-id="modifier-manage" class="has-sub">
                        <a href="javascript:;">
                            <b class="caret pull-right"></b>
                            <span>Nearby Category</span>
                        </a>

                        <ul class="sub-menu">
                            <li nav-id="modifier-manage-modifier"><a href="/backend/nearby_category/create">Entry</a></li>
                            <li nav-id="modifier-manage-modifierpanel"><a href="/backend/nearby_category">List</a></li>
                        </ul>
                    </li>
                    <li nav-id="modifier-create" class="has-sub">
                        <a href="javascript:;">
                            <b class="caret pull-right"></b>
                            <span>Hotel Nearby</span>
                        </a>

                        <ul class="sub-menu">
                            <li nav-id="modifier-create-modifier"><a href="/backend/hotel_nearby/create">Entry</a></li>
                            <li nav-id="modifier-create-modifierpanel"><a href="/backend/hotel_nearby">List</a></li>
                        </ul>
                    </li>
                    <li nav-id="modifier-create" class="has-sub">
                        <a href="javascript:;">
                            <b class="caret pull-right"></b>
                            <span>Facility Group</span>
                        </a>

                        <ul class="sub-menu">
                            <li nav-id="modifier-create-modifier"><a href="/backend/facility_group/create">Entry</a></li>
                            <li nav-id="modifier-create-modifierpanel"><a href="/backend/facility_group">List</a></li>
                        </ul>
                    </li>
                    <li nav-id="modifier-create" class="has-sub">
                        <a href="javascript:;">
                            <b class="caret pull-right"></b>
                            <span>Facilities</span>
                        </a>

                        <ul class="sub-menu">
                            <li nav-id="modifier-create-modifier"><a href="/backend/facilities/create">Entry</a></li>
                            <li nav-id="modifier-create-modifierpanel"><a href="/backend/facilities">List</a></li>
                        </ul>
                    </li>
                    <li nav-id="modifier-manage" class="has-sub">
                        <a href="javascript:;">
                            <b class="caret pull-right"></b>
                            <span>Features</span>
                        </a>

                        <ul class="sub-menu">
                            <li nav-id="modifier-manage-modifier"><a href="/backend/feature/create">Entry</a></li>
                            <li nav-id="modifier-manage-modifierpanel"><a href="/backend/feature">List</a></li>

                        </ul>
                    </li>
                    <li nav-id="modifier-create" class="has-sub">
                        <a href="javascript:;">
                            <b class="caret pull-right"></b>
                            <span>Amenities</span>
                        </a>

                        <ul class="sub-menu">
                            <li nav-id="modifier-create-modifier"><a href="/backend/amenities/create">Entry</a></li>
                            <li nav-id="modifier-create-modifierpanel"><a href="/backend/amenities">List</a></li>
                        </ul>
                    </li>

                    <li nav-id="modifier-create" class="has-sub">
                        <a href="javascript:;">
                            <b class="caret pull-right"></b>
                            <span>Landmark</span>
                        </a>

                        <ul class="sub-menu">
                            <li nav-id="modifier-create-modifier"><a href="/backend/landmark/create">Entry</a></li>
                            <li nav-id="modifier-create-modifierpanel"><a href="/backend/landmark">List</a></li>
                        </ul>
                    </li>

                    <li nav-id="modifier-manage" class="has-sub">
                        <a href="javascript:;">
                            <b class="caret pull-right"></b>
                            <span>Country</span>
                        </a>

                        <ul class="sub-menu">
                            <li nav-id="modifier-manage-modifier"><a href="/backend/country/create">Entry</a></li>
                            <li nav-id="modifier-manage-modifierpanel"><a href="/backend/country">List</a></li>
                        </ul>
                    </li>
                    <li nav-id="modifier-create" class="has-sub">
                        <a href="javascript:;">
                            <b class="caret pull-right"></b>
                            <span>City</span>
                        </a>

                        <ul class="sub-menu">
                            <li nav-id="modifier-create-modifier"><a href="/backend/city/create">Entry</a></li>
                            <li nav-id="modifier-create-modifierpanel"><a href="/backend/city">List</a></li>
                            <li nav-id="modifier-create-modifierpanel"><a href="/backend/popular_city/create">Set Popular City</a></li>
                        </ul>
                    </li>
                    <li nav-id="modifier-manage" class="has-sub">
                        <a href="javascript:;">
                            <b class="caret pull-right"></b>
                            <span>Township</span>
                        </a>

                        <ul class="sub-menu">
                            <li nav-id="modifier-manage-modifier"><a href="/backend/township/create">Entry</a></li>
                            <li nav-id="modifier-manage-modifierpanel"><a href="/backend/township">List</a></li>

                        </ul>
                    </li>

                    {{--<li nav-id="modifier-manage" class="has-sub">--}}
                        {{--<a href="javascript:;">--}}
                            {{--<b class="caret pull-right"></b>--}}
                            {{--<span>Transportation Information</span>--}}
                        {{--</a>--}}

                        {{--<ul class="sub-menu">--}}
                            {{--<li nav-id="modifier-manage-modifier"><a href="backend/transportation_information">Entry</a></li>--}}
                        {{--</ul>--}}
                    {{--</li>--}}

                    <li nav-id="">
                        <a href="/backend/transportation_information">
                            <b class="caret pull-right"></b>
                            <span>Transportation Information</span>
                        </a>
                    </li>

                    <li nav-id="">
                        <a href="/backend/tour_information">
                            <b class="caret pull-right"></b>
                            <span>Tour Guide Information</span>
                        </a>
                    </li>

                    {{--<li nav-id="modifier-manage" class="has-sub">--}}
                        {{--<a href="javascript:;">--}}
                            {{--<b class="caret pull-right"></b>--}}
                            {{--<span>Page</span>--}}
                        {{--</a>--}}

                        {{--<ul class="sub-menu">--}}
                            {{--<li nav-id="modifier-manage-modifierpanel"><a href="/backend/page">List</a></li>--}}
                        {{--</ul>--}}
                    {{--</li>--}}
                </ul>
            </li>

            <li  nav-id='modifier'  class="has-sub">
                <a href="javascript:;">
                    <b class="caret pull-right"></b>
                    <i class="fa fa-users"></i>
                    <span>Hotel Management</span>
                </a>
                <ul class="sub-menu">
                    <li nav-id="modifier-create" class="has-sub">
                        <a href="javascript:;">
                            <b class="caret pull-right"></b>
                            <span>Hotel</span>
                        </a>

                        <ul class="sub-menu">
                            <li nav-id="modifier-create-modifier"><a href="/backend/hotel/create">Entry</a></li>
                            <li nav-id="modifier-create-modifierpanel"><a href="/backend/hotel">List</a></li>
                            <li nav-id="modifier-create-modifierpanel"><a href="/backend/recommend_hotel/create">Set Recommend Hotel</a></li>
                        </ul>
                    </li>
                  {{--  <li nav-id="modifier-create" class="has-sub">
                        <a href="javascript:;">
                            <b class="caret pull-right"></b>
                            <span>Hotel Config</span>
                        </a>

                        <ul class="sub-menu">
                            <li nav-id="modifier-create-modifier"><a href="/backend/hotel_config/create">Entry</a></li>
                            <li nav-id="modifier-create-modifierpanel"><a href="/backend/hotel_config">List</a></li>
                        </ul>
                    </li>
                    <li nav-id="modifier-create" class="has-sub">
                        <a href="javascript:;">
                            <b class="caret pull-right"></b>
                            <span>Hotel Landmark</span>
                        </a>

                        <ul class="sub-menu">
                            <li nav-id="modifier-create-modifier"><a href="/backend/hotel_landmark/create">Entry</a></li>
                            <li nav-id="modifier-create-modifierpanel"><a href="/backend/hotel_landmark">List</a></li>
                        </ul>
                    </li>
                    <li nav-id="modifier-create" class="has-sub">
                        <a href="javascript:;">
                            <b class="caret pull-right"></b>
                            <span>Hotel Feature</span>
                        </a>

                        <ul class="sub-menu">
                            <li nav-id="modifier-create-modifier"><a href="/backend/hotel_feature/create">Entry</a></li>
                            <li nav-id="modifier-create-modifierpanel"><a href="/backend/hotel_feature">List</a></li>
                        </ul>
                    </li>

                    <li nav-id="modifier-create" class="has-sub">
                        <a href="javascript:;">
                            <b class="caret pull-right"></b>
                            <span>Hotel Facility</span>
                        </a>

                        <ul class="sub-menu">
                            <li nav-id="modifier-create-modifier"><a href="/backend/hotel_facility/create">Entry</a></li>
                            <li nav-id="modifier-create-modifierpanel"><a href="/backend/hotel_facility">List</a></li>
                        </ul>
                    </li>--}}
                    <li nav-id="modifier-create" class="has-sub">
                        <a href="javascript:;">
                            <b class="caret pull-right"></b>
                            <span>Hotel Restaurant Category</span>
                        </a>

                        <ul class="sub-menu">
                            <li nav-id="modifier-create-modifier"><a href="/backend/hotel_restaurant_category/create">Entry</a></li>
                            <li nav-id="modifier-create-modifierpanel"><a href="/backend/hotel_restaurant_category">List</a></li>
                        </ul>
                    </li>
                    <li nav-id="modifier-create" class="has-sub">
                        <a href="javascript:;">
                            <b class="caret pull-right"></b>
                            <span>Hotel Restaurant</span>
                        </a>

                        <ul class="sub-menu">
                            <li nav-id="modifier-create-modifier"><a href="/backend/hotel_restaurant/create">Entry</a></li>
                            <li nav-id="modifier-create-modifierpanel"><a href="/backend/hotel_restaurant">List</a></li>
                        </ul>
                    </li>
                </ul>
            </li>

            @endif

            <li  nav-id='modifier'  class="has-sub">
                <a href="javascript:;">
                    <b class="caret pull-right"></b>
                    <i class="fa fa-users"></i>
                    <span>Room Management</span>
                </a>
                <ul class="sub-menu">
                    <li nav-id="modifier-create" class="has-sub">
                        <a href="javascript:;">
                            <b class="caret pull-right"></b>
                            <span>Room Type</span>
                        </a>

                        <ul class="sub-menu">
                            <li nav-id="modifier-create-modifier"><a href="/backend/hotel_room_type/create">Entry</a></li>
                            <li nav-id="modifier-create-modifierpanel"><a href="/backend/hotel_room_type">List</a></li>
                        </ul>
                    </li>
                    <li nav-id="modifier-create" class="has-sub">
                        <a href="javascript:;">
                            <b class="caret pull-right"></b>
                            <span>Hotel Room Category</span>
                        </a>

                        <ul class="sub-menu">
                            {{--<li nav-id="modifier-create-modifier"><a href="/backend/hotel_room_category/create">Entry</a></li>--}}
                            <li nav-id="modifier-create-modifierpanel"><a href="/backend/hotel_room_category">List</a></li>
                        </ul>
                    </li>

                    <li nav-id="modifier-create" class="has-sub">
                        <a href="javascript:;">
                            <b class="caret pull-right"></b>
                            <span>Room</span>
                        </a>

                        <ul class="sub-menu">
                            <li nav-id="modifier-create-modifier"><a href="/backend/room/create">Entry</a></li>
                            <li nav-id="modifier-create-modifierpanel"><a href="/backend/room">List</a></li>
                        </ul>
                    </li>

                    @if (Auth::guard('User')->user()->role_id == 1)
                    {{--<li nav-id="modifier-create" class="has-sub">
                        <a href="javascript:;">
                            <b class="caret pull-right"></b>
                            <span>Room Category Facilities</span>
                        </a>

                        <ul class="sub-menu">
                            <li nav-id="modifier-create-modifier"><a href="/backend/room_category_facility/create">Entry</a></li>
                            <li nav-id="modifier-create-modifierpanel"><a href="/backend/room_category_facility">List</a></li>
                        </ul>
                    </li>
                    <li nav-id="modifier-create" class="has-sub">
                        <a href="javascript:;">
                            <b class="caret pull-right"></b>
                            <span>Room Category Amenities</span>
                        </a>

                        <ul class="sub-menu">
                            <li nav-id="modifier-create-modifier"><a href="/backend/room_category_amenity/create">Entry</a></li>
                            <li nav-id="modifier-create-modifierpanel"><a href="/backend/room_category_amenity">List</a></li>
                        </ul>
                    </li>--}}
                    <li nav-id="modifier-create" class="has-sub">
                        <a href="javascript:;">
                            <b class="caret pull-right"></b>
                            <span>Room Discount</span>
                        </a>

                        <ul class="sub-menu">
                            <li nav-id="modifier-create-modifier"><a href="/backend/room_discount/create">Entry</a></li>
                            <li nav-id="modifier-create-modifierpanel"><a href="/backend/room_discount">List</a></li>
                        </ul>
                    </li>
                    <li nav-id="modifier-create" class="has-sub">
                        <a href="javascript:;">
                            <b class="caret pull-right"></b>
                            <span>Room View</span>
                        </a>

                        <ul class="sub-menu">
                            <li nav-id="modifier-create-modifier"><a href="/backend/room_view/create">Entry</a></li>
                            <li nav-id="modifier-create-modifierpanel"><a href="/backend/room_view">List</a></li>
                        </ul>
                    </li>
                    @endif
                </ul>
            </li>

            <li  nav-id='modifier'  class="has-sub">
                <a href="javascript:;">
                    <b class="caret pull-right"></b>
                    <i class="fa fa-users"></i>
                    <span>Booking Management</span>
                </a>
                <ul class="sub-menu">
                    <li nav-id="modifier-create" class="has-sub">
                        <a href="javascript:;">
                            <b class="caret pull-right"></b>
                            <span>Booking</span>
                        </a>

                        <ul class="sub-menu">
                            <li nav-id="modifier-create-modifierpanel"><a href="/backend/booking">List</a></li>
                        </ul>
                    </li>

                    <li nav-id="modifier-create" class="has-sub">
                        <a href="javascript:;">
                            <b class="caret pull-right"></b>
                            <span>Communication</span>
                        </a>

                        <ul class="sub-menu">
                            <li nav-id="modifier-create-modifierpanel"><a href="/backend/communication">List</a></li>
                        </ul>
                    </li>
                </ul>
            </li>

            @if (Auth::guard('User')->user()->role_id == 1)
            {{--<li  nav-id='modifier' class="has-sub">--}}
                {{--<a href="javascript:;">--}}
                    {{--<b class="caret pull-right"></b>--}}
                    {{--<i class="fa fa-users"></i>--}}
                    {{--<span>Room Management</span>--}}
                {{--</a>--}}
                {{--<ul class="sub-menu">--}}
                    {{--<li nav-id="modifier-create" class="has-sub">--}}
                        {{--<a href="javascript:;">--}}
                            {{--<b class="caret pull-right"></b>--}}
                            {{--<span>Room Type</span>--}}
                        {{--</a>--}}

                        {{--<ul class="sub-menu">--}}
                            {{--<li nav-id="modifier-create-modifier"><a href="/backend/hotel_room_type/create">Entry</a></li>--}}
                            {{--<li nav-id="modifier-create-modifierpanel"><a href="/backend/hotel_room_type">List</a></li>--}}
                        {{--</ul>--}}
                    {{--</li>--}}
                    {{--<li nav-id="modifier-create" class="has-sub">--}}
                        {{--<a href="javascript:;">--}}
                            {{--<b class="caret pull-right"></b>--}}
                            {{--<span>Hotel Room Category</span>--}}
                        {{--</a>--}}

                        {{--<ul class="sub-menu">--}}
                            {{--<li nav-id="modifier-create-modifier"><a href="/backend/hotel_room_category/create">Entry</a></li>--}}
                            {{--<li nav-id="modifier-create-modifierpanel"><a href="/backend/hotel_room_category">List</a></li>--}}
                        {{--</ul>--}}
                    {{--</li>--}}

                    {{--<li nav-id="modifier-create" class="has-sub">--}}
                        {{--<a href="javascript:;">--}}
                            {{--<b class="caret pull-right"></b>--}}
                            {{--<span>Room</span>--}}
                        {{--</a>--}}

                        {{--<ul class="sub-menu">--}}
                            {{--<li nav-id="modifier-create-modifier"><a href="/backend/room/create">Entry</a></li>--}}
                            {{--<li nav-id="modifier-create-modifierpanel"><a href="/backend/room">List</a></li>--}}
                        {{--</ul>--}}
                    {{--</li>--}}

                    {{--@if (Auth::guard('User')->user()->role_id == 1)--}}
                    {{--<li nav-id="modifier-create" class="has-sub">--}}
                        {{--<a href="javascript:;">--}}
                            {{--<b class="caret pull-right"></b>--}}
                            {{--<span>Room Category Facilities</span>--}}
                        {{--</a>--}}

                        {{--<ul class="sub-menu">--}}
                            {{--<li nav-id="modifier-create-modifier"><a href="/backend/room_category_facility/create">Entry</a></li>--}}
                            {{--<li nav-id="modifier-create-modifierpanel"><a href="/backend/room_category_facility">List</a></li>--}}
                        {{--</ul>--}}
                    {{--</li>--}}
                    {{--<li nav-id="modifier-create" class="has-sub">--}}
                        {{--<a href="javascript:;">--}}
                            {{--<b class="caret pull-right"></b>--}}
                            {{--<span>Room Category Amenities</span>--}}
                        {{--</a>--}}

                        {{--<ul class="sub-menu">--}}
                            {{--<li nav-id="modifier-create-modifier"><a href="/backend/room_category_amenity/create">Entry</a></li>--}}
                            {{--<li nav-id="modifier-create-modifierpanel"><a href="/backend/room_category_amenity">List</a></li>--}}
                        {{--</ul>--}}
                    {{--</li>--}}
                    {{--<li nav-id="modifier-create" class="has-sub">--}}
                        {{--<a href="javascript:;">--}}
                            {{--<b class="caret pull-right"></b>--}}
                            {{--<span>Room Discount</span>--}}
                        {{--</a>--}}

                        {{--<ul class="sub-menu">--}}
                            {{--<li nav-id="modifier-create-modifier"><a href="/backend/room_discount/create">Entry</a></li>--}}
                            {{--<li nav-id="modifier-create-modifierpanel"><a href="/backend/room_discount">List</a></li>--}}
                        {{--</ul>--}}
                    {{--</li>--}}
                    {{--@endif--}}
                {{--</ul>--}}
            {{--</li>--}}

            <li nav-id="modifier-create" class="has-sub">
                <a href="javascript:;">
                    <b class="caret pull-right"></b>
                    <i class="fa fa-users"></i>
                    <span>Room Availability Management</span>
                </a>
                <ul class="sub-menu">

                    <li nav-id="modifier-create" class="has-sub">
                        <a href="javascript:;">
                            <b class="caret pull-right"></b>
                            <span>Room Available Period</span>
                        </a>

                        <ul class="sub-menu">
                            <li nav-id="modifier-create-modifier"><a href="/backend/room_available_period/create">Entry</a></li>
                            <li nav-id="modifier-create-modifierpanel"><a href="/backend/room_available_period">List</a></li>
                        </ul>
                    </li>
                    <li nav-id="modifier-create" class="has-sub">
                        <a href="javascript:;">
                            <b class="caret pull-right"></b>
                            <span>Room Blackout Period</span>
                        </a>

                        <ul class="sub-menu">
                            <li nav-id="modifier-create-modifier"><a href="/backend/room_blackout_period/create">Entry</a></li>
                            <li nav-id="modifier-create-modifierpanel"><a href="/backend/room_blackout_period">List</a></li>
                        </ul>
                    </li>
                </ul>
            </li>

            <li nav-id="modifier-create" class="has-sub">
                <a href="javascript:;">
                    <b class="caret pull-right"></b>
                    <i class="fa fa-calendar"></i>
                    <span>{{trans('menu.group-import')}}</span>
                </a>
                <ul class="sub-menu">

                    <li nav-id="modifier-create" class="has-sub">
                        <li nav-id="modifier-create-modifier"><a href="/backend/import">CSV Import</a></li>
                    </li>
                </ul>
            </li>

            <li  nav-id='modifier'  class="has-sub">
                <a href="javascript:;">
                    <b class="caret pull-right"></b>
                    <i class="fa fa-users"></i>
                    <span>Slider Management</span>
                </a>
                <ul class="sub-menu">
                    <li nav-id="modifier-manage" class="has-sub">
                        <a href="javascript:;">
                            <b class="caret pull-right"></b>
                            <span>Slider</span>
                        </a>

                        <ul class="sub-menu">
                            <li nav-id="modifier-manage-modifier"><a href="/backend/slider/create">Entry</a></li>
                            <li nav-id="modifier-manage-modifierpanel"><a href="/backend/slider">List</a></li>
                        </ul>
                    </li>

                </ul>
            </li>

            <li nav-id='report'  class="has-sub" >
                <a href="javascript:;">
                    <b class="caret pull-right"></b>
                    <i class="fa fa-calendar"></i>
                    <span>{{trans('menu.group-report')}}</span>
                </a>

                <ul class="sub-menu">
                    <li nav-id="report-sale-summary"><a href="/backend/salesummaryreport">Sale Summary Report</a></li>
                    <li nav-id="report-booking-summary"><a href="/backend/bookingreport">Booking Detail Report</a></li>

                </ul>
            </li>

            <li  nav-id='modifier'  class="has-sub">
                <a href="javascript:;">
                    <b class="caret pull-right"></b>
                    <i class="fa fa-users"></i>
                    <span>{{trans('menu.group-setup')}}</span>
                </a>
                <ul class="sub-menu">
                    <li nav-id="modifier-manage" class="has-sub">
                        <a href="javascript:;">
                            <b class="caret pull-right"></b>
                            <span>Role</span>
                        </a>

                        <ul class="sub-menu">
                            <li nav-id="modifier-manage-modifier"><a href="/backend/role/create">Entry</a></li>
                            <li nav-id="modifier-manage-modifierpanel"><a href="/backend/role">List</a></li>
                        </ul>
                    </li>
                    <li nav-id="modifier-manage" class="has-sub">
                        <a href="javascript:;">
                            <b class="caret pull-right"></b>
                            <span>Permission</span>
                        </a>

                        <ul class="sub-menu">
                            <li nav-id="modifier-manage-modifier"><a href="/backend/permission/create">Entry</a></li>
                            <li nav-id="modifier-manage-modifierpanel"><a href="/backend/permission">List</a></li>

                        </ul>
                    </li>
                    <li nav-id="modifier-create" class="has-sub">
                        <a href="javascript:;">
                            <b class="caret pull-right"></b>
                            <span>Staff</span>
                        </a>

                        <ul class="sub-menu">
                            <li nav-id="modifier-create-modifier"><a href="/backend/user/create">Entry</a></li>
                            <li nav-id="modifier-create-modifierpanel"><a href="/backend/user">List</a></li>
                        </ul>
                    </li>
                    <li nav-id="">
                        <a href="/backend/config">
                            <b class="caret pull-right"></b>
                            <span>Site Config</span>
                        </a>
                    </li>

                </ul>

            </li>

            <li  nav-id='modifier'  class="has-sub">
                <a href="javascript:;">
                    <b class="caret pull-right"></b>
                    <i class="fa fa-users"></i>
                    <span>Email Management</span>
                </a>
                <ul class="sub-menu">
                    <li nav-id="modifier-manage" class="has-sub">
                        <a href="javascript:;">
                            <b class="caret pull-right"></b>
                            <span>Event Email</span>
                        </a>

                        <ul class="sub-menu">
                            <li nav-id="modifier-manage-modifier"><a href="/backend/eventemail/create">Entry</a></li>
                            <li nav-id="modifier-manage-modifierpanel"><a href="/backend/eventemail">List</a></li>
                        </ul>
                    </li>

                    <li nav-id="modifier-manage" class="has-sub">
                        <a href="javascript:;">
                            <b class="caret pull-right"></b>
                            <span>Event Text</span>
                        </a>

                        <ul class="sub-menu">
                            <li nav-id="modifier-manage-modifier"><a href="/backend/email_template_booking_confirm">Email Booking Confirm</a></li>
                            <li nav-id="modifier-manage-modifier"><a href="/backend/email_template_booking_cancel">Email Booking Cancel</a></li>
                            <li nav-id="modifier-manage-modifier"><a href="/backend/email_template_booking_edit">Email Booking Edit</a></li>
                        </ul>
                    </li>
                </ul>
            </li>

            <li  nav-id='modifier'  class="has-sub">
                <a href="javascript:;">
                    <b class="caret pull-right"></b>
                    <i class="fa fa-gears"></i>
                    <span>{{trans('menu.group-developer')}}</span>
                </a>
                <ul class="sub-menu">
                    <li nav-id="modifier-manage" class="has-sub">
                        <a href="javascript:;">
                            <b class="caret pull-right"></b>
                            <span>Reference</span>
                        </a>

                        <ul class="sub-menu">
                            <li nav-id="systemreference"><a href="/backend/systemreference">System Reference</a></li>
                        </ul>
                    </li>

                    <li nav-id="modifier-manage" class="has-sub">
                        <a href="javascript:;">
                            <b class="caret pull-right"></b>
                            <span>Samples</span>
                        </a>

                        <ul class="sub-menu">
                            <li nav-id="samples_googlemap"><a href="/samples/googlemap">Google Map Sample</a></li>
                        </ul>
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