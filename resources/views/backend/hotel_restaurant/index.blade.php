@extends('layouts.master')
@section('title','Hotel Room Category')
@section('content')

        <!-- begin #content -->
<div id="content" class="content">

    <h1 class="page-header">Hotel Restaurant Listing</h1>

    <div class="row">
        <div class="col-md-10"></div>
        <div class="col-md-2">
            <div class="buttons pull-right">
                <button type="button" onclick='create_setup("hotel_restaurant");' class="btn btn-default btn-md first_btn">
                    <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                </button>
                <button type="button" onclick='edit_setup("hotel_restaurant");' class="btn btn-default btn-md second_btn">
                    <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                </button>
                <button type="button" onclick="delete_setup('hotel_restaurant');" class="btn btn-default btn-md third_btn">
                    <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
                </button>
            </div>
        </div>

    </div>

    {!! Form::open(array('id'=> 'frm_hotel_restaurant' ,'url' => 'backend/hotel_restaurant/destroy', 'class'=> 'form-horizontal user-form-border')) !!}
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
                        <th>Hotel</th>
                        <th>Hotel Restaurant Category</th>
                        <th>Name</th>
                        <th>Opening Hours</th>
                        <th>Opening Days</th>
                        <th>Capacity</th>
                        <th>Area</th>
                        <th>Floor</th>
                        <th>Private Room</th>
                        <th>Description</th>
                        <th>Remark</th>
                    </tr>
                    </thead>
                    <tfoot>
                    <tr>
                        <th></th>
                        <th class="search-col" con-id="hotel">Hotel</th>
                        <th class="search-col" con-id="hotel_restaurant_category">Hotel Restaurant Category</th>
                        <th class="search-col" con-id="name">Name</th>
                        <th class="search-col" con-id="opening_hours">Opening Hours</th>
                        <th class="search-col" con-id="opening_days">Opening Days</th>
                        <th class="search-col" con-id="Capacity">Capacity</th>
                        <th class="search-col" con-id="area">Area</th>
                        <th class="search-col" con-id="floor">Floor</th>
                        <th class="search-col" con-id="private_room">Private Room</th>
                        <th class="search-col" con-id="description">Description</th>
                        <th class="search-col" con-id="remark">Remark</th>


                    </tr>
                    </tfoot>
                    <tbody>
                    @foreach($hotel_restaurant as $restaurant)
                        <tr>
                            <td><input type="checkbox" class="check_source" name="edit_check" value="{{$restaurant->id }}" id="all"></td>
                            <td>{{$restaurant->hotel->name}}</td>
                            <td>{{$restaurant->h_restaurant_category->name}}</td>
                            <td><a href="/backend/hotel_restaurant/edit/{{$restaurant->id}}">{{$restaurant->name}}</a></td>
                            <td>{{$restaurant->opening_hours}}</td>
                            <td>{{$restaurant->opening_days}}</td>
                            <td>{{$restaurant->capacity}}</td>
                            <td>{{$restaurant->area}}</td>
                            <td>{{$restaurant->floor}}</td>
                            <td>{{$restaurant->private_room == 1 ? 'Yes' : 'No'}}</td>
                            <td>{{$restaurant->description}}</td>
                            <td>{{$restaurant->remark}}</td>
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