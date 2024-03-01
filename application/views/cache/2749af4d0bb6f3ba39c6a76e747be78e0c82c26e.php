<?php
$ci = get_instance();
?>

<?php $__env->startSection('style'); ?>
<link rel="dns-prefetch" href="//fonts.gstatic.com">
<link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">


<style>
    .select2-container .select2-selection--single {
        /* height: 35px; */
        font-size: 1rem;
    }
</style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

<div class="container mt-5 mb-5" style="">
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
            <div class="card shadow mb-4 mt-4" data-aos="fade-up" style="">

                <?php echo $__env->make('survei/_include/_benner_survei', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

                <div class="card-header text-center">
					<h3 class="mt-5" style="font-family: 'Exo 2', sans-serif;"><b>DATA RESPONDEN</b></h3>
					<?php echo $__env->make('include_backend/partials_backend/_tanggal_survei', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                </div>
                <div class="card-body">

                    <?php echo $__env->make('include_backend/partials_backend/_message', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>


                    <form action="<?php echo e(base_url() . 'survei/' . $ci->uri->segment(2) . '/data-responden/' . $ci->uri->segment(4) . '/update'); ?>" class="form_responden" method="POST">


                        <span style="color: red; font-style: italic;"><?php echo validation_errors(); ?></span>

                        <?php if($manage_survey->is_layanan_survei != 0): ?>
                        <div class="form-group">
                            <label for="layanan_survei" class="font-weight-bold">Layanan Survei <span class="text-danger">*</span></label>
                            <?php echo form_dropdown($id_layanan_survei); ?>

                        </div>
                        <br>
                        <?php endif; ?>



                        <?php $__currentLoopData = $profil_responden->result(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php
                        $nama_alias = $row->nama_alias;
                        $nama_alias_lainnya = $row->nama_alias. '_lainnya';
                        ?>

                        <div class="form-group">
                            <label class="font-weight-bold"><?php echo e($row->nama_profil_responden); ?><span class="text-danger">*</span></label>

                            <?php if($row->jenis_isian == 2): ?>
                            <input class="form-control" type="<?php echo e($row->type_data); ?>" name="<?php echo e($row->nama_alias); ?>" placeholder="Masukkan data anda ..." value="<?php echo $responden->$nama_alias; ?>" required>

                            <?php else: ?>
                            <select class="form-control" name="<?php echo e($row->nama_alias); ?>" id="<?php echo e($row->nama_alias); ?>" required>
                                <option value="">Please Select</option>

                                <?php $__currentLoopData = $kategori_profil_responden->result(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php if($value->id_profil_responden == $row->id): ?>

                                <option value="<?php echo e($value->id); ?>" id="<?php echo e($value->nama_kategori_profil_responden); ?>" <?php echo $responden->$nama_alias == $value->id ? 'selected' : '' ?>>
                                    <?php echo $value->nama_kategori_profil_responden; ?>

                                </option>

                                <?php endif; ?>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                            </select>

                            <?php if($row->is_lainnya == 1): ?>
                            <input class="form-control mt-5" type="text" name="<?php echo e($row->nama_alias); ?>_lainnya" id="<?php echo e($row->nama_alias); ?>_lainnya" placeholder="Sebutkan Lainnya ..." value="<?php echo $responden->$nama_alias_lainnya; ?>" <?php echo $responden->$nama_alias_lainnya == '' ? 'style="display: none;"' : ' required' ?>>
                            <?php endif; ?>

                            <?php endif; ?>
                        </div>

                        </br>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>


                </div>
                <div class="card-footer">
                    <table class="table table-borderless">
                        <tr>
                            <td class="text-right">
                                <button type="submit" class="btn btn-next btn-lg shadow tombolSave">Selanjutnya</button>
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
<?php
if($ci->uri->segment(5) == 'edit'){
    $segment5 = '/edit';
} else {
    $segment5 = '';
}
?>
<script>
    $('.form_responden').submit(function(e) {

        $.ajax({
            url: $(this).attr('action'),
            type: 'POST',
            dataType: 'json',
            data: $(this).serialize(),
            cache: false,
            beforeSend: function() {
                $('.tombolCancel').attr('disabled', 'disabled');
                $('.tombolSave').attr('disabled', 'disabled');
                $('.tombolSave').html('<i class="fa fa-spin fa-spinner"></i> Sedang diproses');

                KTApp.block('#kt_blockui_content', {
                    overlayColor: '#FFA800',
                    state: 'primary',
                    message: 'Processing...'
                });

                setTimeout(function() {
                    KTApp.unblock('#kt_blockui_content');
                }, 500);

            },
            complete: function() {
                $('.tombolCancel').removeAttr('disabled');
                $('.tombolSave').removeAttr('disabled');
                $('.tombolSave').html('Selanjutnya');
            },

            error: function(e) {
                Swal.fire(
                    'Gagal Menyimpan Data Survei!',
                    e,
                    'error'
                );
                setTimeout(function() {
                    location.reload();
                }, 500);
            },

            success: function(data) {
                if (data.validasi) {
                    $('.pesan').fadeIn();
                    $('.pesan').html(data.validasi);
                }
                if (data.sukses) {
                    // toastr["success"]('Data berhasil disimpan');

                    setTimeout(function() {
                        window.location.href =
                            "<?php echo e(base_url() . 'survei/' . $ci->uri->segment(2) . '/pertanyaan/' . $ci->uri->segment(4) . $segment5); ?>";
                    }, 500);
                }
            }
        })
        return false;
    });
</script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<?php
$profil_responden_js = $ci->db->query("SELECT * FROM
profil_responden_$manage_survey->table_identity WHERE jenis_isian = 1 && is_lainnya = 1");
?>

<?php $__currentLoopData = $profil_responden_js->result(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pr_js): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<script type='text/javascript'>
    $(window).load(function() {
        $("#<?php echo e($pr_js->nama_alias); ?>").change(function() {
            console.log(document.getElementById("<?php echo e($pr_js->nama_alias); ?>").options['Lainnya'].selected);

            if (document.getElementById("<?php echo e($pr_js->nama_alias); ?>").options['Lainnya'].selected == true) {
                $('#<?php echo e($pr_js->nama_alias); ?>_lainnya').show().prop('required', true);
            } else {
                $('#<?php echo e($pr_js->nama_alias); ?>_lainnya').removeAttr('required').hide();
            }
        });
    });
</script>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>



<script>
    $(document).ready(function() {
        $("#id_layanan_survei").select2({
            placeholder: "   Please Select",
            allowClear: true,
            closeOnSelect: true,
        });
    });
</script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('include_backend/_template', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\IT\Documents\Htdocs MAMP\skp_surveiku\application\views/survei/data_responden/edit_data_responden.blade.php ENDPATH**/ ?>