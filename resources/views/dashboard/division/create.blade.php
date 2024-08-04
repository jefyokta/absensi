@extends('dashboard.layouts.main')

@section('container')
    <div class="row mb-3">
        <div class="col-6">
            <div class="card">
                <h5 class="font-semibold m-5 text-xl"> Tambah Divisi</h5>
                <div class="card-body mx-2">
                    <form action="/dashboard/divisions" method="POST" class="glass p-5 max-w-content">
                        @csrf
                        <div class="mb-5 ">
                            <label for="name" class="form-label mb-2.5 block">Nama Divisi</label>
                            <input type="name"@required(true) class="form-control p-2 w-8/12" id="name" name="name"
                                placeholder="CEO" autofocus required>
                        </div>
                        <button class="bg-blue-500 p-2 text-sm rounded-md text-white" type="submit">Tambah</button>
                </div>
                </form>
            </div>
        </div>


    </div>
@endsection
