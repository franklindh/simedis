<x-app-layout>
    <x-slot name="header">
        <div class="mb-2">
            <button class="btn btn-primary" onclick="window.history.back()"><i
                    class="bi bi-arrow-return-left"></i></button>
        </div>
        <div class="row">
            <div class="col-12order-md-1 order-last">
                <h3>Detail Rekam Medis - {{ $dataRekamMedisDetail->nama_pasien }} / {{ $tanggal }} </h3>
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
            <div class="card-header d-flex justify-content-end">
                <button class="btn" style="color: #AD0B00; border: 1px solid;"
                    onclick="window.location.href='{{ route('rekam-medis.cetak', $dataRekamMedisDetail->id_pemeriksaan) }}'">
                    <i class="bi bi-file-earmark-pdf-fill"></i> Cetak
                </button>
                {{-- <button class="btn" style="color: #AD0B00; border: 1px solid;">
                    <i class="bi bi-file-earmark-pdf-fill"></i> Cetak
                </button> --}}

            </div>
            <div class="card-body ">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="nama_pasien">Nama Petugas</label>
                            <input type="text" class="form-control" id="nama_pasien" name="nama_pasien"
                                value="{{ $dataRekamMedisDetail->nama_petugas }}" readonly>
                        </div>
                        <div class="form-group">
                            <label for="tanggal_lahir">Poliklinik</label>
                            <input type="text" class="form-control" id="tanggal_lahir" name="tanggal_lahir"
                                value="{{ $dataRekamMedisDetail->nama_poli }}" readonly>
                        </div>
                    </div>
                    <hr style="border: 3px solid black;">
                    <div class="form-group">
                        <label for="tanggal_lahir">Anamnesis dan Pemeriksaan Fisik</label>
                        <div class="form-control" style="background-color: #E9ECEF;">
                            <div class="row-info">
                                <span>Keluhan</span><span>:</span>
                            </div>
                            <ul>
                                @foreach (explode(',', $dataRekamMedisDetail->keluhan) as $keluhan)
                                    <li>{{ trim($keluhan) }}</li>
                                @endforeach
                            </ul>
                            <div class="row-info">
                                <span>Riwayat</span><span>:</span>
                            </div>
                            <ul>
                                @foreach (explode(',', $dataRekamMedisDetail->riwayat_penyakit) as $riwayat)
                                    <li>{{ trim($riwayat) }}</li>
                                @endforeach
                            </ul>
                            <div class="row-info">
                                <span>Keadaan
                                    Umum</span><span>:</span><span>{{ $dataRekamMedisDetail->keadaan_umum }}</span>
                            </div>
                            {{-- <div class="row-info">
                                <span>Keterangan</span><span>:</span><span>{{ $dataRekamMedisDetail->keterangan }}</span>
                            </div> --}}
                            <div class="row-info">
                                <span>Nadi</span><span>:</span><span>{{ $dataRekamMedisDetail->nadi }} <b>bpm</b></span>
                            </div>
                            <div class="row-info">
                                <span>Tekanan Darah</span><span>:</span><span>{{ $dataRekamMedisDetail->tekanan_darah }}
                                    <b>mmHg</b></span>
                            </div>
                            <div class="row-info">
                                <span>Berat Badan</span><span>:</span><span>{{ $dataRekamMedisDetail->berat_badan }}
                                    <b>kg</b></span>
                            </div>
                            <div class="row-info">
                                <span>Suhu</span><span>:</span><span>{{ $dataRekamMedisDetail->suhu }} <b>°C</b></span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="tanggal_lahir">Diagnosis</label>
                        <div class="form-control" style="background-color: #E9ECEF;">
                            <li>{{ $icd->nama_penyakit }}</li>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="tanggal_lahir">Rencana Terapi/Pengobatan/Edukasi</label>
                        <div class="form-control" style="background-color: #E9ECEF;">
                            <li>{{ $dataRekamMedisDetail->tindakan }}</li>
                        </div>
                    </div>
                    @if ($dataPemeriksaanLab->count() > 0)
                        <hr style="border: 3px solid black;">
                        <div class="form-group">
                            <label for="tanggal_lahir">Pemeriksaan Lab</label>
                            <table class="table table-bordered">
                                <thead>
                                    <tr>

                                        <th>Nama Pemeriksaan</th>
                                        <th>Jenis Pemeriksaan</th>
                                        <th>Hasil</th>
                                        <th>Satuan</th>
                                        <th>Nilai Normal</th>

                                        {{-- <th>Tanggal Dibuat</th> --}}
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($dataPemeriksaanLab as $pemeriksaan)
                                        <tr>

                                            <td>{{ $pemeriksaan->nama_pemeriksaan }}</td>
                                            <td>{{ $pemeriksaan->jenis_pemeriksaan }}</td>
                                            <td>{{ $pemeriksaan->hasil }}</td>
                                            <td>{{ $pemeriksaan->satuan }}</td>
                                            <td>{{ $pemeriksaan->nilai_rujukan }}</td>
                                            {{-- <td>{{ \Carbon\Carbon::parse($pemeriksaan->created_at)->format('d-m-Y H:i') }} --}}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>

                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>
    <style>
        .row-info {
            display: grid;
            grid-template-columns: 150px 10px auto;
            /* Ukuran kolom pertama disesuaikan agar lebih pendek */
            gap: 10px;
            /* Mengatur jarak antar kolom */
            margin-bottom: 5px;
        }

        .row-info span {
            padding: 0;
        }
    </style>
</x-app-layout>
