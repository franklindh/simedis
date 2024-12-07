<table class="table table-hover table-bordered shadow-sm">
    <thead>
        <tr>
            <th>No Rekam Medis</th>
            <th>Nik</th>
            <th>Pasien</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($pasien as $index => $item)
            <tr>
                {{-- <td>{{ ($pasien->currentPage() - 1) * $pasien->perPage() + $loop->iteration }}</td> --}}
                <td>{{ $item->nik }}</td>
                <td>{{ $item->no_rekam_medis }}</td>
                <td>{{ $item->nama_pasien }}</td>
                <td class="text-nowrap">
                    <button class="btn btn-primary btn-view-patient" data-id="{{ $item->id_pasien }}"
                        data-nik="{{ $item->id_pasien }}" data-nama="{{ $item->nama_pasien }}"
                        data-tempat-lahir="{{ $item->tempat_lahir_pasien }}"
                        data-tanggal-lahir="{{ $item->tanggal_lahir_pasien }}" data-jenis-kelamin="{{ $item->jk_pasien }}"
                        data-telepon="{{ $item->no_telepon_pasien }}" data-alamat="{{ $item->alamat_pasien }}"
                        data-status-pernikahan="{{ $item->status_pernikahan }}"
                        data-nama-keluarga="{{ $item->nama_keluarga_terdekat }}"
                        data-nomor-keluarga="{{ $item->no_telepon_keluarga_terdekat }}">
                        <i class="bi bi-eye"></i>
                    </button>
                    {{-- <button class="btn btn-warning btn-edit-icd" data-id="{{ $item->id_pasien }}"
                        data-noRM="{{ $item->no_rekam_medis }}" data-namaPasien="{{ $item->nama_pasien }}">
                        <i class="bi bi-pencil"></i>
                    </button> --}}
                    <button class="btn btn-danger btn-delete-jadwal" data-id="{{ $item->id_pasien }}">
                        <i class="bi bi-trash"></i>
                    </button>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

@if ($pasien->hasPages())
    <div class="d-flex justify-content-center mt-3">
        {{ $pasien->appends(['page_pasien' => request('page_pasien')])->links('pagination::bootstrap-4') }}
    </div>
@endif
