@extends('layout.dashboard-siswa')

@section('container')
    <div class="container-fluid">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
            <h1 class="title mt-4">Profil</h1>
        </div>

        @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif

            <div class="row no-gutters">
                <div class="col-md-3">
                    <img src="{{url('uploads/avatar/'.auth()->user()->avatar)}}" class="card-img" alt="..." style="width: 250px; height: 250px">
                    <form enctype="multipart/form-data" action="{{url('siswa/profil-siswa')}}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="avatar">Ubah foto profil</label>
                            <input type="file" class="form-control-file" id="avatar" name="avatar">
                        </div>
                        <button type="submit" class="btn btn-primary">Ubah Foto</button>
                    </form>
                </div>
                <div class="col-md-9">
                    <div class="card-header">
                        <ul class="nav nav-tabs card-header-tabs">
                            <li class="nav-item">
                                <a class="nav-link active" href="#">About</a>
                            </li>
                        </ul>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col">
                                <p>Nama</p>
                                <p>NISN</p>
                                <p>Kelas</p>
                                <p>Email</p>
                                <p>Jenis Kelamin</p>
                                <p>Tanggal lahir</p>
                                <p>Alamat</p>
                            </div>
                            <div class="col">
                                <p>: {{$user->nama}}</p>
                                <p>: {{$user->NISN}}</p>
                                <p>: {{$user->kelas}}{{$user->unit}}</p>
                                <p>: {{$user->email}}</p>
                                <p>: {{$user->jenis_kelamin}}</p>
                                <p>: {{date('d-m-Y', strtotime($user->tanggal_lahir))}}</p>
                                <p>: {{$user->alamat}}</p>
                            </div>
                        </div>
                        <a href="{{url('siswa/profil-siswa/'.$user->id .'/edit-profil')}}" class="btn btn-primary">Edit profil</a>
                    </div>
                </div>
            </div>

    </div>
@endsection
