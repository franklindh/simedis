<x-app-layout>
    <x-slot name="header">
        {{-- @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif --}}
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Rekam Medis Pasien</h3>
                {{-- <p class="text-subtitle text-muted">This is the main page.</p> --}}
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
        <div class="card border">
            <div class="card-header">
                <form method="GET" action="{{ route('cari') }}" id="form-pencarian">
                    <div class="mb-2">
                        <select id="pasien-select" class="form-control" name="id_pasien" style="width: 80%;">
                            <option value=""></option>
                            @foreach ($pasiens as $pasien)
                                <option value="{{ $pasien->id_pasien }}"
                                    {{ request('id_pasien') == $pasien->id_pasien ? 'selected' : '' }}>
                                    Nik: {{ $pasien->nik }} - Nama: {{ $pasien->nama_pasien }}
                                </option>
                            @endforeach
                        </select>
                        {{-- <button class="btn btn-primary btn-cari" type="submit">Cari</button> --}}
                    </div>
                </form>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col">
                        <div class="form-group">
                            <label for="id_pasien" style="font-weight: bold;">NIK</label>
                            <input type="text" class="form-control" id="id_pasien" name="nik_pasien"
                                value="{{ isset($pasienDetail[0]) ? $pasienDetail[0]->nik : '' }}" readonly>
                        </div>
                        <div class="form-group">
                            <label for="nama_pasien" style="font-weight: bold;">Nama</label>
                            <input type="text" class="form-control" id="nama_pasien" name="nama_pasien"
                                value="{{ isset($pasienDetail[0]) ? $pasienDetail[0]->nama_pasien : '' }}" readonly>
                        </div>
                        <div class="form-group">
                            <label for="jenis_kelamin" style="font-weight: bold;">Jenis Kelamin</label>
                            <input type="text" class="form-control" id="jenis_kelamin" name="jenis_kelamin"
                                value="{{ isset($pasienDetail[0]) ? $jenisKelamin : '' }}" readonly>
                        </div>
                        <div class="form-group">
                            <label for="tempat_lahir" style="font-weight: bold;">Tempat Lahir</label>
                            <input type="text" class="form-control" id="tempat_lahir" name="tempat_lahir"
                                value="{{ isset($pasienDetail[0]) ? $pasienDetail[0]->tempat_lahir_pasien : '' }}"
                                readonly>
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group">
                            <label for="no_rm" style="font-weight: bold;">Nomor Rekam Medis</label>
                            <input type="text" class="form-control" id="no_rm" name="no_rm"
                                value="{{ isset($pasienDetail[0]) ? $pasienDetail[0]->no_rekam_medis : '' }}" readonly>
                        </div>
                        <div class="form-group">
                            <label for="no_telepon_pasien" style="font-weight: bold;">Nomor Telepon</label>
                            <input type="text" class="form-control" id="no_telepon_pasien" name="no_telepon_pasien"
                                value="{{ isset($pasienDetail[0]) ? $pasienDetail[0]->no_telepon_pasien : '' }}"
                                readonly>
                        </div>
                        <div class="form-group">
                            <label for="alamat_pasien" style="font-weight: bold;">Alamat</label>
                            <input type="text" class="form-control" id="alamat_pasien" name="alamat_pasien"
                                value="{{ isset($pasienDetail[0]) ? $pasienDetail[0]->alamat_pasien : '' }}" readonly>
                        </div>
                        <div class="form-group">
                            <label for="tanggal_lahir" style="font-weight: bold;">Tanggal Lahir</label>
                            <input type="text" class="form-control" id="tanggal_lahir" name="tanggal_lahir"
                                value="{{ isset($pasienDetail[0]) ? $tanggalLahir : '' }}" readonly>
                        </div>
                        <div class="form-group">
                            <label for="umur" style="font-weight: bold;">Umur</label>
                            <input type="text" class="form-control" id="umur" name="umur"
                                value="{{ isset($umur) ? $umur : '' }}" readonly>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card border">
            <div class="card-header d-flex justify-content-end">
                {{-- <form method="GET" action="{{ route('cetak') }}" target="_blank" class="d-flex">
                    <input type="text" id="tanggal_periode" name="tanggal_periode" class="form-control me-2"
                        placeholder="Tanggal" hidden>
                    <button class="btn-cetak" id="btn-cetak" type="submit" hidden>
                        <i class="bi bi-file-earmark-pdf-fill"></i> Cetak
                    </button>
                </form> --}}
            </div>
            <div class="card-body">
                <table id="data-tabel" class="table table-hover">
                    <thead>
                        <tr>
                            <th scope="col">No</th>
                            <th scope="col">Tanggal Kunjungan</th>
                            <th scope="col">Poli</th>
                            <th scope="col">Dokter</th>
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
                                    <td>{{ ($pasienDetail->currentPage() - 1) * $pasienDetail->perPage() + $loop->iteration }}
                                    </td>
                                    <td>{{ $tanggal }}</td>
                                    <td>{{ $item->nama_poli }}</td>
                                    <td>{{ $item->nama_petugas }}</td>
                                    <td>
                                        <a href="{{ route('detailByTanggal', ['id_pasien' => $item->id_pasien, 'tanggal' => $item->tanggal_pemeriksaan]) }}"
                                            class="btn btn-primary">Detail</a>
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
                    <button type="button" class="btn btn-danger" id="confirmModalConfirmBtn">Lanjutkan</button>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
<style>
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

        //SweetAlert untuk data tidak ditemukan
        // @if (session('error'))
        //     Swal.fire({
        //         icon: 'error',
        //         title: 'Oops...',
        //         text: "{{ session('error') }}",
        //         confirmButtonText: 'OK',
        //         confirmButtonColor: '#AD0B00'
        //     });
        // @endif

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
