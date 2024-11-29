@extends('layouts.blank')

@section('title', 'Login')

@section('contents')
<div class="d-flex flex-column flex-column-fluid bgi-position-y-bottom position-x-center bgi-no-repeat bgi-size-contain bgi-attachment-fixed" style="background-image: url({{ asset('assets/img/background.png')}})">
    <!--begin::Content-->
    <div class="d-flex flex-center flex-column flex-column-fluid p-10 pb-lg-20">
        <!--begin::Logo-->
        <a href="{{ url('/') }}" class="mb-12">
            <img alt="Logo" src="{{ asset('assets/img/logo_mitratel.png')}}" class="h-40px" />
        </a>
        <!--end::Logo-->
        @if ($data['init'])
        <!--begin::Wrapper-->
        <div class="w-lg-500px bg-body rounded shadow-sm p-10 p-lg-15 mx-auto">
            <!--begin::Form-->
            <form method="POST" class="form w-100" id="kt_sign_in_form" action="{{ url('/absen_event') }}/{{$data['id']}}">
                @csrf
                <!--begin::Heading-->
                <div class="text-center mb-10">
                    <!--begin::Link-->
                    <div class="text-gray-400 fw-bold fs-4">Selamat Datang</div>
                    <!--end::Link-->
                    <!--begin::Title-->
                    <h1 class="text-dark mb-3">Absen {{$data['event_list']->event}} {{$data['date']}}</h1>
                    <!--end::Title-->
                </div>
                <!--begin::Heading-->
                <!--begin::Input group-->
                <div class="fv-row mb-10">
                    <!--begin::Label-->
                    <label class="form-label fs-6 fw-bolder text-dark">NIK TG / PASSCODE</label>
                    <!--end::Label-->
                    <!--begin::Input-->
                    <input class="form-control form-control-lg form-control-solid mb-5" required type="text" name="nik_tg"/>
                    <!--end::Input-->
                    <!--begin::Radio-->
                    <div class="form-check form-check-custom form-check-solid mb-5">
                        <!--begin::Input-->
                        <input class="form-check-input me-3" checked name="status" type="radio" value="HADIR"/>
                        <!--end::Input-->

                        <!--begin::Label-->
                        <label class="form-check-label" for="kt_docs_formvalidation_radio_option_1">
                            <div class="fw-bolder text-gray-800">HADIR</div>
                        </label>
                        <!--end::Label-->
                    </div>
                    <!--end::Radio-->

                    <!--begin::Radio-->
                    <div class="form-check form-check-custom form-check-solid mb-5">
                        <!--begin::Input-->
                        <input class="form-check-input me-3" name="status" type="radio" value="TIDAK HADIR"/>
                        <!--end::Input-->

                        <!--begin::Label-->
                        <label class="form-check-label" for="kt_docs_formvalidation_radio_option_2">
                            <div class="fw-bolder text-gray-800">TIDAK HADIR</div>
                        </label>
                        <!--end::Label-->
                    </div>
                    <!--end::Radio-->
                    <!--begin::Input group-->
                    <div class="fv-row mb-5 alasan hidden">
                        <!--begin::Label-->
                        <label class="fw-bold fs-6 mb-2">Alasan Tidak Hadir</label>
                        <!--end::Label-->

                        <!--begin::Input-->
                        <textarea name="alasan" class="form-control form-control-solid"></textarea>
                        <!--end::Input-->
                    </div>
                    <!--end::Input group-->
                </div>
                <!--end::Input group-->
                <!--begin::Actions-->
                <div class="text-center">
                    <!--begin::Submit button-->
                    <button type="submit" id="kt_sign_in_submit" class="btn btn-lg btn-danger w-100 mb-5">
                        <span class="indicator-label">Absen</span>
                        <span class="indicator-progress">Please wait...
                        <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                    </button>
                    <!--end::Submit button-->
                </div>
                <!--end::Actions-->
            </form>
            <!--end::Form-->
        </div>
        <!--end::Wrapper-->
        @else
        <div class="w-lg-500px bg-body rounded shadow-sm p-10 p-lg-15 mx-auto">
            <!--begin::Heading-->
            <div class="text-center mb-10">
                @if ($data['status_absen'] == 0)
                <h1 class="text-dark mb-3">Anda sudah melakukan absen hari ini, tidak bisa absen lebih dari satu kali.</h1>
                @elseif ($data['status_absen'] == 1)
                <h1 class="text-dark mb-3">Terima kasih sudah hadir sebagai partisipan acara {{$data['event_list']->event}}, {{$data['peserta_absen']}}.</h1>
                @elseif ($data['status_absen'] == 2)
                <h1 class="text-dark mb-3">Absen tidak berhasil, mohon kontak admin event.</h1>
                @elseif ($data['status_absen'] == 3)
                <h1 class="text-dark mb-3">NIK TG anda belum terdaftar, mohon kontak admin event untuk mendaftarkan NIK TG anda.</h1>
                @endif
            </div>
            <!--begin::Heading-->
        </div>
        @endif
    </div>
    <!--end::Content-->
</div>
@stop

@section('styles')
<style>
    .hidden{
        display:none;
    }
</style>
@stop

@section('scripts')
<script>
    $('input[type=radio][name=status]').change(function() {
        if (this.value == 'HADIR') {
            $('.alasan').addClass('hidden');
            $('textarea[name="alasan"]').prop('required',false);
        }
        else if (this.value == 'TIDAK HADIR') {
            $('.alasan').removeClass('hidden');
            $('textarea[name="alasan"]').prop('required',true);
        }
    });
</script>  
@stop 
