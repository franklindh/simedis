<x-app-layout>
    <x-slot name="header">
        <div class="row">
            <div class="col text-end mb-4">
                <button id="btn-tambah-antrian" class="btn btn-success" data-bs-toggle="modal"
                    data-bs-target="#modalTambahAntrian">Tambah Antrian</button>
                <button id="btn-tambah-pasien" class="btn btn-success" data-bs-toggle="modal"
                    data-bs-target="#modalTambahPasien">Tambah Pasien</button>
            </div>
        </div>
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
                <br>
                <div id="data-pasien">
                    @include('petugas.administrator.tabel.pasien', ['pasien' => $pasien])
                </div>
            </div>
        </div>
    </section>

    <!-- Modal Tambah Pasien -->
    <div class="modal fade" id="modalTambahPasien" tabindex="-1" aria-labelledby="modalTambahPasienLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTambahPasienLabel">Tambah Pasien</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <form action="{{ route('pendaftaran.pasien.store') }}" method="POST">
                                    <div class="row">
                                        @csrf
                                        <div class="col">
                                            <div class="form-group">
                                                <label for="nik" style="font-weight: bold;">NIK</label>
                                                <input type="text" class="form-control border border-dark"
                                                    id="nik" name="nik" value="{{ old('nik') }}">
                                                @error('nik')
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="form-group">
                                                <label for="nama_pasien" style="font-weight: bold;">Nama</label>
                                                <input type="text" class="form-control border border-dark"
                                                    id="nama_pasien" name="nama_pasien"
                                                    value="{{ old('nama_pasien') }}">
                                                @error('nama_pasien')
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="form-group">
                                                <label for="tempat_lahir" style="font-weight: bold;">Tempat
                                                    Lahir</label>
                                                <input type="text" class="form-control border border-dark"
                                                    id="tempat_lahir" name="tempat_lahir_pasien"
                                                    value="{{ old('tempat_lahir_pasien') }}">
                                                @error('tempat_lahir_pasien')
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="form-group">
                                                <label for="jenis_kelamin" style="font-weight: bold;">Jenis
                                                    Kelamin</label>
                                                <div>
                                                    <input type="radio" id="lakiLakiAntrian"
                                                        name="jenis_kelamin_pasien" value="L">
                                                    <label for="lakiLakiAntrian">Laki-laki</label>
                                                </div>
                                                <div>
                                                    <input type="radio" id="perempuanAntrian"
                                                        name="jenis_kelamin_pasien" value="P">
                                                    <label for="perempuanAntrian">Perempuan</label>
                                                </div>
                                                @error('jenis_kelamin_pasien')
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>

                                        </div>
                                        <div class="col">
                                            <div class="form-group">
                                                <label for="no_telepon_pasien" style="font-weight: bold;">Nomor
                                                    Telepon</label>
                                                <input type="text" class="form-control border border-dark"
                                                    id="no_telepon_pasien" name="no_telepon_pasien"
                                                    value="{{ old('no_telepon_pasien') }}">
                                                @error('no_telepon_pasien')
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="form-group">
                                                <label for="alamat_pasien" style="font-weight: bold;">Alamat</label>
                                                <textarea name="alamat_pasien" id="alamat_pasien" cols="30" rows="5"
                                                    class="form-control border border-dark"></textarea>
                                                @error('alamat_pasien')
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="form-group">
                                                <label for="tanggal_lahir" style="font-weight: bold;">Tanggal
                                                    Lahir</label>
                                                <input type="text" class="form-control border border-dark"
                                                    id="tanggal_lahir" name="tanggal_lahir_pasien"
                                                    value="{{ old('tanggal_lahir_pasien') }}">
                                                @error('tanggal_lahir_pasien')
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="form-group">
                                                <button class="btn btn-primary">Simpan</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal Tambah Antrian -->
    <div class="modal fade" id="modalTambahAntrian" tabindex="-1" aria-labelledby="modalTambahAntrianLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
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
                                                    onchange="fetchDoctors()">
                                                    {{-- <option value="Administrasi">Administrasi</option>
                                                    <option value="Poliklinik">Poliklinik</option>
                                                    <option value="Dokter">Dokter</option> --}}
                                                    <option value=""></option>
                                                    @foreach ($poli as $item)
                                                        <option value="{{ $item->id_poli }}">
                                                            {{ $item->nama_poli }}
                                                        </option>
                                                    @endforeach
                                                    <!-- Tambahkan opsi role lainnya jika ada -->
                                                </select>
                                                @error('nama_pasien')
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="form-group">
                                                <label for="nama_pasien" style="font-weight: bold;">Dokter</label>
                                                <select class="form-select" id="dokterSelect" name="id_dokter"
                                                    required onchange="fetchSchedule()">
                                                    <option value="">Pilih Dokter</option>
                                                    <!-- Tambahkan opsi role lainnya jika ada -->
                                                </select>
                                                @error('nama_pasien')
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="form-group">
                                                <label for="nama_pasien" style="font-weight: bold;">Prioritas</label>
                                                <select class="form-select" id="dokterSelect" name="prioritas"
                                                    required onchange="fetchSchedule()">
                                                    <option value="Non Gawat">Non Gawat</option>
                                                    <option value="Gawat">Gawat</option>
                                                    <!-- Tambahkan opsi role lainnya jika ada -->
                                                </select>
                                                @error('nama_pasien')
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <button class="btn btn-primary">Tambah Antrian</button>
                                        </div>

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
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<style>
    thead {
        background-color: #465C9E;
        color: #FFFFFF;
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
</style>

<script>
    let notyf = new Notyf({
        duration: 2500, // Durasi notifikasi
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

    function fetchDoctors() {
        var selectedPoli = $('#poliSelect').val();

        $('#dokterSelect').empty().append('<option value="">Pilih Dokter</option>');
        $('#jadwalContainer').empty(); // Kosongkan jadwal ketika poli berubah

        if (selectedPoli) {
            $.ajax({
                url: '/administrasi/dokter', // Laravel route to fetch doctors based on selected Poli
                type: 'GET',
                data: {
                    poli: selectedPoli
                },
                success: function(response) {

                    $('#dokterSelect').empty().append('<option value="">Pilih Dokter</option>');
                    $.each(response.doctors, function(key, value) {
                        console.log(value);
                        $('#dokterSelect').append('<option value="' + value.id_petugas + '">' +
                            value.nama_petugas + '</option>');
                    });
                },
                error: function() {
                    notyf.error('Tidak ada jadwal yang tersedia');

                }
            });
        } else {
            $('#dokterSelect').empty().append('<option value="">Pilih Dokter</option>');
        }
    }

    function fetchSchedule() {
        var selectedDoctor = $('#dokterSelect').val();

        if (selectedDoctor) {
            $.ajax({
                url: '/administrasi/jadwal',
                type: 'GET',
                data: {
                    doctor_id: selectedDoctor,
                    poli_id: $('#poliSelect').val(),
                },
                success: function(response) {
                    if (response.status === 'kosong') {
                        // Menampilkan pesan "Jadwal kosong"
                        $('#jadwalContainer').html('<span class="text-danger">Jadwal kosong</span>');
                    } else {
                        // Menampilkan jadwal yang tersedia
                        $('#jadwalContainer').empty();
                        $.each(response.data, function(key, value) {

                            var jadwalDiv = $(
                                '<div class="card shadow mb-2 jadwal-item" data-id="' + value
                                .id + '">' +
                                '<div class="card-body border">' +
                                '<input type="radio" name="id_jadwal" value="' + value
                                .id_jadwal +
                                '" id="jadwal_' + value.id + '" style="display:none;">' +
                                '<label for="jadwal_' + value.id + '">' +
                                '<p><strong>Tanggal:</strong> ' + value.tanggal_praktik +
                                '</p>' +
                                '<p><strong>Waktu:</strong> ' + value.waktu_mulai + ' - ' +
                                value.waktu_selesai + '</p>' +
                                '<p><strong>Keterangan:</strong> ' + value.keterangan + '</p>' +
                                '</label>' +
                                '</div>' +
                                '</div>'
                            );

                            // Event click untuk memilih jadwal
                            jadwalDiv.on('click', function() {
                                $('input[type="radio"]', this).prop('checked', true);

                                // Hapus border-danger ketika jadwal sudah dipilih
                                $('#jadwalContainer').removeClass('border-danger');

                                // Menambahkan efek visual saat dipilih
                                $('.jadwal-item').removeClass('selected');
                                $(this).addClass('selected');
                            });
                            $('#jadwalContainer').append(jadwalDiv);
                        });
                    }
                },
                error: function() {
                    toastr.error('Tidak ada jadwal praktik');
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
            $('#jadwalContainer').addClass('border-danger'); // Tambahkan kelas "border-danger"
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
