@extends('layouts.master')
@section('title','Popular City')
@section('content')

        <!-- begin #content -->
<div id="content" class="content">

    <h1 class="page-header">
        Set Popular Cities
    </h1>

    {!! Form::open(array('url' => '/backend_mps/popular_city/store', 'class'=> 'form-horizontal user-form-border', 'id'=>'popular_city','files'=>true)) !!}
    <br/>

    
    <div class="row">
        @foreach($cities as $city)
        {{-- <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
            <label for="name">{{$city->name}}</label>
        </div> --}}
        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
            <label for="name">{{$city->name}}</label>
            <select class="form-control" name="{{$city->order_label}}">
                @if(isset($city->order) && $city->order != "" && $city->order != null)
{{--                    @for ($i = 1; $i <= $city_count; $i++)--}}
                    @for ($i = 0; $i <= $city_count; $i++)
                        {{--<option value="{{ $i }}">{{ $i }}</option>--}}
                        @if($i == $city->order)
                            <option value="{{ $i }}" selected>{{ $i }}</option>
                        @else
                            <option value="{{ $i }}">{{ $i }}</option>
                        @endif
                    @endfor
                @else
                    <option value="" disabled selected>Select Order</option>
{{--                    @for ($i = 1; $i <= $city_count; $i++)--}}
                    @for ($i = 0; $i <= $city_count; $i++)
                        <option value="{{ $i }}">{{ $i }}</option>
                    @endfor
                @endif
            </select>
            <p class="text-danger">{{$errors->first('name')}}</p>
        </div>
        @endforeach
    </div>
    

    <div class="row">
        <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
        </div>
        <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1">
            <input type="submit" name="submit" value="SET" class="form-control btn-primary">
        </div>
        <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1">
            <input type="button" value="CANCEL" class="form-control cancel_btn" onclick="cancel_setup('city')">
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