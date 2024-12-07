<x-app-layout>
    <x-slot name="header">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="row">
            <div class="col-12">
                <h3 class="text-center">Skrining dan Pemeriksaan Fisik</h3>
            </div>
        </div>
    </x-slot>

    <section class="section">
        <div class="container mt-4">
            <div class="mb-4">
                <button type="submit" class="btn btn-primary"
                    onclick="location.href='{{ route('pemeriksaan') }}'">Kembali</button>
            </div>
            <div class="card shadow-sm">
                {{-- <div class="card-header text-white py-2">
                    <h5 class="mb-0">Detail Pasien</h5>
                </div> --}}
                <div class="card-body py-2">
                    <p class="mb-1"><strong>Nomor Antrian:</strong> {{ $data->nomor_antrian }}</p>
                    <p class="mb-1"><strong>Nama Pasien:</strong> {{ $data->nama_pasien }}</p>
                    <p class="mb-1"><strong>Nomor Rekam Medis:</strong> {{ $data->no_rekam_medis }}</p>
                </div>
            </div>


            <div class="card">
                <div class="card-body d-flex justify-content-center align-items-center" style="height: 100%;">
                    <div class="accordion w-100" id="accordionExample" style="max-width: 800px;">
                        <form action="{{ route('pemeriksaan.store') }}" id="form-pemeriksaan" method="POST"
                            enctype="multipart/form-data" id="pemeriksaanForm">
                            @csrf
                            <input type="hidden" name="idAntrian" value="{{ $idAntrian }}">
                            <!-- Anamnesa Accordion Item -->
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingOne">
                                    <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                        Anamnesa
                                    </button>
                                </h2>
                                <div id="collapseOne" class="accordion-collapse collapse show"
                                    aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        <label for="keluhan" class="form-label">Keluhan:</label>
                                        <textarea name="keluhan" cols="30" rows="5" class="form-control" {{ isset($pemeriksaan) ? 'readonly' : '' }}>{{ old('keluhan', $pemeriksaan->keluhan ?? '') }}</textarea>
                                        @error('keluhan')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                        <label for="riwayat" class="form-label mt-3">Riwayat Penyakit:</label>
                                        <textarea name="riwayat" cols="30" rows="5" class="form-control"
                                            {{ isset($pemeriksaan) ? 'readonly' : '' }}>{{ old('riwayat', $pemeriksaan->riwayat_penyakit ?? '') }}</textarea>
                                        @error('riwayat')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Pemeriksaan Fisik Accordion Item -->
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingTwo">
                                    <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
                                        Pemeriksaan Fisik
                                    </button>
                                </h2>
                                <div id="collapseTwo" class="accordion-collapse collapse show"
                                    aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        <select id="keadaan_umum" name="keadaan_umum" class="form-control"
                                            {{ isset($pemeriksaan) ? 'readonly' : '' }}>
                                            <option value="">-- Pilih Keadaan Umum --</option>
                                            <option value="Tampak Sakit"
                                                {{ old('keadaan_umum', $pemeriksaan->keadaan_umum ?? '') === 'Tampak Sakit' ? 'selected' : '' }}>
                                                Tampak Sakit</option>
                                            <option value="Baik"
                                                {{ old('keadaan_umum', $pemeriksaan->keadaan_umum ?? '') === 'Baik' ? 'selected' : '' }}>
                                                Baik</option>
                                            <option value="Sesak"
                                                {{ old('keadaan_umum', $pemeriksaan->keadaan_umum ?? '') === 'Sesak' ? 'selected' : '' }}>
                                                Sesak</option>
                                            <option value="Pucat"
                                                {{ old('keadaan_umum', $pemeriksaan->keadaan_umum ?? '') === 'Pucat' ? 'selected' : '' }}>
                                                Pucat</option>
                                            <option value="Lemah"
                                                {{ old('keadaan_umum', $pemeriksaan->keadaan_umum ?? '') === 'Lemah' ? 'selected' : '' }}>
                                                Lemah</option>
                                            <option value="Kejang"
                                                {{ old('keadaan_umum', $pemeriksaan->keadaan_umum ?? '') === 'Kejang' ? 'selected' : '' }}>
                                                Kejang</option>
                                        </select>
                                        @error('keadaan_umum')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                        <label for="berat_badan" class="form-label mt-2">Berat Badan:</label>
                                        <div class="input-group w-50">
                                            <input type="text"
                                                class="form-control form-control-sm @error('berat_badan') is-invalid @enderror"
                                                id="berat_badan" name="berat_badan"
                                                value="{{ old('berat_badan', $pemeriksaan->berat_badan ?? '') }}"
                                                step="0.1" {{ isset($pemeriksaan) ? 'readonly' : '' }}>
                                            <span class="input-group-text">kg</span>
                                        </div>
                                        @error('berat_badan')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                        <label for="suhu_badan" class="form-label mt-2">Suhu Badan:</label>
                                        <div class="input-group w-50">
                                            <input type="text"
                                                class="form-control form-control-sm @error('suhu_badan') is-invalid @enderror"
                                                id="suhu_badan" name="suhu_badan"
                                                value="{{ old('suhu_badan', $pemeriksaan->suhu ?? '') }}"
                                                step="0.1" {{ isset($pemeriksaan) ? 'readonly' : '' }}>
                                            <span class="input-group-text">°C</span>
                                        </div>
                                        @error('suhu_badan')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                        <label for="tekanan_darah" class="form-label mt-2">Tekanan Darah:</label>
                                        <div class="input-group w-50">
                                            <input type="text"
                                                class="form-control form-control-sm @error('tekanan_darah') is-invalid @enderror"
                                                id="tekanan_darah" name="tekanan_darah"
                                                value="{{ old('tekanan_darah', $pemeriksaan->tekanan_darah ?? '') }}"
                                                {{ isset($pemeriksaan) ? 'readonly' : '' }}>
                                            <span class="input-group-text">mmHg</span>
                                        </div>
                                        @error('tekanan_darah')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                        <label for="nadi" class="form-label mt-2">Nadi:</label>
                                        <div class="input-group w-50">
                                            <input type="text"
                                                class="form-control form-control-sm @error('nadi') is-invalid @enderror"
                                                id="nadi" name="nadi"
                                                value="{{ old('nadi', $pemeriksaan->nadi ?? '') }}"
                                                {{ isset($pemeriksaan) ? 'readonly' : '' }}>
                                            <span class="input-group-text">x/mnt</span>
                                        </div>
                                        @error('nadi')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror

                                    </div>
                                </div>
                            </div>
                            <!-- Pemeriksaan Penunjang -->
                            @if (Auth::guard('petugas')->user()->role === 'Dokter')
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="headingPenunjang">
                                        <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#collapsePenunjang" aria-expanded="true"
                                            aria-controls="collapsePenunjang">
                                            Pemeriksaan Penunjang
                                        </button>
                                    </h2>

                                    <div id="collapsePenunjang" class="accordion-collapse show"
                                        aria-labelledby="headingPenunjang" data-bs-parent="#accordionExample">
                                        <div class="accordion-body">
                                            <!-- Checkbox untuk Mengaktifkan Pemeriksaan Lab -->
                                            {{-- @dd($pemeriksaanLab) --}}
                                            @if (isset($pemeriksaanLab[0]->kode_lab))
                                                <div class="mb-3">
                                                    Kode Lab : <strong>{{ $pemeriksaanLab[0]->kode_lab }}</strong>
                                                </div>
                                            @else
                                                <div class="form-check mb-3">
                                                    <input class="form-check-input" type="checkbox"
                                                        id="togglePenunjangLab" name="butuh_pemeriksaan_lab">
                                                    <label class="form-check-label" for="togglePenunjangLab">
                                                        Perlu pemeriksaan lab?
                                                    </label>
                                                </div>
                                            @endif
                                            <!-- Combo Box untuk Jenis Pemeriksaan Lab -->
                                            <div id="penunjangLabCombo" class="d-none">
                                                <div class="form-group">
                                                    <label for="jenisPemeriksaanLab" class="form-label">Jenis
                                                        Pemeriksaan Lab</label>
                                                    <select id="jenisPemeriksaanLab" name="jenis_pemeriksaan_lab[]"
                                                        class="form-control select2" multiple="multiple"
                                                        placeholder="-- Pilih Jenis Pemeriksaan --">
                                                        {{-- <option value="">-- Pilih Jenis Pemeriksaan --</option> --}}
                                                        <option value="Kimia Klinik">Kimia Klinik</option>
                                                        {{-- <option value="Urine">Urine</option>
                                                        <option value="Hematologi">Hematologi</option> --}}
                                                    </select>
                                                </div>
                                            </div>

                                            <!-- Dynamic Form untuk Detail Pemeriksaan -->
                                            <div id="dynamicFormContainer" class="mt-3">
                                                <!-- Detail Pemeriksaan akan digenerate di sini -->
                                            </div>

                                            <!-- Tombol Generate Kode dan Field Kode Lab -->
                                            {{-- <div class="d-flex justify-content-end mt-3 d-none"
                                                id="dynamicFormButton">
                                                <button type="button" id="generateKodeLabButton"
                                                    class="btn btn-primary">Kirim Permintaan Pemeriksaan Lab</button>
                                            </div> --}}
                                            <div class="form-group mt-3 d-none" id="dynamicFormLabel">
                                                <label for="kodeLab" class="form-label">Kode Lab:</label>
                                                <input type="text" id="kodeLab" class="form-control" readonly
                                                    placeholder="Kode akan muncul di sini" name="kode_lab">
                                            </div>
                                            @if (isset($pemeriksaanLab[0]->id_pemeriksaan))
                                                <!-- Periksa apakah ada data -->
                                                <a href="{{ route('lab.cetakPDF', ['id' => $pemeriksaanLab[0]->id_pemeriksaan]) }}"
                                                    class="btn btn-primary mt-3">
                                                    Cetak PDF
                                                </a>
                                            @endif
                                        </div>
                                    </div>

                                </div>
                            @endif
                            <!-- Diagnosis Accordion Item -->
                            @if (Auth::guard('petugas')->user()->role === 'Dokter')
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="headingThree">
                                        <button
                                            class="accordion-button {{ Auth::guard('petugas')->user()->role === 'Dokter' ? '' : 'collapsed' }}"
                                            type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree"
                                            aria-expanded="{{ Auth::guard('petugas')->user()->role === 'Dokter' ? 'true' : 'false' }}"
                                            aria-controls="collapseThree">
                                            Diagnosis
                                        </button>
                                    </h2>
                                    <div id="collapseThree"
                                        class="accordion-collapse collapse {{ Auth::guard('petugas')->user()->role === 'Dokter' ? 'show' : '' }}"
                                        aria-labelledby="headingThree" data-bs-parent="#accordionExample">
                                        <div class="accordion-body">
                                            <!-- Dokter dapat memilih ICD -->
                                            <select id="icd_select" name="icd" class="form-control"
                                                {{ isset($pemeriksaan->id_icd) ? 'disabled' : '' }}>
                                                <option value="">-- Pilih ICD --</option>
                                                @foreach ($kodeIcd as $kI)
                                                    <option value="{{ $kI->id_icd }}"
                                                        {{ isset($pemeriksaan) && $pemeriksaan->id_icd == $kI->id_icd ? 'selected' : '' }}>
                                                        {{ $kI->kode_icd . ' - ' . $kI->nama_penyakit }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @if ($kodeIcd->isEmpty())
                                                <p class="text-danger mt-2">Belum ada ICD yang dapat dipilih.</p>
                                            @endif

                                        </div>
                                    </div>
                                </div>
                            @endif

                            <!-- Tindakan Accordion Item -->
                            @if (Auth::guard('petugas')->user()->role === 'Dokter')
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="headingFour">
                                        <button
                                            class="accordion-button {{ Auth::guard('petugas')->user()->role === 'Dokter' ? '' : 'collapsed' }}"
                                            type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour"
                                            aria-expanded="{{ Auth::guard('petugas')->user()->role === 'Dokter' ? 'true' : 'false' }}"
                                            aria-controls="collapseFour">
                                            Tindakan
                                        </button>
                                    </h2>
                                    <div id="collapseFour"
                                        class="accordion-collapse collapse {{ Auth::guard('petugas')->user()->role === 'Dokter' ? 'show' : '' }}"
                                        aria-labelledby="headingFour" data-bs-parent="#accordionExample">
                                        <div class="accordion-body">
                                            <label for="tindakan" class="form-label">Tindakan:</label>

                                            <!-- Dokter dapat mengisi tindakan -->
                                            <textarea name="tindakan" cols="30" rows="5" class="form-control"
                                                {{ isset($pemeriksaan->tindakan) ? 'readonly' : '' }}>{{ old('tindakan', $pemeriksaan->tindakan ?? '') }}</textarea>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            <div class="d-flex justify-content-end mt-3 px-3">
                                <button type="button" id="editButton" class="btn btn-warning me-2">Edit</button>
                                <button type="submit" class="btn btn-primary">Simpan Pemeriksaan</button>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- Template Pemeriksaan Gula Darah -->
                <div id="templateGulaDarah" class="d-none mt-4">
                    <h5>Kimia Klinik</h5>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="gulaDarahSewaktu"
                            name="pemeriksaan_lab[]" value="Glukosa Sewaktu">
                        <label class="form-check-label" for="gulaDarahSewaktu">Glukosa Sewaktu</label>
                    </div>
                    <div class="form-check mt-2">
                        <input class="form-check-input" type="checkbox" id="gulaDarahPuasa" name="pemeriksaan_lab[]"
                            value="Glukosa 2 Jam PP">
                        <label class="form-check-label" for="gulaDarahPuasa">Glukosa 2 Jam PP</label>
                    </div>
                    <div class="form-check mt-2">
                        <input class="form-check-input" type="checkbox" id="gulaDarahPuasa" name="pemeriksaan_lab[]"
                            value="Glukosa Puasa">
                        <label class="form-check-label" for="gulaDarahPuasa">Glukosa Puasa</label>
                    </div>
                    <div class="form-check mt-2">
                        <input class="form-check-input" type="checkbox" id="gulaDarahPuasa" name="pemeriksaan_lab[]"
                            value="Asam Urat">
                        <label class="form-check-label" for="gulaDarahPuasa">Asam Urat</label>
                    </div>
                    <div class="form-check mt-2">
                        <input class="form-check-input" type="checkbox" id="gulaDarahPuasa" name="pemeriksaan_lab[]"
                            value="Kolestrol">
                        <label class="form-check-label" for="gulaDarahPuasa">Kolestrol</label>
                    </div>
                </div>
                <!-- Template Pemeriksaan Gula Darah -->
                <div id="templateHematologi" class="d-none mt-4">
                    <h5>Hematologi</h5>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="gulaDarahSewaktu"
                            name="pemeriksaan_lab[]" value="Haemoglobin">
                        <label class="form-check-label" for="gulaDarahSewaktu">Haemoglobin</label>
                    </div>
                    <div class="form-check mt-2">
                        <input class="form-check-input" type="checkbox" id="gulaDarahPuasa" name="pemeriksaan_lab[]"
                            value="Leukosit">
                        <label class="form-check-label" for="gulaDarahPuasa">Leukosit</label>
                    </div>
                    <div class="form-check mt-2">
                        <input class="form-check-input" type="checkbox" id="gulaDarahPuasa" name="pemeriksaan_lab[]"
                            value="Trombosit">
                        <label class="form-check-label" for="gulaDarahPuasa">Trombosit</label>
                    </div>
                    <!-- Template Pemeriksaan Fungsi Ginjal -->
                    <div id="templateUrine" class="d-none mt-4">
                        <h5>Urine</h5>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="Kolestrol" name="pemeriksaan_lab[]"
                                value="Warna">
                            <label class="form-check-label" for="Kolestrol">Warna</label>
                        </div>
                        <div class="form-check mt-2">
                            <input class="form-check-input" type="checkbox" id="kreatinin" name="pemeriksaan_lab[]"
                                value="pH">
                            <label class="form-check-label" for="kreatinin">pH</label>
                        </div>
                        <div class="form-check mt-2">
                            <input class="form-check-input" type="checkbox" id="kreatinin" name="pemeriksaan_lab[]"
                                value="Berat Jenis">
                            <label class="form-check-label" for="kreatinin">Berat Jenis</label>
                        </div>
                        <div class="form-check mt-2">
                            <input class="form-check-input" type="checkbox" id="kreatinin" name="pemeriksaan_lab[]"
                                value="Protein">
                            <label class="form-check-label" for="kreatinin">Protein</label>
                        </div>
                        <div class="form-check mt-2">
                            <input class="form-check-input" type="checkbox" id="kreatinin" name="pemeriksaan_lab[]"
                                value="Glukosa">
                            <label class="form-check-label" for="kreatinin">Glukosa</label>
                        </div>
                    </div>
                </div>
    </section>
</x-app-layout>

<style>
    .accordion {
        max-width: 800px;
        width: 100%;
    }

    .accordion-body {
        padding: 1rem;
    }

    .select2-container {
        width: 100% !important;
    }

    .select2-container .select2-selection--multiple {
        min-height: 38px;
        /* Atur tinggi minimal */
    }
</style>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const toggleCheckboxLab = document.getElementById('togglePenunjangLab');
        const penunjangLabCombo = document.getElementById('penunjangLabCombo');
        const dynamicFormContainer = document.getElementById('dynamicFormContainer');
        const dynamicFormButton = document.getElementById('dynamicFormButton');
        const dynamicFormLabel = document.getElementById('dynamicFormLabel');

        // Tampilkan Combo Box saat checkbox dicentang
        toggleCheckboxLab.addEventListener('change', function() {
            if (this.checked) {
                penunjangLabCombo.classList.remove('d-none');
                dynamicFormButton.classList.remove('d-none');
                dynamicFormLabel.classList.remove('d-none');
            } else {
                penunjangLabCombo.classList.add('d-none');
                dynamicFormContainer.innerHTML = ''; // Bersihkan form yang ada saat uncheck
                dynamicFormButton.classList.add('d-none');
                dynamicFormLabel.classList.add('d-none');
            }
        });

        // Inisialisasi Select2 dan event listener untuk perubahan
        $(document).ready(function() {
            $('#jenisPemeriksaanLab').select2({
                width: 'resolve', // Pastikan pengaturan lebar sesuai
                placeholder: "-- Pilih Jenis Pemeriksaan --",
                allowClear: true // Menambahkan tombol untuk menghapus pilihan
            });

            // Event listener untuk perubahan pada Select2
            $('#jenisPemeriksaanLab').on('change', function() {
                const selectedValues = $(this)
                    .val(); // Dapatkan nilai yang dipilih (array of values)

                // Hapus form yang tidak lagi dipilih
                Array.from(dynamicFormContainer.children).forEach(child => {
                    const formId = child.getAttribute('data-form-id');
                    if (!selectedValues.includes(formId)) {
                        child.remove();
                    }
                });

                // Tambahkan form untuk setiap pilihan baru
                selectedValues.forEach(value => {
                    if (!document.querySelector(`[data-form-id="${value}"]`)) {
                        let template;
                        if (value === 'Kimia Klinik') {
                            template = document.getElementById('templateGulaDarah')
                                .cloneNode(true);
                        } else if (value === 'Urine') {
                            template = document.getElementById('templateUrine')
                                .cloneNode(true);
                        } else if (value === 'Hematologi') {
                            template = document.getElementById('templateHematologi')
                                .cloneNode(true);
                        }

                        if (template) {
                            template.classList.remove('d-none');
                            template.setAttribute('data-form-id',
                                value); // Berikan ID form berdasarkan nilai
                            dynamicFormContainer.appendChild(template);
                        }
                    }
                });
            });
        });

        document.getElementById('generateKodeLabButton').addEventListener('click', function() {
            const selectedPemeriksaan = Array.from(document.querySelectorAll(
                'input[name="pemeriksaan_lab[]"]:checked')).map(
                (checkbox) => checkbox.value
            );

            if (selectedPemeriksaan.length === 0) {
                alert('Silakan pilih minimal satu pemeriksaan lab sebelum mengirim.');
                return;
            }

            // Generate satu kode unik untuk seluruh pemeriksaan yang dipilih
            const kodeLabContainer = document.getElementById('kodeLab');
            const kodeUnik = 'LAB-' + Math.random().toString(36).substr(2, 8).toUpperCase();
            kodeLabContainer.value = kodeUnik; // Hanya satu kode lab untuk semua pemeriksaan
        });
    });


    $(document).ready(function() {
        $('.select2').select2({
            width: 'resolve' // Pastikan pengaturan lebar sesuai
        });
    });

    $(document).ready(function() {
        let notyf = new Notyf({
            duration: 4000, // Durasi notifikasi
            position: {
                x: 'right', // posisi X (left/right)
                y: 'top', // posisi Y (top/bottom)
            }
        });

        @if (session('success'))
            notyf.success('{{ session('success') }}');
        @elseif (session('error'))
            notyf.error('{{ session('error') }}');
        @elseif (session('info'))
            notyf.open({
                type: 'info',
                message: '{{ session('info') }}'
            });
        @elseif (session('warning'))
            notyf.open({
                type: 'warning',
                message: '{{ session('warning') }}'
            });
        @endif

        $('#icd_select').select2({
            placeholder: "-- Diagnosis --",
            allowClear: true,
            language: {
                noResults: function() {
                    return "ICD tidak ditemukan";
                }
            }
        });
        document.getElementById('editButton').addEventListener('click', function() {
            const button = this; // Tombol edit/batal
            const formElements = document.querySelectorAll(
                'textarea, input, select'); // Semua elemen dalam form

            // Periksa apakah tombol dalam mode "Edit" atau "Batal Edit"
            if (button.textContent === 'Edit') {
                // Ubah semua elemen menjadi editable
                formElements.forEach(function(element) {
                    element.removeAttribute('readonly');
                    element.removeAttribute('disabled');
                });

                // Ubah tombol menjadi "Batal Edit"
                button.textContent = 'Batal Edit';
                button.classList.remove('btn-warning');
                button.classList.add('btn-danger');
            } else {
                // Kembalikan semua elemen ke readonly/disabled
                formElements.forEach(function(element) {
                    element.setAttribute('readonly', true);
                    if (element.tagName === 'SELECT') {
                        element.setAttribute('disabled',
                            true); // Jika elemen select, tambahkan disabled
                    }
                });

                // Ubah tombol kembali menjadi "Edit"
                button.textContent = 'Edit';
                button.classList.remove('btn-danger');
                button.classList.add('btn-warning');
            }
        });
    });
</script>
