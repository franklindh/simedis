<x-app-layout>
    <x-slot name="header">
        <div class="row">
            <div class="col-12">
                <h3>Skrining dan Pemeriksaan Fisik</h3>
            </div>
        </div>
    </x-slot>
    <section class="section">
        <button onclick="window.history.back()" class="btn btn-secondary">Kembali</button>
        <div class="card mt-2">
            <div class="card-body p-3"> <!-- Mengurangi padding card -->
                <form action="{{ route('pemeriksaan.store') }}" id="form-pemeriksaan" method="POST">
                    @csrf
                    <input type="hidden" name="idAntrian" value="{{ $idAntrian ?? '' }}">
                    <div class="card mt-2">
                        <div class="card-body p-2"> <!-- Mengurangi padding body card -->
                            <h5 class="mb-3">Anamnesa</h5>

                            <div class="accordion" id="accordionExample">
                                <!-- Anamnesa Accordion Item -->
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="headingOne">
                                        <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#collapseOne" aria-expanded="true"
                                            aria-controls="collapseOne">
                                            Anamnesa
                                        </button>
                                    </h2>
                                    <div id="collapseOne" class="accordion-collapse collapse show"
                                        aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                        <div class="accordion-body">
                                            <label for="keluhan" class="form-label">Keluhan:</label>
                                            {{-- <input type="text"
                                                class="form-control form-control-sm @error('keluhan') is-invalid @enderror"
                                                id="keluhan" name="keluhan"
                                                value="{{ old('keluhan', $pemeriksaan->keluhan ?? '') }}"
                                                {{ isset($pemeriksaan) ? 'readonly' : '' }}> --}}
                                            <textarea name="keluhan" cols="30" rows="5" class="form-control" {{ isset($pemeriksaan) ? 'readonly' : '' }}>{{ old('keluhan', $pemeriksaan->keluhan ?? '') }}</textarea>
                                            @error('keluhan')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                            <label for="riwayat" class="form-label mt-2">Riwayat Penyakit:</label>
                                            {{-- <input type="text"
                                                class="form-control form-control-sm @error('riwayat') is-invalid @enderror"
                                                id="riwayat" name="riwayat"
                                                value="{{ old('riwayat', $pemeriksaan->riwayat_penyakit ?? '') }}"
                                                {{ isset($pemeriksaan) ? 'readonly' : '' }}> --}}
                                            <textarea name="riwayat" cols="30" rows="5" class="form-control" {{ isset($pemeriksaan) ? 'readonly' : '' }}>{{ old('riwayat', $pemeriksaan->riwayat_penyakit ?? '') }}</textarea>
                                            @error('riwayat')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <!-- Pemeriksaan Fisik Accordion Item -->
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="headingTwo">
                                        <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#collapseTwo" aria-expanded="true"
                                            aria-controls="collapseTwo">
                                            Pemeriksaan Fisik
                                        </button>
                                    </h2>
                                    <div id="collapseTwo" class="accordion-collapse collapse show"
                                        aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                                        <div class="accordion-body">
                                            <label for="keadaan_umum" class="form-label">Keadaan Umum:</label>
                                            <input type="text"
                                                class="form-control form-control-sm @error('keadaan_umum') is-invalid @enderror"
                                                id="keadaan_umum" name="keadaan_umum"
                                                value="{{ old('keadaan_umum', $pemeriksaan->keadaan_umum ?? '') }}"
                                                {{ isset($pemeriksaan) ? 'readonly' : '' }}>
                                            @error('keadaan_umum')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror

                                            <label for="berat_badan" class="form-label mt-2">Berat Badan:</label>
                                            <div class="input-group">
                                                <input type="text"
                                                    class="form-control form-control-sm @error('berat_badan') is-invalid @enderror"
                                                    id="berat_badan" name="berat_badan"
                                                    value="{{ old('berat_badan', $pemeriksaan->berat_badan ?? '') }}"
                                                    step="0.1" {{ isset($pemeriksaan) ? 'readonly' : '' }}>
                                                <span class="input-group-text">kg</span>
                                            </div>
                                            @error('berat_badan')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                            <label for="suhu_badan" class="form-label mt-2">Suhu Badan:</label>
                                            <div class="input-group">
                                                <input type="text"
                                                    class="form-control form-control-sm @error('suhu_badan') is-invalid @enderror"
                                                    id="suhu_badan" name="suhu_badan"
                                                    value="{{ old('suhu_badan', $pemeriksaan->suhu ?? '') }}"
                                                    step="0.1" {{ isset($pemeriksaan) ? 'readonly' : '' }}>
                                                <span class="input-group-text">°C</span>
                                            </div>
                                            @error('suhu_badan')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                            <label for="tekanan_darah" class="form-label mt-2">Tekanan Darah:</label>
                                            <div class="input-group">
                                                <input type="text"
                                                    class="form-control form-control-sm @error('tekanan_darah') is-invalid @enderror"
                                                    id="tekanan_darah" name="tekanan_darah"
                                                    value="{{ old('tekanan_darah', $pemeriksaan->tekanan_darah ?? '') }}"
                                                    {{ isset($pemeriksaan) ? 'readonly' : '' }}>
                                                <span class="input-group-text">mmHg</span>
                                            </div>
                                            @error('tekanan_darah')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                            <label for="nadi" class="form-label mt-2">Nadi:</label>
                                            <div class="input-group">
                                                <input type="text"
                                                    class="form-control form-control-sm @error('nadi') is-invalid @enderror"
                                                    id="nadi" name="nadi"
                                                    value="{{ old('nadi', $pemeriksaan->nadi ?? '') }}"
                                                    {{ isset($pemeriksaan) ? 'readonly' : '' }}>
                                                <span class="input-group-text">x/mnt</span>
                                            </div>
                                            @error('nadi')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                {{-- @dump($errors->all()) --}}

                                {{-- @if (Auth::guard('petugas')->user()->role === 'Dokter') --}}
                                <!-- Anamnesa Accordion Item -->
                                <div class="accordion" id="accordionExample">
                                    <!-- Diagnosis Accordion Item -->
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="headingOne">
                                            <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                                data-bs-target="#collapseOne" aria-expanded="true"
                                                aria-controls="collapseOne">
                                                Diagnosis
                                            </button>
                                        </h2>
                                        <div id="collapseOne" class="accordion-collapse collapse show"
                                            aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                            <div class="accordion-body">
                                                <label for="icd" class="form-label"><strong>ICD:</strong></label>
                                                @if (Auth::guard('petugas')->user()->role === 'Dokter')
                                                    <!-- Dokter dapat memilih ICD -->
                                                    {{-- <select id="icd" name="icd"
                                                        class="form-control"></select> --}}
                                                    {{-- <select id="icd" name="icd" class="form-control">
                                                        @if ($pemeriksaan && $pemeriksaan->icd)
                                                            @foreach ($kodeIcd as $kI)
                                                                <option value="{{ $kI->id_icd }}"
                                                                    {{ $kI->kode_icd == $kI->id_icd ? 'selected' : '' }}>
                                                                    {{ $kI->kode_icd . ' ' . $kI->nama_penyakit }}
                                                                </option>
                                                            @endforeach
                                                        @endif
                                                    </select> --}}
                                                    <select id="icd" name="icd" class="form-control">
                                                        @if ($pemeriksaan && $pemeriksaan->id_icd)
                                                            @foreach ($kodeIcd as $kI)
                                                                <option value="{{ $kI->id_icd }}"
                                                                    {{ $pemeriksaan->id_icd == $kI->id_icd ? 'selected' : '' }}>
                                                                    {{ $kI->kode_icd . ' - ' . $kI->nama_penyakit }}
                                                                </option>
                                                            @endforeach
                                                        @endif
                                                    </select>
                                                @else
                                                    <!-- Petugas Poliklinik hanya dapat melihat ICD yang sudah ada -->
                                                    <p class="form-control-plaintext">
                                                        {{-- {{ $kodeIcd->kode_icd ? $kodeIcd->kode_icd . ' ' . $kodeIcd->nama_penyakit : 'ICD tidak tersedia' }} --}}
                                                    </p>
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Tindakan Accordion Item -->
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="headingTwo">
                                            <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                                data-bs-target="#collapseTwo" aria-expanded="true"
                                                aria-controls="collapseTwo">
                                                Tindakan
                                            </button>
                                        </h2>
                                        <div id="collapseTwo" class="accordion-collapse collapse show"
                                            aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                                            <div class="accordion-body">
                                                <label for="tindakan"
                                                    class="form-label"><strong>Tindakan:</strong></label>

                                                @if (Auth::guard('petugas')->user()->role === 'Dokter')
                                                    <!-- Dokter dapat mengisi tindakan -->
                                                    <textarea name="tindakan" cols="30" rows="5" class="form-control"
                                                        {{ isset($pemeriksaan->tindakan) ? 'readonly' : '' }}>{{ old('tindakan', $pemeriksaan->tindakan ?? '') }}</textarea>
                                                @else
                                                    <!-- Petugas Poliklinik hanya dapat melihat tindakan yang sudah ada -->
                                                    <p class="form-control-plaintext">
                                                        {{ $pemeriksaan->tindakan ?? 'Tindakan tidak tersedia' }}</p>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {{-- @endif --}}







                                {{-- @if (Auth::guard('petugas')->user()->role === 'Dokter')
                                <h5 class="mt-3 mb-3">Diagnosis</h5>
                                <div class="mb-2">
                                    <label for="diagnosis_utama" class="form-label"><strong>Diagnosis
                                            Utama:</strong></label>
                                    <input type="text" class="form-control form-control-sm" id="diagnosis_utama"
                                        name="diagnosis_utama" value="{{ $pemeriksaan->diagnosis_utama ?? '' }}"
                                        {{ isset($pemeriksaan) ? 'readonly' : '' }}>
                                </div>
                            @endif --}}

                                {{-- @if (!isset($pemeriksaan)) --}}
                                <div class="mt-3">
                                    <button type="submit" id="save-button" class="btn btn-primary btn-sm">Simpan
                                        Pemeriksaan</button>
                                    <button type="button" id="edit-button"
                                        class="btn btn-primary btn-sm">Edit</button>
                                </div>
                                {{-- @endif --}}
                            </div>
                        </div>
                </form>
            </div>
        </div>
    </section>
</x-app-layout>
<script>
    // $(document).ready(function() {
    //     @if (Auth::guard('petugas')->user()->role === 'Dokter')
    //         // Inisialisasi Select2 untuk Dokter
    //         $('#icd').select2({
    //             placeholder: 'Pilih ICD',
    //             ajax: {
    //                 url: '{{ route('icd.list') }}', // Endpoint untuk mengambil data ICD
    //                 dataType: 'json',
    //                 delay: 250,
    //                 data: function(params) {
    //                     return {
    //                         search: params.term // Term pencarian
    //                     };
    //                 },
    //                 processResults: function(data) {
    //                     return {
    //                         results: data
    //                     };
    //                 },
    //                 cache: true
    //             }
    //         });

    //         // Memuat data awal jika sudah ada (untuk Dokter)
    //         var existingIcd = "{{ old('icd', $pemeriksaan->icd ?? '') }}"; // Nilai ICD yang sudah ada
    //         if (existingIcd) {
    //             $.ajax({
    //                 url: '{{ route('icd.list') }}', // Sesuaikan dengan endpoint yang sesuai
    //                 data: {
    //                     id: existingIcd
    //                 },
    //                 dataType: 'json',
    //                 success: function(data) {
    //                     var option = new Option(data.text, data.id, true, true);
    //                     $('#icd').append(option).trigger('change');
    //                 }
    //             });
    //         }
    //     @endif
    // });

    // $(document).ready(function() {
    //     $('#icd').select2({
    //         placeholder: 'Pilih ICD',
    //         ajax: {
    //             url: '{{ route('icd.list') }}', // Endpoint untuk mengambil data ICD
    //             dataType: 'json',
    //             delay: 250,
    //             data: function(params) {
    //                 return {
    //                     search: params.term // Kata kunci pencarian
    //                 };
    //             },
    //             processResults: function(data) {
    //                 return {
    //                     results: data
    //                 };
    //             },
    //             cache: true
    //         }
    //     });
    // });

    $(document).ready(function() {
        let isEditable = false;

        // Tombol Edit untuk mengaktifkan semua input dan textarea
        $('#edit-button').click(function() {
            let inputs = $('form input, form textarea'); // Pilih semua input dan textarea di form
            if (!isEditable) {
                inputs.removeAttr('readonly'); // Hapus readonly
                $(this).text('Batal'); // Ubah teks tombol menjadi "Batal"
                isEditable = true;
                inputs.first().focus(); // Fokus pada input pertama
            } else {
                inputs.attr('readonly', true); // Tambahkan kembali readonly
                $(this).text('Edit'); // Ubah teks tombol menjadi "Edit"
                isEditable = false;
            }
        });

        // Tombol Simpan Pemeriksaan
        $('#save-button').click(function(event) {
            event.preventDefault(); // Mencegah submit form secara default

            // Pastikan input tidak readonly saat menyimpan
            if (isEditable) {
                $('form input, form textarea').removeAttr('readonly');
            }

            // Kirimkan form ke server
            $('#form-pemeriksaan').submit();
        });
        $('#icd').select2({
            placeholder: 'Pilih ICD',
            ajax: {
                url: '{{ route('icd.list') }}',
                dataType: 'json',
                delay: 250,
                data: function(params) {
                    return {
                        search: params.term, // Kata kunci pencarian
                        page: params.page || 1 // Halaman pagination
                    };
                },
                processResults: function(data, params) {
                    params.page = params.page || 1;

                    return {
                        results: data.results,
                        pagination: {
                            more: data.pagination.more
                        }
                    };
                },
                cache: true
            }
        });

        // $('#icd').select2({
        //     placeholder: 'Pilih ICD',
        //     ajax: {
        //         url: '{{ route('icd.list') }}',
        //         dataType: 'json',
        //         delay: 250,
        //         data: function(params) {
        //             return {
        //                 search: params.term // Kata kunci pencarian
        //             };
        //         },
        //         processResults: function(data) {
        //             return {
        //                 results: data
        //             };
        //         },
        //         cache: true
        //     }
        // });

        // Muat data awal jika ICD sudah ada
        var existingIcd = "{{ old('icd', $pemeriksaan->icd ?? '') }}";
        if (existingIcd) {
            $.ajax({
                url: '{{ route('icd.list') }}',
                data: {
                    id: existingIcd
                },
                dataType: 'json',
                success: function(data) {
                    var option = new Option(data.text, data.id, true, true);
                    $('#icd').append(option).trigger('change');
                }
            });
        }
    });
</script>
