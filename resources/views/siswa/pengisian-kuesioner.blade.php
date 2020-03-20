@extends('layout.dashboard-siswa')

@section('container')
    <div class="container-fluid">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
            <h1 class="title mt-4">Pengisian Kuesioner</h1>
        </div>

        @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif

        <table class="table">
            <thead>
            <tr>
                <th scope="col">Nomor</th>
                <th scope="col">Pertanyaan</th>
                <th scope="col">Jawaban</th>
            </tr>
            </thead>
            <tbody>
            @foreach($pertanyaan as $p)
             <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $p->pertanyaan }}</td>
                <td>
                    <form method="post" action="/daftar-pertanyaan/{{ $p->id }}" class="d-inline">
                        @csrf
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="inlineRadioOptions" id="1" value="1">
                            <label class="form-check-label" for="inlineRadio1">1</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="inlineRadioOptions" id="2" value="2">
                            <label class="form-check-label" for="inlineRadio2">2</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="inlineRadioOptions" id="3" value="3">
                            <label class="form-check-label" for="inlineRadio3">3</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="inlineRadioOptions" id="4" value="4">
                            <label class="form-check-label" for="inlineRadio4">4</label>
                        </div>
                    </form>
                </td>
             </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
