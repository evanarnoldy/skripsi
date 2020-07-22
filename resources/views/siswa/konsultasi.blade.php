@extends('layout.dashboard-siswa')

@section('container')
    <div class="container-fluid">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
            <h1 class="title mt-4">Form Keluhan</h1>
        </div>

        @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif

        <form method="post" action="{{url('siswa/konsultasi')}}">
            @csrf
            <div class="form-group">
                <label for="konsultasi">Pilih penerima</label>
                <select class="custom-select my-1 mr-sm-2" id="inlineFormCustomSelectPref" name="penerima">
                    <option>Guru BK</option>
                    <option>Wali kelas</option>
                </select>
            </div>
            <div class="form-group">
                <label for="konsultasi">Silahkan tulis keluhan anda</label>
                <textarea class="form-control @error('konsultasi') is-invalid @enderror" id="konsultasi" name="konsultasi" rows="5">
                </textarea>
                @error('konsultasi') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <button type="submit" class="btn btn-primary">Kirim</button>
        </form>
    </div>
@endsection
