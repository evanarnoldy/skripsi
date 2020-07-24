@extends('layout/dashboard-siswa')

@section('container')
    <div class="container-fluid">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
            <h1 class="title mt-4">Grafik Kesehatan Mental dan Prestasi Belajar Siswa</h1>
        </div>

        <div class="container">
            <div id="chartksh">

            </div>
        </div>

        <div class="container">
            <div id="chart">

            </div>
        </div>
    </div>
@endsection

@section('footer')
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script>
        $('#chartksh').highcharts({
            chart: {
                type: 'column'
            },
            title: {
                text: 'Grafik Kesehatan Mental {{Auth::user()->nama}} Tahun {{date('Y')}}'
            },
            xAxis: {
                categories: {!! json_encode($bulanksh) !!},
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
                name: 'Kesehatan Mental',
                data: [{{implode(',',$nilai)}}]

            }]
        });

        //chart prestasi
        Highcharts.chart('chart', {

            title: {
                text: 'Grafik Prestasi Belajar {{Auth::user()->nama}} Tahun {{date('Y')}}'
            },

            yAxis: {
                min: 0,
                title: {
                    text: 'Nilai'
                }
            },

            xAxis: {
                categories: {!! json_encode($bulan) !!},
                crosshairs: true
            },

            legend: {
                layout: 'vertical',
                align: 'right',
                verticalAlign: 'middle'
            },

            plotOptions: {
                series: {
                    label: {
                        connectorAllowed: false
                    },
                }
            },

            series: [{
                name: 'Prestasi Belajar',
                data: [{{implode(',',$prestasi)}}],
            }],

            responsive: {
                rules: [{
                    condition: {
                        maxWidth: 500
                    },
                    chartOptions: {
                        legend: {
                            layout: 'horizontal',
                            align: 'center',
                            verticalAlign: 'bottom'
                        }
                    }
                }]
            }

        });
    </script>
@endsection
