<x-app-layout>
    <x-slot name="header">
        {{-- <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Form Pemeriksaan Laboratorium') }}
        </h2> --}}
        <h2>
            Form Pemeriksaan Laboratorium
        </h2>
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

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
                <form action="{{ route('lab.store') }}" method="POST" onsubmit="return validateForm(event)">
                    @csrf
                    @foreach ($groupedPemeriksaan as $jenisPemeriksaan => $details)
                        <h5 class="mt-4">Jenis Pemeriksaan: {{ $jenisPemeriksaan }}</h5>
                        <table class="table table-bordered">
                            <thead class="table-success">
                                <tr>
                                    <th>Pemeriksaan</th>
                                    <th>Hasil</th>
                                    <th>Satuan</th>
                                    <th>Nilai Normal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($details as $item)
                                    <tr>
                                        <td>{{ $item->nama_pemeriksaan }}</td>
                                        <td>
                                            <input type="text" class="form-control"
                                                name="hasil[{{ $item->id_pemeriksaan_lab }}]"
                                                placeholder="Masukkan hasil" value="{{ $item->hasil ?? '' }}"
                                                oninput="validateInput(this)" data-normal="{{ $item->nilai_rujukan }}"
                                                required>
                                            <span class="error-message mt-2"
                                                style="color: red; display: none;">Tes</span>

                                            <!-- Jika hasil ada, tampilkan -->
                                        </td>
                                        <td>{{ $item->satuan }}</td>
                                        <td>{{ $item->nilai_rujukan }}</td>
                                    </tr>
                                @endforeach
                                @error('hasil')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </tbody>
                        </table>
                    @endforeach
                    <div class="d-flex justify-content-end mt-4">
                        <button class="btn btn-primary" type="submit">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </section>
    <style>
        input:invalid {
            border-color: red;
        }
    </style>
    <script>
        // function validateInput(input) {
        //     const value = input.value.trim(); // Nilai input
        //     const normal = input.dataset.normal; // Nilai normal
        //     const errorMessage = input.nextElementSibling; // Elemen pesan error
        //     const isNumberNormal = /^-?\d+(\.\d+)?(-\d+(\.\d+)?)?$/.test(normal); // Apakah nilai normal angka/rentang angka
        //     const isNumberInput = /^-?\d+(\.\d+)?$/.test(value); // Apakah input angka

        //     let isValid = true; // Status validasi

        //     // Validasi angka
        //     if (isNumberNormal) {
        //         const isPositiveNumber = isNumberInput && parseFloat(value) >= 0; // Cek jika angka positif
        //         if (value === "" || isPositiveNumber) {
        //             input.style.borderColor = ""; // Kembali normal
        //             errorMessage.style.display = "none";
        //         } else if (!isNumberInput) {
        //             input.style.borderColor = "red"; // Tampilkan error
        //             errorMessage.textContent = "Masukkan harus berupa angka.";
        //             errorMessage.style.display = "block";
        //             isValid = false;
        //         } else if (parseFloat(value) < 0) {
        //             input.style.borderColor = "red"; // Tampilkan error
        //             errorMessage.textContent = "Nilai tidak boleh negatif.";
        //             errorMessage.style.display = "block";
        //             isValid = false;
        //         }
        //     }
        //     // Validasi teks
        //     else {
        //         if (value === "" || !isNumberInput) {
        //             input.style.borderColor = ""; // Kembali normal
        //             errorMessage.style.display = "none";
        //         } else {
        //             input.style.borderColor = "red"; // Tampilkan error
        //             errorMessage.textContent = "Masukkan harus berupa teks.";
        //             errorMessage.style.display = "block";
        //             isValid = false;
        //         }
        //     }

        //     return isValid; // Kembalikan status validasi
        // }
        function validateInput(input) {
            const value = input.value.trim(); // Nilai input
            const errorMessage = input.nextElementSibling; // Elemen pesan error
            const isNumberFormat = /^\d+(\.\d+)?(\/\d+(\.\d+)?)?$/.test(value); // Format angka atau angka/angka
            let isValid = true; // Status validasi

            // Cek apakah ada nilai negatif
            if (isNumberFormat) {
                const parts = value.split('/').map(Number); // Pisahkan nilai jika formatnya angka/angka
                if (parts.some(num => num < 0)) { // Jika ada angka negatif
                    input.style.borderColor = "red";
                    errorMessage.textContent = "Nilai tidak boleh negatif.";
                    errorMessage.style.display = "block";
                    isValid = false;
                } else {
                    input.style.borderColor = ""; // Input valid
                    errorMessage.style.display = "none";
                }
            } else {
                input.style.borderColor = "red"; // Format salah
                errorMessage.textContent = "Masukkan format angka yang valid.";
                errorMessage.style.display = "block";
                isValid = false;
            }

            return isValid; // Kembalikan status validasi
        }




        // Inisialisasi Notyf
        let notyf = new Notyf({
            duration: 1500, // Durasi notifikasi
            position: {
                x: 'right', // posisi X (left/right)
                y: 'top', // posisi Y (top/bottom)
            }
        });

        // Menampilkan notifikasi berdasarkan session Laravel
        // @if (session('success'))
        //     notyf.success('{{ session('success') }}');
        // @elseif (session('error'))
        // @elseif (session('info'))
        //     notyf.open({
        //         type: 'info',
        //         message: '{{ session('info') }}'
        //     });
        // @elseif (session('warning'))
        //     notyf.open({
        //         type: 'warning',
        //         message: '{{ session('warning') }}'
        //     });
        // @endif

        function validateForm(event) {
            const inputs = document.querySelectorAll("input.form-control");
            let isFormValid = true;

            // Validasi setiap input
            inputs.forEach(input => {
                if (!validateInput(input)) {
                    isFormValid = false;
                }
            });

            if (!isFormValid) {
                event.preventDefault(); // Cegah pengiriman form jika ada error
                notyf.error('Form tidak valid. Periksa kembali input.');
            }

            return isFormValid;
        }
    </script>
</x-app-layout>
