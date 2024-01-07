@extends('layouts.template')

@section('content')
    <form action="{{ route('klasifikasi.store') }}" method="post" class="card p-5">
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
            <label for="letter_code" class="col-sm-2 col-form-label">Kode Surat :</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="letter_code" name="letter_code">
            </div>
        </div>
        <div class="mb-3 row">
            <label for="name_type" class="col-sm-2 col-form-label">Klasifikasi Surat :</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="name_type" name="name_type">
            </div>
        </div>
        <div class="mb-3 row">
            <button type="submit" class="btn btn-primary">Simpan</button>
        </div>
    </form>
@endsection