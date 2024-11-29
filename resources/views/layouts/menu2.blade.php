<!-- Pakai syntax ini untuk validasi menu yang aktif-->
@php 
    $path = $_SERVER['REQUEST_URI'];
    $path_short = explode('/trackingspmk', $path);
    $path_cut_1 = explode('?', $path_short[1]);
    $path_cut_2 = explode('#', $path_cut_1[0]);
    $path_current = explode('/', $path_cut_2[0]);
@endphp
<!-- end draw variable -->

<div class="header-navs d-flex align-items-stretch flex-stack h-lg-70px w-100 py-5 py-lg-0" id="kt_header_navs" data-kt-drawer="true" data-kt-drawer-name="header-menu" data-kt-drawer-activate="{default: true, lg: false}" data-kt-drawer-overlay="true" data-kt-drawer-width="{default:'200px', '300px': '250px'}" data-kt-drawer-direction="start" data-kt-drawer-toggle="#kt_header_navs_toggle" data-kt-swapper="true" data-kt-swapper-mode="append" data-kt-swapper-parent="{default: '#kt_body', lg: '#kt_header'}">
    <!--begin::Container-->
    <div class="d-lg-flex container-xxl w-100">
        <!--begin::Wrapper-->
        <div class="d-lg-flex flex-column justify-content-lg-center w-100" id="kt_header_navs_wrapper">
            <!--begin::Header tab content-->
            <div class="tab-content" data-kt-scroll="true" data-kt-scroll-activate="{default: true, lg: false}" data-kt-scroll-height="auto" data-kt-scroll-offset="70px">
                <!--begin::Tab panel-->
<!-- VALIDASI DIBAWAH SINI -->
                <div class="tab-pane fade @if (count($path_current) >= 2) @if ($path_current[1] == 'dashboard') active show @endif @endif" id="kt_header_navs_tab_1">
                    <!--begin::Wrapper-->
                    <div class="d-flex flex-column flex-lg-row flex-lg-stack flex-wrap gap-2 px-4 px-lg-0">
                        <div class="d-flex flex-column flex-lg-row gap-2">
                            <a class="btn btn-sm btn-light-danger fw-bolder" href="{{ url('/dashboard') }}">Dashboard</a>
                            <a class="btn btn-sm btn-light-danger fw-bolder" href="{{ url('/dashboard/list_document') }}">List Dokumen</a>
                        </div>
                    </div>
                    <!--end::Wrapper-->
                </div>
                <!--end::Tab panel-->
            </div>
            <!--end::Header tab content-->
        </div>
        <!--end::Wrapper-->
    </div>
    <!--end::Container-->
</div>