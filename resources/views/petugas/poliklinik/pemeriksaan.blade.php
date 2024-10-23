<x-app-layout>
    <x-slot name="header">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Skrining dan Pemeriksaan Fisik</h3>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item active" aria-current="page"></li>
                    </ol>
                </nav>
            </div>
        </div>
    </x-slot>
    <section class="section">
        <div class="card">
            <div class="card-body">
                <table id="data-tabel" class="table table-hover">
                    <thead>
                        <tr>
                            <th scope="col">Nomor Antrian</th>
                            <th scope="col">No RM</th>
                            <th scope="col">Poli</th>
                            <th scope="col">Pasien</th>
                            <th scope="col">Status</th>
                            <th scope="col"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (isset($pasienDetail) && count($pasienDetail) == 0)
                            <tr>
                                <td colspan="3" class="text-center">Data tidak ditemukan</td>
                            </tr>
                        @elseif (isset($pasienDetail))
                            @foreach ($pasienDetail as $index => $item)
                                <tr>
                                    <td>{{ $item->nomor_antrian }}</td>
                                    <td>{{ $item->no_rekam_medis }}</td>
                                    <td>{{ $item->nama_poli }}</td>
                                    <td>{{ $item->nama_pasien }}</td>
                                    <td>{{ $item->status }}</td>
                                    <td>
                                        <button class="btn btn-primary btn-lihat" data-bs-toggle="modal"
                                            data-id="{{ $item->id_antrian }}"
                                            data-bs-target="#lihatModal">Periksa</button>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
                @if (isset($pasienDetail) && $pasienDetail->count() > 0)
                    {{-- @dd($pasienDetail) --}}
                    <div class="d-flex justify-content-center mt-3 pagination-container">
                        {{ $pasienDetail->appends(['id_pasien' => request('id_pasien')])->links('pagination::bootstrap-4') }}
                    </div>
                @endif
            </div>
        </div>
    </section>
    <!-- Modal Pemeriksaan -->
    <div class="modal fade" id="lihatModal" tabindex="-1" aria-labelledby="pemeriksaanModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="pemeriksaanModalLabel">Skrining dan Pemeriksaan Fisik</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Form Diagnosis dengan Tab Navigasi -->
                    <div class="container mt-4" id="diagnosaForm" style="">
                        <!-- Tab Navigation -->
                        <ul class="nav nav-tabs" id="formTabs" role="tablist">
                            <li class="nav-item" role="presentation">
                                <a class="nav-link active" id="anamnesa-tab" data-bs-toggle="tab" href="#anamnesa"
                                    role="tab" aria-controls="anamnesa" aria-selected="true">Anamnesa</a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" id="pemeriksaan-fisik-tab" data-bs-toggle="tab"
                                    href="#pemeriksaan-fisik" role="tab" aria-controls="pemeriksaan-fisik"
                                    aria-selected="false">Pemeriksaan Fisik</a>
                            </li>
                            @if (Auth::guard('petugas')->check() && Auth::guard('petugas')->user()->role === 'Dokter')
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link" id="diagnosis-tab" data-bs-toggle="tab" href="#diagnosis"
                                        role="tab" aria-controls="diagnosis" aria-selected="false">Diagnosis</a>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link" id="rencana-awal-tab" data-bs-toggle="tab" href="#rencana-awal"
                                        role="tab" aria-controls="rencana-awal" aria-selected="false">Rencana
                                        Awal</a>
                                </li>
                            @endif

                        </ul>

                        <!-- Tab Content -->
                        <form action="{{ route('pemeriksaan.store') }}" method="post">
                            @csrf
                            <input type="hidden" name="id_antrian" id="id_antrian" value="">
                            <div class="tab-content" id="formTabContent">
                                <!-- Anamnesa Tab -->
                                <div class="tab-pane fade show active" id="anamnesa" role="tabpanel"
                                    aria-labelledby="anamnesa-tab">
                                    <h4 class="mt-3">Anamnesa</h4>
                                    <div class="mb-3">
                                        <label for="keluhan" class="form-label">Keluhan</label>
                                        <textarea style="resize: none; height: 100px" class="form-control" id="lihat_keluhan" name="keluhan"></textarea>
                                    </div>
                                    <div class="mb-3">
                                        <label for="riwayat" class="form-label">Riwayat Penyakit</label>
                                        <textarea style="resize: none; height: 100px" class="form-control" id="riwayat" name="riwayat"></textarea>
                                    </div>
                                </div>
                                <!-- Pemeriksaan Fisik Tab -->
                                <div class="tab-pane fade" id="pemeriksaan-fisik" role="tabpanel"
                                    aria-labelledby="pemeriksaan-fisik-tab">
                                    <h4 class="mt-3">Pemeriksaan Fisik</h4>
                                    <label for="keadaan_umum" class="form-label">Keadaan Umum</label>
                                    <div class="d-flex mb-2">
                                        <input type="text" class="form-control" id="lihat_keadaan_umum"
                                            name="keadaan_umum" required>
                                    </div>
                                    <label for="berat_badan" class="form-label">Berat Badan</label>
                                    <div class="d-flex mb-2">
                                        <input type="text" class="form-control" id="lihat_berat_badan"
                                            name="berat_badan" required>
                                        <span class="input-group-text ms-2">Kg</span>
                                    </div>
                                    <label for="suhu_badan" class="form-label">Suhu Badan</label>
                                    <div class="d-flex mb-2">
                                        <input type="text" class="form-control" id="lihat_suhu_badan"
                                            name="suhu_badan" required>
                                        <span class="input-group-text ms-2">°C</span>
                                    </div>
                                    <label for="tensi" class="form-label">Tekanan Darah</label>
                                    <div class="d-flex mb-2">
                                        <input type="text" class="form-control" id="lihat_tekanan_darah"
                                            name="tekanan_darah" required>
                                        <span class="input-group-text ms-2">mmHg</span>
                                    </div>
                                    <label for="nadi" class="form-label">Nadi</label>
                                    <div class="d-flex mb-2">
                                        <input type="text" class="form-control" id="lihat_nadi" name="nadi"
                                            required>
                                        <span class="input-group-text ms-2">x/mnt</span>
                                    </div>
                                </div>
                                <!-- Diagnosis Tab -->
                                @if (Auth::guard('petugas')->check() && Auth::guard('petugas')->user()->role === 'Dokter')
                                    <div class="tab-pane fade" id="diagnosis" role="tabpanel"
                                        aria-labelledby="diagnosis-tab">
                                        <h4 class="mt-3">Diagnosis</h4>
                                        <div class="mb-3">
                                            <label for="diagnosis-utama" class="form-label">Diagnosis</label>
                                            {{-- <p id="lihat_diagnosa_utama"></p> --}}

                                            {{-- <input type="text" class="form-control" id="lihat_diagnosa_utama"
                                                name="diagnosa_utama" required> --}}
                                            {{-- <select class="form-select" id="diagnosis-utama" name="diagnosis_utama">
                                                <option>-- Pilih --</option>
                                                @foreach ($kodeIcd as $item)
                                                    <option value="{{ $item->id_icd }}">{{ $item->kode_icd }} -
                                                        {{ $item->nama_penyakit }}</option>
                                                @endforeach
                                            </select> --}}
                                            <select class="form-select" id="diagnosis-utama" name="diagnosis_utama"
                                                required>
                                                <option value="">-- Pilih --</option> {{-- Ubah value menjadi kosong untuk memastikan validasi --}}
                                                @foreach ($kodeIcd as $item)
                                                    <option value="{{ $item->id_icd }}">{{ $item->kode_icd }} -
                                                        {{ $item->nama_penyakit }}</option>
                                                @endforeach
                                            </select>

                                        </div>
                                        {{-- <div class="mb-3">
                                            <label for="diagnosis-penyerta" class="form-label">Diagnosis
                                                Penyerta</label>
                                            <input type="text" class="form-control" id="lihat_diagnosa_penyerta"
                                                name="diagnosa_penyerta" required>
                                        </div> --}}
                                    </div>

                                    <!-- Rencana Awal Tab -->
                                    <div class="tab-pane fade" id="rencana-awal" role="tabpanel"
                                        aria-labelledby="rencana-awal-tab">
                                        <h4 class="mt-3">Rencana Awal</h4>

                                        <div class="mb-3">
                                            <label for="rencana" class="form-label">Rencana Pengobatan</label>
                                            {{-- <textarea class="form-control" id="rencana" name="rencana"></textarea> --}}
                                            <textarea style="resize: none; height: 100px" class="form-control" id="rencana" name="rencana"></textarea>
                                        </div>
                                    </div>
                                @endif


                            </div>
                            <!-- Tombol di luar Tab -->
                            <div class="d-flex justify-content-end mt-3">
                                <button type="button" id="editForm" class="btn btn-warning me-2">Edit</button>
                                <button class="btn btn-secondary me-2">Batal</button>
                                <button class="btn btn-success" type="submit">Simpan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
<style>
    .modal-lg {
        max-width: 800px;
        /* Atur lebar maksimal modal */
    }

    .modal-body {
        overflow-y: auto;
        /* Aktifkan scroll jika konten melebihi ukuran modal */
        max-height: 500px;
        /* Atur tinggi maksimal modal */
    }

    .btn-cetak {
        background-color: #fff;
        color: #AD0B00;
        border-radius: 5px;
        border-color: #AD0B00;
        transition: background-color 0.3s ease, color 0.3s ease;
    }

    .btn-cetak:hover {
        background-color: #AD0B00;
        color: #fff;
        /* Warna teks berubah menjadi putih saat dihover */
        border-color: #AD0B00;
    }

    /* Custom Flatpickr Input Style */
    #tanggal_periode {
        background-color: #fff;
        border: 1px solid #ccc;
        border-radius: 5px;
        padding: 8px;
        max-width: 200px;
        /* Membatasi lebar kolom tanggal */
    }

    /* Placeholder Style */
    #tanggal_periode::placeholder {
        color: #999;
        font-style: italic;
    }
</style>
<script type="text/javascript">
    $(document).ready(function() {
        $('#btnBeriDiagnosa').on('click', function() {
            // Toggle form diagnosa dengan slide
            $('#diagnosaForm').slideToggle(function() {
                // Periksa apakah form tersembunyi atau terlihat setelah toggle
                if ($(this).is(':visible')) {
                    $('#btnBeriDiagnosa').text('Tutup Form Diagnosa');
                } else {
                    $('#btnBeriDiagnosa').text('Beri Diagnosa');
                }
            });
        });

        $('.btn-lihat').on('click', function() {
            var antrianId = $(this).data('id'); // Ambil ID antrian dari atribut data-id
            $('#id_antrian').val(antrianId); // Isi input hidden dengan ID antrian
            // Lakukan AJAX request untuk mengambil data pemeriksaan
            $.ajax({
                url: "{{ route('pemeriksaan.detailById', ':id') }}".replace(':id',
                    antrianId), // Mengambil route dari Laravel
                type: 'GET',
                success: function(data) {
                    if (data) {
                        // Jika data ditemukan, isi form dan set input menjadi readonly
                        $('#lihat_keluhan').val(data.keluhan).attr('readonly', true);
                        $('#lihat_keadaan_umum').val(data.keadaan_umum).attr('readonly',
                            true);
                        $('#lihat_berat_badan').val(data.berat_badan).attr('readonly',
                            true);
                        $('#lihat_suhu_badan').val(data.suhu_badan).attr('readonly', true);
                        $('#lihat_tekanan_darah').val(data.tekanan_darah).attr('readonly',
                            true);
                        $('#lihat_nadi').val(data.nadi).attr('readonly', true);
                        $('#rencana').val(data.tindakan).attr('readonly', true);
                        $('#riwayat').val(data.riwayat).attr('readonly', true);
                        // $('#lihat_diagnosa_utama').innerHTML = data.diagnosis);
                    } else {
                        // Jika data tidak ditemukan, pastikan input tidak readonly dan set inputan menjadi required
                        $('#lihat_keluhan').val('').removeAttr('readonly').attr('required',
                            true);
                        $('#lihat_keadaan_umum').val('').removeAttr('readonly').attr(
                            'required', true);
                        $('#lihat_berat_badan').val('').removeAttr('readonly').attr(
                            'required', true);
                        $('#lihat_suhu_badan').val('').removeAttr('readonly').attr(
                            'required', true);
                        $('#lihat_tekanan_darah').val('').removeAttr('readonly').attr(
                            'required', true);
                        $('#lihat_nadi').val('').removeAttr('readonly').attr('required',
                            true);
                        $('#rencana').val('').removeAttr('readonly').attr('required',
                            true);
                        $('#riwayat').val('').removeAttr('readonly').attr('required',
                            true);
                    }
                },
                error: function(xhr, status, error) {
                    console.log(error); // Untuk debugging jika terjadi kesalahan
                }
            });
            // Event listener untuk tombol "Edit"
            $('#editForm').on('click', function() {
                // Ubah semua input yang tadinya readonly menjadi required kembali (editable)
                $('#lihat_keluhan').removeAttr('readonly').attr('required', true);
                $('#lihat_keadaan_umum').removeAttr('readonly').attr('required', true);
                $('#lihat_berat_badan').removeAttr('readonly').attr('required', true);
                $('#lihat_suhu_badan').removeAttr('readonly').attr('required', true);
                $('#lihat_tekanan_darah').removeAttr('readonly').attr('required', true);
                $('#lihat_nadi').removeAttr('readonly').attr('required', true);
                $('#rencana').removeAttr('readonly').attr('required', true);
                $('#riwayat').removeAttr('readonly').attr('required', true);
                $('#lihat_diagnosa_utama').removeAttr('readonly').attr('required', true);

                // Opsional: Sembunyikan tombol edit jika hanya ingin tombol terlihat satu kali
                // $(this).hide();
            });
        });

        // Inisialisasi Select2
        $('#pasien-select').select2({
            placeholder: "-- Cari Pasien --",
            allowClear: true,
            language: {
                noResults: function() {
                    return "Pasien tidak ditemukan";
                }
            }
        });
        // Event listener untuk saat pilihan dihapus (tombol x ditekan)
        $('#pasien-select').on('select2:clear', function(e) {
            // Bersihkan semua kolom input yang terkait
            $('#id_pasien').val('');
            $('#nama_pasien').val('');
            $('#jenis_kelamin').val('');
            $('#tempat_lahir').val('');
            $('#no_rm').val('');
            $('#no_telepon_pasien').val('');
            $('#alamat_pasien').val('');
            $('#tanggal_lahir').val('');
            $('#umur').val('');

            $('#data-tabel tbody').empty();

            let baseUrl = "{{ route('rekam') }}";
            window.history.replaceState(null, null, baseUrl); // Ubah URL tanpa reload halaman

            $('.pagination-container').remove(); // Hilangkan hanya pagination
            // Sembunyikan kembali kolom tanggal dan tombol cetak
            $('#tanggal_periode').attr('hidden', true);
            $('#btn-cetak').attr('hidden', true);
        });
        // Event listener untuk mencegah submit saat Select2 clear
        $('#form-pencarian').on('submit', function(e) {
            if ($('#pasien-select').val() === "") {
                e.preventDefault(); // Mencegah form dikirim jika tidak ada pilihan
            }
        });
        // Event listener untuk mengirim form secara otomatis saat memilih pasien
        $('#pasien-select').on('change', function() {
            $('#form-pencarian').submit();
        });
        // Menampilkan kolom tanggal dan tombol cetak setelah data pencarian muncul
        if ($('#data-tabel tbody tr').length > 0) {
            $('#tanggal_periode').removeAttr('hidden');
            $('#btn-cetak').removeAttr('hidden');
        }

        flatpickr("#tanggal_periode", {
            dateFormat: "Y-m-d",
            mode: "range",
            locale: "id",
            allowInput: true
        });

        // Event listener untuk tombol cetak
        $('#btn-cetak').on('click', function(e) {
            var tanggalPeriode = $('#tanggal_periode').val();
            if (tanggalPeriode === "") {
                e.preventDefault();
                Swal.fire({
                    icon: 'warning',
                    title: 'Perhatian',
                    text: 'Silakan pilih tanggal periode terlebih dahulu.',
                    confirmButtonText: 'OK',
                    confirmButtonColor: '#AD0B00'
                });
            } else {
                // Logika untuk mencetak PDF dengan tanggal periode
                console.log("Mencetak untuk tanggal: " + tanggalPeriode);
            }
        });

        $('.btn-cari').on('click', function(e) {
            var selectedValue = $('#pasien-select').val();
            if (selectedValue === "") {
                e.preventDefault();
                Swal.fire({
                    icon: 'warning',
                    title: 'Perhatian',
                    text: 'Silahkan pilih pasien terlebih dahulu.',
                    confirmButtonText: 'OK',
                    confirmButtonColor: '#AD0B00'
                });
            }
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
