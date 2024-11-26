<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Laporan 10 Penyakit ICD</title>
        <style>
            body {
                font-family: Arial, sans-serif;
                margin: 20px;
            }

            table {
                width: 100%;
                border-collapse: collapse;
                margin-top: 20px;
            }

            th,
            td {
                border: 1px solid #ddd;
                padding: 8px;
                text-align: left;
            }

            th {
                background-color: #f2f2f2;
            }

            h1 {
                text-align: center;
            }
        </style>
    </head>

    <body>
        <h1>Laporan 10 Penyakit ICD Paling Sering</h1>
        <p>Bulan: {{ \Carbon\Carbon::createFromDate(null, $bulan, 1)->format('F') }}</p>
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Kode ICD</th>
                    <th>Nama Penyakit</th>
                    <th>Jumlah Kasus</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $index => $item)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $item->kode_icd }}</td>
                        <td>{{ $item->nama_penyakit }}</td>
                        <td>{{ $item->jumlah_penyakit }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </body>

</html>
