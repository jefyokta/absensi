@extends('dashboard.layouts.main')
@section('container')
<div class="my-3">
    <h1 class="text-slate-700 font-bold text-3xl text-center my-10">Presensi {{ auth()->user()->name }}</h1>
</div>
<div class="">
    <div class="col-6">
        <div class="card mb-3">

            <h5 class="card-header p-3 text-slate-600 font-semibold">Daftar Kehadiran</h5>
            <div class="w-full">
                {{ $absensis->links() }}
                <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-100 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-6 py-3 rounded-ss-lg">
                                No</th>
                            <th scope="col" class="px-6 py-3">TANGGAL</th>
                            <th scope="col" class="px-6 py-3">JAM MASUK</th>
                            <th scope="col" class="px-6 py-3">JAM Keluar</th>
                            <th scope="col" class="px-6 py-3">STATUS</th>
                            <th scope="col" class="px-6 py-3 rounded-se-lg">
                                AKSI</th>
                        </tr>
                    </thead>
                    <tbody class="glass rounded-es-lg">
                        @php
                            $i =1;
                        @endphp
                        @foreach ($absensis as $absensi)
                            <tr class="dark:bg-gray-800 rounded-lg">
                                <td class="px-6 py-4 ">{{ $i++ }}</td>
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
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>


</div>

@endsection
