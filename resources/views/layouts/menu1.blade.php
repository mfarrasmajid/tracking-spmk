<!-- Pakai syntax ini untuk validasi menu yang aktif-->
@php 
    $path = $_SERVER['REQUEST_URI'];
    $path_short = explode('/document', $path);
    $path_cut_1 = explode('?', $path_short[1]);
    $path_cut_2 = explode('#', $path_cut_1[0]);
    $path_current = explode('/', $path_cut_2[0]);
@endphp
<!-- end draw variable -->

<div class="header-tabs overflow-auto mx-4 ms-lg-10 mb-5 mb-lg-0" id="kt_header_tabs" data-kt-swapper="true" data-kt-swapper-mode="prepend" data-kt-swapper-parent="{default: '#kt_header_navs_wrapper', lg: '#kt_brand_tabs'}">
    <ul class="nav flex-nowrap">
        <li class="nav-item">
            <a class="nav-link @if (count($path_current) >= 2) @if ($path_current[1] == 'dashboard') active @endif @endif" data-bs-toggle="tab" href="#kt_header_navs_tab_1">Dashboard</a>
        </li>
    </ul>
</div>
