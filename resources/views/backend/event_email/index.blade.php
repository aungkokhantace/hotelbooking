@extends('layouts.master')
@section('title','Event Email Listing')
@section('content')

    <!-- begin #content -->
    <div id="content" class="content">

        <h1 class="page-header">{{trans('setup_eventemail.title-list')}}</h1>

        <div class="row">
            <div class="col-md-10"></div>
            <div class="col-md-2">
                <div class="buttons pull-right">
                    <button type="button" onclick='create_setup("eventemail");' class="btn btn-default btn-md first_btn">
                        <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                    </button>
                    <button type="button" onclick='edit_setup("eventemail");' class="btn btn-default btn-md second_btn">
                        <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                    </button>
                    <button type="button" onclick="delete_setup('eventemail');" class="btn btn-default btn-md third_btn">
                        <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
                    </button>
                </div>
            </div>

        </div>

        {!! Form::open(array('id'=> 'frm_eventemail' ,'url' => 'backend/eventemail/destroy', 'class'=> 'form-horizontal user-form-border')) !!}
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
                            <th>{{trans('setup_eventemail.tb-col-email')}}</th>
                            <th>{{trans('setup_eventemail.tb-col-description')}}</th>
                            <th>{{trans('setup_eventemail.tb-col-type')}}</th>
                        </tr>
                        </thead>
                        <tfoot>
                        <tr>
                            <th></th>
                            <th class="search-col" con-id="hotel">Email</th>
                            <th class="search-col" con-id="name">Description</th>
                            <th class="search-col" con-id="name">Email Type</th>
                        </tr>
                        </tfoot>
                        <tbody>
                        @foreach($events as $event)
                            <tr>
                                <td><input type="checkbox" class="check_source" name="edit_check" value="{{ $event->id }}" id="all"></td>
                                <td><a href="eventemail/edit/{{ $event->id }}">{{$event->email}}</a></td>
                                <td>{{$event->description}}</td>
                                <td>
                                    @if($event->type == 1)
                                        Register
                                    @elseif ($event->type == 2)
                                        Test 2
                                    @elseif ($event->type == 3)
                                        Test 3
                                    @elseif ($event->type == 4)
                                        Test 4
                                    @elseif ($event->type == 5)
                                        Booking Cancel
                                    @endif
                                </td>
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