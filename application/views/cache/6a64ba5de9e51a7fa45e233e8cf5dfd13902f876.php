<div class="alert alert-secondary mb-5" role="alert">
    <i class="flaticon-exclamation-1"></i> Jika diaktifkan, maka akan ditampilkan form saran
    survei.
</div>

<form action="<?php echo base_url() . $ci->session->userdata('username') . '/' . $ci->uri->segment(2) . '/form-survei/update-saran' ?>" class="form_saran">

    <div class="form-group row">
        <label class="col-sm-3 col-form-label font-weight-bold">Aktifkan Form Saran <span class="text-danger">*</span></label>
        <div class="col-sm-9">
            <select class="form-control" name="is_saran" value="<?php echo set_value('is_saran'); ?>">
                <option value="1" <?php if ($manage_survey->is_saran == "1") {
                                        echo "selected";
                                    } ?>>Ya</option>
                <option value="2" <?php if ($manage_survey->is_saran == "2") {
                                        echo "selected";
                                    } ?>>Tidak</option>
            </select>
        </div>
    </div>

    <div class="form-group row">
        <label class="col-sm-3 col-form-label font-weight-bold">Judul Form
            Saran <span class="text-danger">*</span></label>
        <div class="col-sm-9">
            <textarea class="form-control" name="judul_form_saran" value="" rows="3"><?php echo $manage_survey->judul_form_saran ?></textarea>
        </div>
    </div>

    <?php if($manage_survey->is_question == 1): ?>
    <div class="text-right">
        <button type="submit" class="btn btn-primary btn-sm font-weight-bold tombolSimpanSaran">Update
            Form
            Saran</button>
    </div>
    <?php endif; ?>
</form><?php /**PATH C:\Users\IT\Documents\Htdocs MAMP\skp_surveiku\application\views/form_survei/_include/_form_saran.blade.php ENDPATH**/ ?>