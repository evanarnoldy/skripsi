@extends('layout.dashboard-admin')

@section('container')
    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @elseif(session('failed'))
        <div class="alert alert-danger">
            {{ session('failed') }}
        </div>
    @endif

    <form method="post" action="{{ route('psswrd-guru.update')}}">
        @csrf
        <div class="form-group">
            <label for="password">Password sekarang</label>
            <input type="password" class="form-control @error('current-password') is-invalid @enderror" id="password" name="current-password" placeholder="Masukkan Password sekarang" value="">
            @error('current-password') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>
        <div class="form-group">
            <label for="password">Password baru</label>
            <input type="password" class="form-control @error('new-password') is-invalid @enderror" id="password" name="new-password" placeholder="Masukkan Password baru" value="">
            @error('new-password') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>
        <div class="form-group">
            <label for="password_confirmation">Confirm Password</label>
            <input type="password" class="form-control @error('new-password_confirmation') is-invalid @enderror" id="confirm_password" name="new-password_confirmation" placeholder="Konfirmasi Password" value="">
            @error('new-password_confirmation') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>
        <button type="submit" class="btn btn-primary">Daftar</button>
    </form>
@endsection
