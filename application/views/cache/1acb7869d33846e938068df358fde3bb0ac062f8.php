<div class="card shadow">

    <?php
    $title_header = unserialize($manage_survey->title_header_survey);
    $title_1 = $title_header[0];
    $title_2 = $title_header[1];
    ?>

    <form class="form_header" action="<?php echo base_url() . $ci->session->userdata('username') . '/' . $ci->uri->segment(2) . '/form-survei/update-header' ?>" method="POST">

        <div class="card-body">

            <div class="form-group row">
                <label class="col-sm-2 col-form-label font-weight-bold">Judul <span style="color: red;">*</span></label>
                <div class="col-sm-10">
                    <textarea name="title[]" value="" class="form-control" required><?php echo $title_1 ?></textarea>
                </div>
            </div>

            <div class="form-group row">
                <label class="col-sm-2 col-form-label font-weight-bold">Sub Judul <span style="color: red;">*</span></label>
                <div class="col-sm-10">
                    <textarea name="title[]" value="" class="form-control" required><?php echo $title_2 ?></textarea>
                </div>
            </div>

        </div>
        <div class="card-footer">
            <div class="text-right">
                <button type="submit" class="btn btn-primary font-weight-bold tombolSimpanHeader">Simpan</button>
            </div>
        </div>
    </form>
</div>
<br>

<nav class="navbar navbar-light bg-white shadow">
    <div class="outer-box">
        <div class="box-edge-logo">
            <?php if($data_user->foto_profile == NULL): ?>
            <img src="<?php echo base_url(); ?>assets/klien/foto_profile/200px.jpg" width="100%" class="" alt="">
            <?php else: ?>
            <img src="<?php echo base_url(); ?>assets/klien/foto_profile/<?php echo $data_user->foto_profile ?>" width="100%" class="" alt="">
            <?php endif; ?>

        </div>
        <div class="box-edge-text">
            <div class="box-title">
                <?php echo $title_1 ?>
            </div>
            <div class="box-desc">
                <?php echo $title_2 ?>
            </div>
        </div>
    </div>

    

</nav>
<div class="alert alert-secondary mt-5 mb-5" role="alert">
    <i class="flaticon-exclamation-1"></i> Logo akan tampil dibagian header dan cover
    laporan survei
</div><?php /**PATH C:\Users\IT\Documents\Htdocs MAMP\skp_surveiku\application\views/form_survei/_include/_judul.blade.php ENDPATH**/ ?>