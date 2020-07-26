@extends('layout.dashboard-walikelas')

@section('container')
    <div class="container-fluid">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
            <h1 class="title mt-4">Hasil Korelasi</h1>
        </div>

        <div class="card">
            <div class="card-header">
            </div>
            <div class="card-body">
                <h5 class="bold">Tahun : {{$tahun}}</h5>
                <h5 class="bold">Bulan : {{$bulan1}}</h5>
                <h5 class="bold">Hasil : </h5>
                <p>Nilai koefisien korelasi sebesar {{$korelasi}}</p>
                <p>{{$hasil}}</p>
            </div>
            <div class="card-footer text-muted">
            </div>
        </div>
    </div>
@endsection
