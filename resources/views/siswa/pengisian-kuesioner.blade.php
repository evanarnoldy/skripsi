@extends('layout.dashboard-siswa')

@section('container')
    <div class="container-fluid">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
            <h1 class="title mt-4">Pengisian Kuesioner</h1>
        </div>

        @if (session('status'))
            <div class="alert alert-info">
                {{ session('status') }}
            </div>
        @endif

        <div class="alert alert-success">
            <p>Pengisian kuesioner hanya dilakukan setelah UAS dan UTS</p>
        </div>

        <table class="table table-bordered col-3">
            <thead>
            <tr>
                <th>Nilai</th>
                <th>Keterangan</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td>1</td>
                <td>Sangat tidak setuju</td>
            </tr>
            <tr>
                <td>2</td>
                <td>Tidak setuju</td>
            </tr>
            <tr>
                <td>3</td>
                <td>Setuju</td>
            </tr>
            <tr>
                <td>4</td>
                <td>Sangat setuju</td>
            </tr>
            </tbody>
        </table>

        <form method="post" action="{{url('siswa/store-kuesioner')}}" class="d-inline">
            @csrf
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
                         <div class="form-check form-check-inline">
                             <input class="form-check-input" type="radio" name="{{ $p->id }}" id="1" value="{{$p->jenis=='Favorable'?1:4}}" required>
                             <label class="form-check-label" for="inlineRadio1">1</label>
                             <input class="form-check-input" type="radio" name="{{ $p->id }}" id="2" value="{{$p->jenis=='Favorable'?2:3}}" required>
                             <label class="form-check-label" for="inlineRadio2">2</label>
                             <input class="form-check-input" type="radio" name="{{ $p->id }}" id="3" value="{{$p->jenis=='Favorable'?3:2}}" required>
                             <label class="form-check-label" for="inlineRadio3">3</label>
                             <input class="form-check-input" type="radio" name="{{ $p->id }}" id="4" value="{{$p->jenis=='Favorable'?4:1}}" required>
                             <label class="form-check-label" for="inlineRadio4">4</label>
                             <input type="hidden" name="jawaban[]" value="{{ $p->id }}" required>
                         </div>
                        </td>
                     </tr>
                @endforeach
            </tbody>
        </table>
            <button type="submit" class="btn btn-primary" style="margin-bottom: 40px">Selesai</button>
        </form>
    </div>
@endsection
