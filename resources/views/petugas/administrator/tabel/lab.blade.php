<table class="table table-hover table-bordered shadow-sm">
    <thead>
        <tr>
            <th>Kode Lab</th>
            <th>Pasien</th>
            <th>Poli</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($pemeriksaan as $p => $item)
            <tr>
                <td>{{ $item->kode_lab }}</td>
                <td>{{ $item->nama_pasien }}</td>
                <td>{{ $item->nama_poli }}</td>
                <td>
                    {{-- <button class="btn btn-primary btn-edit-jadwal" data-id="{{ $item->id_pemeriksaan }}"
                        data-poli="{{ $item->id_poli }}" data-petugas="{{ $item->id_pemeriksaan }}"
                        data-tanggal="{{ $item->tanggal_praktik }}" data-mulai="{{ $item->waktu_mulai }}"
                        data-selesai="{{ $item->waktu_selesai }}">
                        Edit
                    </button> --}}
                    {{-- <button class="btn btn-primary btn-delete-jadwal" data-id="{{ $item->id_pemeriksaan }}">
                        Periksa
                    </button> --}}
                    @if ($item->hasil == null)
                        <button onclick="location.href='{{ route('lab.show', ['id' => $item->id_pemeriksaan]) }}'"
                            type="button" class="btn btn-primary">
                            Periksa
                        </button>
                    @else
                        <button onclick="location.href='{{ route('lab.show', ['id' => $item->id_pemeriksaan]) }}'"
                            type="button" class="btn btn-primary">
                            Lihat
                        </button>
                    @endif
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

@if ($pemeriksaan->hasPages())
    <div class="d-flex justify-content-center mt-3">
        {{ $pemeriksaan->appends(['page_pemeriksaan' => request('page_pemeriksaan')])->links('pagination::bootstrap-4') }}
    </div>
@endif
