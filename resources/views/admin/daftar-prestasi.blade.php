@extends('layout/dashboard-admin')

@section('container')
    <div class="container-fluid">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
            <h1 class="title mt-4">Daftar Prestasi Belajar</h1>
        </div>

        @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif

        <div class="row" style="margin-bottom: 15px">
            <div class="col">
                <form class="form-inline" method="get" action="{{url('admin/filter-prestasi')}}">
                    <select class="custom-select my-1 mr-sm-2" id="inlineFormCustomSelectPref" name="kelas">
                        <option selected>Pilih kelas</option>
                        @foreach($kelas as $b)
                            <option>{{$b->kelas}}</option>
                        @endforeach
                    </select>

                    <select class="custom-select my-1 mr-sm-2" id="inlineFormCustomSelectPref" name="unit">
                        <option selected>Pilih unit kelas</option>
                        @foreach($unit as $b)
                            <option>{{$b->unit}}</option>
                        @endforeach
                    </select>

                    <button type="submit" class="btn btn-primary my-1">Cari</button>
                </form>
            </div>
            <div class="col-3">
                <form class="form-inline" method="get" action="{{url('admin/cari-prestasi')}}">
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Cari nama" aria-label="Recipient's username" aria-describedby="button-addon2" name="cari">
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
                <th scope="col">No.</th>
                <th scope="col">Nama</th>
                <th scope="col">NISN</th>
                <th scope="col">Kelas</th>
                <th scope="col">Aksi</th>
            </tr>
            </thead>
            <tbody>
            @foreach($siswa as $index => $s)
                 <tr>
                    <th scope="row">{{ ++$index + ($siswa->currentPage()-1) * $siswa->perPage() }}</th>
                    <td>{{ $s->nama }}</td>
                    <td>{{ $s->NISN }}</td>
                    <td>{{ $s->kelas }}{{ $s->unit }}</td>
                    <td>
                        <a href="{{url('admin/form-prestasi/'.$s->id.'/form')}}" class="badge badge-success">Isi Nilai</a>
                    </td>
                 </tr>
            @endforeach
            </tbody>
        </table>
        {{$siswa->links()}}
    </div>
@endsection
