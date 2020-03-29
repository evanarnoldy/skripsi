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
                <th scope="col">Hasil</th>
                <th scope="col">Aksi</th>
            </tr>
            </thead>
            <tbody>
            @foreach($siswa as $siswa)
                @foreach($hasil as $h)
                 <tr>
                    <th scope="row">{{ $loop->iteration }}</th>
                    <td>{{ $siswa->nama }}</td>
                    <td>{{ $siswa->NISN }}</td>
                    <td>{{ $siswa->kelas }}</td>
                    <td>{{ $siswa->email }}</td>
                     <td>
                         <a href="/detail-jawaban/{{ $siswa->id}}">{{ $h->kesimpulan }}</a></td>
                    <td>
                        <a href="/detail-siswa/{{ $siswa->id}}" class="badge badge-info">Rincian</a>
                        <form method="post" action="/data-siswa/{{ $siswa->id }}" class="d-inline">
                            @method('delete')
                            @csrf
                            <button type="submit" class="badge badge-danger no-border">Hapus</button>
                        </form>
                        <a href="/data-siswa/{{ $siswa->id }}/edit-siswa" class="badge badge-success">Edit</a>
                    </td>
                 </tr>
                @endforeach
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
