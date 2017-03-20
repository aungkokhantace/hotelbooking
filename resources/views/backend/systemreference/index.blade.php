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

@stop

@section('page_script')

@stop