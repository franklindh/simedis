<x-app-layout>
    <x-slot name="header">

    </x-slot>
    <section class="section">
        <div id="card-utama" class="card fixed-card mb-4">
            <div class="card-body">
                <div class="row align-items-center justify-content-between mb-4">
                    <div class="col-md-6">
                        <h4>Daftar Poli</h4>
                    </div>
                    {{-- <div class="col-md-4">
                        <input type="text" id="searchPasien" class="form-control" placeholder="Cari ICD...">
                    </div> --}}
                </div>
                <div id="data-poli">
                    @include('petugas.administrator.tabel.poli', ['polis' => $polis])
                </div>
            </div>
        </div>

        <!-- Tambahkan Form -->
        <div id="form-icd-container" class="card mt-4">
            <div class="card-header">
                <h4>Tambah Data Poli</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('data.poli.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="kode_icd" class="form-label">Nama Poli</label>
                        <input type="text" id="nama_poli" name="nama_poli" class="form-control w-25"
                            placeholder="Masukkan nama poli" required>
                        @error('nama_poli')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </form>
            </div>
        </div>
    </section>
    <!-- Modal Edit Poli -->
    <div class="modal fade" id="editPoliModal" tabindex="-1" aria-labelledby="editPoliModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="editPoliForm" action="" method="POST">
                    @csrf
                    @method('PUT') <!-- Untuk metode PUT -->
                    <div class="modal-header">
                        <h5 class="modal-title" id="editPoliModalLabel">Edit Data Poli</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="editNamaPoli" class="form-label">Nama Poli</label>
                            <input type="text" id="editNamaPoli" class="form-control" name="nama_poli" required>
                            @error('nama_poli')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="editNamaPoli" class="form-label">Status Poli</label>
                            <select id="editStatusPoli" name="status_poli" class="form-control" required>
                                <option value="aktif">
                                    Aktif</option>
                                <option value="nonaktif">
                                    Nonaktif</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Modal Konfirmasi Hapus -->
    <div class="modal fade" id="deletePoliModal" tabindex="-1" aria-labelledby="deletePoliModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="deletePoliForm" action="" method="POST">
                    @csrf
                    @method('DELETE') <!-- Untuk metode DELETE -->
                    <div class="modal-header">
                        <h5 class="modal-title" id="deletePoliModalLabel">Konfirmasi Hapus</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>Apakah Anda yakin ingin menghapus data poli ini?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-danger">Hapus</button>
                    </div>
                </form>
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
                    <button type="button" class="btn btn-primary" id="confirmModalConfirmBtn">Lanjutkan</button>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>


<style>
    #card-utama {
        margin-top: 0;
        /* Kurangi margin atas card */
        padding-top: 10px;
        /* Jika padding terlalu besar, kurangi */
    }
</style>

<script>
    $(document).ready(function() {
        // Menggunakan event delegation pada pagination
        $(document).on('click', '#data-poli .pagination a', function(event) {
            event.preventDefault();
            var page = $(this).attr('href').split('page_poli=')[1];
            fetch_data_poli(page);
        });

        function fetch_data_poli(page) {
            $.ajax({
                url: "/administrasi/data/poli?page_poli=" + page,
                success: function(data) {
                    console.log(data);
                    $('#data-poli').html(data);
                },
                error: function(xhr) {
                    console.log("Error: " + xhr.status + " " + xhr.statusText);
                }
            });
        }

        $(document).on('click', '.btn-edit-poli', function() {
            // Ambil data dari tombol edit
            let id = $(this).data('id');
            let nama = $(this).data('nama');
            let deskripsi = $(this).data('deskripsi');
            let status = $(this).data('status');

            // Isi data ke dalam form modal
            $('#editPoliForm').attr('action', '/administrasi/data/poli/' + id);
            $('#editNamaPoli').val(nama);
            $('#editDeskripsiPoli').val(deskripsi);
            $('#editStatusPoli').val(status);

            // Tampilkan modal
            $('#editPoliModal').modal('show');
        });

        $(document).on('click', '.btn-delete-poli', function() {
            // Ambil ID poli dari tombol
            let id = $(this).data('id');

            // Set action pada form modal
            $('#deletePoliForm').attr('action', '/administrasi/data/poli/' + id);

            // Tampilkan modal konfirmasi
            $('#deletePoliModal').modal('show');
        });

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


    });
</script>
