@extends('layouts.main')

@section('title', 'Manage Users')

@section('menu', 'Manage Users')

@section('sub_menu', 'Manage Users Special Privilege')

@section('contents')
<div class="card card-custom" id="manage_table">
    <div class="card-header">
        <div class="card-title">
            <span class="card-icon">
                <i class="flaticon2-layers text-primary"></i>
            </span>
            <h3 class="card-label">Manage Users</h3>
        </div>
        <div class="card-toolbar">
            <a href="{{ url('/admin/detail_users')}}" class="btn btn-sm btn-primary">
                Add User Special Privilege
            </a>
        </div>
    </div>
    <div class="card-body">
        @if (session('error'))
        <div class="alert alert-danger d-flex align-items-center">
            <span class="svg-icon svg-icon-2hx svg-icon-danger me-3"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                <path opacity="0.3" d="M12 10.6L14.8 7.8C15.2 7.4 15.8 7.4 16.2 7.8C16.6 8.2 16.6 8.80002 16.2 9.20002L13.4 12L12 10.6ZM10.6 12L7.8 14.8C7.4 15.2 7.4 15.8 7.8 16.2C8 16.4 8.3 16.5 8.5 16.5C8.7 16.5 8.99999 16.4 9.19999 16.2L12 13.4L10.6 12Z" fill="black"/>
                <path d="M22 12C22 17.5 17.5 22 12 22C6.5 22 2 17.5 2 12C2 6.5 6.5 2 12 2C17.5 2 22 6.5 22 12ZM13.4 12L16.2 9.20001C16.6 8.80001 16.6 8.19999 16.2 7.79999C15.8 7.39999 15.2 7.39999 14.8 7.79999L12 10.6L9.2 7.79999C8.8 7.39999 8.2 7.39999 7.8 7.79999C7.4 8.19999 7.4 8.80001 7.8 9.20001L10.6 12L7.8 14.8C7.4 15.2 7.4 15.8 7.8 16.2C8 16.4 8.3 16.5 8.5 16.5C8.7 16.5 9 16.4 9.2 16.2L12 13.4L14.8 16.2C15 16.4 15.3 16.5 15.5 16.5C15.7 16.5 16 16.4 16.2 16.2C16.6 15.8 16.6 15.2 16.2 14.8L13.4 12Z" fill="black"/>
                </svg></span>
            <div class="d-flex flex-column">
                <h4 class="mb-1 text-danger">Error</h4>
                <span>{{ session('error')}}</span>
            </div>
            <button type="button" class="position-absolute position-sm-relative m-2 m-sm-0 top-0 end-0 btn btn-icon ms-sm-auto" data-bs-dismiss="alert">
                <span class="svg-icon svg-icon-2x svg-icon-light"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                <path opacity="0.3" d="M6 19.7C5.7 19.7 5.5 19.6 5.3 19.4C4.9 19 4.9 18.4 5.3 18L18 5.3C18.4 4.9 19 4.9 19.4 5.3C19.8 5.7 19.8 6.29999 19.4 6.69999L6.7 19.4C6.5 19.6 6.3 19.7 6 19.7Z" fill="black"/>
                <path d="M18.8 19.7C18.5 19.7 18.3 19.6 18.1 19.4L5.40001 6.69999C5.00001 6.29999 5.00001 5.7 5.40001 5.3C5.80001 4.9 6.40001 4.9 6.80001 5.3L19.5 18C19.9 18.4 19.9 19 19.5 19.4C19.3 19.6 19 19.7 18.8 19.7Z" fill="black"/>
                </svg></span>
            </button>
        </div>
        @endif
        @if (session('success'))
        <div class="alert alert-success d-flex align-items-center">
            <span class="svg-icon svg-icon-2hx svg-icon-success me-3"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
            <path opacity="0.3" d="M10.3 14.3L11 13.6L7.70002 10.3C7.30002 9.9 6.7 9.9 6.3 10.3C5.9 10.7 5.9 11.3 6.3 11.7L10.3 15.7C9.9 15.3 9.9 14.7 10.3 14.3Z" fill="black"/>
            <path d="M22 12C22 17.5 17.5 22 12 22C6.5 22 2 17.5 2 12C2 6.5 6.5 2 12 2C17.5 2 22 6.5 22 12ZM11.7 15.7L17.7 9.70001C18.1 9.30001 18.1 8.69999 17.7 8.29999C17.3 7.89999 16.7 7.89999 16.3 8.29999L11 13.6L7.70001 10.3C7.30001 9.89999 6.69999 9.89999 6.29999 10.3C5.89999 10.7 5.89999 11.3 6.29999 11.7L10.3 15.7C10.5 15.9 10.8 16 11 16C11.2 16 11.5 15.9 11.7 15.7Z" fill="black"/>
            </svg></span>
            <div class="d-flex flex-column">
                <h4 class="mb-1 text-success">Success</h4>
                <span>{{ session('success')}}</span>
            </div>
            <button type="button" class="position-absolute position-sm-relative m-2 m-sm-0 top-0 end-0 btn btn-icon ms-sm-auto" data-bs-dismiss="alert">
                <span class="svg-icon svg-icon-2x svg-icon-light"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                <path opacity="0.3" d="M6 19.7C5.7 19.7 5.5 19.6 5.3 19.4C4.9 19 4.9 18.4 5.3 18L18 5.3C18.4 4.9 19 4.9 19.4 5.3C19.8 5.7 19.8 6.29999 19.4 6.69999L6.7 19.4C6.5 19.6 6.3 19.7 6 19.7Z" fill="black"/>
                <path d="M18.8 19.7C18.5 19.7 18.3 19.6 18.1 19.4L5.40001 6.69999C5.00001 6.29999 5.00001 5.7 5.40001 5.3C5.80001 4.9 6.40001 4.9 6.80001 5.3L19.5 18C19.9 18.4 19.9 19 19.5 19.4C19.3 19.6 19 19.7 18.8 19.7Z" fill="black"/>
                </svg></span>
            </button>
        </div>
        @endif
        <div class="row">
            <div class="col-lg-12">
                @csrf
                <table class="table table-rounded table-striped border gy-5 gs-5" id="datatable">
                    <thead>
                        <tr>
                            <th style="min-width: 30px; font-weight:600;">#</th>
                            <th style="min-width: 80px; font-weight:600;">NIK TG</th>
                            <th style="min-width: 80px; font-weight:600;">Actions</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th style="min-width: 30px; font-weight:600;">#</th>
                            <th style="min-width: 80px; font-weight:600;">NIK TG</th>
                            <th style="min-width: 80px; font-weight:600;">Actions</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
        <!--begin: Datatable-->
        <!--end: Datatable-->
        <form id="csrf_dummy">
            @csrf
        </form>
    </div>
</div>
<!--end::Card-->
@stop 

@section('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
<link href="{{ asset('assets/plugins/custom/datatables/datatables.bundle.css')}}" rel="stylesheet" type="text/css"/>
<style>
    .hidden {display:none;}
    tr th {padding: 10px !important;}
    tr td {padding: 1px 1px 1px 5px !important; font-size: 12px !important; vertical-align: middle !important;}
    .table-striped>tbody>tr:nth-of-type(odd)>* { --bs-table-accent-bg: #eeeeee !important;}
</style>
@stop

@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
<script src="{{ asset('assets/plugins/custom/datatables/datatables.bundle.js')}}"></script>
<script>
    var DataTable = function () {
    var blockUI = new KTBlockUI(document.querySelector('#manage_table'), {
        message: '<div class="blockui-message"><span class="spinner-border text-primary"></span> Loading...</div>',
    });
    var initTable = function initTable() {
      var table = $('#datatable');

      
  
      var datatable = table.DataTable({
        fixedHeader: {
            header: true,
            headerOffset: 70,
        },
        scrollX: true,
        scrollCollapse: true,
        processing: true,
        serverSide: true,
        // ordering: false,
        // oSearch: {"sSearch": "{{Session::get('searchQry')}}" },
        ajax: {
          url: "{{ url('/')}}/admin/api/get_list_manage_users",
          data: {
            _token : $("input[name='_token']").val()
          },
          type: 'GET',
        },
        order: [2, 'asc'],
        dom:
        "<'row'" +
        "<'col-sm-6 d-flex align-items-center justify-content-start'l>" +
        "<'col-sm-6 d-flex align-items-center justify-content-end'f>" +
        ">" +

        "<'table-responsive'tr>" +

        "<'row'" +
        "<'col-sm-12 col-md-5 d-flex align-items-center justify-content-center justify-content-md-start'i>" +
        "<'col-sm-12 col-md-7 d-flex align-items-center justify-content-center justify-content-md-end'p>" +
        ">",
        "lengthMenu": [ [10, 25, 50, -1], [10, 25, 50, "All"] ],
        // columnDefs: [{
        //   targets: [1, -1],
        //   orderable: false,
        //   width: '125px'
        // },{
        //   targets: [0,1,3,4
        //     @for($i = 6; $i <= 109; $i++)
        //     , {{$i}}
        //     @endfor
        //   ],
        //   orderable: false
        // },{
        //   targets: [2,5],
        //   orderable: true
        // }
        // {
        //     className: 'select-checkbox',
        //     targets:   0
        // }
        // ],
        // select: {
        //     style: 'multi',
        //     // selector: 'td:first-child'
        // },
      }).on('click', '.btn-delete',function(){
        var id = $(this).attr('data-id');
        var token = $('input[name="_token"]').val();
        var formData = new FormData();
        formData.append('_token', token);
        if ($(this).hasClass('btn-delete')){
          $.confirm({
              title: 'Konfirmasi Delete User',
              content: 'Apakah anda yakin akan menghapus user ini?',
              type: 'red',
              typeAnimated: true,
              buttons: {
                  ya: {
                      text: 'Delete',
                      btnClass: 'btn-red',
                      action: function(){
                          blockUI.block();
                          $.ajax({
                              url: "{{ url('/')}}/admin/delete_users/" + id,
                              type: 'POST',
                              data: formData,
                              processData: false,
                              contentType: false,
                              success: function(response) {
                                  blockUI.release();
                                  location.reload();
                              },error: function(error){
                                  console.log(error)
                              }
                          });
                      }
                  },
                  cancel: function () {
                  }
              }
          });
        }
      });

    //   $('#tahun').on( 'change', function () {
    //   datatable
    //       .columns( 5 )
    //       .search( this.value )
    //       .draw();
    //   });

      datatable.on( 'draw.dt', function () {
      var PageInfo = $('#datatable').DataTable().page.info();
          datatable.column(0, { page: 'current' }).nodes().each( function (cell, i) {
              cell.innerHTML = i + 1 + PageInfo.start;
          } );
          datatable.column(-1, { page: 'current' }).nodes().each( function (cell, i) {
              cell.innerHTML = '<div style="white-space:nowrap">\
                              <a href="{{ url("admin/detail_users") }}/'+ cell.innerHTML + '" class="btn btn-sm btn-secondary me-2 px-5 py-2 my-1" title="Edit Users">\
                                Edit User\
                              </a>\
                              <a data-id="' +  cell.innerHTML + '" class="btn btn-sm btn-clean btn-icon btn-delete" title="Delete">\
                                    <span class="svg-icon svg-icon-muted svg-icon-5"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">\
                                    <path d="M5 9C5 8.44772 5.44772 8 6 8H18C18.5523 8 19 8.44772 19 9V18C19 19.6569 17.6569 21 16 21H8C6.34315 21 5 19.6569 5 18V9Z" fill="currentColor"/>\
                                    <path opacity="0.5" d="M5 5C5 4.44772 5.44772 4 6 4H18C18.5523 4 19 4.44772 19 5V5C19 5.55228 18.5523 6 18 6H6C5.44772 6 5 5.55228 5 5V5Z" fill="currentColor"/>\
                                    <path opacity="0.5" d="M9 4C9 3.44772 9.44772 3 10 3H14C14.5523 3 15 3.44772 15 4V4H9V4Z" fill="currentColor"/>\
                                    </svg></span>\
                              </a>\
                          </div>';
          });
      });

    };

   
  
    return {
      //main function to initiate the module
      init: function init() {
        initTable();
      }
    };
  }();

    $(document).ready(function () {     
        DataTable.init();     
    })
</script>
@stop 