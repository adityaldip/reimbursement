
        <!--begin::Modal header-->
        <div class="modal-header">
            <h2>Tambah Pengajuan Reimbursement</h2>
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
            <FORM id="form_tambah_reim" class="form" action="{{ route('admin.reimbursement.tambah.proses') }}" method="post">
                @csrf
                <div class="row">
                    <div class="col-xl-6">
                        <div class="input-group mb-5">
                            <span class="input-group-text" id="basic-addon1"><i class="fa fa-calendar"></i></span>
                            <input type="date" class="form-control" id="tanggal" name="tanggal"/>
                        </div>
                    </div>
                    <div class="col-xl-6">
                        <div class="input-group mb-5">
                            <span class="input-group-text" id="basic-addon1"><i class="fa fa-pen"></i></span>
                            <input type="text" class="form-control" placeholder="Nama Reimbursement" aria-label="Nama Reimbursement" aria-describedby="basic-addon2" name="nama_r" value="" required/>
                        </div>
                    </div>
                    <div class="col-xl-6">
                        <div class="input-group mb-5">
                            <span class="input-group-text" id="basic-addon1">File</span>
                            <input type="file" class="form-control" placeholder="File Pendukung" aria-label="File Pendukung" aria-describedby="basic-addon2" name="file_pendukung" accept="image/*,.pdf" required/>
                        </div>
                    </div>
                    <div class="col-xl-12">
                        <div class="input-group mb-5">
                            <span class="input-group-text" id="basic-addon1">Deskripsi</span>
                            <textarea class="form-control" name="deskripsi" aria-label="deskripsi" aria-describedby="basic-addon2"></textarea>
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
$("#form_tambah_reim").submit(function(event) {
    event.preventDefault();

    Swal.fire('Silahkan Tunggu...');
    Swal.showLoading();

    var $form = $(this),
    url = $form.attr('action');

    var formData = new FormData(this); // Create FormData object from the form

    $.ajax({
        url: url,
        type: 'POST',
        dataType: "JSON",
        timeout: 10000,
        data: formData,
        processData: false, // Prevent jQuery from processing the data
        contentType: false, // Prevent jQuery from setting the content type
        success: function(data) {
            Swal.fire({
                text: data.msg,
                icon: "success",
                buttonsStyling: false,
                confirmButtonText: "Ok",
                customClass: {
                    confirmButton: "btn btn-primary"
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    location.reload();
                }
            });
        },
        error: function(xhr, status, error) {
            Swal.fire({
                text: xhr.responseJSON.msg,
                icon: "error",
                buttonsStyling: false,
                confirmButtonText: "Ok",
                customClass: {
                    confirmButton: "btn btn-primary"
                }
            });
        }
    });
});

</script>