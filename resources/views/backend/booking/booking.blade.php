@extends('layouts.master')
@section('title','Hotel Booking')
@section('content')

        <!-- begin #content -->
<div id="content" class="content">

    <h1 class="page-header">{{trans('setup_booking.title-detail')}}</h1>

    <div class="row">
        <div class="col-lg-7 col-md-7 col-sm-7 col-xs-7">
            <br>
            <div>
                @if($booking->can_refund == 1)
                    {!! Form::open(array('url'=>'backend_mps/booking/refund','class'=>'form-inline','id'=>'refund_form')) !!}
                    <input type="hidden" name="b_num" value="{!! $booking->id !!}">
                    <div class="form-group">
                        <select class="form-control" name="refund_percentage">
                            <option value=100>100%</option>
                        </select>
                    </div>

                    <button type="button" class="btn btn-danger" id="refund"><b>Refund</b></button>
                    {!! Form::close() !!}
                @endif
            </div>
            <br>
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
@section('page_script')
    <script type="text/javascript">
        $(document).ready(function(){

            $('#refund').click(function(){
                swal({
                    title: "Are you sure?",
                    text: "You want to refund!",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#DD6B55 ",
                    confirmButtonText: "Confirm",
                    cancelButtonText: "Cancel",
                    closeOnConfirm: false,
                    closeOnCancel: true
                },function(isConfirm){
                    if(isConfirm){
                        $("#refund_form").submit();
                    }
                    else{
                        return;
                    }
                }
                );
            });
        });
    </script>
@stop
