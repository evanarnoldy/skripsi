@extends('layout.dashboard-admin')

@section('container')
    <div class="container-fluid">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
            <h1 class="title mt-4">Info Walikelas</h1>
        </div>
        <div class="card text-center">
            <div class="card-header">
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col" style="text-align: right">
                        <p class="card-text">Nama  :</p>
                        <p class="card-text">NIP  :</p>
                        <p class="card-text">Jenis kelamin  :</p>
                        <p class="card-text">Kelas yang diampu  :</p>
                        <p class="card-text">Alamat  :</p>
                        <p class="card-text">Tanggal lahir  :</p>
                        <p class="card-text">Email :</p>
                    </div>
                    <div class="col" style="text-align: left">
                        <p class="card-text">{{ $waliKelas->nama }}</p>
                        <p class="card-text">{{ $waliKelas->NIP }}</p>
                        <p class="card-text">{{ $waliKelas->jenis_kelamin }}</p>
                        <p class="card-text">{{ $waliKelas->kelas_diampu }}{{$waliKelas->unit}}</p>
                        <p class="card-text">{{ $waliKelas->alamat }}</p>
                        <p class="card-text">{{ date('d-m-Y', strtotime($waliKelas->tanggal_lahir))}}</p>
                        <p class="card-text">{{ $waliKelas->email}}</p>
                    </div>
                </div>
                <a href="{{url('admin/data-wali')}}" class="btn btn-primary mt-14">Kembali</a>
            </div>
            <div class="card-footer text-muted">
            </div>
        </div>
    </div>
@endsection
