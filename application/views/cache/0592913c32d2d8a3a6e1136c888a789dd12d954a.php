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

            <form
                action="<?php echo base_url() . $ci->session->userdata('username') . '/penayang-survei/edit/' . $ci->uri->segment(4) ?>"
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

                        <span class="text-warning font weight-bold"><b>Gambar sebelumnya</b></span><br>
                        <img src="<?php echo e(base_url()); ?>assets/klien/benner_penayang/<?php echo e($penayang_survei->img_benner); ?>"
                            alt="" width=100%">
                        <br>
                        <br>


                        <div class="custom-file">
                            <input type="file" class="custom-file-input" name="benner" id="profil">
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
                        <label class=""><input type="checkbox" name="list_survei" value="<?php echo e($row->id); ?>" class="child"
                                checked disabled>&nbsp<?php echo e($row->survey_name); ?></label>
                        <br>
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

                <br>


                <div class="form-group row">
                    <label class="col-sm-2 col-form-label font-weight-bold">Jenis Penayangan <span
                            style="color: red;">*</span></label>
                    <div class="col-sm-10">
                        <div>
                            <label><input type="radio" name="jenis_penayang" id="default" value="1" class="customisasi"
                                    <?php echo $penayang_survei->jenis_penayang == '1' ? 'checked' : '' ?>>&nbsp
                                Card</label>
                        </div>
                        <hr>
                        <div>
                            <label>
                                <input type="radio" name="jenis_penayang" id="custom" value="2" class="customisasi"
                                    <?php echo $penayang_survei->jenis_penayang == '2' ? 'checked' : '' ?>>&nbsp
                                List</label>
                        </div>

                    </div>
                    </label>
                </div>

                <br>

                <table width="100%" class="mt-5">
                    <tr>
                        <td class="text-left">
                            <a class="btn btn-danger font-weight-bold" href="javascript:void(0)"
                                title="Hapus <?php echo $penayang_survei->nama_label ?>"
                                onclick="delete_data('<?php echo $penayang_survei->id ?>')"><i class="fa fa-trash"></i>
                                Delete Penayang Survei</a>
                        </td>
                        <td class="text-right">
                            <a class="btn btn-secondary font-weight-bold shadow"
                                href="<?php echo base_url() . $ci->session->userdata('username') . '/penayang-survei' ?>">Batal</a>
                            <button type="submit" class="btn btn-primary font-weight-bold shadow">Simpan</button>
                        </td>
                    </tr>
                </table>

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



function delete_data() {
    if (confirm('Are you sure delete this data?')) {
        $.ajax({
            url: "<?php echo base_url() . $ci->session->userdata('username') . '/penayang-survei/delete/' . $ci->uri->segment(4) ?>",
            type: "POST",
            dataType: "JSON",
            success: function(data) {
                if (data.status) {

                    Swal.fire(
                        'Informasi',
                        'Berhasil menghapus data',
                        'success'
                    );
                    window.location.href =
                        "<?php echo base_url() . $ci->session->userdata('username') . '/penayang-survei/' ?>";
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
                window.location.href =
                    "<?php echo base_url() . $ci->session->userdata('username') . '/penayang-survei/' ?>";
            }
        });

    }
}
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('include_backend/template_backend', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\IT\Documents\Htdocs MAMP\skp_surveiku\application\views/penayang_survei/edit.blade.php ENDPATH**/ ?>