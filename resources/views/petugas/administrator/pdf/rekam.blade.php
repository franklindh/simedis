<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Rekam Medis</title>
        <style>
            body {
                font-family: Arial, sans-serif;
                font-size: 12px;
                margin: 0;
                padding: 0;
            }

            .header {
                text-align: center;
                font-size: 14px;
                font-weight: bold;
            }

            .container {
                padding: 10px;
                border: 1px solid black;
            }

            .section-title {
                margin-top: 10px;
                font-weight: bold;
                text-decoration: underline;
            }

            .data-table {
                width: 100%;
                border-collapse: collapse;
                margin-top: 10px;
            }

            .data-table th,
            .data-table td {
                border: 1px solid black;
                padding: 8px;
                text-align: left;
            }
        </style>
    </head>

    <body>
        <div class="header">
            <p>PEMERINTAH KABUPATEN BIAK NUMFOR<br>
                DINAS KESEHATAN<br>
                PUSKESMAS BIAK KOTA DISTRIK BIAK KOTA<br>
                JL.JEND. SUDIRMAN BIAK - PAPUA</p>
            <h3>REKAM MEDIS</h3>
            <p>PUSKESMAS BIAK KOTA</p>
        </div>

        <div class="container">
            <p><strong>No. Rekam Medis:</strong> {{ $pasienData->no_rm }}</p>
            <p><strong>Nama Pasien:</strong> {{ $pasienData->nama_pasien }}</p>
            {{-- <p><strong>Nama KK:</strong> {{ $pasienData->nama_kk }}</p> --}}
            <p><strong>TTL/Umur:</strong> {{ $pasienData->tanggal_lahir_pasien }} /
                {{ \Carbon\Carbon::parse($pasienData->tanggal_lahir_pasien)->age }} tahun</p>
            <p><strong>Jenis Kelamin:</strong>
                {{ $pasienData->jenis_kelamin_pasien == 'L' ? 'Laki-laki' : 'Perempuan' }}</p>
            {{-- <p><strong>Kelurahan/Kampung:</strong> {{ $pasienData->kelurahan }}</p> --}}
            <p><strong>Alamat:</strong> {{ $pasienData->alamat_pasien }}</p>
            {{-- <p><strong>No. Kartu Jaminan:</strong> {{ $pasienData->no_kartu_jaminan }}</p> --}}
            <p><strong>No. NIK:</strong> {{ $pasienData->nik }}</p>
        </div>

        {{-- <div class="section-title">Tahun Dirawat Terakhir:</div>
        <p>{{ $pasienData->tahun_dirawat_terakhir ?? '-' }}</p> --}}

        <div class="section-title">Perhatian:</div>
        <ol>
            <li>Tidak boleh dibawa / dikirimkan keluar Puskesmas Biak Kota (Kecuali kasus hukum).</li>
            <li>Harap disimpan di tempat yang ditentukan.</li>
            <li>Setelah selesai harap segera dikembalikan ke Bagian Rekam Medis dalam keadaan lengkap 2x24 jam.</li>
        </ol>
        <p style="text-align: center; margin-top: 20px;"><strong>RAHASIA MEDIS</strong></p>
    </body>

</html>
