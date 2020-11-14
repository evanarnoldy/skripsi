@extends('layout.dashboard-guru')

@section('container')
    <div class="container-fluid">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
            <h1 class="title mt-4">Hasil Korelasi</h1>
        </div>

        <form class="form-inline" method="get" action="{{url('guru/korelasi')}}" style="margin-bottom: 15px">
            <select class="custom-select my-1 mr-sm-2" id="inlineFormCustomSelectPref" name="bulan">
                @foreach($bulan as $b)
                    <option>{{$b->bulan}}</option>
                @endforeach
            </select>

            <select class="custom-select my-1 mr-sm-2" id="inlineFormCustomSelectPref" name="tahun">
                @foreach($tahun as $b)
                    <option>{{$b->tahun}}</option>
                @endforeach
            </select>

            <button type="submit" class="btn btn-primary my-1">Hitung</button>
        </form>
    </div>
@endsection

