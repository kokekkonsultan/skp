

<?php
$ci = get_instance();
?>

<?php $__env->startSection('style'); ?>
<link href="<?php echo e(TEMPLATE_BACKEND_PATH); ?>plugins/custom/datatables/datatables.bundle.css" rel="stylesheet"
    type="text/css">
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="secondary-label">
    Kata Pembuka
</div>

<div class="alert alert-secondary mb-5" role="alert">
    <i class="flaticon-exclamation-1"></i> Kata-kata ini akan ditampilkan pada halaman akhir
    survei.
</div>

<form
    action="<?php echo e(base_url()); ?><?php echo e($ci->session->userdata('username')); ?>/<?php echo e($ci->uri->segment(2)); ?>/form-survei/update-kata-penutup"
    class="form_header">

    <div class="form-group">
        <label class="col-form-label font-weight-bolder">Kata Form Penutup Survei <span
                style="color: red;">*</span></label>
        <textarea name="deskripsi_selesai_survei" id="editor-penutup" rows="8" value="" class="form-control"
            required><?php echo $manage_survey->deskripsi_selesai_survei; ?></textarea>
    </div>

    <div class="text-right">
        <button type="submit" class="btn btn-primary font-weight-bold tombolSimpan">Simpan</button>
    </div>
</form>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('form_preview'); ?>

<div class="text-center" data-aos="fade-up">
    <div id="progressbar" class="mb-5">
        <li class="active" id="account"><strong>Data Responden</strong></li>
        <li class="active" id="personal"><strong>Pertanyaan Survei</strong></li>
        <?php if($manage_survey->is_saran == 1): ?>
        <li class="active" id="payment"><strong>Saran</strong></li>
        <?php endif; ?>
        <li class="active" id="completed"><strong>Completed</strong></li>
    </div>
</div>
<br>
<br>

<div class="card shadow mt-5" data-aos="fade-up">

    <?php echo $__env->make('survei/_include/_benner_survei', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>


    <div class="card-body">

        <div class="text-center">

            <i class="fa fa-check-circle" style="font-size: 72px; color: #32CD32;"></i>

            <br>
            <br>
            <br>


            <div class="font-weight-bold" style="font-size: 15px;">
                <?php echo e($manage_survey->survey_name); ?>

                <br>
                <?php echo $manage_survey->deskripsi_selesai_survei; ?>

            </div>

            <br>
            <br>
        </div>

    </div>
</div>
<br>
<?php echo $__env->make('include_backend.partials_survei.footer_survei', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('javascript'); ?>
<script src="https://cdn.ckeditor.com/ckeditor5/34.2.0/classic/ckeditor.js"></script>
<script src="<?php echo e(base_url()); ?>assets/vendor/bootstrap/js/bootstrap-colorpicker.js"></script>

<!-- <script>
    ClassicEditor
        .create(document.querySelector('#editor'))
        .then(editor => {
            console.log(editor);
        })
        .catch(error => {
            console.error(error);
        });
    ClassicEditor.create(document.querySelector('#editor-penutup'));
</script> -->


<script>
$('.form_header').submit(function(e) {

    $.ajax({
        url: $(this).attr('action'),
        type: 'POST',
        dataType: 'json',
        data: $(this).serialize(),
        cache: false,
        beforeSend: function() {
            $('.tombolSimpan').attr('disabled', 'disabled');
            $('.tombolSimpan').html('<i class="fa fa-spin fa-spinner"></i> Sedang diproses');

        },
        complete: function() {
            $('.tombolSimpan').removeAttr('disabled');
            $('.tombolSimpan').html('Simpan');
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
                toastr["success"]('Data berhasil diubah');
                window.location.reload()
            }
        }
    })
    return false;
});



$(document).ready(function() {
    $('#tablex').on('change', '.toggle_dash_1', function() {
        // alert("TT");
        var mode = $(this).prop('checked');
        var nilai_id = $(this).val();

        $.ajax({

            type: 'POST',
            dataType: 'JSON',
            url: "<?php echo e(base_url()); ?><?php echo e($ci->session->userdata('username')); ?>/<?php echo e($ci->uri->segment(2)); ?>/form-survei/update-is-kata-pembuka",
            data: {
                'mode': mode,
                'nilai_id': nilai_id
            },
            success: function(data) {
                var data = eval(data);
                message = data.message;
                success = data.success;

                toastr["success"](message);
                window.setTimeout(function() {
                    location.reload()
                }, 1000);

            }
        });
    });
});
</script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('setting_form_survei/_include/_template', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\IT\Documents\Htdocs MAMP\skp_surveiku\application\views/setting_form_survei/form_penutup.blade.php ENDPATH**/ ?>