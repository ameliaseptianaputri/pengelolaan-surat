@extends('layouts.template')

@section('content')
    @if (Session::get('success'))
        <div class="alert alert-success">{{ Session::get('success') }}</div>
    @endif

    @if (Session::get('deleted'))
        <div class="alert alert-warning">{{ Session::get('deleted') }}</div>
    @endif
    <div class="d-block justify-content-between flex-wrap flex-end-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h5 class="h5"> Data Klasifikasi Surat</h5>
        <div class="d-flex">
            <h6>Home /<b class="text-primary"> Data Klasifikasi Surat</b></h6>
        </div>  
        <div class="input-group m-3">
            <form action="{{ route('klasifikasi.home') }}" method="GET" class="d-flex align-items-center">
                <input type="text" name="data" value="{{ request('data') }}" class="form-control" placeholder="Cari...">
                <button type="submit" class="btn btn-info">Cari</button>
                @if(request('data'))
                    <a href="{{ route('klasifikasi.home') }}" class="btn btn-danger">Hapus</a>
                @endif
            </form>            
        </div>

    <div class="d-flex justify-content-end">
        <a href="{{ route('klasifikasi.create') }}" class="btn btn-primary mb-3">Tambah</a>
        <a href="{{ route('klasifikasi.export') }}" class="btn btn-info mb-3">Export Klasifikasi Surat</a>
    </div>
    <table class="table table-striped table-bordered table-hover">
        <thead>
            <tr>
                <th>No</th>
                <th>Kode Surat</th>
                <th>Klasifikasi Surat</th>
                <th>Surat Tertaut</th>
                <th class="text-center">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @php $no = 1; @endphp
            @foreach ($let as $letters)
                <tr>
                    <td>{{ $no++ }}</td>
                    <td>{{ $letters['letter_code'] }}</td>
                    <td>{{ $letters['name_type'] }}</td>
                    <td>{{ App\Models\Letter::where('letter_type_id', $letters->id)->count() }}</td>
                    <td class="d-flex justify-content-center">
                        <a href="{{ route('klasifikasi.show', $letters['id']) }}" class="btn btn-warning me-3 text-white">Show</a>
                        <a href="{{ route('klasifikasi.edit', $letters['id']) }}" class="btn btn-primary me-3">Edit</a>
                        <form action="{{ route('klasifikasi.destroy', $letters['id']) }}" class="d-inline" method="post" onsubmit="return confirm('Apakah anda yakin akan menghapus data ini?')">
                            @method('delete')
                            @csrf
                            <button class="btn btn-danger me-3">
                                Delete
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
    