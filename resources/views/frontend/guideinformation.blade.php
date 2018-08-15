@extends('layouts_frontend.master_frontend')
@section('title','Guide Information')
@section('content')
        <div id="header_id">
            <img class="img-responsive img-hover" src="/assets/shared/images/slider1.png">
        </div>
    </div>

    </section>

        <section id="aboutus">
            <div class="container">
                <div class="row">
                    <!-- <h1>{{trans('frontend_header.tour_information')}}</h1> -->
                    {!! $page_data !!}
                </div><!-- /.row -->
            </div><!-- /.container -->
        </section><!-- /.section -->
@stop

@section('page_script')

@stop
