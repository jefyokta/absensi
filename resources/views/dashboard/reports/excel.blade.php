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
    <h2>Laporan Absensi Bulanan @if ($subdivision)
            {{ $subdivision->name }}
        @endif
    </h2>
    <p style="text-align: center;">{{ Carbon\Carbon::create()->month($month)->translatedFormat('F') }}
        {{ $year }}</p>

    @php
        $i = 1;
    @endphp
    @include('dashboard.reports.table')
</body>

</html>
