@extends('layout.dashboard-guru')

@section('container')
    <div class="container-fluid">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
            <h1 class="title mt-4">Hasil Korelasi</h1>
        </div>

        <form class="form-inline" method="get" action="{{url('guru/filter-korelasiguru')}}" style="margin-bottom: 15px">
            <select class="custom-select my-1 mr-sm-2" id="inlineFormCustomSelectPref" name="tahun">
                <option selected>Pilih tahun</option>
                @foreach($tahun as $b)
                    <option>{{$b->tahun}}</option>
                @endforeach
            </select>

            <select class="custom-select my-1 mr-sm-2" id="inlineFormCustomSelectPref" name="bulan">
                <option selected>Pilih bulan</option>
                @foreach($bulan as $b)
                    <option>{{$b->bulan}}</option>
                @endforeach
            </select>

            <button type="submit" class="btn btn-primary my-1">Cari</button>
        </form>
        <div class="card">
            <div class="card-header">
            </div>
            <div class="card-body">
                @foreach($hasil as $h)
                <h5 class="bold">Tahun : {{$h->tahun}}</h5>
                <h5 class="bold">Bulan : {{$h->bulan}}</h5>
                <h5 class="bold">Hasil : </h5>
                <p>Nilai koefisien korelasi sebesar {{$h->korelasi}}</p>
                <p>{{$h->ket}}</p>
                @endforeach
            </div>
            <div class="card-footer text-muted">
            </div>
        </div>
    </div>
@endsection
