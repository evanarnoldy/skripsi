@extends('layout/login')

@section('form')
    <h3>Daftar Sebagai</h3>
    <form>
        <div class="form-group">
            <label for="exampleInputEmail1">NIM</label>
            <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
        </div>
        <div class="form-group">
            <label for="exampleInputPassword1">Password</label>
            <input type="password" class="form-control" id="exampleInputPassword1">
        </div>
        <div class="form-group form-check">
            <input type="checkbox" class="form-check-input" id="exampleCheck1">
            <label class="form-check-label" for="exampleCheck1">Ingatin password</label>
        </div>
        <button type="submit" class="btn btn-primary">Login</button>
    </form>
    <div class="daftar">
        <a href="{{url('/admin')}}">Belum punya akun? Daftar disini</a>
    </div>

@endsection
