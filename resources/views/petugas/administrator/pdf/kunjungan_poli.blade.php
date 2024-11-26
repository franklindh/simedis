<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <title>{{ $title }}</title>
        <style>
            table {
                width: 100%;
                border-collapse: collapse;
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
        </style>
    </head>

    <body>
        <h1>{{ $title }}</h1>
        <p>Bulan: {{ \Carbon\Carbon::createFromDate(null, $bulan, 1)->format('F') }}</p>
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Poli</th>
                    <th>Jumlah Kunjungan</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $index => $item)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $item->nama_poli }}</td>
                        <td>{{ $item->jumlah_pasien }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </body>

</html>
