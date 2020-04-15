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
            @foreach($siswa as $s)
                 <tr>
                    <td>{{ $s->nama }}</td>
                    <td>{{ $s->NISN }}</td>
                    <td>{{ $s->kelas }}</td>
                    <td>{{ $s->email }}</td>
                     <td>
                         <a href="/detail-jawaban/{{ $s->id}}">{{ $s->keterangan }}</a>
                     </td>
                 </tr>
            @endforeach
            </tbody>
        </table>
        {{$siswa->links()}}
    </div>
@endsection
