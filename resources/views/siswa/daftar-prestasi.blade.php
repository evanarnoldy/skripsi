@extends('layout/dashboard-siswa')

@section('container')
    <div class="container-fluid">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
            <h1 class="title mt-4">Hasil Prestasi Belajar</h1>
        </div>

{{--        <div class="row" style="margin-bottom: 15px">--}}
{{--            <div class="col">--}}
{{--                <form class="form-inline" method="get" action="{{url('guru/filter-surveyguru')}}">--}}
{{--                    <select class="custom-select my-1 mr-sm-2" id="inlineFormCustomSelectPref" name="bulan">--}}
{{--                        <option selected>Pilih bulan</option>--}}
{{--                        @foreach($bulan as $b)--}}
{{--                            <option>{{$b->bulan}}</option>--}}
{{--                        @endforeach--}}
{{--                    </select>--}}

{{--                    <select class="custom-select my-1 mr-sm-2" id="inlineFormCustomSelectPref" name="tahun">--}}
{{--                        <option selected>Pilih tahun</option>--}}
{{--                        @foreach($tahun as $b)--}}
{{--                            <option>{{$b->tahun}}</option>--}}
{{--                        @endforeach--}}
{{--                    </select>--}}

{{--                    <select class="custom-select my-1 mr-sm-2" id="inlineFormCustomSelectPref" name="kelas">--}}
{{--                        <option selected>Pilih kelas</option>--}}
{{--                        @foreach($kelas as $b)--}}
{{--                            <option>{{$b->kelas}}</option>--}}
{{--                        @endforeach--}}
{{--                    </select>--}}

{{--                    <select class="custom-select my-1 mr-sm-2" id="inlineFormCustomSelectPref" name="unit">--}}
{{--                        <option selected>Pilih unit kelas</option>--}}
{{--                        @foreach($unit as $b)--}}
{{--                            <option>{{$b->unit}}</option>--}}
{{--                        @endforeach--}}
{{--                    </select>--}}

{{--                    <button type="submit" class="btn btn-primary my-1">Cari</button>--}}
{{--                </form>--}}
{{--            </div>--}}
{{--            <div class="col-3">--}}
{{--                <form class="form-inline" method="get" action="{{url('guru/cari-surveyguru')}}">--}}
{{--                    <div class="input-group">--}}
{{--                        <input type="text" class="form-control" placeholder="Cari nama" aria-label="Recipient's username" aria-describedby="button-addon2" name="cari">--}}
{{--                        <div class="input-group-append">--}}
{{--                            <button class="btn btn-primary" type="submit"><i class="fas fa-search"></i></button>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </form>--}}
{{--            </div>--}}
{{--        </div>--}}

        <table class="table">
            <thead>
            <tr>
                <th scope="col">Bulan</th>
                <th scope="col">Tahun</th>
                <th scope="col">IPA</th>
                <th scope="col">Matematika</th>
                <th scope="col">Bahasa Indonesia</th>
                <th scope="col">Bahasa Inggris</th>
                <th scope="col">Rata-rata</th>
                <th scope="col">Hasil</th>
                <th scope="col">Keterangan</th>
            </tr>
            </thead>
            <tbody>
            @foreach($prestasi as $s)
                <tr>
                    <td>{{ $s->bulan }}</td>
                    <td>{{ $s->tahun }}</td>
                    <td>{{$s->ipa}}</td>
                    <td>{{$s->matematika}}</td>
                    <td>{{$s->bhsind}}</td>
                    <td>{{$s->bhsing}}</td>
                    <td>{{$s->rata}}</td>
                    <td>{{$s->keterangan}}</td>
                    <td>{{$s->status}}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
        {{$prestasi->links()}}
    </div>
@endsection
