<?php
$ci = get_instance();
?>

<?php $__env->startSection('style'); ?>
<link rel="dns-prefetch" href="//fonts.gstatic.com">
<link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

<div class="container mt-5 mb-5" style="font-family: nunito;">
    <div class="text-center" data-aos="fade-up">
        <div id="progressbar" class="mb-5">
            <li class="active" id="account"><strong>Data Responden</strong></li>
            <li class="active" id="personal"><strong>Pertanyaan Survei</strong></li>
            <?php if($status_saran == 1): ?>
            <li id="payment"><strong>Saran</strong></li>
            <?php endif; ?>
            <li id="completed"><strong>Completed</strong></li>
        </div>
    </div>
    <br>
    <br>
    <div class="row">
        <div class="col-md-8 offset-md-2" style="font-size: 16px;">
            <div class="card shadow mb-4 mt-4" data-aos="fade-up" style="font-family: 'Exo 2', sans-serif;">

            <?php echo $__env->make('survei/_include/_benner_survei', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

				<div class="card-header text-center">
					<h3 class="mt-5" style="font-family: 'Exo 2', sans-serif;"><b>PERTANYAAN UNSUR</b></h3>
					<?php echo $__env->make('include_backend/partials_backend/_tanggal_survei', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                </div>

                <form>

                    <div class="card-body ml-5 mr-5">

                        <!-- Looping Pertanyaan Terbuka Paling Atas -->
                        <?php
                        $a = 1;
                        ?>
                        <?php $__currentLoopData = $pertanyaan_terbuka_atas->result(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row_terbuka_atas): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php
                        $model_ta = $row_terbuka_atas->is_model_pilihan_ganda == 2 ? 'checkbox' : 'radio';
                        ?>

                        <div class="mt-10 mb-10">

                            <table class="table table-borderless" width="100%" border="0">
                                <tr>
                                    <td width="5%" valign="top"><?php echo $row_terbuka_atas->nomor_pertanyaan_terbuka; ?>.
                                    </td>
                                    <td><?php echo $row_terbuka_atas->isi_pertanyaan_terbuka; ?></td>
                                </tr>

                                <tr>
                                    <td width="5%"></td>
                                    <td style="font-weight:bold;" width="95%">

                                        <?php $__currentLoopData = $jawaban_pertanyaan_terbuka->result(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value_terbuka_atas): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php if($value_terbuka_atas->id_perincian_pertanyaan_terbuka ==
                                        $row_terbuka_atas->id_perincian_pertanyaan_terbuka): ?>
                                        <div class="<?php echo e($model_ta); ?>-inline mb-2">
                                            <label class="<?php echo e($model_ta); ?> <?php echo e($model_ta); ?>-outline <?php echo e($model_ta); ?>-success <?php echo e($model_ta); ?>-lg" style="font-size: 16px;">
                                                <input type="<?php echo e($model_ta); ?>" name="jawaban_pertanyaan_terbuka[<?php echo e($row_terbuka_atas->id_pertanyaan_terbuka); ?>]"
                                                    value="<?php echo e($value_terbuka_atas->pertanyaan_ganda); ?>"
                                                    class="terbuka_<?php echo e($value_terbuka_atas->id_pertanyaan_terbuka); ?>">
                                                <span></span> <?php echo e($value_terbuka_atas->pertanyaan_ganda); ?>

                                            </label>
                                        </div>
                                        <?php endif; ?>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>



                                        <?php if($row_terbuka_atas->dengan_isian_lainnya == 1): ?>
                                        <div class="<?php echo e($model_ta); ?>-inline mb-2">
                                            <label class="<?php echo e($model_ta); ?> <?php echo e($model_ta); ?>-outline <?php echo e($model_ta); ?>-success <?php echo e($model_ta); ?>-lg"
                                                style="font-size: 16px;">
                                                <input type="<?php echo e($model_ta); ?>"
                                                    name="jawaban_pertanyaan_terbuka[<?php echo e($row_terbuka_atas->id_pertanyaan_terbuka); ?>]"
                                                    value="Lainnya"
                                                    class="terbuka_<?php echo e($value_terbuka_atas->id_pertanyaan_terbuka); ?>"><span></span>Lainnya
                                            </label>
                                        </div>
                                        
                                        <input class="form-control" name="jawaban_lainnya[<?php echo e($row_terbuka_atas->id_pertanyaan_terbuka); ?>]" 
                                            value=""
                                            pattern="^[a-zA-Z0-9.,\s]*$|^\w$"
                                            placeholder="Masukkan jawaban lainnya ..."
                                            id="terbuka_lainnya_<?php echo e($row_terbuka_atas->id_pertanyaan_terbuka); ?>" style="display:none">
                                            
                                            <small id="text_terbuka_<?php echo e($row_terbuka_atas->id_pertanyaan_terbuka); ?>" class="text-danger" style="display:none">**Pengisian form hanya dapat menggunakan tanda baca
                                            (.) titik dan (,) koma</small>
                                            <br>
                                        <?php endif; ?>


                                        <?php if($row_terbuka_atas->id_jenis_pilihan_jawaban == 2): ?>
                                        <textarea class="form-control" type="text"
                                            name="jawaban_pertanyaan_terbuka[<?php echo e($row_terbuka_atas->id_pertanyaan_terbuka); ?>]"
                                            placeholder="Masukkan Jawaban Anda ..."></textarea>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            </table>
                        </div>

                        <?php
                        $a++;
                        ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>




                        <!-- Looping Pertanyaan Unsur -->
                        <?php
                        $i = 1;
                        ?>
                        <?php $__currentLoopData = $pertanyaan_unsur->result(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php
                        $is_required = 'required';
                        $is_required_u = ''//<b class="text-danger">*</b>;
                        ?>
                        <div class="mt-10 mb-10">
                            <table class="table table-borderless" width="100%" border="0">
                                <tr>
                                    <td width="5%" valign="top"><?php echo $row->nomor; ?>.</td>
                                    <td width="95%"><?php echo $row->isi_pertanyaan_unsur . '' . $is_required_u; ?></td>
                                </tr>

                                <tr>
                                    <td width="5%"></td>
                                    <td style="font-weight:bold;" width="95%">


                                        
                                        <?php $__currentLoopData = $jawaban_pertanyaan_unsur->result(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php if($value->id_pertanyaan_unsur == $row->id_pertanyaan_unsur): ?>
                                        <div class="radio-inline mb-2">
                                            <label class="radio radio-outline radio-success radio-lg"
                                                style="font-size: 16px;">

                                                <input type="radio" name="jawaban_pertanyaan_unsur[<?php echo e($i); ?>]"
                                                    value="<?php echo e($value->nomor_kategori_unsur_pelayanan); ?>"
                                                    class="unsur_<?php echo e($value->id_pertanyaan_unsur); ?>"
                                                    <?php echo e($is_required); ?>><span></span> <?php echo e($value->nama_kategori_unsur_pelayanan); ?>

                                            </label>
                                        </div>
                                        <?php endif; ?>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </td>
                                </tr>

                                
                                <tr>
                                    <td width="5%"></td>
                                    <td width="95%">

                                        <textarea class="form-control form-alasan" type="text"
                                            name="alasan_pertanyaan_unsur[<?php echo e($i); ?>]" id="input_alasan_<?php echo e($row->id_pertanyaan_unsur); ?>"
                                            placeholder="Berikan alasan jawaban anda ..."
                                            pattern="^[a-zA-Z0-9.,\s]*$|^\w$" style="display:none"></textarea>

                                        <small id="text_alasan_<?php echo e($row->id_pertanyaan_unsur); ?>" class="text-danger"
                                            style="display:none">**Pengisian alasan hanya dapat menggunakan tanda baca
                                            (.) titik dan (,) koma</small>
                                    </td>
                                </tr>
                                
                                
                            </table>
                        </div>


                        <div id="display_terbuka_<?php echo e($row->id_pertanyaan_unsur); ?>">
                            <!-- Looping Pertanyaan Terbuka -->
                            <?php
                            $n = $pertanyaan_terbuka_atas->num_rows() + 1;
                            ?>

                            <?php $__currentLoopData = $pertanyaan_terbuka->result(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row_terbuka): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php if($row_terbuka->id_unsur_pelayanan == $row->id_unsur_pelayanan): ?>
                            <?php
                            $model_t = $row_terbuka->is_model_pilihan_ganda == 2 ? 'checkbox' : 'radio';
                            ?>
                            <div class=" mt-10 mb-10">

                                <table class="table table-borderless" width="100%" border="0">
                                    <tr>
                                        <td width="5%" valign="top"><?php echo $row_terbuka->nomor_pertanyaan_terbuka; ?>.</td>
                                        <td width="95%"><?php echo $row_terbuka->isi_pertanyaan_terbuka; ?></td>
                                    </tr>

                                    <tr>
                                        <td width="5%"></td>
                                        <td style="font-weight:bold;" width="95%">
                                            <?php $__currentLoopData = $jawaban_pertanyaan_terbuka->result(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value_terbuka): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <?php if($value_terbuka->id_perincian_pertanyaan_terbuka ==
                                            $row_terbuka->id_perincian_pertanyaan_terbuka): ?>

                                            <div class="<?php echo e($model_t); ?>-inline mb-2">
                                                <label class="<?php echo e($model_t); ?> <?php echo e($model_t); ?>-outline <?php echo e($model_t); ?>-success <?php echo e($model_t); ?>-lg"
                                                    style="font-size: 16px;">
                                                    <input type="<?php echo e($model_t); ?>"
                                                        name="jawaban_pertanyaan_terbuka[<?php echo e($row_terbuka->id_pertanyaan_terbuka); ?>]"
                                                        value="<?php echo e($value_terbuka->pertanyaan_ganda); ?>"
                                                        class="terbuka_<?php echo e($row_terbuka->id_pertanyaan_terbuka); ?>">
                                                    <span></span> <?php echo e($value_terbuka->pertanyaan_ganda); ?>

                                                </label>
                                            </div>
                                            <?php endif; ?>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>


                                            <?php if($row_terbuka->dengan_isian_lainnya == 1): ?>
                                            <div class="<?php echo e($model_t); ?>-inline mb-2">
                                                <label class="<?php echo e($model_t); ?> <?php echo e($model_t); ?>-outline <?php echo e($model_t); ?>-success <?php echo e($model_t); ?>-lg"
                                                    style="font-size: 16px;">

                                                    <input type="<?php echo e($model_t); ?>"
                                                        name="jawaban_pertanyaan_terbuka[<?php echo e($row_terbuka->id_pertanyaan_terbuka); ?>]"
                                                        value="Lainnya"
                                                        class="terbuka_<?php echo e($row_terbuka->id_pertanyaan_terbuka); ?>">
                                                    <span></span> Lainnya
                                                </label>
                                            </div>
                                            
                                            <input class="form-control" name="jawaban_lainnya[<?php echo e($row_terbuka->id_pertanyaan_terbuka); ?>]" 
                                            value=""
                                            pattern="^[a-zA-Z0-9.,\s]*$|^\w$"
                                            placeholder="Masukkan jawaban lainnya ..." id="terbuka_lainnya_<?php echo e($row_terbuka->id_pertanyaan_terbuka); ?>" style="display:none">

                                            <small id="text_terbuka_<?php echo e($row_terbuka->id_pertanyaan_terbuka); ?>" class="text-danger" style="display:none">**Pengisian form hanya dapat menggunakan tanda baca
                                            (.) titik dan (,) koma</small>
                                            <br>
                                            <?php endif; ?>



                                            <?php if($row_terbuka->id_jenis_pilihan_jawaban == 2): ?>
                                            <textarea class="form-control" type="text"
                                                name="jawaban_pertanyaan_terbuka[<?php echo e($row_terbuka->id_pertanyaan_terbuka); ?>]"
                                                placeholder="Masukkan Jawaban Anda ..."></textarea>

                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                            <?php endif; ?>

                            <?php
                            $n++;
                            ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>


                        <?php
                        $i++;
                        ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>




                        <!-- Looping Pertanyaan Terbuka Paling Bawah -->
                        <?php
                        $b = $pertanyaan_terbuka_atas->num_rows() + $pertanyaan_terbuka->num_rows() + 1;
                        ?>
                        <?php $__currentLoopData = $pertanyaan_terbuka_bawah->result(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row_terbuka_bawah): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php
                        $model_tb = $row_terbuka_bawah->is_model_pilihan_ganda == 2 ? 'checkbox' : 'radio';
                        ?>
                        <div class="mt-10 mb-10">

                            <table class="table table-borderless" width="100%" border="0">
                                <tr>
                                    <td width="5%" valign="top"><?php echo $row_terbuka_bawah->nomor_pertanyaan_terbuka; ?>.
                                    </td>
                                    <td width="95%"><?php echo $row_terbuka_bawah->isi_pertanyaan_terbuka; ?></td>
                                </tr>

                                <tr>
                                    <td width="5%"></td>
                                    <td style="font-weight:bold;" width="95%">
                                        <?php $__currentLoopData = $jawaban_pertanyaan_terbuka->result(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value_terbuka_bawah): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php if($value_terbuka_bawah->id_perincian_pertanyaan_terbuka ==
                                        $row_terbuka_bawah->id_perincian_pertanyaan_terbuka): ?>

                                        <div class="<?php echo e($model_tb); ?>-inline mb-2">
                                            <label class="<?php echo e($model_tb); ?> <?php echo e($model_tb); ?>-outline <?php echo e($model_tb); ?>-success <?php echo e($model_tb); ?>-lg"
                                                style="font-size: 16px;">

                                                <input type="<?php echo e($model_tb); ?>"
                                                    name="jawaban_pertanyaan_terbuka[<?php echo e($row_terbuka_bawah->id_pertanyaan_terbuka); ?>]"
                                                    value="<?php echo e($value_terbuka_bawah->pertanyaan_ganda); ?>"
                                                    class="terbuka_<?php echo e($value_terbuka_bawah->id_pertanyaan_terbuka); ?>">
                                                <span></span> <?php echo e($value_terbuka_bawah->pertanyaan_ganda); ?>

                                            </label>
                                        </div>
                                        <?php endif; ?>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                        <?php if($row_terbuka_bawah->dengan_isian_lainnya == 1): ?>
                                        <div class="<?php echo e($model_tb); ?>-inline mb-2">
                                            <label class="<?php echo e($model_tb); ?> <?php echo e($model_tb); ?>-outline <?php echo e($model_tb); ?>-success <?php echo e($model_tb); ?>-lg"
                                                style="font-size: 16px;">

                                                <input type="<?php echo e($model_tb); ?>"
                                                    name="jawaban_pertanyaan_terbuka[<?php echo e($row_terbuka_bawah->id_pertanyaan_terbuka); ?>]"
                                                    value="Lainnya"
                                                    class="terbuka_<?php echo e($value_terbuka_bawah->id_pertanyaan_terbuka); ?>">
                                                <span></span> Lainnya
                                            </label>
                                        </div>
                                        
                                           <input class="form-control" name="jawaban_lainnya[<?php echo e($row_terbuka_bawah->id_pertanyaan_terbuka); ?>]" 
                                            value=""
                                            pattern="^[a-zA-Z0-9.,\s]*$|^\w$"
                                            placeholder="Masukkan jawaban lainnya ..."
                                            id="terbuka_lainnya_<?php echo e($row_terbuka_bawah->id_pertanyaan_terbuka); ?>" style="display:none">
                                            
                                            <small id="text_terbuka_<?php echo e($row_terbuka_bawah->id_pertanyaan_terbuka); ?>" class="text-danger" style="display:none">**Pengisian form hanya dapat menggunakan tanda baca
                                            (.) titik dan (,) koma</small>
                                            <br>
                                        <?php endif; ?>


                                        <?php if($row_terbuka_bawah->id_jenis_pilihan_jawaban == 2): ?>
                                        <textarea class="form-control" type="text"
                                            name="jawaban_pertanyaan_terbuka[<?php echo e($row_terbuka_bawah->id_pertanyaan_terbuka); ?>]"
                                            placeholder="Masukkan Jawaban Anda ..."></textarea>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            </table>
                        </div>

                        <?php
                        $b++;
                        ?>

                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>


                    <div class="card-footer">
                        <table class="table table-borderless">
                            <tr>
                                <td class="text-left">
                                    <?php echo anchor(base_url() . $ci->session->userdata('username') . '/' .
                                    $ci->uri->segment(2)
                                    . '/preview-form-survei/data-responden', 'Kembali',
                                    ['class' => 'btn btn-back btn-lg shadow']); ?>

                                </td>
                                <td class="text-right">
                                    <a class="btn btn-next btn-lg shadow"
                                        href="<?php echo $url_next ?>">Selanjutnya</a>
                                </td>
                            </tr>
                        </table>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php $__env->stopSection(); ?>



<?php $__env->startSection('javascript'); ?>

<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.1/jquery.min.js"></script>


<?php $__currentLoopData = $pertanyaan_unsur->result(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pr): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<script type="text/javascript">
$(function() {
    $(":radio.unsur_<?= $pr->id_pertanyaan_unsur ?>").click(function() {
        $("#input_alasan_<?= $pr->id_pertanyaan_unsur ?>").hide();
        $("#text_alasan_<?= $pr->id_pertanyaan_unsur ?>").hide();

        if ($(this).val() == 1 || $(this).val() == 2) {
            $("#input_alasan_<?= $pr->id_pertanyaan_unsur ?>").prop('required', true).show();
            $("#text_alasan_<?= $pr->id_pertanyaan_unsur ?>").show();

        } else {
            $("#input_alasan_<?= $pr->id_pertanyaan_unsur ?>").removeAttr('required').hide();
            $("#text_alasan_<?= $pr->id_pertanyaan_unsur ?>").hide();

        }

    });

});
</script>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

<?php $__currentLoopData = $ci->db->get("pertanyaan_terbuka_$manage_survey->table_identity")->result(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pt): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<script type="text/javascript">
$(function() {
    $(":radio.terbuka_<?= $pt->id ?>").click(function() {
         if($(this).val() == 'Lainnya'){
            $("#terbuka_lainnya_<?= $pt->id ?>").prop('required', true).show();
            $("#text_terbuka_<?= $pt->id ?>").show();
        } else {
            $("#terbuka_lainnya_<?= $pt->id ?>").removeAttr('required').hide();
            $("#text_terbuka_<?= $pt->id ?>").hide();
        }

    });

});
</script>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>


<?php $__env->stopSection(); ?>
<?php echo $__env->make('include_backend/_template', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\IT\Documents\Htdocs MAMP\skp_surveiku\application\views/preview_form_survei/form_pertanyaan.blade.php ENDPATH**/ ?>