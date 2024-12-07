<x-app-layout>
    <x-slot name="header">
        {{-- <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Form Pemeriksaan Laboratorium') }}
        </h2> --}}
        <h2>
            Form Pemeriksaan Laboratorium
        </h2>
    </x-slot>

    <section class="section">
        <div class="card mb-4">
            {{-- <div class="card-header  text-white">
                <h4>Form Hasil Pemeriksaan Laboratorium</h4>
            </div> --}}
            <div class="card-body">

                <!-- Informasi Pasien -->
                <div class="mb-3">
                    <strong>Nomor Rekam Medis:</strong> {{ $pemeriksaan->first()->no_rekam_medis }} <br>
                    <strong>Nama Pasien:</strong> {{ $pemeriksaan->first()->nama_pasien }} <br>
                    <strong>Poli:</strong> {{ $pemeriksaan->first()->nama_poli }} <br>
                    <strong>Tanggal Pemeriksaan:</strong> {{ $tanggal }}
                </div>

                <!-- Form Dinamis -->
                <form action="{{ route('lab.store') }}" method="POST">
                    @csrf
                    @foreach ($groupedPemeriksaan as $jenisPemeriksaan => $details)
                        <h5 class="mt-4">Jenis Pemeriksaan: {{ $jenisPemeriksaan }}</h5>
                        <table class="table table-bordered">
                            <thead class="table-success">
                                <tr>
                                    <th>Nama Pemeriksaan</th>
                                    <th>Hasil</th>
                                    <th>Satuan</th>
                                    <th>Nilai Rujukan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($details as $item)
                                    <tr>
                                        <td>{{ $item->nama_pemeriksaan }}</td>
                                        <td>
                                            <input type="text" class="form-control"
                                                name="hasil[{{ $item->id_pemeriksaan_lab }}]"
                                                placeholder="Masukkan hasil" value="{{ $item->hasil ?? '' }}">
                                            <!-- Jika hasil ada, tampilkan -->
                                        </td>
                                        <td>{{ $item->satuan }}</td>
                                        <td>{{ $item->nilai_rujukan }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endforeach

                    {{-- <!-- Tombol Submit -->
                    <div class="text-end mt-3">
                        <button type="submit" class="btn btn-danger">Simpan Hasil Pemeriksaan</button>
                        <a href="{{ route('lab.index') }}" class="btn btn-secondary">Kembali</a>
                    </div> --}}
                    <button class="btn btn-primary" type="submit">Simpan</button>
                </form>
            </div>
        </div>
    </section>
</x-app-layout>
