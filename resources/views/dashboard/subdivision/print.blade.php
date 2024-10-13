<!DOCTYPE html>
<html>

<head>

    <title>employess</title>
    <style>
        body {
            margin: 0;
        }

        table {
            page-break-inside: auto;
        }

        tr {
            page-break-inside: avoid;
            page-break-after: auto;
        }

        h1 {
            margin-top: 0;
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
    @php
        $path = storage_path('app/cop.jpeg');
        $type = pathinfo($path, PATHINFO_EXTENSION);
        $data = file_get_contents($path);
        $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
    @endphp

    <img src="{{ $base64 }}" alt="" style="width: 60%;margin-bottom: 50px;z-index:-1;">
    <h1 style="text-align: center">Karyawan {{ $subdivision }}</h1>

    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
        <thead class="text-xs text-gray-700 uppercase bg-gray-100 dark:bg-gray-700 dark:text-gray-400">
            <tr>
                <th scope="col" class="px-6 py-3 rounded-ss-lg">
                    NO</th>
                <th scope="col" class="px-6 py-3 ">QRCODE</th>
                <th scope="col" class="px-6 py-3 ">NIK</th>
                <th scope="col" class="px-6 py-3 ">NAMA</th>
                <th scope="col" class="px-6 py-3 ">DIVISI</th>
                <th scope="col" class="px-6 py-3 ">ALAMAT</th>
                <th scope="col" class="px-6 py-3 ">NOMOR TELEPON</th>
                <th scope="col" class="px-6 py-3 ">JABATAN</th>
            </tr>
        </thead>
        <tbody class="glass rounded-es-lg">
            @php
                $i = 1;
            @endphp
            @foreach ($users as $user)
                <tr class="dark:bg-gray-800 rounded-lg">
                    <td class="px-6 py-4 ">{{ $i++ }}</th>
                        @php
                            $path = storage_path("app/qrcodes/$user->qrcode");
                            $type = pathinfo($path, PATHINFO_EXTENSION);
                            $data = file_get_contents($path);
                            $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
                        @endphp
                    <td class="px-6 py-4 ">
                        <img src="{{ $base64 }}" alt="" width="32" height="32"
                            style="margin-left:25%;margin-top:auto"></th>
                    <td class="px-6 py-4 ">{{ $user->nik }}</th>
                    <td class="px-6 py-4 ">{{ $user->name }}</th>

                    <td class="px-6 py-4 ">{{ $user->division->name }}</th>
                    <td class="px-6 py-4 ">{{ $user->address }}</td>
                    <td class="px-6 py-4 ">{{ $user->phonenumber }}</td>
                    <td class="px-6 py-4 ">{{ $user->role ?? '-' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    @include('dashboard.reports.footer')

</body>

</html>
