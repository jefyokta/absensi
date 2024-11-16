@extends('dashboard.layouts.main')

@section('container')
    <div
        class="d-flex justify-content-between flex-wrap mb-5 flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="text-2xl font-semibold">Tambah Admin
            {{ auth()->user()->divisions_id ? auth()->user()->division->name : '' }}</h1>
    </div>
    @livewire('form-add-admin')
@endsection
