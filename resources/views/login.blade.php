<!DOCTYPE html>

<html lang="en">
	<!--begin::Head-->
	<head>
		<title>Kasir Pintar</title>
		<meta charset="utf-8" />
		<meta name="description" content="Kasir Pintar" />
		<meta name="keywords" content="Kasir Pintar" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<meta property="og:locale" content="en_US" />
		<meta property="og:type" content="article" />
		<meta property="og:title" content="Kasir Pintar" />
		<meta property="og:url" content="" />
		<meta property="og:site_name" content="Kasir Pintar" />
		<link rel="canonical" href="" />
		<!--begin::Fonts-->
		<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" />
		<!--end::Fonts-->
		<!--begin::Global Stylesheets Bundle(used by all pages)-->
        <link href="{{ asset('admin/plugins/global/plugins.bundle.css') }}" rel="stylesheet" type="text/css" />
		<link href="{{ asset('admin/css/style.bundle.css') }}" rel="stylesheet" type="text/css" />
		<!--end::Global Stylesheets Bundle-->
	</head>
	<!--end::Head-->
	<!--begin::Body-->
	<body id="kt_body" class="bg-body">
		<!--begin::Main-->
		<!--begin::Root-->
		<div class="d-flex flex-column flex-root">
			<!--begin::Authentication - Sign-in -->
			<div class="d-flex flex-column flex-column-fluid bgi-position-y-bottom position-x-center bgi-no-repeat bgi-size-contain bgi-attachment-fixed" style="background-color:#E5F0F9;">
				<!--begin::Content-->
				<div class="d-flex flex-center flex-column flex-column-fluid p-10 pb-lg-20">
					<!--begin::Logo-->
					<a href="" class="mb-12">
					 <h2>Mini Penugasan Laravel Developer Kasir Pintar</h2>
					</a>
					<!--end::Logo-->
					<!--begin::Wrapper-->
					<div class="w-lg-500px bg-body rounded shadow-sm p-10 p-lg-15 mx-auto">
						<!--begin::Form-->
						<form class="form w-100" novalidate="novalidate" id="kt_sign_in_form" action="{{ route('login.proses') }}" method="post">
							<!--begin::Heading-->
							<div class="text-center mb-10">
								<!--begin::Title-->
								<h1 class="text-dark mb-3">Masuk</h1>
								<!--end::Title-->
							</div>
							<!--begin::Heading-->
							<!--begin::Input group-->
							<div class="fv-row mb-10">
								<!--begin::Label-->
								<label class="form-label fs-6 fw-bolder text-dark">NIP</label>
								<!--end::Label-->
								<!--begin::Input-->
								<input class="form-control form-control-lg form-control-solid" type="text" name="nip" autocomplete="off" id="nip" />
								<!--end::Input-->
							</div>
							<!--end::Input group-->
							<!--begin::Input group-->
							<div class="fv-row mb-10">
								<!--begin::Wrapper-->
								<div class="d-flex flex-stack mb-2">
									<!--begin::Label-->
									<label class="form-label fw-bolder text-dark fs-6 mb-0">Password</label>
									<!--end::Label-->
								</div>
								<!--end::Wrapper-->
								<!--begin::Input-->
								<input class="form-control form-control-lg form-control-solid" type="password" name="password" autocomplete="off" id="password" />
								<!--end::Input-->
							</div>
							<!--end::Input group-->
							<!--begin::Actions-->
							<div class="text-center">
								<!--begin::Submit button-->
								<button type="submit" id="kt_sign_in_submit" class="btn btn-lg btn-primary w-100 mb-5">
									<span class="indicator-label">Continue</span>
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
				</div>
				<!--end::Content-->
				<!--begin::Footer-->
				<div class="d-flex flex-center flex-column-auto p-10">
					<!--begin::Links-->
					<div class="d-flex align-items-center fw-bold fs-6">
						<a href="#" class="text-muted text-hover-primary px-2">About</a>
						<a href="#" class="text-muted text-hover-primary px-2">Contact</a>
						<a href="#" class="text-muted text-hover-primary px-2">Contact Us</a>
					</div>
					<!--end::Links-->
				</div>
				<!--end::Footer-->
			</div>
			<!--end::Authentication - Sign-in-->
		</div>
		<!--end::Root-->
		<!--end::Main-->
		<!--begin::Global Javascript Bundle(used by all pages)-->
		<script src="{{ asset('admin/plugins/global/plugins.bundle.js') }}"></script>
		<script src="{{ asset('admin/js/scripts.bundle.js') }}"></script>
		<!--end::Global Javascript Bundle-->
		<!--begin::Page Custom Javascript(used by this page)-->
		<script src="{{ asset('admin/js/custom/authentication/sign-in/general.js') }}"></script>
		<!--end::Page Custom Javascript-->
		<!--end::Javascript-->
		<script>
			"use strict";
			var KTSigninGeneral = function() {
				var t, e, i, nip, password;
				return {
					init: function() {
						t = document.querySelector("#kt_sign_in_form"),
							e = document.querySelector("#kt_sign_in_submit"),
							i = FormValidation.formValidation(t, {
								fields: {
									nip: {
										validators: {
											notEmpty: {
												message: "Harap isi kolom ini"
											}
										}
									},
									password: {
										validators: {
											notEmpty: {
												message: "Harap isi kolom ini"
											}
										}
									}
								},
								plugins: {
									trigger: new FormValidation.plugins.Trigger,
									bootstrap: new FormValidation.plugins.Bootstrap5({
										rowSelector: ".fv-row"
									})
								}
							}),
							e.addEventListener("click", (function(n) {
								n.preventDefault(), i.validate().then((function(i) {
									"Valid" == i ? (e.setAttribute("data-kt-indicator", "on"), e.disabled = !0, setTimeout((
										function() {
											e.removeAttribute("data-kt-indicator"), e.disabled = !1,
                                                nip = $('#nip').val()
											    password = $('#password').val()
											$.ajax({
												url: `{{ route('login.proses') }}`,
												type: 'POST',
												dataType: "JSON",
												timeout: 10000,
												data: {
                                                    _token: "{{ csrf_token() }}",
													nip: nip,
													password: password
												},
												success: function(data) {
													if (data.status == 'success') {
														Swal.fire({
															title: data.msg,
															timer: 1500,
															timerProgressBar: true,
															didOpen: () => {
																Swal.showLoading()
																const b = Swal.getHtmlContainer().querySelector('b')
																timerInterval = setInterval(() => {
																	b.textContent = Swal.getTimerLeft()
																}, 100)
															},
															willClose: () => {
																	location.href = `{{ route('admin.dashboard') }}`

															}
														})
													} else {
														Swal.fire({
															text: data.msg,
															icon: "error",
															buttonsStyling: !1,
															confirmButtonText: "Ok",
															customClass: {
																confirmButton: "btn btn-primary"
															}
														})
													}
												},
												error: function() {
													Swal.fire({
														text: "NIP atau password yang anda masukan tidak sesuai, Silahkan coba lagi !",
														icon: "error",
														buttonsStyling: !1,
														confirmButtonText: "Ok",
														customClass: {
															confirmButton: "btn btn-primary"
														}
													})
												}
											})
										}), 2e3)) : Swal.fire({
										text: "NIP atau password yang anda masukan tidak sesuai, Silahkan coba lagi !",
										icon: "error",
										buttonsStyling: !1,
										confirmButtonText: "Ok",
										customClass: {
											confirmButton: "btn btn-primary"
										}
									})
								}))
							}))
					}
				}
			}();
			KTUtil.onDOMContentLoaded((function() {
				KTSigninGeneral.init()
			}));
			</script>
	</body>
	<!--end::Body-->
</html>