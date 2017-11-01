@extends('layouts.master')
@section('title','Room Available Period')
@section('content')

        <!-- begin #content -->
<div id="content" class="content">

    <h1 class="page-header">{{trans('setup_roomavailableperiod.title-list')}}</h1>

    <div class="row">
        <div class="col-md-10"></div>
        <div class="col-md-2">
            <div class="buttons pull-right">
                <button type="button" onclick='create_setup("room_available_period");' class="btn btn-default btn-md first_btn">
                    <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                </button>
                <button type="button" onclick='edit_setup("room_available_period");' class="btn btn-default btn-md second_btn">
                    <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                </button>
                <button type="button" onclick="delete_setup('room_available_period');" class="btn btn-default btn-md third_btn">
                    <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
                </button>
            </div>
        </div>

    </div>

    {!! Form::open(array('id'=> 'frm_room_available_period' ,'url' => 'backend_mps/room_available_period/destroy', 'class'=> 'form-horizontal user-form-border')) !!}
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
                        <th>{{trans('setup_roomavailableperiod.tb-col-hotel')}}</th>
                        <th>{{trans('setup_roomavailableperiod.tb-col-room')}}</th>
                        <th>{{trans('setup_roomavailableperiod.tb-col-from')}}</th>
                        <th>{{trans('setup_roomavailableperiod.tb-col-to')}}</th>
                        <th>{{trans('setup_roomavailableperiod.tb-col-remark')}}</th>
                    </tr>
                    </thead>
                    <tfoot>
                    <tr>
                        <th></th>
                        <th class="search-col" con-id="hotel">Hotel</th>
                        <th class="search-col" con-id="room">Room Type</th>
                        <th class="search-col" con-id="from_date">Available From Date</th>
                        <th class="search-col" con-id="to_date">Available To Date</th>
                        <th class="search-col" con-id="remark">Remark</th>

                    </tr>
                    </tfoot>
                    <tbody>
                    @foreach($room_available_period as $available)
                        <tr>
                            <td><input type="checkbox" class="check_source" name="edit_check" value="{{$available->id}}" id="all"></td>
                            <td>{{$available->hotel->name}}</td>
                            <td><a href="/backend_mps/room_available_period/edit/{{$available->id}}">{{$available->room->name}}</a></td>
                            <td>{{$available->from_date}}</td>
                            <td>{{$available->to_date}}</td>
                            <td>{{$available->remark}}</td>
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