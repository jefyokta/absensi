@extends('pages.layouts.general')

@section('content')
    <div class="flex justify-center items-center w-full h-screen">
        <div class="flex flex-col jusitify-center items-center">
            <img src="/images/ll.png" style="width: 400px;height:350px" alt="">
            <h1 class="text-4xl text-white font-semibold">Sistem Presensi Karyawan</h1>
            @if (auth()->user())
                <a href="/dashboard"
                    class="border p-2.5 rounded-md px-10 text-white hover:bg-white hover:text-slate-900 my-5">
                    Dashboard
                </a>
            @else
                <a href="/login" class="border p-2.5 rounded-md px-10 text-white hover:bg-white hover:text-slate-900 my-5">
                    Login
                </a>
            @endif
        </div>
    </div>
@endsection
