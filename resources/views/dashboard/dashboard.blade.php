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
        <div class="flex items-center justify-center h-screen w-full flex-col">
            <div class="flex flex-wrap px-10 rounded-lg pt-3 pb-2 mb-3 justify-center w-full glass">
                <h1 class="h2 font-semibold text-center text-xl p-2.5"> Selamat Datang {{ auth()->user()->is_admin ? "Administrator ": "Karyawan" }}  di Aplikasi Presensi Karyawan PT Abdi Budi Mulia</h1>

            </div>
            <div class="glass w-full flex justify-center flex-col items-center p-5">

                <img src="/images/logoo.png" alt="" class="h-72 w-72">
                <div class="px-2.5 text-center mb-24">
                    PT. Abdi Budi Mulia (ABM) merupakan perusahaan perkebunan swasta nasional yang bergerak di bidang kelapa sawit dan telah berdiri sejak tahun 1988. ABM berkomitmen untuk menjadi perusahaan terkemuka dan berkelanjutan di sektor perkebunan kelapa sawit melalui keunggulan operasional. Dalam menjalankan usahanya, ABM memiliki misi untuk meningkatkan nilai bagi pemegang saham, mengembangkan kompetensi sumber daya manusia, meningkatkan kesejahteraan masyarakat di sekitar wilayah operasional, serta menjaga kepuasan pelanggan.                </div>

            </div>
        </div>
    @endsection
