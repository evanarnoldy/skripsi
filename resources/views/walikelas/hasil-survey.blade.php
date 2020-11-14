@extends('layout/dashboard-walikelas')

@section('container')
    <div class="container-fluid">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
            <h1 class="title mt-4">Hasil Monitoring Kesehatan Mental Kelas {{Auth::user()->kelas_diampu}}{{Auth::user()->unit}}</h1>
        </div>

        <div class="row" style="margin-bottom: 15px">
            <div class="col">
                <form class="form-inline" method="get" action="{{url('wali/filter-surveywali')}}">
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
            <div class="col-3">
                <form class="form-inline" method="get" action="{{url('wali/cari-surveywali')}}">
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Cari nama atau NISN" aria-label="Recipient's username" aria-describedby="button-addon2" name="cari">
                        <div class="input-group-append">
                            <button class="btn btn-primary" type="submit"><i class="fas fa-search"></i></button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <table class="table">
            <thead>
            <tr>
                <th scope="col">Nama</th>
                <th scope="col">NISN</th>
                <th scope="col">Kelas</th>
                <th scope="col">Bulan</th>
                <th scope="col">Tahun</th>
                <th scope="col">Hasil</th>
                <th scope="col">Keterangan</th>
            </tr>
            </thead>
            <tbody>
            @foreach($siswa as $s)
                @if($siswa == null)
                    <p>Data tidak ditemukan</p>
                    @else
                 <tr>
                    <td>{{ $s->nama }}</td>
                    <td>{{ $s->NISN }}</td>
                    <td>{{ $s->kelas }}{{$s->unit}}</td>
                    <td>{{ $s->bulan }}</td>
                    <td>{{ $s->tahun }}</td>
                     <td>
                         <a href="{{url('wali/detail-jawaban-wali/'.$s->id)}}">{{ $s->keterangan }}</a>
                     </td>
                     <td>{{ $s->status }}</td>
                 </tr>
                 @endif
            @endforeach
            </tbody>
        </table>
        {{$siswa->links()}}
    </div>
@endsection
