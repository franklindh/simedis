<table class="table table-hover table-bordered shadow-sm">
    <thead>
        <tr>
            <th>No</th>
            <th>Username</th>
            <th>Nama</th>
            <th>Role</th>
            <th colspan="2"></th>

        </tr>
    </thead>
    <tbody>
        @foreach ($daftarPengguna as $index => $item)
            <tr>
                <td>{{ ($daftarPengguna->currentPage() - 1) * $daftarPengguna->perPage() + $loop->iteration }}
                </td>
                {{-- <td><a href="">{{ $item->username_petugas }}</a></td>
              <td><a href="">{{ $item->nama_petugas }}</td>
              <td>{{ $item->username_petugas }}</td> --}}
                <td>{{ $item->username_petugas }}</td>
                <td>{{ $item->nama_petugas }}</td>
                <td>{{ $item->role }}</td>
                <td>
                    <button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#confirmModal"
                        data-url="{{ route('pengguna.reset-password', $item->id_petugas) }}"
                        data-message="Apakah Anda yakin ingin mereset password untuk pengguna ini?">Reset
                        Password</button>
                    <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#confirmModal"
                        data-url="{{ route('pengguna.nonatif-petugas', $item->id_petugas) }}"
                        data-message="Apakah Anda yakin ingin menonaktifkan pengguna ini?">Nonaktifkan</button>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

@if ($daftarPengguna->hasPages())
    <div class="d-flex justify-content-center mt-3">
        {{ $daftarPengguna->appends(['page_pengguna' => request('page_pengguna')])->links('pagination::bootstrap-4') }}
    </div>
@endif
