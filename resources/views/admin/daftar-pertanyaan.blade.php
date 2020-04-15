@extends('layout.dashboard-admin')

@section('container')
    <div class="container-fluid">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
            <h1 class="title mt-4">Daftar Pertanyaan</h1>
        </div>

        <a href="{{url('tambah-pertanyaan')}}" class="btn btn-primary mb-18">Tambah Pertanyaan</a>

        @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif

        <table class="table">
            <thead>
            <tr>
                <th scope="col">Id</th>
                <th scope="col">Pertanyaan</th>
                <th scope="col">Jenis</th>
                <th scope="col">Kategori</th>
                <th scope="col">Aksi</th>
            </tr>
            </thead>
            <tbody>
            @foreach($pertanyaan as $p)
             <tr>
                <th scope="row">{{ $loop->iteration }}</th>
                <td>{{ $p->pertanyaan }}</td>
                <td>{{ $p->jenis }}</td>
                <td>{{ $p->kategori }}</td>
                <td>
                    <form method="post" action="/daftar-pertanyaan/{{ $p->id }}" class="d-inline">
                        @method('delete')
                        @csrf
                        <button type="submit" class="badge badge-danger no-border">Hapus</button>
                    </form>
                    <a href="/daftar-pertanyaan/{{ $p->id }}/edit-pertanyaan" class="badge badge-success">Edit</a>
                </td>
             </tr>
            @endforeach
            </tbody>
        </table>
        {{$pertanyaan->links()}}
    </div>
@endsection
