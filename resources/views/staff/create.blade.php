@extends('layouts.template')

@section('content')
    <form action="{{ route('staff.store') }}" method="post" class="card p-5">
        @csrf

        @if (Session::get('success'))
            <div class="alert alert-success">{{ Session::get('success') }}</div>
        @endif
        @if ($errors->any())
            <ul class="alert alert-danger">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        @endif
        <div class="d-block justify-content-between flex-wrap flex-end-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
            <h1 class="h2">Tambah Data Staff Tata Usaha</h1>
            <div class="d-flex">
                <h6>Home / Data Staff Usaha /<b class="text-primary"> Tambah Data Staff Tata Usaha</b></h6>
            </div>
        </div>        
        <div class="mb-3 row">
            <label for="name" class="col-sm-2 col-form-label">Nama Pengguna :</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="name" name="name">
            </div>
        </div>
        <div class="mb-3 row">
            <label for="email" class="col-sm-2 col-form-label">Email Pengguna :</label>
            <div class="col-sm-10">
                <input type="email" class="form-control" id="email" name="email">
            </div>
        </div>
        <div class="mb-3 row">
            <label for="role" class="col-sm-2 col-form-label">Role Pengguna :</label>
            <div class="col-sm-10">
                <select name="role" id="role" class="form-select">
                    <option hidden disabled selected>Pilih</option>
                    <option value="staff">Staff</option>
                    <option value="guru">Guru</option>
                </select>
            </div>
        </div>
        <div class="mb-3 row">
            <button type="submit" class="btn btn-primary">Simpan</button>
        </div>
    </form>
@endsection