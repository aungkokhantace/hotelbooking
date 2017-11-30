<?php
/**
 * Created by PhpStorm.
 * Author: Wai Yan Aung
 * Date: 8/26/2016
 * Time: 2:18 PM
 */
?>

@extends('layouts.master')
@section('title','Activities')
@section('content')

<style>
    #list-table2 tfoot {
        display:table-header-group;
    }

    #list-table3 tfoot {
        display:table-header-group;
    }

    #list-table4 tfoot {
        display:table-header-group;
    }

    #list-table5 tfoot {
        display:table-header-group;
    }
    #ex1Slider .slider-selection {
        background: #BABABA;
    }
</style>

        <!-- begin #content -->
<div id="content" class="content">

    <h1 class="page-header">Activity Log</h1>

    @if(count(Session::get('message')) != 0)
        <div>
        </div>
    @endif

    <br/>
    <div class="row">
    <!--Start Accordion-->
        <div class="panel-group" id="accordion">
            @foreach($logArray as $date=>$logs)
                <div class="panel panel-inverse">
                    <!-- Panel Heading -->
                    <div class="panel-heading">
                        <h3 class="panel-title">
                            <a class="accordion-toggle accordion-toggle-styled collapsed" data-toggle="collapse" data-parent="#accordion" href="#{{$date}}">
                                <i class="fa fa-plus-circle pull-right"></i>
                                {{$date}}
                            </a>
                        </h3>
                    </div>
                    <!-- End Panel Heading -->

                    <!-- Start Panel Body -->
                    <div id="{{$date}}" class="panel-collapse collapse">
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <div class="listing">
                                        <table class="table table-striped list-table" id="list-table">
                                                <thead>
                                                <tr>
                                                    <th>{{$date.' Activities'}}</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($logs as $log)
                                                    <tr>
                                                        <td>{{$log}}</td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End Panel Body -->
                </div>
                @endforeach
        </div>
        <!--End Accordion-->
    </div>
</div>
@stop
