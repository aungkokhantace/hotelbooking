@extends('layouts.master')
@section('title','Hotel Booking')
@section('content')

        <!-- begin #content -->
<div id="content" class="content">

    <h1 class="page-header">{{trans('setup_booking.title-list')}}</h1>

    <div class="row">
        <div class="col-lg-7 col-md-7 col-sm-7 col-xs-7">
            <div class="listing">
                <table class="table table-striped list-table" id="list-table">
                    <thead>
                    <tr>
                        <th>{{trans('setup_booking.tb-col-name')}}</th>
                        <th>{{trans('setup_booking.tb-col-description')}}</th>
                    </tr>
                    </thead>

                    <tbody>
                        <tr>
                            <td width="30%">{{trans('setup_booking.tb-col-booking-number')}}</td>
                            <td>{{ $booking->booking_no}}</td>
                        </tr>

                        <tr>
                            <td>{{trans('setup_booking.tb-col-username')}}</td>
                            <td>{{ $booking->user->display_name}}</td>
                        </tr>

                        <tr>
                            <td>{{trans('setup_booking.tb-col-check-in-date')}}</td>
                            <td>{{ $booking->check_in_date}}</td>
                        </tr>

                        <tr>
                            <td>{{trans('setup_booking.tb-col-check-out-date')}}</td>
                            <td>{{ $booking->check_out_date}}</td>
                        </tr>

                        <tr>
                            <td>{{trans('setup_booking.tb-col-check-in-time')}}</td>
                            <td>{{ $booking->check_in_time}}</td>
                        </tr>

                        <tr>
                            <td>{{trans('setup_booking.tb-col-check-out-time')}}</td>
                            <td>{{ $booking->check_out_time}}</td>
                        </tr>

                        <tr>
                            <td>{{trans('setup_booking.tb-col-for-other')}}</td>
                            <td>
                                @if($booking->for_other == 0)
                                    {{ 'No'}}
                                @else
                                    {{ 'Yes'}}
                                @endif
                            </td>
                        </tr>

                        <tr>
                            <td>{{trans('setup_booking.tb-col-price-wo-tax')}}</td>
                            <td>{{ $booking->price_wo_tax}}</td>
                        </tr>

                        <tr>
                            <td>{{trans('setup_booking.tb-col-price-w-tax')}}</td>
                            <td>{{ $booking->price_w_tax}}</td>
                        </tr>

                        <tr>
                            <td>{{trans('setup_booking.tb-col-total-tax-amt')}}</td>
                            <td>{{ $booking->total_tax_amt}}</td>
                        </tr>

                        <tr>
                            <td>{{trans('setup_booking.tb-col-total-tax-percentage')}}</td>
                            <td>{{ $booking->total_tax_percentage}}</td>
                        </tr>

                        <tr>
                            <td>{{trans('setup_booking.tb-col-total-payable-amt')}}</td>
                            <td>{{ $booking->total_payable_amt}}</td>
                        </tr>

                        <tr>
                            <td>{{trans('setup_booking.tb-col-total-discount-amt')}}</td>
                            <td>{{ $booking->total_discount_amt}}</td>
                        </tr>

                        <tr>
                            <td>{{trans('setup_booking.tb-col-total-discount-percentage')}}</td>
                            <td>{{ $booking->total_discount_percentage}}</td>
                        </tr>

                        <tr>
                            <td>{{trans('setup_booking.tb-col-hotel-name')}}</td>
                            <td>{{ $booking->hotel->name}}</td>
                        </tr>

                        <tr>
                            <td>{{trans('setup_booking.tb-col-travel-for-work')}}</td>
                            <td>
                                @if($booking->travel_for_work == 0)
                                    {{ 'No'}}
                                @else
                                    {{ 'Yes'}}
                                @endif
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
@stop