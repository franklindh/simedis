<x-app-layout>
    <x-slot name="header">
        {{-- @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif --}}
    </x-slot>
    <section class="section">
        <div id="card-utama" class="card fixed-card mb-4">
            <div class="card-body">
                <div class="row align-items-center justify-content-between mb-4">
                    <div class="col-md-6">
                        <h4>Daftar Jadwal</h4>
                    </div>
                </div>
                <div id="data-jadwal">
                    @include('petugas.administrator.tabel.jadwal', ['jadwals' => $jadwals])
                </div>
            </div>
        </div>

        <!-- Tambahkan Form -->
        <div id="form-jadwal-container" class="card mt-4">
            <div class="card-header">
                <h4>Tambah Jadwal</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('data.jadwal.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="tanggal_praktik" class="form-label">Tanggal Praktik</label>
                        <input type="date" id="tanggal_praktik" name="tanggal_praktik" class="form-control w-25"
                            required>
                    </div>
                    <div class="mb-3">
                        <label for="poli" class="form-label">Poli</label><br>
                        <select id="poli" name="id_poli" class="form-control w-25" required>
                            <option value=""></option>
                            @foreach ($poli as $p)
                                <option value="{{ $p->id_poli }}">{{ $p->nama_poli }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="petugas" class="form-label">Dokter</label><br>
                        <select id="petugas" name="id_petugas" class="form-control w-25" required>
                            <option value=""></option>
                            @foreach ($petugas as $petugasItem)
                                <option value="{{ $petugasItem->id_petugas }}">{{ $petugasItem->nama_petugas }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="waktu_mulai" class="form-label">Waktu Mulai</label>
                        <input type="time" id="waktu_mulai" name="waktu_mulai" class="form-control w-25" required>
                    </div>
                    <div class="mb-3">
                        <label for="waktu_selesai" class="form-label">Waktu Selesai</label>
                        <input type="time" id="waktu_selesai" name="waktu_selesai" class="form-control w-25"
                            required>
                    </div>
                    {{-- <div class="mb-3">
                        <label for="keterangan" class="form-label">Keterangan</label>
                        <textarea id="keterangan" name="keterangan" class="form-control"></textarea>
                    </div> --}}
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </form>
            </div>
        </div>
    </section>

    <!-- Modal Edit Jadwal -->
    <div class="modal fade" id="editJadwalModal" tabindex="-1" aria-labelledby="editJadwalModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="editJadwalForm" action="" method="POST">
                    @csrf
                    @method('PUT') <!-- Untuk metode PUT -->
                    <div class="modal-header">
                        <h5 class="modal-title" id="editJadwalModalLabel">Edit Jadwal</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="editPoli" class="form-label">Poli</label><br>
                            <select id="editPoli" class="form-control" name="id_poli" required>
                                @foreach ($poli as $p)
                                    <option value="{{ $p->id_poli }}">{{ $p->nama_poli }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Pilihan Petugas -->
                        <div class="mb-3">
                            <label for="editPetugas" class="form-label">Dokter</label><br>
                            <select id="editPetugas" class="form-control" name="id_petugas" required>
                                @foreach ($petugas as $petugasItem)
                                    <option value="{{ $petugasItem->id_petugas }}">{{ $petugasItem->nama_petugas }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="editTanggalPraktik" class="form-label">Tanggal Praktik</label>
                            <input type="date" id="editTanggalPraktik" class="form-control" name="tanggal_praktik"
                                required>
                        </div>
                        <div class="mb-3">
                            <label for="editWaktuMulai" class="form-label">Waktu Mulai</label>
                            <input type="time" id="editWaktuMulai" class="form-control" name="waktu_mulai" required>
                        </div>
                        <div class="mb-3">
                            <label for="editWaktuSelesai" class="form-label">Waktu Selesai</label>
                            <input type="time" id="editWaktuSelesai" class="form-control" name="waktu_selesai"
                                required>
                        </div>
                        {{-- <div class="mb-3">
                            <label for="editKeterangan" class="form-label">Keterangan</label>
                            <textarea id="editKeterangan" class="form-control" name="keterangan"></textarea>
                        </div> --}}
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
                        <p>Apakah Anda yakin ingin menghapus jadwal ini?</p>
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
    /* Menargetkan Select2 di dalam modal saja */
    #editJadwalModal .select2-container {
        width: 50% !important;
        /* Lebar penuh hanya untuk Select2 di modal */
    }
</style>
<script>
    $(document).ready(function() {
        $('#petugas').select2({
            placeholder: "-- Dokter --",
            allowClear: true,
            language: {
                noResults: function() {
                    return "Petugas tidak ditemukan";
                }
            }
        });
        $('#poli').select2({
            placeholder: "-- Poli --",
            allowClear: true,
            language: {
                noResults: function() {
                    return "Poli tidak ditemukan";
                }
            }
        });
        $('#editPoli').select2({
            dropdownParent: $('#editJadwalModal'), // Agar dropdown tetap berada dalam modal
            placeholder: "-- Poli --",
            allowClear: false,
            language: {
                noResults: function() {
                    return "Poli tidak ditemukan";
                }
            }
        });
        $('#editPetugas').select2({
            dropdownParent: $('#editJadwalModal'), // Agar dropdown tetap berada dalam modal
            placeholder: "-- Petugas --",
            allowClear: false,
            language: {
                noResults: function() {
                    return "Petugas tidak ditemukan";
                }
            }
        });
        // Pagination
        $(document).on('click', '#data-jadwal .pagination a', function(event) {
            event.preventDefault();
            var page = $(this).attr('href').split('page_jadwal=')[1];
            fetch_data_jadwal(page);
        });

        function fetch_data_jadwal(page) {
            $.ajax({
                url: "/administrasi/data/jadwal?page_jadwal=" + page,
                success: function(data) {
                    $('#data-jadwal').html(data);
                },
                error: function(xhr) {
                    console.log("Error: " + xhr.status + " " + xhr.statusText);
                }
            });
        }

        // Edit
        $(document).on('click', '.btn-edit-jadwal', function() {
            let id = $(this).data('id');
            let tanggal = $(this).data('tanggal');
            let mulai = $(this).data('mulai');
            let selesai = $(this).data('selesai');
            let keterangan = $(this).data('keterangan');
            let id_poli = $(this).data('poli');
            let id_petugas = $(this).data('petugas');

            $('#editJadwalForm').attr('action', '/administrasi/data/jadwal/' + id);
            $('#editTanggalPraktik').val(tanggal);
            $('#editWaktuMulai').val(mulai);
            $('#editWaktuSelesai').val(selesai);
            $('#editKeterangan').val(keterangan);
            $('#editPoli').val(id_poli);
            $('#editPetugas').val(id_petugas);

            $('#editPoli').val(id_poli).trigger('change');
            $('#editPetugas').val(id_petugas).trigger('change');

            $('#editJadwalModal').modal('show');
        });

        // Delete
        $(document).on('click', '.btn-delete-jadwal', function() {
            let id = $(this).data('id');
            $('#deleteJadwalForm').attr('action', '/administrasi/data/jadwal/' + id);
            $('#deleteJadwalModal').modal('show');
        });


        const inputTanggal = document.getElementById('tanggal_praktik');
        const today = new Date().toISOString().split('T')[
            0]; // Ambil tanggal hari ini dalam format YYYY-MM-DD
        inputTanggal.min = today; // Tetapkan minimal tanggal ke hari ini


        let notyf = new Notyf({
            duration: 1500, // Durasi notifikasi
            position: {
                x: 'right', // posisi X (left/right)
                y: 'top', // posisi Y (top/bottom)
            }
        });

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
