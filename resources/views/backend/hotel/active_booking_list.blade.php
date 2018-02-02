@extends('layouts.master')
@section('title','Active Booking List')
@section('content')

        <!-- begin #content -->
<div id="content" class="content">

    <h1 class="page-header">{{trans('setup_hotel.active-booking-title')}} {{$hotel->name}}</h1>

    <div class="row">
        <div class="col-md-10">
          <h3><a href="/backend_mps/hotel"><i class="fa fa-angle-double-left"></i>&nbsp Back to Hotel List</a></h3>
        </div>
    </div>

    <input type="hidden" id="selected_checkboxes" name="selected_checkboxes" value="">

    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="listing">
                <input type="hidden" id="pageSearchedValue" name="pageSearchedValue" value="">
                <table class="table table-striped list-table" id="list-table">

                    <thead>
                    <tr>
                        <th>{{trans('setup_hotel.active-booking-number')}}</th>
                        <th>{{trans('setup_hotel.active-booking-user')}}</th>
                        <th>{{trans('setup_hotel.active-booking-email')}}</th>
                        <th>{{trans('setup_hotel.active-booking-phone')}}</th>
                        <th>{{trans('setup_hotel.active-booking-check-in')}}</th>
                        <th>{{trans('setup_hotel.active-booking-check-out')}}</th>
                        <th>{{trans('setup_hotel.active-booking-status')}}</th>
                    </tr>
                    </thead>
                    <tfoot>
                    <tr>
                        <th class="search-col" con-id="booking_no">Booking No.</th>
                        <th class="search-col" con-id="name">Name</th>
                        <th class="search-col" con-id="email">Email</th>
                        <th class="search-col" con-id="phone">Phone</th>
                        <th class="search-col" con-id="check_in">Check In</th>
                        <th class="search-col" con-id="check_out">Check Out</th>
                        <th class="search-col" con-id="status">Status</th>
                    </tr>
                    </tfoot>
                    <tbody>
                    @foreach($bookings as $booking)
                        <tr>
                            <td>{{$booking->booking_no}}</td>
                            <td>{{$booking->user->first_name}} {{$booking->user->last_name}}</td>
                            <td>{{$booking->user->email}}</td>
                            <td>{{$booking->phone}}</td>
                            <td>{{$booking->check_in_date}}</td>
                            <td>{{$booking->check_out_date}}</td>
                            <td>{{$booking->status_text}}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- {!! Form::close() !!} -->

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
//                "order": [[ 2, "desc" ]],
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
