<!DOCTYPE html>
<html lang="en">
	<!--begin::Head-->
	<head>
		<title>Tracking SPMK | @yield('title')</title>
		<meta charset="utf-8" />
		<meta name="description" content="Tracking SPMK" />
		<meta name="keywords" content="Absensi, Radir, Mitratel" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<link rel="shortcut icon" href="{{ asset('icon.ico')}}" />
		<!--begin::Fonts-->
		<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" />
		<!--end::Fonts-->
		<!--begin::Page Vendor Stylesheets(used by this page)-->
		<!------------ NOTE FOR YANUAR: Vendor CSS per Page bisa diliat di Demo20 -->
		<!--end::Page Vendor Stylesheets-->
		<!--begin::Global Stylesheets Bundle(used by all pages)-->
		<link href="{{ asset('assets/plugins/global/plugins.bundle.css')}}" rel="stylesheet" type="text/css" />
		<link href="{{ asset('assets/css/style.bundle.css')}}" rel="stylesheet" type="text/css" />
		<!--end::Global Stylesheets Bundle-->
        @yield('styles')
		<style>
			.header {
				background-color: #ae0000;
			}
		</style>	
	</head>
	<!--end::Head-->
	<!--begin::Body-->
	<body id="kt_body" class="header-extended header-fixed header-tablet-and-mobile-fixed">
		<!--begin::Main-->
		<!--begin::Root-->
		<div class="d-flex flex-column flex-root">
			<!--begin::Page-->
			<div class="page d-flex flex-row flex-column-fluid">
				<!--begin::Wrapper-->
				<div class="wrapper d-flex flex-column flex-row-fluid" id="kt_wrapper">
					<!--begin::Header-->
					<div id="kt_header" class="header">
						<!--begin::Header top-->
						<div class="header-top d-flex align-items-stretch flex-grow-1">
							<!--begin::Container-->
							<div class="d-flex container-xxl w-100">
								<!--begin::Wrapper-->
								<div class="d-flex flex-stack align-items-stretch w-100">
									<!--begin::Brand-->
									<div class="d-flex align-items-center align-items-lg-stretch me-5">
										<!--begin::Heaeder navs toggle-->
										<button class="d-lg-none btn btn-icon btn-color-white bg-hover-white bg-hover-opacity-10 w-35px h-35px h-md-40px w-md-40px ms-n2 me-2" id="kt_header_navs_toggle">
											<!--begin::Svg Icon | path: icons/duotune/abstract/abs015.svg-->
											<span class="svg-icon svg-icon-2">
												<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
													<path d="M21 7H3C2.4 7 2 6.6 2 6V4C2 3.4 2.4 3 3 3H21C21.6 3 22 3.4 22 4V6C22 6.6 21.6 7 21 7Z" fill="black" />
													<path opacity="0.3" d="M21 14H3C2.4 14 2 13.6 2 13V11C2 10.4 2.4 10 3 10H21C21.6 10 22 10.4 22 11V13C22 13.6 21.6 14 21 14ZM22 20V18C22 17.4 21.6 17 21 17H3C2.4 17 2 17.4 2 18V20C2 20.6 2.4 21 3 21H21C21.6 21 22 20.6 22 20Z" fill="black" />
												</svg>
											</span>
											<!--end::Svg Icon-->
										</button>
										<!--end::Heaeder navs toggle-->
										<!--begin::Logo-->
										<a href="{{ url('/') }}" class="d-flex align-items-center">
											<img alt="Logo" src="{{ asset('assets/img/logo_white.png')}}" class="h-25px h-lg-30px" />
										</a>
										<!--end::Logo-->
										<div class="align-self-end" id="kt_brand_tabs">
											<!--begin::Header tabs-->
											@include('layouts.menu1')
											<!--end::Header tabs-->
										</div>
									</div>
									<!--end::Brand-->
									<!--begin::Topbar-->
									@include('layouts.profile')
									<!--end::Topbar-->
								</div>
								<!--end::Wrapper-->
							</div>
							<!--end::Container-->
						</div>
						<!--end::Header top-->
						<!--begin::Header navs-->
						@include('layouts.menu2')
						<!--end::Header navs-->
					</div>
					<!--end::Header-->
					<!--begin::Toolbar-->
					<div class="toolbar mb-n1 pt-3 mb-lg-n3 pt-lg-6" id="kt_toolbar">
						<!--begin::Container-->
						<div id="kt_toolbar_container" class="container-xxl d-flex flex-stack flex-wrap gap-2">
							<!--begin::Page title-->
							<div class="page-title d-flex flex-column align-items-start me-3 py-2 py-lg-0 gap-2">
								<!--begin::Title-->
								<h1 class="d-flex text-dark fw-bolder m-0 fs-3">@yield('menu')
								<!--begin::Separator-->
								<span class="h-20px border-gray-400 border-start mx-3"></span>
								<!--end::Separator-->
								<!--begin::Description-->
								<small class="text-gray-500 fs-7 fw-bold my-1">@yield('sub_menu')</small>
								<!--end::Description--></h1>
								<ul class="breadcrumb breadcrumb-dot fw-bold text-gray-600 fs-7">
									<!--begin::Item-->
									<li class="breadcrumb-item text-gray-600">
										<a href="{{ url('/') }}" class="text-gray-600 text-hover-primary">Home</a>
									</li>
									<!--end::Item-->
									<!--begin::Item-->
									<li class="breadcrumb-item text-gray-600">@yield('menu')</li>
									<!--end::Item-->
								</ul>
								<!--end::Title-->
							</div>
							<!--end::Page title-->
						</div>
						<!--end::Container-->
					</div>
					<!--end::Toolbar-->
					<!--begin::Container-->
					<div id="kt_content_container" class="d-flex flex-column-fluid align-items-start container-xxl">
						<!--begin::Post-->
						<div class="content flex-row-fluid" id="kt_content">
							@yield('contents')
						</div>
						<!--end::Post-->
					</div>
					<!--end::Container-->
					<!--begin::Footer-->
					<div class="footer py-4 d-flex flex-lg-column" id="kt_footer">
						<!--begin::Container-->
						<div class="container-xxl d-flex flex-column flex-md-row align-items-center justify-content-between">
							<!--begin::Copyright-->
							<div class="text-dark order-2 order-md-1">
								<span class="text-muted fw-bold me-1">2022©</span>
								<a href="https://mitratel.co.id" target="_blank" class="text-gray-800 text-hover-primary">PT Dayamitra Telekomunikasi Tbk</a>
							</div>
							<!--end::Copyright-->
							<!--begin::Menu-->
							<!-- <ul class="menu menu-gray-600 menu-hover-primary fw-bold order-1">
								<li class="menu-item">
									<a href="https://keenthemes.com" target="_blank" class="menu-link px-2">About</a>
								</li>
								<li class="menu-item">
									<a href="https://devs.keenthemes.com" target="_blank" class="menu-link px-2">Support</a>
								</li>
								<li class="menu-item">
									<a href="https://1.envato.market/EA4JP" target="_blank" class="menu-link px-2">Purchase</a>
								</li>
							</ul> -->
							<!--end::Menu-->
						</div>
						<!--end::Container-->
					</div>
					<!--end::Footer-->
				</div>
				<!--end::Wrapper-->
			</div>
			<!--end::Page-->
		</div>
		<!--end::Root-->
		<!--end::Main-->
		<!--begin::Scrolltop-->
		<div id="kt_scrolltop" class="scrolltop" data-kt-scrolltop="true">
			<!--begin::Svg Icon | path: icons/duotune/arrows/arr066.svg-->
			<span class="svg-icon">
				<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
					<rect opacity="0.5" x="13" y="6" width="13" height="2" rx="1" transform="rotate(90 13 6)" fill="black" />
					<path d="M12.5657 8.56569L16.75 12.75C17.1642 13.1642 17.8358 13.1642 18.25 12.75C18.6642 12.3358 18.6642 11.6642 18.25 11.25L12.7071 5.70711C12.3166 5.31658 11.6834 5.31658 11.2929 5.70711L5.75 11.25C5.33579 11.6642 5.33579 12.3358 5.75 12.75C6.16421 13.1642 6.83579 13.1642 7.25 12.75L11.4343 8.56569C11.7467 8.25327 12.2533 8.25327 12.5657 8.56569Z" fill="black" />
				</svg>
			</span>
			<!--end::Svg Icon-->
		</div>
		<!--end::Scrolltop-->
		<!--begin::Javascript-->
		<script>var hostUrl = "{{ asset('assets')}}/";</script>
		<!--begin::Global Javascript Bundle(used by all pages)-->
		<script src="{{ asset('assets/plugins/global/plugins.bundle.js')}}"></script>
		<script src="{{ asset('assets/js/scripts.bundle.js')}}"></script>
		<!--end::Global Javascript Bundle-->

        @yield('scripts')

		<!--begin::Page Vendors Javascript(used by this page)-->
		<!------------ NOTE FOR YANUAR: Vendor Javascript per Page bisa diliat di Demo20 -->
		<!--end::Page Vendors Javascript-->
		<!--begin::Page Custom Javascript(used by this page)-->
		<!------------ NOTE FOR YANUAR: Custom Javascript per Page bisa diliat di Demo20 -->
		<!--end::Page Custom Javascript-->
		<!--end::Javascript-->
	</body>
	<!--end::Body-->
</html>