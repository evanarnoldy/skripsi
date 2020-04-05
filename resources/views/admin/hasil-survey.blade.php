@extends('layout/dashboard-admin')

@section('container')
    <div class="container-fluid">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
            <h1 class="title mt-4">Hasil Monitoring Kesehatan Mental</h1>
        </div>

        <table class="table">
            <thead>
            <tr>
                <th scope="col">Nama</th>
                <th scope="col">NISN</th>
                <th scope="col">Kelas</th>
                <th scope="col">Email</th>
                <th scope="col">Hasil</th>
            </tr>
            </thead>
            <tbody>
            @foreach($siswa as $siswa)
                 <tr>
                    <td>{{ $siswa->nama }}</td>
                    <td>{{ $siswa->NISN }}</td>
                    <td>{{ $siswa->kelas }}</td>
                    <td>{{ $siswa->email }}</td>
                     <td>
                         <a href="/detail-jawaban/{{ $siswa->id}}">{{ $siswa->keterangan }}</a>
                     </td>
                 </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
