@extends('layout/dashboard-walikelas')

@section('container')
    <div class="container-fluid">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
            <h1 class="title mt-4">Grafik Monitoring Korelasi Antara Kesehatan Mental dan Prestasi Belajar Kelas {{auth()->user()->kelas_diampu}}{{auth()->user()->unit}}</h1>
        </div>

        <div class="row" style="margin-bottom: 15px">
            <div class="col">
                <form class="form-inline" method="get" action="{{url('wali/filter-indexkor')}}">
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
                <div class="col" id="chart">

                </div>
                <div class="col" id="chartkor">

                </div>
            </div>
        </div>
    </div>
@endsection

@section('footer')
    <script src="{{asset('js/highcharts.js')}}"></script>
    <script>
        //chart korelasi
        $('#chart').highcharts({
            chart: {
                type: 'column'
            },
            title: {
                text: 'Grafik Perkembangan Kesehatan Mental dan Prestasi Belajar Kelas {{auth()->user()->kelas_diampu}}{{auth()->user()->unit}} Bulan {{$bulan1}} Tahun {{$tahun1}}'
            },
            xAxis: {
                categories: [
                    'Tinggi', 'Sedang', 'Rendah'
                ],
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
                name: 'Prestasi Belajar',
                data: [{{$tpb}}, {{$spb}}, {{$rpb}}]

            }, {
                name: 'Kesehatan Mental',
                data: [{{$t}}, {{$s}}, {{$r}}]

            }]
        });

        $('#chartkor').highcharts({
            chart: {
                type: 'column'
            },
            title: {
                text: 'Grafik Korelasi Kelas {{auth()->user()->kelas_diampu}}{{auth()->user()->unit}} Tahun {{$tahun1}}'
            },
            xAxis: {
                categories: {!! json_encode($blnkor) !!},
                crosshair: true
            },
            yAxis: {
                min: 0,
                title: {
                    text: 'Nilai'
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
                name: 'Korelasi',
                data: [{{implode(',',$nilai)}}]

            }]
        });
    </script>
@endsection
