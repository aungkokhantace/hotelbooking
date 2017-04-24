@extends('layouts.master')
@section('title','Hotel Landmark')
@section('content')

        <!-- begin #content -->
<div id="content" class="content">

    <h1 class="page-header">{{isset($hotel_landmark) ? trans('setup_hotellandmark.title-edit') : trans('setup_hotellandmark.title-entry')}}</h1>

    @if(isset($hotel_landmark))
        {!! Form::open(array('url' => '/backend/hotel_landmark/update','id'=>'hotel_landmark', 'class'=> 'form-horizontal user-form-border')) !!}

    @else
        {!! Form::open(array('url' => '/backend/hotel_landmark/store','id'=>'hotel_landmark', 'class'=> 'form-horizontal user-form-border')) !!}
    @endif
    <input type="hidden" name="id" value="{{isset($hotel_landmark)? $hotel_landmark->id:''}}"/>
    <br/>

    <div class="row">
        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
            <label for="hotel_id">{{trans('setup_hotellandmark.hotel')}}<span class="require">*</span></label>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
            <select class="form-control" name="hotel_id" id="hotel_id">
                @if(isset($hotel_landmark))
                    @foreach($hotels as $hotel)
                        @if($hotel->id == $hotel_landmark->hotel_id)
                            <option value="{{$hotel->id}}" selected>{{$hotel->name}}</option>
                        @else
                            <option value="{{$hotel->id}}">{{$hotel->name}}</option>
                        @endif
                    @endforeach
                @else
                    <option value="" disabled selected>{{trans('setup_hotellandmark.place-hotel')}}</option>
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
            <label for="landmark">{{trans('setup_hotellandmark.landmark')}}<span class="require">*</span></label>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
            <select class="form-control" name="landmark" id="landmark">
                @if(isset($hotel_landmark))
                    @foreach($landmarks as $landmark)
                        @if($landmark->id == $landmark->landmark_id)
                            <option value="{{$landmark->id}}" selected>{{$landmark->name}}</option>
                        @else
                            <option value="{{$landmark->id}}">{{$landmark->name}}</option>
                        @endif
                    @endforeach
                @else
                    <option value="" disabled selected>
                        {{trans('setup_hotellandmark.place-landmark')}}
                    </option>
                    @foreach($landmarks as $landmark)
                        <option value="{{$landmark->id}}">{{$landmark->name}}</option>
                    @endforeach
                @endif
            </select>
            <p class="text-danger">{{$errors->first('landmark')}}
        </div>
    </div>


    <div class="row">
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
        </div>
        <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1">
            <input type="submit" name="submit" value="{{isset($hotel_landmark)? trans('setup_hotellandmark.btn-update') : trans('setup_hotellandmark.btn-add')}}" class="form-control btn-primary">
        </div>
        <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1">
            <input type="button" value="{{trans('setup_hotellandmark.btn-cancel')}}" class="form-control cancel_btn" onclick="cancel_setup('hotel_landmark')">
        </div>
    </div>
    {!! Form::close() !!}
</div>
@stop

@section('page_script')
    <script type="text/javascript">
        $(document).ready(function(){
            //Start Validation for Entry and Edit Form
            $('#hotel_landmark').validate({
                rules: {
                    hotel_id      : 'required',
                    landmark      : 'required',
                },
                messages: {
                    hotel_id      : 'Hotel is required!',
                    landmark      : 'Landmark is required!',
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