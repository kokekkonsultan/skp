<?php
$warna_benner = unserialize($manage_survey->warna_benner);
$warna_benner1 = (isset($warna_benner[0])) ? $warna_benner[0] : "#E4E6EF";
$warna_benner2 = (isset($warna_benner[1])) ? $warna_benner[1] : "#E4E6EF";
$warna_benner3 = (isset($warna_benner[2])) ? $warna_benner[2] : "#E4E6EF";

$title_header = unserialize($manage_survey->title_header_survey);
    $title_1 = $title_header[0];
    $title_2 = $title_header[1];
?>

<div class="alert alert-secondary mb-5" role="alert">
    <i class="flaticon-exclamation-1"></i> Banner akan tampil dibagian header halaman survei
</div>

<!-- <div class="text-right mb-5">
                                <button class=" btn btn-light-primary btn-sm font-weight-bold" type="button" data-toggle="collapse"
                                    data-target="#collapseHeader" aria-expanded="false" aria-controls="collapseExample">
                                    <i class="fa fa-edit"></i> Edit Banner Form Survei
                                </button>
                            </div> -->

<div id="tableBanner">
    <div class="custom-control custom-switch mt-5 mb-5">
        <input type="checkbox" name="setting_banner" class="custom-control-input toggle_banner_1" value="1" id="customBanner1" <?php echo e(($manage_survey->is_benner == '1') ? "checked" : ""); ?> />
        <label class="custom-control-label" for="customBanner1">Menggunakan banner
            gambar</label>
    </div>

    <!-- <div class="collapse" id="collapseHeader"> -->

    <div class="card card-body shadow mb-5">
        <form id="uploadForm">
            <div class="custom-file">
                <input type="file" class="custom-file-input" name="upload" id="profil">
                <label class="custom-file-label" for="validatedCustomFile">Choose
                    file...</label>
            </div>
            <br>
            <div class="alert alert-secondary mt-5" role="alert">
                <small class="text-danger">
                    * Format file harus jpg/png.<br>
                    * Ukuran max file adalah 10MB.<br>
                    * Dimensi banner proporsional 1920px x 465px
                </small>
            </div>
            <!-- <br> -->

            <div class="text-right mt-3">
                <!-- <button class="btn btn-secondary btn-sm" type="button"
                                                data-toggle="collapse" data-target="#collapseHeader"
                                                aria-expanded="false" aria-controls="collapseExample">
                                                Close
                                            </button> -->
                <button type="submit" class="btn btn-primary btn-sm font-weight-bold tombolUploud">Upload</button>
            </div>
        </form>
    </div>
    <!-- </div> -->

    <div class="custom-control custom-switch mt-5 mb-5">
        <input type="checkbox" name="setting_banner" class="custom-control-input toggle_banner_1" value="2" id="customBanner2" <?php echo e(($manage_survey->is_benner == '2') ? "checked" : ""); ?> />
        <label class="custom-control-label" for="customBanner2">Menggunakan banner
            tulisan</label>
    </div>

    <div class="custom-control custom-switch mt-5 mb-5">
        <input type="checkbox" name="setting_banner" class="custom-control-input toggle_banner_1" value="3" id="customBanner3" <?php echo e(($manage_survey->is_benner == '3') ? "checked" : ""); ?> />
        <label class="custom-control-label" for="customBanner3">Menggunakan banner tulisan
            dengan warna solid</label>
        <div id="cp6" class="input-group" style="width: 145px; ">
            <input type="text" name="warna_benner[]" id="warna1" value="<?php echo e($warna_benner1); ?>" class="form-control input-lg" />
            <span class="input-group-append">
                <span class="input-group-text colorpicker-input-addon"><i></i></span>
            </span>
        </div>
    </div>

    <div class="custom-control custom-switch mt-5 mb-5">
        <input type="checkbox" name="setting_banner" class="custom-control-input toggle_banner_1" value="4" id="customBanner4" <?php echo e(($manage_survey->is_benner == '4') ? "checked" : ""); ?> />
        <label class="custom-control-label" for="customBanner4">Menggunakan banner tulisan
            dengan warna gradasi</label>
        <div class="row" style="padding-left:12px; ">
            <div id="cp4" class="input-group" style="width: 145px; float:left; margin-right:10px; ">
                <input type="text" name="warna_benner[]" id="warna2" value="<?php echo e($warna_benner2); ?>" class="form-control input-lg" />
                <span class="input-group-append">
                    <span class="input-group-text colorpicker-input-addon"><i></i></span>
                </span>
            </div>
            <div id="cp5" class="input-group" style="width: 145px; ">
                <input type="text" name="warna_benner[]" id="warna3" value="<?php echo e($warna_benner3); ?>" class="form-control input-lg" />
                <span class="input-group-append">
                    <span class="input-group-text colorpicker-input-addon"><i></i></span>
                </span>
            </div>
        </div>
    </div>

    <div class="custom-control custom-switch mt-5 mb-5">
        <input type="checkbox" name="setting_banner" class="custom-control-input toggle_banner_1" value="5" id="customBanner5" <?php echo e(($manage_survey->is_benner == '5') ? "checked" : ""); ?> />
        <label class="custom-control-label" for="customBanner5">Menggunakan banner tulisan
            dengan logo</label>
    </div>
</div>

<div align="center"><a href="<?php echo base_url() . $ci->session->userdata('username') . '/' . $ci->uri->segment(2) . '/preview-form-survei/opening' ?>" class="btn btn-sm btn-primary font-weight-bold" target="_blank">
        <i class="flaticon-interface-10"></i> Lihat Tampilan
    </a></div><br>


<?php if($manage_survey->is_benner == 2): ?>
<div class="card-header text-dark" style="background-color: #E4E6EF;">
    <div class="text-center font-weight-bold mt-5 mb-5" style="font-family: Helvetica, Arial, sans-serif;">
        <h1 style="font-weight:800;"><?php echo e(strtoupper($title_1)); ?></h1>
        <h3 class="mt-3" style="font-weight:800;"><?php echo e(strtoupper($title_2)); ?></h3>
    </div>
</div>

<?php elseif($manage_survey->is_benner == 3): ?>
<div class="card-header text-dark" id="gantiwarna1" style="background-color: <?= $warna_benner1 ?>;">
    <div class="text-center font-weight-bold mt-5 mb-5" style="font-family: Helvetica, Arial, sans-serif;">
        <h1 style="font-weight:800;"><?php echo e(strtoupper($title_1)); ?></h1>
        <h3 class="mt-3" style="font-weight:800;"><?php echo e(strtoupper($title_2)); ?></h3>
    </div>
</div>

<?php elseif($manage_survey->is_benner == 4): ?>
<div class="card-header text-dark" id="gantiwarna2" style="background-image: linear-gradient(to bottom right, <?= $warna_benner2 . ', ' . $warna_benner3 ?>);">
    <div class="text-center font-weight-bold mt-5 mb-5" style="font-family: Helvetica, Arial, sans-serif;">
        <h1 style="font-weight:800;"><?php echo e(strtoupper($title_1)); ?></h1>
        <h3 class="mt-3" style="font-weight:800;"><?php echo e(strtoupper($title_2)); ?></h3>
    </div>
</div>

<?php elseif($manage_survey->is_benner == 5): ?>
<div class="card-header text-dark" style="background-color: <?= $warna_benner1 ?>;">
    <table class="table table-borderless mt-5" width="100%">
        <tr>
            <td width="15%" style="vertical-align:middle;">
                <img src="<?php echo e(base_url() . 'assets/klien/foto_profile/200px.jpg'); ?>" height="100" width="100" alt="">
            </td>
            <td style="font-family: Helvetica, Arial, sans-serif; vertical-align:middle;">
                <h1 style="font-weight:800;"><?php echo e(strtoupper($title_1)); ?></h1>
                <h3 class="mt-3" style="font-weight:800;"><?php echo e(strtoupper($title_2)); ?></h3>
            </td>
        </tr>
    </table>
</div>

<?php else: ?>

<?php if($manage_survey->img_benner == ''): ?>
<img class="card-img-top" src="<?php echo e(base_url()); ?>assets/img/site/page/banner-survey.jpg" alt="new image" />
<?php else: ?>
<img class="card-img-top shadow" src="<?php echo e(base_url()); ?>assets/klien/benner_survei/<?php echo e($manage_survey->img_benner); ?>" alt="new image">
<?php endif; ?>

<?php endif; ?><?php /**PATH C:\Users\IT\Documents\Htdocs MAMP\skp_surveiku\application\views/form_survei/_include/_benner.blade.php ENDPATH**/ ?>