<?php
$role_id = Auth::guard('User')->user()->role_id;
$permissions = \App\Core\Check::getPermissionByRoleId($role_id);
// print_r($permissions[0]);
?>

<!-- begin #sidebar -->
<div id="sidebar" class="sidebar">
    <!-- begin sidebar scrollbar -->
    <div data-scrollbar="true" data-height="100%">
        <!-- begin sidebar nav -->
        <ul class="nav">
            <!-- begin sidebar minify button -->
            <li><a href="javascript:;" class="sidebar-minify-btn" data-click="sidebar-minify"><i class="fa fa-angle-double-left"></i></a></li>
            <!-- end sidebar minify button -->

            <!--Only Admin and Super Admin Access -->
            @if((in_array("backend_mps/nearby_category", $permissions)) ||
            (in_array("backend_mps/hotel_nearby", $permissions)) ||
            (in_array("backend_mps/facility_group", $permissions)) ||
            (in_array("backend_mps/facilities", $permissions)) ||
            (in_array("backend_mps/feature", $permissions)) ||
            (in_array("backend_mps/amenities", $permissions)) ||
            (in_array("backend_mps/landmark", $permissions)) ||
            (in_array("backend_mps/country", $permissions)) ||
            (in_array("backend_mps/city", $permissions)) ||
            (in_array("backend_mps/popular_city/create", $permissions)) ||
            (in_array("backend_mps/township", $permissions)) ||
            (in_array("backend_mps/transportation_information", $permissions)) ||
            (in_array("backend_mps/visa_information", $permissions)) ||
            (in_array("backend_mps/tour_information", $permissions)) ||
            (in_array("backend_mps/faq_information", $permissions))
            )
            <li  nav-id='modifier'  class="has-sub">
                <a href="javascript:;">
                    <b class="caret pull-right"></b>
                    <i class="fa fa-sitemap"></i>
                    <span>General</span>
                </a>
                <ul class="sub-menu">
                    @if(in_array("backend_mps/nearby_category", $permissions))
                    <li nav-id="modifier-manage" class="has-sub">
                        <a href="/backend_mps/nearby_category">Nearby Category</a>
                    </li>
                    @endif

                    @if(in_array("backend_mps/hotel_nearby", $permissions))
                    <li nav-id="modifier-create" class="has-sub">
                        <a href="/backend_mps/hotel_nearby">Hotel Nearby</a>
                    </li>
                    @endif

                    @if(in_array("backend_mps/facility_group", $permissions))
                    <li nav-id="modifier-create" class="has-sub">
                        <a href="/backend_mps/facility_group">Facility Group</a>
                    </li>
                    @endif

                    @if(in_array("backend_mps/facilities", $permissions))
                    <li nav-id="modifier-create" class="has-sub">
                        <a href="/backend_mps/facilities">Facilities</a>
                    </li>
                    @endif

                    @if(in_array("backend_mps/feature", $permissions))
                    <li nav-id="modifier-manage" class="has-sub">
                        <a href="/backend_mps/feature">Features</a>
                    </li>
                    @endif

                    @if(in_array("backend_mps/amenities", $permissions))
                    <li nav-id="modifier-create" class="has-sub">
                        <a href="/backend_mps/amenities">Amenities</a>
                    </li>
                    @endif

                    @if(in_array("backend_mps/landmark", $permissions))
                    <li nav-id="modifier-create" class="has-sub">
                        <a href="/backend_mps/landmark">Landmark</a>
                    </li>
                    @endif

                    @if(in_array("backend_mps/country", $permissions))
                    <li nav-id="modifier-manage" class="has-sub">
                        <a href="/backend_mps/country">Country</a>
                    </li>
                    @endif

                    <li nav-id="modifier-create" class="has-sub">
                        <a href="javascript:;">
                            <b class="caret pull-right"></b>
                            <span>City</span>
                        </a>

                        <ul class="sub-menu">
                            @if(in_array("backend_mps/city", $permissions))
                            <li nav-id="modifier-create-modifierpanel"><a href="/backend_mps/city">City</a></li>
                            @endif

                            @if(in_array("backend_mps/popular_city/create", $permissions))
                            <li nav-id="modifier-create-modifierpanel"><a href="/backend_mps/popular_city/create">Set Popular City</a></li>
                            @endif
                        </ul>
                    </li>

                    @if(in_array("backend_mps/township", $permissions))
                    <li nav-id="modifier-manage" class="has-sub">
                        <a href="/backend_mps/township">Township</a>
                    </li>
                    @endif

                    @if(in_array("backend_mps/transportation_information", $permissions))
                    <li nav-id="">
                        <a href="/backend_mps/transportation_information">
                            <span>Transportation Information</span>
                        </a>
                    </li>
                    @endif

                    @if(in_array("backend_mps/tour_information", $permissions))
                    <li nav-id="">
                        <a href="/backend_mps/tour_information">
                            <span>Tour Guide Information</span>
                        </a>
                    </li>
                    @endif

                    @if(in_array("backend_mps/visa_information", $permissions))
                    <li nav-id="">
                        <a href="/backend_mps/visa_information">
                            <span>VISA Information</span>
                        </a>
                    </li>
                    @endif

                     @if(in_array("backend_mps/faq_information", $permissions))
                    <li nav-id="">
                        <a href="/backend_mps/faq_information">
                            <span>FAQ Information</span>
                        </a>
                    </li>
                    @endif
                </ul>
            </li>
            @endif

            @if((in_array("backend_mps/hotel", $permissions)) || (in_array("backend_mps/recommend_hotel/create", $permissions)) || (in_array("backend_mps/hotel_restaurant_category", $permissions)) || (in_array("backend_mps/hotel_restaurant", $permissions)) || (in_array("backend_mps/hotel_gallery", $permissions)) || (in_array("backend_mps/hotel_policy", $permissions)))
            <li  nav-id='modifier'  class="has-sub">
                <a href="javascript:;">
                    <b class="caret pull-right"></b>
                    <i class="fa fa-university"></i>
                    <span>Hotel Management</span>
                </a>
                <ul class="sub-menu">
                    @if(in_array("backend_mps/hotel", $permissions))
                    <li nav-id="modifier-create" class="has-sub">
                        <a href="/backend_mps/hotel">Hotel</a>
                    </li>
                    @endif

                    @if(in_array("backend_mps/recommend_hotel/create", $permissions))
                    <li nav-id="modifier-create" class="has-sub">
                        <a href="/backend_mps/recommend_hotel/create">Set Recommend Hotel</a>
                    </li>
                    @endif

                    @if(in_array("backend_mps/hotel_restaurant_category", $permissions))
                    <li nav-id="modifier-create" class="has-sub">
                        <a href="/backend_mps/hotel_restaurant_category">Hotel Restaurant Category</a>
                    </li>
                    @endif

                    @if(in_array("backend_mps/hotel_restaurant", $permissions))
                    <li nav-id="modifier-create" class="has-sub">
                        <a href="/backend_mps/hotel_restaurant">Hotel Restaurant</a>
                    </li>
                    @endif

                     <!-- Hotel Gallery -->
                     @if(in_array("backend_mps/hotel_gallery", $permissions))
                     <li nav-id="modifier-create" class="has-sub">
                        <a href="/backend_mps/hotel_gallery">Hotel Gallery</a>
                    </li>
                    @endif

                     <!-- Hotel Policy -->
                     @if(in_array("backend_mps/hotel_policy", $permissions))
                     <li nav-id="modifier-create" class="has-sub">
                        <a href="/backend_mps/hotel_policy">Hotel Policy</a>
                    </li>
                    @endif

                     <!-- Disabled Hotels -->
                     <!-- @if(in_array("backend_mps/hotel/disabled_hotels", $permissions))
                     <li nav-id="modifier-create" class="has-sub">
                        <a href="/backend_mps/hotel/disabled_hotels">Disabled Hotels</a>
                    </li>
                    @endif -->
                </ul>
            </li>
            @endif

            @if((in_array("backend_mps/hotel_room_type", $permissions)) || (in_array("backend_mps/hotel_room_category", $permissions)) || (in_array("backend_mps/room_view", $permissions)) || (in_array("backend_mps/room", $permissions)) || (in_array("backend_mps/room_discount", $permissions)))
            <li  nav-id='modifier'  class="has-sub">
                <a href="javascript:;">
                    <b class="caret pull-right"></b>
                    <i class="fa fa-key"></i>
                    <span>Room Management</span>
                </a>
                <ul class="sub-menu">
                    @if(in_array("backend_mps/hotel_room_type", $permissions))
                    <li nav-id="modifier-create">
                        <a href="/backend_mps/hotel_room_type">Building Type</a>
                    </li>
                    @endif

                    @if(in_array("backend_mps/hotel_room_category", $permissions))
                    <li nav-id="modifier-create" class="has-sub">
                        <a href="/backend_mps/hotel_room_category">Hotel Room Category</a>
                    </li>
                    @endif

                    @if(in_array("backend_mps/room_view", $permissions))
                    <li nav-id="modifier-create" class="has-sub">
                        <a href="/backend_mps/room_view">Room View</a>
                    </li>
                    @endif

                    @if(in_array("backend_mps/room", $permissions))
                    <li nav-id="modifier-create" class="has-sub">
                        <a href="/backend_mps/room">Room</a>
                    </li>
                    @endif

                    @if(in_array("backend_mps/room_discount", $permissions))
                    <li nav-id="modifier-create" class="has-sub">
                        <a href="/backend_mps/room_discount">Room Discount</a>
                    </li>
                    @endif
                </ul>
            </li>
            @endif

            @if((in_array("backend_mps/booking", $permissions)) || (in_array("backend_mps/communication", $permissions)))
            <li  nav-id='modifier'  class="has-sub">
                <a href="javascript:;">
                    <b class="caret pull-right"></b>
                    <i class="fa fa-phone"></i>
                    <span>Booking Management</span>
                </a>
                <ul class="sub-menu">
                    @if(in_array("backend_mps/booking", $permissions))
                    <li nav-id="modifier-create" class="has-sub">
                        <a href="/backend_mps/booking">Booking</a>
                    </li>
                    @endif

                    @if(in_array("backend_mps/communication", $permissions))
                    <li nav-id="modifier-create" class="has-sub">
                        <a href="/backend_mps/communication">Communication</a>
                    </li>
                    @endif
                </ul>
            </li>
            @endif

            @if((in_array("backend_mps/room_available_period", $permissions)) || (in_array("backend_mps/room_blackout_period", $permissions)))
            <li nav-id="modifier-create" class="has-sub">
                <a href="javascript:;">
                    <b class="caret pull-right"></b>
                    <i class="fa fa-key"></i>
                    <span>Room Availability Management</span>
                </a>
                <ul class="sub-menu">
                    @if(in_array("backend_mps/room_available_period", $permissions))
                    <li nav-id="modifier-create" class="has-sub">
                        <a href="/backend_mps/room_available_period">Room Available Period</a>
                    </li>
                    @endif

                    @if(in_array("backend_mps/room_blackout_period", $permissions))
                    <li nav-id="modifier-create" class="has-sub">
                        <a href="/backend_mps/room_blackout_period">Room Blackout Period</a>
                    </li>
                    @endif
                </ul>
            </li>
            @endif

            @if(in_array("backend_mps/import", $permissions))
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

            @if(in_array("backend_mps/slider", $permissions))
            <li  nav-id='modifier'  class="has-sub">
                <a href="javascript:;">
                    <b class="caret pull-right"></b>
                    <i class="fa fa-file-image-o"></i>
                    <span>Slider Management</span>
                </a>
                <ul class="sub-menu">
                    <li nav-id="modifier-manage" class="has-sub">
                        <a href="/backend_mps/slider">Slider</a>
                    </li>

                </ul>
            </li>
            @endif

            @if((in_array("backend_mps/salesummaryreport", $permissions)) || (in_array("backend_mps/bookingreport", $permissions)))
            <li nav-id='report'  class="has-sub" >
                <a href="javascript:;">
                    <b class="caret pull-right"></b>
                    <i class="fa fa-line-chart"></i>
                    <span>{{trans('menu.group-report')}}</span>
                </a>

                <ul class="sub-menu">
                    @if(in_array("backend_mps/salesummaryreport", $permissions))
                    <li nav-id="report-sale-summary"><a href="/backend_mps/salesummaryreport">Sale Summary Report</a></li>
                    @endif

                    @if(in_array("backend_mps/bookingreport", $permissions))
                    <li nav-id="report-booking-summary"><a href="/backend_mps/bookingreport">Booking Detail Report</a></li>
                    @endif
                </ul>
            </li>
            @endif

            @if((in_array("backend_mps/role", $permissions)) || (in_array("backend_mps/permission", $permissions)) || (in_array("backend_mps/user", $permissions)) || (in_array("backend_mps/config", $permissions)) || (in_array("backend_mps/activities", $permissions)))
            <li  nav-id='modifier'  class="has-sub">
                <a href="javascript:;">
                    <b class="caret pull-right"></b>
                    <i class="fa fa-cog"></i>
                    <span>{{trans('menu.group-setup')}}</span>
                </a>
                <ul class="sub-menu">
                    @if(in_array("backend_mps/role", $permissions))
                    <li nav-id="modifier-manage" class="has-sub">
                        <a href="/backend_mps/role">Role</a>
                    </li>
                    @endif

                    @if(in_array("backend_mps/permission", $permissions))
                    <li nav-id="modifier-manage" class="has-sub">
                        <a href="/backend_mps/permission">Permission</a>
                    </li>
                    @endif

                    @if(in_array("backend_mps/user", $permissions))
                    <li nav-id="modifier-create" class="has-sub">
                        <a href="/backend_mps/user">User</a>
                    </li>
                    @endif

                    @if(in_array("backend_mps/config", $permissions))
                    <li nav-id="modifier-creat" class="has-sub">
                        <a href="/backend_mps/config">
                            <span>Site Config</span>
                        </a>
                    </li>
                    @endif

                    @if(in_array("backend_mps/activities", $permissions))
                    <li nav-id="modifier-creat" class="has-sub">
                        <a href="/backend_mps/activities">
                            <span>Activity Log</span>
                        </a>
                    </li>
                    @endif
                </ul>

            </li>
            @endif

            @if((in_array("backend_mps/eventemail", $permissions)) || (in_array("backend_mps/email_template_booking_confirm", $permissions)) || (in_array("backend_mps/email_template_booking_cancel", $permissions)) || (in_array("backend_mps/email_template_booking_edit", $permissions)))
            <li  nav-id='modifier' class="has-sub">
                <a href="javascript:;">
                    <b class="caret pull-right"></b>
                    <i class="fa fa-envelope"></i>
                    <span>Email Management</span>
                </a>
                <ul class="sub-menu">
                    @if(in_array("backend_mps/eventemail", $permissions))
                    <li nav-id="modifier-manage" class="has-sub">
                        <a href="/backend_mps/eventemail">Event Email</a>
                    </li>
                    @endif

                    <li nav-id="modifier-manage" class="has-sub">
                        <a href="javascript:;">
                            <b class="caret pull-right"></b>
                            <span>Event Text</span>
                        </a>

                        <ul class="sub-menu">
                            @if(in_array("backend_mps/email_template_booking_confirm", $permissions))
                            <li nav-id="modifier-manage-modifier"><a href="/backend_mps/email_template_booking_confirm">Email Booking Confirm</a></li>
                            @endif

                            @if(in_array("backend_mps/email_template_booking_cancel", $permissions))
                            <li nav-id="modifier-manage-modifier"><a href="/backend_mps/email_template_booking_cancel">Email Booking Cancel</a></li>
                            @endif

                            @if(in_array("backend_mps/email_template_booking_edit", $permissions))
                            <li nav-id="modifier-manage-modifier"><a href="/backend_mps/email_template_booking_edit">Email Booking Edit</a></li>
                            @endif
                        </ul>
                    </li>
                </ul>
            </li>
            @endif

            @if(Auth::guard('User')->user()->role_id == 1)
            <li  nav-id='modifier' class="has-sub">
                <a href="javascript:;">
                    <b class="caret pull-right"></b>
                    <i class="fa fa-gears"></i>
                    <span>{{trans('menu.group-developer')}}</span>
                </a>
                <ul class="sub-menu">
                    <li nav-id="modifier-manage" class="has-sub">
                        <a href="/backend_mps/systemreference">System Reference</a>
                    </li>

                    <li nav-id="modifier-manage" class="has-sub">
                        <a href="/samples/googlemap">Google Map Sample</a>
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
        var submenu = '.sub-menu li';
        var hassub = '.has-sub';

        $(hassub).removeClass('active');
        $(submenu).removeClass('active');

        $(".sub-menu li a").each(function () {
            var href = $(this).attr('href');
            var child_href = href+'/';
            //check for child hrefs also (eg. room and room/create)
            if (path === href || path.includes(child_href)) {
            // if (path.includes(href)) {
                $(this).closest('li').addClass('active');
                $(this).closest('.has-sub').addClass('active');
                $(this).parents(".has-sub:eq(1)").toggleClass("active");
            }
        });
    });
</script>
