<?php
$ci = get_instance();
?>

<?php $__env->startSection('style'); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <?php echo $__env->make("include_backend/partials_no_aside/_inc_menu_repository", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <div class="row mt-5">
        <div class="col-md-3">
            <?php echo $__env->make('manage_survey/menu_data_survey', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        </div>
        <div class="col-md-9">

            <div class="card">
                <div class="card-header font-weight-bold">
                    <?php echo e($title); ?>

                </div>

                <form action="<?php echo e(base_url() . $ci->session->userdata('username') . '/' . $ci->uri->segment(2) . '/tingkatan-pertanyaan-survei/update'); ?>" class="form_tingkatan_pertanyaan">
                    <div class="card-body">

                        <div class="alert alert-secondary mb-5" role="alert">
                            <i class="flaticon-exclamation-1"></i> Halaman ini digunakan untuk mengatur tingkatan pertanyaan yang dipakai di dalam survei. Perlu diperhatikan, Mengubah Tingkatan Pertanyaan juga akan menghapus semua data pertanyaan yang sudah di inputkan.
                        </div>



                        <div class="form-group row mt-5">
                            <label for="recipient-name" class="col-sm-4 col-form-label font-weight-bold">Tingkatan
                                Pertanyaan Survei <span style="color:red;">*</span></label>

                            <div class="col-sm-8">

                                <label class="font-weight-bold"><input type="checkbox" name="is_aspek" id="is_aspek" value="1" <?= ($manage_survey->is_aspek == 1) ? 'checked' : '' ?>>
                                    Aspek</label><br>

                                <label class="font-weight-bold"><input type="checkbox" name="is_dimensi" id="is_dimensi" value="1" <?= ($manage_survey->is_dimensi == 1) ? 'checked' : '' ?> <?= ($manage_survey->is_aspek == 1) ? 'disabled' : '' ?>>
                                    Dimensi</label><br>
                                    

                                <label class="font-weight-bold"><input type="checkbox" checked disabled>
                                    Pertanyaan Unsur</label><br>
                                
                                <label class="font-weight-bold"><input type="checkbox" checked disabled>
                                    Pertanyaan Sub Unsur</label><br>

                            </div>
                        </div>






                    </div>
                    <div class="card-footer">
                        <?php if($manage_survey->is_question == 1): ?>
                        <div class="text-right mt-5">
                            <button type="submit" onclick="return confirm('Apakah anda yakin ingin mengubah tingkatan pertanyaan survei ?')" class="btn btn-primary font-weight-bold btn-sm tombolSimpanTingkatanPertanyaan" <?= $manage_survey->is_survey_close == 1 ? 'disabled' : '' ?>>Update
                                Tingkatan Pertanyaan</button>
                        </div>
                        <?php endif; ?>

                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('javascript'); ?>

<script type="text/javascript">
    $(function() {
        $("#is_aspek").click(function() {
            var is_dimensi = document.getElementById("is_dimensi");
            if(is_aspek.checked){
                is_dimensi.checked = true;
                is_dimensi.disabled = true;
            }else{
                //is_dimensi.checked = false;
                is_dimensi.disabled = false;
            }
        });
    });
</script>

<script>
    $('.form_tingkatan_pertanyaan').submit(function(e) {
        $.ajax({
            url: $(this).attr('action'),
            type: 'POST',
            dataType: 'json',
            data: $(this).serialize(),
            cache: false,
            beforeSend: function() {
                $('.tombolSimpanTingkatanPertanyaan').attr('disabled', 'disabled');
                $('.tombolSimpanTingkatanPertanyaan').html(
                    '<i class="fa fa-spin fa-spinner"></i> Sedang diproses');

                KTApp.block('#content_1', {
                    overlayColor: '#000000',
                    state: 'primary',
                    message: 'Processing...'
                });

                setTimeout(function() {
                    KTApp.unblock('#content_1');
                }, 1000);

            },
            complete: function() {
                $('.tombolSimpanTingkatanPertanyaan').removeAttr('disabled');
                $('.tombolSimpanTingkatanPertanyaan').html('Update Tingkatan Pertanyaan');
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
                    toastr["success"]('Data berhasil disimpan');
                    window.setTimeout(function() {
                        location.reload()
                    }, 1000);
                }
            }
        })
        return false;
    });
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('include_backend/template_backend', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\IT\Documents\Htdocs MAMP\skp_surveiku\application\views/tingkatan_pertanyaan_survei/index.blade.php ENDPATH**/ ?>