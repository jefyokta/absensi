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
    <div class="w-full flex justify-center flex-col my-20 glass p-5">
        <h1
            class="mb-4 text-center text-5xl font-extrabold leading-none  text-green-700 md:text-5xl lg:text-6xl ">
           Terimakasih Untuk Hari ini</h1>
        <p class="mb-6 text-center text-lg font-normal text-gray-500 lg:text-xl sm:px-16 xl:px-48 dark:text-gray-400">Sampai Jumpa Di hari Kerja berikutnya
        </p>
    </div>
@endsection
