
        <!--begin::Modal header-->
        <div class="modal-header">
            <h2>Tambah User Baru</h2>
            <div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
                <span class="svg-icon svg-icon-1">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                        <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1" transform="rotate(-45 6 17.3137)" fill="black" />
                        <rect x="7.41422" y="6" width="16" height="2" rx="1" transform="rotate(45 7.41422 6)" fill="black" />
                    </svg>
                </span>
            </div>
        </div>
        <!--end::Modal header-->
        <!--begin::Modal body-->
        <div class="modal-body py-lg-10 px-lg-10">
            <FORM id="form_tambah_user" class="form" action="{{ route('admin.user.tambah.proses') }}" method="post">
                <div class="row">
                    <div class="col-xl-6">
                        <div class="input-group mb-5">
                            <span class="input-group-text" id="basic-addon1">Nama</span>
                            <input type="text" class="form-control" placeholder="nama user" aria-label="nama user" aria-describedby="basic-addon2" name="nama" value="" required/>
                        </div>
                    </div>
                    <div class="col-xl-6">
                        <div class="input-group mb-5">
                            <span class="input-group-text" id="basic-addon1">Email</span>
                            <input type="email" class="form-control" placeholder="Email user" aria-label="Email user" aria-describedby="basic-addon2" name="email" value="" required/>
                        </div>
                    </div>
                    <div class="col-xl-6">
                        <div class="input-group mb-5">
                            <span class="input-group-text" id="basic-addon1">NIP</span>
                            <input type="text" class="form-control" placeholder="NIP user" aria-label="NIP user" aria-describedby="basic-addon2" name="nip" value="" required/>
                        </div>
                    </div>
                    <div class="col-xl-6">
                        <div class="input-group mb-5">
                            <span class="input-group-text" id="basic-addon1">Jabatan</span>
                            <select class="form-select" aria-describedby="basic-addon2" id="jabatan" name="jabatan">
                                <option value="finance">FINANCE</option>
                                <option value="staf">STAFF</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-xl-6">
                        <div class="input-group mb-5">
                            <span class="input-group-text" id="basic-addon1">password</span>
                            <input type="password" class="form-control" placeholder="Password user" aria-label="Password user" aria-describedby="basic-addon2" name="password" value="" required/>
                        </div>
                    </div>
                </div>
                <!--end::Input group-->
                <div class="input-group mb-5">
                    <button type="submit" class="btn btn-primary">Tambah</button>
                </div>
            </form>
        </div>
        <!--end::Modal body-->
<script>
    $("#form_tambah_user").submit(function(event) {
   Swal.fire('Silahkan Tunggu...');
   Swal.showLoading();
   event.preventDefault();

   var $form = $(this),
   url = $form.attr('action');
   $.ajax({
	url: url,
	type: 'POST',
	dataType: "JSON",
	timeout: 10000,
	data: {
        _token: "{{ csrf_token() }}",
       name: $("input[name='nama']").val(),
       email: $("input[name='email']").val(),
       nip: $("input[name='nip']").val(),
       jabatan: $("select[name='jabatan']").val(),
       iduser: $("input[name='id_users']").val(),
       password: $("input[name='password']").val(),
	},
	success: function(data) {
        Swal.fire({
           text:data.msg,
           icon:"success",
           buttonsStyling:!1,
           confirmButtonText:"Ok",
           customClass:{
           confirmButton:"btn btn-primary"}}).then((result) => {
                if (result.isConfirmed) {
                    location.reload();
                }
         })
	},
	error: function(data) {
			Swal.fire({
				text: data.responseJSON.msg,
				icon: "error",
				buttonsStyling: !1,
				confirmButtonText: "Ok",
				customClass: {
				    confirmButton: "btn btn-primary"
				}
            })
		}
	})   
});
</script>