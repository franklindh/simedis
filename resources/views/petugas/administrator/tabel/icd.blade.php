<table class="table table-hover table-bordered shadow-sm">
    <thead>
        <tr>
            <th>Kode ICD</th>
            <th>Nama Penyakit</th>
            <th>Status</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        @foreach ($icds as $icd => $item)
            <tr>
                {{-- <td>{{ ($pasien->currentPage() - 1) * $pasien->perPage() + $loop->iteration }}</td> --}}
                <td>{{ $item->kode_icd }}</td>
                <td>{{ $item->nama_penyakit }}</td>
                <td>
                    @if ($item->status == 'aktif')
                        <span class="badge bg-success">
                            <i class="bi bi-check-circle"></i> Aktif
                        </span>
                    @else
                        <span class="badge bg-danger">
                            <i class="bi bi-x-circle"></i> Nonaktif
                        </span>
                    @endif
                </td>
                <td> <button class="btn btn-primary btn-edit-icd" data-id="{{ $item->id_icd }}"
                        data-kode="{{ $item->kode_icd }}" data-nama="{{ $item->nama_penyakit }}">
                        Edit
                    </button>
                    {{-- <button class="btn btn-primary btn-delete-icd" data-id="{{ $item->id_icd }}">
                        Hapus
                    </button> --}}
                    @if ($item->status == 'aktif')
                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#confirmModal"
                            data-url="{{ route('data.icd.nonaktif', $item->id_icd) }}"
                            data-message="Apakah Anda yakin ingin menonaktifkan icd ini?">
                            Nonaktifkan
                        </button>
                    @else
                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#confirmModal"
                            data-url="{{ route('data.icd.aktif', $item->id_icd) }}"
                            data-message="Apakah Anda yakin ingin mengaktifkan kembali icd ini?">
                            Aktifkan
                        </button>
                    @endif
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

@if ($icds->hasPages())
    <div class="d-flex justify-content-center mt-3">
        {{ $icds->appends(['page_icd' => request('page_icd')])->links('pagination::bootstrap-4') }}
    </div>
@endif
