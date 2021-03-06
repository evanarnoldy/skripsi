@extends('layout/dashboard-walikelas')

@section('container')
    <div class="container-fluid">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
            <h1 class="title mt-4">Grafik Monitoring Kesehatan Mental dan Prestasi Belajar Kelas {{auth()->user()->kelas_diampu}}{{auth()->user()->unit}}</h1>
        </div>

        <div class="row">
            <div class="col">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Grafik Kesehatan mental</h5>
                        <p class="card-text">Menampilkan perkembangan grafik kesehatan mental siswa.</p>
                        <a href="{{route('wali.indexksh')}}" class="btn btn-primary">Lihat grafik</a>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Grafik Prestasi Belajar</h5>
                        <p class="card-text">Menampilkan perkembangan grafik prestasi belajar siswa.</p>
                        <a href="{{route('wali.indexpb')}}" class="btn btn-primary">Lihat grafik</a>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Grafik Korelasi Kesehatan Mental dan Prestasi Belajar</h5>
                        <p class="card-text">Menampilkan perkembangan grafik prestasi belajar siswa.</p>
                        <a href="{{route('wali.indexkor')}}" class="btn btn-primary">Lihat grafik</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('footer')
@endsection
