<?php
$ci = get_instance();
?>

<div class="" id="primary-menu" onMouseOver="show('in-primary-label')" onMouseOut="hide('in-primary-label')">
    <div class="" id="sub-primary-menu">

        <div class="in-primary-group">
            <div class="in-primary-menu">
                <img src="<?php echo e(base_url()); ?>assets/img/site/logo/logo-dark2.png" alt="" width="30px">
            </div>
        </div>


        <div class="in-primary-group">
            <div class="in-primary-menu">
                <a href="#">
                    <i class="fas fa-heading" <?= $ci->uri->segment(3) == 'setting-form-survei' && $ci->uri->segment(4) == NULL ? 'style="color: #ffffff;"' : ''?>></i>
                </a>
            </div>
            <div class="in-primary-label">
                <a href="<?php echo e(base_url() . $ci->session->userdata('username') . '/' . $ci->uri->segment(2) . '/setting-form-survei'); ?>"
                    <?= $ci->uri->segment(3) == 'setting-form-survei' && $ci->uri->segment(4) == NULL ? 'style="color: #ffffff;"' : ''?>>
                    Judul Form
                </a>
            </div>
        </div>


        <div class="in-primary-group">
            <div class="in-primary-menu">
                <a href="#">
                    <i class="fas fa-image"
                        <?= $ci->uri->segment(4) == 'form-benner' ? 'style="color: #ffffff;"' : '' ?>></i>
                </a>
            </div>
            <div class="in-primary-label">
                <a href="<?php echo e(base_url() . $ci->session->userdata('username') . '/' . $ci->uri->segment(2) . '/setting-form-survei/form-benner'); ?>"
                    <?= $ci->uri->segment(4) == 'form-benner' ? 'style="color: #ffffff;"' : '' ?>>
                    Banner
                </a>
            </div>
        </div>


        <div class="in-primary-group">
            <div class="in-primary-menu">
                <a href="#">
                    <i class="fas fa-book-open"
                        <?= $ci->uri->segment(4) == 'form-pembuka' ? 'style="color: #ffffff;"' : ''?>></i>
                </a>
            </div>
            <div class="in-primary-label">
                <a href="<?php echo e(base_url() . $ci->session->userdata('username') . '/' . $ci->uri->segment(2) . '/setting-form-survei/form-pembuka'); ?>"
                    <?= $ci->uri->segment(4) == 'form-pembuka' ? 'style="color: #ffffff;"' : '' ?>>
                    Kata Pembuka
                </a>
            </div>
        </div>
       

        <div class="in-primary-group">
            <div class="in-primary-menu">
                <a href="#">
                    <i class="fas fa-text-height"
                        <?= $ci->uri->segment(4) == 'form-font-text' ? 'style="color: #ffffff;"' : '' ?>></i>
                </a>
            </div>
            <div class="in-primary-label">
                <a href="<?php echo e(base_url() . $ci->session->userdata('username') . '/' . $ci->uri->segment(2) . '/setting-form-survei/form-font-text'); ?>"
                    <?= $ci->uri->segment(4) == 'form-font-text' ? 'style="color: #ffffff;"' : '' ?>>
                    Gaya Teks
                </a>
            </div>
        </div>


        <div class="in-primary-group">
            <div class="in-primary-menu">
                <a href="#">
                    <i class="fas fa-toggle-on"
                        <?= $ci->uri->segment(4) == 'form-tombol' ? 'style="color: #ffffff;"' : ''?>></i>
                </a>
            </div>
            <div class="in-primary-label">
                <a href="<?php echo e(base_url() . $ci->session->userdata('username') . '/' . $ci->uri->segment(2) . '/setting-form-survei/form-tombol'); ?>"
                    <?= $ci->uri->segment(4) == 'form-tombol' ? 'style="color: #ffffff;"' : ''?>>
                    Gaya Tombol
                </a>
            </div>
        </div>


    <!-- <div class="in-primary-group">
            <div class="in-primary-menu">
                <a href="#">
                    <i class="fas fa-fill"></i>
                </a>
            </div>
            <div class="in-primary-label">
                <a href="#">
                    Latar Belakang
                </a>
            </div>
        </div> -->


        <div class="in-primary-group">
            <div class="in-primary-menu">
                <a href="#">
                    <i class="fas fa-file-signature"
                        <?= $ci->uri->segment(4) == 'form-saran' ? 'style="color: #ffffff;"' : ''?>></i>
                </a>
            </div>
            <div class="in-primary-label">
                <a href="<?php echo e(base_url() . $ci->session->userdata('username') . '/' . $ci->uri->segment(2) . '/setting-form-survei/form-saran'); ?>"
                    <?= $ci->uri->segment(4) == 'form-saran' ? 'style="color: #ffffff;"' : ''?>>
                    Form Saran
                </a>
            </div>
        </div>


        <div class="in-primary-group">
            <div class="in-primary-menu">
                <a href="#">
                    <i class="fas fa-file-export" <?= $ci->uri->segment(4) == 'form-penutup' ? 'style="color: #ffffff;"' : '' ?>></i>
                </a>
            </div>
            <div class="in-primary-label">
                <a href="<?php echo e(base_url() . $ci->session->userdata('username') . '/' . $ci->uri->segment(2) . '/setting-form-survei/form-penutup'); ?>"
                    <?= $ci->uri->segment(4) == 'form-penutup' ? 'style="color: #ffffff;"' : '' ?>>
                    Kata Penutup
                </a>
            </div>
        </div>


        <!-- <div class="in-primary-group">
            <div class="in-primary-menu">
                <a href="#">
                    <i class="fas fa-tasks"></i>
                </a>
            </div>
            <div class="in-primary-label">
                <a href="#">
                    Progres Bar
                </a>
            </div>
        </div> -->

        <div class="in-primary-group">
            <div class="in-primary-menu">
                <a href="#">
                    <i class="fas fa-tasks"  <?= $ci->uri->segment(3) == 'alur-pertanyaan-lompat' ? 'style="color: #ffffff;"' : ''?>></i>
                </a>
            </div>
            <div class="in-primary-label">
                <a href="<?php echo e(base_url() . $ci->session->userdata('username') . '/' . $ci->uri->segment(2) . '/alur-pertanyaan-lompat'); ?>"
                <?= $ci->uri->segment(3) == 'alur-pertanyaan-lompat' ? 'style="color: #ffffff;"' : '' ?>>
                    Alur Pertanyaan Lompat
                </a>
            </div>
        </div>

        
        <div class="in-primary-group">
            <div class="in-primary-menu">
                <a href="#">
                    <i class="fas fa-chevron-circle-left"></i>
                </a>
            </div>
            <div class="in-primary-label">
                <a href="<?php echo e(base_url() . $ci->session->userdata('username') . '/' . $ci->uri->segment(2) . '/do'); ?>">
                    Kembali
                </a>
            </div>
        </div>

    </div>
</div><?php /**PATH C:\Users\IT\Documents\Htdocs MAMP\skp_surveiku\application\views/setting_form_survei/_include/_nav_menu.blade.php ENDPATH**/ ?>