@extends('layouts.master')
@section('title','Hotel')
@section('content')

        <!-- begin #content -->
<div id="content" class="content">

    <h1 class="page-header">{{trans('setup_hotel.title-list')}}</h1>

    <div class="row">
        <div class="col-md-10">
          <h3><a href="/backend_mps/hotel"><i class="fa fa-angle-double-left"></i>&nbsp Back to Hotel List</a></h3>
        </div>
    </div>

    <input type="hidden" id="selected_checkboxes" name="selected_checkboxes" value="">

    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="listing">
                <input type="hidden" id="pageSearchedValue" name="pageSearchedValue" value="">
                <table class="table table-striped list-table" id="list-table">

                    <thead>
                    <tr>
                        <th>{{trans('setup_hotel.tb-col-name')}}</th>
                        <th>{{trans('setup_hotel.tb-col-address')}}</th>
                        <th>{{trans('setup_hotel.tb-col-phone')}}</th>
                        <th>{{trans('setup_hotel.tb-col-email')}}</th>
                        <th>{{trans('setup_hotel.tb-col-class')}}</th>
                        <!-- <th>{{trans('setup_hotel.tb-col-website')}}</th> -->
                        <th></th>
                    </tr>
                    </thead>
                    <tfoot>
                    <tr>
                        <th class="search-col" con-id="name">Name</th>
                        <th class="search-col" con-id="address">Address</th>
                        <th class="search-col" con-id="phone">Phone</th>
                        <th class="search-col" con-id="email">Email</th>
                        <th class="search-col" con-id="category">Category</th>
                        <!-- <th class="search-col" con-id="website">Website</th> -->
                        <!-- <th class="search-col" con-id="website"></th> -->
                    </tr>
                    </tfoot>
                    <tbody>
                    @foreach($hotels as $hotel)
                        <tr>
                            <td><a href="/backend_mps/hotel/edit/{{$hotel->id}}">{{$hotel->name}}</a></td>
                            <td>{{$hotel->address}}</td>
                            <td>{{$hotel->phone}}</td>
                            <td>{{$hotel->email}}</td>
                            <td>{{$hotel->class}}</td>
                            <!-- <td>{{$hotel->website}}</td> -->
                            <td>
                              <form id="frm_enable_hotel_{{$hotel->id}}" method="post" action="/backend_mps/hotel/enable">
                                {{ csrf_field() }}
                                <input type="hidden" id="enable_hotel_id" name="enable_hotel_id" value="{{$hotel->id}}">
                                <button type="button" onclick="enable_hotel('{{$hotel->id}}');" class="btn btn-primary">ENABLE</button>
                              </form>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
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
//                "order": [[ 2, "desc" ]],
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
