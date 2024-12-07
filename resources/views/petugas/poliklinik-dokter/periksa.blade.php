<x-app-layout>
    <x-slot name="header">
        {{-- @dd($pasienDetail) --}}
        <div class="row">
            <h3>Skrining dan Pemeriksaan Fisik Poli
                {{ isset($pasienDetail[0]->nama_poli) ? $pasienDetail[0]->nama_poli : '' }}</h3>
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
                            {{-- <th scope="col">Poli</th> --}}
                            <th scope="col">Pasien</th>
                            <th scope="col">Status</th>
                            <th scope="col"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (isset($pasienDetail) && count($pasienDetail) == 0)
                            <tr>
                                <td colspan="5" class="text-center">Belum ada pasien</td>
                            </tr>
                        @elseif (isset($pasienDetail))
                            @foreach ($pasienDetail as $index => $item)
                                <tr>
                                    <td>{{ $item->nomor_antrian }}</td>
                                    <td>{{ $item->no_rekam_medis }}</td>
                                    {{-- <td>{{ $item->nama_poli }}</td> --}}
                                    <td>{{ $item->nama_pasien }}</td>
                                    <td>{{ $item->status }}</td>
                                    @if ($item->status === 'Menunggu')
                                        <td>
                                            <a href="{{ route('pemeriksaan.show', $item->id_antrian) }}"
                                                class="btn btn-primary">
                                                {{ $item->status === 'Selesai' && Auth::guard('petugas')->user()->role === 'Dokter' ? 'Lihat' : 'Periksa' }}
                                            </a>
                                        </td>
                                    @elseif($item->status === 'Menunggu Diagnosis')
                                        <td>
                                            <a href="{{ route('pemeriksaan.show', $item->id_antrian) }}"
                                                class="btn btn-primary">
                                                {{ $item->status === 'Menunggu Diagnosis' && Auth::guard('petugas')->user()->role === 'Dokter' ? 'Periksa' : 'Lihat' }}
                                            </a>
                                        </td>
                                    @elseif($item->status === 'Selesai')
                                        <td>
                                            <a href="{{ route('pemeriksaan.show', $item->id_antrian) }}"
                                                class="btn btn-primary">
                                                Lihat
                                            </a>
                                        </td>
                                    @endif
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
        $('.btn-lihat').on('click', function() {
            let id = $(this).data('id');
            let url = "{{ route('pemeriksaan.show', ':id') }}";
            url = url.replace(':id', id);
            console.log(url);
        });
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
</script>
