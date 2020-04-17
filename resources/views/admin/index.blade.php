@extends('layout/dashboard-admin')

@section('container')
    <div class="container-fluid">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
            <h1 class="title mt-4">Grafik Kesehatan Mental Sekolah</h1>
        </div>
        <div class="container">
            <div id="chart">

            </div>
        </div>
        <div class="ket">
            <p>Keterangan</p>
            <p>Jumlah siswa dengan hasil tinggi : {{$t}}</p>
            <p>Jumlah siswa dengan hasil sedang : {{$s}}</p>
            <p>Jumlah siswa dengan hasil rendah : {{$r}}</p>
            <p>Jumlah siswa yang sudah di survey : {{$jmlsiswa}}</p>
        </div>
    </div>
@endsection

@section('footer')
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script>
        // Radialize the colors
        Highcharts.setOptions({
            colors: Highcharts.map(Highcharts.getOptions().colors, function (color) {
                return {
                    radialGradient: {
                        cx: 0.5,
                        cy: 0.3,
                        r: 0.7
                    },
                    stops: [
                        [0, color],
                        [1, Highcharts.color(color).brighten(-0.3).get('rgb')] // darken
                    ]
                };
            })
        });

        // Build the chart
        Highcharts.chart('chart', {
            chart: {
                plotBackgroundColor: null,
                plotBorderWidth: null,
                plotShadow: false,
                type: 'pie'
            },
            title: {
                text: 'Grafik Kesehatan Mental Bulan {{$bulan1}} Tahun {{date('Y')}}'
            },
            tooltip: {
                pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
            },
            accessibility: {
                point: {
                    valueSuffix: '%'
                }
            },
            plotOptions: {
                pie: {
                    allowPointSelect: true,
                    cursor: 'pointer',
                    dataLabels: {
                        enabled: true,
                        format: '<b>{point.name}</b>: {point.percentage:.1f} %',
                        connectorColor: 'silver'
                    }
                }
            },
            series: [{
                name: 'Share',
                data: [
                    { name: 'Tinggi', y: {{$t}} },
                    { name: 'Sedang', y: {{$s}} },
                    { name: 'Rendah', y: {{$r}} },
                ]
            }]
        });
    </script>
@endsection
