<?php
$ci = get_instance();
?>

<?php $__env->startSection('style'); ?>
<!-- <link rel="dns-prefetch" href="//fonts.gstatic.com">
<link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet"> -->
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

<div class="container mt-5 mb-5">
    <div class="text-center" data-aos="fade-up">
        <div id="progressbar" class="mb-5">
            <li class="active" id="account"><strong>Data Responden</strong></li>
            <li id="personal"><strong>Pertanyaan Survei</strong></li>
            <?php if($status_saran == 1): ?>
            <li id="payment"><strong>Saran</strong></li>
            <?php endif; ?>
            <li id="completed"><strong>Completed</strong></li>
        </div>
    </div>
    <br>
    <br>

    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card shadow mb-4 mt-4" data-aos="fade-up"
                style="border-left: 0px solid #FFA800; font-size: 16px; ">

                <?php echo $__env->make('survei/_include/_benner_survei', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

                <div class="card-header text-center">
                    <h4><b>DATA RESPONDEN</b> - <?php echo $__env->make('include_backend/partials_backend/_tanggal_survei', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?></h4>
                </div>
                <div class="card-body">

                    <form>

                        <span style="color: red; font-style: italic;"><?php echo validation_errors(); ?></span>

                        <!-- <div class="form-group">
                            <label class="font-weight-bold">Nama Lengkap <span class="text-danger">*</span></label>
                            <?php
                            echo form_input($nama_lengkap);
                            ?>
                        </div>

                        </br> -->


                        <?php if($manage_survey->is_layanan_survei != 0): ?>
                        <?php if($manage_survey->is_kategori_layanan_survei == 1): ?>
                        <div class="form-group">
                            <label for="kategori_layanan" class="font-weight-bold">Kategori Layanan Survei <span class="text-danger">*</span></label>
                            <select id="kategori_layanan" name="kategori_layanan" class="form-control" required>
                                <option value="">Please Select</option>

                                <?php $__currentLoopData = $ci->db->query("SELECT * FROM
                                kategori_layanan_survei_$manage_survey->table_identity WHERE is_active = 1 ORDER BY
                                urutan ASC")->result(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($row->id); ?>"><?php echo e($row->nama_kategori_layanan); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>

                        <div class="form-group mt-5" id="layanan_survei" style="display: none;">
                            <br>
                            <label for="layanan_survei" class="font-weight-bold">Layanan Survei <span class="text-danger">*</span></label>
                            <select id="id_layanan_survei" name="id_layanan_survei" class="form-control">
                                <option value="">Please Select</option>
                            </select>
                        </div>

                        <input class="form-control mb-5" name="layanan_survei_lainnya" id="layanan_survei_lainnya" placeholder="Masukkan Jenis Layanan Lainnya..." style="display: none;">

                        <?php else: ?>

                        <div class="form-group">
                            <label for="layanan_survei" class="font-weight-bold">Layanan Survei <span class="text-danger">*</span></label>
                            <?php echo form_dropdown($id_layanan_survei); ?>

                        </div>


                        <?php endif; ?>
                        
                        <?php endif; ?>


                        <?php if($manage_survey->is_layanan_survei != 0): ?>
                        
                        <?php endif; ?>


                       <?php $__currentLoopData = $profil_responden->result(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                        <div class="form-group" style="margin-bottom: 0; <?php echo ((!isset($row->id_profil)) || ($row->id_profil == '0')) ? 'padding-top:25px;' : 'padding-top:10px;' ?> ">
                        
                            <label class="font-weight-bold" style="<?php echo ((!isset($row->id_profil)) || ($row->id_profil == '0')) ? '' : 'display: none; ' ?> "><?php echo $row->nama_profil_responden ?> <?php echo ((!isset($row->is_required)) || ($row->is_required == '1')) ? '<span
                                    class="text-danger">*</span>' : '' ?></label>
                            <div class="form-inline">
                            <?php if ($row->jenis_isian == 2) { ?>

                            <?php if ((isset($row->posisi_label_isian)) && ($row->posisi_label_isian == 1)) { echo '<label class="col-md-2" style="display: -webkit-box; ">'.$row->label_isian.'</label>'; } ?><input class="form-control <?php if ((isset($row->posisi_label_isian)) && ($row->posisi_label_isian != 0)) { echo 'col-md-10'; }else{ echo 'col-md-12'; } ?>" type="<?php echo $row->type_data ?>"
                                name="<?php echo $row->nama_alias ?>" placeholder="Masukkan data anda ..." <?php echo ((!isset($row->is_required)) || ($row->is_required == '1')) ? 'required' : '' ?>><?php if ((isset($row->posisi_label_isian)) && ($row->posisi_label_isian == 2)) { echo '<label class="col-md-2" style="display: -webkit-box; ">'.$row->label_isian.'</label>'; } ?>

                            <?php } else { ?>

                            <?php if ((isset($row->posisi_label_isian)) && ($row->posisi_label_isian == 1)) { echo '<label class="col-md-2" style="display: -webkit-box; ">'.$row->label_isian.'</label>'; } ?><select class="form-control <?php if ((isset($row->posisi_label_isian)) && ($row->posisi_label_isian != 0)) { echo 'col-md-10'; }else{ echo 'col-md-12'; } ?>" name="<?php echo $row->nama_alias ?>" <?php echo ((!isset($row->is_required)) || ($row->is_required == '1')) ? 'required' : '' ?>>
                                <option value="">Please Select</option>

                                <?php
                                        foreach ($kategori_profil_responden->result() as $value) {
                                        ?>

                                <?php if ($value->id_profil_responden == $row->id) { ?>

                                <option value="<?php echo $value->id ?>">
                                    <?php echo $value->nama_kategori_profil_responden ?></option>

                                <?php } ?>

                                <?php } ?>

                            </select><?php if ((isset($row->posisi_label_isian)) && ($row->posisi_label_isian == 2)) { echo '<label class="col-md-2" style="display: -webkit-box; ">'.$row->label_isian.'</label>'; } ?>

                            <?php } ?>
                            </div>
                        </div>
                        

                       <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</br>


                </div>
                <div class="card-footer">
                    <table class="table table-borderless">
                        <tr>
                            <td class="text-left">
                                <?php echo anchor(base_url() . $ci->uri->segment(1) . '/' . $ci->uri->segment(2)
                                . '/preview-form-survei/opening', 'Kembali',
                                ['class' => 'btn btn-back btn-lg shadow']); ?>

                            </td>
                            <td class="text-right">
                                <a class="btn btn-next btn-lg shadow"
                                    href="<?php echo base_url() . $ci->uri->segment(1) . '/' . $ci->uri->segment(2) . '/preview-form-survei/pertanyaan' ?>">Selanjutnya</a>
                            </td>
                        </tr>
                    </table>
                </div>
                </form>
            </div>


            <br><br>
        </div>
    </div>
</div>


<?php $__env->stopSection(); ?>

<?php $__env->startSection('javascript'); ?>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script type='text/javascript'>
$(window).load(function() {
    $("#pekerjaan").change(function() {
        console.log($("#pekerjaan option:selected").val());
        if ($("#pekerjaan option:selected").val() == '6') {
            $('#pekerjaan_lainnya').prop('hidden', false);
        } else {
            $('#pekerjaan_lainnya').prop('hidden', 'true');
        }
    });
});

$("#kategori_layanan").change(function() {
        var id_kategori_layanan = $("#kategori_layanan").val();
        // console.log(id_kategori_layanan);
        if (id_kategori_layanan == 0) {
            $('#id_layanan_survei').removeAttr('required');
            $('#layanan_survei').hide();
            $('#layanan_survei_lainnya').prop('required', true).show();
        } else {
            $('#layanan_survei_lainnya').removeAttr('required').hide();
            $('#layanan_survei').show();

            $("#id_layanan_survei").select2({
                ajax: {
                    url: "<?= base_url() .  $ci->session->userdata('username') . '/' . $ci->uri->segment(2) . '/preview-form-survei/getdatalayanan/' ?>" + id_kategori_layanan,
                    type: "post",
                    dataType: 'json',
                    delay: 200,
                    data: function(params) {
                        return {
                            searchTerm: params.term
                        };
                    },
                    processResults: function(response) {
                        return {
                            results: response
                        };
                    },
                    cache: true
                }
            }).prop('required', true);
        }
    });
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('include_backend/_template', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\IT\Documents\Htdocs MAMP\skp_surveiku\application\views/preview_form_survei/form_data_responden.blade.php ENDPATH**/ ?>