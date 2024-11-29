@extends('layouts.main')

@section('title', 'Manage Peserta Radir')

@section('menu', 'Manage Peserta Radir')

@section('sub_menu', 'Tambahkan atau Edit Peserta Radir yang Dapat Akses ke Absensi Radir')

@section('contents')
<div class="card card-custom">
    <div class="card-header">
        <div class="card-title">
            <span class="card-icon">
                <i class="flaticon2-layers text-primary"></i>
            </span>
            <h3 class="card-label">Manage Peserta Radir</h3>
        </div>
        <div class="card-toolbar">
            <!--begin::Button-->
            <a href="{{ url('/admin/add_peserta') }}" class="btn btn-danger font-weight-bolder">
            <i class="la la-plus"></i>Add Peserta</a>
            <!--end::Button-->
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
        <!--begin: Datatable-->
        <table class="table table-row-bordered gy-5" id="kt_datatable">
            <thead>
                <tr>
                    <th>No</th>
                    <th>NIK TG</th>
                    <th>Name</th>
                    <th>Unit</th>
                    <th>Direktorat</th>
                    <th>Jabatan</th>
                    <th>Group</th>
                    <th>Priority</th>
                    <th>Priority Number</th>
                    <th>Photo</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($data['peserta'] as $u)
                <tr>
                    <td>{{$loop->iteration}}</td>
                    <td>{{$u->nik_tg}}</td>
                    <td>{{$u->name}}</td>
                    <td>{{$u->unit}}</td>
                    <td>{{$u->direktorat}}</td>
                    <td>{{$u->jabatan}}</td>
                    <td>{{$u->group}}</td>
                    @if ($u->priority == '1')
                    <td>Direktur</td>
                    @elseif ($u->priority == '2')
                    <td>SVP</td>
                    @elseif ($u->priority == '3')
                    <td>EGM</td>
                    @elseif ($u->priority == '4')
                    <td>VP</td>
                    @elseif ($u->priority == '5')
                    <td>GM</td>
                    @else
                    <td>Belum Diassign</td>
                    @endif
                    @php if ($u->priority_number < 100) {
                        $u->priority_number = '0'.$u->priority_number;
                    }
                    @endphp
                    <td>{{$u->priority}}-{{$u->priority_number}}</td>  
                    <td><img src="{{asset('eviden')}}/{{$u->photo}}" class="h-50px" alt="Photo"></td>
                    <td>{{$u->id}}</td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <th>No</th>
                    <th>NIK TG</th>
                    <th>Name</th>
                    <th>Unit</th>
                    <th>Direktorat</th>
                    <th>Jabatan</th>
                    <th>Group</th>
                    <th>Priority</th>
                    <th>Priority Number</th>
                    <th>Photo</th>
                    <th>Actions</th>
                </tr>
            </tfoot>
        </table>
        <!--end: Datatable-->
        <form id="csrf_dummy">
            @csrf
        </form>
    </div>
</div>
<!--end::Card-->
@stop 

@section('styles')
<link href="{{ asset('assets/plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
<style>
    .dataTables_wrapper .dataTable th, .dataTables_wrapper .dataTable td {padding: 5px; font-size: 12px;}
</style>
@stop 

@section('scripts')
<script src="{{ asset('assets/plugins/custom/datatables/datatables.bundle.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
<script>
    var KTDatatablesAdvancedColumnRendering = function() {

	var init = function() {
		var table = $('#kt_datatable');

		// begin first table
		table.DataTable({
            dom: `<'row'<'col-sm-6 text-left'f><'col-sm-6 text-right'B>>
            <'row'<'col-sm-12'tr>>
			<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7 dataTables_pager'lp>>`,
            lengthMenu: [5, 10, 25, 50],

            buttons: [
				'print',
				'copyHtml5',
				'excelHtml5',
				'csvHtml5',
				'pdfHtml5',
			],
            pageLength: 10,
			responsive: true,
			paging: true,
			columnDefs: [{
                    targets: -1, // Actions
                    title: 'Actions',
                    orderable: false,
                    render: function(data, type, full, meta) {
                        return '\
							<a href="{{url("/admin/add_peserta/")}}/' + data + '" class="btn btn-sm btn-clean btn-icon" title="Edit">\
								<i class="la la-edit"></i>\
							</a>\
							<a href="javascript:;" data-id="' + data + '" class="btn btn-sm btn-clean btn-icon manage-delete" title="Delete">\
								<i class="la la-trash"></i>\
							</a>\
						';
                    },
                },
            ],
		}).on('click', '.manage-delete', function(){
            var id = $(this).data('id');
            $.confirm({
                title: 'Delete Peserta!',
                content: 'Apakah anda yakin akan menghapus peserta ini?',
                type: 'red',
                buttons: {
                    hapus: {
                        text: 'Hapus',
                        btnClass: 'btn-red',
                        action : function () {
                            $.ajax({
                                url: '{{ url("/admin/delete_peserta")}}/' + id,
                                data: $('#csrf_dummy').serialize(),
                                method: 'POST',
                                success : function() {
                                    location.reload();
                                },
                                error : function (e) {
                                    console.log(e);
                                    $.alert({
                                        title: 'Error!',
                                        content: 'Delete Peserta Failed',
                                    });
                                }
                            });
                        },
                    },
                    cancel: {
                        text: 'Cancel',
                        keys: ['enter', 'shift'],
                        action : function () {
                        
                        },
                    }
                }
            });                      
        });
	};

	return {

		//main function to initiate the module
		init: function() {
			init();
		}
	};
}();

jQuery(document).ready(function() {
	KTDatatablesAdvancedColumnRendering.init();
});
</script>
@stop 