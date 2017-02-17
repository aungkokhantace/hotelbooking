@extends('layouts.master')
@section('title','Amendities')
@section('content')

        <!-- begin #content -->
<div id="content" class="content">

    <h1 class="page-header">
        @if(isset($profile))
            Update Profile
        @else
            {{ isset($amendities) ?  'Amendities Edit' : 'Amendities Entry' }}
        @endif
    </h1>

    {{--check new or edit--}}
    @if(isset($amendities))
        {!! Form::open(array('url' => '/backend/amendities/update','files'=>true, 'class'=> 'form-horizontal user-form-border', 'id'=>'amendities')) !!}

    @else
        {!! Form::open(array('url' => '/backend/amendities/store','files'=>true, 'class'=> 'form-horizontal user-form-border', 'id'=>'amendities')) !!}
    @endif
    <input type="hidden" name="id" value="{{isset($amendities)? $amendities->id:''}}"/>
    <br/>

    <div class="row">
        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
            <label for="country_id">Amendities Name <span class="require">*</span></label>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
            <input required type="text" class="form-control" id="amendities_name" name="amendities_name"
                   placeholder="Enter Amendities Name" value="{{ isset($amendities)? $amendities->amendities_name:Request::old('amendities_name') }}"/>
            <p class="text-danger">{{$errors->first('amendities_name')}}</p>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
            <label for="user_name">Amendities Icon<span class="require">*</span></label>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
            <div class="fileinput fileinput-new" data-provides="fileinput">
                <div class="fileinput-preview thumbnail" data-trigger="fileinput" style="width: 355px; height: 220px;">
                    <img id='site_logoPopUp' src="" alt="Load Image"/>
                </div>
                <div data-provides="fileinput">
	                        <span class="btn btn-default btn-file" style="background-color: #259299;border-color: #22868d;">
	                            <span class="fileinput-new" data-trigger="fileinput">Select</span>
	                            <span class="fileinput-exists">Image</span>
	                            <input id="site_logo2" type="file" class="amendities_icon" name="amendities_icon" accept="image.*" style="width: 330px;"/>
	                        </span>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
        </div>
        <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1">
            <input type="submit" name="submit" value="{{isset($amendities)? 'UPDATE' : 'ADD'}}" class="form-control btn-primary">
        </div>
        <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1">
            <input type="button" value="CANCEL" class="form-control cancel_btn" onclick="cancel_setup('amendities')">
        </div>
    </div>
    {!! Form::close() !!}
</div>
@stop

@section('page_script')
    <script type="text/javascript">
        $(document).ready(function(){
            $('INPUT[type="file"]').change(function () {
                var ext = this.value.match(/\.(.+)$/)[1];
                var f=this.files[0];
                var fileSize = (f.size||f.fileSize);
                var imgkbytes = Math.round(parseInt(fileSize)/1024);

                if(imgkbytes > 5000){
                    $('#image_error_fileSize').modal('show');
                    $('#site_logoPopUp').attr('src') = '';
                }

                switch (ext) {
                    case 'jpg':
                    case 'jpeg':
                    case 'png':
                    case 'gif':
                        break;
                    default:
                        $('#image_error_fileFormat').modal('show');
                        $('#site_logoPopUp').attr('src') = '';
                }
            });
        });

    </script>
@stop