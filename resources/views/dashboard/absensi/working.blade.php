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
    
    <div
        class="p-4 my-20 mb-4 text-green-800 border border-green-500 rounded-lg glass dark:text-green-400 dark:border-green-800">
        <div class="flex items-center ">
            <svg class="flex-shrink-0 w-4 h-4 me-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                viewBox="0 0 20 20">
                <path
                    d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z" />
            </svg>
            <span class="sr-only">Info</span>
            <h3 class="text-lg font-medium">Halo Semangat Bekerja Ya!</h3>
        </div>
        <div class="mt-2 mb-4 text-sm">
            Jangan Lupa Absen Pulang !
        </div>

    </div>
    @include('dashboard.absensi.dashboard')

@endsection
