<!DOCTYPE html>

<html>

<head>
    <title>Bootstrap color picker Example</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-colorpicker/3.2.0/js/bootstrap-colorpicker.js">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-colorpicker/3.2.0/js/bootstrap-colorpicker.min.js">
    </script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-colorpicker/3.2.0/css/bootstrap-colorpicker.min.css" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-colorpicker/3.2.0/css/bootstrap-colorpicker.css" /> -->

    <script src="https://cdn.jsdelivr.net/npm/@jaames/iro@5"></script>
    <style>
        body {
            color: #ffffff;
            background: #171F30;
            line-height: 150%;
        }

        .wrap {
            min-height: 100vh;
            max-width: 720px;
            margin: 0 auto;
            display: flex;
            flex-direction: row;
            align-items: center;
            justify-content: center;
        }

        .half {
            width: 50%;
            padding: 32px 0;
        }

        .title {
            font-family: sans-serif;
            line-height: 24px;
            display: block;
            padding: 8px 0;
        }

        .readout {
            margin-top: 32px;
            line-height: 180%;
        }

        .colorSquare {
            height: 70px;
            width: 70px;
            background-color: red;
            border-radius: 10%;
            margin-bottom: 10px;
        }
    </style>
</head>

<body>


    <div class="card card-body">
        <h3>Kenyamanan</h3>
        <div id="2"></div>
    </div>
    <br>

    <!-- <div class="card card-body">
        <h3>Keamanan</h3>
        <div id="2"></div>
    </div>
    <br>

    <div class="card card-body">
        <h3>Kebersihan dan Keindahan</h3>
        <div id="3"></div>
    </div>
    <br>

    <div class="card card-body">
        <h3>Bus Kawasan SCBD</h3>
        <div id="4"></div>
    </div>
    <br>

    <div class="card card-body">
        <h3>Area Parkir</h3>
        <div id="5"></div>
    </div>
    <br>

    <div class="card card-body">
        <h3>Utility</h3>
        <div id="6"></div>
    </div>
    <br>

    <div class="card card-body">
        <h3>Petugas Keamanan dan Pengatur Lalu Lintas</h3>
        <div id="7"></div>
    </div>
    <br>

    <div class="card card-body">
        <h3>Health, Safety & Environment</h3>
        <div id="8"></div>
    </div>
    <br> -->



    @php
    $ci = get_instance();
    $rata_unsur = 4.028320313;
    $rata_harapan = 4.252929688;

    $grafik = $ci->db->query("SELECT *,
        (CASE
                    WHEN skor_unsur <= $rata_unsur && skor_harapan >= $rata_harapan
                            THEN 1
                    WHEN skor_unsur >= $rata_unsur && skor_harapan >= $rata_harapan
                            THEN 2
                        WHEN skor_unsur <= $rata_unsur && skor_harapan <= $rata_harapan
                            THEN 3
                        WHEN skor_unsur >= $rata_unsur && skor_harapan <= $rata_harapan
                            THEN 4
                    ELSE 0
                END) AS kuadran
                
        FROM test_kuadran")
    @endphp


    <table class="table table-bordered table-hover mt-8">
        <tr>
            <th class="text-center bg-light" width="30%" style="vertical-align: middle;">
                KUADRAN I</th>
            <td>
                <ul>
                    @foreach($grafik->result() as $row)
                    @if($row->kuadran == 1)
                    <li>{{$row->unsur}}</li>
                    @endif
                    @endforeach
                </ul>
            </td>
        </tr>
        <tr>
            <th class="text-center bg-light" width="30%" style="vertical-align: middle;">KUADRAN II</th>
            <td>
                <ul>
                    @foreach($grafik->result() as $row)
                    @if($row->kuadran == 2)
                    <li>{{$row->unsur}}</li>
                    @endif
                    @endforeach
                </ul>
            </td>
        </tr>
        <tr>
            <th class="text-center bg-light" width="30%" style="vertical-align: middle;">KUADRAN III
            </th>
            <td>
                <ul>
                    @foreach($grafik->result() as $row)
                    @if($row->kuadran == 3)
                    <li>{{$row->unsur}}</li>
                    @endif
                    @endforeach
                </ul>
            </td>
        </tr>
        <tr>
            <th class="text-center bg-light" width="30%" style="vertical-align: middle;">KUADRAN IV</th>
            <td>
                <ul>
                    @foreach($grafik->result() as $row)
                    @if($row->kuadran == 4)
                    <li>{{$row->unsur}}</li>
                    @endif
                    @endforeach
                </ul>
            </td>
        </tr>
    </table>


    <!-- <div class="wrap">
        <div class="half">
            <div class="colorPicker"></div>
        </div>
        <div class="half readout">
            <span class="title">Selected Color:</span>
            <div class="colorSquare" id="colorSquare"></div>
            <div id="values"></div>
            <input id="hexInput"></input>
        </div>
    </div>


    <script>
    var values = document.getElementById("values");
    var hexInput = document.getElementById("hexInput");
    let colorSquare = document.getElementById("colorSquare");
    var colorPicker = new iro.ColorPicker(".colorPicker", {
        width: 280,
        color: "rgb(255, 0, 0)",
        borderWidth: 1,
        borderColor: "#fff"
    });

    colorPicker.on(["color:init", "color:change"], function(color) {
        values.innerHTML = [
            "hex: " + color.hexString,
            "rgb: " + color.rgbString,
            "hsl: " + color.hslString
        ].join("<br>");

        hexInput.value = color.hexString;
        colorSquare.style.backgroundColor = color.hexString;
    });
    hexInput.addEventListener("change", function() {
        colorPicker.color.hexString = this.value;
    });
    </script> -->


    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous">
    </script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/highcharts/7.1.1/highcharts.js'></script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/react/16.8.6/umd/react.production.min.js'></script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/react-dom/16.8.6/umd/react-dom.production.min.js'></script>


    <script>
        Highcharts.chart('1', {
            chart: {
                type: 'scatter',
                plotBorderWidth: 1,
                zoomType: 'xy',
                height: 500,
                // width: 500
            },

            title: 'quadrant',
            legend: {
                enabled: false
            },
            tooltip: {
                pointFormat: '<span>{point.counter}</span>',
            },

            xAxis: {
                gridLineWidth: 0,
                startOnTick: true,
                endOnTick: true,
                crosshair: true,
                title: {
                    text: 'PERFORMANCE'
                },
                plotLines: [{
                    color: 'black',
                    dashStyle: 'dot',
                    width: 2,
                    value: 4.148239087, //GARIS BATAS NILAI X
                    zIndex: 3
                }],
            },

            yAxis: {
                gridLineWidth: 0,
                startOnTick: true,
                endOnTick: true,
                crosshair: true,
                title: {
                    text: 'IMPORTANCE'
                },
                maxPadding: 0.2,
                plotLines: [{
                    color: 'black',
                    dashStyle: 'dot',
                    width: 2,
                    value: 4.495758929, //GARIS BATAS NILAI Y
                    label: {
                        align: 'right',
                        style: {
                            fontStyle: 'italic'
                        },
                        x: -10
                    },
                    zIndex: 3
                }],
            },
            plotOptions: {
                series: {
                    dataLabels: {
                        defer: true,
                        enabled: true,
                        format: '{point.name}',
                        style: {
                            fontSize: '14px',
                            fontFamily: 'monospace',
                            color: 'black'
                            //  fontStyle: 'italic'
                        },
                    }
                }
            },
            series: [{
                data: [{
                        x: 4.29496527777778,
                        y: 4.55121527777778,
                        name: 'U1'
                    },
                    {
                        x: 4.26684027777778,
                        y: 4.50138888888889,
                        name: 'U2'
                    },
                    {
                        x: 4.27916666666667,
                        y: 4.48385416666667,
                        name: 'U3'
                    },
                    {
                        x: 4.40625,
                        y: 4.51840277777778,
                        name: 'U4'
                    },
                    {
                        x: 4.33576388888889,
                        y: 4.44774305555556,
                        name: 'U5'
                    },
                    {
                        x: 4.35538194444444,
                        y: 4.54149305555556,
                        name: 'U6'
                    },
                    {
                        x: 4.28697916666667,
                        y: 4.48559027777778,
                        name: 'U7'
                    },
                    {
                        x: 4.196875,
                        y: 4.54756944444444,
                        name: 'U8'
                    },
                    {
                        x: 4.05954861111111,
                        y: 4.60364583333333,
                        name: 'U9'
                    },
                    {
                        x: 3.97274305555556,
                        y: 4.49652777777778,
                        name: 'U10'
                    },
                    {
                        x: 4.25920138888889,
                        y: 4.47222222222222,
                        name: 'U11'
                    },
                    {
                        x: 3.93090277777778,
                        y: 4.58263888888889,
                        name: 'U12'
                    },
                    {
                        x: 3.68211805555556,
                        y: 4.30677083333333,
                        name: 'U13'
                    },
                    {
                        x: 3.74861111111111,
                        y: 4.4015625,
                        name: 'U14'
                    }

                ]
            }, {
                enableMouseTracking: false,
                linkedTo: 0,
                marker: {
                    enabled: false
                },
                dataLabels: {
                    defer: false,
                    enabled: true,
                    //  y: 20,
                    style: {
                        fontSize: '14px',
                        fontFamily: 'monospace',
                        color: 'black',
                        fontStyle: 'italic'
                    },
                    format: 'Kuadran {point.name}'
                },
                keys: ['x', 'y', 'name'],
                data: [
                    [(4.148239087 - 0.5), (4.495758929 + 0.5), 'I'],
                    [(4.148239087 + 0.5), (4.495758929 + 0.5), 'II'],
                    [(4.148239087 - 0.5), (4.495758929 - 0.5), 'III'],
                    [(4.148239087 + 0.5), (4.495758929 - 0.5), 'IV']

                ]
            }],

        });
    </script>


    <script>
        Highcharts.chart('2', {
            chart: {
                type: 'scatter',
                plotBorderWidth: 1,
                zoomType: 'xy',
                height: 500,
                // width: 500
            },

            title: 'quadrant',
            legend: {
                enabled: false
            },
            tooltip: {
                pointFormat: '<span>{point.counter}</span>',
            },

            xAxis: {
                gridLineWidth: 0,
                startOnTick: true,
                endOnTick: true,
                crosshair: true,
                title: {
                    text: 'PERFORMANCE'
                },
                plotLines: [{
                    color: 'black',
                    dashStyle: 'dot',
                    width: 2,
                    value: 4.191073495, //GARIS BATAS NILAI X
                    zIndex: 3
                }],
            },

            yAxis: {
                gridLineWidth: 0,
                startOnTick: true,
                endOnTick: true,
                crosshair: true,
                title: {
                    text: 'IMPORTANCE'
                },
                maxPadding: 0.2,
                plotLines: [{
                    color: 'black',
                    dashStyle: 'dot',
                    width: 2,
                    value: 4.50697338, //GARIS BATAS NILAI Y
                    label: {
                        align: 'right',
                        style: {
                            fontStyle: 'italic'
                        },
                        x: -10
                    },
                    zIndex: 3
                }],
            },
            plotOptions: {
                series: {
                    dataLabels: {
                        defer: true,
                        enabled: true,
                        format: '{point.name}',
                        style: {
                            fontSize: '14px',
                            fontFamily: 'monospace',
                            color: 'black'
                            //  fontStyle: 'italic'
                        },
                    }
                }
            },
            series: [{
                data: [{
                        x: 4.17743055555556,
                        y: 4.56892361111111,
                        name: 'U15'
                    },
                    {
                        x: 4.42881944444444,
                        y: 4.52534722222222,
                        name: 'U16'
                    },
                    {
                        x: 4.2046875,
                        y: 4.57274305555556,
                        name: 'U17'
                    },
                    {
                        x: 4.2203125,
                        y: 4.49826388888889,
                        name: 'U18'
                    },
                    {
                        x: 4.12552083333333,
                        y: 4.57951388888889,
                        name: 'U19'
                    },
                    {
                        x: 4.17378472222222,
                        y: 4.54756944444444,
                        name: 'U20'
                    },
                    {
                        x: 4.20520833333333,
                        y: 4.471875,
                        name: 'U21'
                    },
                    {
                        x: 4.32864583333333,
                        y: 4.4140625,
                        name: 'U22'
                    },
                    {
                        x: 4.20659722222222,
                        y: 4.51388888888889,
                        name: 'U23'
                    },
                    {
                        x: 4.2375,
                        y: 4.56388888888889,
                        name: 'U24'
                    },
                    {
                        x: 3.95104166666667,
                        y: 4.44722222222222,
                        name: 'U25'
                    },
                    {
                        x: 4.03333333333333,
                        y: 4.38038194444444,
                        name: 'U26'
                    },
                ]
            }, {
                enableMouseTracking: false,
                linkedTo: 0,
                marker: {
                    enabled: false
                },
                dataLabels: {
                    defer: false,
                    enabled: true,
                    //  y: 20,
                    style: {
                        fontSize: '14px',
                        fontFamily: 'monospace',
                        color: 'black',
                        fontStyle: 'italic'
                    },
                    format: 'Kuadran {point.name}'
                },
                keys: ['x', 'y', 'name'],
                data: [
                    [(4.191073495 - 0.5), (4.50697338 + 0.5), 'I'],
                    [(4.191073495 + 0.5), (4.50697338 + 0.5), 'II'],
                    [(4.191073495 - 0.5), (4.50697338 - 0.5), 'III'],
                    [(4.191073495 + 0.5), (4.50697338 - 0.5), 'IV']
                ]
            }],

        });
    </script>


    <script>
        Highcharts.chart('3', {
            chart: {
                type: 'scatter',
                plotBorderWidth: 1,
                zoomType: 'xy',
                height: 500,
                // width: 500
            },

            title: 'quadrant',
            legend: {
                enabled: false
            },
            tooltip: {
                pointFormat: '<span>{point.counter}</span>',
            },

            xAxis: {
                gridLineWidth: 0,
                startOnTick: true,
                endOnTick: true,
                crosshair: true,
                title: {
                    text: 'PERFORMANCE'
                },
                plotLines: [{
                    color: 'black',
                    dashStyle: 'dot',
                    width: 2,
                    value: 4.349479167, //GARIS BATAS NILAI X
                    zIndex: 3
                }],
            },

            yAxis: {
                gridLineWidth: 0,
                startOnTick: true,
                endOnTick: true,
                crosshair: true,
                title: {
                    text: 'IMPORTANCE'
                },
                maxPadding: 0.2,
                plotLines: [{
                    color: 'black',
                    dashStyle: 'dot',
                    width: 2,
                    value: 4.431051587, //GARIS BATAS NILAI Y
                    label: {
                        align: 'right',
                        style: {
                            fontStyle: 'italic'
                        },
                        x: -10
                    },
                    zIndex: 3
                }],
            },
            plotOptions: {
                series: {
                    dataLabels: {
                        defer: true,
                        enabled: true,
                        format: '{point.name}',
                        style: {
                            fontSize: '14px',
                            fontFamily: 'monospace',
                            color: 'black'
                            //  fontStyle: 'italic'
                        },
                    }
                }
            },
            series: [{
                data: [{
                        x: 4.40486111111111,
                        y: 4.575,
                        name: 'U27'
                    },
                    {
                        x: 4.49791666666667,
                        y: 4.50972222222222,
                        name: 'U28'
                    },
                    {
                        x: 4.3359375,
                        y: 4.33888888888889,
                        name: 'U29'
                    },
                    {
                        x: 4.26753472222222,
                        y: 4.30659722222222,
                        name: 'U30'
                    },
                    {
                        x: 4.421875,
                        y: 4.35972222222222,
                        name: 'U31'
                    },
                    {
                        x: 4.21371527777778,
                        y: 4.33628472222222,
                        name: 'U32'
                    },
                    {
                        x: 4.30451388888889,
                        y: 4.59114583333333,
                        name: 'U33'
                    }

                ]
            }, {
                enableMouseTracking: false,
                linkedTo: 0,
                marker: {
                    enabled: false
                },
                dataLabels: {
                    defer: false,
                    enabled: true,
                    //  y: 20,
                    style: {
                        fontSize: '14px',
                        fontFamily: 'monospace',
                        color: 'black',
                        fontStyle: 'italic'
                    },
                    format: 'Kuadran {point.name}'
                },
                keys: ['x', 'y', 'name'],
                data: [
                    [(4.349479167 - 0.5), (4.431051587 + 0.5), 'I'],
                    [(4.349479167 + 0.5), (4.431051587 + 0.5), 'II'],
                    [(4.349479167 - 0.5), (4.431051587 - 0.5), 'III'],
                    [(4.349479167 + 0.5), (4.431051587 - 0.5), 'IV']
                ]
            }],

        });
    </script>

    <script>
        Highcharts.chart('4', {
            chart: {
                type: 'scatter',
                plotBorderWidth: 1,
                zoomType: 'xy',
                height: 500,
                // width: 500
            },

            title: 'quadrant',
            legend: {
                enabled: false
            },
            tooltip: {
                pointFormat: '<span>{point.counter}</span>',
            },

            xAxis: {
                gridLineWidth: 0,
                startOnTick: true,
                endOnTick: true,
                crosshair: true,
                title: {
                    text: 'PERFORMANCE'
                },
                plotLines: [{
                    color: 'black',
                    dashStyle: 'dot',
                    width: 2,
                    value: 4.005237559, //GARIS BATAS NILAI X
                    zIndex: 3
                }],
            },

            yAxis: {
                gridLineWidth: 0,
                startOnTick: true,
                endOnTick: true,
                crosshair: true,
                title: {
                    text: 'IMPORTANCE'
                },
                maxPadding: 0.2,
                plotLines: [{
                    color: 'black',
                    dashStyle: 'dot',
                    width: 2,
                    value: 4.443373843, //GARIS BATAS NILAI Y
                    label: {
                        align: 'right',
                        style: {
                            fontStyle: 'italic'
                        },
                        x: -10
                    },
                    zIndex: 3
                }],
            },
            plotOptions: {
                series: {
                    dataLabels: {
                        defer: true,
                        enabled: true,
                        format: '{point.name}',
                        style: {
                            fontSize: '14px',
                            fontFamily: 'monospace',
                            color: 'black'
                            //  fontStyle: 'italic'
                        },
                    }
                }
            },
            series: [{
                data: [{
                        x: 4.12565381635025,
                        y: 4.46041666666667,
                        name: 'U34'
                    },
                    {
                        x: 4.30789576802508,
                        y: 4.49444444444444,
                        name: 'U35'
                    },
                    {
                        x: 4.21479885057471,
                        y: 4.53298611111111,
                        name: 'U36'
                    },
                    {
                        x: 3.74298559989668,
                        y: 4.47534722222222,
                        name: 'U37'
                    },
                    {
                        x: 3.7316285677386,
                        y: 4.37326388888889,
                        name: 'U38'
                    },
                    {
                        x: 4.00116234017823,
                        y: 4.40902777777778,
                        name: 'U39'
                    },
                    {
                        x: 3.84991282448663,
                        y: 4.45520833333333,
                        name: 'U40'
                    },
                    {
                        x: 4.0186055146584,
                        y: 4.40868055555556,
                        name: 'U41'
                    },
                    {
                        x: 4.08620689655172,
                        y: 4.46180555555556,
                        name: 'U42'
                    },
                    {
                        x: 4.02150214018192,
                        y: 4.45069444444444,
                        name: 'U43'
                    },
                    {
                        x: 4.11160887253003,
                        y: 4.45954861111111,
                        name: 'U44'
                    },
                    {
                        x: 3.85088951310861,
                        y: 4.3390625,
                        name: 'U45'
                    },

                ]
            }, {
                enableMouseTracking: false,
                linkedTo: 0,
                marker: {
                    enabled: false
                },
                dataLabels: {
                    defer: false,
                    enabled: true,
                    //  y: 20,
                    style: {
                        fontSize: '14px',
                        fontFamily: 'monospace',
                        color: 'black',
                        fontStyle: 'italic'
                    },
                    format: 'Kuadran {point.name}'
                },
                keys: ['x', 'y', 'name'],
                data: [
                    [(4.005237559 - 0.5), (4.443373843 + 0.5), 'I'],
                    [(4.005237559 + 0.5), (4.443373843 + 0.5), 'II'],
                    [(4.005237559 - 0.5), (4.443373843 - 0.5), 'III'],
                    [(4.005237559 + 0.5), (4.443373843 - 0.5), 'IV']
                ]
            }],

        });
    </script>

    <script>
        Highcharts.chart('5', {
            chart: {
                type: 'scatter',
                plotBorderWidth: 1,
                zoomType: 'xy',
                height: 500,
                // width: 500
            },

            title: 'quadrant',
            legend: {
                enabled: false
            },
            tooltip: {
                pointFormat: '<span>{point.counter}</span>',
            },

            xAxis: {
                gridLineWidth: 0,
                startOnTick: true,
                endOnTick: true,
                crosshair: true,
                title: {
                    text: 'PERFORMANCE'
                },
                plotLines: [{
                    color: 'black',
                    dashStyle: 'dot',
                    width: 2,
                    value: 3.840604575, //GARIS BATAS NILAI X
                    zIndex: 3
                }],
            },

            yAxis: {
                gridLineWidth: 0,
                startOnTick: true,
                endOnTick: true,
                crosshair: true,
                title: {
                    text: 'IMPORTANCE'
                },
                maxPadding: 0.2,
                plotLines: [{
                    color: 'black',
                    dashStyle: 'dot',
                    width: 2,
                    value: 4.508701728, //GARIS BATAS NILAI Y
                    label: {
                        align: 'right',
                        style: {
                            fontStyle: 'italic'
                        },
                        x: -10
                    },
                    zIndex: 3
                }],
            },
            plotOptions: {
                series: {
                    dataLabels: {
                        defer: true,
                        enabled: true,
                        format: '{point.name}',
                        style: {
                            fontSize: '14px',
                            fontFamily: 'monospace',
                            color: 'black'
                            //  fontStyle: 'italic'
                        },
                    }
                }
            },
            series: [{
                data: [{
                        x: 3.76862745098039,
                        y: 4.45966717479675,
                        name: 'U46'
                    },
                    {
                        x: 3.95952380952381,
                        y: 4.62557164634146,
                        name: 'U47'
                    },
                    {
                        x: 3.61904761904762,
                        y: 4.46830538617886,
                        name: 'U48'
                    },
                    {
                        x: 3.96190476190476,
                        y: 4.51606961382114,
                        name: 'U49'
                    },
                    {
                        x: 3.80059523809524,
                        y: 4.47345020325203,
                        name: 'U50'
                    },
                    {
                        x: 3.93392857142857,
                        y: 4.50914634146341,
                        name: 'U51'
                    }

                ]
            }, {
                enableMouseTracking: false,
                linkedTo: 0,
                marker: {
                    enabled: false
                },
                dataLabels: {
                    defer: false,
                    enabled: true,
                    //  y: 20,
                    style: {
                        fontSize: '14px',
                        fontFamily: 'monospace',
                        color: 'black',
                        fontStyle: 'italic'
                    },
                    format: 'Kuadran {point.name}'
                },
                keys: ['x', 'y', 'name'],
                data: [
                    [(3.840604575 - 0.5), (4.508701728 + 0.5), 'I'],
                    [(3.840604575 + 0.5), (4.508701728 + 0.5), 'II'],
                    [(3.840604575 - 0.5), (4.508701728 - 0.5), 'III'],
                    [(3.840604575 + 0.5), (4.508701728 - 0.5), 'IV']
                ]
            }],

        });
    </script>


    <script>
        Highcharts.chart('6', {
            chart: {
                type: 'scatter',
                plotBorderWidth: 1,
                zoomType: 'xy',
                height: 500,
                // width: 500
            },

            title: 'quadrant',
            legend: {
                enabled: false
            },
            tooltip: {
                pointFormat: '<span>{point.counter}</span>',
            },

            xAxis: {
                gridLineWidth: 0,
                startOnTick: true,
                endOnTick: true,
                crosshair: true,
                title: {
                    text: 'PERFORMANCE'
                },
                plotLines: [{
                    color: 'black',
                    dashStyle: 'dot',
                    width: 2,
                    value: 4.095982143, //GARIS BATAS NILAI X
                    zIndex: 3
                }],
            },

            yAxis: {
                gridLineWidth: 0,
                startOnTick: true,
                endOnTick: true,
                crosshair: true,
                title: {
                    text: 'IMPORTANCE'
                },
                maxPadding: 0.2,
                plotLines: [{
                    color: 'black',
                    dashStyle: 'dot',
                    width: 2,
                    value: 4.368303571, //GARIS BATAS NILAI Y
                    label: {
                        align: 'right',
                        style: {
                            fontStyle: 'italic'
                        },
                        x: -10
                    },
                    zIndex: 3
                }],
            },
            plotOptions: {
                series: {
                    dataLabels: {
                        defer: true,
                        enabled: true,
                        format: '{point.name}',
                        style: {
                            fontSize: '14px',
                            fontFamily: 'monospace',
                            color: 'black'
                            //  fontStyle: 'italic'
                        },
                    }
                }
            },
            series: [{
                data: [{
                        x: 4.125,
                        y: 4.40625,
                        name: 'U52'
                    },
                    {
                        x: 4.234375,
                        y: 4.453125,
                        name: 'U53'
                    },
                    {
                        x: 4.1875,
                        y: 4.359375,
                        name: 'U54'
                    },
                    {
                        x: 4.1875,
                        y: 4.34375,
                        name: 'U55'
                    },
                    {
                        x: 4.03125,
                        y: 4.34375,
                        name: 'U56'
                    },
                    {
                        x: 4.171875,
                        y: 4.234375,
                        name: 'U57'
                    },
                    {
                        x: 3.734375,
                        y: 4.4375,
                        name: 'U58'
                    }

                ]
            }, {
                enableMouseTracking: false,
                linkedTo: 0,
                marker: {
                    enabled: false
                },
                dataLabels: {
                    defer: false,
                    enabled: true,
                    //  y: 20,
                    style: {
                        fontSize: '14px',
                        fontFamily: 'monospace',
                        color: 'black',
                        fontStyle: 'italic'
                    },
                    format: 'Kuadran {point.name}'
                },
                keys: ['x', 'y', 'name'],
                data: [
                    [(4.095982143 - 0.5), (4.368303571 + 0.5), 'I'],
                    [(4.095982143 + 0.5), (4.368303571 + 0.5), 'II'],
                    [(4.095982143 - 0.5), (4.368303571 - 0.5), 'III'],
                    [(4.095982143 + 0.5), (4.368303571 - 0.5), 'IV']
                ]
            }],

        });
    </script>


    <script>
        Highcharts.chart('7', {
            chart: {
                type: 'scatter',
                plotBorderWidth: 1,
                zoomType: 'xy',
                height: 500,
                // width: 500
            },

            title: 'quadrant',
            legend: {
                enabled: false
            },
            tooltip: {
                pointFormat: '<span>{point.counter}</span>',
            },

            xAxis: {
                gridLineWidth: 0,
                startOnTick: true,
                endOnTick: true,
                crosshair: true,
                title: {
                    text: 'PERFORMANCE'
                },
                plotLines: [{
                    color: 'black',
                    dashStyle: 'dot',
                    width: 2,
                    value: 4.010416667, //GARIS BATAS NILAI X
                    zIndex: 3
                }],
            },

            yAxis: {
                gridLineWidth: 0,
                startOnTick: true,
                endOnTick: true,
                crosshair: true,
                title: {
                    text: 'IMPORTANCE'
                },
                maxPadding: 0.2,
                plotLines: [{
                    color: 'black',
                    dashStyle: 'dot',
                    width: 2,
                    value: 4.5078125, //GARIS BATAS NILAI Y
                    label: {
                        align: 'right',
                        style: {
                            fontStyle: 'italic'
                        },
                        x: -10
                    },
                    zIndex: 3
                }],
            },
            plotOptions: {
                series: {
                    dataLabels: {
                        defer: true,
                        enabled: true,
                        format: '{point.name}',
                        style: {
                            fontSize: '14px',
                            fontFamily: 'monospace',
                            color: 'black'
                            //  fontStyle: 'italic'
                        },
                    }
                }
            },
            series: [{
                data: [{
                        x: 4.03125,
                        y: 4.5625,
                        name: 'U59'
                    },
                    {
                        x: 4.140625,
                        y: 4.546875,
                        name: 'U60'
                    },
                    {
                        x: 3.828125,
                        y: 4.453125,
                        name: 'U61'
                    },
                    {
                        x: 4.109375,
                        y: 4.625,
                        name: 'U62'
                    },
                    {
                        x: 3.859375,
                        y: 4.375,
                        name: 'U63'
                    },
                    {
                        x: 4.09375,
                        y: 4.484375,
                        name: 'U64'
                    },

                ]
            }, {
                enableMouseTracking: false,
                linkedTo: 0,
                marker: {
                    enabled: false
                },
                dataLabels: {
                    defer: false,
                    enabled: true,
                    //  y: 20,
                    style: {
                        fontSize: '14px',
                        fontFamily: 'monospace',
                        color: 'black',
                        fontStyle: 'italic'
                    },
                    format: 'Kuadran {point.name}'
                },
                keys: ['x', 'y', 'name'],
                data: [
                    [(4.010416667 - 0.5), (4.5078125 + 0.5), 'I'],
                    [(4.010416667 + 0.5), (4.5078125 + 0.5), 'II'],
                    [(4.010416667 - 0.5), (4.5078125 - 0.5), 'III'],
                    [(4.010416667 + 0.5), (4.5078125 - 0.5), 'IV']
                ]
            }],

        });
    </script>


    <script>
        Highcharts.chart('8', {
            chart: {
                type: 'scatter',
                plotBorderWidth: 1,
                zoomType: 'xy',
                height: 500,
                // width: 500
            },

            title: 'quadrant',
            legend: {
                enabled: false
            },
            tooltip: {
                pointFormat: '<span>{point.counter}</span>',
            },

            xAxis: {
                gridLineWidth: 0,
                startOnTick: true,
                endOnTick: true,
                crosshair: true,
                title: {
                    text: 'PERFORMANCE'
                },
                plotLines: [{
                    color: 'black',
                    dashStyle: 'dot',
                    width: 2,
                    value: 4.028320313, //GARIS BATAS NILAI X
                    zIndex: 3
                }],
            },

            yAxis: {
                gridLineWidth: 0,
                startOnTick: true,
                endOnTick: true,
                crosshair: true,
                title: {
                    text: 'IMPORTANCE'
                },
                maxPadding: 0.2,
                plotLines: [{
                    color: 'black',
                    dashStyle: 'dot',
                    width: 2,
                    value: 4.252929688, //GARIS BATAS NILAI Y
                    label: {
                        align: 'right',
                        style: {
                            fontStyle: 'italic'
                        },
                        x: -10
                    },
                    zIndex: 3
                }],
            },
            plotOptions: {
                series: {
                    dataLabels: {
                        defer: true,
                        enabled: true,
                        format: '{point.name}',
                        style: {
                            fontSize: '14px',
                            fontFamily: 'monospace',
                            color: 'black'
                            //  fontStyle: 'italic'
                        },
                    }
                }
            },
            series: [{
                data: [{
                        x: 3.953125,
                        y: 4.328125,
                        name: 'U65'
                    },
                    {
                        x: 4.265625,
                        y: 4.390625,
                        name: 'U66'
                    },
                    {
                        x: 4.0625,
                        y: 4.234375,
                        name: 'U67'
                    },
                    {
                        x: 4.15625,
                        y: 4.421875,
                        name: 'U68'
                    },
                    {
                        x: 4.375,
                        y: 4.265625,
                        name: 'U69'
                    },
                    {
                        x: 4.125,
                        y: 4.234375,
                        name: 'U70'
                    },
                    {
                        x: 4.234375,
                        y: 4.109375,
                        name: 'U71'
                    },
                    {
                        x: 4.1875,
                        y: 4.125,
                        name: 'U72'
                    },
                    {
                        x: 4.078125,
                        y: 4.21875,
                        name: 'U73'
                    },
                    {
                        x: 3.703125,
                        y: 4.140625,
                        name: 'U74'
                    },
                    {
                        x: 3.234375,
                        y: 3.96875,
                        name: 'U75'
                    },
                    {
                        x: 4.0625,
                        y: 4.4375,
                        name: 'U76'
                    },
                    {
                        x: 4.171875,
                        y: 4.359375,
                        name: 'U77'
                    },
                    {
                        x: 3.890625,
                        y: 4.1875,
                        name: 'U78'
                    },
                    {
                        x: 3.9375,
                        y: 4.34375,
                        name: 'U79'
                    },
                    {
                        x: 4.015625,
                        y: 4.28125,
                        name: 'U80'
                    }

                ]
            }, {
                enableMouseTracking: false,
                linkedTo: 0,
                marker: {
                    enabled: false
                },
                dataLabels: {
                    defer: false,
                    enabled: true,
                    //  y: 20,
                    style: {
                        fontSize: '14px',
                        fontFamily: 'monospace',
                        color: 'black',
                        fontStyle: 'italic'
                    },
                    format: 'Kuadran {point.name}'
                },
                keys: ['x', 'y', 'name'],
                data: [
                    [(4.028320313 - 0.5), (4.252929688 + 0.5), 'I'],
                    [(4.028320313 + 0.5), (4.252929688 + 0.5), 'II'],
                    [(4.028320313 - 0.5), (4.252929688 - 0.5), 'III'],
                    [(4.028320313 + 0.5), (4.252929688 - 0.5), 'IV']
                ]
            }],

        });
    </script>

</body>

</html>