@if ($daftarAntrian->isEmpty())
    <div class=" text-center" role="alert">
        Tidak ada antrian hari ini.
    </div>
@else
    <table id="data-tabel" class="table table-hover table-bordered shadow-sm">
        <thead>
            <tr>
                <th scope="col">Nomor Antrian</th>
                <th scope="col">Pasien</th>
                <th scope="col">Poli</th>
                <th scope="col">Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($daftarAntrian as $index => $item)
                <tr>
                    {{-- <td>{{ ($daftarAntrian->currentPage() - 1) * $daftarAntrian->perPage() + $loop->iteration }}</td> --}}
                    <td>{{ $item->nomor_antrian }}</td>
                    <td>{{ $item->nama_pasien }}</td>
                    <td>{{ $item->nama_poli }}</td>
                    <td>{{ $item->status }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    @if ($daftarAntrian->hasPages())
        <div class="d-flex justify-content-center mt-3 pagination-container">
            {{ $daftarAntrian->appends(['page_antrian' => request('page_antrian')])->links('pagination::bootstrap-4') }}
        </div>
    @endif
@endif
