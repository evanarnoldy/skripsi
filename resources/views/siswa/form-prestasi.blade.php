@extends('layout.dashboard-admin')

@section('container')
    <div class="container-fluid">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
            <h1 class="title mt-4">Form Prestasi Belajar</h1>
        </div>
        <form method="post" action="{{url('admin/store-prestasi/'.$student->id)}}">
            @csrf
            <div class="form-group">
                <label for="ipa">Ipa</label>
                <input type="text" class="form-control @error('ipa') is-invalid @enderror" id="ipa" name="ipa" placeholder="Masukkan Nilai Ipa" value="{{ old('ipa') }}">
                @error('ipa') <div class="invalid-feedback">{{ $message }}</div> @enderror
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
