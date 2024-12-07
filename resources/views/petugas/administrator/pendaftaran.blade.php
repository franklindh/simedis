<x-app-layout>
    <x-slot name="header">
        {{-- <div class="row"> --}}
        <div class="text-end mb-2">
            <button id="btn-tambah-antrian" class="btn btn-success" data-bs-toggle="modal"
                data-bs-target="#modalTambahAntrian"><i class="bi bi-plus-lg"></i></button>
        </div>
        {{-- </div> --}}
    </x-slot>
    <section class="section">
        <div id="card-utama" class="card fixed-card mb-4">
            <div class="card-body">
                <div class="row align-items-center justify-content-end mb-0">
                    <div class="col-md-3">
                        <select id="filterPoli" class="form-control">
                            <option value="">Pilih Poli</option>
                            @foreach ($poli as $item)
                                <option value="{{ $item->id_poli }}">{{ $item->nama_poli }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <select id="filterStatus" class="form-control">
                            <option value="">Pilih Status</option>
                            <option value="Menunggu">Menunggu</option>
                            <option value="Menunggu Diagnosis">Menunggu Diagnosis</option>
                            <option value="Selesai">Selesai</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <input type="text" id="searchAntrian" class="form-control" placeholder="Cari Antrian...">
                    </div>
                </div>
                <br>
                <div id="data-antrian">
                    @include('petugas.administrator.tabel.antrian', ['daftarAntrian' => $daftarAntrian])
                </div>
            </div>
        </div>
        {{-- <div class="row mb-2"> --}}
        <div class="text-end mb-2">
            <button id="btn-tambah-pasien" class="btn btn-success" data-bs-toggle="modal"
                data-bs-target="#modalTambahPasien"><i class="bi bi-plus-lg"></i></button>
        </div>
        {{-- </div> --}}
        <div id="card-utama" class="card fixed-card mb-4">

            <div class="card-body">

                <div class="row align-items-center justify-content-between mb-4">
                    <div class="col-md-6">
                        <h4>Daftar Pasien</h4>
                    </div>
                    <div class="col-md-4">
                        <input type="text" id="searchPasien" class="form-control" placeholder="Cari Pasien...">
                    </div>
                </div>
                <div id="data-pasien">
                    @include('petugas.administrator.tabel.pasien', ['pasien' => $pasien])
                </div>
            </div>
        </div>
    </section>

    <!-- Modal Tambah Pasien -->
    <div class="modal fade" id="modalTambahPasien" tabindex="-1" aria-labelledby="modalTambahPasienLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <!-- Header Modal -->
                <div class="modal-header">
                    <h5 class="modal-title text-primary" id="modalTambahPasienLabel">Tambah Pasien</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <!-- Body Modal -->
                <div class="modal-body">
                    <form id="formTambahPasien" action="{{ route('pendaftaran.pasien.store') }}" method="POST">
                        @csrf

                        <!-- Input NIK -->
                        <div class="form-group mb-3">
                            <label for="nik" class="fw-bold">NIK</label>
                            <input type="text" id="nik" name="nik" class="form-control border border-dark"
                                placeholder="Masukkan NIK: 1234567890123456" value="{{ old('nik') }}">
                            @error('nik')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Input Nama -->
                        <div class="form-group mb-3">
                            <label for="nama_pasien" class="fw-bold">Nama</label>
                            <input type="text" id="nama_pasien" name="nama_pasien"
                                class="form-control border border-dark" placeholder="Masukkan Nama"
                                value="{{ old('nama_pasien') }}">
                            @error('nama_pasien')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Input Tempat Lahir -->
                        <div class="form-group mb-3">
                            <label for="tempat_lahir" class="fw-bold">Tempat Lahir</label>
                            <input type="text" id="tempat_lahir" name="tempat_lahir_pasien"
                                class="form-control border border-dark" placeholder="Masukkan Tempat Lahir"
                                value="{{ old('tempat_lahir_pasien') }}">
                            @error('tempat_lahir_pasien')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Input Tanggal Lahir -->
                        <div class="form-group mb-3">
                            <label for="tanggal_lahir" class="fw-bold">Tanggal Lahir</label>
                            <input type="text" id="tanggal_lahir" name="tanggal_lahir_pasien"
                                class="form-control border border-dark flatpickr" placeholder="Masukkan Tanggal Lahir"
                                value="{{ old('tanggal_lahir_pasien') }}">
                            @error('tanggal_lahir_pasien')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Input Jenis Kelamin -->
                        <div class="form-group mb-3">
                            <label for="jenis_kelamin" class="fw-bold">Jenis Kelamin</label>
                            <select id="jenis_kelamin" name="jenis_kelamin_pasien"
                                class="form-control border border-dark">
                                <option value="">Pilih Jenis Kelamin</option>
                                <option value="L" {{ old('jenis_kelamin_pasien') == 'L' ? 'selected' : '' }}>
                                    Laki-laki</option>
                                <option value="P" {{ old('jenis_kelamin_pasien') == 'P' ? 'selected' : '' }}>
                                    Perempuan</option>
                            </select>
                            @error('jenis_kelamin_pasien')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Input Nomor Telepon -->
                        <div class="form-group mb-3">
                            <label for="no_telepon_pasien" class="fw-bold">Nomor Telepon</label>
                            <input type="text" id="no_telepon_pasien" name="no_telepon_pasien"
                                class="form-control border border-dark" placeholder="Masukkan Nomor Telepon"
                                value="{{ old('no_telepon_pasien') }}">
                            @error('no_telepon_pasien')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Input Alamat -->
                        <div class="form-group mb-3">
                            <label for="alamat_pasien" class="fw-bold">Alamat</label>
                            <textarea id="alamat_pasien" name="alamat_pasien" class="form-control border border-dark" rows="3"
                                placeholder="Masukkan Alamat">{{ old('alamat_pasien') }}</textarea>
                            @error('alamat_pasien')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group mb-3">
                            <label for="alamat_pasien" class="fw-bold">Status Pernikahan</label>
                            <select id="jenis_kelamin" name="status_pernikahan"
                                class="form-control border border-dark">
                                <option value="">Pilih Status Pernikahan</option>
                                <option value="Belum Menikah"
                                    {{ old('status_pernikahan') == 'Belum Menikah' ? 'selected' : '' }}>
                                    Belum Menikah</option>
                                <option value="Menikah" {{ old('status_pernikahan') == 'Menikah' ? 'selected' : '' }}>
                                    Menikah</option>
                                <option value="Cerai Hidup"
                                    {{ old('status_pernikahan') == 'Cerai Hidup' ? 'selected' : '' }}>
                                    Cerai Hidup</option>
                                <option value="Cerai Mati"
                                    {{ old('status_pernikahan') == 'Cerai Mati' ? 'selected' : '' }}>
                                    Cerai Mati</option>
                            </select>
                            @error('status_pernikahan')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group mb-3">
                            <label for="alamat_pasien" class="fw-bold">Nama Keluarga Terdekat</label>
                            <input type="text" id="tempat_lahir" name="nama_keluarga_terdekat"
                                class="form-control border border-dark" placeholder="Masukkan Nama Keluarga Terdekat"
                                value="{{ old('nama_keluarga_terdekat') }}">
                            @error('nama_keluarga_terdekat')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group mb-3">
                            <label for="alamat_pasien" class="fw-bold">Nomor Telepon Keluarga Terdekat</label>
                            <input type="text" id="tempat_lahir" name="no_telepon_keluarga_terdekat"
                                class="form-control border border-dark"
                                placeholder=" Masukkan Nomor Telepon Keluarga Terdekat"
                                value="{{ old('no_telepon_keluarga_terdekat') }}">
                            @error('no_telepon_keluarga_terdekat')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>



                        <!-- Tombol Simpan -->
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary mt-3">
                                <span id="spinner" class="spinner-border spinner-border-sm d-none" role="status"
                                    aria-hidden="true"></span>
                                Simpan Data Pasien
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="editPasienModal" tabindex="-1" aria-labelledby="editPasienModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="editPasienForm" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-header">
                        <h5 class="modal-title" id="editPasienModalLabel">Edit Data Pasien</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id="id_pasien" name="id_pasien">
                        <div class="mb-3">
                            <label for="nik" class="form-label">NIK</label>
                            <input type="text" class="form-control" id="nik" name="nik" required>
                        </div>
                        <div class="mb-3">
                            <label for="nama_pasien" class="form-label">Nama Pasien</label>
                            <input type="text" class="form-control" id="nama_pasien" name="nama_pasien" required>
                        </div>
                        <div class="mb-3">
                            <label for="alamat_pasien" class="form-label">Alamat</label>
                            <input type="text" class="form-control" id="alamat_pasien" name="alamat_pasien"
                                required>
                        </div>
                        <div class="mb-3">
                            <label for="no_telepon_pasien" class="form-label">No. Telepon</label>
                            <input type="text" class="form-control" id="no_telepon_pasien"
                                name="no_telepon_pasien">
                        </div>
                        <!-- Tambahkan input sesuai kebutuhan -->
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <!-- Modal Tambah Antrian -->
    <div class="modal fade " id="modalTambahAntrian" tabindex="-1" aria-labelledby="modalTambahAntrianLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTambahAntrianLabel">Tambah Antrian</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <form id="form-antrian" action="{{ route('pendaftaran.antrian.store') }}"
                                    method="POST">
                                    <div class="row">
                                        @csrf
                                        <div class="col">
                                            <div class="form-group">
                                                <label for="nik" style="font-weight: bold;">Pasien</label>
                                                <select class="form-select" id="patientSelect" name="id_pasien"
                                                    required>
                                                    <option value=""></option>
                                                    @foreach ($pasienAll as $item)
                                                        <option value="{{ $item->id_pasien }}">
                                                            {{ $item->nama_pasien }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @error('nik')
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="form-group">
                                                <label for="nama_pasien" style="font-weight: bold;">Poli</label>
                                                <select class="form-select" id="poliSelect" name="id_poli" required
                                                    onchange="fetchSchedule()">
                                                    <option value="">Pilih Poli</option>
                                                    @foreach ($poli as $item)
                                                        <option value="{{ $item->id_poli }}">{{ $item->nama_poli }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @error('nama_pasien')
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>

                                        </div>

                                    </div>
                                    <div class="row">
                                        <div class="col ">
                                            <label for="jadwal_praktik" style="font-weight: bold;">Jadwal
                                                Praktek</label>
                                            <div class="form-group" style="max-height: 300px; overflow-y: auto;">
                                                <div id="jadwalContainer"
                                                    style="max-height: 300px; overflow-y: auto;">
                                                    <!-- This will be populated dynamically based on the selected Dokter -->
                                                </div>
                                                @error('jadwal_praktik')
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <button class="btn btn-primary">Tambah Antrian</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="viewPatientModal" tabindex="-1" aria-labelledby="viewPatientModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="viewPatientModalLabel">Detail Pasien</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="viewPatientForm">
                        <div class="mb-3">
                            <label for="viewNIK" class="form-label">NIK</label>
                            <input type="text" class="form-control" id="viewNIK" name="nik" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="viewNama" class="form-label">Nama</label>
                            <input type="text" class="form-control" id="viewNama" name="nama" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="viewTempatLahir" class="form-label">Tempat Lahir</label>
                            <input type="text" class="form-control" id="viewTempatLahir" name="tempat_lahir"
                                readonly>
                        </div>
                        <div class="mb-3">
                            <label for="viewTanggalLahir" class="form-label">Tanggal Lahir</label>
                            <input type="date" class="form-control" id="viewTanggalLahir" name="tanggal_lahir"
                                readonly>
                        </div>
                        <div class="mb-3">
                            <label for="viewJenisKelamin" class="form-label">Jenis Kelamin</label>
                            <select id="viewJenisKelamin" name="jenis_kelamin_pasien"
                                class="form-control border border-dark" readonly>
                                <option value="">Pilih Jenis Kelamin</option>
                                <option value="L">
                                    Laki-laki</option>
                                <option value="P">
                                    Perempuan</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="viewTelepon" class="form-label">Nomor Telepon</label>
                            <input type="text" class="form-control" id="viewTelepon" name="telepon" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="viewAlamat" class="form-label">Alamat</label>
                            <textarea class="form-control" id="viewAlamat" name="alamat" readonly></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="viewStatusPernikahan" class="form-label">Status Pernikahan</label>
                            <input type="text" class="form-control" id="viewStatusPernikahan"
                                name="status_pernikahan" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="viewKeluarga" class="form-label">Nama Keluarga Terdekat</label>
                            <input type="text" class="form-control" id="viewKeluarga" name="keluarga" readonly>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="button" class="btn btn-primary" id="editPatientButton">Edit</button>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>

<style>
    thead {
        border-bottom: 3px solid #000;
        /* Ketebalan dan warna garis */
        font-weight: bold;
        /* Opsional: Membuat teks tebal */
    }

    .mb-0 {
        margin-bottom: 0px !important;
    }

    .row {
        padding: 0px !important;
        /* Hilangkan padding jika ingin lebih menempel */
    }

    .form-control {
        height: 36px;
        padding: 6px 10px;
    }

    .table {
        margin-top: 0px !important;
        padding-top: 0px !important;
    }

    #modalTambahAntrian .fixed-card {
        position: relative;
        /* Memungkinkan pergeseran saat form muncul */
        transition: top 0.3s ease;
        /* Animasi untuk pergeseran, kurangi waktu transisi jika diinginkan */
    }

    .shifted {
        top: 20px;
        /* Sesuaikan nilai ini untuk mengurangi jarak */
    }

    #form-tambah-antrian {
        margin-bottom: 0;
        /* Kurangi margin bawah form */
    }

    #card-utama {
        margin-top: 0;
        /* Kurangi margin atas card */
        padding-top: 10px;
        /* Jika padding terlalu besar, kurangi */
    }

    /* .table th {
        color: #ffffff;
        background-color: #1885f1;
    } */

    /* Atur lebar select2 */
    .select2-container {
        width: 100% !important;
        /* Buat dropdown mengambil lebar penuh */
    }

    .jadwal-item {
        cursor: pointer;
    }

    .jadwal-item.selected {
        background-color: #d4edda;
        /* Hijau muda sebagai tanda terpilih */
        border-color: #155724;
        /* Border hijau */
    }

    .border-danger {
        border: 2px solid red;
        padding: 10px;
        border-radius: 5px;
    }

    #jadwalContainer .form-check {
        border: 1px solid #ddd;
        border-radius: 5px;
        padding: 10px;
        margin-bottom: 5px;
        cursor: pointer;
        transition: background-color 0.2s, border-color 0.2s;
    }

    #jadwalContainer .form-check:hover {
        background-color: #f8f9fa;
        /* Warna abu-abu muda saat hover */
    }

    #jadwalContainer .form-check-input:checked+.form-check-label {
        background-color: #d4edda;
        /* Hijau muda */
        border-color: #155724;
        /* Hijau */
        padding: 10px;
        border-radius: 5px;
        transition: background-color 0.3s, border-color 0.3s;
    }

    #jadwalContainer .form-check-label {
        display: block;
        /* Agar label mencakup seluruh elemen */
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Tangkap event klik tombol lihat
        $(document).on('click', '.btn-view-patient', function() {
            const nik = $(this).data('nik');
            const nama = $(this).data('nama');
            const tempatLahir = $(this).data('tempatLahir');
            const tanggalLahir = $(this).data('tanggalLahir');
            const jenisKelamin = $(this).data('jenisKelamin') === 'L' ? 'Laki-laki' :
                'Perempuan'; // Kondisi jenis kelamin
            const telepon = $(this).data('telepon');
            const alamat = $(this).data('alamat');
            const statusPernikahan = $(this).data('statusPernikahan');
            const keluarga = $(this).data('keluarga');

            // Isi data ke modal
            $('#viewNIK').val(nik);
            $('#viewNama').val(nama);
            $('#viewTempatLahir').val(tempatLahir);
            $('#viewTanggalLahir').val(tanggalLahir);
            $('#viewJenisKelamin').val(jenisKelamin);
            $('#viewTelepon').val(telepon);
            $('#viewAlamat').val(alamat);
            $('#viewStatusPernikahan').val(statusPernikahan);
            $('#viewKeluarga').val(keluarga);

            // Tampilkan modal
            const modal = new bootstrap.Modal(document.getElementById('viewPatientModal'));
            modal.show();
        });

        // Tangkap event klik tombol edit
        document.getElementById('editPatientButton').addEventListener('click', function() {
            // Ubah semua input menjadi bisa diedit
            const inputs = document.querySelectorAll(
                '#viewPatientForm input, #viewPatientForm textarea');
            inputs.forEach(input => input.removeAttribute('readonly'));

            // Ganti tombol menjadi "Simpan"
            this.textContent = 'Simpan';
            this.classList.remove('btn-primary');
            this.classList.add('btn-success');

            // Tambahkan logika penyimpanan jika tombol diklik lagi
            this.addEventListener('click', function() {
                // Kirim form untuk penyimpanan (sesuaikan dengan backend Anda)
                document.getElementById('viewPatientForm').submit();
            }, {
                once: true
            });
        });

        // Reset modal saat ditutup
        document.getElementById('viewPatientModal').addEventListener('hidden.bs.modal', function() {
            // Ubah semua input kembali menjadi readonly
            const inputs = document.querySelectorAll(
                '#viewPatientForm input, #viewPatientForm textarea');
            inputs.forEach(input => input.setAttribute('readonly', true));

            // Reset tombol edit menjadi default
            const editButton = document.getElementById('editPatientButton');
            editButton.textContent = 'Edit';
            editButton.classList.remove('btn-success');
            editButton.classList.add('btn-primary');
        });
    });

    let notyf = new Notyf({
        duration: 1500, // Durasi notifikasi
        position: {
            x: 'right', // posisi X (left/right)
            y: 'top', // posisi Y (top/bottom)
        }
    });

    $(document).ready(function() {
        $('#searchPasien').on('keyup', function() {
            var query = $(this).val(); // Ambil nilai input
            fetch_data_pasien(query); // Panggil fungsi untuk mengambil data pasien
        });

        function fetch_data_pasien(query = '') {
            $.ajax({
                url: "{{ route('search.pasien') }}", // Pastikan route sesuai
                method: 'GET',
                data: {
                    query: query
                }, // Kirim nilai input pencarian
                success: function(data) {
                    $('#data-pasien').html(data); // Update tabel pasien dengan data baru
                },
                error: function(xhr, status, error) {
                    console.log(xhr.responseText); // Debug jika terjadi error
                }
            });
        }
    });
    $(document).ready(function() {
        $('#filterPoli, #filterStatus').on('change', function() {
            var poli = $('#filterPoli').val();
            var status = $('#filterStatus').val();
            fetch_data_antrian('', 1, poli, status); // Panggil fungsi dengan filter
        });

        $(document).on('click', '#data-antrian .pagination a', function(event) {
            event.preventDefault();
            var page = $(this).attr('href').split('page_antrian=')[1];
            var poli = $('#filterPoli').val();
            var status = $('#filterStatus').val();
            fetch_data_antrian('', page, poli, status);
        });

        function fetch_data_antrian(query = '', page = 1, poli = '', status = '') {
            $.ajax({
                url: "{{ route('search.antrian') }}",
                method: 'GET',
                data: {
                    query: query,
                    page_antrian: page,
                    poli: poli,
                    status: status // Kirim data filter ke server
                },
                success: function(data) {
                    $('#data-antrian').html(data); // Update tabel dengan data baru
                },
                error: function(xhr, status, error) {
                    console.log(xhr.responseText);
                }
            });
        }

        // Panggil fungsi untuk menampilkan data awal saat halaman dimuat
        fetch_data_antrian();
    });

    // function fetchDoctors() {
    //     var selectedPoli = $('#poliSelect').val();

    //     $('#dokterSelect').empty().append('<option value="">Pilih Dokter</option>');
    //     $('#jadwalContainer').empty(); // Kosongkan jadwal ketika poli berubah

    //     if (selectedPoli) {
    //         $.ajax({
    //             url: '/administrasi/dokter', // Laravel route to fetch doctors based on selected Poli
    //             type: 'GET',
    //             data: {
    //                 poli: selectedPoli
    //             },
    //             success: function(response) {

    //                 $('#dokterSelect').empty().append('<option value="">Pilih Dokter</option>');
    //                 $.each(response.doctors, function(key, value) {
    //                     console.log(value);
    //                     $('#dokterSelect').append('<option value="' + value.id_petugas + '">' +
    //                         value.nama_petugas + '</option>');
    //                 });
    //             },
    //             error: function() {
    //                 notyf.error('Tidak ada jadwal yang tersedia');

    //             }
    //         });
    //     } else {
    //         $('#dokterSelect').empty().append('<option value="">Pilih Dokter</option>');
    //     }
    // }

    // function fetchSchedule() {
    //     var selectedDoctor = $('#dokterSelect').val();

    //     if (selectedDoctor) {
    //         $.ajax({
    //             url: '/administrasi/jadwal',
    //             type: 'GET',
    //             data: {
    //                 doctor_id: selectedDoctor,
    //                 poli_id: $('#poliSelect').val(),
    //             },
    //             success: function(response) {
    //                 if (response.status === 'kosong') {
    //                     // Menampilkan pesan "Jadwal kosong"
    //                     $('#jadwalContainer').html('<span class="text-danger">Jadwal kosong</span>');
    //                 } else {
    //                     // Menampilkan jadwal yang tersedia
    //                     $('#jadwalContainer').empty();
    //                     $.each(response.data, function(key, value) {

    //                         var jadwalDiv = $(
    //                             '<div class="card shadow mb-2 jadwal-item" data-id="' + value
    //                             .id + '">' +
    //                             '<div class="card-body border">' +
    //                             '<input type="radio" name="id_jadwal" value="' + value
    //                             .id_jadwal +
    //                             '" id="jadwal_' + value.id + '" style="display:none;">' +
    //                             '<label for="jadwal_' + value.id + '">' +
    //                             '<p><strong>Tanggal:</strong> ' + value.tanggal_praktik +
    //                             '</p>' +
    //                             '<p><strong>Waktu:</strong> ' + value.waktu_mulai + ' - ' +
    //                             value.waktu_selesai + '</p>' +
    //                             '<p><strong>Keterangan:</strong> ' + value.keterangan + '</p>' +
    //                             '</label>' +
    //                             '</div>' +
    //                             '</div>'
    //                         );

    //                         // Event click untuk memilih jadwal
    //                         jadwalDiv.on('click', function() {
    //                             $('input[type="radio"]', this).prop('checked', true);

    //                             // Hapus border-danger ketika jadwal sudah dipilih
    //                             $('#jadwalContainer').removeClass('border-danger');

    //                             // Menambahkan efek visual saat dipilih
    //                             $('.jadwal-item').removeClass('selected');
    //                             $(this).addClass('selected');
    //                         });
    //                         $('#jadwalContainer').append(jadwalDiv);
    //                     });
    //                 }
    //             },
    //             error: function() {
    //                 toastr.error('Tidak ada jadwal praktik');
    //             }
    //         });

    //     } else {
    //         $('#jadwalContainer').empty();
    //     }
    // }
    function fetchSchedule() {
        let selectedPoli = $('#poliSelect').val(); // Ambil value poli yang dipilih
        $('#jadwalContainer').empty(); // Kosongkan kontainer jadwal

        if (selectedPoli) {
            $.ajax({
                url: '/administrasi/jadwal', // Ganti dengan route yang sesuai
                type: 'GET',
                data: {
                    poli_id: selectedPoli
                }, // Kirim ID poli ke server
                success: function(response) {
                    if (response.status === 'kosong') {
                        $('#jadwalContainer').html('<span class="text-danger">Jadwal kosong</span>');
                    } else {
                        response.data.forEach(function(item) {
                            // Konversi tanggal menggunakan Intl.DateTimeFormat
                            let formattedDate = new Intl.DateTimeFormat('id-ID', {
                                day: 'numeric',
                                month: 'long',
                                year: 'numeric'
                            }).format(new Date(item.tanggal_praktik));
                            let jadwalHTML = `
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="radio" name="id_jadwal" id="jadwal_${item.id_jadwal}" value="${item.id_jadwal}">
                                <label class="form-check-label" for="jadwal_${item.id_jadwal}">
                                    <strong>Tanggal:</strong> ${formattedDate}<br>
                                    <strong>Waktu:</strong> ${item.waktu_mulai} - ${item.waktu_selesai}<br>
                                    <strong>Petugas:</strong> ${item.nama_petugas}<br>
                                </label>
                            </div>`;
                            $('#jadwalContainer').append(jadwalHTML);
                        });
                    }
                },
                error: function() {
                    toastr.error('Gagal mengambil data jadwal');
                }
            });
        } else {
            $('#jadwalContainer').empty();
        }
    }



    // Tambahkan validasi agar form tidak bisa disubmit tanpa memilih jadwal
    $('#form-antrian').on('submit', function(event) {
        if (!$('input[name="id_jadwal"]:checked').val()) {
            event.preventDefault(); // Cegah form agar tidak disubmit
            notyf.error('Pilih jadwal terlebih dahulu');

            // Menambahkan efek highlight ke container jadwal
            // $('#jadwalContainer').addClass('border-danger'); // Tambahkan kelas "border-danger"
            return false; // Hentikan proses submit
        }
    });
    $(document).ready(function() {
        // Menggunakan event delegation pada pagination
        $(document).on('click', '#data-antrian .pagination a', function(event) {
            event.preventDefault();
            var page = $(this).attr('href').split('page_antrian=')[1];
            fetch_data_antrian(page);
        });

        function fetch_data_antrian(page) {
            $.ajax({
                url: "/administrasi/pendaftaran?page_antrian=" + page,
                success: function(data) {
                    $('#data-antrian').html(data);
                },
                error: function(xhr) {
                    console.log("Error: " + xhr.status + " " + xhr.statusText);
                }
            });
        }

        $(document).on('click', '#data-pasien .pagination a', function(event) {
            event.preventDefault();
            var page = $(this).attr('href').split('page_pasien=')[1];
            fetch_data_pasien(page);
        });

        function fetch_data_pasien(page) {
            $.ajax({
                url: "/administrasi/pendaftaran?page_pasien=" + page,
                success: function(data) {
                    $('#data-pasien').html(data);
                },
                error: function(xhr) {
                    console.log("Error: " + xhr.status + " " + xhr.statusText);
                }
            });
        }

        // Menampilkan modal tambah pasien jika ada error di dalamnya
        @if (
            $errors->has('no_telepon_pasien') ||
                $errors->has('nik') ||
                $errors->has('nama_pasien') ||
                $errors->has('tempat_lahir_pasien') ||
                $errors->has('jenis_kelamin_pasien') ||
                $errors->has('alamat_pasien') ||
                $errors->has('tanggal_lahir_pasien'))
            $('#modalTambahPasien').modal('show');
        @endif

        // Menampilkan modal tambah antrian jika ada error di dalamnya
        @if (
            $errors->has('nomor_antrian') ||
                $errors->has('id_pasien') ||
                $errors->has('id_poli') ||
                $errors->has('tanggal_antrian'))
            $('#modalTambahAntrian').modal('show');
        @endif

        // Mengosongkan inputan saat modal "Tambah Pasien" dibuka
        $('#modalTambahPasien').on('show.bs.modal', function() {
            if (!$(this).hasClass('persisted')) {
                // Reset semua inputan di dalam form
                $(this).find('input[type="text"], input[type="number"], textarea').val('');
                // Reset radio button
                $(this).find('input[type="radio"]').prop('checked', false);

                // Hapus semua pesan kesalahan
                $(this).find('.text-danger').remove();
                $(this).find('.is-invalid').removeClass('is-invalid');
            } else {
                // Hilangkan kelas persisted setelah modal ditutup
                $(this).removeClass('persisted');
            }
        });

        // Jika ada kesalahan, buka modal secara otomatis
        if ($("#modalTambahAntrian").hasClass("show")) {
            // Modal harus terbuka dan diinisialisasi ulang
            $("#modalTambahAntrian").addClass('persisted').modal('show');
        }
        $('#modalTambahAntrian').on('show.bs.modal', function() {
            if (!$(this).hasClass('persisted')) {
                // Reset semua inputan di dalam form
                $(this).find('input[type="text"], input[type="number"], textarea').val('');
                // Reset radio button
                $(this).find('input[type="radio"]').prop('checked', false);

                // Hapus semua pesan kesalahan
                $(this).find('.text-danger').remove();
                $(this).find('.is-invalid').removeClass('is-invalid');
            } else {
                // Hilangkan kelas persisted setelah modal ditutup
                $(this).removeClass('persisted');
            }
        });



        $('#patientSelect').select2({
            placeholder: "Pilih pasien",
            allowClear: true,
            dropdownParent: $('#modalTambahAntrian') // Tambahkan ini untuk modal
        });

        $('#poliSelect').select2({
            placeholder: "Pilih poli",
            allowClear: true,
            dropdownParent: $('#modalTambahAntrian') // Tambahkan ini untuk modal
        });

        flatpickr("#tanggal_lahir", {
            dateFormat: "Y-m-d", // Format tanggal
            altInput: true, // Input alternatif yang lebih user-friendly
            altFormat: "F j, Y", // Format alternatif untuk ditampilkan
            locale: "id", // Setel bahasa Indonesia
            allowInput: true // Memungkinkan pengguna untuk mengetik langsung
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
