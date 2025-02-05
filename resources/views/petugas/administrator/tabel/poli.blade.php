    <table class="table table-hover table-bordered shadow-sm">
        <thead class="table-success">
            <tr>
                <th>Poli</th>
                <th>Status</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($polis as $poli => $item)
                <tr>
                    {{-- <td>{{ ($pasien->currentPage() - 1) * $pasien->perPage() + $loop->iteration }}</td> --}}
                    <td>{{ $item->nama_poli }}</td>
                    <td>
                        @if ($item->status_poli == 'aktif')
                            <span class="badge bg-success">
                                <i class="bi bi-check-circle"></i> Aktif
                            </span>
                        @else
                            <span class="badge bg-danger">
                                <i class="bi bi-x-circle"></i> Nonaktif
                            </span>
                        @endif
                    </td>
                    <td> <button class="btn btn-primary btn-edit-poli" data-id="{{ $item->id_poli }}"
                            data-nama="{{ $item->nama_poli }}" data-status="{{ $item->status_poli }}">
                            <i class="bi bi-pencil"></i>
                        </button>
                        {{-- <button class="btn btn-primary btn-delete-poli" data-id="{{ $item->id_poli }}">
                            Hapus
                        </button> --}}
                        {{-- @if ($item->status_poli == 'aktif')
                            <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#confirmModal"
                                data-url="{{ route('data.poli.nonaktif', $item->id_poli) }}"
                                data-message="Nonaktifkan {{ $item->nama_poli }}">
                                <i class="bi bi-power"></i>
                            </button>
                        @else
                            <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#confirmModal"
                                data-url="{{ route('data.poli.aktif', $item->id_poli) }}"
                                data-message="Apakah Anda yakin ingin mengaktifkan kembali poli ini?">
                                <i class="bi bi-power"></i>
                            </button>
                        @endif --}}
                        <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#confirmModal"
                            data-url="{{ route('data.poli.destroy', $item->id_poli) }}"
                            data-message="Hapus {{ $item->nama_poli }}?">
                            <i class="bi bi-trash"></i>
                        </button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>


    @if ($polis->hasPages())
        <div class="d-flex justify-content-center mt-3 pagination-container">
            {{ $polis->appends(['page_poli' => request('page_poli')])->links('pagination::bootstrap-4') }}
        </div>
    @endif
