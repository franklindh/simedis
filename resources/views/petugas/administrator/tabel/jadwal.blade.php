<table class="table table-hover table-bordered shadow-sm">
    <thead class="table-success">
        <tr>
            <th>Poli</th>
            <th>Nama Petugas</th>
            <th>Tanggal Praktik</th>
            <th>Waktu Mulai</th>
            <th>Waktu Selesai</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        @foreach ($jadwals as $jadwal => $item)
            <tr>
                {{-- <td>{{ ($pasien->currentPage() - 1) * $pasien->perPage() + $loop->iteration }}</td> --}}
                <td>{{ $item->nama_poli }}</td>
                <td>{{ $item->nama_petugas }}</td>
                <td>{{ \Carbon\Carbon::parse($item->tanggal_praktik)->translatedFormat('d F Y') }}</td>
                <td>{{ $item->waktu_mulai }}</td>
                <td>{{ $item->waktu_selesai }}</td>
                <td> <button class="btn btn-primary btn-edit-jadwal" data-id="{{ $item->id_jadwal }}"
                        data-poli="{{ $item->id_poli }}" data-petugas="{{ $item->id_petugas }}"
                        data-tanggal="{{ $item->tanggal_praktik }}" data-mulai="{{ $item->waktu_mulai }}"
                        data-selesai="{{ $item->waktu_selesai }}">
                        <i class="bi bi-pencil"></i>
                    </button>
                    <button class="btn btn-danger btn-delete-jadwal" data-id="{{ $item->id_jadwal }}">
                        <i class="bi bi-trash"></i>
                    </button>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

@if ($jadwals->hasPages())
    <div class="d-flex justify-content-center mt-3">
        {{ $jadwals->appends(['page_jadwal' => request('page_jadwal')])->links('pagination::bootstrap-4') }}
    </div>
@endif
