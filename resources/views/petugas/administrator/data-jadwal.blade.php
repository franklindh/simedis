<x-app-layout>
    <x-slot name="header">

    </x-slot>
    <section class="section">
        <div id="card-utama" class="card fixed-card mb-4">
            <div class="card-body">
                <div class="row align-items-center justify-content-between mb-4">
                    <div class="col-md-6">
                        <h4>Daftar Jadwal</h4>
                    </div>
                    {{-- <div class="col-md-4">
                        <input type="text" id="searchPasien" class="form-control" placeholder="Cari ICD...">
                    </div> --}}
                </div>
                <div id="data-jadwal">
                    @include('petugas.administrator.tabel.jadwal', ['jadwals' => $jadwals])
                </div>
            </div>
        </div>

        <!-- Tambahkan Form -->
        <div id="form-icd-container" class="card mt-4">
            <div class="card-header">
                <h4>Tambah Data Jadwal</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('data.jadwal.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="deskripsi_penyakit" class="form-label">Petugas</label>
                        <select class="form-select" id="patientSelect" name="id_petugas" required>
                            <option value=""></option>
                            @foreach ($petugas as $item)
                                <option value="{{ $item->id_petugas }}">
                                    {{ $item->nama_petugas }}
                                </option>
                            @endforeach
                        </select>
                        @error('nik')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="deskripsi_penyakit" class="form-label">Poli</label>
                        <select class="form-select" id="patientSelect" name="id_poli" required>
                            <option value=""></option>
                            @foreach ($poli as $item)
                                <option value="{{ $item->id_poli }}">
                                    {{ $item->nama_poli }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="tanggal">Tanggal Praktik</label>
                        <input type="text" id="tanggal" class="form-control" name="tanggal_praktik">
                    </div>
                    <div class="mb-3">
                        <label for="tanggal">Waktu Mulai</label>
                        <input type="text" id="waktu" class="form-control" name="waktu_mulai">
                    </div>
                    <div class="mb-3">
                        <label for="tanggal">Waktu Selesai</label>
                        <input type="text" id="waktu" class="form-control" name="waktu_selesai">
                    </div>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </form>
            </div>
        </div>
    </section>
    <!-- Modal Edit -->
    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="editForm" action="" method="POST">
                    @csrf
                    @method('PUT') <!-- Untuk metode PUT -->
                    <div class="modal-header">
                        <h5 class="modal-title" id="editModalLabel">Edit Data Jadwal</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="editPetugas" class="form-label">Petugas</label>
                            <select class="form-select" id="editPetugas" name="id_petugas" required>
                                <option value=""></option>
                                @foreach ($petugas as $item)
                                    <option value="{{ $item->id_petugas }}">
                                        {{ $item->nama_petugas }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="editPoli" class="form-label">Poli</label>
                            <select class="form-select" id="editPoli" name="id_poli" required>
                                <option value=""></option>
                                @foreach ($poli as $item)
                                    <option value="{{ $item->id_poli }}">
                                        {{ $item->nama_poli }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="editTanggal" class="form-label">Tanggal Praktik</label>
                            <input type="text" id="editTanggal" class="form-control" name="tanggal_praktik">
                        </div>
                        <div class="mb-3">
                            <label for="editWaktuMulai" class="form-label">Waktu Mulai</label>
                            <input type="text" id="editWaktuMulai" class="form-control" name="waktu_mulai">
                        </div>
                        <div class="mb-3">
                            <label for="editWaktuSelesai" class="form-label">Waktu Selesai</label>
                            <input type="text" id="editWaktuSelesai" class="form-control" name="waktu_selesai">
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
    <div class="modal fade" id="deleteJadwalModal" tabindex="-1" aria-labelledby="deleteJadwalModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="deleteJadwalForm" action="" method="POST">
                    @csrf
                    @method('DELETE') <!-- Untuk metode DELETE -->
                    <div class="modal-header">
                        <h5 class="modal-title" id="deleteJadwalModalLabel">Konfirmasi Hapus</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>Apakah Anda yakin ingin menghapus data jadwal ini?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-danger">Hapus</button>
                    </div>
                </form>
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
        $(document).on('click', '#data-jadwal .pagination a', function(event) {
            event.preventDefault();
            var page = $(this).attr('href').split('page_jadwal=')[1];
            fetch_data_jadwal(page);
        });

        function fetch_data_jadwal(page) {
            $.ajax({
                url: "/administrasi/data/jadwal?page_jadwal=" + page,
                success: function(data) {
                    console.log(data);
                    $('#data-jadwal').html(data);
                },
                error: function(xhr) {
                    console.log("Error: " + xhr.status + " " + xhr.statusText);
                }
            });
        }

        flatpickr("#tanggal", {
            dateFormat: "Y-m-d",
            locale: "id",
            allowInput: true
        });
        flatpickr("#waktu", {
            enableTime: true, // Aktifkan input waktu
            noCalendar: true, // Nonaktifkan kalender (hanya waktu)
            dateFormat: "H:i", // Format waktu (HH:mm - 24 jam)
            time_24hr: true,
            allowInput: true
        });

        $(document).on('click', '.btn-edit', function() {
            // Ambil data dari tombol edit
            let id = $(this).data('id');
            let poli = $(this).data('poli');
            let petugas = $(this).data('petugas');
            let tanggal = $(this).data('tanggal');
            let mulai = $(this).data('mulai');
            let selesai = $(this).data('selesai');

            // Isi data ke dalam form modal
            $('#editForm').attr('action', '/administrasi/data/jadwal/' + id);
            $('#editPetugas').val(petugas);
            $('#editPoli').val(poli);
            $('#editTanggal').val(tanggal);
            $('#editWaktuMulai').val(mulai);
            $('#editWaktuSelesai').val(selesai);

            // Tampilkan modal
            $('#editModal').modal('show');

            // Inisialisasi kembali Flatpickr
            flatpickr("#editTanggal", {
                dateFormat: "Y-m-d",
                locale: "id",
                allowInput: true
            });
            flatpickr("#editWaktuMulai", {
                enableTime: true,
                noCalendar: true,
                dateFormat: "H:i",
                time_24hr: true,
                allowInput: true
            });
            flatpickr("#editWaktuSelesai", {
                enableTime: true,
                noCalendar: true,
                dateFormat: "H:i",
                time_24hr: true,
                allowInput: true
            });
        });

        $(document).on('click', '.btn-delete-jadwal', function() {
            // Ambil ID poli dari tombol
            let id = $(this).data('id');

            // Set action pada form modal
            $('#deleteJadwalForm').attr('action', '/administrasi/data/jadwal/' + id);

            // Tampilkan modal konfirmasi
            $('#deleteJadwalModal').modal('show');
        });



    });
</script>
