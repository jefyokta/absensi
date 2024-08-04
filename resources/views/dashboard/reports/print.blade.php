<!DOCTYPE html>
<html>

<head>
    @php
        use App\Services\DateID;
        $end = false;
        $start = false;
        if ($s && $e) {
            $end = explode('/', $e);
            if (count($end) < 3) {
                $end = false;
            }
            $start = explode('/', $s);
            if (count($start) < 3) {
                $start = false;
            }
        }
    @endphp
    <title>Absensi</title>
    <style>
        body {
            font-family: sans-serif;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th,
        td {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }

        th {
            background-color: #f2f2f2;
        }

        .text-danger {
            color: red;
        }

        .dark-bg {
            background-color: #444444;
            color: #ffffff;
        }

        .rounded-ss-lg {
            border-top-left-radius: 10px;
        }

        .rounded-se-lg {
            border-top-right-radius: 10px;
        }

        .rounded-es-lg {
            border-bottom-left-radius: 10px;
        }

        .rounded-ee-lg {
            border-bottom-right-radius: 10px;
        }
    </style>
</head>

<body>
    <h1 style="text-align: center">Absensi</h1>
    <p class="text-xs" style="text-align: center">
        {{ $end && $start ? $start[0] . ' ' . DateID::getmonth($start[1]) . ' ' . $end[2] . ' - ' . $end[0] . ' ' . DateID::getmonth($end[1]) . ' ' . $end[2] : '' }}
    </p>
    <table>
        <thead>
            <tr>
                <th scope="col" class="rounded-ss-lg">ID</th>
                <th scope="col">NAMA</th>
                <th scope="col">DIVISI</th>
                <th scope="col">TANGGAL</th>
                <th scope="col">MASUK</th>
                <th scope="col">KELUAR</th>
                <th scope="col" class="rounded-se-lg">STATUS</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($absensis as $absensi)
                <tr class="{{ $loop->even ? '' : '' }}">
                    <td>{{ $absensi->id }}</td>
                    <td>{{ $absensi->user->name }}</td>
                    <td>
                        @if ($absensi->user->division)
                            {{ $absensi->user->division->name }}
                        @else
                            <p class="text-danger"><i class="fa-solid fa-triangle-exclamation"></i> -</p>
                        @endif
                    </td>
                    <td>{{ $absensi->date }}</td>
                    <td>{{ $absensi->in }}</td>
                    <td>{{ $absensi->out ?? '-' }}</td>
                    <td>{{ $absensi->status ? 'hadir' : 'tidak hadir' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
