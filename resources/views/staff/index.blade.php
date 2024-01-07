@extends('layouts.template')

@section('content')
    @if (Session::get('success'))
        <div class="alert alert-success">{{ Session::get('success') }}</div>
    @endif

    @if (Session::get('deleted'))
        <div class="alert alert-warning">{{ Session::get('deleted') }}</div>
    @endif
    <div class="d-block justify-content-between flex-wrap flex-end-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h5 class="h5"> Data Staff Tata Usaha</h5>
        <div class="d-flex">
            <h6>Home /<b class="text-primary"> Data Staff Tata Usaha</b></h6>
        </div>  

    <div class="input-group m-3">
        <form action="{{ route('staff.home') }}" method="GET" class="d-flex align-items-center">
            <input type="text" name="data" value="{{ request('data') }}" class="form-control" placeholder="Cari...">
            <button type="submit" class="btn btn-info">Cari</button>
            @if(request('data'))
                <a href="{{ route('staff.home') }}" class="btn btn-danger">Hapus</a>
            @endif
        </form>
    </div>
    <div class="d-flex justify-content-end">
        <a href="{{ route('staff.create') }}" class="btn btn-primary mb-3">Tambah Pengguna</a>
    </div>
    <br>
    
    <table class="table table-striped table-bordered table-hover">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Email</th>
                <th>Role</th>
                <th class="text-center">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @php
                $no = 1;
            @endphp
            @foreach ($staffs as $item)
                <tr>
                    <td>{{ $no++ }}</td>
                    <td>{{ $item['name'] }}</td>
                    <td>{{ $item['email'] }}</td>
                    <td>{{ $item['role'] }}</td>
                    <td class="d-flex justify-content-center">
                        <a href="{{ route('staff.edit', $item['id']) }}" class="btn btn-primary me-3">Edit</a>
                        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#modal-hapus-{{$item['id']}}">Hapus</button>
                    </td>
                </tr>
                <div class="modal fade" id="modal-hapus-{{$item['id']}}" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Konfirmasi Hapus</h5>
                                <button type='button' class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                Yakin ingin menghapus data ini ?
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <form action="{{ route('staff.delete', $item['id']) }}" method="post">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Hapus</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </tbody>
    </table>    
@endsection