@extends('layout.dashboard-siswa')

@section('container')
    <div class="container-fluid">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
            <h1 class="title mt-4">Hasil</h1>
        </div>
        <div class="card text-center">
            <div class="card-header">
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col" style="text-align: right">
                        <p class="card-text">Nama :</p>
                        <p class="card-text">Kelas :</p>
                        <p class="card-text">Email :</p>
                        <p class="card-text">Skor :</p>
                        <p class="card-text">Hasil :</p>
                    </div>
                    <div class="col" style="text-align: left">
                        @foreach($hasil as $h)
                            <p class="card-text">{{ $h->nama}}</p>
                            <p class="card-text">{{ $h->kelas}}</p>
                            <p class="card-text">{{ $h->email}}</p>
                            <p class="card-text">{{ $h->skor}}</p>
                            <p class="card-text">{{ $h->keterangan }}</p>
                        @endforeach
                    </div>
                </div>
                <a href="{{url('siswa')}}" class="btn btn-primary mt-14">Kembali</a>
            </div>
            <div class="card-footer text-muted">
            </div>
        </div>
    </div>
@endsection
