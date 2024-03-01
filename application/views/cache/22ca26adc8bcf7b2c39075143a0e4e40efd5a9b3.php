<?php
$ci = get_instance();
?>

<?php $__env->startSection('style'); ?>
<link href="<?php echo e(TEMPLATE_BACKEND_PATH); ?>plugins/custom/datatables/datatables.bundle.css" rel="stylesheet" type="text/css" />

<style>
    .border-menu {
        border-color: #304EC0 !important;
        background-color: #f3f3f3;
    }
</style>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

<div class="container-fluid">
    <?php echo $__env->make("include_backend/partials_no_aside/_inc_menu_repository", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <div class="row mt-5">
        <div class="col-md-3">
            <?php echo $__env->make('manage_survey/menu_data_survey', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        </div>
        <div class="col-md-9">


            <div class="card card-custom bgi-no-repeat gutter-b" style="height: 150px; background-color: #1c2840; background-position: calc(100% + 0.5rem) 100%; background-size: 100% auto; background-image: url(/assets/img/banner/taieri.svg)" data-aos="fade-down">
                <div class="card-body d-flex align-items-center">
                    <div>
                        <h3 class="text-white font-weight-bolder line-height-lg mb-5">
                            <?php echo e(strtoupper($title)); ?>

                        </h3>

                        <?php if($manage_survey->is_question == 1): ?>
                        <a class="btn btn-primary btn-sm font-weight-bold shadow" href="<?php echo e(base_url() . $ci->session->userdata('username') . '/' . $ci->uri->segment(2) . '/pertanyaan-nps/add'); ?>"><i class="fas fa-plus"></i> Tambah Pertanyaan NPS</a>
                        <?php endif; ?>

                    </div>
                </div>
            </div>



            <div class="card card-custom card-sticky" data-aos="fade-down">
                <div class="card-body">

                    <!-- <div id="tablex">
                        <div class="custom-control custom-switch mt-5 mb-5">
                            <input type="checkbox" name="setting_value" class="custom-control-input toggle_dash_1" value="1" id="customSwitch1"  <?php echo e($profiles->is_emoji_nps == 1 ? 'checked' : ''); ?>>
                            <label class="custom-control-label font-weight-bold" for="customSwitch1">Gunakan Emoji Pada Pilihan Jawaban NPS</label>
                        </div>
                    </div>
                    <hr> -->


                    <div class="table-responsive mt-5">
                        <table id="table" class="table table-bordered table-hover" cellspacing="0" width="100%" style="font-size: 12px;">
                            <thead class="bg-secondary">
                                <tr>
                                    <th width="5%">No.</th>
                                    <th>Isi Pertanyaan</th>
                                    <th>Status</th>
                                    <th></th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>




<?php $__env->stopSection(); ?>

<?php $__env->startSection('javascript'); ?>
<script src="<?php echo e(TEMPLATE_BACKEND_PATH); ?>plugins/custom/datatables/datatables.bundle.js"></script>

<script>
    $(document).ready(function() {
        $('#tablex').on('change', '.toggle_dash_1', function() {
            // alert("TT");
            var mode = $(this).prop('checked');
            var nilai_id = $(this).val();
            console.log(mode);

            $.ajax({

                type: 'POST',
                dataType: 'JSON',
                url: "<?php echo e(base_url()); ?><?php echo e($ci->session->userdata('username')); ?>/<?php echo e($ci->uri->segment(2)); ?>/pertanyaan-nps/is-emoji",
                data: {
                    'mode': mode,
                    'nilai_id': nilai_id
                },
                success: function(data) {
                    var data = eval(data);
                    message = data.message;
                    success = data.success;

                    table.ajax.reload();
                    toastr["success"](message);



                }
            });
        });
    });
</script>


<script>
    $(document).ready(function() {
        table = $('#table').DataTable({

            "processing": true,
            "serverSide": true,
            "lengthMenu": [
                [5, 10, 25, 50, 100, -1],
                [5, 10, 25, 50, 100, "Semua data"]
            ],
            "pageLength": 5,
            "order": [],
            "language": {
                "processing": '<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span> ',
            },
            "ajax": {
                "url": "<?php echo base_url() . $ci->session->userdata('username') . '/' . $ci->uri->segment(2) . '/pertanyaan-nps/ajax-list' ?>",
                "type": "POST",
                "data": function(data) {}
            },

            "columnDefs": [{
                "targets": [-1],
                "orderable": false,
            }, ],

        });
    });
</script>


<script>
    function delete_pertanyaan_nps(id_pertanyaan_nps) {
        if (confirm('Are you sure delete this data?')) {
            $.ajax({
                url: "<?php echo base_url() . $ci->session->userdata('username') . '/' . $ci->uri->segment(2) . '/pertanyaan-nps/delete/' ?>" +
                    id_pertanyaan_nps,
                type: "POST",
                dataType: "JSON",
                success: function(data) {
                    if (data.status) {

                        table.ajax.reload();

                        Swal.fire(
                            'Informasi',
                            'Berhasil menghapus data',
                            'success'
                        );
                    } else {
                        Swal.fire(
                            'Informasi',
                            'Hak akses terbatasi. Bukan akun administrator.',
                            'warning'
                        );
                    }


                },
                error: function(jqXHR, textStatus, errorThrown) {
                    alert('Error deleting data');
                }
            });

        }
    }
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('include_backend/template_backend', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\IT\Documents\Htdocs MAMP\skp_surveiku\application\views/pertanyaan_nps/index.blade.php ENDPATH**/ ?>