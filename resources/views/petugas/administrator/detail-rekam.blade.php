<x-app-layout>
    <x-slot name="header">
        <div class="mb-2">
            <button class="btn btn-primary" onclick="window.history.back()"><i
                    class="bi bi-arrow-return-left"></i></button>
        </div>
        <div class="row">
            <div class="col-12 order-md-1 order-last">
                <h3>Detail Rekam Medis - {{ $dataRekamMedisDetail->nama_pasien }}</h3>
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
            <div class="card-body border">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="nama_pasien">NIK</label>
                            <input type="text" class="form-control" id="nama_pasien" name="nama_pasien"
                                value="{{ $dataRekamMedisDetail->nik }}" readonly>
                        </div>
                        <div class="form-group">
                            <label for="nama_pasien">Nama</label>
                            <input type="text" class="form-control" id="nama_pasien" name="nama_pasien"
                                value="{{ $dataRekamMedisDetail->nama_pasien }}" readonly>
                        </div>
                        <div class="form-group">
                            <label for="jenis_kelamin">Jenis Kelamin</label>
                            <input type="text" class="form-control" id="jenis_kelamin" name="jenis_kelamin"
                                value="{{ $dataRekamMedisDetail->jenis_kelamin_pasien }}" readonly>
                        </div>
                        <div class="form-group">
                            <label for="tanggal_lahir">Tanggal Lahir</label>
                            <input type="text" class="form-control" id="tanggal_lahir" name="tanggal_lahir"
                                value="{{ $dataRekamMedisDetail->tanggal_lahir_pasien }}" readonly>
                        </div>
                    </div>
                    <div class="">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th scope="col">No</th>
                                    <th scope="col">Tanggal Kunjungan</th>
                                    <th scope="col">Nama Petugas</th>
                                    <th scope="col">Poliklinik</th>
                                    <th scope="col">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    {{-- <td>{{ $loop->iteration }}</td> --}}
                                    <td>1</td>
                                    <td>{{ $tanggal }}</td>
                                    <td>{{ $dataRekamMedisDetail->nama_petugas }}</td>
                                    <td>{{ $dataRekamMedisDetail->nama_poli }}</td>
                                    <td>
                                        <button class="btn btn-warning text-dark rounded"
                                            onclick="window.location.href='{{ route('detailByTanggal', ['nik' => $dataRekamMedisDetail->nik, 'tanggal' => $dataRekamMedisDetail->tanggal_pemeriksaan]) }}'">Detail</button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-app-layout>
