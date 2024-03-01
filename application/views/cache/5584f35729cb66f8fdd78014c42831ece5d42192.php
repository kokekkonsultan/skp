<?php
$ci = get_instance();
?>

<?php $__env->startSection('style'); ?>
<link rel="dns-prefetch" href="//fonts.gstatic.com">
<link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
<?php $__env->stopSection(); ?>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<?php $__env->startSection('content'); ?>
<div class="container mt-5 mb-5" style="font-family: 'Exo 2', sans-serif;">
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

    <form action="<?php echo e(base_url() . 'survei/' . $ci->uri->segment(2) . '/add_pertanyaan/' . $ci->uri->segment(4)); ?>"
        class="form_survei" method="POST">

        <div class="row">
            <div class="col-md-8 offset-md-2" style="font-size: 16px;">
                <div class="card shadow mb-4 mt-4" data-aos="fade-up">

                    <?php echo $__env->make('survei/_include/_benner_survei', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

                    <div class="card-header text-center">
                        <h3 class="mt-5"><b>PERTANYAAN UNSUR</b></h3>
                        <?php echo $__env->make('include_backend/partials_backend/_tanggal_survei', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    </div>

                    <div class="card-body">




                        <!-- START TERBUKA ATAS -->
                        <?php echo $__env->make('survei/pertanyaan_terbuka/_tanpa_kategori/form_terbuka_atas', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                        <!-- END TERBUKA ATAS-->






                        <!--============================================================================================================================================================================================================================================================================================================================================================================== -->





                        <!-- LOOP UNSUR -->
                        <?php
                        $i = 1;
                        ?>
                        <?php $__currentLoopData = $pertanyaan_unsur->result(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php
                        $is_required = $row->is_required == 1 ? 'required' : '';
                        $is_required_u = $row->is_required == 1 ? '<b class="text-danger">*</b>' : '';
                        ?>

                        <div class="mt-10 mb-10">
                            <input type="hidden" name="id_pertanyaan_unsur[<?php echo e($i); ?>]"
                                value="<?php echo e($row->id_pertanyaan_unsur); ?>">
                            <table class="table table-borderless" width="100%" border="0">
                                <tr>
                                    <td width="5%" valign="top"><?php echo $row->nomor . '' . $is_required_u; ?>.</td>
                                    <td width="95%"><?php echo $row->isi_pertanyaan_unsur; ?></td>
                                </tr>

                                <tr>
                                    <td width="5%"></td>
                                    <td style="font-weight:bold;" width="95%">

                                        <!-- Looping Pilihan Jawaban -->
                                        <?php $__currentLoopData = $ci->db->get_where("kategori_unsur_pelayanan_$table_identity",
                                        ['id_pertanyaan_unsur' => $row->id_pertanyaan_unsur])->result(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <div class="radio-inline mb-2">
                                            <label class="radio radio-outline radio-success radio-lg"
                                                style="font-size: 16px;">

                                                <input type="radio" name="jawaban_pertanyaan_unsur[<?php echo e($i); ?>]"
                                                    value="<?php echo e($value->nomor_kategori_unsur_pelayanan); ?>"
                                                    class="unsur_<?php echo e($row->nomor); ?>"
                                                    <?= $value->nomor_kategori_unsur_pelayanan == $row->skor_jawaban ? 'checked' : '' ?>
                                                    <?php echo e($is_required); ?>><span></span>
                                                <?php echo e($value->nama_kategori_unsur_pelayanan); ?>

                                            </label>
                                        </div>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </td>
                                </tr>

                                <?php if($row->is_alasan == 1): ?>
                                <tr>
                                    <td width="5%"></td>
                                    <td width="95%">

                                        <textarea class="form-control form-alasan" type="text"
                                            name="alasan_pertanyaan_unsur[<?php echo e($i); ?>]" id="input_alasan_<?php echo e($row->nomor); ?>"
                                            placeholder="Berikan alasan jawaban anda ..."
                                            pattern="^[a-zA-Z0-9.,\s]*$|^\w$"
                                            <?= $row->skor_jawaban == 1 || $row->skor_jawaban == 2 ? 'required' : 'style="display:none"' ?>><?php echo e($row->alasan_jawaban); ?></textarea>

                                        <small id="text_alasan_<?php echo e($row->nomor); ?>" class="text-danger"
                                            style="display:none">**Pengisian
                                            alasan hanya dapat menggunakan tanda baca
                                            (.) titik dan (,) koma</small>
                                    </td>
                                </tr>
                                <?php endif; ?>

                            </table>
                        </div>


                        <!-- START TERBUKA -->
                        <?php echo $__env->make('survei/pertanyaan_terbuka/_tanpa_kategori/form_terbuka', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                        <!-- END TERBUKA -->


                        <?php
                        $i++;
                        ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>



                        <!--============================================================================================================================================================================================================================================================================================================================================================================== -->



                        <!-- START TERBUKA BAWAH -->
                        <?php echo $__env->make('survei/pertanyaan_terbuka/_tanpa_kategori/form_terbuka_bawah', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                        <!-- END TERBUKA BAWAH -->



                    </div>


                    <div class="card-footer">
                        <table class="table table-borderless">
                            <tr>
                                <?php
                                if($ci->uri->segment(5) == 'edit'){
                                $segment5 = 'edit';
                                } else {
                                $segment5 = 'do';
                                }
                                ?>

                                <td class="text-left">
                                    <a class="btn btn-back btn-lg shadow"
                                        href="<?php echo e(base_url() . 'survei/' . $ci->uri->segment(2) . '/data-responden/' . $ci->uri->segment(4) . '/' . $segment5); ?>">Kembali</a>
                                </td>

                                <td class="text-right">
                                    <button type="submit"
                                        class="btn btn-next btn-lg shadow-lg tombolSave">Selanjutnya</button>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </form>
</div>

<?php $__env->stopSection(); ?>



<?php $__env->startSection('javascript'); ?>

<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.1/jquery.min.js"></script>


<!-- UNSUR -->
<script>
<?php echo $js_pertanyaan_terbuka_atas ?>
<?php echo $js_pertanyaan_unsur ?>
<?php echo $js_pertanyaan_terbuka_bawah ?>
</script>







<?php $__currentLoopData = $ci->db->get("pertanyaan_terbuka_$manage_survey->table_identity")->result(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pt): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<?php if($pt->is_model_pilihan_ganda == 2): ?>
<script type="text/javascript">
$(document).ready(function() {
    var checkboxes = $('.terbuka_<?php echo e($pt->nomor_pertanyaan_terbuka); ?>');
    checkboxes.change(function() {
        if ($('.terbuka_<?php echo e($pt->nomor_pertanyaan_terbuka); ?>:checked').length > 0) {
            checkboxes.removeAttr('required');
        } else {
            checkboxes.attr('required', 'required');
        }
    });
    if ($('.terbuka_<?php echo e($pt->nomor_pertanyaan_terbuka); ?>:checked').length > 0) {
        checkboxes.removeAttr('required');
    }
});
</script>
<?php endif; ?>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>




<script>
$('.form_survei').submit(function(e) {

    var textboxes = document.getElementsByClassName("form-alasan");
    for (var i = 0; i < textboxes.length; i++) {
        var textbox = textboxes[i].value;
        var result = !!textbox.match(/[-:;!?"'()/{}<>@#$%^&*_+=|`~]/)
        if (result) {
            //alert("Pengisian alasan hanya dapat menggunakan tanda baca(.) titik dan (,) koma");
            Swal.fire({
                icon: 'warning',
                title: 'Peringatan',
                text: 'Pengisian alasan hanya dapat menggunakan tanda baca(.) titik dan (,) koma !',
                confirmButtonColor: '#8950FC',
                confirmButtonText: 'Baik, saya mengerti',
            })
            return false;
        }
    }

    $.ajax({
        url: $(this).attr('action'),
        type: 'POST',
        dataType: 'json',
        data: $(this).serialize(),
        cache: false,
        beforeSend: function() {
            $('.tombolSave').attr('disabled', 'disabled');
            $('.tombolSave').html('<i class="fa fa-spin fa-spinner"></i> Sedang diproses');

            KTApp.block('#kt_blockui_content', {
                overlayColor: '#FFA800',
                state: 'primary',
                message: 'Processing...'
            });

            setTimeout(function() {
                KTApp.unblock('#kt_blockui_content');
            }, 1000);

        },
        complete: function() {
            $('.tombolSave').removeAttr('disabled');
            $('.tombolSave').html('Selanjutnya');
        },

        error: function(e) {
            Swal.fire(
                'Error !',
                e,
                'error'
            )
        },

        success: function(data) {
            if (data.validasi) {
                $('.pesan').fadeIn();
                $('.pesan').html(data.validasi);
            }
            if (data.sukses) {
                // toastr["success"]('Data berhasil disimpan');

                setTimeout(function() {
                    window.location.href = "<?= $url_next ?>";
                }, 500);
            }
        }
    })
    return false;
});


$('.form-alasan').keyup(function() {
    var textboxes = document.getElementsByClassName("form-alasan");
    for (var i = 0; i < textboxes.length; i++) {
        var textbox = textboxes[i].value;
        var result = !!textbox.match(/[-:;!?"'()/{}<>@#$%^&*_+=|`~]/)
        if (result) {
            //alert("Pengisian alasan hanya dapat menggunakan tanda baca(.) titik dan (,) koma");
            Swal.fire({
                icon: 'warning',
                title: 'Peringatan',
                text: 'Pengisian alasan hanya dapat menggunakan tanda baca(.) titik dan (,) koma !',
                confirmButtonColor: '#8950FC',
                confirmButtonText: 'Baik, saya mengerti',
            })
            textboxes[i].focus();
        }
    }
});
</script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('include_backend/_template', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\IT\Documents\Htdocs MAMP\skp_surveiku\application\views/survei/pertanyaan_unsur/form_pertanyaan.blade.php ENDPATH**/ ?>