    <table class="table table-hover table-bordered shadow-sm">
        <thead>
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
                    <td> <button class="btn btn-primary btn-edit-poli" data-id="{{ $item->id_poli }}"
                            data-nama="{{ $item->nama_poli }}">
                            Edit
                        </button>
                        {{-- <button class="btn btn-primary btn-delete-poli" data-id="{{ $item->id_poli }}">
                            Hapus
                        </button> --}}
                        @if ($item->status == 'aktif')
                            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#confirmModal"
                                data-url="{{ route('data.poli.nonaktif', $item->id_poli) }}"
                                data-message="Apakah Anda yakin ingin menonaktifkan poli ini?">
                                Nonaktifkan
                            </button>
                        @else
                            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#confirmModal"
                                data-url="{{ route('data.poli.aktif', $item->id_poli) }}"
                                data-message="Apakah Anda yakin ingin mengaktifkan kembali poli ini?">
                                Aktifkan
                            </button>
                        @endif
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
