@extends('layouts.main')

@section('title', 'Detail Document')

@section('menu', 'Detail Document')

@section('sub_menu', 'Detail List Tracking SPMK')

@section('contents')
<div class="card card-custom">
    <div class="card-header">
        <div class="card-title">
            <span class="card-icon">
                <i class="flaticon2-layers text-primary"></i>
            </span>
            <h3 class="card-label">PID {{$data['document']->pid}}</h3>
        </div>
        <div class="card-toolbar">
            @if ($data['new_doc'])
            <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#kt_modal_1">
                Tambahkan Flow Dokumen Baru
            </button>

            <div class="modal fade" tabindex="-1" id="kt_modal_1">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h3 class="modal-title">Flow Dokumen Baru</h3>

                            <!--begin::Close-->
                            <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                                <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span class="path2"></span></i>
                            </div>
                            <!--end::Close-->
                        </div>

                        <div class="modal-body">
                            <p>Anda yakin akan menambahkan flow approval dokumen baru?.</p>
                        </div>

                        <div class="modal-footer">
                            <form action="{{ url('/dashboard/new_doc') }}/{{$data['document']->id}}" method="POST">
                                @csrf
                                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Ya, Submit</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            @endif
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
                <div class="row">
                    <div class="col-lg-4">
                        <div class="mb-5">
                            <div class="fs-5 fw-bolder text-muted mb-2">PID</div>
                            <div class="fs-6 ">{{$data['document']->pid}}</div>
                        </div>
                        <div class="mb-5">
                            <div class="fs-5 fw-bolder text-muted mb-2">Site Name</div>
                            <div class="fs-6 ">{{$data['document']->site_name}}</div>
                        </div>
                        <div class="mb-5">
                            <div class="fs-5 fw-bolder text-muted mb-2">Region</div>
                            <div class="fs-6 ">{{$data['document']->region}}</div>
                        </div>
                        <div class="mb-5">
                            <div class="fs-5 fw-bolder text-muted mb-2">Supplier Name</div>
                            <div class="fs-6 ">{{$data['document']->supplier_name}}</div>
                        </div>
                        <div class="mb-5">
                            <div class="fs-5 fw-bolder text-muted mb-2">Status</div>
                            <div class="fs-6 "><span class="badge badge-sm badge-{{$data['document']->class}}">{{$data['document']->status}}</span></div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="mb-5">
                            <div class="fs-5 fw-bolder text-muted mb-2">Scope of Work</div>
                            <div class="fs-6 ">{{$data['document']->scope}}</div>
                        </div>
                        <div class="mb-5">
                            <div class="fs-5 fw-bolder text-muted mb-2">SPMK</div>
                            <div class="fs-6 ">{{$data['document']->spmk}}</div>
                        </div>
                        <div class="mb-5">
                            <div class="fs-5 fw-bolder text-muted mb-2">Aging</div>
                            <div class="fs-6 ">{{$data['aging']}} hari</div>
                        </div>
                        <div class="mb-5">
                            <div class="fs-5 fw-bolder text-muted mb-2">Amount</div>
                            <div class="fs-6 ">@php echo number_format($data['document']->amount, 0,',','.')@endphp</div>
                        </div>
                        <div class="mb-5">
                            <div class="fs-5 fw-bolder text-muted mb-2">Amount Procurement</div>
                            <div class="fs-6 ">@php echo number_format($data['document']->amount_proc, 0,',','.')@endphp</div>
                        </div>
                    </div>
                    <div class="col-lg-4 mb-10">
                        <div class="mb-2 border border-gray-600 rounded p-5">
                            <div class="fs-6 fw-bolder d-flex flex-row justify-content-between align-items-center">
                                PM Status
                                @if ($data['document']->pm_date != null)
                                <div class="d-flex flex-column align-items-end">
                                    <div class="fs-7"><span class="badge badge-success badge-sm">APPROVED</span></div>
                                    <div class="fs-7">{{ date('d M Y H:i:s', strtotime($data['document']->pm_date)) }}</div>
                                </div>
                                @else
                                <div class="d-flex flex-column align-items-end">
                                    <div class="fs-7"><span class="badge badge-dark badge-sm">PENDING</span></div>
                                    <div class="fs-7">NY Approved</div>
                                </div>
                                @endif
                            </div>
                            <div class="fs-7 fw-bolder text-gray-700">{{$data['document']->pm_name}}</div>
                            <div class="fs-7 fw-bolder text-gray-700">{{$data['document']->pm_nik}}</div>
                            <div class="fs-7 fw-bolder text-gray-700">{{$data['document']->pm_posisi}}</div>
                        </div>
                        <div class="mb-2 border border-gray-600 rounded p-5">
                            <div class="fs-6 fw-bolder d-flex flex-row justify-content-between align-items-center">
                                MGR Regional Status
                                @if ($data['document']->mgr_region_date != null)
                                <div class="d-flex flex-column align-items-end">
                                    <div class="fs-7"><span class="badge badge-success badge-sm">APPROVED</span></div>
                                    <div class="fs-7">{{ date('d M Y H:i:s', strtotime($data['document']->mgr_region_date)) }}</div>
                                </div>
                                @else
                                <div class="d-flex flex-column align-items-end">
                                    <div class="fs-7"><span class="badge badge-dark badge-sm">PENDING</span></div>
                                    <div class="fs-7">NY Approved</div>
                                </div>
                                @endif
                            </div>
                            <div class="fs-7 fw-bolder text-gray-700">{{$data['document']->mgr_region_name}}</div>
                            <div class="fs-7 fw-bolder text-gray-700">{{$data['document']->mgr_region_nik}}</div>
                            <div class="fs-7 fw-bolder text-gray-700">{{$data['document']->mgr_region_posisi}}</div>
                        </div>
                        <div class="mb-2 border border-gray-600 rounded p-5">
                            <div class="fs-6 fw-bolder d-flex flex-row justify-content-between align-items-center">
                                GM Area Status
                                @if ($data['document']->gm_area_date != null)
                                <div class="d-flex flex-column align-items-end">
                                    <div class="fs-7"><span class="badge badge-success badge-sm">APPROVED</span></div>
                                    <div class="fs-7">{{ date('d M Y H:i:s', strtotime($data['document']->gm_area_date)) }}</div>
                                </div>
                                @else
                                <div class="d-flex flex-column align-items-end">
                                    <div class="fs-7"><span class="badge badge-dark badge-sm">PENDING</span></div>
                                    <div class="fs-7">NY Approved</div>
                                </div>
                                @endif
                            </div>
                            <div class="fs-7 fw-bolder text-gray-700">{{$data['document']->gm_area_name}}</div>
                            <div class="fs-7 fw-bolder text-gray-700">{{$data['document']->gm_area_nik}}</div>
                            <div class="fs-7 fw-bolder text-gray-700">{{$data['document']->gm_area_posisi}}</div>
                        </div>
                        <div class="mb-2 border border-gray-600 rounded p-5">
                            <div class="fs-6 fw-bolder d-flex flex-row justify-content-between align-items-center">
                                MGR Construction Status
                                @if ($data['document']->mgr_cons_date != null)
                                <div class="d-flex flex-column align-items-end">
                                    <div class="fs-7"><span class="badge badge-success badge-sm">APPROVED</span></div>
                                    <div class="fs-7">{{ date('d M Y H:i:s', strtotime($data['document']->mgr_cons_date)) }}</div>
                                </div>
                                @else
                                <div class="d-flex flex-column align-items-end">
                                    <div class="fs-7"><span class="badge badge-dark badge-sm">PENDING</span></div>
                                    <div class="fs-7">NY Approved</div>
                                </div>
                                @endif
                            </div>
                            <div class="fs-7 fw-bolder text-gray-700">{{$data['document']->mgr_cons_name}}</div>
                            <div class="fs-7 fw-bolder text-gray-700">{{$data['document']->mgr_cons_nik}}</div>
                            <div class="fs-7 fw-bolder text-gray-700">{{$data['document']->mgr_cons_posisi}}</div>
                        </div>
                        <div class="mb-2 border border-gray-600 rounded p-5">
                            <div class="fs-6 fw-bolder d-flex flex-row justify-content-between align-items-center">
                                GM Construction Status
                                @if ($data['document']->gm_cons_date != null)
                                <div class="d-flex flex-column align-items-end">
                                    <div class="fs-7"><span class="badge badge-success badge-sm">APPROVED</span></div>
                                    <div class="fs-7">{{ date('d M Y H:i:s', strtotime($data['document']->gm_cons_date)) }}</div>
                                </div>
                                @else
                                <div class="d-flex flex-column align-items-end">
                                    <div class="fs-7"><span class="badge badge-dark badge-sm">PENDING</span></div>
                                    <div class="fs-7">NY Approved</div>
                                </div>
                                @endif
                            </div>
                            <div class="fs-7 fw-bolder text-gray-700">{{$data['document']->gm_cons_name}}</div>
                            <div class="fs-7 fw-bolder text-gray-700">{{$data['document']->gm_cons_nik}}</div>
                            <div class="fs-7 fw-bolder text-gray-700">{{$data['document']->gm_cons_posisi}}</div>
                        </div>
                        <div class="mb-2 border border-gray-600 rounded p-5">
                            <div class="fs-6 fw-bolder d-flex flex-row justify-content-between align-items-center">
                                MGR Procurement Status
                                @if ($data['document']->mgr_proc_date != null)
                                <div class="d-flex flex-column align-items-end">
                                    <div class="fs-7"><span class="badge badge-success badge-sm">APPROVED</span></div>
                                    <div class="fs-7">{{ date('d M Y H:i:s', strtotime($data['document']->mgr_proc_date)) }}</div>
                                </div>
                                @else
                                <div class="d-flex flex-column align-items-end">
                                    <div class="fs-7"><span class="badge badge-dark badge-sm">PENDING</span></div>
                                    <div class="fs-7">NY Approved</div>
                                </div>
                                @endif
                            </div>
                            <div class="fs-7 fw-bolder text-gray-700">{{$data['document']->mgr_proc_name}}</div>
                            <div class="fs-7 fw-bolder text-gray-700">{{$data['document']->mgr_proc_nik}}</div>
                            <div class="fs-7 fw-bolder text-gray-700">{{$data['document']->mgr_proc_posisi}}</div>
                        </div>
                        <div class="mb-2 border border-gray-600 rounded p-5">
                            <div class="fs-6 fw-bolder d-flex flex-row justify-content-between align-items-center">
                                VP Procurement Status
                                @if ($data['document']->vp_proc_date != null)
                                <div class="d-flex flex-column align-items-end">
                                    <div class="fs-7"><span class="badge badge-success badge-sm">APPROVED</span></div>
                                    <div class="fs-7">{{ date('d M Y H:i:s', strtotime($data['document']->vp_proc_date)) }}</div>
                                </div>
                                @else
                                <div class="d-flex flex-column align-items-end">
                                    <div class="fs-7"><span class="badge badge-dark badge-sm">PENDING</span></div>
                                    <div class="fs-7">NY Approved</div>
                                </div>
                                @endif
                            </div>
                            <div class="fs-7 fw-bolder text-gray-700">{{$data['document']->vp_proc_name}}</div>
                            <div class="fs-7 fw-bolder text-gray-700">{{$data['document']->vp_proc_nik}}</div>
                            <div class="fs-7 fw-bolder text-gray-700">{{$data['document']->vp_proc_posisi}}</div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="mb-2">
                            <div class="fs-5 fw-bolder">Get Latest Document:</div>
                            @foreach($data['latest_document'] as $l)
                            <div><a href="{{ asset('/storage')}}/{{$l}}" target="_blank">{{$l}}</a></div>
                            @endforeach
                        </div>
                    </div>
                    @if ($data['privilege'])
                    <div class="col-lg-6">
                        <div class="mb-5">
                            <form action="{{url('/dashboard/list_document')}}/{{$data['document']->id}}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="fs-1 fw-bolder mb-5">Update Progress as {{$data['latest_pic']}}:</div>
                                <div class="fv-row fv-plugins-icon-container fv-plugins-bootstrap5-row-valid">
                                    <!--begin::Label-->
                                    <label class="d-flex align-items-center fs-5 fw-semibold mb-2">
                                        <span class="required">Upload Document (pdf)</span>
                                        <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip" title="Amount Procurement"></i>
                                    </label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <input type="file" name="document[]" multiple="multiple" class="form-control form-control-solid" accept=".pdf" required>
                                    <!--end::Input-->
                                    <div class="fv-plugins-message-container invalid-feedback"></div>
                                </div>
                                @if ($data['privilege_proc'])
                                <div class="fv-row fv-plugins-icon-container fv-plugins-bootstrap5-row-valid">
                                    <!--begin::Label-->
                                    <label class="d-flex align-items-center fs-5 fw-semibold mb-2">
                                        <span class="required">Amount by Procurement</span>
                                        <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip" title="Amount Procurement"></i>
                                    </label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <input type="text" name="amount_proc" class="form-control form-control-solid number" required>
                                    <!--end::Input-->
                                    <div class="fv-plugins-message-container invalid-feedback"></div>
                                </div>
                                @endif
                                <button type="submit" class="btn btn-primary btn-sm">Submit</button>
                            </form>
                        </div>
                    </div>
                    @endif
                </div>
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
<link href="{{ asset('assets/plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
<style>
    .dataTables_wrapper .dataTable th, .dataTables_wrapper .dataTable td {padding: 5px; font-size: 12px;}
</style>
@stop 

@section('scripts')
<script src="{{ asset('assets/plugins/custom/datatables/datatables.bundle.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
<script src="{{ asset('assets/jquery.number.min.js')}}"></script>
<script>
    $(document).ready(function () {     
        $('input.number').number(true, 0, ',', '.');
    })
</script>
@stop 