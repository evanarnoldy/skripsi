@extends('layout/dashboard-walikelas')

@section('container')
    <div class="container-fluid">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
            <h1 class="title mt-4">Grafik Monitoring Kesehatan Mental Kelas {{auth()->user()->kelas_diampu}}{{auth()->user()->unit}}</h1>
        </div>

        <div class="row" style="margin-bottom: 15px">
            <div class="col">
                <form class="form-inline" method="get" action="{{url('wali/filter-indexksh')}}">
                    <select class="custom-select my-1 mr-sm-2" id="inlineFormCustomSelectPref" name="bulan">
                        <option selected>Pilih bulan</option>
                        @foreach($bln as $b)
                            <option>{{$b->bulan}}</option>
                        @endforeach
                    </select>

                    <select class="custom-select my-1 mr-sm-2" id="inlineFormCustomSelectPref" name="tahun">
                        <option selected>Pilih tahun</option>
                        @foreach($thn as $b)
                            <option>{{$b->tahun}}</option>
                        @endforeach
                    </select>
                    <button type="submit" class="btn btn-primary my-1">Cari</button>
                </form>
            </div>
        </div>

        <div class="container">
            <div class="row">
                <div class="col" id="chartksh">

                </div>
            </div>
        </div>
    </div>
@endsection

@section('footer')
    <script src="{{asset('js/highcharts.js')}}"></script>
    <script>
        $('#chartksh').highcharts({
            chart: {
                type: 'column'
            },
            title: {
                @if($getbulan == 'Pilih bulan' && $gettahun == 'Pilih tahun')
                text: 'Grafik Kesehatan Mental Kelas {{auth()->user()->kelas_diampu}}{{auth()->user()->unit}} Bulan {{$bulan1}} Tahun {{$tahun1}}',
                @elseif($getbulan != 'Pilih bulan' && $gettahun != 'Pilih tahun')
                text: 'Grafik Kesehatan Mental Kelas {{auth()->user()->kelas_diampu}}{{auth()->user()->unit}} Bulan {{$getbulan}} Tahun {{$gettahun}}',
                @elseif($getbulan != 'Pilih bulan' && $gettahun == 'Pilih tahun')
                text: 'Grafik Kesehatan Mental Kelas {{auth()->user()->kelas_diampu}}{{auth()->user()->unit}} Bulan {{$getbulan}} Tahun {{$tahun1}}',
                @elseif($getbulan == 'Pilih bulan' && $gettahun != 'Pilih tahun')
                text: 'Grafik Kesehatan Mental Kelas {{auth()->user()->kelas_diampu}}{{auth()->user()->unit}} Bulan {{$bulan1}} Tahun {{$gettahun}}'
                @endif
            },
            xAxis: {
                categories: ['Tinggi', 'Sedang', 'Rendah'],
                crosshair: true
            },
            yAxis: {
                min: 0,
                title: {
                    text: 'Jumlah'
                }
            },
            tooltip: {
                headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
                pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                    '<td style="padding:0"><b>{point.y}</b></td></tr>',
                footerFormat: '</table>',
                shared: true,
                useHTML: true
            },
            plotOptions: {
                column: {
                    pointPadding: 0.2,
                    borderWidth: 0
                }
            },
            series: [{
                name: 'Kesehatan Mental',
                data: [{{$t}}, {{$s}}, {{$r}}]
            }]
        });
    </script>
@endsection
