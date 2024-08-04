@extends('dashboard.layouts.main')

@section('container')
    <div class="row mb-3">
        <div class="col-6">
            <div class="card">
                <h5 class="font-semibold m-5 text-xl"> Tambah Sub Divisi</h5>
                <div class="card-body mx-2">
                    <form action="/dashboard/sub_division" method="POST" class="glass p-5 max-w-content">
                        @csrf
                        <div class="mb-5 ">
                            <label for="name" class="form-label mb-2.5 block">Nama Sub Divisi</label>
                            <input type="name"@required(true) class="form-control p-2 w-8/12" id="name"
                                name="name" placeholder="CEO" autofocus required>
                        </div>
                        <div class="mb-5">
                            <select id="countries"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 w-8/12"
                                name="division_id">
                                <option selected>Pilih Divisi</option>

                                @foreach ($divisions as $item)
                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                @endforeach

                            </select>
                        </div>
                        <button class="bg-blue-500 p-2 text-sm rounded-md text-white" type="submit">Tambah</button>
                </div>
                </form>
            </div>
        </div>


    </div>
@endsection
