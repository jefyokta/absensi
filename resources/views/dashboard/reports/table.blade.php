<table>
    <thead>
        <tr class="header-row">
            <th rowspan="2">No</th>

            <th rowspan="2">Nik</th>
            <th rowspan="2">Nama</th>
            <th rowspan="2">Jabatan</th>
            <th rowspan="2">Jam Kerja</th>

            @foreach ($dates as $date)
                <th colspan="2">{{ $date->day }}</th>
            @endforeach
            <th rowspan="2">Total(Jam)</th>

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
                <td>{{ $i++ }}</td>
                <td>{{ $employee->nik }}</td>
                <td>{{ $employee->name }}</td>
                <td>{{ $employee->role ?? '-' }}</td>
                <td>{{ 8 }}</td>

                @php
                    $total = 0;
                @endphp
                @foreach ($dates as $date)
                    @php
                        $absen = $employee->absensis->first(function ($absensi) use ($date) {
                            return $absensi->date === $date->format('d/m/Y');
                        });
                        if ($absen) {
                            if ($absen->in && $absen->out) {
                                $t1 = strtotime($absen->in);
                                $t2 = strtotime($absen->out);
                                $time = ($t2 - $t1) / 60 / 60 > 8 ? 8 : ($t2 - $t1) / 60 / 60;
                                $total += $time;
                            } elseif ($absen->in && !$absen->out) {
                                $total += 4;
                            }
                        }
                    @endphp
                    <td>{{ $absen ? $absen->in : '-' }}</td>
                    <td>{{ $absen ? $absen->out : '-' }}</td>
                @endforeach
                <td>{{ floor($total * 100) / 100 }}</td>
            </tr>
        @endforeach
    </tbody>


</table>
