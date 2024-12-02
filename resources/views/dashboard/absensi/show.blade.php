@extends('dashboard.layouts.main')

@section('container')
    @if (session()->has('success'))
        <div class="alert alert-success" role="alert">
            {{ session('success') }}
        </div>
    @endif

    <div class="row">
        <div class="col-6">
            <div class="card glass p-5">
                <div class="card-body  p-16 flex justify-center flex-col items-center">
                    <div class="glass p-10 rounded-lg h-max flex flex-col justify-around">

                        <h5 class="card-header font-semibold text-2xl "><i class="fa-solid fa-circle-info"></i> Detail
                            Absensi</h5>

                        <div class="card-text">

                            <table cellpadding="5px">
                                <tr>
                                    <td> <b>Nama </b></td>
                                    <td>:</td>
                                    <td> {{ $absensi->user->name }} </td>
                                </tr>
                                <tr>
                                    <td> <b>Divisi </b></td>
                                    <td>:</td>
                                    <td> {{ $absensi->division->name ?? '-' }} </td>
                                </tr>
                                <tr>
                                    <td> <b>Tanggal </b></td>
                                    <td>:</td>
                                    <td> {{ $absensi->date }}</td>
                                </tr>
                                <tr>
                                    <td> <b>Jam Masuk </b> </td>
                                    <td>:</td>
                                    <td> {{ $absensi->in }}</td>
                                </tr>
                                <tr>
                                    <td>
                                        <b>Jam Keluar </b>
                                    </td>
                                    <td>:</td>
                                    <td> {{ $absensi->out ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <td> <b>Status </b></td>
                                    <td>:</td>
                                    <td>
                                        {{ $absensi->status ? 'Hadir' : 'Tidak Hadir' }}
                                    </td>
                                </tr>
                            </table>




                            @if (!is_null($absensi->status) && !$absensi->status)
                                <div class="mt-10">

                                    <b>Bukti :</b> <button
                                        class="badge p-1 text-white bg-blue-500  text-xs rounded bg-dark border-0 text-decoration-none"
                                        data-image-src="{{ asset('storage/' . $absensi->image) }}">Lihat Bukti</button><br>
                                    <b>Alasan :</b> {{ $absensi->reason ?? '-' }}
                                    @if (!is_null($absensi->image))
                                        <div class="col-6 my-5">
                                            <div class="card">
                                                <h5 class="card-header">Detail Bukti Sakit
                                                </h5>
                                                <a href="/bukti?q={{ $absensi->image }}" target="_blank">


                                                    <div class="w-96 rounded-lg overflow-hidden">
                                                        <img id="proofImage" src="/bukti?q={{ $absensi->image }}"
                                                            alt="Bukti">
                                                    </div>
                                                </a>
                                            </div>
                                        </div>
                                    @else
                                        <div class="col-6">
                                            <div class="card">
                                                <h5 class="card-header"><i class="fa-solid fa-image"></i>Tidak Melampirkan
                                                    Bukti
                                                </h5>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            @endif

                        </div>
                    </div>
                </div>
                <div class="flex justify-end">
                    <div class="my-5">
                        <a href="/dashboard" class="bg-blue-500 p-2 rounded-md text-sm text-white">Kembali</a>
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
