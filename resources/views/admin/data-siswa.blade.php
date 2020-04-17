@extends('layout/dashboard-admin')

@section('container')
    <div class="container-fluid">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
            <h1 class="title mt-4">Data Siswa</h1>
        </div>

        <a href="{{url('tambah-siswa')}}" class="btn btn-primary mb-18">Tambah Data Siswa</a>

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
                <th scope="col">NISN</th>
                <th scope="col">Kelas</th>
                <th scope="col">Email</th>
                <th scope="col">Foto</th>
                <th scope="col">Aksi</th>
            </tr>
            </thead>
            <tbody>
            @foreach($siswa as $s)
                 <tr>
                    <th scope="row">{{ $loop->iteration }}</th>
                    <td>{{ $s->nama }}</td>
                    <td>{{ $s->NISN }}</td>
                    <td>{{ $s->kelas }}</td>
                    <td>{{ $s->email }}</td>
                     <td><img src="{{'uploads/avatar/'.$s->avatar }}" style="width:100px;height: 100px;"></td>
                    <td>
                        <a href="/detail-siswa/{{ $s->id}}" class="badge badge-info">Rincian</a>
                        <form method="post" action="/data-siswa/{{ $s->id }}" class="d-inline">
                            @method('delete')
                            @csrf
                            <button type="submit" class="badge badge-danger no-border">Hapus</button>
                        </form>
                        <a href="/data-siswa/{{ $s->id }}/edit-siswa" class="badge badge-success">Edit</a>
                    </td>
                 </tr>
            @endforeach
            </tbody>
        </table>
        {{$siswa->links()}}
    </div>
@endsection
