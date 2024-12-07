<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Hasil Pemeriksaan Laboratorium</title>
        <style>
            body {
                font-family: Arial, sans-serif;
                font-size: 12px;
            }

            .header {
                text-align: center;
                margin-bottom: 20px;
            }

            .header h1 {
                margin: 0;
                font-size: 16px;
            }

            .header p {
                margin: 0;
                font-size: 12px;
            }

            table {
                width: 100%;
                border-collapse: collapse;
                margin-bottom: 20px;
            }

            table th,
            table td {
                border: 1px solid #000;
                padding: 5px;
                text-align: left;
            }

            .footer {
                text-align: center;
                margin-top: 30px;
            }
        </style>
    </head>

    <body>
        <div class="header">

        </div>

        <h2>Hasil Pemeriksaan Laboratorium</h2>
        <p><strong>No. RM:</strong> {{ $pasien->no_rekam_medis }}</p>
        <p><strong>Nama:</strong> {{ $pasien->nama_pasien }}</p>
        {{-- <p><strong>Jenis Kelamin:</strong> {{ $pasien->jk_pasien }}</p> --}}
        <p><strong>Alamat:</strong> {{ $pasien->alamat_pasien }}</p>
        <p><strong>No. Lab:</strong> {{ $kode_lab }}</p>
        <p><strong>Tanggal Pemeriksaan:</strong> {{ $tanggal_pemeriksaan }}</p>
        {{-- <p><strong>Petugas:</strong> {{ $petugas }}</p> --}}
        {{-- <p><strong>Asal Klinik:</strong> {{ $asal_klinik }}</p> --}}

        @foreach ($groupedPemeriksaan as $jenis => $pemeriksaan)
            <h3>{{ $jenis }}</h3>
            <table>
                <thead>
                    <tr>
                        <th>Nama Pemeriksaan</th>
                        <th>Hasil</th>
                        <th>Satuan</th>
                        <th>Nilai Normal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($pemeriksaan as $item)
                        <tr>
                            <td>{{ $item->nama_pemeriksaan }}</td>
                            <td>{{ $item->hasil }}</td>
                            <td>{{ $item->satuan }}</td>
                            <td>{{ $item->nilai_rujukan }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endforeach

        {{-- <div class="footer">
            <p>Pemeriksa,</p>
            <p>______________________</p>
        </div> --}}
    </body>

</html>
