@extends('layout.dashboard-walikelas')

@section('container')
    <div class="container-fluid">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
            <h1 class="title mt-4">Detail Jawaban</h1>
        </div>

        @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif

        <table class="table">
            <thead>
            <tr>
                <th scope="col">Pertanyaan</th>
                <th scope="col">Jenis</th>
                <th scope="col">Kategori</th>
                <th scope="col">Nilai</th>
            </tr>
            </thead>
            <tbody>
            @foreach($hasil as $h)
             <tr>
                 <td>{{ $h->pertanyaan }}</td>
                 <td>{{ $h->jenis }}</td>
                 <td>{{ $h->kategori }}</td>
                 <td>{{ $h->jawaban }}</td>
             </tr>
            @endforeach
            </tbody>
        </table>
        <a href="{{url('wali/hasil-survey-wali')}}" class="btn btn-primary mt-14" style="margin-bottom: 40px">Kembali</a>
    </div>
@endsection
