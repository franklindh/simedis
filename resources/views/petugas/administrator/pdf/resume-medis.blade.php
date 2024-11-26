<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Resume Medis</title>
        <style>
            /* Mengatur halaman PDF menjadi landscape */
            @page {
                size: A4 landscape;
                margin: 10mm;
            }

            body {
                font-family: Arial, sans-serif;
                margin: 0;
                padding: 0;
                display: flex;
                align-items: center;
                justify-content: center;
                height: 100vh;
                /* background-color: #f4f4f4; */
            }

            .container {
                width: 95%;
                max-width: 1000px;
                height: auto;
                padding: 20px;
                box-sizing: border-box;
                background-color: white;
                border: 1px solid black;
                display: flex;
                flex-direction: column;
                justify-content: space-between;
                /* box-shadow: none; */
                /* Pastikan tidak ada bayangan di sini */
            }

            .header {
                display: flex;
                justify-content: space-between;
                align-items: center;
                text-align: center;
                border-bottom: 2px solid black;
                padding-bottom: 10px;
                margin-bottom: 10px;
            }

            .header img {
                width: 70px;
            }

            .header h1 {
                font-size: 16px;
                margin: 0;
            }

            .header h2 {
                font-size: 14px;
                margin: 0;
                font-weight: bold;
            }

            .header p {
                font-size: 10px;
                margin: 0;
            }

            h3 {
                text-align: center;
                font-size: 16px;
                margin: 5px 0 10px 0;
            }

            .info-section,
            .section {
                margin-top: 10px;
                font-size: 12px;
            }

            .table-info {
                width: 100%;
                border-collapse: collapse;
                margin-top: 5px;
            }

            .table-info th,
            .table-info td {
                padding: 4px;
                font-size: 11px;
                text-align: left;
                border: 1px solid black;
                vertical-align: top;
            }

            .section-title {
                font-weight: bold;
                margin-top: 15px;
                font-size: 14px;
            }

            .content {
                margin-top: 5px;
                font-size: 12px;
                line-height: 1.5;
            }
        </style>
    </head>

    <body>
        <div class="container">
            <div class="header">
                <div class="logo-left">
                    {{-- <img src="{{ public_path('images/logo/kabupaten.png') }}" alt="Logo 1"> --}}
                </div>
                <div class="header-text">
                    <h1>PEMERINTAH KABUPATEN BIAK KOTA</h1>
                    <h2>PUSKESMAS BIAK KOTA</h2>
                    <p>Alamat: Jl. Jend. Sudirman Biak-Papua Kode Pos 98115, Email: pkmbiakkota581@gmail.com</p>
                </div>
                <div class="logo-right">
                    {{-- <img src="{{ public_path('images/logo/puskesmas.png') }}" alt="Logo 2"> --}}
                </div>
            </div>
            <h3>HASIL PEMERIKSAAN</h3>

            <table class="table-info">
                <tr>
                    <th colspan="3">Nomor Rekam Medis: {{ $dataRekamMedisDetail->no_rekam_medis }}</th>
                </tr>
                <tr>
                    <td>Nama Pasien: {{ $dataRekamMedisDetail->nama_pasien }}</td>
                    <td>Tanggal Lahir: {{ $tanggalLahir }}</td>
                    <td>Umur: {{ $umur }} Tahun</td>
                </tr>
                <tr>
                    <td colspan="2">Jenis Kelamin: {{ $jk }}</td>
                    <td>Tanggal Pemeriksaan: {{ $tanggal }}</td>
                </tr>
            </table>

            <div class="info-section">
                <div class="section-title">I. ANAMNESA</div>
                <p>Keluhan: {{ $dataRekamMedisDetail->keluhan }}</p>
                <p>Riwayat Penyakit: {{ $dataRekamMedisDetail->riwayat_penyakit }}</p>
                <p>Keterangan: {{ $dataRekamMedisDetail->keterangan }}</p>
            </div>

            <div class="info-section">
                <div class="section-title">II. PEMERIKSAAN FISIK</div>
                <p>Keadaan Umum: {{ $dataRekamMedisDetail->keadaan_umum }}</p>
                <p>Tekanan Darah: {{ $dataRekamMedisDetail->tekanan_darah }} mmHg</p>
                <p>Suhu: {{ $dataRekamMedisDetail->suhu }}°C</p>
                <p>Nadi: {{ $dataRekamMedisDetail->nadi }} x/mnt</p>
                <p>Berat Badan: {{ $dataRekamMedisDetail->berat_badan }} kg</p>
            </div>
            <div class="info-section">
                <div class="section-title">III. DIAGNOSIS</div>
                <p>Diagnosis: {{ $dataRekamMedisDetail->nama_penyakit }}</p>
            </div>
            <div class="info-section">
                <div class="section-title">IV. TINDAKAN</div>
                <p>Tindakan: {{ $dataRekamMedisDetail->tindakan }}</p>
            </div>
        </div>
    </body>

</html>
