@extends('layout/login')

@section('form')
    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif
    <h3>Login</h3>
    <form method="post" action="{{ route('login') }}">
        @csrf
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" class="form-control" id="exampleInputEmail1" name="email" aria-describedby="emailHelp" required>
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" class="form-control" id="exampleInputPassword1" name="password" required>
        </div>
        <div class="form-group form-check">
            <input type="checkbox" class="form-check-input" id="exampleCheck1">
            <label class="form-check-label" for="exampleCheck1">Ingatin password</label>
        </div>
        <button type="submit" class="btn btn-primary">Login</button>
    </form>
    <div class="daftar">
        <a href="{{'/register'}}">Belum punya akun? Daftar disini</a>
    </div>

@endsection
