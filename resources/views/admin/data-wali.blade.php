@extends('layout.dashboard-admin')

@section('container')
    <div class="container-fluid">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
            <h1 class="title mt-4">Data Walikelas</h1>
        </div>

        @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif


        <a href="{{url('admin/tambah-wali')}}" class="btn btn-primary mb-18">Tambah Data Walikelas</a>

        <div class="row" style="margin-bottom: 15px">
            <div class="col">
                <form class="form-inline" method="get" action="{{url('admin/filter-wali')}}">
                    <select class="custom-select my-1 mr-sm-2" id="inlineFormCustomSelectPref" name="kelas">
                        <option selected>Pilih kelas</option>
                        @foreach($kelas as $b)
                            <option>{{$b->kelas_diampu}}</option>
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
                <form class="form-inline" method="get" action="{{url('admin/cari-wali')}}">
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Cari nama dan NIP" aria-label="Recipient's username" aria-describedby="button-addon2" name="cari">
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
                <th scope="col">NIP</th>
                <th scope="col">Email</th>
                <th scope="col">Alamat</th>
                <th scope="col">Kelas yang diampu</th>
                <th scope="col">Foto</th>
                <th scope="col">Aksi</th>
            </tr>
            </thead>
            <tbody>
            @foreach($wali as $index => $g)
             <tr>
                <th scope="row">{{ ++$index + ($wali->currentPage()-1) * $wali->perPage() }}</th>
                <td>{{ $g->nama }}</td>
                <td>{{ $g->NIP }}</td>
                <td>{{ $g->email }}</td>
                <td>{{ $g->alamat }}</td>
                <td>{{ $g->kelas_diampu }}{{$g->unit}}</td>
                 <td><img src="{{url('uploads/avatar/'.$g->avatar )}}" style="width:100px;height: 100px;"></td>
                <td>
                    <form method="post" action="{{url('admin/data-wali/'.$g->id)}}" class="d-inline">
                        @method('delete')
                        @csrf
                        <button type="submit" class="badge badge-danger no-border">Hapus</button>
                    </form>
                    <a href="{{url('admin/data-wali/'.$g->id.'/edit-wali')}}" class="badge badge-success">Edit</a>
                </td>
             </tr>
            @endforeach
            </tbody>
        </table>
        {{$wali->links()}}
    </div>
@endsection
