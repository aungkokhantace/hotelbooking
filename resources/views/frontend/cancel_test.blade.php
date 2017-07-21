@extends('layouts_frontend.master_frontend')
@section('title','Manage Booking')
@section('content')
    <h5><b>Cancellation Policy</b></h5>

    {!! Form::open(array('url'=>'/booking/cancel','class'=> 'form-horizontal', 'id'=>'booking_cancel','method'=>'post')) !!}
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <input type="hidden" name="id" value="{{$booking->id}}">
    <div class="row">
        <div class="col-md-12" style="padding: 15px;">
            @foreach($reasons as $reason)
                <input type="radio" id="radio" name="reason" value="{{$reason->value}}">
                {{$reason->description}}
                <br>
            @endforeach
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <button type="submit" class="btn btn-success btn-cancel">Yes, Cancel this booking.</button>
        </div>
        <div class="col-md-4">
            <button type="button" class="btn">No, I don't want to cancel.</button>
        </div>
    </div>
    {!! Form::close() !!}
@stop
