@extends('layouts.master')
@section('title','Dashboard')
@section('content')

<div id="content" class="content">
<h1 class="page-header">{{ trans('messages.dashboard') }}</h1>
<div class="row">
        <div class="col-md-3">
            <div class="info-box">
                <span class="info-box-icon bg-light-blue"><i class="ion ion-android-person"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text">NUMBER OF HOTELS</span>
                    <span class="info-box-number">{{ $hotelCount }}</span>
                </div>
                <!-- /.info-box-content -->
            </div>
        </div>

        <div class="col-md-6">
            <div id="chartdiv"></div>
        </div>

        <div class="col-md-6">
            <div id="daily_chart_div"></div>
        </div>

  </div>
</div>

@stop
