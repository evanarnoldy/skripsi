@extends('layout.dashboard-siswa')

@section('container')
    <div class="container-fluid">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
            <h1 class="title mt-4">Detail Hasil</h1>
        </div>
        <div class="card text-center">
            <div class="card-header">
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col" style="text-align: right">
                        <p class="card-text">Hasil :</p>
                        <p class="card-text">Skor :</p>
                        <p class="card-text">Diisi pada :</p>
                    </div>
                    <div class="col" style="text-align: left">
                            <p class="card-text">{{ $hasil->keterangan }}</p>
                            <p class="card-text">{{ $hasil->nilai}}</p>
                            <p class="card-text">{{date('l, d F Y H:i:s', strtotime($hasil->created_at))}}</p>
                    </div>
                </div>
                <a href="{{route('hasil')}}" class="btn btn-primary mt-14">Kembali</a>
            </div>
            <div class="card-footer text-muted">
            </div>
        </div>
    </div>
@endsection
