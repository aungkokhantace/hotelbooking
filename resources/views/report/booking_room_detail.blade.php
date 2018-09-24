@extends('layouts.master')
@section('title','Booking Room Detail')
@section('content')

        <!-- begin #content -->
<div id="content" class="content">

    <h1 class="page-header">Booking Room Detail</h1>
    @if(count(Session::get('message')) != 0)
        <div>
        </div>
    @endif
    <br />
    <div class="row">
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
            <a href="/backend_mps/bookingreport">
                <h5>
                    <span class="glyphicon glyphicon-arrow-left"></span>
                    Back to Booking Report
                </h5>
            </a>
        </div>
    </div>

    <!-- Booking Number -->
    <div class="row">
        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
            <h5>Booking ID : </h5>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
            <h5>{{isset($booking_no)?$booking_no:''}}</h5>
        </div>
    </div>

    <!-- Customer Name -->
    <div class="row">
        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
            <h5>Customer Name : </h5>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
            <h5>{{isset($customer_name)?ucwords($customer_name):''}}</h5>
        </div>
    </div>

    <!-- Hotel Name -->
    <div class="row">
        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
            <h5>Hotel Name : </h5>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
            <h5>{{isset($hotel)?ucwords($hotel->name):''}}</h5>
        </div>
    </div>

    @if(isset($booking_requests->booking_taxi))
    <!-- Taxi Info -->
    <div class="row">
        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
            <h5>Want to book taxi : </h5>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
            <h5>{{($booking_requests->booking_taxi == 1) ? 'Yes':'No'}}</h5>
        </div>
    </div>
    @endif

    @if(isset($booking_requests->booking_tour_guide))
    <!-- Tour Guide Info -->
    <div class="row">
        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
            <h5>Want to book tour guide : </h5>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
            <h5>{{($booking_requests->booking_tour_guide == 1) ? 'Yes':'No'}}</h5>
        </div>
    </div>
    @endif

    @if(isset($booking_requests->special_request) && $booking_requests->special_request !== null && $booking_requests->special_request !== '')
    <!-- Special Request -->
    <div class="row">
        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
            <h5>Special request : </h5>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
            <h5>{{$booking_requests->special_request}}</h5>
        </div>
    </div>
    @endif

    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

            <div class="listing">
                <input type="hidden" id="pageSearchedValue" name="pageSearchedValue" value="">
                <table class="table list-table" id="list-table">
                    <thead>
                    <tr>
                        <th>Date</th>
                        <!-- <th>Hotel</th> -->
                        <th>Room</th>
                        <th>Status</th>
                        <th>Room Price</th>
                        <th>Number of Nights</th>
                        <th>Extra Bed</th>
                        <th>Extra Bed Price</th>
                        <th>Guest Count</th>
                        <th>Smoking</th>
                        <th>Discount Amount</th>
                        <th>Room Payable Amount</th>
                    </tr>
                    </thead>
                    <tfoot>
                    <tr>
                        <th class="search-col" con-id="date">Date</th>
                        <th class="search-col" con-id="room">Room</th>
                        <th class="search-col" con-id="status">Status</th>
                        <th class="search-col" con-id="room_price">Room Price</th>
                        <th class="search-col" con-id="number_of_nights">Number of Nights</th>
                        <th class="search-col" con-id="extra_bed">Extra Bed</th>
                        <th class="search-col" con-id="extra_bed_price">Extra Bed Price</th>
                        <th class="search-col" con-id="guest_count">Guest Count</th>
                        <th class="search-col" con-id="smoking">Smoking</th>
                        <th class="search-col" con-id="discount_amt">Discount Amount</th>
                        <th class="search-col" con-id="room_payable_amt_wo_tax">Room Payable Amount</th>
                    </tr>
                    </tfoot>
                    <tbody>

                    @if(isset($booking_room) && count($booking_room) > 0)
                        @foreach($booking_room as $b_room)
                            <tr>
                                <td>{{$b_room->date}}</td>
                                <td>{{$b_room->room->name}}</td>
                                <td>{{$b_room->status_text}}</td>
                                <td>{{number_format($b_room->room_price_per_night,2)}}</td>
                                <td>{{$b_room->number_of_night}}</td>
                                <td>{{$b_room->added_extra_bed_status}}</td>
                                <td>{{number_format($b_room->extra_bed_price,2)}}</td>
                                <td>{{$b_room->guest_count}}</td>
                                <td>{{$b_room->smoking_status}}</td>
                                <td>{{$b_room->discount_amt}}</td>
                                <td>{{$b_room->room_payable_amt_wo_tax}}</td>
                            </tr>
                        @endforeach
                    @endif

                    </tbody>

                </table>
            </div>
        </div>
    </div>

</div>
@stop

@section('page_script')
    <script type="text/javascript" language="javascript" class="init">
        $(document).ready(function() {

            $('#list-table tfoot th.search-col').each( function () {
                var title = $('#list-table thead th').eq( $(this).index() ).text();
                $(this).html( '<input type="text" placeholder="Search '+title+'" />' );
            } );

            var table = $('#list-table').DataTable({
                aLengthMenu: [
                    [5,25, 50, 100, 200, -1],
                    [5,25, 50, 100, 200, "All"]
                ],
                iDisplayLength: 5,
                "order": [[ 2, "desc" ]],
                stateSave: false,
                "pagingType": "full",
                "paging":   false,
                "dom": '<"pull-right m-t-20"i>rt<"bottom"lp><"clear">',

            });

            // Apply the search
            table.columns().eq( 0 ).each( function ( colIdx ) {
                $( 'input', table.column( colIdx ).footer() ).on( 'keyup change', function () {
                    table
                            .column( colIdx )
                            .search( this.value )
                            .draw();
                } );

            });

            //Start Daypickers
            $('#datepicker_from').datepicker({
                format: 'dd-mm-yyyy',
                autoclose: true,
                defaultDate: "+1w",
                changeMonth: true,
                numberOfMonths: 1,
                allowInputToggle: true
            });

            $('#datepicker_to').datepicker({
                format: 'dd-mm-yyyy',
                autoclose: true,
                defaultDate: "+1w",
                changeMonth: true,
                numberOfMonths: 1,
                allowInputToggle: true,
                minDate: "20-08-2016"
            });
            //End Daypickers

            //Start Monthpickers
            $('#monthpicker_from').datepicker({
                format: 'mm-yyyy',
                viewMode: "months",
                minViewMode: "months",
                allowInputToggle: true,
                autoclose: true
            });

            $('#monthpicker_to').datepicker({
                format: "mm-yyyy",
                viewMode: "months",
                minViewMode: "months",
                allowInputToggle: true,
                autoclose: true
            });
            //End Monthpickers

            //Start Yearpickers
            $('#yearpicker_from').datepicker({
                format: "yyyy",
                viewMode: "years",
                minViewMode: "years",
                allowInputToggle: true,
                autoclose: true
            });

            $('#yearpicker_to').datepicker({
                format: "yyyy",
                viewMode: "years",
                minViewMode: "years",
                allowInputToggle: true,
                autoclose: true
            });
            //End Yearpickers

            var currentType = document.getElementById("type").value;
            if(currentType == "yearly"){
                $('.days').hide();
                $('.months').hide();
                $('.years').show();
            }
            else if(currentType == "monthly"){
                $('.days').hide();
                $('.months').show();
                $('.years').hide();
            }
            else{
                $('.days').show();
                $('.months').hide();
                $('.years').hide();
            }

        });

        function switchPicker(){
            var type = document.getElementById("type").value;
            if(type == "yearly"){
                $('.days').hide();
                $('.months').hide();
                $('.years').show();
            }
            else if(type == "monthly"){
                $('.days').hide();
                $('.months').show();
                $('.years').hide();
            }
            else{
                $('.days').show();
                $('.months').hide();
                $('.years').hide();
            }
        }
    </script>
@stop
