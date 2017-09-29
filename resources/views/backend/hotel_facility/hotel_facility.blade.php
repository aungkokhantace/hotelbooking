@extends('layouts.master')
@section('title','Hotel Facility')
@section('content')

        <!-- begin #content -->
<div id="content" class="content">

    <h1 class="page-header">{{isset($hotel_facility) ? trans('setup_hotelfacility.title-edit') : trans('setup_hotelfacility.title-entry')}}</h1>

    @if(isset($hotel_facility))
        {!! Form::open(array('url' => '/backend_mps/hotel_facility/update','id'=>'hotel_facility', 'class'=> 'form-horizontal user-form-border')) !!}

    @else
        {!! Form::open(array('url' => '/backend_mps/hotel_facility/store','id'=>'hotel_facility', 'class'=> 'form-horizontal user-form-border')) !!}
    @endif
    <input type="hidden" name="id" value="{{isset($hotel_facility)? $hotel_facility->id:''}}"/>
    <br/>

    <div class="row">
        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
            <label for="hotel_id">{{trans('setup_hotelfacility.hotel')}}<span class="require">*</span></label>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
            <select class="form-control" name="hotel_id" id="hotel_id">
                @if(isset($hotel_facility))
                    @foreach($hotels as $hotel)
                        @if($hotel->id == $hotel_facility->hotel_id)
                            <option value="{{$hotel->id}}" selected>{{$hotel->name}}</option>
                        @else
                            <option value="{{$hotel->id}}">{{$hotel->name}}</option>
                        @endif
                    @endforeach
                @else
                    <option value="" disabled selected>{{trans('setup_hotelfacility.place-hotel')}}</option>
                    @foreach($hotels as $hotel)
                        <option value="{{$hotel->id}}">{{$hotel->name}}</option>
                    @endforeach
                @endif
            </select>
            <p class="text-danger">{{$errors->first('hotel_id')}}
        </div>
    </div>

    {{--<div class="row">--}}
        {{--<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">--}}
            {{--<label for="facility_group">{{trans('setup_hotelfacility.facility-gp')}}<span class="require">*</span></label>--}}
        {{--</div>--}}
        {{--<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">--}}
            {{--<select class="form-control" name="facility_group" id="facility_group">--}}
                {{--@if(isset($hotel_facility))--}}
                    {{--@foreach($facility_group as $group)--}}
                        {{--@if($group->id == $hotel_facility->facility_group_id)--}}
                            {{--<option value="{{$group->id}}" selected>{{$group->name}}</option>--}}
                        {{--@else--}}
                            {{--<option value="{{$group->id}}">{{$group->name}}</option>--}}
                        {{--@endif--}}
                    {{--@endforeach--}}
                {{--@else--}}
                    {{--<option value="" disabled selected>{{trans('setup_hotelfacility.place-facility-gp')}}</option>--}}
                    {{--@foreach($facility_group as $group)--}}
                        {{--<option value="{{$group->id}}">{{$group->name}}</option>--}}
                    {{--@endforeach--}}
                {{--@endif--}}
            {{--</select>--}}
            {{--<p class="text-danger">{{$errors->first('facility_group')}}--}}
        {{--</div>--}}
    {{--</div>--}}

    <div class="row">
        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
            <label for="facility">{{trans('setup_hotelfacility.facility')}}<span class="require">*</span></label>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
            <select class="form-control" name="facility" id="facility">
                @if(isset($hotel_facility))
                    @foreach($facilities as $facility)
                        @if($facility->id == $hotel_facility->facility_id)
                            <option value="{{$facility->id}}" selected>{{$facility->name}}</option>
                        @else
                            <option value="{{$facility->id}}">{{$facility->name}}</option>
                        @endif
                    @endforeach
                @else
                    <option value="" disabled selected>{{trans('setup_hotelfacility.place-facility')}}</option>
                    @foreach($facilities as $facility)
                        <option value="{{$facility->id}}">{{$facility->name}}</option>
                    @endforeach
                @endif
            </select>
            <p class="text-danger">{{$errors->first('facility')}}
        </div>
    </div>


    <div class="row">
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
        </div>
        <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1">
            <input type="submit" name="submit" value="{{isset($hotel_facility)? trans('setup_hotelfacility.btn-update') : trans('setup_hotelfacility.btn-add')}}" class="form-control btn-primary">
        </div>
        <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1">
            <input type="button" value="{{trans('setup_hotelfacility.btn-cancel')}}" class="form-control cancel_btn" onclick="cancel_setup('hotel_facility')">
        </div>
    </div>
    {!! Form::close() !!}
</div>
@stop

@section('page_script')
    <script type="text/javascript">
        $(document).ready(function(){
            //Start Validation for Entry and Edit Form
            $('#hotel_facility').validate({
                rules: {
                    hotel_id      : 'required',
                    facility    : 'required',
//                    facility_group : 'required',
                },
                messages: {
                    hotel_id      : 'Hotel is required!',
                    facility    : 'Feature is required!',
//                    facility_group : 'Facility Group is required!',
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