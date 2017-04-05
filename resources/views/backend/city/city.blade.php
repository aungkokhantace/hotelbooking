@extends('layouts.master')
@section('title','City')
@section('content')

        <!-- begin #content -->
<div id="content" class="content">

    <h1 class="page-header">
        {{ isset($city) ?  trans('messages.edit') : trans('messages.entry') }}
    </h1>

    {{--check new or edit--}}
    @if(isset($city))
        {!! Form::open(array('url' => '/backend/city/update', 'class'=> 'form-horizontal user-form-border', 'id'=>'city','files'=>true)) !!}

    @else
        {!! Form::open(array('url' => '/backend/city/store', 'class'=> 'form-horizontal user-form-border', 'id'=>'city','files'=>true)) !!}
    @endif
    <input type="hidden" name="id" value="{{isset($city)? $city->id:''}}"/>
    <br/>

    <div class="row">
        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
            <label for="country_id">Country Name<span class="require">*</span></label>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
            <select class="form-control" name="country_id" id="country_id">
            @if(isset($city))
                @foreach($countries as $country)
                    @if($country->id == $city->country_id)
                        <option value="{{$country->id}}" selected>{{$country->name}}</option>
                    @else
                        <option value="{{$country->id}}">{{$country->name}}</option>
                    @endif
                @endforeach
            @else
                <option value="" disabled selected>Select Country</option>
                @foreach($countries as $country)
                    <option value="{{$country->id}}">{{$country->name}}</option>
                @endforeach
            @endif
            </select>
            <p class="text-danger">{{$errors->first('country_id')}}</p>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
            <label for="name">City Name<span class="require">*</span></label>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
            <input type="text" class="form-control" id="name" name="name" placeholder="Enter City Name" value="{{ isset($city)? $city->name:Request::old('name') }}"/>
            <p class="text-danger">{{$errors->first('name')}}</p>
        </div>
    </div>

    {{--Start File Upload--}}
    <div class="row">
        <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1">
            <label for="photo" class="text_bold_black">Photo</label>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 col-lg-offset-1 col-md-offset-1 col-sm-offset-1 col-xs-offset-1">
            @if(isset($city))
                <div class="add_image_div add_image_div_red" style="background-image: url({{'/images/upload/'.$city->image}});background-position:center;background-size:cover">
                </div>
                <input type="hidden" id="removeImageFlag" value="0" name="removeImageFlag">
            @else
                <div class="add_image_div add_image_div_red">
                </div>
                <input type="hidden" id="removeImageFlag" value="0" name="removeImageFlag">
            @endif
        </div>
    </div>

    <div class="row">
        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
            <label></label>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
            <input type="button" class="form-control image_remove_btn" value="Remove Image" id="removeImage" name="removeImage">
            <p class="text-danger">{{$errors->first('photo')}}</p>
        </div>
    </div>
    <br/>
    {{--End File Upload--}}

    <div class="row">
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
        </div>
        <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1">
            <input type="submit" name="submit" value="{{isset($city)? 'UPDATE' : 'ADD'}}" class="form-control btn-primary">
        </div>
        <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1">
            <input type="button" value="CANCEL" class="form-control cancel_btn" onclick="cancel_setup('city')">
        </div>
    </div>

    {{--Start Modal--}}
    <div class="modal fade" id="modal-image" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel">Upload item image,</h4>
                    <p>Please ensure file is in .jpg, .png, .gif format.</p>
                </div>

                <div class="modal-body">
                    <div class="col-md-12 text-center">
                        <div class="form-group">
                        </div>
                    </div>

                    <div class="col-md-12 text-center">
                        <div class="fileinput fileinput-new" data-provides="fileinput">
                            <div class="fileinput-preview thumbnail" data-trigger="fileinput" style="width: 380px; height: 220px;">

                                <img id='user_image_PopUp' src="" alt="Load Image"/>
                            </div>
                            <div data-provides="fileinput">
                        <span class="btn btn-default btn-file">
                            <span class="fileinput-new" data-trigger="fileinput">Select image</span>
                            <span class="fileinput-exists">Change</span>

                            <input id="photo" type="file" name="photo" accept="image.*" />
                            {{--{{ Form::file('nric_front_img') }}--}}
                        </span>
                                {{--<a href="#" class="btn btn-default fileinput-exists" data-dismiss="fileinput">Remove</a>--}}
                            </div>
                        </div>
                    </div>

                    <div class="clearfix"></div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" onclick="changeItemImage()" class="btn btn-default" data-dismiss="modal">Save</button>
                </div>

            </div>
        </div>
    </div>

    <div class="modal fade" id="modal-image-remove" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel">Remove Image !</h4>
                    <p>Please ensure you want to remove this image .</p>
                </div>

                <div class="modal-body">
                    <div class="col-md-12 text-center">
                        <div class="form-group">
                        </div>
                    </div>

                    <div class="col-md-12 text-center">
                        Are you sure want to remove this image ?
                    </div>

                    <div class="clearfix"></div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <button type="button" onclick="removeIMG()" class="btn btn-default" data-dismiss="modal">Yes</button>
                </div>

            </div>
        </div>
    </div>

    <div class="modal fade" id="image_error_fileFormat" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="col-md-12 text-center">
                        <div class="form-group">
                            <label class="font-big-red">You can only upload a .jpg / jpeg / png / gif file format.</label>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="image_error_fileSize" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="col-md-12 text-center">
                        <div class="form-group">
                            <label class="font-big-red">This is not an allowed file size !</label>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    {{--End Modal--}}


    {!! Form::close() !!}
</div>
@stop

@section('page_script')
    <script type="text/javascript">
        $(document).ready(function() {
            //Start Validation for Entry and Edit Form
            $('#city').validate({
                rules: {
                    name                  : 'required',
                    country_id            : 'required',
                    photo                 : 'required',
                },
                messages: {
                    name                  : 'City Name is required',
                    country_id            : 'Country is required',
                    photo                 : 'Photo is required',
                },
                submitHandler: function(form) {
                    $('input[type="submit"]').attr('disabled','disabled');
                    form.submit();
                }
            });
            //End Validation for Entry and Edit Form

            //            Start fileupload js
            $(".add_image_div").click(function(){
                showPopup();
            });

            $("#removeImage").click(function(){
                $('#modal-image-remove').modal();
            });

            $('INPUT[type="file"]').change(function () {

                var ext = this.value.match(/\.(.+)$/)[1];
                var f=this.files[0];
                var fileSize = (f.size||f.fileSize);
                var imgkbytes = Math.round(parseInt(fileSize)/1024);

                if(imgkbytes > 5000){
                    $('#image_error_fileSize').modal('show');
                    //$('#user_image_PopUp').attr('src') = '';
                    $('#user_image_PopUp').attr('src','');
                    $('#user_image').val(null);
                }
                // else{
                switch (ext) {
                    case 'jpg':
                    case 'jpeg':
                    case 'png':
                    case 'gif':
                        break;
                    default:
                        $('#image_error_fileFormat').modal('show');
                        //$('#user_image_PopUp').attr('src') = '';
                        $('#user_image_PopUp').attr('src','');
                        $('#user_image').val(null);
                }
                //}

            });
//            End fileupload js

            //For checkbox picker
            $(':checkbox').checkboxpicker();
        });

        //start js function for fileupload
        function showPopup() {
            $('#modal-image').modal();
        }

        function changeItemImage(){
            var images = $('#modal-image img').attr('src');
            $('.add_image_div').css({"background-image": "url("+images+")", "background-position": "center","background-size":"cover"});
            $('#removeImageFlag').val(0);
        }

        function removeIMG(){
            $('#modal-image img').attr('src','second.jpg');
            $('.add_image_div').css('background-image', 'url()');
            $('#removeImageFlag').val(1);
        }
        //end js function for fileupload
    </script>
@stop