@include('dashboard.reports.header')
    @php
        $path = storage_path('app/cop.jpeg');
        $type = pathinfo($path, PATHINFO_EXTENSION);
        $data = file_get_contents($path);
        $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
        $i = 1;
    @endphp

    <img src="{{ $base64 }}" alt="" style="width: 30%;margin-bottom: 50px;z-index:-1;">
    <h2>Laporan Absensi Bulanan</h2>
    <p style="text-align: center;">{{ Carbon\Carbon::create()->month($month)->translatedFormat('F') }}
        {{ $year }}</p>

    @if ($subdivision)
        <p style="text-align: center;">{{ $subdivision->name }}</p>
    @endif

    @include('dashboard.reports.table')

    <div class="" style="font-size: 8px;margin-top: 10px">
        <p>Keterangan:</p>
        <p>*D : Datang</p>
        <p>*P : Pulang</p>
    </div>
    @include('dashboard.reports.footer')
</body>

</html>
