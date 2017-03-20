@extends('layouts.master')
@section('title','Hotel Feature')
@section('content')

        <!-- begin #content -->
<div id="content" class="content">

    <h1 class="page-header">{{isset($hotel_feature) ?  'Hotel Feature Edit' : 'Hotel Feature Entry' }}</h1>

    @if(isset($hotel_feature))
        {!! Form::open(array('url' => '/backend/hotel_feature/update','id'=>'hotel_feature', 'class'=> 'form-horizontal user-form-border')) !!}

    @else
        {!! Form::open(array('url' => '/backend/hotel_feature/store','id'=>'hotel_feature', 'class'=> 'form-horizontal user-form-border')) !!}
    @endif
    <input type="hidden" name="id" value="{{isset($hotel_feature)? $hotel_feature->id:''}}"/>
    <br/>

    <div class="row">
        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
            <label for="hotel_id">Hotel <span class="require">*</span></label>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
            <select class="form-control" name="hotel_id" id="hotel_id">
                @if(isset($hotel_feature))
                    @foreach($hotels as $hotel)
                        @if($hotel->id == $hotel_feature->hotel_id)
                            <option value="{{$hotel->id}}" selected>{{$hotel->name}}</option>
                        @else
                            <option value="{{$hotel->id}}">{{$hotel->name}}</option>
                        @endif
                    @endforeach
                @else
                    <option value="" disabled selected>Select Hotel</option>
                    @foreach($hotels as $hotel)
                        <option value="{{$hotel->id}}">{{$hotel->name}}</option>
                    @endforeach
                @endif
            </select>
            <p class="text-danger">{{$errors->first('hotel_id')}}
        </div>
    </div>

    <div class="row">
        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
            <label for="hotel_id">Feature<span class="require">*</span></label>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
            <select class="form-control" name="feature_id" id="feature_id">
                @if(isset($hotel_feature))
                    @foreach($features as $feature)
                        @if($feature->id == $hotel_feature->feature_id)
                            <option value="{{$feature->id}}" selected>{{$feature->name}}</option>
                        @else
                            <option value="{{$feature->id}}">{{$feature->name}}</option>
                        @endif
                    @endforeach
                @else
                    <option value="" disabled selected>Select Feature</option>
                    @foreach($features as $feature)
                        <option value="{{$feature->id}}">{{$feature->name}}</option>
                    @endforeach
                @endif
            </select>
            <p class="text-danger">{{$errors->first('feature_id')}}
        </div>
    </div>


    <div class="row">
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
        </div>
        <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1">
            <input type="submit" name="submit" value="{{isset($hotel_feature)? 'UPDATE' : 'ADD'}}" class="form-control btn-primary">
        </div>
        <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1">
            <input type="button" value="CANCEL" class="form-control cancel_btn" onclick="cancel_setup('hotel_feature')">
        </div>
    </div>
    {!! Form::close() !!}
</div>
@stop

@section('page_script')
    <script type="text/javascript">
        $(document).ready(function(){
            //Start Validation for Entry and Edit Form
            $('#hotel_feature').validate({
                rules: {
                    hotel_id      : 'required',
                    feature_id    : 'required',
                },
                messages: {
                    hotel_id      : 'Hotel is required',
                    feature_id    : 'Feature is required',
                },
                submitHandler: function(form) {
                    $('input[type="submit"]').attr('disabled','disabled');
                    form.submit();
                }
            });
            //End Validation for Entry and Edit Form
        });
    </script>
@stop