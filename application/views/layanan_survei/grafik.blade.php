@extends('include_backend/template_backend')

@php
$ci = get_instance();
@endphp

@section('style')
<link href="{{ TEMPLATE_BACKEND_PATH }}plugins/custom/datatables/datatables.bundle.css" rel="stylesheet" type="text/css" />



<style type="text/css">
    [pointer-events="bounding-box"] {
        display: none
    }
</style>

@endsection

@section('content')

<div class="container-fluid">
    @include("include_backend/partials_no_aside/_inc_menu_repository")

    <div class="row mt-5" data-aos="fade-down">
        <div class="col-md-3">
            @include('manage_survey/menu_data_survey')
        </div>
        <div class="col-md-9">

            <!-- <button onclick="get_canvas()">Convert</button> -->
            <!-- <div id="root"></div>
            <br> -->

            <div class="card card-custom card-sticky mb-5">
                <div class="card-body">

                    <div class="d-flex justify-content-center" id="chart"></div>
                    <br>

                    <table class="table table-bordered table-striped example" style="width:100%">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Kelompok</th>
                                <th>Jumlah</th>
                                <th>Persentase</th>
                                <th>Nilai Indeks</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                            $layanan = $ci->db->query("SELECT *
                            FROM (SELECT *,
                            (SELECT COUNT(*) FROM survey_$table_identity WHERE is_submit = 1) AS total_survei,
                            (SELECT COUNT(*) FROM responden_$table_identity JOIN survey_$table_identity ON responden_$table_identity.id = survey_$table_identity.id_responden WHERE layanan_survei_$table_identity.id = responden_$table_identity.id_layanan_survei && is_submit = 1) AS perolehan
                            FROM layanan_survei_$table_identity
                            WHERE is_active = 1
                            ) ls_$table_identity
                            ORDER BY urutan ASC");
                            @endphp

                            @php
                            $no = 1;
                            @endphp
                            @foreach ($layanan->result() as $value)

                            <tr>
                                <td>{{$no++}}</td>
                                <td>{{$value->nama_layanan}}</td>
                                <td>{{$value->perolehan}}</th>
                                <td>{{ ($value->perolehan / $value->total_survei) * 100}} %</td>
                                <td>
                                {{ROUND(
                                    $ci->db->query("SELECT AVG(rata_rata) AS rata_rata
                                        FROM (
                                        SELECT nama_unsur_pelayanan,
                                        IF(id_parent = 0, unsur_pelayanan_$table_identity.id, unsur_pelayanan_$table_identity.id_parent) AS id_sub,
                                        AVG(IF(jawaban_pertanyaan_unsur_$table_identity.skor_jawaban != 0, skor_jawaban, NULL)) AS rata_rata

                                        FROM jawaban_pertanyaan_unsur_$table_identity
                                        JOIN pertanyaan_unsur_pelayanan_$table_identity ON jawaban_pertanyaan_unsur_$table_identity.id_pertanyaan_unsur = pertanyaan_unsur_pelayanan_$table_identity.id
                                        JOIN unsur_pelayanan_$table_identity ON pertanyaan_unsur_pelayanan_$table_identity.id_unsur_pelayanan = unsur_pelayanan_$table_identity.id JOIN survey_$table_identity ON jawaban_pertanyaan_unsur_$table_identity.id_responden = survey_$table_identity.id_responden
                                        JOIN responden_$table_identity ON responden_$table_identity.id = survey_$table_identity.id_responden
                                        WHERE survey_$table_identity.is_submit = 1 AND responden_$table_identity.id_layanan_survei = 1
                                        GROUP BY id_sub
                                        ORDER BY SUBSTR(nomor_unsur,2) + 0
                                        ) ni")->row()->rata_rata
                                    ,3)}}
                                </td>
                            </tr>
                            @endforeach

                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('javascript')
<script src="https://cdn.fusioncharts.com/fusioncharts/latest/fusioncharts.js"></script>

<script src="{{ base_url() }}assets/vendor/fusioncharts-suite-xt/js/themes/fusioncharts.theme.accessibility.js">
</script>
<script src="{{ base_url() }}assets/vendor/fusioncharts-suite-xt/js/themes/fusioncharts.theme.candy.js"></script>
<script src="{{ base_url() }}assets/vendor/fusioncharts-suite-xt/js/themes/fusioncharts.theme.carbon.js"></script>
<script src="{{ base_url() }}assets/vendor/fusioncharts-suite-xt/js/themes/fusioncharts.theme.fint.js"></script>
<script src="{{ base_url() }}assets/vendor/fusioncharts-suite-xt/js/themes/fusioncharts.theme.fusion.js"></script>
<script src="{{ base_url() }}assets/vendor/fusioncharts-suite-xt/js/themes/fusioncharts.theme.gammel.js"></script>
<script src="{{ base_url() }}assets/vendor/fusioncharts-suite-xt/js/themes/fusioncharts.theme.ocean.js"></script>
<script src="{{ base_url() }}assets/vendor/fusioncharts-suite-xt/js/themes/fusioncharts.theme.umber.js"></script>
<script src="{{ base_url() }}assets/vendor/fusioncharts-suite-xt/js/themes/fusioncharts.theme.zune.js"></script>


<script src="{{ TEMPLATE_BACKEND_PATH }}plugins/custom/datatables/datatables.bundle.js"></script>


<script>
    $(document).ready(function() {
        $('.example').DataTable({
            "lengthMenu": [
                [10, 25, 50, 100, -1],
                [10, 25, 50, 100, "Semua data"]
            ],
            "pageLength": 10
        });
    });
</script>


@php
if ($layanan->num_rows() <= 20) { $tinggi_chart="500" ; } else if ($layanan->num_rows() <= 50) { $tinggi_chart="1000" ; } else if ($layanan->num_rows() <= 100) { $tinggi_chart="2000" ; }else if ($layanan->num_rows() <= 200) { $tinggi_chart="4000" ; }else if ($layanan->num_rows() <= 300) { $tinggi_chart="6000" ; }else if ($layanan->num_rows() <= 400) { $tinggi_chart="8000" ; }else if ($layanan->num_rows() <= 500) { $tinggi_chart="100000" ; } else { $tinggi_chart="1000" ; } @endphp <script>
                            FusionCharts.ready(function() {
                            var myChart = new FusionCharts({
                            "type": "bar3d",
                            "renderAt": "chart",
                            "width": "100%",
                            "height": "<?= $tinggi_chart ?>",
                            "dataFormat": "json",
                            'limit': 500,
                            dataSource: {
                            "chart": {
                            caption: "Layanan Survei",
                            subcaption: "Jenis Barang/Jasa yang di Survei",
                            "enableSmartLabels": "1",
                            "startingAngle": "0",
                            "showPercentValues": "1",
                            "decimals": "2",
                            "useDataPlotColorForLabels": "1",
                            // "theme": "umber",
                            // "bgColor": "#ffffff",

                            theme: "fusion"
                            },
                            "data": [
                            <?php foreach ($layanan->result() as $value) { ?> {
                                "label": "<?= $value->nama_layanan ?>",
                                "value": "<?= ROUND(
                                    $ci->db->query("SELECT SUM(rata_rata_bobot) AS rata_rata
                                    FROM (SELECT
                                    nama_unsur_pelayanan,
                                    IF(id_parent = 0, unsur_pelayanan_$table_identity.id, unsur_pelayanan_$table_identity.id_parent) AS id_sub,

                                    ((SUM(skor_jawaban)/COUNT(DISTINCT survey_$table_identity.id_responden))/(COUNT(id_parent)/COUNT(DISTINCT survey_$table_identity.id_responden))) AS nilai,

                                    (((SUM(skor_jawaban)/COUNT(DISTINCT survey_$table_identity.id_responden))/(COUNT(id_parent)/COUNT(DISTINCT survey_$table_identity.id_responden)))/(SELECT COUNT(id) FROM unsur_pelayanan_$table_identity WHERE id_parent = 0)) AS rata_rata_bobot


                                    FROM jawaban_pertanyaan_unsur_$table_identity
                                    JOIN pertanyaan_unsur_pelayanan_$table_identity ON jawaban_pertanyaan_unsur_$table_identity.id_pertanyaan_unsur = pertanyaan_unsur_pelayanan_$table_identity.id
                                    JOIN unsur_pelayanan_$table_identity ON pertanyaan_unsur_pelayanan_$table_identity.id_unsur_pelayanan = unsur_pelayanan_$table_identity.id
                                    JOIN survey_$table_identity ON jawaban_pertanyaan_unsur_$table_identity.id_responden = survey_$table_identity.id_responden JOIN responden_$table_identity ON responden_$table_identity.id = survey_$table_identity.id_responden
                                    WHERE survey_$table_identity.is_submit = 1 AND responden_$table_identity.id_layanan_survei = $value->id
                                    GROUP BY id_sub) ni")->row()->rata_rata
                                    ,3) ?>"
                                },
                            <?php } ?>
                            ]
                            }

                            });
                            myChart.render();
                            });
                            </script>


                            <script>
                                $('.toggle_dash').change(function() {

                                    var mode = $(this).prop('checked');
                                    var nilai_id = $(this).val();

                                    $.ajax({
                                        type: 'POST',
                                        dataType: 'JSON',
                                        url: "{{ base_url() }}{{ $ci->session->userdata('username') }}/{{ $ci->uri->segment(2) }}/update-chart-layanan",
                                        data: {
                                            'mode': mode,
                                            'nilai_id': nilai_id
                                        },
                                        success: function(data) {
                                            var data = eval(data);
                                            message = data.message;
                                            success = data.success;

                                            Swal.fire(
                                                'Mode Chart Berhasil di Ubah',
                                                message,
                                                'success'
                                            ).then(function() {
                                                location.reload();
                                            })
                                        }
                                    });

                                });
                            </script>


                            @endsection