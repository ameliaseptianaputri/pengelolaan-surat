@extends('layouts.template')

@section('content')
    <form action="{{ route('user.store') }}" method="post" class="card p-5">
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
                    <option value="admin">Staff</option>
                    <option value="cashier">Guru</option>
                </select>
            </div>
        </div>
        <div class="mb-3 row">
            <button type="submit" class="btn btn-primary">Simpan</button>
        </div>
    </form>
@endsection