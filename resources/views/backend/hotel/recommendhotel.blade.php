@extends('layouts.master')
@section('title','Recommend Hotel')
@section('content')

        <!-- begin #content -->
<div id="content" class="content">

    <h1 class="page-header">
        {{trans('setup_hotel.title-recommend')}}
    </h1>

    {!! Form::open(array('url' => '/backend_mps/recommend_hotel/store', 'class'=> 'form-horizontal user-form-border', 'id'=>'recommend_hotel','files'=>true)) !!}
    <br/>

    @foreach($hotels as $hotel)
    <div class="row">
        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
            <label for="name">{{$hotel->name}}</label>
        </div>
        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
            <select class="form-control" name="{{$hotel->order_label}}">
                @if(isset($hotel->order) && $hotel->order != "" && $hotel->order != null)
{{--                    @for ($i = 1; $i <= $hotel_count; $i++)--}}
                    @for ($i = 0; $i <= $hotel_count; $i++)
                        @if($i == $hotel->order)
                            <option value="{{ $i }}" selected>{{ $i }}</option>
                        @else
                            <option value="{{ $i }}">{{ $i }}</option>
                        @endif
                    @endfor
                @else
                    <option value="" disabled selected>{{trans('setup_hotel.place-order')}}</option>
{{--                    @for ($i = 1; $i <= $hotel_count; $i++)--}}
                    @for ($i = 0; $i <= $hotel_count; $i++)
                        <option value="{{ $i }}">{{ $i }}</option>
                    @endfor
                @endif
            </select>
            <p class="text-danger">{{$errors->first('name')}}</p>
        </div>
    </div>
    @endforeach

    <div class="row">
        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
        </div>
        <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1">
            <input type="submit" name="submit" value="{{trans('setup_hotel.btn-set')}}" class="form-control btn-primary">
        </div>
        <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1">
            <input type="button" value="{{trans('setup_hotel.btn-cancel')}}" class="form-control cancel_btn" onclick="cancel_setup('hotel')">
        </div>
    </div>

    {!! Form::close() !!}
</div>
@stop

@section('page_script')
    <script type="text/javascript">
        $(document).ready(function() {

        });
    </script>
@stop