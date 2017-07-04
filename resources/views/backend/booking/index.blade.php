@extends('layouts.master')
@section('title','Hotel Booking')
@section('content')

        <!-- begin #content -->
<div id="content" class="content">

    <h1 class="page-header">{{trans('setup_booking.title-list')}}</h1>

    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="listing">
                <input type="hidden" id="pageSearchedValue" name="pageSearchedValue" value="">
                <table class="table table-striped list-table" id="list-table">

                    <thead>
                    <tr>
                        <th>{{trans('setup_booking.tb-col-booking-number')}}</th>
                        <th>{{trans('setup_booking.tb-col-username')}}</th>
                        <th>{{trans('setup_booking.tb-col-check-in-date')}}</th>
                        <th>{{trans('setup_booking.tb-col-check-out-date')}}</th>
                        <th>{{trans('setup_booking.tb-col-for-other')}}</th>
                        <th>{{trans('setup_booking.tb-col-total-tax-amt')}}</th>
                        <th>{{trans('setup_booking.tb-col-total-tax-percentage')}}</th>
                        <th>{{trans('setup_booking.tb-col-hotel-name')}}</th>
                        <th>{{trans('setup_booking.tb-col-travel-for-work')}}</th>
                    </tr>
                    </thead>
                    <tfoot>
                    <tr>
                        <th class="search-col" con-id="booking_name">Booking Number</th>
                        <th class="search-col" con-id="username">Username</th>
                        <th class="search-col" con-id="check_in_date">Check in Date</th>
                        <th class="search-col" con-id="check_out_date">Check Out Date</th>
                        <th class="search-col" con-id="for_other">For Other</th>
                        <th class="search-col" con-id="total_tax_amt">Total Tax Amount</th>
                        <th class="search-col" con-id="total_tax_percentage">Total Tax Percentage</th>
                        <th class="search-col" con-id="hotel_name">Hotel Name</th>
                        <th class="search-col" con-id="travel_for_work">Travel For Work</th>
                    </tr>
                    </tfoot>
                    <tbody>
                    @foreach($bookings as $booking)
                        <tr>
                            <td><a href="booking/{{ $booking->id }}">{{ $booking->booking_no}}</a></td>
                            <td>{{ $booking->user->display_name}}</td>
                            <td>{{ $booking->check_in_date}}</td>
                            <td>{{ $booking->check_out_date}}</td>
                            <td>
                                @if($booking->for_other == 0)
                                    {{ 'No'}}
                                @else
                                    {{ 'Yes'}}
                                @endif
                            </td>
                            <td>{{ $booking->total_tax_amt}}</td>
                            <td>{{ $booking->total_tax_percentage}}</td>
                            <td>{{ $booking->hotel->name}}</td>
                            <td>
                                @if($booking->travel_for_work == 0)
                                    {{ 'No'}}
                                @else
                                    {{ 'Yes'}}
                                @endif
                            </td>
                        </tr>
                    @endforeach
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
                "dom": '<"pull-right m-t-20"i>rt<"bottom"lp><"clear">',

            });
//            new $.fn.dataTable.FixedHeader( table, {
//            });


            // Apply the search
            table.columns().eq( 0 ).each( function ( colIdx ) {
                $( 'input', table.column( colIdx ).footer() ).on( 'keyup change', function () {
                    table
                            .column( colIdx )
                            .search( this.value )
                            .draw();
                } );

            });
        });
    </script>
@stop