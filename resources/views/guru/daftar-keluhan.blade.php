@extends('layout.dashboard-guru')

@section('container')
    <div class="container-fluid">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
            <h1 class="title mt-4">Keluhan</h1>
        </div>
        <table class="table">
            <thead>
            <tr>
                <th scope="col">Nama</th>
                <th scope="col">NISN</th>
                <th scope="col">Kelas</th>
                <th scope="col">Isi</th>
                <th scope="col">Waktu</th>
                <th scope="col">Aksi</th>
            </tr>
            </thead>
            <tbody>
            @foreach($list as $k)
                <tr>
                    <td>{{ $k->nama }}</td>
                    <td>{{ $k->NISN }}</td>
                    <td>{{ $k->kelas }}{{ $k->unit }}</td>
                    <td>{{ $k->isi }}</td>
                    <td>{{ $k->created_at }}</td>
                    <td>
                        <a href="{{url('guru/tanggapanguru/'.$k->id)}}" class="badge badge-info">Tanggapi</a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        {{$list->links() }}
    </div>
@endsection
