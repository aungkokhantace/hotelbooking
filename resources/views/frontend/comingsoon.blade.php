@extends('layouts_frontend.master_frontend')
@section('title','About Us')
@section('content')
    <div id="header_id">
        <img class="img-responsive img-hover" src="/assets/shared/images/slider1.png">
    </div>
    </div>

    </section>

    <section id="aboutus">
        <div class="container">
            <div class="row">
                <div class="col-md-offset-3 col-md-6 right underconstruction">
                    <h1><strong>{{trans('frontend_details.coming_soon')}}</strong></h1>
                    <h2>{{trans('frontend_details.page_is_under_construction')}}</h2>
                    {{--<img src="/images/construction.gif">--}}
                </div>
            </div>
        </div><!-- /.container -->
    </section><!-- /.section -->
@stop

@section('page_script')

@stop