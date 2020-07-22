@extends('layout/dashboard-admin')

@section('container')
    <div class="container-fluid">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
            <h1 class="title mt-4">Info Siswa</h1>
        </div>
        <div class="card text-center">
            <div class="card-header">
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col" style="text-align: right">
                        <p class="card-text">Nama  :</p>
                        <p class="card-text">NISN  :</p>
                        <p class="card-text">Jenis kelamin  :</p>
                        <p class="card-text">Alamat  :</p>
                        <p class="card-text">Tanggal lahir  :</p>
                        <p class="card-text">Kelas :</p>
                    </div>
                    <div class="col" style="text-align: left">
                            <p class="card-text">{{ $student->nama }}</p>
                            <p class="card-text">{{ $student->NISN }}</p>
                            <p class="card-text">{{ $student->jenis_kelamin }}</p>
                            <p class="card-text">{{ $student->alamat }}</p>
                            <p class="card-text">{{ date('d-m-Y', strtotime($student->tanggal_lahir))}}</p>
                            <p class="card-text">{{ $student->kelas}}{{ $student->unit }}</p>
                    </div>
                </div>
                <a href="{{url('admin/data-siswa')}}" class="btn btn-primary mt-14">Kembali</a>
            </div>
            <div class="card-footer text-muted">
            </div>
        </div>
    </div>
@endsection
