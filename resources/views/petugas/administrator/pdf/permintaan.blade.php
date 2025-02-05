<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Resume Medis</title>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">

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

            /* .info-section,
            .section {
                margin-top: 10px;
                font-size: 20px;
            } */

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
            <h3>PERMINTAAN PEMERIKSAAN LABOTORIUM</h3>
            <div class="info-section" style="border: 1px solid black; padding: 10px; margin-bottom: 20px;">
                <div>Nama Pasien : {{ $pemeriksaan->nama_pasien }}</div>
                <div>Tanggal Lahir :
                    {{ \Carbon\Carbon::parse($pemeriksaan->tanggal_lahir_pasien)->translatedFormat('d F Y') }}</div>
                <div>Jenis Kelamin : {{ $pemeriksaan->jk_pasien == 'L' ? 'Laki-laki' : 'Perempuan' }}</div>
                <div>Nomor RM : {{ $pemeriksaan->no_rekam_medis }}</div>
                <div>Dokter : {{ $pemeriksaan->nama_petugas }}</div>
                <div>Diagnosa : {{ isset($icd) ? $icd->nama_penyakit : '-' }}</div>
            </div>

            <div class="info-section">
                <div class="">Kode Lab :</div>
                <b>{{ $lab->kode_lab }}</b>
            </div>
        </div>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    </body>

</html>
