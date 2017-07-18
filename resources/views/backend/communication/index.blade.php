@extends('layouts.master')
@section('title','Hotel Booking')
@section('content')

        <!-- begin #content -->
<div id="content" class="content">

    <h1 class="page-header">{{trans('setup_communication.title-list')}}</h1>

    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="listing">
                <input type="hidden" id="pageSearchedValue" name="pageSearchedValue" value="">
                <table class="table table-striped list-table" id="list-table">

                    <thead>
                    <tr>
                        <th>{{trans('setup_communication.tb-col-booking-number')}}</th>
                        <th>{{trans('setup_communication.tb-col-username')}}</th>
                        <th>{{trans('setup_communication.tb-col-hotel-name')}}</th>
                        <th>{{trans('setup_communication.tb-col-total-request')}}</th>
                        <th>{{trans('setup_communication.tb-col-reply')}}</th>
                    </tr>
                    </thead>
                    <tfoot>
                    <tr>
                        <th class="search-col" con-id="booking_name">Booking Number</th>
                        <th class="search-col" con-id="username">Username</th>
                        <th class="search-col" con-id="hotel_name">Hotel Name</th>
                        <th class="search-col" con-id="total_request">Total Request</th>
                        <th class="search-col" con-id="reply">Reply</th>
                    </tr>
                    </tfoot>
                    <tbody>
                    @foreach($bookings as $booking)
                        <tr>
                            <td>{{ $booking->booking_no}}</td>
                            <td>{{ $booking->user->display_name}}</td>
                            <td>{{ $booking->hotel->name}}</td>
                            
                            <td>
                            @foreach($commuCount as $key => $Count)
                                @if($booking->id == $key)
                                {{ $Count }}
                                @endif
                            @endforeach
                            </td>
                            <td><a href="communication/reply/{{ $booking->id}}">Reply</a></td>
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