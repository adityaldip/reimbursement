@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
@php
    $user = Auth::user();
@endphp
<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
    <!-- Toolbar -->
    <div class="toolbar" id="kt_toolbar">
        <!-- Container -->
        <div id="kt_toolbar_container" class="container-xxl d-flex flex-stack">
            <!-- Page title -->
            <div data-kt-swapper="true" 
                 data-kt-swapper-mode="prepend" 
                 data-kt-swapper-parent="{default: '#kt_content_container', 'lg': '#kt_toolbar_container'}" 
                 class="page-title d-flex align-items-center flex-wrap me-3 mb-5 mb-lg-0">
                <!-- Title -->
                <h1 class="d-flex align-items-center text-dark fw-bolder fs-3 my-1">Dashboard</h1>
                <!-- Separator -->
                <span class="h-20px border-gray-300 border-start mx-4"></span>
                <h1 class="d-flex align-items-center text-dark fw-bolder fs-3 my-1">Selamat Datang {{ $user->name }} !</h1>
            </div>
            <!-- End Page title -->
        </div>
        <!-- End Container -->
    </div>
    <!-- End Toolbar -->
    <!-- Post -->
    <div class="post d-flex flex-column-fluid" id="kt_post">
        <!-- Container -->
        <div id="kt_content_container" class="container-xxl">
            @if(is_direktur())
            <!-- Row -->
            <div class="row gy-5 g-xl-8">
                <!-- Col -->
                <div class="col-xl-12">
                    <!-- Tables Widget -->
                    <div class="card card-xl-stretch mb-5 mb-xl-8">
                        <!-- Header -->
                        <div class="card-header border-0 pt-5">
                            <h3 class="card-title align-items-start flex-column">
                                <span class="card-label fw-bolder fs-3 mb-1">Data User</span>
                            </h3>
                            <a class="card-title btn btn-sm btn-primary tambah_user" style="color:white;" data-bs-toggle="modal" data-bs-target="#modal"><i class="fa fa-plus"></i>Tambah User</a>
                        </div>
                        <!-- Body -->
                        <div class="card-body py-3">
                            <!-- Table container -->
                            <div class="table-responsive">
                                <!-- Table -->
                                <table class="table table-row-dashed table-row-gray-300 align-middle gs-0 gy-4 dttble">
                                    <!-- Table head -->
                                    @php 
                                        $no=1; 
                                    @endphp
                                    <thead>
                                        <tr class="fw-bolder text-muted">
                                            <th>No</th>
                                            <th>Nama</th>
                                            <th>Email</th>
                                            <th>NIP</th>
                                            <th>Jabatan</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <!-- Table body -->
                                    <tbody>
                                        @foreach($users as $u)
                                            <tr>
                                                <td>{{ $no++ }}</td>
                                                <td>{{ $u->name }}</td>
                                                <td>{{ $u->email }}</td>
                                                <td>{{ $u->nip }}</td>
                                                <td>{{ $u->jabatan }}</td>
                                                <td>
                                                    <a class="btn btn-sm btn-danger hapus_user" id="{{ $u->id }}"> Hapus</a>
                                                    <a class="btn btn-sm btn-info edit_users" id="{{ $u->id }}" data-bs-toggle="modal" data-bs-target="#modal">Edit</a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <!-- End Table -->
                            </div>
                            <!-- End Table container -->
                        </div>
                        <!-- End Body -->
                    </div>
                    <!-- End Tables Widget -->
                </div>
                <!-- End Col -->
            </div>
            <!-- End Row -->
            @endif
            <div class="row gy-5 g-xl-8">
                <!-- Col -->
                <div class="col-xl-12">
                    <!-- Tables Widget -->
                    <div class="card card-xl-stretch mb-5 mb-xl-8">
                        <!-- Header -->
                        <div class="card-header border-0 pt-5">
                            <h3 class="card-title align-items-start flex-column">
                                <span class="card-label fw-bolder fs-3 mb-1">Reimbursement</span>
                            </h3>
                            @if(is_staff())
                                <a class="card-title btn btn-sm btn-info tambah_reim" style="color:white;" data-bs-toggle="modal" data-bs-target="#modal"><i class="fa fa-plus"></i>Tambah Pengajuan Reimbursement</a>
                            @endif
                        </div>
                        <!-- Body -->
                        <div class="card-body py-3">
                            <!-- Table container -->
                            <div class="table-responsive">
                                <!-- Table -->
                                <table class="table table-row-dashed table-row-gray-300 align-middle gs-0 gy-4 dttble">
                                    <!-- Table head -->
                                    @php 
                                        $nor=1; 
                                    @endphp
                                    <thead>
                                        <tr class="fw-bolder text-muted">
                                            <th>No</th>
                                            <th>Dari</th>
                                            <th>Tanggal</th>
                                            <th>Nama Reimbursement</th>
                                            <th>Deskripsi</th>
                                            <th>File Pendukung</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <!-- Table body -->
                                    <tbody>
                                        @foreach($reimbursement as $reim)
                                            @php 
                                                if($reim->reimbursement){
                                                    $r = $reim->reimbursement;
                                                }else{
                                                    $r = $reim;
                                                }

                                                $file = $r->file;
                                                $extension = pathinfo($file, PATHINFO_EXTENSION);
                                            @endphp
                                            <tr>
                                                <td>{{ $nor++ }}</td>
                                                <td></td>
                                                <td>{{ $r->tanggal }}</td>
                                                <td>{{ $r->name }}</td>
                                                <td>{{ $r->description }}</td>
                                                <td>
                                                    @if ($extension == 'pdf')
                                                        <!-- Display PDF -->
                                                        <a href="{{ url('/reimbursement/'.$r->file) }}" target="_blank" class="btn btn-sm btn-info">Lihat PDF</a><br>
                                                        <embed src="{{ url('/reimbursement/'.$r->file) }}" type="application/pdf" width="200" height="200">
                                                    @else
                                                        <!-- Display image -->
                                                        <a href="{{ url('/reimbursement/'.$r->file) }}" target="_blank">
                                                            <img src="{{ url('/reimbursement/'.$r->file) }}" alt="Image" width="150">
                                                        </a>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if($r->status == 'to_direktur')
                                                        <span style="color:blue;font-weight:bold;">Menunggu persetujuan Direktur</span>
                                                    @elseif($r->status == 'to_finance')
                                                        <span style="color:orange;font-weight:bold;">Menunggu persetujuan Finance</span>
                                                    @elseif($r->status == 'rejected')
                                                        <span style="color:red;font-weight:bold;">Reimbursement ditolak</span><br>
                                                        <span style="color:red;font-weight:bold;">alasan: {{ $r->keterangan_ditolak }}</span>
                                                    @elseif($r->status == 'approved')
                                                        <span style="color:green;font-weight:bold;">Reimbursement telah di setujui finance, Menunggu pembayaran</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if(is_direktur())
                                                        @if($r->status == 'to_direktur')
                                                            <a class="btn btn-sm btn-success setujui_reim" id="{{ $r->id; }}">Setujui</a>
                                                            <a class="btn btn-sm btn-danger tolak_reim" id="{{ $r->id; }}">Tolak</a>
                                                        @else
                                                            <span>Anda telah memproses Reimbursement ini</span>
                                                        @endif
                                                    @elseif(is_finance())
                                                        @if($r->status == 'to_finance')
                                                            <a class="btn btn-sm btn-success setujui_reim" id="{{ $r->id; }}">Setujui</a>
                                                            <a class="btn btn-sm btn-danger tolak_reim" id="{{ $r->id; }}">Tolak</a>
                                                        @else
                                                            <span>Anda telah memproses Reimbursement ini</span>
                                                        @endif
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <!-- End Table -->
                            </div>
                            <!-- End Table container -->
                        </div>
                        <!-- End Body -->
                    </div>
                    <!-- End Tables Widget -->
                </div>
                <!-- End Col -->
            </div>
        </div>
        <!-- End Container -->
    </div>
    <!-- End Post -->
</div>
<div class="modal fade" id="modal" tabindex="-1" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered mw-900px">
        <div class="modal-content" id="body-modal">	
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
	$(document).ready( function () {
		$('.dttble').DataTable();
	});

    $(document).on("click",".hapus_user", function () {
    const id = this.id;   // Getting Button id 
    var url = `{{ route('admin.user.hapus', ['id=']) }}`;
    url = url.replace('id=', id);        
     Swal.fire({
          title: 'Anda yakin ingin menghapus user ini ?',
          showDenyButton: true,
          confirmButtonText: 'Ya',
          denyButtonText: 'Tidak',
        }).then((result) => {
          /* Read more about isConfirmed, isDenied below */
          if (result.isConfirmed) {
            $.ajax({
              url: url,
              type: 'POST',
              dataType: "JSON",
              data: {
                id:id,
                _token: "{{ csrf_token() }}",
            },
              dataType: 'json',
              success: function(data){
                  Swal.fire(data.msg, '',data.status).then((result) => {
                    if (result.isConfirmed) {
                        location.reload();
                    }
                })
              }
            });
          } else if (result.isDenied) {
            Swal.fire('Baiklah', '', 'info')
          }
        })
  });

  $(document).on("click",".setujui_reim", function () {
    const id = this.id;   // Getting Button id 
    var url = `{{ route('admin.reimbursement.approve') }}`;
     Swal.fire({
          title: 'Anda yakin ingin menyetujui reimbursement ini ?',
          showDenyButton: true,
          confirmButtonText: 'Ya',
          denyButtonText: 'Tidak',
        }).then((result) => {
          if (result.isConfirmed) {
            $.ajax({
              url: url,
              type: 'POST',
              dataType: "JSON",
              data: {
                id:id,
                _token: "{{ csrf_token() }}",
            },
              dataType: 'json',
              success: function(data){
                  Swal.fire(data.msg, '',data.status).then((result) => {
                    if (result.isConfirmed) {
                        location.reload();
                    }
                })
              }
            });
          } else if (result.isDenied) {
            Swal.fire('Baiklah', '', 'info')
          }
        })
  });
  $(document).on("click",".tolak_reim", function () {
    const id = this.id;   // Getting Button id 
    var url = `{{ route('admin.reimbursement.reject') }}`;
     Swal.fire({
          title: 'Anda yakin ingin monolak reimbursement ini ?',
          showDenyButton: true,
          confirmButtonText: 'Ya',
          input: "textarea",
          inputPlaceholder: "Berikan alasan penolakan...",
          denyButtonText: 'Tidak',
          inputValidator: (value) => {
            if (!value) {
                return 'Anda harus memberikan alasan penolakan.';
            }
        }
        }).then((result) => {
          if (result.isConfirmed) {
            var rejectionReason = result.value;
            $.ajax({
              url: url,
              type: 'POST',
              dataType: "JSON",
              data: {
                id:id,
                rejectionReason:rejectionReason,
                _token: "{{ csrf_token() }}",
            },
              dataType: 'json',
              success: function(data){
                  Swal.fire(data.msg, '',data.status).then((result) => {
                    if (result.isConfirmed) {
                        location.reload();
                    }
                })
              }
            });
          } else if (result.isDenied) {
            Swal.fire('Baiklah', '', 'info')
          }
        })
  });
</script>
<script>
    function getEdit(id) {
      $('#body-modal').html('<div class="card"><h2 style="text-align: center;">Loading...</h2></div>');
        var url = `{{ route('admin.user.edit', ['id=']) }}`;
        url = url.replace('id=', id);        
        $.get(url, function(data) {
            $('#body-modal').html(data);
        });
   }
    $(document).on("click",".edit_users", function () {
        var id = this.id;   // Getting Button id 
        getEdit(id)
    });
</script>
<script>
    function getTambah() {
      $('#body-modal').html('<div class="card"><h2 style="text-align: center;">Loading...</h2></div>');
        var url = `{{ route('admin.user.tambah') }}`;
        $.get(url, function(data) {
            $('#body-modal').html(data);
        });
   }
    $(document).on("click",".tambah_user", function () {
        getTambah()
    });
</script>
<script>
    function getTambahReim() {
      $('#body-modal').html('<div class="card"><h2 style="text-align: center;">Loading...</h2></div>');
        var url = `{{ route('admin.reimbursement.tambah') }}`;
        $.get(url, function(data) {
            $('#body-modal').html(data);
        });
   }
    $(document).on("click",".tambah_reim", function () {
        getTambahReim()
    });
</script>
@endpush
