@extends('layout/login')

@section('form')
    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @elseif (session('failed'))
        <div class="alert alert-danger">
            {{ session('failed') }}
        </div>
    @endif
    <h3>Login</h3>
    <form method="post" action="{{ route('login') }}">
        @csrf
        <div class="form-group">
            <label for="nis">NISN/NIP</label>
            <input type="text" class="form-control @error('nis') is-invalid @enderror" id="exampleInputEmail1" name="nis" aria-describedby="emailHelp" value="{{ old('email') }}" required>
            @error('nis') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" class="form-control @error('password') is-invalid @enderror" id="exampleInputPassword1" name="password" required>
            @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>
        <button type="submit" class="btn btn-primary">Login</button>
    </form>

@endsection
