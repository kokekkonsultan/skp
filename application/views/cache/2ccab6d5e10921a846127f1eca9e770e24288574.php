

<?php
$ci = get_instance();
?>

<?php $__env->startSection('style'); ?>
<link href="<?php echo e(TEMPLATE_BACKEND_PATH); ?>plugins/custom/datatables/datatables.bundle.css" rel="stylesheet"
    type="text/css" />
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

<div class="container-fluid">
    <?php echo $__env->make("include_backend/partials_no_aside/_inc_menu_repository", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <div class="row mt-5">
        <div class="col-md-3">
            <?php echo $__env->make('manage_survey/menu_data_survey', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        </div>
        <div class="col-md-9">


            <div class="card card-custom bgi-no-repeat gutter-b aos-init aos-animate"
                style="height: 150px; background-color: #1c2840; background-position: calc(100% + 0.5rem) 100%; background-size: 100% auto; background-image: url(/assets/img/banner/taieri.svg)"
                data-aos="fade-down">
                <div class="card-body d-flex align-items-center">
                    <div>
                        <h5 class="text-white">Jenis Pelayanan :</h5>
                        <h5 class="text-white font-weight-bolder line-height-lg">
                        <?php echo e(strtoupper($layanan->nama_layanan) . ' - '. ROUND($nilai_tertimbang, 3) . ' (' . $kategori . ')'); ?>

                        </h5>
                        <a class="btn btn-secondary btn-sm font-weight-bold"
                            href="<?php echo e(base_url() . $ci->session->userdata('username') . '/' . $ci->uri->segment(2) . '/analisa-survei'); ?>"><i
                                class="fa fa-arrow-left"></i> Kembali</a>
                    </div>
                </div>
            </div>

            <div class="card card-body" data-aos="fade-down">
                <div class="table-responsive">
                    <table class="table table-hover example" style="width:100%">
                        <thead class="">
                            <tr>
                                <th>No</th>
                                <th>Unsur</th>
                                <th>Indeks</th>
                                <th>Kategori</th>
                                <th></th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php
                            $no = 1;
                            ?>
                            <?php $__currentLoopData = $nilai_per_unsur->result(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td><?php echo e($no++); ?></td>
                                <td><?php echo e($value->nomor_unsur); ?>. <?php echo e($value->nama_unsur_pelayanan); ?></td>
                                <td><?php echo e(ROUND($value->rata_rata, 3)); ?></td>
                                <td>
                                    <?php
                                    $nilai_konversi = $value->rata_rata * $skala_likert;
                                    foreach ($definisi_skala->result() as $obj) {
                                        if ($nilai_konversi <= $obj->range_bawah && $nilai_konversi >= $obj->range_atas) {
                                            echo $obj->kategori;
                                        }
                                    }
                                    if ($nilai_konversi <= 0) {
                                        echo  'NULL';
                                    }
                                    ?>
                                </td>
                                <td>
                                    <a href="<?php echo e(base_url()); ?><?php echo e($ci->session->userdata('username')); ?>/<?php echo e($ci->uri->segment(2)); ?>/analisa-survei/<?php echo e($ci->uri->segment(4)); ?>/<?php echo e($value->id_sub); ?>"
                                        class="btn btn-light-primary btn-sm font-weight-bold"><i class="fa fa-book"></i>
                                        Lakukan Analisa</a>
                                </td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
            </div>


            <div class="card card-body mt-5" data-aos="fade-down">
                <h5 class="text-primary">Hasil Analisa <?php echo e($layanan->nama_layanan); ?></h5>
                <hr>


                <div class="table-responsive">
                    <table class="table table-hover example" style="width:100%">
                        <thead class="">
                            <tr>
                                <th></th>
                                <th width="10%"></th>
                            </tr>
                        </thead>

                        <tbody>

                            <?php
                            $analisa = $ci->db->query("SELECT *, analisa_$table_identity.id AS id_analisa
                            FROM analisa_$table_identity
                            JOIN layanan_survei_$table_identity ON analisa_$table_identity.id_layanan_survei =
                            layanan_survei_$table_identity.id
                            JOIN unsur_pelayanan_$table_identity ON analisa_$table_identity.id_unsur_pelayanan =
                            unsur_pelayanan_$table_identity.id");
                            $no = 1;
                            ?>

                            <?php $__currentLoopData = $analisa->result(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td>
                                    <b
                                        class="text-primary"><?php echo e($row->nomor_unsur . '. ' . $row->nama_unsur_pelayanan); ?></b>
                                    <hr>
                                    <ul>
                                        <li><b>Faktor Yang Mempengaruhi :</b> <?php echo $row->faktor_penyebab; ?></li>
                                        <li><b>Rencana Tindak Lanjut :</b> <?php echo $row->rencana_perbaikan; ?></li>
                                        <li><b>Waktu :</b> <?php echo $row->waktu; ?></li>
                                        <li><b>Penanggung Jawab :</b> <?php echo $row->penanggung_jawab; ?></li>
                                    </ul>
                                </td>
                                <td>
                                    <a href="<?php echo e(base_url() . $ci->session->userdata('username') . '/' . $ci->uri->segment(2) . '/analisa-survei/edit/' . $row->id_analisa); ?>"
                                        class="btn btn-light-primary btn-sm font-weight-bold shadow"><i
                                            class="fa fa-edit"></i> Edit</a>

                                    <hr>
                                    <a class="btn btn-light-primary btn-sm font-weight-bold shadow"
                                        href="javascript:void(0)" title="Hapus ' . $value->nama_unsur_pelayanan . '"
                                        onclick="delete_analisa_survei(<?php echo e($row->id_analisa); ?>)"><i
                                            class="fa fa-trash"></i> Delete</a>
                                </td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('javascript'); ?>
<script src="<?php echo e(TEMPLATE_BACKEND_PATH); ?>plugins/custom/datatables/datatables.bundle.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/4.9.11/tinymce.min.js"></script>
<script src="<?php echo e(base_url()); ?>assets/themes/metronic/assets/plugins/custom/datatables/datatables.bundle.js"></script>
<script>
$(document).ready(function() {
    $('.example').DataTable({
        "lengthMenu": [
            [5, 10, 25, 50, 100, -1],
            [5, 10, 25, 50, 100, "Semua data"]
        ],
        "pageLength": 5,
    });
});
</script>


<script>
// $(document).ready(function() {
//     table = $('#table').DataTable({

//         "processing": true,
//         "serverSide": true,
//         "order": [],
//         "language": {
//             "processing": '<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span> ',
//         },
//         "ajax": {
//             "url": "<?php echo base_url() . $ci->session->userdata('username') . '/' . $ci->uri->segment(2) . '/analisa-survei/ajax-list' ?>",
//             "type": "POST",
//             "data": function(data) {}
//         },

//         "columnDefs": [{
//             "targets": [-1],
//             "orderable": false,
//         }, ],

//     });
// });

// $('#btn-filter').click(function() {
//     table.ajax.reload();
// });
// $('#btn-reset').click(function() {
//     $('#form-filter')[0].reset();
//     table.ajax.reload();
// });

function delete_analisa_survei(id) {
    if (confirm('Are you sure delete this data?')) {
        $.ajax({
            url: "<?php echo base_url() . $ci->session->userdata('username') . '/' . $ci->uri->segment(2) . '/analisa-survei/delete/' ?>" +
                id,
            type: "POST",
            dataType: "JSON",
            success: function(data) {
                if (data.status) {

                    Swal.fire(
                        'Informasi',
                        'Berhasil menghapus data',
                        'success'
                    );
                    window.setTimeout(function() {
                        location.reload()
                    }, 1500);

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
<?php echo $__env->make('include_backend/template_backend', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\IT\Documents\Htdocs MAMP\skp_surveiku\application\views/analisa_survei/detail_layanan.blade.php ENDPATH**/ ?>