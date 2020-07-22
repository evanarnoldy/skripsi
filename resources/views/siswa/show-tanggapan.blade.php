@extends('layout.dashboard-siswa')

@section('container')
    <div class="container-fluid">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
            <h1 class="title mt-4">Detail Tanggapan</h1>
        </div>

        @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif

        <div class="card">
                @foreach($data as $d)
                    @foreach($keluhan as $k)
                        <div class="card-header">
                            <h5 class="bold">Keluhan</h5>
                        </div>
                        <div class="card-body">
                             <p>{{$k->isi}}</p>
                        </div>
                    @endforeach
                        <div class="card-header">
                            <h5 class="bold">Tanggapan</h5>
                        </div>
                        <div class="card-body">
                            <p> {{$d->tanggapan}}</p>
                        </div>
                @endforeach
                <a href="{{route('daftar.tanggapan')}}" class="btn btn-primary mt-14">Kembali</a>
            <div class="card-footer text-muted">
            </div>
        </div>
    </div>
@endsection


{{--@extends('layout.dashboard-siswa')--}}

{{--@section('container')--}}
{{--    <div class="container-fluid">--}}
{{--        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">--}}
{{--            <h1 class="title mt-4">Tanggapan</h1>--}}
{{--        </div>--}}
{{--        <table class="table">--}}
{{--            <thead>--}}
{{--            <tr>--}}
{{--                <th scope="col">Nama</th>--}}
{{--                <th scope="col">Email</th>--}}
{{--                <th scope="col">Isi</th>--}}
{{--                <th scope="col">Waktu</th>--}}
{{--            </tr>--}}
{{--            </thead>--}}
{{--            <tbody>--}}
{{--            @foreach($data as $k)--}}
{{--                <tr>--}}
{{--                    <td>{{ $k->nama }}</td>--}}
{{--                    <td>{{ $k->email }}</td>--}}
{{--                    <td>{{ $k->tanggapan }}</td>--}}
{{--                    <td>{{ $k->created_at }}</td>--}}
{{--                </tr>--}}
{{--            @endforeach--}}
{{--            </tbody>--}}
{{--        </table>--}}
{{--    </div>--}}
{{--@endsection--}}
