@extends('dashboard.layouts.main')

@section('container')
    <div
        class="glass rounded-lg p-5 max-h-content flex justify-between items-center flex-wrap flex-md-nowrap  pt-3 pb-2 mb-3 border-bottom">
        <h1 class="font-semibold p-2 text-xl">Data Karyawans</h1>
    </div>

@include('superadmin.components.employees')
@endsection
