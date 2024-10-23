<!-- Tambahkan kode ini di bagian paling atas dari Blade template -->
@if ($errors->any())
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var addUserModal = new bootstrap.Modal(document.getElementById('addUserModal'));
            addUserModal.show();
        });
    </script>
@endif
<x-app-layout>
    <x-slot name="header">
        {{-- @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif --}}

        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Data Pengguna</h3>
                {{-- <p class="text-subtitle text-muted">This is the main page.</p> --}}
            </div>
            {{-- <div class="col-12 col-md-6 order-md-2 order-first d-flex justify-content-end mb-2"
                style="padding-right: 45px;"> --}}
            <div class="col-12 col-md-6 order-md-2 order-first d-flex justify-content-end mb-2">
                <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addUserModal">Tambah
                    Pengguna</button>
                {{-- <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item active" aria-current="page"></li>
                    </ol>
                </nav> --}}
            </div>
        </div>
    </x-slot>
    <section class="section">
        <div class="card">
            {{-- <div class="card-header">
                <h4 class="card-title">Data Pengguna</h4>
            </div> --}}
            <div class="card-body">
                <div id="data-pengguna">
                    @include('petugas.administrator.tabel.pengguna', ['daftarPengguna' => $daftarPengguna])
                </div>
            </div>
        </div>
    </section>
    <!-- Modal -->
    <div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="addUserModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addUserModalLabel">Tambah Pengguna</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('pengguna.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="username" class="form-label">Username</label>
                            <input type="text" class="form-control @error('username') is-invalid @enderror"
                                id="username" name="username" value="{{ old('username') }}">
                            @error('username')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="nama" class="form-label">Nama</label>
                            <input type="text" class="form-control" id="nama" name="nama" required>
                            @error('nama')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="role" class="form-label">Role</label>
                            <select class="form-select" id="role" name="role" required>
                                <option value="Administrasi">Administrasi</option>
                                <option value="Poliklinik">Poliklinik</option>
                                <option value="Dokter">Dokter</option>
                                <!-- Tambahkan opsi role lainnya jika ada -->
                            </select>
                            @error('role')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="d-flex justify-content-end mt-3">
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal Konfirmasi -->
    <div class="modal fade" id="confirmModal" tabindex="-1" aria-labelledby="confirmModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmModalLabel">Konfirmasi Tindakan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="confirmModalMessage">
                    <!-- Pesan konfirmasi akan diisi oleh JavaScript -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-danger" id="confirmModalConfirmBtn">Lanjutkan</button>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
<style>
    thead {
        color: #ffffff;
        background-color: #465C9E;
    }
</style>
<script>
    $(document).ready(function() {
        // Pagination for pasien
        $(document).on('click', '#data-pengguna .pagination a', function(event) {
            event.preventDefault();
            var page = $(this).attr('href').split('page_pengguna=')[1];
            fetch_data_pasien(page);
        });

        function fetch_data_pasien(page) {
            $.ajax({
                url: "/administrasi/pengguna?page_pengguna=" + page,
                success: function(data) {
                    $('#data-pengguna').html(data);
                },
                error: function(xhr) {
                    console.log("Error: " + xhr.status + " " + xhr.statusText);
                }
            });
        }
    });

    document.addEventListener('DOMContentLoaded', function() {
        var confirmModal = document.getElementById('confirmModal');
        var confirmModalMessage = document.getElementById('confirmModalMessage');
        var confirmModalConfirmBtn = document.getElementById('confirmModalConfirmBtn');

        confirmModal.addEventListener('show.bs.modal', function(event) {
            var button = event.relatedTarget; // Tombol yang memicu modal
            var message = button.getAttribute('data-message'); // Pesan dari tombol
            var url = button.getAttribute('data-url'); // URL dari tombol

            // Set pesan dalam modal
            confirmModalMessage.textContent = message;

            // Set aksi saat tombol "Lanjutkan" diklik
            confirmModalConfirmBtn.onclick = function() {
                window.location.href = url;
            };
        });

        // Inisialisasi Notyf
        let notyf = new Notyf({
            duration: 2500, // Durasi notifikasi
            position: {
                x: 'right', // posisi X (left/right)
                y: 'top', // posisi Y (top/bottom)
            }
        });

        // Menampilkan notifikasi berdasarkan session Laravel
        @if (session('success'))
            notyf.success('{{ session('success') }}');
        @elseif (session('error'))
            notyf.error('{{ session('error') }}');
        @elseif (session('info'))
            notyf.open({
                type: 'info',
                message: '{{ session('info') }}'
            });
        @elseif (session('warning'))
            notyf.open({
                type: 'warning',
                message: '{{ session('warning') }}'
            });
        @endif
    });
</script>
