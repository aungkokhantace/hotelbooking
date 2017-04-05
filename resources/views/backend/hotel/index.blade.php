@extends('layouts.master')
@section('title','Hotel')
@section('content')

        <!-- begin #content -->
<div id="content" class="content">

    <h1 class="page-header">Hotel Listing</h1>

    <div class="row">
        <div class="col-md-10"></div>
        <div class="col-md-2">
            <div class="buttons pull-right">
                <button type="button" onclick='create_setup("hotel");' class="btn btn-default btn-md first_btn">
                    <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                </button>
                <button type="button" onclick='edit_setup("hotel");' class="btn btn-default btn-md second_btn">
                    <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                </button>
                <button type="button" onclick="delete_setup('hotel');" class="btn btn-default btn-md third_btn">
                    <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
                </button>
            </div>
        </div>

    </div>

    {!! Form::open(array('id'=> 'frm_hotel' ,'url' => 'backend/hotel/destroy', 'class'=> 'form-horizontal user-form-border')) !!}
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
                        <th>Name</th>
                        <th>Type</th>
                        <th>Address</th>
                        <th>Phone</th>
                        <th>Fax</th>
                        <th>Latitude</th>
                        <th>Longitude</th>
                        <th>Logo</th>
                        <th>Star</th>
                        <th>Email</th>
                        <th>Country</th>
                        <th>City</th>
                        <th>Township</th>
                        <th>Description</th>
                        <th>Number of Floors</th>
                        <th>Class</th>
                        <th>Website</th>
                        <th>Check-in Time</th>
                        <th>Check-out Time</th>
                        <th>Breakfast Start Time</th>
                        <th>Breakfast End Time</th>
                    </tr>
                    </thead>
                    <tfoot>
                    <tr>
                        <th></th>
                        <th class="search-col" con-id="name">Name</th>
                        <th class="search-col" con-id="type">Type</th>
                        <th class="search-col" con-id="address">Address</th>
                        <th class="search-col" con-id="phone">Phone</th>
                        <th class="search-col" con-id="fax">Fax</th>
                        <th class="search-col" con-id="latitude">Latitude</th>
                        <th class="search-col" con-id="longitude">Longitude</th>
                        <th class="search-col" con-id="logo">Logo</th>
                        <th class="search-col" con-id="star">Star</th>
                        <th class="search-col" con-id="email">Email</th>
                        <th class="search-col" con-id="country">Country</th>
                        <th class="search-col" con-id="city">City</th>
                        <th class="search-col" con-id="township">Township</th>
                        <th class="search-col" con-id="description">Description</th>
                        <th class="search-col" con-id="number_of_floors">Number of Floors</th>
                        <th class="search-col" con-id="class">Class</th>
                        <th class="search-col" con-id="website">Website</th>
                        <th class="search-col" con-id="check_in_time">Check-in Time</th>
                        <th class="search-col" con-id="check_out_time">Check-out Time</th>
                        <th class="search-col" con-id="breakfast_start_time">Breakfast Start Time</th>
                        <th class="search-col" con-id="breakfast_end_time">Breakfast End Time</th>
                    </tr>
                    </tfoot>
                    <tbody>
                    @foreach($hotels as $hotel)
                        <tr>
                            <td><input type="checkbox" class="check_source" name="edit_check" value="{{ $hotel->id }}" id="all"></td>
                            <td><a href="/backend/hotel/edit/{{$hotel->id}}">{{$hotel->name}}</a></td>
                            <td>{{$hotel->h_type_id}}</td>
                            <td>{{$hotel->address}}</td>
                            <td>{{$hotel->phone}}</td>
                            <td>{{$hotel->fax}}</td>
                            <td>{{$hotel->latitude}}</td>
                            <td>{{$hotel->longitude}}</td>
                            <td>{{$hotel->logo}}</td>
                            <td>{{$hotel->star}}</td>
                            <td>{{$hotel->email}}</td>
                            <td>{{$hotel->country->name}}</td>
                            <td>{{$hotel->city->name}}</td>
                            <td>{{$hotel->township->name}}</td>
                            <td>{{$hotel->description}}</td>
                            <td>{{$hotel->number_of_floors}}</td>
                            <td>{{$hotel->class}}</td>
                            <td>{{$hotel->website}}</td>
                            <td>{{$hotel->check_in_time}}</td>
                            <td>{{$hotel->check_out_time}}</td>
                            <td>{{$hotel->breakfast_start_time}}</td>
                            <td>{{$hotel->breakfast_end_time}}</td>
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