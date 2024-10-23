<table class="table table-hover table-bordered shadow-sm">
    <thead>
        <tr>
            <th>Nik</th>
            <th>Nomor RM</th>
            <th>Nama Pasien</th>
            <th>Jenis Kelamin</th>
            <th>Alamat</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($pasien as $index => $item)
            @if ($item->jk_pasien == 'L')
                <tr>
                    {{-- <td>{{ ($pasien->currentPage() - 1) * $pasien->perPage() + $loop->iteration }}</td> --}}
                    <td>{{ $item->nik }}</td>
                    <td>{{ $item->no_rekam_medis }}</td>
                    <td>{{ $item->nama_pasien }}</td>
                    <td>Laki-laki</td>
                    <td>{{ $item->alamat_pasien }}</td>
                </tr>
            @else
                <tr>
                    {{-- <td>{{ ($pasien->currentPage() - 1) * $pasien->perPage() + $loop->iteration }}</td> --}}
                    <td>{{ $item->nik }}</td>
                    <td>{{ $item->no_rekam_medis }}</td>
                    <td>{{ $item->nama_pasien }}</td>
                    <td>Perempuan</td>
                    <td>{{ $item->alamat_pasien }}</td>
                </tr>
            @endif
        @endforeach
    </tbody>
</table>

@if ($pasien->hasPages())
    <div class="d-flex justify-content-center mt-3">
        {{ $pasien->appends(['page_pasien' => request('page_pasien')])->links('pagination::bootstrap-4') }}
    </div>
@endif
