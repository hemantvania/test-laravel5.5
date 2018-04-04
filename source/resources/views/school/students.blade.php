@extends('layouts.vdesk')
@section("page-css")
    <link rel="stylesheet" href="{{ asset('plugins/datatables.net/css/dataTables.bootstrap.css') }}">
@endsection
@section('content')
    @include("error.message")
    <section class="content-wrapper">
        <div class="container-fluid inner-contnet-wrapper">
            <div class="tab-wrapper">
                <div class="row">
                    <div class="col-lg-8 col-md-7 col-sm-12 col-xs-12 user-details">
                        @include("comman.school-nav")
                    </div>
                    @include("comman.navigation")
                </div>
            </div>
            <div class="row">
                <div class="scroll-main-wrapper2">
                <div class="col-sm-12">
                    <div id="myTabContent" class="tab-content">
                        <div role="tabpanel" class="tab-pane fade in active" id="aineisto" aria-labelledby="aineisto-tab">
                            <div class="material-tab">
                                <div class="material-filter">
                                    <div class="row">
                                        <ul class="clearfix">
                                            <li class="search-filter col-lg-4 col-md-4 col-sm-6 col-xs-12">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="search-filter-main" id="adv-search">
                                                            <input type="text" id="global_search" class="form-control select2" placeholder="@lang('schooladmin.student_search_title')" />
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>

                                <div class="materialtable materialtable-teacher">
                                    <table class="gridtable table-bordered" id="student_list" width="100%" border="0" cellspacing="0" cellpadding="0">
                                        <thead>
                                        <tr>
                                            <th>@lang('adminuser.first_name')</th>
                                            <th>@lang('adminuser.last_name')</th>
                                            <th>@lang('adminuser.email')</th>
                                            {{--<th>@lang('adminuser.usertype')</th>--}}
                                            <th>@lang('adminuser.phone')</th>
                                            <th>@lang('adminuser.address')</th>
                                            <th>@lang('adminuser.action')</th>
                                        </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                </div></div>
        </div>
    </section>
@endsection
@section("scripts")

    <script src="{{ asset('plugins/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables.net/js/dataTables.bootstrap.min.js') }}"></script>

    <script>

        var schoolUrl = '{!! generateLangugeUrl(App::getLocale(),url(generateUrlPrefix())) !!}';

        var lbl_fname   = "@lang('adminuser.first_name')";
        var lbl_lname   = "@lang('adminuser.last_name')";
        var lbl_email   = "@lang('adminuser.email')";
        var lbl_role    = "@lang('adminuser.usertype')";
        var lbl_phone   = "@lang('adminuser.phone')";
        var lbl_addr    = "@lang('adminuser.address')";
        var lbl_act     = "@lang('adminuser.action')";

        jQuery(function() {

            var studentlist = jQuery('#student_list').on( 'error.dt', function ( e, settings, techNote, message ) {
                console.log( 'An error has been reported by DataTables: ', message );
            } ).DataTable({
                processing: true,
                serverSide: true,
                ajax: '{!! generateLangugeUrl(App::getLocale(),url(generateUrlPrefix().'/studentlist')) !!}',
                columns: [

                    { data: 'first_name', name: 'users.first_name' },
                    { data: 'last_name', name: 'users.last_name' },
                    { data: 'email', name: 'users.email' },
                 /*   { data: 'rolename', name: 'userroles.rolename' },*/
                    { data: 'phone', name: 'user_metas.phone' },
                    { data: 'addressline1', name: 'user_metas.addressline1' },
                    { data: 'action', name: 'action' }
                ],
                'columnDefs': [
                    {
                        'targets': 5,
                        'searchable': false,
                        'orderable': false,
                        createdCell: function(td, cellData, rowData, row, col) {
                            $(td).attr('data-label',lbl_act);
                        }
                    },
                    {
                        'targets': 0,
                        createdCell: function(td, cellData, rowData, row, col) {
                            $(td).attr('data-label',lbl_fname);
                        },
                    },
                    {
                        'targets': 1,
                        createdCell: function(td, cellData, rowData, row, col) {
                            $(td).attr('data-label',lbl_lname);
                        },
                    },
                    {
                        'targets': 2,
                        createdCell: function(td, cellData, rowData, row, col) {
                            $(td).attr({'data-label':lbl_email, 'title': rowData.email});
                        },
                        render: function ( data, type, row ) {
                            return getLimitedString(data,15);
                        }
                    },
                    /*{
                        'targets': 3,
                        createdCell: function(td, cellData, rowData, row, col) {
                            $(td).attr('data-label',lbl_role);
                        },
                    },*/
                    {
                        'targets': 3,
                        createdCell: function(td, cellData, rowData, row, col) {
                            $(td).attr('data-label',lbl_phone);
                        },
                    },
                    {
                        'targets': 4,
                        createdCell: function(td, cellData, rowData, row, col) {
                            $(td).attr('data-label',lbl_addr);
                        },
                    },
                ]
            });

            jQuery('#global_search').on( 'keyup click', function () {
                studentlist.search(
                    jQuery('#global_search').val()
                ).draw();
            });

            studentlist.on( 'draw', function () {

                /**
                 * Function is use for delete records
                 */
                jQuery(".remove-adminusers").unbind().click( function(e) {
                    e.preventDefault();
                    var userId = jQuery(this).attr("data-index");
                    jQuery('#confirmDelete').attr('data-id',userId);
                    jQuery('#confirmDelete').modal('show');
                });

                /**
                 * Fire Ajax Call on click "Yes" button
                 */
                jQuery("#btnYes").unbind().click(function(e) {
                    // handle deletion here
                    var userId = jQuery('#confirmDelete').attr('data-id');
                    jQuery('#confirmDelete').modal('hide');
                    jQuery( ".alert-success").remove();
                    jQuery( ".alert-danger").remove();
                    showloader();
                    jQuery.ajax({
                        url: schoolUrl+"/users/" + userId +'/destroy',
                        type: 'GET',
                        data: userId,
                        success: function( data ) {
                            if ( data.status == true ) {
                                showmessage(data.message);
                            } else {
                                showmessage(data.message);
                            }
                            studentlist.ajax.reload();
                            showloader();
                        },
                        error: function( data ) {
                            if ( data.status === false) {
                                showmessage(data.message);
                            }
                            showloader();
                        }
                    });
                });


                /**
                 * Function is use for restore deleted records
                 */
                jQuery(".restore-adminusers").on('click', function(e) {
                    showloader();
                    var userId = jQuery(this).attr("data-index");
                    jQuery( ".alert-success").remove();
                    jQuery( ".alert-danger").remove();
                    jQuery.ajax({
                        url: schoolUrl+"/users/" + userId +'/restore',
                        type: 'GET',
                        data: userId,
                        success: function( data ) {
                            if ( data.status == true ) {
                                showmessage(data.message);
                            } else {
                                showmessage(data.message);
                            }
                            studentlist.ajax.reload();
                            showloader();
                        },
                        error: function( data ) {
                            if ( data.status === false) {
                                showmessage(data.message);
                            }
                            showloader();
                        }
                    });

                    return false;
                });
            });

        });
    </script>
@endsection