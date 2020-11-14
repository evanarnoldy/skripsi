@extends('layout.dashboard-admin')

@section('container')
    <div class="container-fluid">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
            <h1 class="title mt-4">Form Tambah Data Walikelas</h1>
        </div>
        <form enctype="multipart/form-data" method="post" action="{{url('admin/data-wali')}}">
            @csrf
            <div class="form-group">
                <label for="nama">Nama</label>
                <input type="text" class="form-control @error('nama') is-invalid @enderror" id="nama" name="nama" placeholder="Masukkan Nama" value="{{ old('nama') }}">
                @error('nama') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="form-group">
                <label for="NIP">Nomor Induk Pegawai</label>
                <input type="text" class="form-control @error('NIP') is-invalid @enderror" id="NIP" name="NIP" placeholder="Masukkan NIP" value="{{ old('NIP') }}">
                @error('NISN') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="form-group">
                <label for="tanggal_lahir">Tanggal lahir</label>
                <input type="date" class="form-control @error('tanggal_lahir') is-invalid @enderror" id="tanggal_lahir" name="tanggal_lahir" placeholder="Masukkan Tanggal lahir" value="{{ old('tanggal_lahir') }}">
                @error('tanggal_lahir') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="form-group">
                <label for="jenis_kelamin">Jenis Kelamin</label>
                <select type="date" class="form-control @error('jenis_kelamin') is-invalid @enderror" id="jenis_kelamin" name="jenis_kelamin" placeholder="Masukkan Jenis Kelamin" value="{{ old('jenis_kelamin') }}">
                @error('jenis_kelamin') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    <option selected disabled>Pilih Jenis Kelamin</option>
                    <option>Laki-laki</option>
                    <option>Perempuan</option>
                </select>
            </div>
            <div class="form-group">
                <label for="alamat">Alamat</label>
                <input type="text" class="form-control @error('alamat') is-invalid @enderror" id="alamat" name="alamat" placeholder="Masukkan Alamat" value="{{ old('alamat') }}">
                @error('alamat') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" placeholder="Masukkan Email" value="{{ old('email') }}">
                @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="form-group">
                <label for="kelas">Kelas yang diampu</label>
                <select type="text" class="form-control @error('kelas') is-invalid @enderror" id="kelas" name="kelas_diampu" placeholder="Masukkan Kelas yang diampu" value="{{ old('kelas_diampu') }}">
                    @error('kelas_diampu') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    <option selected disabled>Pilih Kelas</option>
                    <option>7</option>
                    <option>8</option>
                    <option>9</option>
                </select>
            </div>
            <div class="form-group">
                <label for="unit">Unit</label>
                <select type="text" class="form-control @error('unit') is-invalid @enderror" id="unit" name="unit" placeholder="Masukkan Unit Kelas" value="{{ old('unit') }}">
                    @error('unit') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    <option selected disabled>Pilih Unit Kelas</option>
                    <option>A</option>
                    <option>B</option>
                    <option>C</option>
                    <option>D</option>
                    <option>E</option>
                </select>
            </div>
            <div class="form-group">
                <label for="avatar">Foto</label>
                <input type="file" class="form-control-file @error('avatar') is-invalid @enderror" id="avatar" name="avatar">
                @error('avatar') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <button type="submit" class="btn btn-primary">Tambah Data</button>
        </form>
    </div>
@endsection
