<?php
$ci = get_instance();
$ci->load->helper('form');
?>

<form
    action="<?php echo e(base_url() . $ci->session->userdata('username') . '/' . $ci->uri->segment(2) . '/pertanyaan-unsur/update-detail-alur'); ?>"
    method="POST" class="form_default">

    <table class="table table-bordered table-hover">
        
        <tr class="bg-secondary">
            <td class="font-weight-bold">Pilihan Jawaban</td>
            <td class="font-weight-bold">Action</td>
        </tr>


        <?php $__currentLoopData = $kategori_unsur->result(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <tr>
            <td><input name="id_kategori[]" value="<?php echo $row->id ?>" hidden>
                <?php echo $row->nama_kategori_unsur_pelayanan ?></td>
            <td>
                <select class="form-control form-control-sm" name="is_next_step[]">

                    <?php
                    $pertanyaan_terbuka = $ci->db->get_where("pertanyaan_terbuka_$manage_survey->table_identity", array('id_unsur_pelayanan' => $row->id_unsur_pelayanan));

                    $last_row = $pertanyaan_terbuka->last_row();
                    $number_next = substr($last_row->nomor_pertanyaan_terbuka, 1) + 1;
                    ?>

                    <?php $__currentLoopData = $pertanyaan_terbuka->result(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($value->nomor_pertanyaan_terbuka); ?>" <?php echo $row->is_next_step == $value->nomor_pertanyaan_terbuka ? 'selected' : '' ?>>Lanjutkan Ke <?php echo e($value->nomor_pertanyaan_terbuka); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                    <option value="T<?php echo e($number_next); ?>" <?php echo $row->is_next_step == 'T' . $number_next ? 'selected' : '' ?>>Lanjutkan Ke Pertanyaan Unsur Berikutnya</option>

                </select>
            </td>
        </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

    </table>


    <div class="text-right mt-8">
        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary btn-sm tombolDefault">Simpan</button>
    </div>
</form>




<script>
$('.form_default').submit(function(e) {

    $.ajax({
        url: $(this).attr('action'),
        type: 'POST',
        dataType: 'json',
        data: $(this).serialize(),
        cache: false,
        beforeSend: function() {
            $('.tombolDefault').attr('disabled', 'disabled');
            $('.tombolDefault').html(
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
            $('.tombolDefault').removeAttr('disabled');
            $('.tombolDefault').html('Simpan');
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
                table.ajax.reload();
                // window.setTimeout(function() {
                //     location.reload()
                // }, 1500);
            }
        }
    })
    return false;
});
</script><?php /**PATH C:\Users\IT\Documents\Htdocs MAMP\skp_surveiku\application\views/pertanyaan_unsur_survei/detail_alur.blade.php ENDPATH**/ ?>