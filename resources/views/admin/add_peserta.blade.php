@extends('layouts.main')

@section('title', 'Add Peserta')

@if (isset($data['id']))
@section('menu', 'Edit Peserta')
@section('sub_menu', 'Ubah Data Peserta')
@else 
@section('menu', 'Add Peserta')
@section('sub_menu', 'Tambahkan Peserta Baru')
@endif

@section('contents')
<div class="card card-custom">
    <div class="card-header">
    <h3 class="card-title">
    @if (isset($data['id']))
    Edit Peserta ID {{$data['id']}}
    @else
    Input Peserta Baru
    @endif
    </h3>
    </div>
    <!--begin::Form-->
    <form class="form" enctype="multipart/form-data" method="POST" @if(isset($data['id'])) action="{{url('/admin/add_peserta').'/'.$data['id']}}" @else action="{{ url('/admin/add_peserta') }}" @endif>
    @csrf
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
            <div class="form-group mb-5">
                <label class="mb-2">NIK TG</label>
                <input type="text" class="form-control" name="nik_tg" @if(isset($data['id'])) value="{{$data['peserta']->nik_tg}}" @endif required/>
            </div>
            <div class="form-group mb-5">
                <label class="mb-2">Name</label>
                <input type="text" class="form-control" name="name" @if(isset($data['id'])) value="{{$data['peserta']->name}}" @endif required/>
            </div>
            <div class="form-group mb-5">
                <label class="mb-2">Unit</label>
                <input type="text" class="form-control" name="unit" @if(isset($data['id'])) value="{{$data['peserta']->unit}}" @endif required/>
            </div>
            <div class="form-group mb-5">
                <label class="mb-2">Direktorat</label>
                <input type="text" class="form-control" name="direktorat" @if(isset($data['id'])) value="{{$data['peserta']->direktorat}}" @endif required/>
            </div>
            <div class="form-group mb-5">
                <label class="mb-2">Jabatan</label>
                <input type="text" class="form-control" name="jabatan" @if(isset($data['id'])) value="{{$data['peserta']->jabatan}}" @endif required/>
            </div>
            <div class="form-group mb-5">
                <label class="mb-2">Group Radir (Boleh Lebih Dari Satu)</label>
                <div class="form-check form-check-custom form-check-solid">
                    <input class="form-check-input" type="checkbox" name="group_1" value="1" checked="checked" />
                    <label class="form-check-label form-control" for="flexCheckChecked" style="border: 0;">
                        Group 1: All SL
                    </label>
                </div>
                <div class="form-check form-check-custom form-check-solid">
                    <input class="form-check-input" type="checkbox" name="group_2" value="2" @if (isset($data['id'])) @if($data['group_2'] == '2') checked="checked" @endif @endif />
                    <label class="form-check-label form-control" for="flexCheckChecked" style="border: 0;">
                        Group 2: Khusus
                    </label>
                </div>
            </div>
            <div class="form-group mb-5">
                <label class="mb-2">Prioritas Urutan</label>
                <div class="form-check form-check-custom form-check-solid mb-2">
                    <input class="form-check-input" type="radio" name="priority" @if (isset($data['id'])) @if($data['peserta']->priority == '1') checked="checked" @endif @endif value="1" />
                    <label class="form-check-label">
                        Direktur
                    </label>
                </div>
                <div class="form-check form-check-custom form-check-solid mb-2">
                    <input class="form-check-input" type="radio" name="priority" @if (isset($data['id'])) @if($data['peserta']->priority == '2') checked="checked" @endif @endif value="2"/>
                    <label class="form-check-label">
                        SVP
                    </label>
                </div>
                <div class="form-check form-check-custom form-check-solid mb-2">
                    <input class="form-check-input" type="radio" name="priority" @if (isset($data['id'])) @if($data['peserta']->priority == '3') checked="checked" @endif @endif value="3"/>
                    <label class="form-check-label">
                        EGM
                    </label>
                </div>
                <div class="form-check form-check-custom form-check-solid mb-2">
                    <input class="form-check-input" type="radio" name="priority" @if (isset($data['id'])) @if($data['peserta']->priority == '4') checked="checked" @endif @endif value="4"/>
                    <label class="form-check-label">
                        VP
                    </label>
                </div>
                <div class="form-check form-check-custom form-check-solid">
                    <input class="form-check-input" type="radio" name="priority" @if (isset($data['id'])) @if($data['peserta']->priority == '5') checked="checked" @endif @endif value="5"/>
                    <label class="form-check-label">
                        GM
                    </label>
                </div>
            </div>
            <div class="form-group mb-5">
                <label class="mb-2">Prioritas Nomor</label>
                <input type="text" class="form-control" name="priority_number" @if(isset($data['id'])) value="{{$data['peserta']->priority_number}}" @endif required/>
            </div>
            <input class="replace" type="text" hidden name="replace" value="0">
            @if (!isset($data['id']))
            <input class="replace_name" type="text" hidden name="replace_name" value="">
            @elseif ($data['peserta']->photo != NULL)
            <input class="replace_name" type="text" hidden name="replace_name" value="{{$data['peserta']->photo}}">
            @else
            <input class="replace_name" type="text" hidden name="replace_name" value="">
            @endif
            <div class="form-group mb-5">
                <div class="mb-2">Photo</div>
                <!--begin::Image input-->
                <div class="image-input image-input-outline" data-kt-image-input="true" style="background-image: url({{ asset('assets/media/svg/avatars/blank.svg')}})">
                    <!--begin::Image preview wrapper-->
                    @if (!isset($data['id']))
                    <div class="image-input-wrapper w-125px h-125px" style="background-image: url({{ asset('assets/media/svg/avatars/blank.svg')}})"></div>
                    @elseif ($data['peserta']->photo != NULL)
                    <div class="image-input-wrapper w-125px h-125px" style="background-image: url({{ asset('eviden')}}/{{$data['peserta']->photo}})"></div>
                    @else
                    <div class="image-input-wrapper w-125px h-125px" style="background-image: url({{ asset('assets/media/svg/avatars/blank.svg')}})"></div>
                    @endif
                    <!--end::Image preview wrapper-->

                    <!--begin::Edit button-->
                    <label class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                        data-kt-image-input-action="change"
                        data-bs-toggle="tooltip"
                        data-bs-dismiss="click"
                        title="Change photo">
                        <i class="bi bi-pencil-fill fs-7"></i>

                        <!--begin::Inputs-->
                        <input type="file" name="photo" accept=".png, .jpg, .jpeg" />
                        <input type="hidden" name="avatar_remove" />
                        <!--end::Inputs-->
                    </label>
                    <!--end::Edit button-->

                    <!--begin::Cancel button-->
                    <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                        data-kt-image-input-action="cancel"
                        data-bs-toggle="tooltip"
                        data-bs-dismiss="click"
                        title="Cancel photo">
                        <i class="bi bi-x fs-2"></i>
                    </span>
                    <!--end::Cancel button-->

                    <!--begin::Remove button-->
                    <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                        data-kt-image-input-action="remove"
                        data-bs-toggle="tooltip"
                        data-bs-dismiss="click"
                        title="Remove photo">
                        <i class="bi bi-x fs-2"></i>
                    </span>
                    <!--end::Remove button-->
                </div>
                <!--end::Image input-->
            </div>
        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-danger mr-2">Submit</button>
            <a href="{{url('/admin/manage_peserta')}}" class="btn btn-secondary">Back</a>
        </div>
    </form>
    <!--end::Form-->
</div>
@stop 

@section('styles')
@stop 

@section('scripts')
<script>
jQuery(document).ready(function() {
	KTImageInput.createInstances();
    $('span[data-kt-image-input-action="remove"]').on('click', function(){
        $('.replace').val('1');
    });
    $('span[data-kt-image-input-action="change"]').on('click', function(){
        $('.replace').val('0');
    });
});
    
</script>
@stop 