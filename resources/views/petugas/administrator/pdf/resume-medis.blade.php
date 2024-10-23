<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Resume Medis</title>
        <style>
            body {
                font-family: Arial, sans-serif;
                height: 100vh;
                display: flex;
                justify-content: center;
                align-items: center;
                background-color: #f4f4f4;
                margin: 0;
            }

            .container {
                background-color: white;
                padding: 20px;
                border: 1px solid black;
                box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
                width: 80%;
                max-width: 800px;
                box-sizing: border-box;
                overflow-y: auto;
            }

            .header {
                text-align: center;
                padding-bottom: 10px;
                position: relative;
            }

            .header img.logo-left {
                width: 80px;
                position: absolute;
                left: 0;
                top: 0;
            }

            .header img.logo-right {
                width: 80px;
                position: absolute;
                right: 0;
                top: 0;
            }

            .header h1 {
                margin: 0;
                font-size: 20px;
            }

            .header h2 {
                margin: 0;
                font-size: 18px;
                font-weight: bold;
            }

            .header p {
                margin-top: 5px;
                font-size: 12px;
            }

            .header hr {
                border: none;
                border-top: 2px solid black;
                margin: 40px 0 10px 0;
            }

            .tes {
                margin-top: 5px;
                padding: 10px;
                line-height: 1.4;
                /* border: 1px solid black; */
            }

            h3 {
                font-size: 24px;
                text-align: center;
                margin-top: 20px;
            }

            .table-info {
                width: 100%;
                border-collapse: collapse;
                margin-top: 10px;
            }

            .table-info td,
            .table-info th {
                font-weight: normal;
                border: 1px solid black;
                padding: 12px;
                font-size: 14px;
            }

            .table-info th {
                text-align: left;
            }

            .section-title {
                font-weight: bold;
                margin-bottom: 10px;
            }

            .section {
                margin-top: 5px;
            }
        </style>
    </head>

    <body>
        <div class="container">
            <div class="header">
                <img src="{{ asset('images/logo/kabupaten.png') }}" alt="Logo 1" class="logo-left">
                <img src="{{ asset('images/logo/puskesmas.png') }}" alt="Logo 2" class="logo-right">
                <h1 style="font-weight: normal;">PEMERINTAH KABUPATEN BIAK KOTA</h1>
                <h2>PUSKESMAS BIAK KOTA</h2>
                <p>Alamat : Jl. Jend. Sudirman Biak-Papua Kode Pos 98115 Email :pkmbiakkota581@gmail.com</p>
                <hr>
            </div>

            <table class="table-info">
                <tr>
                    <th colspan="6">
                        <h1>HASIL PEMERIKSAAN</h1>
                    </th>
                    <th colspan="2"><b>Nomor Rekam Medis :</b> {{ $dataRekamMedisDetail->no_rekam_medis }}</th>
                </tr>
                <tr>
                    <th><b>Nama Pasien :</b> {{ $dataRekamMedisDetail->nama_pasien }}</th>
                    <th colspan="4"><b>Tanggal Lahir :</b> {{ $dataRekamMedisDetail->tanggal_lahir_pasien }}</th>
                    <th><b>Umur :</b> {{ $umur }}</th>
                    <th colspan="2"><b>Jenis Kelamin :</b> {{ $jk }}</th>
                </tr>
                <tr>
                    <th><b>Tanggal Pemeriksaan :</b> {{ $dataRekamMedisDetail->tanggal_pemeriksaan }}
                    </th>
                </tr>
            </table>
            <div class="tes">
                <div class="section-title"><b>I. ANAMNESA</b></div>
                <div class="section">Keluhan : {{ $dataRekamMedisDetail->keluhan }}</div>
                <div class="section">Riwayat Penyakit : {{ $dataRekamMedisDetail->riwayat_penyakit }}</div>
                <div class="section">Keterangan : {{ $dataRekamMedisDetail->keterangan }}</div>
            </div>
            <div class="tes">
                <div class="section-title"><b>II. PEMERIKSAAN FISIK</b></div>
                <div class="section">Keadaan Umum : {{ $dataRekamMedisDetail->keadaan_umum }}</div>
                <div class="section">Tekanan Darah : {{ $dataRekamMedisDetail->tekanan_darah }} mmHg</div>
                <div class="section">Suhu : {{ $dataRekamMedisDetail->suhu }}°C</div>
                <div class="section">Nadi : {{ $dataRekamMedisDetail->nadi }} x/mnt</div>
                <div class="section">Berat Badan : {{ $dataRekamMedisDetail->berat_badan }}</div>
            </div>
            <div class="tes">
                <div class="section-title"><b>III. DIAGNOSIS</b></div>
                <div class="section">Diagnosis : {{ $diagnosis->nama_penyakit }}</div>
                {{-- <div class="section">Tindakan : {{ $dataRekamMedisDetail->tindakan }}</div>
                <div class="section">Obat : {{ $dataRekamMedisDetail->obat }}</div> --}}
            </div>
        </div>
    </body>

</html>
