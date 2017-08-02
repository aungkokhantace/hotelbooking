@extends('layouts.master')
@section('title','CSV Import')
@section('content')

        <!-- begin #content -->
    <div id="content" class="content">
        <style>
            .fileUpload {
                position: relative;
                overflow: hidden;
                margin: 10px;
            }
            .fileUpload input.upload {
                position: absolute;
                top: 0;
                right: 0;
                margin: 0;
                padding: 0;
                font-size: 20px;
                cursor: pointer;
                opacity: 0;
                filter: alpha(opacity=0);
            }
            .err-csv {
                position: absolute;
                color:blue;
            }
            .text-download {
                color: #008A8A;
                line-height: 40px;
            }
            #amenities, #facilities, #facility_group, #features, #hotels, #landmarks {
                display: none;
            }
        </style>
        <h1 class="page-header">{{ trans('setup_csvimport.title-entry') }}</h1>

        {!! Form::open(array('url' => '/backend/import/store','id'=>'csv_import', 'enctype'=>'multipart/form-data' ,'class'=> 'form-horizontal user-form-border')) !!}
        <br/>

        <div class="row">
            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
                <label for="hotel_id">
                    {{trans('setup_csvimport.place-tbl')}}
                    <span class="require">*</span>
                </label>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                <select class="form-control" name="tbl_name" id="tbl_name" onchange="showDownload()">
                    <option value="">Select Table Name</option>
                    <option value="amenities" {{ (old("tbl_name") == "amenities" ? "selected":"") }}>Amenities</option>
                    <option value="facilities" {{ (old("tbl_name") == "facilities" ? "selected":"") }}>Facilities</option>
                    <option value="facility_group" {{ (old("tbl_name") == "facility_group" ? "selected":"") }}>Facility Group</option>
                    <option value="features" {{ (old("tbl_name") == "features" ? "selected":"") }}>Features</option>
                    <option value="hotels" {{ (old("tbl_name") == "hotels" ? "selected":"") }}>Hotels</option>
                    <option value="landmarks" {{ (old("tbl_name") == "landmarks" ? "selected":"") }}>Landmarks</option>
                </select>
                <p class="text-danger">{{$errors->first('tbl-name')}}
            </div>
        </div>

        <div class="row">
            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
                <label for="csv_upl">
                    {{trans('setup_csvimport.place-csv')}}
                    <span class="require">*</span>
                </label>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                <div class="fileUpload btn btn-success">
                    <span>{{trans('setup_csvimport.place-browse')}}</span>
                    <input id="csv_upl" type="file" class="upload" name="csv_upl" />
                </div>
                <p class="text-danger err-csv">{{$errors->first('csv_upl')}}</p>
            </div>
        </div>
        <!-- Start Download Button For CSV -->
        <div class="row" id="amenities">
            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
                <label for="">
                    <span class="require">&nbsp;</span>
                </label>
            </div>
            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
                <button class="form-control btn-success" onclick="downloadfile()" type="button">
                {{trans('setup_csvimport.place-download')}}
                </button>
                <iframe style="display:none;" name="hiddenIframe" id="hiddenIframe"></iframe>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                <p class="text-download">{{trans('setup_csvimport.download-amenities')}}</p>
            </div>
        </div>

        <div class="row" id="facilities">
            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
                <label for="">
                    <span class="require">&nbsp;</span>
                </label>
            </div>
            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
                <button class="form-control btn-success" onclick="downloadfile()" type="button">
                {{trans('setup_csvimport.place-download')}}
                </button>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                <p class="text-download">{{trans('setup_csvimport.download-facilities')}}</p>
            </div>
        </div>

        <div class="row" id="facility_group">
            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
                <label for="">
                    <span class="require">&nbsp;</span>
                </label>
            </div>
            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
                <button class="form-control btn-success" onclick="downloadfile()" type="button">
                {{trans('setup_csvimport.place-download')}}
                </button>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                <p class="text-download">{{trans('setup_csvimport.download-facility_group')}}</p>
            </div>
        </div>

        <div class="row" id="features">
            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
                <label for="">
                    <span class="require">&nbsp;</span>
                </label>
            </div>
            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
                <button class="form-control btn-success" onclick="downloadfile()" type="button">
                {{trans('setup_csvimport.place-download')}}
                </button>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                <p class="text-download">{{trans('setup_csvimport.download-features')}}</p>
            </div>
        </div>

        <div class="row" id="hotels">
            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
                <label for="">
                    <span class="require">&nbsp;</span>
                </label>
            </div>
            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
                <button class="form-control btn-success" onclick="downloadfile()" type="button">
                {{trans('setup_csvimport.place-download')}}
                </button>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                <p class="text-download">{{trans('setup_csvimport.download-hotels')}}</p>
            </div>
        </div>

        <div class="row" id="landmarks">
            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
                <label for="">
                    <span class="require">&nbsp;</span>
                </label>
            </div>
            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
                <button class="form-control btn-success" onclick="downloadfile()" type="button">
                {{trans('setup_csvimport.place-download')}}
                </button>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                <p class="text-download">{{trans('setup_csvimport.download-landmarks')}}</p>
            </div>
        </div>

        <!-- End Download Button For CSV -->
        <div class="row">
            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
            </div>

            <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1">
                <input type="submit" name="submit" value="{{ trans('setup_csvimport.btn-add') }}" class="form-control btn-primary">
            </div>

            <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1">
                <input type="button" value="{{trans('setup_csvimport.btn-cancel')}}" class="form-control cancel_btn">
            </div>
        </div>
        {!! Form::close() !!}
    </div>
@stop

@section('page_script')
    <script type="text/javascript">
        $(document).ready(function() {

            $('#csv_import').validate({
                rules   : {
                    tbl_name        : 'required',
                    csv_upl         : {
                                        required: true,
                                        extension: "xls|csv"
                    }
                },
                messages: {
                    tbl_name        : 'Table Name is required!',
                    csv_upl         : {
                                        required: 'CSV file is required!',
                                        extension: 'Please upload a csv file!'
                    }
                },
                submitHandler: function(form) {
                    $('input[type="submit"]').attr('disabled','disabled');
                    form.submit();
                }
            });
        });

        function showDownload() {
            $(document).ready(function() {
                var showId      = $('#tbl_name').val();
                if (showId == 'amenities') {
                    $('#amenities').show();
                    $('#facilities').hide();
                    $('#facility_group').hide();
                    $('#features').hide();
                    $('#hotels').hide();
                    $('#landmarks').hide();
                }

                if (showId == 'facilities') {
                    $('#amenities').hide();
                    $('#facilities').show();
                    $('#facility_group').hide();
                    $('#features').hide();
                    $('#hotels').hide();
                    $('#landmarks').hide();
                }

                if (showId == 'facility_group') {
                    $('#amenities').hide();
                    $('#facilities').hide();
                    $('#facility_group').show();
                    $('#features').hide();
                    $('#hotels').hide();
                    $('#landmarks').hide();
                }

                if (showId == 'features') {
                    $('#amenities').hide();
                    $('#facilities').hide();
                    $('#facility_group').hide();
                    $('#features').show();
                    $('#hotels').hide();
                    $('#landmarks').hide();
                }

                if (showId == 'hotels') {
                    $('#amenities').hide();
                    $('#facilities').hide();
                    $('#facility_group').hide();
                    $('#features').hide();
                    $('#hotels').show();
                    $('#landmarks').hide();
                }

                if (showId == 'landmarks') {
                    $('#amenities').hide();
                    $('#facilities').hide();
                    $('#facility_group').hide();
                    $('#features').hide();
                    $('#hotels').hide();
                    $('#landmarks').show();
                }
            });
        }

        function downloadfile() {
            var fileId      = $('#tbl_name').val();
            var downloadUrl = "../DownloadCsv/" + fileId + ".csv";
            var url=downloadUrl;    
            window.open(url, 'Download');
        }
    </script>
@stop