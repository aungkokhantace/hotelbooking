@extends('layouts.master')
@section('title','User')
@section('content')

<!-- begin #content -->
<div id="content" class="content">

    <h1 class="page-header">User Listing</h1>

    <div class="row">
        <div class="col-md-10"></div>
        <div class="col-md-2">
            <div class="buttons pull-right">
                <button type="button" onclick='create_setup("user");' class="btn btn-default btn-md first_btn">
                    <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                </button>
                <button type="button" onclick='edit_setup("user");' class="btn btn-default btn-md second_btn">
                    <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                </button>
                <!-- <button type="button" onclick="delete_setup('user');" class="btn btn-default btn-md third_btn"> -->
                <button type="button" onclick="disable_setup('user');" class="btn btn-default btn-md third_btn">
                    <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
                </button>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-10">
          <h3><a href="/backend_mps/user/disabled_users"><i class="fa fa-angle-double-right"></i>&nbsp View Inactive User List</a></h3>
        </div>
    </div>

    {!! Form::open(array('id'=> 'frm_disable_user' ,'url' => '/backend_mps/user/disable', 'class'=> 'form-horizontal user-form-border')) !!}
    <!-- {!! Form::open(array('id'=> 'frm_user' ,'url' => '/backend_mps/user/destroy', 'class'=> 'form-horizontal user-form-border')) !!} -->
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
                        <th>Login Name</th>
                        <th>Display Name</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Address</th>

                    </tr>
                    </thead>
                    <tfoot>
                    <tr>
                        <th></th>
                        <th class="search-col" con-id="user_name">Login Name</th>
                        <th class="search-col" con-id="display_name">Display Name</th>
                        <th class="search-col" con-id="email">Email</th>
                        <th class="search-col" con-id="role_name">Role</th>
                        <th class="search-col" con-id="staff_id">Address</th>


                    </tr>
                    </tfoot>
                    <tbody>
                    @foreach($users as $user)
                        <tr>
                        <td><input type="checkbox" class="check_source" name="edit_check" value="{{ $user->id }}" id="all"></td>
                        <td><a href="/backend_mps/user/edit/{{$user->id}}">{{$user->user_name}}</a></td>
                        <td>{{$user->display_name}}</td>
                        <td>{{$user->email}}</td>
                        <td>{{$user->role->name}}</td>
                        <td>{{$user->address}}</td>

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
