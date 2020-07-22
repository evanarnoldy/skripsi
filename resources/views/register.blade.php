@extends('layout/login')

@section('form')
    <h3> Daftar Sebagai :</h3>
    <form>
        <div class="tombol">
            <a href="{{route('registersiswa')}}" class="btn btn-primary">Siswa</a>
            <a href="{{route('registerguru')}}" class="btn btn-primary">Guru</a>
            <a href="{{route('registerwali')}}" class="btn btn-primary">Wali Kelas</a>
        </div>
    </form>

@endsection
