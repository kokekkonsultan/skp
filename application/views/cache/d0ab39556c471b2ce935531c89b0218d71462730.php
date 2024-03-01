<?php
$ci = get_instance();
?>

<?php $__env->startSection('style'); ?>
<link href="<?php echo e(TEMPLATE_BACKEND_PATH); ?>plugins/custom/datatables/datatables.bundle.css" rel="stylesheet"
    type="text/css" />
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class=" container-fluid">

    <div class="card card-custom bgi-no-repeat gutter-b"
        style="height: 150px; background-color: #1c2840; background-position: calc(100% + 0.5rem) 100%; background-size: 100% auto; background-image: url(/assets/img/banner/taieri.svg)"
        data-aos="fade-down">
        <div class="card-body d-flex align-items-center">
            <div>
                <h3 class="text-white font-weight-bolder line-height-lg mb-5">
                    <?php echo e(strtoupper($title)); ?>

                </h3>

                <a class="btn btn-primary font-weight-bold shadow-lg btn-sm"
                    href="<?php echo base_url() . $ci->session->userdata('username') . '/penayang-survei/add' ?>"><i
                        class="fa fa-plus"></i> Buat Label Penayangan</a>
            </div>
        </div>
    </div>









    <div class="card shadow aos-init aos-animate" data-aos="fade-up">
        <div class="card-body">

            <?php if($penayang_survei->num_rows() > 0): ?>
            <style>
            thead {
                display: none;
            }
            </style>
            <table id="table" class="table mt-5" cellspacing="0" width="100%">
                <thead class="bg-gray-300">
                    <tr>
                        <th width="1%"></th>
                        <th>Nama Survey</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
            <?php else: ?>
            <div class="fs-5 lead text-center mt-5 text-primary">
                Belum ada label penayangan yang dibuat !
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>




<?php $__env->stopSection(); ?>

<?php $__env->startSection('javascript'); ?>
<script src="<?php echo e(TEMPLATE_BACKEND_PATH); ?>plugins/custom/datatables/datatables.bundle.js"></script>
<script>
var table;
$(document).ready(function() {
    table = $("#table").DataTable({
        "processing": true,
        "serverSide": true,
        "lengthMenu": [
            [5, 10, -1],
            [5, 10, "Semua data"]
        ],
        "pageLength": 5,
        "ordering": true,
        "processing": true,
        "serverSide": true,
        "ajax": {
            "url": "<?php echo base_url() . $ci->session->userdata('username') . '/penayang-survei/ajax-list' ?>",
            "type": "POST",
            "dataType": "json",
            "dataSrc": function(jsonData) {
                return jsonData.data;
            },
            "data": function(data) {},

        },
        "columnDefs": [{
            "targets": [0],
            "orderable": false,
        }, ],

    });
});
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('include_backend/template_backend', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\IT\Documents\Htdocs MAMP\skp_surveiku\application\views/penayang_survei/index.blade.php ENDPATH**/ ?>