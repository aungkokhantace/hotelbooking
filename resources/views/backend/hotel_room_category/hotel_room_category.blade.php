@extends('layouts.master')
@section('title','Hotel Room Category')
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
    b{
        color:red;
    }
</style>
        <!-- begin #content -->
<div id="content" class="content">

    <h1 class="page-header">{{isset($hotel_room_category) ?  'Hotel Room Category Edit' : 'Hotel Room Category Entry' }}</h1>

    @if(isset($hotel_room_category))
        {!! Form::open(array('url' => '/backend/hotel_room_category/update','id'=>'hotel_room_category', 'class'=> 'form-horizontal user-form-border','files' => true)) !!}

    @else
        {!! Form::open(array('url' => '/backend/hotel_room_category/store','id'=>'hotel_room_category', 'class'=> 'form-horizontal user-form-border','files' => true)) !!}
    @endif
    <input type="hidden" name="id" value="{{isset($hotel_room_category)? $hotel_room_category->id:''}}"/>
    <br/>

    <div class="row">
        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
            <label for="hotel_id">Hotel <span class="require">*</span></label>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
            <select class="form-control" name="hotel_id" id="hotel_id">
                @if(isset($hotel_room_category))
                    @foreach($hotels as $hotel)
                        @if($hotel->id == $hotel_room_category->hotel_id)
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
            <label for="hotel_id">Room Type<span class="require">*</span></label>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
            <select class="form-control" name="h_room_type_id" id="h_room_type_id">
                @if(isset($hotel_room_category))
                    @foreach($hotel_room_type as $type)
                        @if($type->id == $hotel_room_category->h_room_type_id)
                            <option value="{{$type->id}}" selected>{{$type->name}}</option>
                        @else
                            <option value="{{$type->id}}">{{$type->name}}</option>
                        @endif
                    @endforeach
                @else
                    <option value="" disabled selected>Select Room Type</option>
                @endif
            </select>
            <p class="text-danger">{{$errors->first('h_room_type_id')}}
        </div>
    </div>

    <div class="row">
        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
            <label for="name">Name<span class="require">*</span></label>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
            <input type="text" required class="form-control" id="name" name="name"
                   placeholder="Enter Room Category Name" value="{{ isset($hotel_room_category)? $hotel_room_category->name:Request::old('name') }}"/>
            <p class="text-danger">{{$errors->first('name')}}</p>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
            <label for="price">Price<span class="require">*</span></label>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
            <input type="text" required class="form-control" id="price" name="price"
                   placeholder="Enter Price" value="{{ isset($hotel_room_category)? $hotel_room_category->price:Request::old('price') }}"/>
            <p class="text-danger">{{$errors->first('price')}}</p>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
            <label for="square_metre">S.Q.M<span class="require">*</span></label>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
            <input type="text" required class="form-control" id="square_metre" name="square_metre"
                   placeholder="Enter Square Metre" value="{{ isset($hotel_room_category)? $hotel_room_category->square_metre:Request::old('square_metre') }}"/>
            <p class="text-danger">{{$errors->first('square_metre')}}</p>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
            <label for="booking_cutoff_day">Booking CutOff Day<span class="require">*</span></label>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
            <input type="text" required class="form-control" id="booking_cutoff_day" name="booking_cutoff_day"
                   placeholder="Enter Booking CutOff Day" value="{{ isset($hotel_room_category)? $hotel_room_category->booking_cutoff_day:Request::old('booking_cutoff_day') }}"/>
            <p class="text-danger">{{$errors->first('booking_cutoff_day')}}</p>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
            <label for="extra_bed_allowed">Extra Bed Allowed</label>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
            @if(isset($hotel_room_category))
                @if($hotel_room_category->extra_bed_allowed == 1)
                    <input type="checkbox" id="extra_bed_allowed" name="extra_bed_allowed" value="true" checked/>
                @else
                    <input type="checkbox" id="extra_bed_allowed" name="extra_bed_allowed" value="true" />
                @endif
            @else
                <input type="checkbox" id="extra_bed_allowed" name="extra_bed_allowed" value="true" />
            @endif
            <p class="text-danger">{{$errors->first('extra_bed_allowed')}}</p>
        </div>
    </div>

    <div class="row extra_bed_price">
        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
            <label for="extra_bed_price">Extra Bed Price</label>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
            <input type="text" class="form-control" id="extra_bed_price" name="extra_bed_price"
                   placeholder="Enter Extra Bed Price"
                   value="{{ isset($hotel_room_category)? $hotel_room_category->extra_bed_price:Request::old('extra_bed_price') }}"/>
            <p class="text-danger">{{$errors->first('extra_bed_price')}}</p>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
            <label for="capacity">Capacity<span class="require">*</span></label>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
            <input type="text" required class="form-control" id="capacity" name="capacity"
                   placeholder="Enter Capacity"
                   value="{{ isset($hotel_room_category)? $hotel_room_category->capacity:Request::old('capacity') }}"/>
            <p class="text-danger">{{$errors->first('capacity')}}</p>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
            <label for="bed_type">Bed Type<span class="require">*</span></label>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
            <input type="text" required class="form-control" id="bed_type" name="bed_type"
                   placeholder="Enter Bed Type"
                   value="{{ isset($hotel_room_category)? $hotel_room_category->bed_type:Request::old('bed_type') }}"/>
            <p class="text-danger">{{$errors->first('bed_type')}}</p>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
            <label for="description">Description</label>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
            <textarea rows="5" cols="50" class="form-control" id="description" name="description" placeholder="Enter Room Category Description">{{ isset($hotel_room_category)? $hotel_room_category->description:Request::old('description') }}</textarea>
            <p class="text-danger">{{$errors->first('description')}}</p>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
            <label for="remark">Remark</label>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
            <textarea rows="5" cols="50" class="form-control" id="remark" name="remark" placeholder="Enter Remark For Booking CutOff Day">{{ isset($hotel_room_category)? $hotel_room_category->remark:Request::old('remark') }}</textarea>
            <p class="text-danger">{{$errors->first('remark')}}</p>
        </div>
    </div>

    {{-- Start Image --}}
    @if(isset($images) && count($images) > 0)

        <div class="row">
            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
                <label for="image">Image</label>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                @foreach($images as $image)
                    <div id="filediv">
                        <div id='abcd' class='abcd'>
                            <input type="hidden" name="file_id[]" value="{{$image->id}}"/>
                            <input name="file[]" type="file" id="file" value="{{$image->img_path}}" class="file-hide"/>
                            <img id='previewimg' src='{{$image->img_path}}'/>
                            <input type="button" id="remove-img{{$image->id}}" value="Remove" class="btn btn-default remove-img">
                        </div>
                    </div>
                    <br/>
                @endforeach
                <div id="filediv"><input name="file[]" type="file" id="file"/></div><br/>

                <input type="button" id="add_more" class="upload" value="Add Image"/>
            </div>
        </div>
    @else
        <div class="row">
            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
                <label for="image">Image</label>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">

                <div id="filediv"><input name="file[]" type="file" id="file"/></div><br/>

                <input type="button" id="add_more" class="upload" value="Add Image"/>
            </div>
        </div>
    @endif
    {{-- End Image --}}

    <div class="row">
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
        </div>
        <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1">
            <input type="submit" name="submit" value="{{isset($hotel_room_category)? 'UPDATE' : 'ADD'}}" class="form-control btn-primary">
        </div>
        <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1">
            <input type="button" value="CANCEL" class="form-control cancel_btn" onclick="cancel_setup('hotel_room_category')">
        </div>
    </div>

    {!! Form::close() !!}
</div>
@stop

@section('page_script')
    <script type="text/javascript">
        var count = 0;      // Declaring and defining global increment variable.
        $(document).ready(function(){

            $('#hotel_id').change(function(e){
                loadHotelRoomType($(this).val());
            });

            if (document.getElementById('extra_bed_allowed').checked)
            {
                //If Extra Bed Allowed is checked, show Extra Bed Price
                $(".extra_bed_price").show();
            } else {
                //If not, hide Extra Bed Price
                $(".extra_bed_price").hide();
            }

            //Whenever Extra Bed Allowed change, 
            $(':checkbox').change(function() {
                if (document.getElementById('extra_bed_allowed').checked)
                {
                    $(".extra_bed_price").show();
                } else {
                    $('#extra_bed_price').val("");
                    $(".extra_bed_price").hide();
                }
            });

            //Start Validation for Entry and Edit Form
            $('#hotel_room_category').validate({
                rules: {
                    hotel_id            : 'required',
                    h_room_type_id      : 'required',
                    name                : 'required',
                    price               : 'required',
                    square_metre        : 'required',
                    booking_cutoff_day  : 'required',
                    capacity            : 'required',
                    bed_type            : 'required',

                },
                messages: {
                    hotel_id            : 'Hotel is required',
                    h_room_type_id      : 'Room Type is required!',
                    name                : 'Name is required!',
                    price               : 'Price is required!',
                    square_metre        : 'S.Q.M is required!',
                    booking_cutoff_day  : 'Booking CutOff Day is required!',
                    capacity            : 'Capacity is required!',
                    bed_type            : 'Bed Type is required!',
                },
                submitHandler: function(form) {
                    $('input[type="submit"]').attr('disabled','disabled');
                    form.submit();
                }
            });
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
                    count += 1; // Incrementing global variable by 1.
                    var z = count - 1;
                    var x = $(this).parent().find('#previewimg' + z).remove();
                    $(this).before("<div id='abcd" + count + "' class='abcd'><img id='previewimg" + count + "' src=''/></div>");
                    var reader = new FileReader();
                    reader.onload = imageIsLoaded;
                    reader.readAsDataURL(this.files[0]);
                    $(this).hide(); //Hide chose file button
                    //Remove Button
                    $("#abcd" + count).append($("<input/>", {
                        type: 'button',
                        id: 'remove',
                        value: 'Remove',
                        class: 'btn btn-default'
                    }).click(function() {
                        $(this).parent().parent().remove();
                    }));
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
        });
        function loadHotelRoomType(hotelId){
            $.ajax({
                type: "GET",
                url: "/backend/hotel_room_type/get_room_type/"+hotelId,
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