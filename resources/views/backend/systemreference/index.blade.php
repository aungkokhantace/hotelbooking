@extends('layouts.master')
@section('title','System Reference For Developer')
@section('content')

        <!-- begin #content -->
<div id="content" class="content">
    <h1 class="page-header">System Reference List</h1>
    <div class="row">
        <ul class="nav nav-tabs">
            <li class="active"><a data-toggle="tab" href="#sample">Sample</a></li>
        </ul>

        <div class="tab-content">
            <div id="call_log" class="tab-pane fade in active">
                <h3>Sample Status Reference Description</h3>
                <table border="2" width="300px" style="text-align: center">
                    <tr>
                        <td><strong>Name</strong></td>
                        <td><strong>Value</strong></td>
                    </tr>
                    <tr>
                        <td>Pending</td>
                        <td>1</td>
                    </tr>
                    <tr>
                        <td>Confirm</td>
                        <td>2</td>
                    </tr>
                    <tr>
                        <td>Cancel</td>
                        <td>3</td>
                    </tr>
                    <tr>
                        <td>Approve</td>
                        <td>4</td>
                    </tr>
                    <tr>
                        <td>Reject</td>
                        <td>5</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

    <div class="row">
        <ul class="nav nav-tabs">
            <li class="active"><a data-toggle="tab" href="#hotel_type"><b>Hotel_Type</b></a></li>
            <li><a data-toggle="tab" href="#room_status"><b>Room Status</b></a></li>
            <li><a data-toggle="tab" href="#facility_type"><b>Facility Type</b></a></li>
        </ul>

        <div class="tab-content">
            <div id="hotel_type" class="tab-pane fade in active">
                <h3>Hotel Type Reference Description</h3>
                <table border="2" width="300px" style="text-align: center">
                    <tr>
                        <td><strong>Name</strong></td>
                        <td><strong>Value</strong></td>
                    </tr>
                    <tr>
                        <td>Hotel</td>
                        <td>1</td>
                    </tr>
                    <tr>
                        <td>Motel</td>
                        <td>2</td>
                    </tr>
                    <tr>
                        <td>Guest House</td>
                        <td>3</td>
                    </tr>
                    <tr>
                        <td>Inn</td>
                        <td>4</td>
                    </tr>
                    <tr>
                        <td>Hostel</td>
                        <td>5</td>
                    </tr>
                </table>
            </div>
            <div id="room_status" class="tab-pane fade">
                <h3>Room Status Reference Description</h3>
                <table border="2" width="300px" style="text-align: center">
                    <tr>
                        <td><strong>Name</strong></td>
                        <td><strong>Value</strong></td>
                    </tr>
                    <tr>
                        <td>Available</td>
                        <td>1</td>
                    </tr>
                    <tr>
                        <td>Non Available</td>
                        <td>0</td>
                    </tr>

                </table>
            </div>
            <div id="facility_type" class="tab-pane fade">
                <h3>Facility Type Reference Description</h3>
                <table border="2" width="300px" style="text-align: center">
                    <tr>
                        <td><strong>Name</strong></td>
                        <td><strong>Value</strong></td>
                    </tr>
                    <tr>
                        <td>For Hotel</td>
                        <td>1</td>
                    </tr>
                    <tr>
                        <td>For Room</td>
                        <td>2</td>
                    </tr>

                </table>
            </div>
        </div>
    </div>

</div>
@stop

@section('page_script')

@stop