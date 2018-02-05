@extends('layouts.master')
@section('title','User')
@section('content')

<!-- begin #content -->
<div id="content" class="content">

    <h1 class="page-header">Disabled User List</h1>

    <div class="row">
        <div class="col-md-10">
          <h3><a href="/backend_mps/user"><i class="fa fa-angle-double-left"></i>&nbsp Back to User List</a></h3>
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
                        <th>Login Name</th>
                        <th>Display Name</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Address</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tfoot>
                    <tr>
                        <th class="search-col" con-id="user_name">Login Name</th>
                        <th class="search-col" con-id="display_name">Display Name</th>
                        <th class="search-col" con-id="email">Email</th>
                        <th class="search-col" con-id="role_name">Role</th>
                        <th class="search-col" con-id="address">Address</th>
                    </tr>
                    </tfoot>
                    <tbody>
                    @foreach($users as $user)
                        <tr>
                        <td><a href="/backend_mps/user/edit/{{$user->id}}">{{$user->user_name}}</a></td>
                        <td>{{$user->display_name}}</td>
                        <td>{{$user->email}}</td>
                        <td>{{$user->role->name}}</td>
                        <td>{{$user->address}}</td>
                        <td>
                          <form id="frm_enable_user_{{$user->id}}" method="post" action="/backend_mps/user/enable">
                            {{ csrf_field() }}
                            <input type="hidden" id="enable_user_id" name="enable_user_id" value="{{$user->id}}">
                            <button type="button" onclick="enable_user('{{$user->id}}');" class="btn btn-primary">ENABLE</button>
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
