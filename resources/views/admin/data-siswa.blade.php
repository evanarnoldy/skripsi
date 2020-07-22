@extends('layout/dashboard-admin')

@section('container')
    <div class="container-fluid">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
            <h1 class="title mt-4">Data Siswa</h1>
        </div>

        <a href="{{url('admin/tambah-siswa')}}" class="btn btn-primary mb-18">Tambah Data Siswa</a>

        @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif

        <div class="row" style="margin-bottom: 15px">
            <div class="col">
                <form class="form-inline" method="get" action="{{url('admin/filter-datasiswa')}}">
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
                <form class="form-inline" method="get" action="{{url('admin/cari-datasiswa')}}">
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
                <th scope="col">Id</th>
                <th scope="col">Nama</th>
                <th scope="col">NISN</th>
                <th scope="col">Kelas</th>
                <th scope="col">Foto</th>
                <th scope="col">Aksi</th>
            </tr>
            </thead>
            <tbody>
            @foreach($siswa as $s)
                 <tr>
                    <th scope="row">{{ $loop->iteration }}</th>
                    <td>{{ $s->nama }}</td>
                    <td>{{ $s->NISN }}</td>
                    <td>{{ $s->kelas }}{{ $s->unit }}</td>
                     <td><img src="{{url('uploads/avatar/'.$s->avatar )}}" style="width:100px;height: 100px;"></td>
                    <td>
                        <a href="detail-siswa/{{ $s->id}}" class="badge badge-info">Rincian</a>
                        <form method="post" action="data-siswa/{{ $s->id }}" class="d-inline">
                            @method('delete')
                            @csrf
                            <button type="submit" class="badge badge-danger no-border">Hapus</button>
                        </form>
                        <a href="data-siswa/{{ $s->id }}/edit-siswa" class="badge badge-success">Edit</a>
                    </td>
                 </tr>
            @endforeach
            </tbody>
        </table>
        {{$siswa->links()}}
    </div>
@endsection
