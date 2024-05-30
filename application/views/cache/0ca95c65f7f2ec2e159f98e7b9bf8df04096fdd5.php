

<?php
$ci = get_instance();
?>

<?php $__env->startSection('style'); ?>
<link href="<?php echo e(TEMPLATE_BACKEND_PATH); ?>plugins/custom/datatables/datatables.bundle.css" rel="stylesheet" type="text/css" />
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

<div class="container-fluid">
    <?php echo $__env->make("include_backend/partials_no_aside/_inc_menu_repository", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <div class="row mt-5">
        <div class="col-md-3">
            <?php echo $__env->make('manage_survey/menu_data_survey', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        </div>
        <div class="col-md-9">

            <div class="card card-custom bgi-no-repeat gutter-b aos-init aos-animate" style="height: 120px; background-color: #1c2840; background-position: calc(100% + 0.5rem) 100%; background-size: 100% auto; background-image: url(/assets/img/banner/taieri.svg)" data-aos="fade-down">
                <div class="card-body d-flex align-items-center">
                    <div>
                        <h4 class="text-white font-weight-bolder line-height-lg"><?php echo e(strtoupper($title)); ?></h4>
                        <h4 class="text-white text-uppercase"><b>Nilai IKP : <?php echo e($indeks_total); ?></b></h4>
                    </div>
                </div>
            </div>



            <div class="card card-body" data-aos="fade-down">
                <!-- <h4 class="text-primary"><b>Unsur</b></h4> -->
                <div class="table-responsive">
                    <table class="table table-hover table-bordered example" style="width:100%">
                        <thead class="bg-secondary">
                            <tr>
                                <th width="4%" valign="top">No</th>
                                <th>Layanan</th>
                                <th>Indeks</th>
                                <th></th>
                            </tr>
                        </thead>

                        <tbody>

                            <?php
                            $a = 1;
                            $layanan = $ci->db->get_where("layanan_survei_$profiles->table_identity", array('is_active' => 1));
                            ?>
                            <?php $__currentLoopData = $layanan->result(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php
                            $ikm_layanan  = $ci->db->query("SELECT AVG(rata_rata) AS rata_rata
                            FROM (
                            SELECT
                            IF(id_parent = 0,unsur_pelayanan_$table_identity.id, unsur_pelayanan_$table_identity.id_parent) AS id_sub,
                            AVG(IF(jawaban_pertanyaan_unsur_$table_identity.skor_jawaban != 0, skor_jawaban, NULL)) AS rata_rata
                            
                            FROM jawaban_pertanyaan_unsur_$table_identity
                            JOIN pertanyaan_unsur_pelayanan_$table_identity ON jawaban_pertanyaan_unsur_$table_identity.id_pertanyaan_unsur = pertanyaan_unsur_pelayanan_$table_identity.id
                            JOIN unsur_pelayanan_$table_identity ON pertanyaan_unsur_pelayanan_$table_identity.id_unsur_pelayanan = unsur_pelayanan_$table_identity.id
                            JOIN survey_$table_identity ON jawaban_pertanyaan_unsur_$table_identity.id_responden = survey_$table_identity.id_responden
                            JOIN responden_$table_identity ON survey_$table_identity.id_responden = responden_$table_identity.id
                            WHERE survey_$table_identity.is_submit = 1 && responden_$table_identity.id_layanan_survei = $value->id
                            GROUP BY id_sub
                            ) jpu_$table_identity")->row()->rata_rata;
                            $konversi = $ikm_layanan * $skala_likert;
                            ?>
                            <tr>
                                <td class="text-center"><?php echo e($a++); ?></td>
                                <td><a data-toggle="collapse" href="#Collapse<?php echo e($value->id); ?>"><b class="text-primary"><?php echo e($value->nama_layanan); ?></b></a>
                                  
                                <?php
                                $analisa = $ci->db->query("SELECT *, analisa_$table_identity.id AS id_analisa
                                FROM analisa_$table_identity
                                JOIN unsur_pelayanan_$table_identity ON analisa_$table_identity.id_unsur_pelayanan = unsur_pelayanan_$table_identity.id
                                WHERE id_layanan_survei = $value->id
                                ORDER BY id_unsur_pelayanan ASC
                                ");
                                $no = 1;
                                ?>
                                <div class="collapse multi-collapse <?php echo e($analisa->num_rows() > 0 ? 'show' : ''); ?>" id="Collapse<?php echo e($value->id); ?>">

                                <?php if($analisa->num_rows() > 0): ?>
                                <hr>
                                <?php $__currentLoopData = $analisa->result(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <ul>
                                        <li><b><?php echo e($row->nomor_unsur . '. ' . $row->nama_unsur_pelayanan); ?></b>
                                            <div class="btn-group" role="group">
                                                <button type="button" class="badge badge-info border dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Action</button>

                                                <div class="dropdown-menu">
                                                    <a class="dropdown-item" href="<?php echo e(base_url() . $ci->session->userdata('username') . '/' . $ci->uri->segment(2) . '/analisa-survei/edit/' . $row->id_analisa); ?>">Edit</a>
                                                    <a class="dropdown-item" href="javascript:void(0)" onclick="delete_analisa_survei(<?php echo e($row->id_analisa); ?>)">Delete</a>
                                                </div>
                                            </div>
                                        </li>
                                        <ul>
                                            <li><b>Faktor Yang Mempengaruhi :</b> <?php echo $row->faktor_penyebab; ?></li>
                                            <li><b>Rencana Tindak Lanjut :</b> <?php echo $row->rencana_perbaikan; ?></li>
                                            <li><b>Waktu :</b> <?php echo $row->waktu; ?></li>
                                            <li><b>Penanggung Jawab :</b> <?php echo $row->penanggung_jawab; ?></li>
                                        </ul>
                                    </ul>
                                    <hr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php else: ?> 


                                <div class="text-center mt-3"><i>Belum ada analisa yang dibuat.</i></div>

                                <?php endif; ?>
                                </div>


                                </td>
                                <td><?php echo e(ROUND($ikm_layanan,3)); ?>

                                <?php foreach ($definisi_skala->result() as $obj) {
                                        if ($konversi <= $obj->range_bawah && $konversi >= $obj->range_atas) {
                                            echo '(' . $obj->kategori . ')';
                                        }
                                    }
                                    if ($konversi <= 0) {
                                        echo  'NULL';
                                    }
                                    ?>
                                </td>
                                <td>
                                    <a href="<?php echo e(base_url()); ?><?php echo e($ci->session->userdata('username')); ?>/<?php echo e($ci->uri->segment(2)); ?>/analisa-survei/<?php echo e($value->id); ?>" class="btn btn-light-primary btn-sm font-weight-bold"><i class="fa fa-book"></i> Analisa Layanan</a>
                                </td>
                            </tr>

                            <?php
                            $no++
                            ?>
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
<?php echo $__env->make('include_backend/template_backend', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\IT\Documents\Htdocs MAMP\skp_surveiku\application\views/analisa_survei/index.blade.php ENDPATH**/ ?>