<x-app-layout>
    <x-slot name="header">

    </x-slot>
    <section class="section">
        <div id="card-utama" class="card fixed-card mb-4">
            <div class="card-body">
                <div class="row align-items-center justify-content-between mb-4">
                    <div class="col-md-6">
                        <h4>Daftar ICD</h4>
                    </div>
                    {{-- <div class="col-md-4">
                        <input type="text" id="searchPasien" class="form-control" placeholder="Cari ICD...">
                    </div> --}}
                </div>
                <div id="data-icd">
                    @include('petugas.administrator.tabel.icd', ['icds' => $icds])
                </div>
            </div>
        </div>

        <!-- Tambahkan Form -->
        <div id="form-icd-container" class="card mt-4">
            <div class="card-header">
                <h4>Tambah Data ICD</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('data.icd.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="kode_icd" class="form-label">Kode ICD</label>
                        <input type="text" id="kode_icd" name="kode_icd" class="form-control w-25"
                            placeholder="Masukkan kode ICD" required>
                        @error('kode_icd')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="nama_penyakit" class="form-label">Nama Penyakit</label>
                        <input type="text" id="nama_penyakit" name="nama_penyakit" class="form-control w-50"
                            placeholder="Masukkan nama penyakit" required>
                    </div>
                    {{-- <div class="mb-3">
                        <label for="deskripsi_penyakit" class="form-label">Deskripsi Penyakit</label>
                        <textarea id="deskripsi_penyakit" name="deskripsi_penyakit" class="form-control"
                            placeholder="Masukkan deskripsi penyakit" rows="3" required></textarea>
                    </div> --}}
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </form>
            </div>
        </div>
    </section>
    <!-- Modal Edit ICD -->
    <div class="modal fade" id="editICDModal" tabindex="-1" aria-labelledby="editICDModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="editICDForm" action="" method="POST">
                    @csrf
                    @method('PUT') <!-- Untuk metode PUT -->
                    <div class="modal-header">
                        <h5 class="modal-title" id="editICDModalLabel">Edit Data ICD</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="editKodeICD" class="form-label">Kode ICD</label>
                            <input type="text" id="editKodeICD" class="form-control" name="kode_icd" required>
                            @error('kode_icd')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="editNamaPenyakit" class="form-label">Nama Penyakit</label>
                            <input type="text" id="editNamaPenyakit" class="form-control" name="nama_penyakit"
                                required>
                        </div>
                        <div class="mb-3">
                            <label for="editNamaPenyakit" class="form-label">Status ICD</label>
                            <select id="editStatusICD" name="status_icd" class="form-control" required>
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
    <!-- Modal Konfirmasi Hapus ICD -->
    <div class="modal fade" id="deleteICDModal" tabindex="-1" aria-labelledby="deleteICDModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="deleteICDForm" action="" method="POST">
                    @csrf
                    @method('DELETE') <!-- Untuk metode DELETE -->
                    <div class="modal-header">
                        <h5 class="modal-title" id="deleteICDModalLabel">Konfirmasi Hapus</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>Apakah Anda yakin ingin menghapus data ICD ini?</p>
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
    <div class="modal fade" id="confirmModal" tabindex="-1" aria-labelledby="confirmModalLabel"
        aria-hidden="true">
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
        $(document).on('click', '#data-icd .pagination a', function(event) {
            event.preventDefault();
            var page = $(this).attr('href').split('page_icd=')[1];
            fetch_data_icd(page);
        });

        function fetch_data_icd(page) {
            $.ajax({
                url: "/administrasi/data/icd?page_icd=" + page,
                success: function(data) {
                    console.log(data);
                    $('#data-icd').html(data);
                },
                error: function(xhr) {
                    console.log("Error: " + xhr.status + " " + xhr.statusText);
                }
            });
        }

        $(document).on('click', '.btn-edit-icd', function() {
            // Ambil data dari tombol edit
            let id = $(this).data('id');
            let kode = $(this).data('kode');
            let nama = $(this).data('nama');
            let deskripsi = $(this).data('deskripsi');
            let status = $(this).data('status');
            // Isi data ke dalam form modal
            $('#editICDForm').attr('action', '/administrasi/data/icd/' + id);
            $('#editKodeICD').val(kode);
            $('#editNamaPenyakit').val(nama);
            $('#editDeskripsiPenyakit').val(deskripsi);
            // Atur nilai pada select Status
            $('#editStatusICD').val(status);

            // Tampilkan modal
            $('#editICDModal').modal('show');
        });

        $(document).on('click', '.btn-delete-icd', function() {
            // Ambil ID ICD dari tombol
            let id = $(this).data('id');

            // Set action pada form modal
            $('#deleteICDForm').attr('action', '/administrasi/data/icd/' + id);

            // Tampilkan modal konfirmasi
            $('#deleteICDModal').modal('show');
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
