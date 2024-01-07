@extends('layouts.template')

@section('content')
    @if(Session::get('success'))
    <div class="alert alert-success"> {{ Session::get('success') }} </div>
    @endif

    @if(Session::get('deleted'))
    <div class="alert alert-warning"> {{ Session::get('deleted') }} </div>
    @endif

     <div class="d-block justify-content-between flex-wrap flex-end-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h5 class="h5"> Data Surat</h5>
        <div class="d-flex">
            <h6>Home /<b class="text-primary"> Data Surat</b></h6>
        </div>  
    <div class="col-md-6">
        <form action="{{ route('order.index') }}" method="GET">
            <div class="input-group">
                <input type="date" name="tanggal_filter" id="tanggal_filter" value="{{ request('tanggal_filter') }}" class="form-control">
                <button type="submit" class="btn btn-info">Cari Data</button>
                @if(request('tanggal_filter'))
                    <a href="{{ route('order.index') }}" class="btn btn-secondary">Clear</a>
                @endif
            </div>
        </form>
    </div>
    <div class="d-flex justify-content-end">
        <a href="{{ route('staff.create') }}" class="btn btn-primary mb-3  custom-margin">Tambah</a>
        <a href="{{ route('surat.export') }}" class="btn btn-info mb-3">Export Data Surat</a>
    </div>
    
    {{-- <a href="{{route('surat.create')}}" class="btn btn-primary">Tambah</a> --}}
    {{-- <a href="{{ route('surat.export') }}" class="btn btn-info">Export Klasifikasi Surat</a> --}}
    <table id="example" class="table table-striped" style="width:100%">
        <thead>
            <tr>
                <th>No</th>
                <th>Nomor Surat</th>
                <th>Perihal</th>
                <th>Tanggal Keluar</th>
                <th>Penerima Surat</th>
                <th>Notulis</th>
                <th>Hasil Rapat</th>
                <th>Aksi</th>
            </tr>
        </thead>
        @php
            $no = 1;
        @endphp
        @foreach ($letter as $item)
            <tbody>
                <tr>
                    <td>{{$no++}}</td>
                    <td>{{$item->letterType->letter_code}}/000{{$item->id}}/SMK Wikrama/XII/{{ date('Y') }}</td>
                    <td>{{$item->letter_perihal}}</td>
                    <td>{{$item->created_at->format('j F Y')}}</td>
                    <td>{{implode(', ', array_column($item->recipients, 'name'))}}</td>
                    <td>{{$item->user->name}}</td>
                    <td>
                        @if (App\Models\Result::where('letter_id', $item->id)->exists())
                            <p class="text-success">Sudah dibuat</p>
                        @else
                            <p class="text-danger">Belum Dibuat</p>
                        @endif
                    </td>
                    <td class="d-flex justify-content-center">
                        <a href="{{ route('surat.show', $item['id']) }}" class="btn btn-warning me-3 text-white">Show</a>
                        <a href="{{ route('surat.edit', $item['id']) }}" class="btn btn-primary me-3">Edit</a>
                        <form action="{{ route('surat.delete', $item['id']) }}" class="d-inline" method="post" onsubmit="return confirm('Apakah anda yakin akan menghapus data ini?')">
                            @method('delete')
                            @csrf
                            <button class="btn btn-danger me-3">
                                Delete
                            </button>
                        </form>
                    </td>
            </tbody>
        @endforeach
    </table>
@endsection