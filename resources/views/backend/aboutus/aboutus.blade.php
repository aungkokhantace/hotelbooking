@extends('layouts.master')
@section('title','About Us Edit')
@section('content')

        <!-- begin #content -->
<div id="content" class="content">

    <h1 class="page-header">About Us Edit</h1>
    {!! Form::open(array('url' => '/backend_mps/about_us', 'class'=> 'form-horizontal user-form-border','files' => true)) !!}
    <input type="hidden" name="_token" value="{{ csrf_token() }}">

    <div class="row">
        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
            <label for="description" class="text_bold_black">About Us Text [English]</label>
        </div>
        <div class="col-lg-10 col-md-10 col-sm-10 col-xs-10">
            <textarea class="form-control text-area" id="description_en" name="description_en" placeholder="Enter About Us Text in English" rows="5" cols="50">{{ isset($aboutUs)? $aboutUs["description_en"]:Request::old('description_en') }}</textarea>
            <p class="text-danger">{{$errors->first('description_en')}}</p>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
            <label for="description" class="text_bold_black">About Us Text [Japanese]</label>
        </div>
        <div class="col-lg-10 col-md-10 col-sm-10 col-xs-10">
            <textarea class="form-control text-area" id="description_jp" name="description_jp" placeholder="Enter About Us Text in Japanese" rows="5" cols="50">{{ isset($aboutUs)? $aboutUs["description_jp"]:Request::old('description_jp') }}</textarea>
            <p class="text-danger">{{$errors->first('description_jp')}}</p>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-10 col-md-10 col-sm-10 col-xs-10">
        </div>
        <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1">
            <input type="submit" name="submit" value="{{isset($aboutUs)? 'UPDATE' : 'ADD'}}" class="form-control btn-primary">
        </div>
        <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1">
            <input type="button" value="CANCEL" class="form-control cancel_btn" onclick="cancel_setup('about_us')">
        </div>
    </div>
    {!! Form::close() !!}
</div>
@stop

@section('page_script')
    <script>
        $(document).ready(function() {
//        $('#description').summernote({
//            height:300
//        });

            $('.text-area').summernote({
                height:300,
                toolbar: [
                    // [groupName, [list of button]]
                    ['style', ['style']],
                    ['style', ['bold', 'italic', 'underline', 'clear']],
                    ['font', ['strikethrough', 'superscript', 'subscript']],
                    ['fontsize', ['fontsize']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['height', ['height']],
                    ['picture', ['picture']],
                    ['link', ['link']],
                    ['table', ['table']],
                    ['hr', ['hr']],
                    ['codeview', ['codeview']],
                    ['undo', ['undo']],
                    ['redo', ['redo']],
//                ['help', ['help']],
              ],
              placeholder: 'Enter text here...'
            });
        });

        function saveConfig(action) {
            var rate = $("#SETTING_TAXRATE").val();
            $("#error_lbl_SETTING_TAXRATE").text("");
            var errorCount = 0;
            if(isNaN(rate)){
                $("#error_lbl_SETTING_TAXRATE").text("Invalid Tax Rate !. It allow Number only !");
                errorCount++;
            }

            if(errorCount>0) {
                return;
            }
            else{
                $("#backend_posconfigs").submit();
            }
        }

    </script>
@stop
