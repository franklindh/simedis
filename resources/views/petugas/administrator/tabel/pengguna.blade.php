<table class="table table-hover table-bordered shadow-sm">
    <thead>
        <tr>
            <th>No</th>
            <th>Username</th>
            <th>Nama</th>
            <th>Peran</th>
            <th>Poli</th>
            <th>Status Akun</th>
            <th colspan="3"></th>
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
                <td>{{ $item->role }} </td>
                <td>{{ $item->nama_poli ?? '' }} </td>
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
                <td>
                    @if (Auth::guard('petugas')->user()->id_petugas !== $item->id_petugas)
                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#confirmModal"
                            data-url="{{ route('data.pengguna.reset-password', $item->id_petugas) }}"
                            data-message="Apakah Anda yakin ingin mereset password untuk pengguna ini?">Reset
                            Password</button>
                        @if ($item->status == 'aktif')
                            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#confirmModal"
                                data-url="{{ route('data.pengguna.nonaktif-petugas', $item->id_petugas) }}"
                                data-message="Apakah Anda yakin ingin menonaktifkan pengguna ini?">
                                Nonaktifkan
                            </button>
                        @else
                            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#confirmModal"
                                data-url="{{ route('data.pengguna.aktif-petugas', $item->id_petugas) }}"
                                data-message="Apakah Anda yakin ingin mengaktifkan kembali pengguna ini?">
                                Aktifkan
                            </button>
                        @endif
                    @else
                        {{-- <span class="text-muted">Tidak dapat mengubah status diri sendiri</span> --}}
                    @endif
                    <button class="btn btn-sm btn-primary btn-edit-pengguna" data-id="{{ $item->id_petugas }}"
                        data-username="{{ $item->username_petugas }}" data-nama="{{ $item->nama_petugas }}"
                        data-peran="{{ $item->role }}" data-poli-id="{{ $item->id_poli }}">
                        Edit
                    </button>
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
