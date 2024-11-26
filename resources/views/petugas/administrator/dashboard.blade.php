<x-app-layout>
    <x-slot name="header">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Dashboard</h3>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item active" aria-current="page"></li>
                    </ol>
                </nav>
            </div>
        </div>
    </x-slot>

    <section class="section">
        <div class="row mb-2">
            <div class="col-md-4">
                <form id="filter-form" method="GET" action="{{ route('dashboard') }}">
                    <div class="input-group">
                        <select class="form-select" name="bulan" id="bulan">
                            @foreach (range(1, 12) as $i)
                                <option value="{{ $i }}"
                                    {{ $i == request('bulan', date('n')) ? 'selected' : '' }}>
                                    {{ \Carbon\Carbon::createFromDate(null, $i, 1)->format('F') }}
                                </option>
                            @endforeach
                        </select>
                        <button type="submit" class="btn btn-primary">Filter</button>
                    </div>
                </form>
            </div>
            <div class="col-md-4">
                <div class="input-group">
                    <select class="form-select" id="laporanSelect">
                        <option value="icd" selected>Top 10 Diagnosis</option>
                        <option value="kunjungan_poli">Kunjungan Pasien</option>
                        <!-- Tambahkan laporan lainnya jika diperlukan -->
                    </select>
                    <button id="cetakLaporanBtn" class="btn btn-success">Cetak</button>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <div class="card border">
                    {{-- <div class="card-header">

                    </div> --}}
                    <div class="card-body">
                        <h4>Kunjungan Pasien</h4>
                        @if ($chartPoli)
                            {!! $chartPoli->container() !!}
                        @else
                            <p>Data tidak tersedia untuk bulan ini.</p>
                        @endif

                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="card border">
                    {{-- <div class="card-header">

                    </div> --}}
                    <div class="card-body">
                        <h4>Top 10 Diagnosis</h4>
                        @if ($chartICD)
                            {!! $chartICD->container() !!}
                        @else
                            <p>Data tidak tersedia untuk bulan ini.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>

</x-app-layout>
<script src="{{ LarapexChart::cdn() }}"></script>
@if ($chartPoli)
    {{ $chartPoli->script() }}
@endif

@if ($chartICD)
    {{ $chartICD->script() }}
@endif
<script>
    document.getElementById('cetakLaporanBtn').addEventListener('click', function() {
        // Ambil nilai laporan yang dipilih
        const laporanType = document.getElementById('laporanSelect').value;
        const bulan = document.getElementById('bulan').value;

        // Redirect ke URL laporan dengan parameter
        window.location.href = `/laporan/${laporanType}?bulan=${bulan}`;
    });
</script>
