@extends('layout/dashboard-siswa')

@section('container')
    <div class="container-fluid">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
            <h1 class="title mt-4">Hasil Tes Kesehatan Mental</h1>
        </div>

        <div class="row" style="margin-bottom: 15px">
            <div class="col">
                <form class="form-inline" method="get" action="{{url('siswa/filter-hasil-kuesioner')}}">
                    <select class="custom-select my-1 mr-sm-2" id="inlineFormCustomSelectPref" name="bulan">
                        <option selected>Pilih bulan</option>
                        @foreach($bulan as $b)
                            <option>{{$b->bulan}}</option>
                        @endforeach
                    </select>

                    <select class="custom-select my-1 mr-sm-2" id="inlineFormCustomSelectPref" name="tahun">
                        <option selected>Pilih tahun</option>
                        @foreach($tahun as $b)
                            <option>{{$b->tahun}}</option>
                        @endforeach
                    </select>

                    <select class="custom-select my-1 mr-sm-2" id="inlineFormCustomSelectPref" name="keterangan">
                        <option selected>Pilih hasil</option>
                        @foreach($ket as $b)
                            <option>{{$b->keterangan}}</option>
                        @endforeach
                    </select>

                    <button type="submit" class="btn btn-primary my-1">Cari</button>
                </form>
            </div>
        </div>

        <table class="table">
            <thead>
            <tr>
                <th scope="col">Bulan</th>
                <th scope="col">Tahun</th>
                <th scope="col">Nilai</th>
                <th scope="col">Hasil</th>
                <th scope="col">Keterangan</th>
            </tr>
            </thead>
            <tbody>
            @foreach($hasil as $s)
                <tr>
                    <td>{{ $s->bulan }}</td>
                    <td>{{ $s->tahun }}</td>
                    <td>{{ $s->nilai }}</td>
                    <td>{{$s->keterangan}}</td>
                    <td>{{$s->status}}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
        {{$hasil->links()}}
    </div>
@endsection
