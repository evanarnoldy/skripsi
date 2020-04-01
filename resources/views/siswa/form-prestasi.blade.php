@extends('layout.dashboard-siswa')

@section('container')
    <div class="container-fluid">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
            <h1 class="title mt-4">Form Prestasi Belajar</h1>
        </div>
        <form method="post" action="/store-prestasi">
            @csrf
            <div class="form-group">
                <label for="biologi">Biologi</label>
                <input type="text" class="form-control @error('biologi') is-invalid @enderror" id="biologi" name="biologi" placeholder="Masukkan Nilai Biologi" value="{{ old('biologi') }}">
                @error('biologi') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="form-group">
                <label for="kimia">Kimia</label>
                <input type="text" class="form-control @error('kimia') is-invalid @enderror" id="kimia" name="kimia" placeholder="Masukkan Nilai Kimia" value="{{ old('kimia') }}">
                @error('kimia') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="form-group">
                <label for="fisika">Fisika</label>
                <input type="text" class="form-control @error('fisika') is-invalid @enderror" id="fisika" name="fisika" placeholder="Masukkan Nilai Fisika" value="{{ old('fisika') }}">
                @error('fisika') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="form-group">
                <label for="matematika">Matematika</label>
                <input type="text" class="form-control @error('matematika') is-invalid @enderror" id="matematika" name="matematika" placeholder="Masukkan Nilai Matematika" value="{{ old('matematika') }}">
                @error('matematika') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="form-group">
                <label for="bhsind">Bahasa Indonesia</label>
                <input type="text" class="form-control @error('bhsind') is-invalid @enderror" id="bhsind" name="bhsind" placeholder="Masukkan Nilai Bahasa Indonesia" value="{{ old('bhsind') }}">
                @error('bhsind') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="form-group">
                <label for="bhsing">Bahasa Inggris</label>
                <input type="text" class="form-control @error('bhsing') is-invalid @enderror" id="bhsing" name="bhsing" placeholder="Masukkan Nilai Bahasa Inggris" value="{{ old('bhsing') }}">
                @error('bhsing') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <button type="submit" class="btn btn-primary">Selesai</button>
        </form>
    </div>
@endsection
