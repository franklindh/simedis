<x-app-layout>
    <x-slot name="header">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Rekam Medis</h3>
                {{-- <p class="text-subtitle text-muted">This is the main page.</p> --}}
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
        <div class="card">
            {{-- <div class="card-header">
                <h4 class="card-title">Example Content</h4>
            </div> --}}
            <div class="card-body">
                <form method="GET" action="{{ route('cari') }}">
                    <div class="mb-2">
                        <select id="pasien-select" class="form-control" name="nik" style="width: 50%;">
                            <option value="">-- Cari --</option>
                            @foreach ($pasiens as $pasien)
                                <option value="{{ $pasien->nik }}"
                                    {{ request('nik') == $pasien->nik ? 'selected' : '' }}>
                                    {{ $pasien->nama_pasien }} - {{ $pasien->nik }} - {{ $pasien->no_rm }}
                                </option>
                            @endforeach
                        </select>
                        <button class="btn btn-primary btn-cari" type="submit">Cari</button>
                    </div>
                </form>
                {{-- Lorem ipsum dolor sit amet consectetur adipisicing elit. Consectetur quas omnis
                laudantium tempore
                exercitationem, expedita aspernatur sed officia asperiores unde tempora maxime odio
                reprehenderit
                distinctio incidunt! Vel aspernatur dicta consequatur! --}}
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th scope="col">No</th>
                            <th scope="col">Nama Pasien</th>
                            <th scope="col">NIK</th>
                            <th scope="col">Nomor Rekam Medis</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($dataRekamMedis as $index => $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                {{-- <td><button class="btn text-primary  "
                                        onclick="window.location.href='{{ route('detailById', $item->nik) }}'">{{ $item->nama_pasien }}</button>
                                </td> --}}
                                <td><a href="{{ route('detailById', $item->nik) }}">{{ $item->nama_pasien }}</a></td>
                                <td><a href="{{ route('detailById', $item->nik) }}">{{ $item->nik }}</a></td>
                                <td><a href="{{ route('detailById', $item->nik) }}">{{ $item->no_rm }}</a></td>
                                {{-- <td>{{ $item->nama_pasien }}</td>
                                <td>{{ $item->nik }}</td> --}}
                                {{-- <td>
                                    <button class="btn btn-warning text-dark rounded"
                                        onclick="window.location.href='{{ route('detailById', $item->nik) }}'">Detail</button>
                                    <button class="btn btn-info text-dark rounded"
                                        onclick="window.location.href='{{ route('rekam') }}'">Edit</button>
                                </td> --}}
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="d-flex justify-content-center mt-3">
                    {{ $dataRekamMedis->links('pagination::bootstrap-4') }}
                </div>
            </div>
        </div>
        <script type="text/javascript">
            $(document).ready(function() {
                $('#pasien-select').select2({
                    placeholder: "-- Cari --",
                    allowClear: true
                });
            });
        </script>
    </section>


</x-app-layout>
