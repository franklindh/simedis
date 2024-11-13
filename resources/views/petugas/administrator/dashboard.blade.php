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
        <div class="card border">
            <div class="card-header">
                <h4>Kunjungan Pasien per Bulan Berdasarkan Poli</h4>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        {!! $chart->container() !!} {{-- Menampilkan chart Larapex --}}
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script src="{{ LarapexChart::cdn() }}"></script>
    {{ $chart->script() }}
</x-app-layout>
