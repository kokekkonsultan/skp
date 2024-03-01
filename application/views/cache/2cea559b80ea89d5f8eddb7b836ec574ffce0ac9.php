<?php
$ci = get_instance();
?>

<?php $__env->startSection('style'); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="container">
    <div class="card card-custom mb-5" data-aos="fade-down">
        <div class="card-header bg-secondary font-weight-bold">
            <div class="card-title">
                <?php echo e($title); ?>

            </div>
        </div>
        <div class="card-body">

            <form action="<?php echo base_url() . $ci->session->userdata('username') . '/penayang-survei/add' ?>"
                method="POST" enctype="multipart/form-data">

                <span class="text-danger"><?php echo validation_errors(); ?></span>


                <div class="form-group row">
                    <label class="col-sm-2 col-form-label font-weight-bold">Nama Label <span
                            style="color: red;">*</span></label>
                    <div class="col-sm-10">
                        <?php echo form_input($nama_label); ?>

                    </div>
                </div>


                <div class="form-group row">
                    <label class="col-sm-2 col-form-label font-weight-bold">Image Banner <span
                            style="color: red;">*</span></label>
                    <div class="col-sm-10">

                        <div class="custom-file">
                            <input type="file" class="custom-file-input" name="benner" id="profil" required>
                            <label class="custom-file-label" for="validatedCustomFile">Choose
                                file...</label>
                        </div>
                        <br>
                        <small class="text-danger">* Format file harus jpg/png.<br>* Ukuran max
                            file adalah 10MB.</small>
                    </div>
                </div>



                <div class="form-group row">
                    <label class="col-sm-2 col-form-label font-weight-bold">Kata Pembuka <span
                            style="color: red;">*</span></label>
                    <div class="col-sm-10">
                        <?php echo form_textarea($kata_pembuka); ?>

                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-2 col-form-label font-weight-bold">Pilih List Survei <span
                            style="color: red;">*</span></label>
                    <div class="col-sm-10">

                        <?php $__currentLoopData = $manage_survey->result(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="checkbox-list mb-3">
                            <label class="checkbox"><input type="checkbox" name="list_survei[]" value="<?php echo e($row->id); ?>"
                                    class="child">
                                <span></span><?php echo e($row->survey_name); ?></label>
                        </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>


                <div class="form-group row">
                    <label class="col-sm-2 col-form-label font-weight-bold">Kata Penutup</label>
                    <div class="col-sm-10">
                        <?php echo form_textarea($kata_penutup); ?>

                    </div>
                </div>


                <div class="form-group row">
                    <label class="col-sm-2 col-form-label font-weight-bold">Link Penayang <span
                            style="color: red;">*</span></label>
                    <div class="input-group col-sm-10">
                        <div class="input-group-prepend"><span
                                class="input-group-text"><?php echo base_url() . 'survei-list/' ?></span></div>
                        <?php echo form_input($link_penayang); ?>

                    </div>
                </div>




                <div class="form-group row">
                    <label class="col-sm-2 col-form-label font-weight-bold">Jenis Penayangan <span
                            style="color: red;">*</span></label>
                    <div class="col-sm-10">
                        <div>
                            <label><input type="radio" name="jenis_penayang" id="default" value="1" class="customisasi"
                                    required>&nbsp Card</label><br>
                        </div>
                        <div>
                            <label><input type="radio" name="jenis_penayang" id="custom" value="2"
                                    class="customisasi">&nbsp
                                List</label><br>
                        </div>

                    </div>
                    </label>
                </div>



                <div class="text-right mt-3 mb-3">
                    <a class="btn btn-secondary font-weight-bold shadow"
                        href="<?php echo base_url() . $ci->session->userdata('username') . '/penayang-survei' ?>">Batal</a>
                    <button type="submit" class="btn btn-primary font-weight-bold shadow">Simpan</button>
                </div>

            </form>


        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('javascript'); ?>
<script src="https://cdn.ckeditor.com/ckeditor5/34.2.0/classic/ckeditor.js"></script>
<script>
ClassicEditor
    .create(document.querySelector('#kata_pembuka'))
    .then(editor => {
        console.log(editor);
    })
    .catch(error => {
        console.error(error);
    });

ClassicEditor
    .create(document.querySelector('#kata_penutup'))
    .then(editor => {
        console.log(editor);
    })
    .catch(error => {
        console.error(error);
    });
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('include_backend/template_backend', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\IT\Documents\Htdocs MAMP\skp_surveiku\application\views/penayang_survei/add.blade.php ENDPATH**/ ?>