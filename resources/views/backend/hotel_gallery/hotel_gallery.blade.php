@extends('layouts.master')
@section('title','Hotel Gallery')
@section('content')
<style>
    .upload{
        /*background-color:#ff0000;*/
        border:1px solid #2a72b5;
        color:#000;
        border-radius:5px;
        padding:10px;
        /*text-shadow:1px 1px 0px green;*/
        box-shadow: 2px 2px 15px rgba(0,0,0, .75);
    }
    .upload:hover{
        cursor:pointer;
        background:#2a72b5;
        color: #fff;
        border:1px solid #2a72b5;
        box-shadow: 0px 0px 5px rgba(0,0,0, .75);
    }
    #file{
        color:green;
        padding:5px; border:1px dashed #123456;
        background-color: #f9ffe5;
    }
    #upload{
        margin-left: 45px;
    }

    #noerror{
        color:green;
        text-align: left;
    }
    #error{
        color:red;
        text-align: left;
    }
    #img{
        width: 25px;
        border: none;
        height:25px;
        margin-left: -24px;
        margin-bottom: 165px;
    }

    .abcd img{
        height:200px;
        width:200px;
        padding: 5px;
        border: 1px solid rgb(232, 222, 189);
    }

</style>
        <!-- begin #content -->
<div id="content" class="content">

    <h1 class="page-header">{{isset($hotel) ? trans('setup_hotelgallery.title-edit') : trans('setup_hotelgallery.title-entry')}}</h1>

    @if(isset($hotel))
        {!! Form::open(array('url' => '/backend_mps/hotel_gallery/update','id'=>'hotel_gallery', 'class'=> 'form-horizontal user-form-border','files' => true)) !!}

    @else
        {!! Form::open(array('url' => '/backend_mps/hotel_gallery/store','id'=>'hotel_gallery', 'class'=> 'form-horizontal user-form-border','files' => true)) !!}
    @endif
    <input type="hidden" name="id" value="{{isset($hotel)? $hotel->id:0}}"/>
    <br/>

    <div class="row">
        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
            <label for="hotel_id">{{trans('setup_hotelgallery.hotel')}}
                <span class="require">*</span>
            </label>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">        
            @if ($role == 3)
            <select class="form-control" name="hotel_id" id="hotel_id">
                @foreach($hotels as $hotel)
                <option value="{{$hotel->id}}" selected>{{$hotel->name}}</option>
                @endforeach
                </select>
            @else
                @foreach($hotels as $hotel)
                    @if($hotel_id == $hotel->id)
                    <select class="form-control" name="hotel_id" id="hotel_id">
                            <option value="{{$hotel->id}}" selected >{{$hotel->name}}</option>
                    </select>
                    @endif
                @endforeach
            @endif               
            <p class="text-danger">{{$errors->first('hotel_id')}}
        </div>
    </div>

    {{-- Start Image --}}
    @if(isset($images) && count($images) > 0)
        <div class="row">
            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
                <label for="image">{{trans('setup_hotelgallery.image')}}</label>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                <label class="notice">(Image must be 500*300 pixels)</label>
                @foreach($images as $image)
                    <div id="filediv">
                        <div id='abcd' class='abcd'>
                            <input type="hidden" name="file_id[]" value="{{$image->id}}"/>
                            <input name="file[]" type="file" id="file" value="{{$image->img_path}}" class="file-hide"/>
                            <img id='previewimg' src='/images/upload/{{$image->image}}'/>
                            <input type="button" id="remove-img{{$image->id}}" value="Remove" class="btn btn-default remove-img">
                        </div>
                    </div>
                    <br/>
                @endforeach

                <div id="filediv"><input name="file[]" type="file" id="file"/></div><br/>

                <input type="button" id="add_more" class="upload" value="{{trans('setup_hotelgallery.btn-image')}}"/>
            </div>
        </div>
    @else
        <div class="row">
            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
                <label for="image">{{trans('setup_hotelgallery.image')}}</label>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                <label class="notice">(Image must be 500*300 pixels)</label>
                <div id="filediv"><input name="file[]" type="file" id="file"/></div><br/>

                <input type="button" id="add_more" class="upload" value="{{trans('setup_hotelgallery.btn-image')}}"/>
            </div>
        </div>
    @endif
    {{-- End Image --}}
    <br>
    
    <div class="row">
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
        </div>
        <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1">
            <!-- <input type="submit" name="submit" value="{{isset($hotel)? trans('setup_hotelgallery.btn-update') : trans('setup_hotelgallery.btn-add')}}" class="form-control btn-primary"> -->
            <input type="submit" name="submit" value="{{isset($hotel)? trans('setup_hotelgallery.btn-add') : trans('setup_hotelgallery.btn-add')}}" class="form-control btn-primary">
        </div>
        <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1">
            <input type="button" value="{{trans('setup_hotelgallery.btn-cancel')}}" class="form-control cancel_btn" onclick="cancel_setup('hotel_gallery')">
        </div>
    </div>

    {!! Form::close() !!}
</div>
@stop

@section('page_script')
    <script type="text/javascript">
        var count = 0;      // Declaring and defining global increment variable.
        $(document).ready(function(){

            var hotel_id    = document.getElementById('hotel_id').value;
            var room        = $('input[type="hidden"][name="id"]').val();

            if (hotel_id > 0 && room <= 0) {
                loadHotelRoomType(hotel_id);
            }

            $('#hotel_id').change(function(e){
                loadHotelRoomType($(this).val());
            });

            //Start Validation for Entry and Edit Form
//             $('#hotel_gallery').validate({
//                 rules: {
//                     // hotel_id            : 'required',
//                     h_room_type_id      : 'required',
//                     name                : 'required',
//                     price               : {
//                         required    : true,
//                         number      : true
//                     },
//                     square_metre        : {
//                         required    : true,
//                         number      : true
//                     },
//                     booking_cutoff_day  : 'required',
//                     capacity            : {
//                         required  : true,
//                         number    : true  

//                     },
//                     bed_type            : 'required',
//                     extra_bed_price     : 'required',
// //                    'file[]'            : {
// //                        required: true,
// //                        minlength: 1,
// //                    }

//                 },
//                 messages: {
//                     hotel_id            : 'Hotel is required',
//                     h_room_type_id      : 'Room Type is required!',
//                     name                : 'Name is required!',
//                     price               : {
//                         required    : 'Price is required!',
//                         number      : 'Please enter a valid number!'
//                     },
//                     square_metre        : {
//                         required    : 'S.Q.M is required!',
//                         number      : 'Please enter a valid number!'
//                     },
//                     booking_cutoff_day  : 'Booking CutOff Day is required!',
//                     capacity            : {
//                         required    : 'Capacity is required!',
//                         number      : 'Please enter a valid number!'
//                     },
//                     bed_type            : 'Bed Type is required!',
//                     extra_bed_price     : 'Extra bed price is required!'
//                 },
//                 submitHandler: function(form) {
//                     $('input[type="submit"]').attr('disabled','disabled');
//                     form.submit();
//                 }
//             });
            //End Validation for Entry and Edit Form


            /* Start multi image */
            //  To add new input file field dynamically, on click of "Add More Files" button below function will be executed.
            $('#add_more').click(function() {
                $(this).before($("<div/>", {
                    id: 'filediv'
                }).fadeIn('slow').append($("<input/>", {
                    name: 'file[]',
                    type: 'file',
                    id: 'file'
                }), $("<br/>")));
            });
            // Following function will executes on change event of file input to select different file.
            $('body').on('change', '#file', function() {
                if (this.files && this.files[0]) {
                    //Start File type validation
                    var fileExtension = ['jpeg', 'jpg', 'png', 'gif', 'bmp'];
                    if ($.inArray($(this).val().split('.').pop().toLowerCase(), fileExtension) == -1) {
                        alert("Only '.jpeg','.jpg', '.png', '.gif', '.bmp' formats are allowed.");
                        $(this).next().remove();
                        $(this).parent().append("<p class='error'>Only '.jpeg','.jpg', '.png', '.gif', '.bmp' formats are allowed.</p><br>");
                        $('input[type="submit"]').attr('disabled','disabled');
                    }
                    //End File type validation
                    else{
                        count += 1; // Incrementing global variable by 1.
                        var z = count - 1;
                        var x = $(this).parent().find('#previewimg' + z).remove();
                        $(this).before("<div id='abcd" + count + "' class='abcd'><img id='previewimg" + count + "' src=''/></div>");
                        var reader = new FileReader();
                        reader.onload = imageIsLoaded;
                        reader.readAsDataURL(this.files[0]);
                        $(this).hide(); //Hide choose file button
                        //Remove Button
                        $("#abcd" + count).append($("<input/>", {
                            type: 'button',
                            id: 'remove',
                            value: 'Remove',
                            class: 'btn btn-default'
                        }).click(function() {
                            $(this).parent().parent().remove();
                        }));
                        $(this).next().remove();
                        $("input[type=submit]").removeAttr('disabled');
                    }
                }
            });
    // To Preview Image
            function imageIsLoaded(e) {
                $('#previewimg' + count).attr('src', e.target.result);
            };
            $('#upload').click(function(e) {
                var name = $(":file").val();
                if (!name) {
                    alert("First Image Must Be Selected");
                    e.preventDefault();
                }
            });
            $('.file-hide').hide();
            //Remove Button For Edit Button
            $('.remove-img').live('click',function(){
                var id = $(this).attr('id');
                $('#'+id).parent().parent().remove();

            });

            /* End multi image */

            $(':checkbox').checkboxpicker();
        });
        function loadHotelRoomType(hotelId){
            $.ajax({
                type: "GET",
                url: "/backend_mps/hotel_room_type/get_room_type/"+hotelId,
            }).done(function( result ) {
                $("#h_room_type_id").empty();//To reset states
                $("#h_room_type_id").append("<option selected disabled>Select Room Type</option>");
                $(result).each(function(){
                    $("#h_room_type_id").append($('<option>', {
                        value: this.id,
                        text: this.name,
                    }));
                })
            });
        }

    </script>
@stop