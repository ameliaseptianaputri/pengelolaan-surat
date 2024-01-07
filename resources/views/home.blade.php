@extends('layouts.template')

@section('content')
<div class="d-block justify-content-between flex-wrap flex-end-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h5 class="h5">Dashboard</h5>
    <div class="d-flex">
        <h6>Home /<b class="text-primary"> Dashboard</b></h6>
    </div>  
<br> 
<div class="jumbotron py-4 px-5">
    @if(Session::get ('cannotAccess'))
        <div class="alert alert-danger">{{ Session::get('cannotAccess') }}</div>
    @endif
    <h2 class="display-4">
        Selamat Datang!
        @auth
            {{ Auth::user()->name }} !
        @endauth
    </h2>
    <hr class="my-4">
    @auth
    <div class="row">
        <div class="col-xl-3 col-md-6">
            <div class="card">
                <div class="card-body">
                    Surat Keluar
                </div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <h2>{{ App\Models\Letter::all()->count() }}</h2>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card">
                <div class="card-body">
                    Klasifikasi Surat
                </div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <h2>{{ App\Models\LetterType::all()->count() }}</h2>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card">
                <div class="card-body">
                    Staff Tata Usaha
                </div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <h2>{{ App\Models\User::where('role', 'staff')->count() }}</h2>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card">
                <div class="card-body">
                    Guru
                </div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <h2>{{ App\Models\User::where('role', 'guru')->count() }}</h2>
                </div>
            </div>
        </div>
    </div>
</div>
    @endauth
@endsection