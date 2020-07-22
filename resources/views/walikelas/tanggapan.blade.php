@extends('layout.dashboard-walikelas')

@section('container')
    <div class="container-fluid">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
            <h1 class="title mt-4">Tanggapan</h1>
        </div>

        @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif

        <div class="card">
            <div class="card-header">
            </div>
            <div class="card-body">
                @foreach($data as $d)
                    <h5 class="bold">Nama siswa : {{$d->nama}}</h5>
                    <h5 class="bold">Isi keluhan : {{$d->isi}}</h5>
                @endforeach
            </div>
            <div class="card-footer text-muted">
            </div>
        </div>

        <form method="post" action="{{url('wali/send-tanggapan/'.$keluhan->id)}}">
            @csrf
            <div class="form-group">
                <label for="tanggapan">Silahkan tulis tanggapan</label>
                <textarea class="form-control @error('tanggapan') is-invalid @enderror" id="tanggapan" name="tanggapan" rows="5">
                </textarea>
                @error('tanggapan') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <button type="submit" class="btn btn-primary">Kirim</button>
        </form>
    </div>
@endsection
