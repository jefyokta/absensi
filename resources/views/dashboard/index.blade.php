@extends('dashboard.layouts.main')

@section('container')
    <div class="flex justify-between flex-wrap px-10 rounded-lg pt-3 pb-2 mb-3 glass">
        <h1 class="h2 font-semibold">Halo, {{ auth()->user()->name }}</h1>
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center">
            @php
                use App\Services\DateID;
                $day = DateID::getDay(date('l'));
                $month = DateID::getMonth(date('m'));
            @endphp
            <h4>{{ $day . date(', d ') . $month . date(' Y') }}</h4>
        </div>
    </div>

    @if (auth()->user()->is_admin)
        <div class="my-3">
            <h1 class="text-slate-700 font-bold text-3xl text-center my-10">Presensi Hari ini
                {{ auth()->user()->division ? ' : ' . auth()->user()->division->name : '' }}</h1>
        </div>
        <div class="">
            <div class="col-6">
                <div class="card mb-3">

                    <h5 class="card-header p-3 text-slate-600 font-semibold">Daftar Kehadiran</h5>
                    <div class="w-full">
                        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-100 dark:bg-gray-700 dark:text-gray-400">
                                <tr>
                                    <th scope="col" class="px-6 py-3 rounded-ss-lg">
                                        ID</th>
                                    <th scope="col" class="px-6 py-3">NAMA</th>
                                    @if (!auth()->user()->divisions_id)
                                        <th scope="col" class="px-6 py-3">
                                            UNIT
                                        </th>
                                    @endif

                                    <th scope="col" class="px-6 py-3">TANGGAL</th>
                                    <th scope="col" class="px-6 py-3">JAM MASUK</th>
                                    <th scope="col" class="px-6 py-3">JAM Keluar</th>
                                    <th scope="col" class="px-6 py-3">STATUS</th>
                                    <th scope="col" class="px-6 py-3 rounded-se-lg">
                                        AKSI</th>
                                </tr>
                            </thead>
                            <tbody class="glass rounded-es-lg">
                                @foreach ($absensis as $absensi)
                                    @if (auth()->user()->divisions_id)
                                        @if ($absensi->user->divisions_id === auth()->user()->divisions_id)
                                            <tr class="dark:bg-gray-800 rounded-lg">
                                                <td class="px-6 py-4 ">{{ $absensi->id }}</td>
                                                <td class="px-6 py-4 "><a
                                                        href="/dashboard/employees/{{ $absensi->user->id }}"
                                                        class="text-blue-700">{{ $absensi->user->name }}</a> </td>
                                                <td class="px-6 py-4 ">{{ $absensi->date }}</td>
                                                <td class="px-6 py-4 ">{{ $absensi->in }}</td>
                                                <td class="px-6 py-4 ">{{ $absensi->out }}</td>
                                                @if ($absensi->status)
                                                    <td class="px-6 py-4 text-green-500">Hadir</td>
                                                @else
                                                    <td class="px-6 py-4 text-red-500">Tidak Hadir</td>
                                                @endif
                                                <td class="px-6 py-4 "><a href="/dashboard/absensi/{{ $absensi->id }}"
                                                        class="badge bg-dark border-0"> <svg
                                                            class="w-6 h-6 text-blue-800 dark:text-white" aria-hidden="true"
                                                            xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                            fill="none" viewBox="0 0 24 24">
                                                            <path stroke="currentColor" stroke-width="2"
                                                                d="M21 12c0 1.2-4.03 6-9 6s-9-4.8-9-6c0-1.2 4.03-6 9-6s9 4.8 9 6Z" />
                                                            <path stroke="currentColor" stroke-width="2"
                                                                d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                                        </svg>Lihat
                                                    </a></td>
                                            </tr>
                                        @endif
                                    @else
                                        <tr class="dark:bg-gray-800 rounded-lg">
                                            <td class="px-6 py-4 ">{{ $absensi->id }}</td>
                                            <td class="px-6 py-4 "><a href="/dashboard/employees/{{ $absensi->user->id }}"
                                                    class="text-blue-700">{{ $absensi->user->name }}</a> </td>
                                            <td class="px-6 py-4 ">{{ $absensi->user->division->name ?? '-' }}</td>
                                            <td class="px-6 py-4 ">{{ $absensi->date }}</td>

                                            <td class="px-6 py-4 ">{{ $absensi->in }}</td>
                                            <td class="px-6 py-4 ">{{ $absensi->out }}</td>
                                            @if ($absensi->status)
                                                <td class="px-6 py-4 text-green-500">Hadir</td>
                                            @else
                                                <td class="px-6 py-4 text-red-500">Tidak Hadir</td>
                                            @endif
                                            <td class="px-6 py-4 "><a href="/dashboard/absensi/{{ $absensi->id }}"
                                                    class="badge bg-dark border-0"> <svg
                                                        class="w-6 h-6 text-blue-800 dark:text-white" aria-hidden="true"
                                                        xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                        fill="none" viewBox="0 0 24 24">
                                                        <path stroke="currentColor" stroke-width="2"
                                                            d="M21 12c0 1.2-4.03 6-9 6s-9-4.8-9-6c0-1.2 4.03-6 9-6s9 4.8 9 6Z" />
                                                        <path stroke="currentColor" stroke-width="2"
                                                            d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                                    </svg>Lihat
                                                </a></td>
                                        </tr>
                                    @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>


        </div>
    @else
        <div class="row">
            <div class="col-6">
                <div class="card mb-3">
                    <h5 class="card-header p-3"><i class="fa-solid fa-circle-info"></i> Status absensi hari ini!</h5>
                    <div class="card-body">
                        <p>

                            @if (empty($absensi_by_name))
                                <a href="/dashboard/absensi" class="text-decoration-none text-danger fw-bold">
                                    <p><i class="fa-solid fa-triangle-exclamation"></i> Kamu belum mengambil absensi hari
                                        ini! <i class="fa-solid fa-triangle-exclamation"></i></p>
                                </a>
                            @elseif ($absensi_by_name->status == 0)
                                <div class="flex items-center p-4 mb-4 text-sm text-blue-800 rounded-lg bg-blue-50 dark:bg-gray-800 dark:text-blue-400"
                                    role="alert">
                                    <svg class="flex-shrink-0 inline w-4 h-4 me-3" aria-hidden="true"
                                        xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                        <path
                                            d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z" />
                                    </svg>
                                    <span class="sr-only">Info</span>
                                    <div>
                                        <span class="font-medium">Semoga Kamu Segera Kembali!</span> We miss u :(
                                    </div>
                                </div>
                            @elseif(!empty($absensi_by_name->out) && !empty($absensi_by_name->in))
                                <div class="flex items-center p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400"
                                    role="alert">
                                    <svg class="flex-shrink-0 inline w-4 h-4 me-3" aria-hidden="true"
                                        xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                        <path
                                            d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z" />
                                    </svg>
                                    <span class="sr-only">Info</span>
                                    <div>
                                        <span class="font-medium">Mantap!</span> Waktunya Pulang, Kembali lagi Besok ya !
                                    </div>
                                </div>
                            @elseif(empty($absensi_by_name->out) && !empty($absensi_by_name->in))
                                <div class="flex items-center p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400"
                                    role="alert">
                                    <svg class="flex-shrink-0 inline w-4 h-4 me-3" aria-hidden="true"
                                        xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                        <path
                                            d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z" />
                                    </svg>
                                    <span class="sr-only">Info</span>
                                    <div>
                                        <span class="font-medium">Semangat!</span> Jangan Lupa nanti Absen Pulang ya !
                                    </div>
                                </div>
                            @endif
                        </p>
                    </div>
                </div>
            </div>

        </div>
    @endif
@endsection
