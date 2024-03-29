<?php
$ci = get_instance();
$ci->load->helper('form');
?>

<form
    action="<?php echo e(base_url() . $ci->session->userdata('username') . '/' . $ci->uri->segment(2) . '/pertanyaan-terbuka/update-detail-alur'); ?>"
    method="POST" class="form_default">

    <table class="table table-bordered table-hover">

        <tr class="bg-secondary">
            <td class="font-weight-bold">Pilihan Jawaban</td>
            <td class="font-weight-bold">Action</td>
        </tr>


        <?php $__currentLoopData = $kategori_terbuka->result(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <tr>
            <td><input name="id_kategori[]" value="<?php echo $row->id_kategori ?>" hidden>
                <?php echo $row->pertanyaan_ganda ?></td>
            <td>
                <select class="form-control form-control-sm" name="is_next_step[]">

                    <?php
                    $object = $ci->db->get_where("pertanyaan_terbuka_$manage_survey->table_identity", array('id' =>
                    $ci->uri->segment(5)))->row();
                    $nomor_pertanyaan_terbuka = substr($object->nomor_pertanyaan_terbuka,1);

                    if($object->is_letak_pertanyaan == 1){
                    $pertanyaan_terbuka = $ci->db->query("SELECT * FROM
                    pertanyaan_terbuka_$manage_survey->table_identity WHERE is_letak_pertanyaan = 1 &&
                    SUBSTR(nomor_pertanyaan_terbuka,2) > $nomor_pertanyaan_terbuka");

                    } elseif($object->is_letak_pertanyaan == 2) {
                    $pertanyaan_terbuka = $ci->db->query("SELECT * FROM
                    pertanyaan_terbuka_$manage_survey->table_identity WHERE is_letak_pertanyaan = 2 &&
                    SUBSTR(nomor_pertanyaan_terbuka,2) > $nomor_pertanyaan_terbuka");


                    } else {
                    $pertanyaan_terbuka = $ci->db->query("SELECT * FROM
                    pertanyaan_terbuka_$manage_survey->table_identity WHERE id_unsur_pelayanan =
                    $object->id_unsur_pelayanan && SUBSTR(nomor_pertanyaan_terbuka,2) > $nomor_pertanyaan_terbuka");

                    }
                    $last_row = $pertanyaan_terbuka->last_row();
                    $number_next = substr($last_row->nomor_pertanyaan_terbuka, 1) + 1
                    ?>


                    <?php $__currentLoopData = $pertanyaan_terbuka->result(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($value->nomor_pertanyaan_terbuka); ?>"
                        <?php echo $row->is_next_step == $value->nomor_pertanyaan_terbuka ? 'selected' : '' ?>>Lanjutkan
                        Ke <?php echo e($value->nomor_pertanyaan_terbuka); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                    <option value="T<?php echo e($number_next); ?>"
                        <?php echo $row->is_next_step == 'T' . $number_next ? 'selected' : '' ?>>Lanjutkan Ke Pertanyaan
                        Unsur Berikutnya</option>

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
</script><?php /**PATH C:\Users\IT\Documents\Htdocs MAMP\skp_surveiku\application\views/pertanyaan_terbuka_survei/detail_alur.blade.php ENDPATH**/ ?>