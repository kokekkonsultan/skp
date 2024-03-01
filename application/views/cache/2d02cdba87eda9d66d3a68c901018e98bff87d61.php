<?php
$ci = get_instance();
?>




<div class="row mb-5">
    <div class="col-md-4">
        <div class="card card-body">
            <div class="text-center">
                <div id="chart-perolehan"></div>
            </div>
        </div>
    </div>
    <div class="col-md-8">
        <div class="card card-body">
            <div class="text-center">
                <div id="chart"></div>
            </div>
        </div>
    </div>
</div>



<script>
FusionCharts.ready(function() {
    var myChart = new FusionCharts({
        type: "column3d",
        renderAt: "chart",
        width: "100%",
        "height": "309",
        dataFormat: "json",
        dataSource: {
            chart: {
                caption: "Indeks Survei <?php echo $klien ?>", // Kepuasan Pelanggan
                subcaption: "Sampai dengan Tahun <?php echo $tahun_awal ?>",
                // yaxisname: "Deforested Area{br}(in Hectares)",
                decimals: "2",
                theme: "gammel",
                "bgColor": "#ffffff"
            },
            data: [<?php echo $new_chart ?>]
        }
    });
    myChart.render();
});


FusionCharts.ready(function() {
    var myChart = new FusionCharts({
        type: "pie3d",
        renderAt: "chart-perolehan",
        width: "100%",
        "height": "309",
        dataFormat: "json",
        dataSource: {
            chart: {
                caption: "Perolehan Survei", // Kepuasan Pelanggan
                // subcaption: "Sampai dengan Tahun <?php echo $tahun_awal ?>",
                // yaxisname: "Deforested Area{br}(in Hectares)",
                decimals: "2",
                theme: "umber",
                "bgColor": "#ffffff"
            },
            data: [<?php echo $perolehan ?>]
        }
    });
    myChart.render();
});
</script><?php /**PATH C:\Users\IT\Documents\Htdocs MAMP\skp_surveiku\application\views/dashboard/chart_survei.blade.php ENDPATH**/ ?>