

<?php
$ci = get_instance();
?>

<?php $__env->startSection('style'); ?>
<link href="<?php echo e(TEMPLATE_BACKEND_PATH); ?>plugins/custom/datatables/datatables.bundle.css" rel="stylesheet" type="text/css">
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="secondary-label">
    Judul & Sub Judul
</div>


<?php
$title_header = unserialize($manage_survey->title_header_survey);
$title_1 = $title_header[0];
$title_2 = $title_header[1];
?>


<div>
    <form class="form_header" action="<?php echo base_url() . $ci->session->userdata('username') . '/' . $ci->uri->segment(2) . '/form-survei/update-header' ?>" method="POST">
        <div class="form-group">
            <label class="col-form-label font-weight-bolder">Judul <span style="color: red;">*</span></label>
            <textarea name="title[]" value="" class="form-control" required><?php echo $title_1 ?></textarea>
        </div>

        <div class="form-group">
            <label class="col-form-label font-weight-bolder">Sub Judul <span style="color: red;">*</span></label>
            <textarea name="title[]" value="" class="form-control" required><?php echo $title_2 ?></textarea>
        </div>


        <div class="text-right">
            <button type="submit" class="btn btn-primary font-weight-bold tombolSimpanHeader">Simpan</button>
        </div>
    </form>
</div>

<div class="alert alert-secondary mt-5 mb-5" role="alert">
    <i class="fa fa-info-circle"></i> Logo akan tampil dibagian header dan cover
    laporan survei
</div>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('form_preview'); ?>
<div class="card card-body shadow">


    <table class="table table-borderless" width="100%">
        <tr>
            <td width="10%" style="vertical-align:middle;">
                <img src="<?php echo e(base_url() . 'assets/klien/foto_profile/200px.jpg'); ?>" height="85" width="85" alt="">
            </td>
            <td style="vertical-align:middle; font-size:18px;">  <!-- class="font-text-header"-->
                <span class="font-weight-bolder"><?php echo e(strtoupper($title_1)); ?></span>
                <br>
                <span class="font-weight-bolder mt-3"><?php echo e(strtoupper($title_2)); ?></span>
            </td>
        </tr>
    </table>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('javascript'); ?>

<script>
    $('.form_header').submit(function(e) {

    $.ajax({
        url: $(this).attr('action'),
        type: 'POST',
        dataType: 'json',
        data: $(this).serialize(),
        cache: false,
        beforeSend: function() {
            $('.tombolSimpanHeader').attr('disabled', 'disabled');
            $('.tombolSimpanHeader').html('<i class="fa fa-spin fa-spinner"></i> Sedang diproses');

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
            $('.tombolSimpanHeader').removeAttr('disabled');
            $('.tombolSimpanHeader').html('Simpan');
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
</script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('setting_form_survei/_include/_template', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\IT\Documents\Htdocs MAMP\skp_surveiku\application\views/setting_form_survei/form_judul.blade.php ENDPATH**/ ?>