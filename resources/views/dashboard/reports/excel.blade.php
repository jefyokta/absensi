<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Absensi Bulanan</title>
    <style>
        body {
            font-family: Arial, sans-serif;

        }

        h2 {
            text-align: center;
            margin-bottom: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            font-size: 8px;
        }

        th,
        td {
            border: 1px solid #000;
            text-align: center;
            padding: 5px;
        }

        th {
            background-color: #f2f2f2;
        }

        .header-row {
            background-color: #ffe5b4;
        }

        .sub-header {
            background-color: #d3eafd;
        }
    </style>
</head>

<body>
    <h2>Laporan Absensi Bulanan</h2>
    <p style="text-align: center;">Bulan: {{ $month }} - Tahun: {{ $year }}</p>

    <table>
        <thead>
            <tr class="header-row">
                <th rowspan="2">Nik</th>
                <th rowspan="2">Nama</th>
                <th rowspan="2">Jabatan</th>
                @foreach ($dates as $date)
                    <th colspan="2">{{ $date->day }}</th>
                @endforeach
            </tr>
            <tr class="sub-header">
                @foreach ($dates as $date)
                    <th>D</th>
                    <th>P</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @foreach ($employees as $employee)
                <tr>
                    <td>{{ $employee->nik }}</td>
                    <td>{{ $employee->name }}</td>
                    <td>{{ $employee->role ?? '-' }}</td>

                    @foreach ($dates as $date)
                        @php
                            $absen = $employee->absensis->first(function ($absensi) use ($date) {
                                return $absensi->date === $date->format('j/n/Y');
                            });
                        @endphp
                        <td>{{ $absen ? $absen->in : '-' }}</td>
                        <td>{{ $absen ? $absen->out : '-' }}</td>
                    @endforeach
                </tr>
            @endforeach
        </tbody>


    </table>
</body>

</html>
