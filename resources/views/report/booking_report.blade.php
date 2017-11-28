@extends('layouts.master')
@section('title','Booking Detail Report')
@section('content')

        <!-- begin #content -->
<div id="content" class="content">

    <h1 class="page-header">Booking Report</h1>
    @if(count(Session::get('message')) != 0)
        <div>
        </div>
    @endif
    <br />

    <div class="row">
        <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1">
            <label for="type" class="text_bold_black">Types</label>
        </div>

        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
            <select class="form-control" name="type" id="type" onchange="switchPicker();">
                @if(isset($type) && $type == "daily")
                    <option value="daily" selected>Daily</option>
                @else
                    <option value="daily">Daily</option>
                @endif
                @if(isset($type) && $type == "monthly")
                    <option value="monthly" selected>Monthly</option>
                @else
                    <option value="monthly">Monthly</option>
                @endif
                @if(isset($type) && $type == "yearly")
                    <option value="yearly" selected>Yearly</option>
                @else
                    <option value="yearly">Yearly</option>
                @endif
            </select>
            <p class="text-danger">{{$errors->first('type')}}</p>
        </div>
    </div>
    <br>

    {{--Start Datepicker--}}
    <div class="row days" style="display:none;">
        <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1">
            <label for="from_date" class="text_bold_black">From Date</label>
        </div>

        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
            <div class="input-group date dateTimePicker" data-provide="datepicker" id="datepicker_from">
                <input type="text" class="form-control" id="from_date" name="from_date" value="{{isset($from_date)?$from_date:''}}">
                <div class="input-group-addon">
                    <span class="glyphicon glyphicon-calendar"></span>
                </div>
            </div>
        </div>
        <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1"></div>

        <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1">
            <label for="to_date" class="text_bold_black">To Date</label>
        </div>

        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
            <div class="input-group date dateTimePicker" data-provide="datepicker"  id="datepicker_to">
                <input type="text" class="form-control" id="to_date" name="to_date" value="{{isset($to_date)?$to_date:''}}">
                <div class="input-group-addon">
                    <span class="glyphicon glyphicon-calendar"></span>
                </div>
            </div>
        </div>
    </div>
    {{--End Datepicker--}}
    <br class="days">

    {{--Start Monthpicker--}}
    <div class="row months" style="display:none;">
        <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1">
            <label for="from_month" class="text_bold_black">From Month</label>
        </div>

        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
            <div class="input-group date dateTimePicker" data-provide="datepicker" id="monthpicker_from">
                <input type="text" class="form-control" id="from_month" name="from_month" value="{{isset($from_month)?$from_month:''}}">
                <div class="input-group-addon">
                    <span class="glyphicon glyphicon-calendar"></span>
                </div>
            </div>
        </div>
        <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1"></div>

        <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1">
            <label for="to_month" class="text_bold_black">To Month</label>
        </div>

        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
            <div class="input-group date dateTimePicker" data-provide="datepicker"  id="monthpicker_to">
                <input type="text" class="form-control" id="to_month" name="to_month" value="{{isset($to_month)?$to_month:''}}">
                <div class="input-group-addon">
                    <span class="glyphicon glyphicon-calendar"></span>
                </div>
            </div>
        </div>
    </div>
    {{--End Monthpicker--}}
    <br class="months">

    {{--Start Yearpicker--}}
    <div class="row years" style="display:none;">
        <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1">
            <label for="from_year" class="text_bold_black">From Year</label>
        </div>

        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
            <div class="input-group date dateTimePicker" data-provide="datepicker" id="yearpicker_from">
                <input type="text" class="form-control" id="from_year" name="from_year" value="{{isset($from_year)?$from_year:''}}">
                <div class="input-group-addon">
                    <span class="glyphicon glyphicon-calendar"></span>
                </div>
            </div>
        </div>
        <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1"></div>

        <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1">
            <label for="to_year" class="text_bold_black">To Year</label>
        </div>

        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
            <div class="input-group date dateTimePicker" data-provide="datepicker"  id="yearpicker_to">
                <input type="text" class="form-control" id="to_year" name="to_year" value="{{isset($to_year)?$to_year:''}}">
                <div class="input-group-addon">
                    <span class="glyphicon glyphicon-calendar"></span>
                </div>
            </div>
        </div>
    </div>
    {{--End Yearpicker--}}
    <br class="years">

    <div class="row">
        <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1">
            <label for="status" class="text_bold_black">Status</label>
        </div>

        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
            <select class="form-control" id="status">
                <option value=0>All</option>
                <!-- <option value=1 {{isset($status)&&$status== 1?'selected':''}}>Pending</option>
                <option value=2 {{isset($status)&&$status== 2?'selected':''}}>Confirm</option>
                <option value=3 {{isset($status)&&$status== 3?'selected':''}}>Cancel</option>
                <option value=4 {{isset($status)&&$status== 4?'selected':''}}>Void</option> -->
                <option value=1 {{isset($status)&&$status== 1?'selected':''}}>Pending</option>
                <option value=2 {{isset($status)&&$status== 2?'selected':''}}>Confirm</option>
                <option value=3 {{isset($status)&&$status== 3?'selected':''}}>Cancel(Cancel By User)</option>
                <option value=4 {{isset($status)&&$status== 4?'selected':''}}>Void(Cancel By System Admin)</option>
                <option value=4 {{isset($status)&&$status== 5?'selected':''}}>Complete</option>
                <option value=4 {{isset($status)&&$status== 6?'selected':''}}>Transaction Fail</option>
                <option value=4 {{isset($status)&&$status== 7?'selected':''}}>Refund by Customer(Cancel within first cancellation days)</option>
                <option value=4 {{isset($status)&&$status== 8?'selected':''}}>Refund by Admin</option>
                <option value=4 {{isset($status)&&$status== 9?'selected':''}}>Cancel within second cancellation days</option>
            </select>
        </div>
    </div>

    <br class="staus">

    <div class="row">
        <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1"></div>

        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
            <button type="button" onclick="report_search_with_type('bookingreport');" class="form-control btn-primary">Preview By List</button>
        </div>

        {{--<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">--}}
        {{--<button type="button" onclick="check_to_redirect_to_graph_with_type();" class="form-control btn-primary">Preview By Graph</button>--}}
        {{--</div>--}}

        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
            <button type="button" onclick="report_export_with_type('bookingreport');" class="form-control btn-primary">Export Excel</button>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="listing">
                <input type="hidden" id="pageSearchedValue" name="pageSearchedValue" value="">
                <table class="table list-table" id="list-table">
                    <thead>
                    <tr>
                        <th>Date</th>
                        <th>Booking Number</th>
                        <th>Customer Name</th>
                        <th>Status</th>
                        <th>Total Room</th>
                        <th>Total Amount</th>
                    </tr>
                    </thead>
                    <tfoot>
                    <tr>
                        <th class="search-col" con-id="date">Date</th>
                        <th class="search-col" con-id="booking_number">Booking Number</th>
                        <th class="search-col" con-id="customer_name">Customer Name</th>
                        <th class="search-col" con-id="status">Status</th>
                        <th class="search-col" con-id="total_room">Total Room</th>
                        <th class="search-col" con-id="total_amount">Total Amount</th>
                    </tr>
                    </tfoot>
                    <tbody>

                    @if(isset($bookings) && count($bookings) > 0)
                        @foreach($bookings as $booking)
                            <tr>
                                <td>{{$booking->date}}</td>
                                <td><a href="/backend_mps/bookingreport/room_detail/{{$booking->id}}">{{$booking->booking_no}}</a></td>
                                <td>{{ucwords($booking->first_name.' '.$booking->last_name)}}</td>
                                <td>
                                    <!-- @if($booking->status == 1) {{'Pending'}}
                                    @elseif($booking->status == 2) {{'Confirm'}}
                                    @elseif($booking->status == 3) {{'Cancel'}}
                                    @else {{'Void'}}
                                    @endif -->
                                    @if($booking->status == 1) {{'Pending'}}
                                    @elseif($booking->status == 2) {{'Confirm'}}
                                    @elseif($booking->status == 3) {{'Cancel(Cancel By User)'}}
                                    @elseif($booking->status == 4) {{'Void (Cancel By System Admin)'}}
                                    @elseif($booking->status == 5) {{'Complete'}}
                                    @elseif($booking->status == 6) {{'Transaction Fail'}}
                                    @elseif($booking->status == 7) {{'Refund by Customer(Cancel within first cancellation days)'}}
                                    @elseif($booking->status == 8) {{'Refund by Admin'}}
                                    @else {{'Cancel within second cancellation days'}}
                                    @endif
                                </td>
                                <td>{{$booking->total_room}}</td>
                                <td>{{number_format($booking->total_payable_amt,2)}}</td>
                            </tr>
                        @endforeach
                    @endif

                    </tbody>
                    <tr bgcolor="#AE3D8D" style = "color:white">
                        <td>Grand Total</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td>{{isset($grandTotal)?number_format($grandTotal,2):0.00}}</td>
                    </tr>
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
//                "order": [[ 2, "desc" ]],
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
