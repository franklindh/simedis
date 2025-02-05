<x-app-layout>
    <x-slot name="header">
        {{-- @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif --}}

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
                            <input type="hidden" name="id_icd"
                                value="{{ isset($pemeriksaan) && $pemeriksaan->id_icd ? $pemeriksaan->id_icd : '' }}">
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
                                        <label for="riwayat" class="form-label mt-3">Riwayat Penyakit (isi '-' jika
                                            tidak ada):</label>
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
                                        <select id="keadaan_umum" name="keadaan_umum" class="form-control w-50"
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
                                                        {{-- <option value="Kimia Klinik">Kimia Klinik</option>
                                                        <option value="Urine">Urine</option>
                                                        <option value="Hematologi">Hematologi</option> --}}

                                                        @foreach ($groupedPemeriksaan as $kriteria => $items)
                                                            <option value="{{ $kriteria }}"
                                                                {{ isset($pemeriksaan) && in_array($kriteria, $pemeriksaanLab->pluck('jenis_pemeriksaan')->toArray()) ? 'selected' : '' }}>
                                                                {{ $kriteria }}
                                                            </option>
                                                        @endforeach

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
                                                @if (isset($pemeriksaanLab[0]->hasil))
                                                    <a href="{{ route('lab.cetakPDF', ['id' => $pemeriksaanLab[0]->id_pemeriksaan]) }}"
                                                        class="btn btn-primary mt-3">
                                                        Hasil
                                                    </a>
                                                @endif
                                                <a href="{{ route('lab.cetak', ['id' => $pemeriksaanLab[0]->kode_lab, 'id_pemeriksaan' => $pemeriksaanLab[0]->id_pemeriksaan]) }}"
                                                    class="btn btn-primary mt-3">
                                                    Permintaan Pemeriksaan Lab
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
                                            <select id="icd_select" name="id_icd" class="form-control"
                                                {{ isset($pemeriksaan->id_icd) ? 'disabled' : '' }}>
                                                <option value="">-- Pilih ICD --</option>
                                                {{-- @dd($pemeriksaan) --}}
                                                @foreach ($kodeIcd as $kI)
                                                    <option value="{{ $kI->id_icd }}"
                                                        {{ old('id_icd', $pemeriksaan->id_icd ?? '') == $kI->id_icd ? 'selected' : '' }}>
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
                                <!-- Tombol -->
                                @if (isset($pemeriksaan))
                                    <!-- Data sudah ada -->
                                    <button id="editButton" type="button" class="btn btn-primary">Edit</button>
                                    <button id="saveButton" type="submit" class="btn btn-primary"
                                        style="display: none; margin-left: 16px">Simpan Pemeriksaan</button>
                                @else
                                    <!-- Data belum ada -->
                                    <button id="saveButton" type="submit" class="btn btn-primary">Simpan
                                        Pemeriksaan</button>
                                @endif
                            </div>
                        </form>
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
            const groupedPemeriksaan = @json($groupedPemeriksaan);
            // Event listener untuk perubahan pada Select2
            $('#jenisPemeriksaanLab').on('change', function() {
                const selectedValues = $(this).val(); // Ambil nilai yang dipilih
                console.log('Selected values:', selectedValues); // Debug nilai

                dynamicFormContainer.innerHTML = ''; // Kosongkan container

                // Loop nilai yang dipilih untuk membuat template
                selectedValues.forEach(value => {
                    if (groupedPemeriksaan[value]) {
                        // Buat elemen div untuk setiap kategori
                        const categoryDiv = document.createElement('div');
                        categoryDiv.classList.add('category-container', 'mt-4');
                        categoryDiv.innerHTML = `<h5>${value}</h5>`; // Judul kategori

                        // Loop item dalam kategori
                        groupedPemeriksaan[value].forEach(item => {
                            const formGroup = document.createElement('div');
                            formGroup.classList.add('form-check', 'mt-2');
                            formGroup.innerHTML = `
                        <input type="checkbox" class="form-check-input" 
                               name="pemeriksaan_lab[${value}][]" 
                               value="${item.nama_pemeriksaan}">
                        <label class="form-check-label">
                            ${item.nama_pemeriksaan}
                        </label>
                    `;
                            categoryDiv.appendChild(formGroup);
                        });

                        dynamicFormContainer.appendChild(
                            categoryDiv); // Tambahkan kategori ke container
                    } else {
                        console.error(`Data for ${value} not found`);
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
    document.addEventListener('DOMContentLoaded', function() {
        const toggleCheckboxLab = document.getElementById('togglePenunjangLab');
        const penunjangLabCombo = document.getElementById('penunjangLabCombo');
        const dynamicFormContainer = document.getElementById('dynamicFormContainer');
        const dynamicFormButton = document.getElementById('dynamicFormButton');

        toggleCheckboxLab.addEventListener('change', function() {
            if (this.checked) {
                penunjangLabCombo.classList.remove('d-none');
                dynamicFormButton.classList.remove('d-none');
            } else {
                penunjangLabCombo.classList.add('d-none');
                dynamicFormContainer.innerHTML = ''; // Bersihkan form
                dynamicFormButton.classList.add('d-none');
            }
        });

        $('#jenisPemeriksaanLab').select2({
            width: 'resolve',
            placeholder: '-- Pilih Jenis Pemeriksaan --',
            allowClear: true
        });

        // Event listener untuk perubahan pada Select2
        $('#jenisPemeriksaanLab').on('change', function() {
            const selectedValues = $(this).val(); // Ambil nilai yang dipilih (array of values)

            // Hapus form yang tidak lagi dipilih
            Array.from(dynamicFormContainer.children).forEach(child => {
                const formId = child.getAttribute(
                    'data-form-id'); // Ambil data-form-id dari elemen
                if (!selectedValues.includes(formId)) {
                    child.remove(); // Hapus elemen jika form ID tidak termasuk dalam pilihan
                }
            });

            // Tambahkan form baru untuk setiap pilihan yang dipilih
            selectedValues.forEach(value => {
                console.log('Selected Value:', value); // Debug nilai yang dipilih
                const templateId = `template${value.replace(' ', '')}`; // Buat ID template
                console.log('Looking for template ID:', templateId); // Debug ID template

                const template = document.getElementById(
                    templateId); // Ambil template berdasarkan ID
                if (!template) {
                    console.error(
                        `Template not found: ${templateId}`
                    ); // Log error jika template tidak ditemukan
                } else {
                    const clone = template.cloneNode(true); // Kloning template
                    clone.classList.remove('d-none'); // Tampilkan template
                    clone.setAttribute('data-form-id', value); // Tetapkan ID form ke elemen
                    dynamicFormContainer.appendChild(clone); // Tambahkan ke container dinamis
                }
            });
        });

        document.getElementById('generateKodeLabButton').addEventListener('click', function() {
            const selectedPemeriksaan = Array.from(document.querySelectorAll(
                'input[name="pemeriksaan_lab[]"]:checked')).map(checkbox => checkbox.value);
            if (selectedPemeriksaan.length === 0) {
                alert('Silakan pilih minimal satu pemeriksaan lab sebelum mengirim.');
                return;
            }

            const kodeLabContainer = document.getElementById('kodeLab');
            const kodeUnik = 'LAB-' + Math.random().toString(36).substr(2, 8).toUpperCase();
            kodeLabContainer.value = kodeUnik;
        });
    });



    $(document).ready(function() {
        $('.select2').select2({
            width: 'resolve' // Pastikan pengaturan lebar sesuai
        });
    });

    $(document).ready(function() {
        let notyf = new Notyf({
            duration: 1500, // Durasi notifikasi
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
            const saveButton = document.getElementById('saveButton'); // Tombol simpan pemeriksaan
            const formElements = document.querySelectorAll(
                'textarea, input, select'); // Semua elemen dalam form

            // Periksa apakah tombol dalam mode "Edit" atau "Batal Edit"
            if (button.textContent === 'Edit') {
                // Ubah semua elemen menjadi editable
                formElements.forEach(function(element) {
                    element.removeAttribute('readonly');
                    element.removeAttribute('disabled');
                });

                // Tampilkan tombol "Simpan Pemeriksaan"
                saveButton.style.display = 'inline-block';

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

                // Sembunyikan tombol "Simpan Pemeriksaan"
                saveButton.style.display = 'none';

                // Ubah tombol kembali menjadi "Edit"
                button.textContent = 'Edit';
                button.classList.remove('btn-danger');
                button.classList.add('btn-primary');
            }
        });

    });
</script>
