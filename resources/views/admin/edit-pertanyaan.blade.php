@extends('layout.dashboard-admin')

@section('container')
    <div class="container-fluid">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
            <h1 class="title mt-4">Form Ubah Pertanyaan</h1>
        </div>
        <form method="post" action="/daftar-pertanyaan/{{ $question->id }}">
            @method('patch')
            @csrf
            <div class="form-group">
                <label for="pertanyaan">Pertnyaan</label>
                <input type="text" class="form-control @error('pertanyaan') is-invalid @enderror" id="pertanyaan" name="pertanyaan" placeholder="Masukkan Pertanyaan" value="{{ $question->pertanyaan }}">
                @error('pertanyaan') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="form-group">
                <label for="jenis">Jenis Pertanyaan</label>
                <select type="text" class="form-control @error('jenis') is-invalid @enderror" id="jenis" name="jenis" placeholder="Masukkan Jenis Pertanyaan" value="{{ $question->jenis }}">
                @error('jenis') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    <option>Favorable</option>
                    <option>Unfavorable</option>
                </select>
            </div>
            <div class="form-group">
                <label for="kategori">Kategori Pertanyaan</label>
                <select type="text" class="form-control @error('kategori') is-invalid @enderror" id="kategori" name="kategori" placeholder="Masukkan Kategori Pertanyaan" value="{{ $question->kategori }}">
                    @error('jenis') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    <option>Having</option>
                    <option>Loving</option>
                    <option>Being</option>
                    <option>Health status</option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Ubah Data</button>
        </form>
    </div>
@endsection
