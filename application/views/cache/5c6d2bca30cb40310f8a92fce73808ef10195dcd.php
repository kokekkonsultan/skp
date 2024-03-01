<form class="form_header" action="<?php echo e(base_url() . $ci->session->userdata('username') . '/' . $ci->uri->segment(2) . '/form-survei/update-font-text'); ?>" method="POST">

    <?php
    $font_text_header = unserialize($manage_survey->font_text_header);
    $font_type_header = $font_text_header[0];
    $font_size_header = $font_text_header[1];
    $font_color_header = $font_text_header[2];

    $font_text_body = unserialize($manage_survey->font_text_body);
    $font_type_body = $font_text_body[0];
    $font_size_body = $font_text_body[1];
    $font_color_body = $font_text_body[2];
    ?>

    <h6 class="text-primary">Text Header</h6>
    <hr>

    <div id="tanggal_survei">
        <?php
        $checked_tgl = ($manage_survey->is_display_tanggal_survei == 'true') ? "checked" : "";
        ?>
        <div class="custom-control custom-switch mb-3">
            <input type="checkbox" name="is_display_tanggal_survei" class="custom-control-input toggle_tanggal_1" value="<?php echo e($manage_survey->id); ?>" id="customSwitch2" <?php echo e($checked_tgl); ?> />
            <label class="custom-control-label font-weight-bold" for="customSwitch2">Tampilkan Tanggal Survei</label>
        </div>
    </div>

    <div class="alert alert-secondary mb-10" role="alert">
        <i class="flaticon-exclamation-1"></i> Tanggal Survei akan ditampilkan diatas form survei.
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label class="form-label font-weight-bold">Font Type <b class="text-danger">*</b></label>
                <select class="form-control" name="font_type_header" required>

                    <?php $__currentLoopData = $ci->db->get("fonts_google")->result(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($row->id); ?>" <?php echo e($row->id == $font_type_header ? 'selected' : ''); ?>><?php echo e($row->fonts_name); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
        </div>

        <div class="col-md-3">
            <div class="form-group">
                <label class="form-label font-weight-bold">Size <b class="text-danger">*</b></label>
                <select class="form-control" name="font_size_header" required>
                    <?php for($x = 10; $x <= 20; $x++): ?> <option value="<?php echo e($x); ?>" <?php echo e($x == $font_size_header ? 'selected' : ''); ?>><?php echo e($x); ?></option>
                        <?php endfor; ?>
                </select>
            </div>
        </div>

        <div class="col-md-3">
            <div class="form-group">
                <label class="form-label font-weight-bold">Color <b class="text-danger">*</b></label>
                <input class="form-control" type="color" name="font_color_header" value="<?php echo e($font_color_header); ?>" required>
            </div>
        </div>
    </div>


    <h6 class="text-primary mt-5">Text Body</h6>
    <hr>

    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label class="form-label font-weight-bold">Font Type <b class="text-danger">*</b></label>
                <select class="form-control" name="font_type_body" required>

                    <?php $__currentLoopData = $ci->db->get("fonts_google")->result(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($row->id); ?>" <?php echo e($row->id == $font_type_body ? 'selected' : ''); ?>><?php echo e($row->fonts_name); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
        </div>

        <div class="col-md-3">
            <div class="form-group">
                <label class="form-label font-weight-bold">Size <b class="text-danger">*</b></label>
                <select class="form-control" name="font_size_body" required>
                    <?php for($x = 10; $x <= 20; $x++): ?> <option value="<?php echo e($x); ?>" <?php echo e($x == $font_size_body ? 'selected' : ''); ?>><?php echo e($x); ?></option>
                        <?php endfor; ?>
                </select>
            </div>
        </div>

        <div class="col-md-3">
            <div class="form-group">
                <label class="form-label font-weight-bold">Color <b class="text-danger">*</b></label>
                <input class="form-control" type="color" name="font_color_body" value="<?php echo e($font_color_body); ?>" required>
            </div>
        </div>
    </div>

    <div class="text-right mt-3">
        <button type="submit" class="btn btn-primary font-weight_bold tombolSimpanHeader">Simpan</button>
    </div>
</form><?php /**PATH C:\Users\IT\Documents\Htdocs MAMP\skp_surveiku\application\views/form_survei/_include/_font_text.blade.php ENDPATH**/ ?>