@extends('layout.dashboard-siswa')

@section('container')
    <div class="container-fluid">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
            <h1 class="title mt-4">Daftar Tanggapan</h1>
        </div>
        <table class="table">
            <thead>
            <tr>
                <th scope="col">Nama</th>
                <th scope="col">Status</th>
                <th scope="col">Email</th>
                <th scope="col">Waktu</th>
                <th scope="col">Tanggapan</th>
                <th scope="col">Aksi</th>
            </tr>
            </thead>
            <tbody>
            @foreach($tanggapan as $k)
                <tr>
                    <td>{{ $k->pengirim }}</td>
                    <td>{{ $k->penerima }}</td>
                    <td>{{ $k->email }}</td>
                    <td>{{ $k->created_at }}</td>
                    <td>{{ $k->tanggapan }}</td>
                    <td> <a href="{{url('siswa/detail-tanggapan/'.$k->id)}}" class="badge badge-info">Rincian</a> </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        {{$tanggapan->links() }}
    </div>
@endsection
