@extends('layout/dashboard-guru')

@section('container')
    <div class="container-fluid">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
            <h1 class="title mt-4">Grafik Kesehatan Mental dan Prestasin Belajar Sekolah</h1>
        </div>

        <div class="row" style="margin-bottom: 15px">
            <div class="col">
                <form class="form-inline" method="get" action="{{url('guru/filter-indexguru')}}">
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

        <div class="container d-inline">
            <div class="row">
                <div class="col" id="chart">

                </div>
                <div class="col" id="chartpb">

                </div>
            </div>
            <div class="container" id="chartkor">

            </div>
        </div>
{{--        <div class="ket">--}}
{{--            <p>Keterangan</p>--}}
{{--            <p>Jumlah siswa dengan hasil tinggi : {{$t}}</p>--}}
{{--            <p>Jumlah siswa dengan hasil sedang : {{$s}}</p>--}}
{{--            <p>Jumlah siswa dengan hasil rendah : {{$r}}</p>--}}
{{--            <p>Jumlah siswa yang sudah di survey : {{$jmlsiswa}}</p>--}}
{{--        </div>--}}
    </div>
@endsection

@section('footer')
    <script src="{{'/js/highcharts.js'}}"></script>
    <script type="text/javascript">
        $(function () {
            //chart kesehatan mental
            var pieChart;
            $(document).ready(function () {
                pieChart = new Highcharts.Chart({
                    chart: {
                        renderTo: 'chart',
                        plotBackgroundColor: null,
                        plotBorderWidth: null,
                        plotShadow: false
                    },

                    title: {
                        @if($getbulan == 'Pilih bulan' && $gettahun == 'Pilih tahun')
                            text: 'Grafik Kesehatan Mental Bulan {{$bulan1}} Tahun {{$tahun}}',
                        @elseif($getbulan != 'Pilih bulan' && $gettahun != 'Pilih tahun')
                            text: 'Grafik Kesehatan Mental Bulan {{$getbulan}} Tahun {{$gettahun}}',
                        @elseif($getbulan != 'Pilih bulan' && $gettahun == 'Pilih tahun')
                        text: 'Grafik Kesehatan Mental Bulan {{$getbulan}} Tahun {{$tahun}}',
                        @elseif($getbulan == 'Pilih bulan' && $gettahun != 'Pilih tahun')
                        text: 'Grafik Kesehatan Mental Bulan {{$bulan1}} Tahun {{$gettahun}}'
                        @endif
                    },

                    subtitle: {
                        text: ' Pie Chart'
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
                            },
                            showInLegend: true
                        }
                    },

                    series: [{
                        type: 'pie',
                        name: 'Jumlah',
                        data: [
                            { name: 'Tinggi', y: {{$t}} },
                            { name: 'Sedang', y: {{$s}} },
                            { name: 'Rendah', y: {{$r}} },
                        ]
                    }]


                });

            });
        });
            <!--Pie chart ends here-->

        //chart prestasi
        var pieChart;
        $(document).ready(function () {
            pieChart = new Highcharts.Chart({
                chart: {
                    renderTo: 'chartpb',
                    plotBackgroundColor: null,
                    plotBorderWidth: null,
                    plotShadow: false
                },

                title: {
                    @if($getbulan == 'Pilih bulan' && $gettahun == 'Pilih tahun')
                    text: 'Grafik Prestasi Belajar Bulan {{$bulan1}} Tahun {{$tahun}}',
                    @elseif($getbulan != 'Pilih bulan' && $gettahun != 'Pilih tahun')
                    text: 'Grafik Prestasi Belajar Bulan {{$getbulan}} Tahun {{$gettahun}}',
                    @elseif($getbulan != 'Pilih bulan' && $gettahun == 'Pilih tahun')
                    text: 'Grafik Prestasi Belajar Bulan {{$getbulan}} Tahun {{$tahun}}',
                    @elseif($getbulan == 'Pilih bulan' && $gettahun != 'Pilih tahun')
                    text: 'Grafik Prestasi Belajar Bulan {{$bulan1}} Tahun {{$gettahun}}'
                    @endif
                },

                subtitle: {
                    text: ' Pie Chart'
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
                        },
                        showInLegend: true
                    }
                },

                series: [{
                    type: 'pie',
                    name: 'Jumlah',
                    data: [
                        { name: 'Tinggi', y: {{$tpb}} },
                        { name: 'Sedang', y: {{$spb}} },
                        { name: 'Rendah', y: {{$rpb}} },
                    ]
                }]


            });

        });

        //chart korelasi
        $('#chartkor').highcharts({
            chart: {
                type: 'column'
            },
            title: {
                @if($getbulan == 'Pilih bulan' && $gettahun == 'Pilih tahun')
                text: 'Grafik Kesehatan Mental dan Prestasi Belajar {{$bulan1}} Tahun {{$tahun}}',
                @elseif($getbulan != 'Pilih bulan' && $gettahun != 'Pilih tahun')
                text: 'Grafik Kesehatan Mental dan Prestasi Belajar {{$getbulan}} Tahun {{$gettahun}}',
                @elseif($getbulan != 'Pilih bulan' && $gettahun == 'Pilih tahun')
                text: 'Grafik Kesehatan Mental dan Prestasi Belajar {{$getbulan}} Tahun {{$tahun}}',
                @elseif($getbulan == 'Pilih bulan' && $gettahun != 'Pilih tahun')
                text: 'Grafik Kesehatan Mental dan Prestasi Belajar {{$bulan1}} Tahun {{$gettahun}}',
                @endif
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
    </script>
@endsection
