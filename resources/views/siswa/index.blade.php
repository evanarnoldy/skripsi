@extends('layout/dashboard-siswa')

@section('container')
    <div class="container-fluid">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
            <h1 class="title mt-4">Grafik Kesehatan Mental Siswa</h1>
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
        Highcharts.chart('chart', {

            title: {
                text: 'Grafik Kesehatan Mental {{Auth::user()->nama}} Tahun {{date('Y')}}'
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
                name: 'Nilai',
                data: {!! json_encode($nilai) !!},
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
