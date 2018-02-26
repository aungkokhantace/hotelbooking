@extends('layouts_frontend.master_frontend')
@section('title','Hotel Detail')
@section('content')
    <div id="header_id">
        <img class="img-responsive img-hover" src="/assets/shared/images/slider1.png">
    </div>
    </div>

    </section>

    <section id="popular">
        <!-- Page Content -->
        <div class="container">
            <div class="row">
                <!-- Blog Sidebar Widgets Column -->
                <div class="col-md-3">
                    <!-- Blog Search Well -->
                    <div class="bg_block_sm pd_10">
                        <div class="side_title">
                            <h5>{{trans('frontend_search.search_hotel')}}</h5>
                        </div>
                        <p></p>
                        @include('layouts_frontend.partial_frontend.search_form')
                        {!! Form::close() !!}
                    </div>
                </div>

                <!-- Blog Entries Column -->
                <div class="col-md-9">
                    <!-- First Blog Post Left -->
                    <div class="search_list">
                        <h2>{{$hotel->name}}</h2>
                        <p class="lead">
                            {{$hotel->address}}
                        </p>
                    </div>
                    <!-- First Blog Post Right -->
                    <!-- <div class="detail_righttwo">
                        <samp>6378 reviews</samp>
                        <samp>Excellent 8.3</samp>
                    </div> -->
                    <div class="detail_rightone">
                        @if(isset($hotel->discount) && $hotel->discount != null)
                            <samp>{{$hotel->discount}} off</samp>
                        @endif
                    </div>
                    <div id="jssor_main" class="slider_one">
                        <!-- <div data-u="slides" class="slider_images">
                            @if(isset($roomCategoryImages) && count($roomCategoryImages)>0)
                                @foreach($roomCategoryImages as $roomCategoryImage)
                                    <div>
                                        <img data-u="image" src="{{$roomCategoryImage->img_path}}" />
                                        <img data-u="thumb" src="{{$roomCategoryImage->img_path}}" />
                                    </div>
                                @endforeach
                            @else
                                <div>
                                    <img data-u="image" src="/images/upload/{{$hotel->logo}}" />
                                    <img data-u="thumb" src="/images/upload/{{$hotel->logo}}" />
                                </div>
                            @endif
                        </div> -->
                        <div data-u="slides" class="slider_images">
                            @if(isset($hotelGalleryImages) && count($hotelGalleryImages)>0)
                                @foreach($hotelGalleryImages as $hotelGalleryImage)
                                    <div>
                                        <img data-u="image" src="/images/upload/{{$hotelGalleryImage->image}}" />
                                        <img data-u="thumb" src="/images/upload/{{$hotelGalleryImage->image}}" />
                                    </div>
                                @endforeach
                            @else
                                <div>
                                    <img data-u="image" src="/images/upload/{{$hotel->logo}}" />
                                    <img data-u="thumb" src="/images/upload/{{$hotel->logo}}" />
                                </div>
                            @endif
                        </div>
                        <div data-u="slides" class="slider_imagess">
                            <div>
                                <img data-u="image" src="/images/upload/{{$hotel->logo}}"  width="100%" height="125px" />
                            </div>
                            <p></p>
                            <div>
                                {{--<iframe src="https://www.google.com/maps/embed?pb=!1m10!1m8!1m3!1d244315.84058469086!2d96.1695098!3d16.903821!3m2!1i1024!2i768!4f13.1!5e0!3m2!1sen!2smm!4v1490344960699" width="100%" height="120" frameborder="0" style="border:1px solid #ccc;padding:3px;" allowfullscreen></iframe>--}}
                                <div id="map" style="width: 100%; height: 122px;"></div>
                            </div>
                        </div>
                        <!-- Thumbnail Navigator -->
                        <div data-u="thumbnavigator" class="jssort01" style="position:absolute;left:0px;bottom:0px;width:800px;height:100px;" data-autocenter="1">
                            <!-- Thumbnail Item Skin Begin -->
                            <div data-u="slides" >
                                <div data-u="prototype" class="p">
                                    <div class="w">
                                        <div data-u="thumbnailtemplate" class="t"></div>
                                    </div>
                                    <div class="c"></div>
                                </div>
                            </div>
                            <!-- Thumbnail Item Skin End -->
                        </div>
                    </div>
                    <div class="height_space"></div>
                    <div class="detail_text">
                        <p>{{$hotel->description}}</p>
                    </div>

                    <input type="hidden" id="token" name="token" value="{{ csrf_token() }}">
                    <input type="hidden" id="latitude" name="latitude" value="{{isset($hotel)? $hotel->latitude:''}}"/>
                    <input type="hidden" id="longitude" name="longitude" value="{{isset($hotel)? $hotel->longitude:''}}"/>

                    <!-- Service Blocks -->
                    <div class="row margin-bottom-30">
                        <div class="col-md-6">
                            <div class="service">
                                <img class="fa fa-university service-icon" src="/assets/shared/images/main.jpg">
                                <div class="desc">
                                    <h4>{{trans('frontend_details.features')}}</h4>
                                    <ul>
                                        @foreach($hFeatures as $hFeature)
                                            <li><i class="fa fa-check-square-o" aria-hidden="true"></i>{{$hFeature->feature->name}}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="service">
                                <img class="fa fa-university service-icon" src="/assets/shared/images/around.jpg">
                                <div class="desc">
                                    <h4>{{trans('frontend_details.whats_around')}}</h4>
                                    <ul>
                                        @foreach($nearby_array as $nearby)
                                        <li><i class="fa fa-check-square-o" aria-hidden="true"></i>{{$nearby["name"]}} ({{$nearby["category"]}}) - {{$nearby["distance"]}}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div><!-- End Service Blocks -->
                    <!-- Start Hotel Restaurant Block -->
                    <div class="row margin-bottom-30">
                        <div class="col-md-11">
                            <div class="service">
                                <!-- <img class="fa fa-university service-icon" src="/assets/shared/images/knife_fork.png"> -->
                                <span class="fa fa-cutlery service-icon"></span>
                                <div class="desc">
                                    <h4>{{trans('frontend_details.restaurants')}}</h4>
                                    <ul>
                                        @foreach($restaurantCategoryArr as $category)
                                            <li style="text-align:left; float:left">
                                               <h4> {{$category->name}}</h4>
                                                <ul >
                                                @foreach($category->restaurants as $res)
                                                <li> <h6 class="res_name"> <i class="fa fa-check-square-o" aria-hidden="true"></i> {{$res->name}}</h6></li>
                                                <table>

                                                 </tr>
                                                 <tr>
                                                    <td class="resdetail"> <i class="fa fa-hand-o-right" style="color:#f384AA"></i>   Open
                                                    </td>
                                                    <td> <i class="fa fa-arrow-circle-right" style="color:pink"></i> {{$res->opening_hours}}
                                                    </td>
                                                 </tr>
                                                 <tr>
                                                    <td class="resdetail"> <i class="fa fa-hand-o-right" style="color:#f384AA"></i>  Close
                                                    </td>
                                                    <td><i class="fa fa-arrow-circle-right" style="color:pink"></i> {{$res->closing_hours}}
                                                    </td>
                                                 </tr>
                                                 <tr>
                                                    <td class="resdetail"> <i class="fa fa-hand-o-right" style="color:#f384AA"></i>  Open Days
                                                    </td>
                                                     <td>
                                                        <i class="fa fa-arrow-circle-right" style="color:pink"></i> {{$res->opening_days}}
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td class="resdetail"> <i class="fa fa-hand-o-right" style="color:#f384AA"></i>  Capacity
                                                    </td>
                                                     <td>
                                                        <i class="fa fa-arrow-circle-right" style="color:pink"></i> {{$res->capacity}} persons
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td class="resdetail"> <i class="fa fa-hand-o-right" style="color:#f384AA"></i>  Area
                                                    </td>
                                                     <td>
                                                        <i class="fa fa-arrow-circle-right" style="color:pink"></i> {{$res->area}} sqm
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td class="resdetail"> <i class="fa fa-hand-o-right" style="color:#f384AA"></i>  Floor
                                                    </td>
                                                     <td>
                                                        <i class="fa fa-arrow-circle-right" style="color:pink"></i> {{$res->floor}}
                                                    </td>
                                                </tr>
                                             @if(count($res->private_room )> 0 && $res->private_room==1)
                                                <tr>
                                                    <td class="resdetail"> <i class="fa fa-hand-o-right" style="color:#f384AA"></i>  Private Room
                                                    </td>
                                                     <td>
                                                        <i class="fa fa-arrow-circle-right" style="color:pink"></i> Included
                                                    </td>
                                                </tr>
                                             @endif

                                             @if(str_word_count($res->description) > 0 && str_word_count($res->description)!=0)
                                                <tr>
                                                    <td class="resdetail"> <i class="fa fa-hand-o-right" style="color:#f384AA"></i>  Description
                                                    </td>
                                                     <td>
                                                        <i class="fa fa-arrow-circle-right" style="color:pink"></i> {{$res->description}}
                                                    </td>
                                                </tr>
                                              @endif
                                              @if(str_word_count($res->remark) > 0 && str_word_count($res->remark)!=0)
                                               <tr>
                                                    <td class="resdetail"> <i class="fa fa-hand-o-right" style="color:#f384AA"></i>   Remark
                                                    </td>
                                                     <td>
                                                        <i class="fa fa-arrow-circle-right" style="color:pink"></i> {{$res->remark}}
                                                    </td>
                                                </tr>
                                               @endif
                                                  </table>


                                                @endforeach
                                                </ul>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End Hotel Restaurant Block -->
                    <hr>
                    <div class="table-responsive room_table">
                        <h3>{{trans('frontend_details.available_rooms')}}</h3>
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th width="150px">{{trans('frontend_details.room_category')}}</th>
                                <th width="220px">{{trans('frontend_details.included')}}</th>
                                <th width="65px">{{trans('frontend_details.capacity')}}</th>
                                <th width="130px">{{trans('frontend_details.price_per_night')}}</th>
                                <th width="80px">{{trans('frontend_details.rooms')}}</th>
                                <th width="110px">{{trans('frontend_details.booking')}}</th>
                            </tr>
                            </thead>
                            <tbody>
                            {!! Form::open(array('url' => '/enter_details','files'=>true, 'id'=>'frm_booking', 'class'=> 'form-horizontal user-form-border')) !!}
                            {{ csrf_field() }}

                            <?php
                            $default    = 0;
                            ?>
                            {{--  @if($room_availables_count != 0)  --}}
                            @if($total_available_room != 0)
                            @foreach($roomCategories as $roomCategory)
                                @if($roomCategory->available_room_count > 0)
                                <!-- <input type="hidden" id="available_room_categories" name="available_room_categories[]" value="{{$roomCategory->id }}"> -->
                                <input type="hidden" name="available_room_categories[]" value="{{$roomCategory->id }}">
                                <tr>
                                    <td>
                                        <ul class="fa-ul">
                                            <li class="title_fa">
                                                <a href="#myModal-{{$roomCategory->id}}" data-toggle="modal" id="{{ $roomCategory->id }}" class="insertcolumn" onclick="myFunction({{ $roomCategory->id }})">{{$roomCategory->name}}</a>
                                                <?php
                                                    $default    = $default + 1;
                                                ?>
                                                <input type="hidden" id="slider-{{ $default }}" name="slider-input" value="{{ $roomCategory->id }}" />
                                                <!-- Start Modal -->
                                                <div class="modal fade" id="myModal-{{$roomCategory->id}}" role="dialog">
                                                    <div class="modal-dialogs modal-lg">

                                                        <!-- Modal content Start-->
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                            </div>
                                                            <div class="modal-body">

                                                                <div id="jssor_{{ $roomCategory->id }}" class="slider_two">
                                                                    <div data-u="slides" class="slider_images_two">
                                                                    @if(isset($roomCategory->images) && count($roomCategory->images)>0)
                                                                        @foreach($roomCategory->images as $image)
                                                                            <div>
                                                                                <img data-u="image" src="/images/upload/{{$image->img_path}}" />
                                                                                <img data-u="thumb" src="/images/upload/{{$image->img_path}}" />
                                                                            </div>
                                                                        @endforeach
                                                                    @else
                                                                        <div>
                                                                            <img data-u="image" src="/images/upload/{{$hotel->logo}}" />
                                                                            <img data-u="thumb" src="/images/upload/{{$hotel->logo}}" />
                                                                        </div>
                                                                    @endif
                                                                    </div>
                                                                    <!-- Thumbnail Navigator -->
                                                                    <div data-u="thumbnavigator" class="jssort01" style="position:absolute;left:0px;bottom:0px;width:250px;height:100px;" data-autocenter="1">
                                                                        <!-- Thumbnail Item Skin Begin -->
                                                                        <div data-u="slides" >
                                                                            <div data-u="prototype" class="p">
                                                                                <div class="w">
                                                                                    <div data-u="thumbnailtemplate" class="t"></div>
                                                                                </div>
                                                                                <div class="c"></div>
                                                                            </div>
                                                                        </div>
                                                                        <!-- Thumbnail Item Skin End -->
                                                                    </div>
                                                                </div>
                                                                <div class="detailmodal_text">
                                                                    <h4>{{trans('frontend_details.category_name')}} : {{$roomCategory->name}}</h4>
                                                                    <h4>{{trans('frontend_details.price_per_night')}} : {{$currency.' '.$roomCategory->price}}
                                                                    {{' + '.$gst.'%'.'(Government Tax)'}}{{' + '.$service_tax.'%'.'(Service Charge)'}}</h4>
                                                                    <h4>{{trans('frontend_details.room_size')}} : {{$roomCategory->square_metre}} m<sup>2</sup></h4>
                                                                    <h4>{{trans('frontend_details.bed_type')}} : {{$roomCategory->bed_types_string}}</h4>
                                                                    <!-- @foreach($roomCategory->bed_types as $bed_type)
                                                                      <h4>{{trans('frontend_details.bed_type')}} : {{$bed_type->name}}</h4>
                                                                    @endforeach -->
                                                                    <h4>{{trans('frontend_details.extra_bed')}} : {{$roomCategory->extra_bed_allowed}}</h4>
                                                                    <h5>{{trans('frontend_details.description')}}</h5>
                                                                    <p>{{$roomCategory->description}}</p>
                                                                </div>
                                                                <div class="detailmodal_text row">
                                                                    <div class="col-md-12">
                                                                      <h4>{{trans('frontend_details.room_facilties')}}</h4>
                                                                      <ul class="room_facilities">
                                                                          @if(isset($roomCategory->facilities) && count($roomCategory->facilities) > 0)
                                                                              @foreach($roomCategory->facilities as $room_category_facility)
                                                                                  <div class="col-md-3">
                                                                                      <li class="text_fa"><a href="#" data-toggle="tooltip" data-placement="top" title="{{$room_category_facility->facility}}">{{$room_category_facility->facility->name}}</a></li>
                                                                                  </div>
                                                                              @endforeach
                                                                          @endif
                                                                      </ul>
                                                                    </div>
                                                                </div>
                                                                <br>
                                                                <hr>
                                                                <div class="detailmodal_text row">
                                                                    <div class="col-md-12">
                                                                      <h4>{{trans('frontend_details.room_amenities')}}</h4>
                                                                      <ul class="room_facilities">
                                                                          @if(isset($roomCategory->room_amenities) && count($roomCategory->room_amenities) > 0)
                                                                              @foreach($roomCategory->room_amenities as $room_amenity)
                                                                                  <div class="col-md-3">
                                                                                      <li class="text_fa">{{$room_amenity->amenity->name}}</li>
                                                                                  </div>
                                                                              @endforeach
                                                                          @endif
                                                                      </ul>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="modal-footer"></div>
                                                        </div>
                                                        <!-- Modal content End-->

                                                    </div>
                                                </div>
                                                <!-- End Modal -->
                                            </li>
                                            <!-- <li><img class="fa-lis" src="/assets/shared/images/cityview.png">View</li> -->
                                            <li><img class="fa-lis" src="/assets/shared/images/16sqm.png">{{$roomCategory->square_metre}} s.q.m</li>
                                            @foreach($roomCategory->bed_types as $bed_type)
                                              <li><img class="fa-lis" src="/assets/shared/images/signlebed.png">{{trans('frontend_details.bed')}} : {{$bed_type->name}}</li>
                                            @endforeach
                                            <li><img class="fa-lis" src="/assets/shared/images/signlebed.png">{{trans('frontend_details.extra_bed')}}: {{$roomCategory->extra_bed_allowed}}</li>
                                            <li><img class="fa-lis" src="/assets/shared/images/breakfast.png">{{trans('frontend_details.breakfast')}} : {{$roomCategory->breakfast_included}}</li>
                                        </ul>
                                    </td>
                                    <td>
                                        <ul class="fa-ul price_night">
                                            @foreach($roomCategory->display_room_amenities as $display_room_amenity)
                                                <li><i class="fa fa-check-square-o" aria-hidden="true"></i>{{$display_room_amenity->amenity->name}}</li>
                                            @endforeach
                                            @if($roomCategory->room_amenities_count > 5)
                                              <li><a href="#myModal-{{$roomCategory->id}}" data-toggle="modal" id="{{ $roomCategory->id }}" class="insertcolumn" onclick="myFunction({{ $roomCategory->id }})">{{trans('frontend_details.more')}}>></a></li>
                                            @endif
                                        </ul>
                                    </td>
                                    <td>
                                        @for ($i = 1; $i <= $roomCategory->capacity; $i++)
                                            <i class="fa-td fa fa-user" aria-hidden="true"></i>
                                        @endfor

                                    </td>
                                    <td>
                                        <ul class="fa-ul price_night">
                                            <li>
                                                {{$currency.' '.$roomCategory->price}}<br>
                                                {{'+'.$gst.'%'.'(Government Tax)'}}<br>
                                                {{'+'.$service_tax.'%'.'(Service Charge)'}}
                                            </li>
                                        </ul>
                                    </td>
                                    <td>
                                        <!-- <input type="number" name="number_{{$roomCategory->id}}" id="number_{{$roomCategory->id}}" class="floatLabel form-control" min="0" max="{{$roomCategory->available_room_count}}"> -->
                                        <select class="form-control" name="number_{{$roomCategory->id}}" id="number_{{$roomCategory->id}}">
                                            <option value="0">0</option>
                                            @for($i = 1; $i <= $roomCategory->available_room_count; $i++)
                                                <option value="{{$i}}">{{$i}}</option>
                                            @endfor
                                        </select>
                                    </td>

                                    @if(isset($book_now_flag) && $book_now_flag == 1)
                                        <td rowspan="{{count($roomCategories)}}">
                                            <input type="button" class="btn btn-primary" value="{{trans('frontend_search.book_now')}}" onclick="book();">
                                            <?php $book_now_flag = 0; ?>
                                        </td>
                                    @endif
                                </tr>
                                @endif
                            @endforeach
                            @else
                                    <tr>
                                        <td colspan="6"><h5 align="center">No Available Room</h5></td>
                                    </tr>
                            @endif
                            {!! Form::close() !!}
                            </tbody>
                        </table>
                    </div>


                    <div class="room_table">
                        <h3>Facilities of {{$hotel->name}}</h3>
                        <div class="row margin-bottom-30">
                            @foreach($facilityGroupArray as $facilityGroup)
                                @if(isset($facilityGroup->facilities) && count($facilityGroup->facilities)>0)
                                    <div class="col-md-4">
                                        <div class="service">
                                            <i class="fa fa-check service-icons" aria-hidden="true"></i>
                                            <div class="desc">
                                                <h5>{{$facilityGroup->name}}</h5>
                                                <ul class="fa-ul-li">
                                                    @foreach($facilityGroup->facilities as $facility)
                                                        <li  data-toggle="tooltip" data-placement="top" title="{{$facility->facility->description}}"><i class="fa fa-check-square-o" aria-hidden="true"></i>{{$facility->facility->name}}</li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        </div><!-- End Service Blocks -->
                    </div>
                    <hr>
                    <div class="room_table">
                        <h3>{{trans('frontend_details.area_info')}} : </h3>
                        <!-- Service Blocks -->
                        <div class="row margin-bottom-30">
                            <div class="col-md-6">
                                <div class="service">
                                    <img class="service-icon" src="/assets/shared/images/closet.png">
                                    <div class="desc">
                                        <h4> {{trans('frontend_details.closest_landmarks')}}</h4>
                                        <ul class="fa-ul-li">
                                            @foreach($landmarks as $landmark)
                                                <li data-toggle="tooltip" data-placement="top" title="{{$landmark->landmark->description}}"><i class="fa fa-check-square-o" aria-hidden="true"></i>{{$landmark->landmark->name}}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            @if(isset($popularLandmarks))
                            <div class="col-md-6">
                                <div class="service">
                                    <img class="service-icon" src="/assets/shared/images/popu.png">
                                    <div class="desc">
                                        <h4>{{trans('frontend_details.most_popular_landmarks')}}</h4>
                                        <ul class="fa-ul-li">
                                            @foreach($popularLandmarks as $popularLandmark)
                                            @if($hotel->township_id == $popularLandmark->township_id)
                                                <li data-toggle="tooltip" data-placement="top" title="{{$popularLandmark->description}}"><i class="fa fa-check-square-o" aria-hidden="true"></i>{{$popularLandmark->name}}</li>
                                            @endif
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            @endif
                        </div><!-- End Service Blokcs -->

                    </div>	 <!-- /.room-tabel -->
                    <hr>
                    <div class="room_table" id="good_to_know">
                        <h3>{{trans('frontend_details.good_to_know')}}</h3>
                        <div class="hc_m_content">
                            <h4>{{trans('frontend_details.check_in')}}</h4>
                            <p>{{trans('frontend_details.from')}} {{$hotel->check_in_time}}</p>
                            <h4>{{trans('frontend_details.check_out')}}</h4>
                            <p>{{trans('frontend_details.until')}} {{$hotel->check_out_time}}</p>
                            <h4>{{trans('frontend_details.breakfast_start_time')}}</h4>
                            <p>{{trans('frontend_details.from')}} {{$hotel->breakfast_start_time}}</p>
                            <h4>{{trans('frontend_details.breakfast_end_time')}}</h4>
                            <p>{{trans('frontend_details.until')}} {{$hotel->breakfast_end_time}}</p>
                        </div>
                    </div>	 <!-- /.room-tabel -->
                </div><!-- /.row -->
            </div><!-- /.container -->
        </div>
    </section>

@stop

@section('page_script')
    <script src="http://maps.google.com/maps/api/js?key=AIzaSyAJLUg2IEbAOp4gMqRoXpSnjV0w1FDfYNk&sensor=false" type="text/javascript"></script>
    <script type="text/javascript" language="javascript" class="init">
        $(document).ready(function() {

            //for tootip
             $('[data-toggle="tooltip"]').tooltip();




            var numslider   = $('.slider_two').length;
            //init function
            google.maps.event.trigger(map, 'resize');
            var latitude  = $("#latitude").val();
            var longitude = $("#longitude").val();
//            setTimeout(executeQuery(latitude,longitude), 3000);
            setTimeout(renderMap(latitude,longitude), 3000);
            /* var nowDate = new Date();
            var today = new Date(nowDate.getFullYear(), nowDate.getMonth(), nowDate.getDate(), 0, 0, 0, 0);
            $('#check_in').datepicker({
                format: 'dd-mm-yyyy',
                autoclose: true,
                defaultDate: "+1w",
                changeMonth: true,
                numberOfMonths: 1,
                allowInputToggle: true,
                startDate: today
            });

            $('#check_out').datepicker({
                format: 'dd-mm-yyyy',
                autoclose: true,
                defaultDate: "+1w",
                changeMonth: true,
                numberOfMonths: 1,
                allowInputToggle: true,
                startDate: today
            }); */

            //Date Picker with controls of from date and to date
            $("#check_in").datepicker({
                format: 'dd-mm-yyyy',
                autoclose: true,
                showButtonPanel: true,
                startDate: new Date()
            }).on('changeDate', function (selected) {
                var startDate = new Date(selected.date.valueOf());
                startDate.setDate(startDate.getDate() + 1);
                $('#check_out').datepicker('setStartDate', startDate);
            }).on('clearDate', function (selected) {
                $('#check_out').datepicker('setStartDate',null);
            });

            $("#check_out").datepicker({
                format: 'dd-mm-yyyy',
                autoclose: true,
                startDate: new Date()
            }).on('changeDate', function (selected) {
                var endDate = new Date(selected.date.valueOf());
                $('#check_in').datepicker('setEndDate', endDate);
            }).on('clearDate', function (selected) {
                $('#check_in').datepicker('setEndDate',null);
            });

            $("[type='number']").keypress(function (evt) {
                evt.preventDefault();
            });

            $("#destination").autocomplete({
                source: "/autocompletedestination"
            });

            $(function(){
                $('.filter_checkbox').on('change',function(){
                    $('#search').submit();
                });
            });

            $('#search').validate({
                rules: {
                    destination                    : 'required',
                    check_in                       : 'required',
                    check_out                      : 'required',
                },
                messages: {
                    destination                    : 'Destination is required',
                    check_in                       : 'Check-in Date is required',
                    check_out                      : 'Check-out Date is required',
                },
                submitHandler: function(form) {
                    $('input[type="submit"]').attr('disabled','disabled');
                    form.submit();
                }
            });
            //jssor slider init functions
            jssor_main_slider_init();
            // var val = 2;
            // var a = "jssor_" + val + "_slider_init";
            // window[a]();
                // z = 22;
                // var postId      = $('#slider-' + z).val();
            $('.insertcolumn').click(function(){
                var postId      = $(this).attr('id');
                var sliderId    = "jssor_" + postId + "_slider_init";
                window[sliderId]();
            });

        });

        function renderMap(latitude,longitude) {
//            google.maps.event.trigger(map, 'resize');
            var map = new google.maps.Map(document.getElementById('map'), {
                zoom: 10,
                center: new google.maps.LatLng(latitude, longitude), //dynamic center point
                mapTypeId: google.maps.MapTypeId.ROADMAP
            });

            var marker, i;

            marker = new google.maps.Marker({
                position: new google.maps.LatLng(latitude, longitude),
                map: map
            });
        }

        function book() {
            var null_value_flag = 0; //if 0, all fields are null; and if 1, there is at least a value

            // $(':input[type="number"][name^="number_"]').each(function(){
            $('[name^="number_"]').each(function(){
                if(this.value > 0 && this.value != "" && this.value != null){
                    null_value_flag = 1; //set to 1 as soon as there is a value in input type = number
                }
            });

            //there is at least a value, and it's ok to submit
            if(null_value_flag == 1){
                $("#frm_booking").submit();
            }
            //room_counts are all null
            else{
                sweetAlert("Oops...", "Please select at least one room to book !", "error");
            }
        }

    </script>



    <!-- #region Jssor Slider Begin -->
    <script type="text/javascript">
        jssor_main_slider_init = function() {

            var jssor_main_SlideshowTransitions = [
                {$Duration:1200,x:0.3,$During:{$Left:[0.3,0.7]},$Easing:{$Left:$Jease$.$InCubic,$Opacity:$Jease$.$Linear},$Opacity:2},
                {$Duration:1200,x:-0.3,$SlideOut:true,$Easing:{$Left:$Jease$.$InCubic,$Opacity:$Jease$.$Linear},$Opacity:2},
                {$Duration:1200,x:-0.3,$During:{$Left:[0.3,0.7]},$Easing:{$Left:$Jease$.$InCubic,$Opacity:$Jease$.$Linear},$Opacity:2},
                {$Duration:1200,x:0.3,$SlideOut:true,$Easing:{$Left:$Jease$.$InCubic,$Opacity:$Jease$.$Linear},$Opacity:2},
                {$Duration:1200,y:0.3,$During:{$Top:[0.3,0.7]},$Easing:{$Top:$Jease$.$InCubic,$Opacity:$Jease$.$Linear},$Opacity:2},
                {$Duration:1200,y:-0.3,$SlideOut:true,$Easing:{$Top:$Jease$.$InCubic,$Opacity:$Jease$.$Linear},$Opacity:2},
                {$Duration:1200,y:-0.3,$During:{$Top:[0.3,0.7]},$Easing:{$Top:$Jease$.$InCubic,$Opacity:$Jease$.$Linear},$Opacity:2},
                {$Duration:1200,y:0.3,$SlideOut:true,$Easing:{$Top:$Jease$.$InCubic,$Opacity:$Jease$.$Linear},$Opacity:2},
                {$Duration:1200,x:0.3,$Cols:2,$During:{$Left:[0.3,0.7]},$ChessMode:{$Column:3},$Easing:{$Left:$Jease$.$InCubic,$Opacity:$Jease$.$Linear},$Opacity:2},
                {$Duration:1200,x:0.3,$Cols:2,$SlideOut:true,$ChessMode:{$Column:3},$Easing:{$Left:$Jease$.$InCubic,$Opacity:$Jease$.$Linear},$Opacity:2},
                {$Duration:1200,y:0.3,$Rows:2,$During:{$Top:[0.3,0.7]},$ChessMode:{$Row:12},$Easing:{$Top:$Jease$.$InCubic,$Opacity:$Jease$.$Linear},$Opacity:2},
                {$Duration:1200,y:0.3,$Rows:2,$SlideOut:true,$ChessMode:{$Row:12},$Easing:{$Top:$Jease$.$InCubic,$Opacity:$Jease$.$Linear},$Opacity:2},
                {$Duration:1200,y:0.3,$Cols:2,$During:{$Top:[0.3,0.7]},$ChessMode:{$Column:12},$Easing:{$Top:$Jease$.$InCubic,$Opacity:$Jease$.$Linear},$Opacity:2},
                {$Duration:1200,y:-0.3,$Cols:2,$SlideOut:true,$ChessMode:{$Column:12},$Easing:{$Top:$Jease$.$InCubic,$Opacity:$Jease$.$Linear},$Opacity:2},
                {$Duration:1200,x:0.3,$Rows:2,$During:{$Left:[0.3,0.7]},$ChessMode:{$Row:3},$Easing:{$Left:$Jease$.$InCubic,$Opacity:$Jease$.$Linear},$Opacity:2},
                {$Duration:1200,x:-0.3,$Rows:2,$SlideOut:true,$ChessMode:{$Row:3},$Easing:{$Left:$Jease$.$InCubic,$Opacity:$Jease$.$Linear},$Opacity:2},
                {$Duration:1200,x:0.3,y:0.3,$Cols:2,$Rows:2,$During:{$Left:[0.3,0.7],$Top:[0.3,0.7]},$ChessMode:{$Column:3,$Row:12},$Easing:{$Left:$Jease$.$InCubic,$Top:$Jease$.$InCubic,$Opacity:$Jease$.$Linear},$Opacity:2},
                {$Duration:1200,x:0.3,y:0.3,$Cols:2,$Rows:2,$During:{$Left:[0.3,0.7],$Top:[0.3,0.7]},$SlideOut:true,$ChessMode:{$Column:3,$Row:12},$Easing:{$Left:$Jease$.$InCubic,$Top:$Jease$.$InCubic,$Opacity:$Jease$.$Linear},$Opacity:2},
                {$Duration:1200,$Delay:20,$Clip:3,$Assembly:260,$Easing:{$Clip:$Jease$.$InCubic,$Opacity:$Jease$.$Linear},$Opacity:2},
                {$Duration:1200,$Delay:20,$Clip:3,$SlideOut:true,$Assembly:260,$Easing:{$Clip:$Jease$.$OutCubic,$Opacity:$Jease$.$Linear},$Opacity:2},
                {$Duration:1200,$Delay:20,$Clip:12,$Assembly:260,$Easing:{$Clip:$Jease$.$InCubic,$Opacity:$Jease$.$Linear},$Opacity:2},
                {$Duration:1200,$Delay:20,$Clip:12,$SlideOut:true,$Assembly:260,$Easing:{$Clip:$Jease$.$OutCubic,$Opacity:$Jease$.$Linear},$Opacity:2}
            ];

            var jssor_main_options = {
                $AutoPlay: 1,
                $SlideshowOptions: {
                    $Class: $JssorSlideshowRunner$,
                    $Transitions: jssor_main_SlideshowTransitions,
                    $TransitionsOrder: 1
                },
                $ArrowNavigatorOptions: {
                    $Class: $JssorArrowNavigator$
                },
                $ThumbnailNavigatorOptions: {
                    $Class: $JssorThumbnailNavigator$,
                    $Cols: 10,
                    $SpacingX: 8,
                    $SpacingY: 8,
                    $Align: 360
                }
            };

            var jssor_main_slider = new $JssorSlider$("jssor_main", jssor_main_options);

            /*responsive code begin*/
            /*remove responsive code if you don't want the slider scales while window resizing*/
            function ScaleSlider() {
                var refSize = jssor_main_slider.$Elmt.parentNode.clientWidth;
                if (refSize) {
                    refSize = Math.min(refSize, 800);
                    jssor_main_slider.$ScaleWidth(refSize);
                }
                else {
                    window.setTimeout(ScaleSlider, 30);
                }
            }
            ScaleSlider();
            $Jssor$.$AddEvent(window, "load", ScaleSlider);
            $Jssor$.$AddEvent(window, "resize", ScaleSlider);
            $Jssor$.$AddEvent(window, "orientationchange", ScaleSlider);
            /*responsive code end*/
        };
    </script>

    <!--Jssor 2-->
    <script type="text/javascript">
    function myFunction(id) {
        var i               = id;
        var jssor_num       = "jssor_" + i;
        var jssor_function  = "jssor_" + i + "_slider_init";
        var showTransitions = "jssor_" + i + "_SlideshowTransitions";
        var jssorOption     = "jssor_" + i + "_options";
        var jssorSlider     = "jssor_" + i + "_slider";
         window[jssor_function] = function () {
            window[showTransitions] = [
                    {$Duration:1200,x:0.3,$During:{$Left:[0.3,0.7]},$Easing:{$Left:$Jease$.$InCubic,$Opacity:$Jease$.$Linear},$Opacity:2},
                    {$Duration:1200,x:-0.3,$SlideOut:true,$Easing:{$Left:$Jease$.$InCubic,$Opacity:$Jease$.$Linear},$Opacity:2},
                    {$Duration:1200,x:-0.3,$During:{$Left:[0.3,0.7]},$Easing:{$Left:$Jease$.$InCubic,$Opacity:$Jease$.$Linear},$Opacity:2},
                    {$Duration:1200,x:0.3,$SlideOut:true,$Easing:{$Left:$Jease$.$InCubic,$Opacity:$Jease$.$Linear},$Opacity:2},
                    {$Duration:1200,y:0.3,$During:{$Top:[0.3,0.7]},$Easing:{$Top:$Jease$.$InCubic,$Opacity:$Jease$.$Linear},$Opacity:2},
                    {$Duration:1200,y:-0.3,$SlideOut:true,$Easing:{$Top:$Jease$.$InCubic,$Opacity:$Jease$.$Linear},$Opacity:2},
                    {$Duration:1200,y:-0.3,$During:{$Top:[0.3,0.7]},$Easing:{$Top:$Jease$.$InCubic,$Opacity:$Jease$.$Linear},$Opacity:2},
                    {$Duration:1200,y:0.3,$SlideOut:true,$Easing:{$Top:$Jease$.$InCubic,$Opacity:$Jease$.$Linear},$Opacity:2},
                    {$Duration:1200,x:0.3,$Cols:2,$During:{$Left:[0.3,0.7]},$ChessMode:{$Column:3},$Easing:{$Left:$Jease$.$InCubic,$Opacity:$Jease$.$Linear},$Opacity:2},
                    {$Duration:1200,x:0.3,$Cols:2,$SlideOut:true,$ChessMode:{$Column:3},$Easing:{$Left:$Jease$.$InCubic,$Opacity:$Jease$.$Linear},$Opacity:2},
                    {$Duration:1200,y:0.3,$Rows:2,$During:{$Top:[0.3,0.7]},$ChessMode:{$Row:12},$Easing:{$Top:$Jease$.$InCubic,$Opacity:$Jease$.$Linear},$Opacity:2},
                    {$Duration:1200,y:0.3,$Rows:2,$SlideOut:true,$ChessMode:{$Row:12},$Easing:{$Top:$Jease$.$InCubic,$Opacity:$Jease$.$Linear},$Opacity:2},
                    {$Duration:1200,y:0.3,$Cols:2,$During:{$Top:[0.3,0.7]},$ChessMode:{$Column:12},$Easing:{$Top:$Jease$.$InCubic,$Opacity:$Jease$.$Linear},$Opacity:2},
                    {$Duration:1200,y:-0.3,$Cols:2,$SlideOut:true,$ChessMode:{$Column:12},$Easing:{$Top:$Jease$.$InCubic,$Opacity:$Jease$.$Linear},$Opacity:2},
                    {$Duration:1200,x:0.3,$Rows:2,$During:{$Left:[0.3,0.7]},$ChessMode:{$Row:3},$Easing:{$Left:$Jease$.$InCubic,$Opacity:$Jease$.$Linear},$Opacity:2},
                    {$Duration:1200,x:-0.3,$Rows:2,$SlideOut:true,$ChessMode:{$Row:3},$Easing:{$Left:$Jease$.$InCubic,$Opacity:$Jease$.$Linear},$Opacity:2},
                    {$Duration:1200,x:0.3,y:0.3,$Cols:2,$Rows:2,$During:{$Left:[0.3,0.7],$Top:[0.3,0.7]},$ChessMode:{$Column:3,$Row:12},$Easing:{$Left:$Jease$.$InCubic,$Top:$Jease$.$InCubic,$Opacity:$Jease$.$Linear},$Opacity:2},
                    {$Duration:1200,x:0.3,y:0.3,$Cols:2,$Rows:2,$During:{$Left:[0.3,0.7],$Top:[0.3,0.7]},$SlideOut:true,$ChessMode:{$Column:3,$Row:12},$Easing:{$Left:$Jease$.$InCubic,$Top:$Jease$.$InCubic,$Opacity:$Jease$.$Linear},$Opacity:2},
                    {$Duration:1200,$Delay:20,$Clip:3,$Assembly:260,$Easing:{$Clip:$Jease$.$InCubic,$Opacity:$Jease$.$Linear},$Opacity:2},
                    {$Duration:1200,$Delay:20,$Clip:3,$SlideOut:true,$Assembly:260,$Easing:{$Clip:$Jease$.$OutCubic,$Opacity:$Jease$.$Linear},$Opacity:2},
                    {$Duration:1200,$Delay:20,$Clip:12,$Assembly:260,$Easing:{$Clip:$Jease$.$InCubic,$Opacity:$Jease$.$Linear},$Opacity:2},
                    {$Duration:1200,$Delay:20,$Clip:12,$SlideOut:true,$Assembly:260,$Easing:{$Clip:$Jease$.$OutCubic,$Opacity:$Jease$.$Linear},$Opacity:2}
                ];
                window[jssorOption] = {
                    $AutoPlay: 1,
                    $SlideshowOptions: {
                        $Class: $JssorSlideshowRunner$,
                        $Transitions: window[showTransitions],
                        $TransitionsOrder: 1
                    },
                    $ArrowNavigatorOptions: {
                        $Class: $JssorArrowNavigator$
                    },
                    $ThumbnailNavigatorOptions: {
                        $Class: $JssorThumbnailNavigator$,
                        $Cols: 10,
                        $SpacingX: 8,
                        $SpacingY: 8,
                        $Align: 360
                    }
                };

                window[jssorSlider]     = new $JssorSlider$(jssor_num, window[jssorOption]);

                /*responsive code begin*/
                /*remove responsive code if you don't want the slider scales while window resizing*/
                function ScaleSlider() {
                    var refSize = window[jssorSlider].$Elmt.parentNode.clientWidth;
                    if (refSize) {
                        refSize = Math.min(refSize, 800);
                        window[jssorSlider].$ScaleWidth(refSize);
                }
                    else {
                        window.setTimeout(ScaleSlider, 30);
                    }
                }
                ScaleSlider();
                $Jssor$.$AddEvent(window, "load", ScaleSlider);
                $Jssor$.$AddEvent(window, "resize", ScaleSlider);
                $Jssor$.$AddEvent(window, "orientationchange", ScaleSlider);
                /*responsive code end*/
        }
    }
    </script>
    <!--Jssor 2-->

    <!-- #region Jssor Slider End -->


@stop
