@extends('layouts.master')
@section('title','Hotel Facility')
@section('content')

        <!-- begin #content -->
<div id="content" class="content">

    <h1 class="page-header">{{trans('setup_slider.title-list')}}</h1>
    @if(count(Session::get('message')) != 0)
        <div>
        </div>
    @endif
    <div class="row">
        <div class="col-md-10"></div>
        <div class="col-md-2">
            <div class="buttons pull-right">
                <button type="button" onclick='create_setup("slider");' class="btn btn-default btn-md first_btn">
                    <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                </button>
                <button type="button" onclick="delete_setup('slider');" class="btn btn-default btn-md third_btn">
                    <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
                </button>
            </div>
        </div>

    </div>

    {!! Form::open(array('id'=> 'frm_slider' ,'url' => '/backend/slider/destroy', 'class'=> 'form-horizontal user-form-border')) !!}
    {{ csrf_field() }}
    <input type="hidden" id="selected_checkboxes" name="selected_checkboxes" value="">

    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="listing">
                <input type="hidden" id="pageSearchedValue" name="pageSearchedValue" value="">
                <table class="table table-striped list-table" id="list-table">

                    <thead>
                    <tr>
                        <th><input type='checkbox' name='check' id='check_all'/></th>
                        <th>{{trans('setup_slider.tb-col-slider')}}</th>
                        <th>{{trans('setup_slider.tb-col-title')}}</th>
                        <th>{{trans('setup_slider.tb-col-description')}}</th>
                        <th>{{trans('setup_slider.tb-col-page')}}</th>
                    </tr>
                    </thead>
                    <tfoot>
                    <tr>
                        <th></th>
                        <th class="search-col" con-id="hotel">Image</th>
                        <th class="search-col" con-id="facility_group">Title</th>
                        <th class="search-col" con-id="facility">Description</th>
                        <th class="search-col" con-id="facility">Page</th>
                    </tr>
                    </tfoot>
                    <tbody>
                    @foreach($sliders as $slider)
                        <tr>
                            <td><input type="checkbox" class="check_source" name="edit_check" value="{{ $slider->id }}" id="all"></td>
                            <td>
                                <div class="add_image_div" style="background-image: url({{'/assets/shared/images/'.$slider->image_url}});background-position:center;background-size:cover">
                                </div>
                            </td>
                            <td>{{$slider->title }}</td>
                            <td>{{$slider->description }}</td>
                            <td>{{$slider->template->name}}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    {!! Form::close() !!}

</div>
@stop

@section('page_script')
    <script type="text/javascript" language="javascript" class="init">
        $(document).ready(function() {

            $('#list-table tfoot th.search-col').each( function () {
                var title = $('#list-table thead th').eq( $(this).index() ).text();
                $(this).html( '<input type="text" placeholder="Search '+title+'" />' );
            } );

            var table = $('#list-table').DataTable({
                aLengthMenu: [
                    [5,25, 50, 100, 200, -1],
                    [5,25, 50, 100, 200, "All"]
                ],
                iDisplayLength: 5,
                "order": [[ 2, "desc" ]],
                stateSave: false,
                "pagingType": "full",
                "dom": '<"pull-right m-t-20"i>rt<"bottom"lp><"clear">',

            });
//            new $.fn.dataTable.FixedHeader( table, {
//            });


            // Apply the search
            table.columns().eq( 0 ).each( function ( colIdx ) {
                $( 'input', table.column( colIdx ).footer() ).on( 'keyup change', function () {
                    table
                            .column( colIdx )
                            .search( this.value )
                            .draw();
                } );

            });
        });
    </script>
@stop