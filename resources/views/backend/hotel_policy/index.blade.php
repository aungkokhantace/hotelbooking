@extends('layouts.master')
@section('title','Hotel Policy')
@section('content')
        <!-- begin #content -->
<div id="content" class="content">

    <h1 class="page-header">{{trans('setup_hotelpolicy.title-list')}}</h1>
    <br>

    <div class="row">
        @if(isset($all_hotels))
            <div class="col-md-2">
                @if($role !== 3)
                <select class="form-control" name="hotel_id" id="hotel_id">
                    <option value="All">All</option>
                    @foreach($hotels as $hotel)
                        <option value="{{$hotel->id}}"{{($hotel_id == $hotel->id)? 'selected' : ''}}>{{$hotel->name}}</option>
                    @endforeach
                </select>
                @endif
            </div>

            <div class="col-md-2">
            @if($role !== 3)
                <button type="button" onclick="filter_by_hotel_id('backend_mps/hotel_policy');" class="form-control btn-primary">Filter</button>
            @endif
            </div>

        @endif
        <div class="col-md-8">
            <div class="buttons pull-right">
                @if(isset($all_hotels))
                <button type="button" {{--onclick='create_setup("hotel_policy");'--}} class="btn btn-default btn-md first_btn" data-toggle="modal" data-target="#hotel_modal">
                    <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                </button>
                @endif
                <button type="button" onclick='edit_setup("hotel_policy");' class="btn btn-default btn-md second_btn">
                    <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                </button>

                @if($role !== 3)
                <button type="button" onclick="delete_setup('hotel_policy');" class="btn btn-default btn-md third_btn">
                    <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
                </button>
                @endif
            </div>
        </div>

    </div>

    {!! Form::open(array('id'=> 'frm_hotel_policy' ,'url' => 'backend_mps/hotel_policy/destroy', 'class'=> 'form-horizontal user-form-border')) !!}
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
                        <th>{{trans('setup_hotelpolicy.tb-col-hotel')}}</th>
                        <th>{{trans('setup_hotelpolicy.tb-col-policy')}}</th>
                    </tr>
                    </thead>
                    <tfoot>
                    <tr>
                        <th></th>
                        <th class="search-col" con-id="hotel">Hotel</th>
                        <th class="search-col" con-id="name">Image</th>
                    </tr>
                    </tfoot>
                    <tbody>
                    @foreach($all_hotel_policy as $hotel_policy)
                        <tr>
                            <td><input type="checkbox" class="check_source" name="edit_check" value="{{$hotel_policy->id }}" id="all"></td>
                            <td><a href="/backend_mps/hotel_policy/edit/{{$hotel_policy->id}}">{{$hotel_policy->hotel->name}}</a></td>
                            <td>{!!$hotel_policy->policy!!}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    {!! Form::close() !!}

</div>
<div class="modal fade" id="hotel_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Choose Hotel</h4>
            </div>
            <div class="modal-body">
                @if( $role == 3)
                <select class="form-control" name="all_hotel_id" id="all_hotel_id">
                    @foreach($hotels as $hotel)
                        <option value="{{$hotel->id}}" selected>{{$hotel->name}}</option>
                    @endforeach
                </select>
                @else
                <select class="form-control" name="all_hotel_id" id="all_hotel_id">
                    @foreach($hotels as $hotel)
                        <option value="{{$hotel->id}}">{{$hotel->name}}</option>
                    @endforeach
                </select>
                @endif
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick='create_setup_room_category("hotel_policy");'>Go To Hotel policy Form</button>
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
