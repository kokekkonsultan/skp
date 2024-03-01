<form class="form_header" action="<?php echo e(base_url() . $ci->session->userdata('username') . '/' . $ci->uri->segment(2) . '/form-survei/update-font-button'); ?>" method="POST">

    <?php
    $font_btn_next = unserialize($manage_survey->font_btn_next);
    $font_type_next = $font_btn_next[0];
    $font_size_next = $font_btn_next[1];
    $font_color_next = $font_btn_next[2];
    $btn_color_next = $font_btn_next[3];

    $font_btn_back = unserialize($manage_survey->font_btn_back);
    $font_type_back = $font_btn_back[0];
    $font_size_back = $font_btn_back[1];
    $font_color_back = $font_btn_back[2];
    $btn_color_back = $font_btn_back[3];
    ?>

    <h6 class="text-primary">Tombol Lanjut</h6>
    <hr>

    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label class="form-label font-weight-bold">Font Type <b class="text-danger">*</b></label>
                <select class="form-control" name="font_type_next" required>
                    <?php $__currentLoopData = $ci->db->get("fonts_google")->result(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($row->id); ?>" <?php echo e($row->id == $font_type_next ? 'selected' : ''); ?>><?php echo e($row->fonts_name); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
        </div>

        <div class="col-md-2">
            <div class="form-group">
                <label class="form-label font-weight-bold">Font Size <b class="text-danger">*</b></label>
                <select class="form-control" name="font_size_next" required>
                    <?php for($x = 10; $x <= 20; $x++): ?>
                    <option value="<?php echo e($x); ?>" <?php echo e($x == $font_size_next ? 'selected' : ''); ?>><?php echo e($x); ?></option>
                    <?php endfor; ?>
                </select>
            </div>
        </div>

        <div class="col-md-2">
            <div class="form-group">
                <label class="form-label font-weight-bold">Font Color <b class="text-danger">*</b></label>
                <input class="form-control" type="color" name="font_color_next" value="<?php echo e($font_color_next); ?>" required>
            </div>
        </div>

        <div class="col-md-2">
            <div class="form-group">
                <label class="form-label font-weight-bold">Button Color <b class="text-danger">*</b></label>
                <input class="form-control" type="color" name="btn_color_next" value="<?php echo e($btn_color_next); ?>" required>
            </div>
        </div>
    </div>


    <h6 class="text-primary mt-5">Tombol Kembali</h6>
    <hr>

    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label class="form-label font-weight-bold">Font Type <b class="text-danger">*</b></label>
                <select class="form-control" name="font_type_back" required>
                    <?php $__currentLoopData = $ci->db->get("fonts_google")->result(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($row->id); ?>" <?php echo e($row->id == $font_type_back ? 'selected' : ''); ?>><?php echo e($row->fonts_name); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
        </div>

        <div class="col-md-2">
            <div class="form-group">
                <label class="form-label font-weight-bold">Font Size <b class="text-danger">*</b></label>
                <select class="form-control" name="font_size_back" required>
                    <?php for($x = 10; $x <= 20; $x++): ?>
                    <option value="<?php echo e($x); ?>" <?php echo e($x == $font_size_back ? 'selected' : ''); ?>><?php echo e($x); ?></option>
                        <?php endfor; ?>
                </select>
            </div>
        </div>

        <div class="col-md-2">
            <div class="form-group">
                <label class="form-label font-weight-bold">Font Color <b class="text-danger">*</b></label>
                <input class="form-control" type="color" name="font_color_back" value="<?php echo e($font_color_back); ?>" required>
            </div>
        </div>

        <div class="col-md-2">
            <div class="form-group">
                <label class="form-label font-weight-bold">Button Color <b class="text-danger">*</b></label>
                <input class="form-control" type="color" name="btn_color_back" value="<?php echo e($btn_color_back); ?>" required>
            </div>
        </div>
    </div>

    <div class="text-right mt-3">
        <button type="submit" class="btn btn-primary font-weight_bold tombolSimpanHeader">Simpan</button>
    </div>
</form><?php /**PATH C:\Users\IT\Documents\Htdocs MAMP\skp_surveiku\application\views/form_survei/_include/_font_button.blade.php ENDPATH**/ ?>