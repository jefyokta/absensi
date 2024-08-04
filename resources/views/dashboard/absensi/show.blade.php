@extends('dashboard.layouts.main')

@section('container')
    @if (session()->has('success'))
        <div class="alert alert-success" role="alert">
            {{ session('success') }}
        </div>
    @endif

    <div class="row">
        <div class="col-6">
            <div class="card">
                <div class="card-body glass p-16 flex justify-center flex-col items-center">
                    <h5 class="card-header my-5 font-semibold text-2xl text-blue-700"><i class="fa-solid fa-circle-info"></i> Detail Absensi</h5>
                    <div class="card-text">
                        <b>Nama :</b> {{ $absensi->user->name }} <br>
                        <b>Divisi :</b> {{ $absensi->division->name ?? '-' }}<br>
                        <b>Tanggal :</b> {{ $absensi->date }}<br>
                        <b>Jam Masuk :</b> {{ $absensi->in }}<br>
                        <b>Jam Keluar :</b> {{ $absensi->out ?? '-'}}<br>
                        <b>Status :</b> {{ $absensi->status ? 'Hadir' : 'Tidak Hadir' }}<br>

                        @if (!is_null($absensi->status) && !$absensi->status)

                        <b>Bukti :</b> <button class="badge bg-dark border-0 text-decoration-none"
                            data-image-src="{{ asset('storage/' . $absensi->image) }}">Lihat Bukti</button><br>
                        <b>Alasan :</b> {{ $absensi->reason ?? '-' }}
                        @if (!is_null($absensi->image))
                            <div class="col-6 my-5">
                                <div class="card">
                                    <h5 class="card-header"><i class="fa-solid fa-image"></i> Detail Bukti Sakit</h5>
                                    <a href="/bukti?q={{ $absensi->image }}" target="_blank">


                                        <div class="w-96 rounded-lg overflow-hidden">
                                            <img id="proofImage" src="/bukti?q={{ $absensi->image }}" alt="Bukti">
                                        </div>
                                    </a>
                                </div>
                            </div>
                        @else
                            <div class="col-6">
                                <div class="card">
                                    <h5 class="card-header"><i class="fa-solid fa-image"></i>Tidak Melampirkan Bukti </h5>

                                </div>
                            </div>
                        @endif
                        @endif
                        <div class="my-5">
                            <a href="/dashboard" class="bg-blue-500 p-2 rounded-md text-sm text-white">Kembali</a>
                        </div>
                    </div>
                </div>
            </div>

        </div>



    </div>

    <script>
        document.addEventListener('DOMContentLoaded', (event) => {
            var badge = document.querySelector('.badge');
            var proofImage = document.getElementById('proofImage');

            if (badge && proofImage) {
                badge.addEventListener('click', function(event) {
                    event.preventDefault();
                    var imgSrc = this.getAttribute('data-image-src');

                    if (imgSrc) {
                        if (proofImage.style.display === 'none') {
                            proofImage.src = imgSrc;
                            proofImage.style.display = 'block';
                        } else {
                            proofImage.style.display = 'none';
                        }
                    } else {
                        console.log('URL gambar tidak valid');
                    }
                });
            } else {
                console.log('Elemen badge atau proofImage tidak ditemukan');
            }
        });
    </script>
@endsection
