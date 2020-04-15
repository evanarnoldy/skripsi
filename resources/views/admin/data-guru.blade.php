@extends('layout.dashboard-admin')

@section('container')
    <div class="container-fluid">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
            <h1 class="title mt-4">Data Guru</h1>
        </div>

        <a href="{{url('tambah-guru')}}" class="btn btn-primary mb-18">Tambah Data Guru</a>

        @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif

        <table class="table">
            <thead>
            <tr>
                <th scope="col">Id</th>
                <th scope="col">Nama</th>
                <th scope="col">NIP</th>
                <th scope="col">Email</th>
                <th scope="col">Aksi</th>
            </tr>
            </thead>
            <tbody>
            @foreach($guru as $g)
             <tr>
                <th scope="row">{{ $loop->iteration }}</th>
                <td>{{ $g->nama }}</td>
                <td>{{ $g->NIP }}</td>
                <td>{{ $g->email }}</td>
                <td>
                    <a href="/detail-guru/{{ $g->id}}" class="badge badge-info">Rincian</a>
                    <form method="post" action="/data-guru/{{ $g->id }}" class="d-inline">
                        @method('delete')
                        @csrf
                        <button type="submit" class="badge badge-danger no-border">Hapus</button>
                    </form>
                    <a href="/data-guru/{{ $g->id }}/edit-guru" class="badge badge-success">Edit</a>
                </td>
             </tr>
            @endforeach
            </tbody>
        </table>
        {{$guru->links()}}
    </div>
@endsection
