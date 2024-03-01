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

            <div class="card" data-aos="fade-down">
                <div class="card-header bg-secondary">
                    <h5><?php echo e($title); ?></h5>
                </div>
                <div class="card-body">
                    <span class="text-danger"><?php echo validation_errors(); ?></span>
                    <br>


                    <form action="<?php echo e(base_url() . $ci->session->userdata('username') . '/' . $ci->uri->segment(2) . '/pertanyaan-nps/add'); ?>" method="POST">

                    <div class="row">
                        <label class="col-sm-3 col-form-label
                        font-weight-bold">Isi Pertanyaan <span style="color: red;">*</span></label>
                        <div class="col-sm-9">
                            <textarea class="form-control" type="text" name="isi_pertanyaan" id="isi_pertanyaan"
                                rows="4" placeholder="Isikan Pertanyaan ..." autofocus></textarea>
                        </div>
                    </div>
                    <br>

                    <div class="row">
                        <label class="col-sm-3 col-form-label
                        font-weight-bold">Status Pertanyaan <span style="color: red;">*</span></label>
                        <div class="col-sm-9">
                            <select class="form-control" id="is_active" name="is_required" required>
                                <option>Please Select</option>
                                <option value='1'>Wajib diisi</option>
                                <option value='2'>Tidak Wajid diisi</option>
                            </select>
                        </div>
                    </div>
                    </br>
                    </br>


                    <div class="text-right">
                        <a class="btn btn-secondary font-weight-bold" href="<?php echo e(base_url().$ci->session->userdata('username').'/'.$ci->uri->segment(2).'/pertanyaan-nps'); ?>">Batal</a>
                        <button class="btn btn-primary font-weight-bold" type="submit">Simpan</button>
                    </div>

                    </form>
                </div>
            </div>

        </div>
    </div>

</div>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('javascript'); ?>
<script src="https://cdn.ckeditor.com/ckeditor5/34.2.0/classic/ckeditor.js"></script>
<script>
ClassicEditor
    .create(document.querySelector('#isi_pertanyaan'))
    .then(editor => {
        console.log(editor);
    })
    .catch(error => {
        console.error(error);
    });
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('include_backend/template_backend', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\IT\Documents\Htdocs MAMP\skp_surveiku\application\views/pertanyaan_nps/add.blade.php ENDPATH**/ ?>