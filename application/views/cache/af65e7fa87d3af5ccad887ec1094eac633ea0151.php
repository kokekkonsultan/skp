<?php
$ci = get_instance();
?>

<?php $__env->startSection('style'); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

<div class="container-fluid">
    <?php echo $__env->make("include_backend/partials_no_aside/_inc_menu_repository", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <div class="row mt-5">
        <div class="col-md-3">
            <?php echo $__env->make('manage_survey/menu_data_survey', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        </div>
        <div class="col-md-9">

            <?php if($ci->uri->segment(5) != ''): ?>
            <div class="alert alert-custom alert-notice alert-light-dark fade show" role="alert">
                <div class="alert-icon"><i class="flaticon-warning"></i></div>
                <div class="alert-text">Lanjutkan Mengisi Pertanyaan Sub Unsur Pelayanan</div>
                <div class="alert-close">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true"><i class="ki ki-close"></i></span>
                    </button>
                </div>
            </div>
            <?php endif; ?>

            <div class="card" data-aos="fade-down">
                <div class="card-header bg-secondary">
                    <h5><?php echo e($title); ?></h5>
                </div>
                <div class="card-body">
                    <span class="text-danger"><?php echo validation_errors(); ?></span>
                    <br>
                    <?php echo form_open(base_url() . $ci->session->userdata('username') . '/' . $ci->uri->segment(2) . '/pertanyaan-unsur/add-sub'); ?>


                    <?php if($ci->uri->segment(5) == ''): ?>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label
                        font-weight-bold">Sub Unsur Dari <span style="color: red;">*</span></label>
                        <div class="col-sm-9">
                            <?php
                            echo form_dropdown($id_parent);
                            ?>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label
                        font-weight-bold">Nama Unsur Pelayanan <span style="color: red;">*</span></label>
                        <div class="col-sm-9">
                            <?php
                            echo form_input($nama_unsur_pelayanan);
                            ?>
                        </div>
                    </div>
                    <?php else: ?>

                    <?php
                    $unsur_pelayanan = $ci->db->get_where('unsur_pelayanan_' . $manage_survey->table_identity,
                    array('id' =>
                    $ci->uri->segment(5)))->row();

                    $jumlah_parent = $ci->db->get_where('unsur_pelayanan_' . $manage_survey->table_identity,
                    array('id_parent' =>
                    $ci->uri->segment(5)))->num_rows();
                    ?>

                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label
                        font-weight-bold">Sub Unsur Dari <span style="color: red;">*</span></label>
                        <div class="col-sm-9">
                            <input value="<?php echo e($ci->uri->segment(5)); ?>" name="id_parent" hidden>
                            <input class="form-control"
                                value="<?php echo e($unsur_pelayanan->nomor_unsur . '. ' . $unsur_pelayanan->nama_unsur_pelayanan); ?>"
                                disabled>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label font-weight-bold">Unsur Pelayanan <span
                                style="color: red;">*</span></label>
                        <div class="col-sm-9">
                            <div class="input-group">
                                <div class="input-group-prepend"><span
                                        class="input-group-text font-weight-bold"><?php echo $unsur_pelayanan->nomor_unsur . '.' . ($jumlah_parent + 1) ?></span>
                                </div>
                                <?php
                                echo form_input($nama_unsur_pelayanan);
                                ?>
                                <!-- <small>
                                    Menurut Permenpan dan RB, unsur SKP terbagi 9 unsur antara lain: 1) Persyaratan 2)
                                    Sistem, Mekanisme, dan Prosedur 3) Waktu Penyelesaian 4) Biaya/Tarif 5) Produk
                                    Spesifikasi Jenis Pelayanan 6) Kompetensi Pelaksana 7) Perilaku Pelaksana 8)
                                    Penanganan Pengaduan, Saran dan Masukan 9) Sarana dan prasarana
                                </small> -->
                            </div>
                        </div>
                    </div>
                    <?php endif; ?>




                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label font-weight-bold">Pertanyaan Unsur <span
                                style="color: red;">*</span></label>
                        <div class="col-sm-9">
                            <?php
                            echo form_textarea($isi_pertanyaan_unsur);
                            ?>
                        </div>
                        </label>
                    </div>

                    <!-- <div class="form-group row">
                        <label class="col-sm-3 col-form-label font-weight-bold">Pilihan Jawaban <span
                                style="color: red;">*</span></label>
                        <div class="col-sm-9">
                            <div class="radio-list">
                                <label class="radio">
                                    <input type="radio" name="jenis_pilihan_jawaban" id="jenis_pilihan_jawaban"
                                        value="1" class="jawaban" required><span></span>2 Pilihan Jawaban
                                </label>
                                <label class="radio">
                                    <input type="radio" name="jenis_pilihan_jawaban" id="jenis_pilihan_jawaban"
                                        value="2" class="jawaban"><span></span>
                                    <?php echo e($manage_survey->skala_likert == 5 ? '5 Pilihan Jawaban' : '4 Pilihan Jawaban'); ?>

                                </label>
                            </div>
                        </div>
                    </div> -->

                    <input value="2" name="jenis_pilihan_jawaban" hidden>


                    <!-- PILIHAN JAWABAN 2 -->
                    <!-- <div name="2_jawaban" class="2_jawaban" style="display:none">
                        <br>
                        <h5 class="text-primary">Pilihan Jawaban</h5>
                        <hr class="mb-5">
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Pilihan Jawaban 1 <span
                                    style="color: red;">*</span></label>
                            <div class="col-sm-9">
                                <?php
                                echo form_input($pilihan_jawaban_1);
                                ?>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Pilihan Jawaban 2 <span
                                    style="color: red;">*</span></label>
                            <div class="col-sm-9">
                                <?php
                                echo form_input($pilihan_jawaban_2);
                                ?>
                            </div>
                        </div>
                    </div> -->


                    <!-- PILIHAN JAWABAN 4 -->
                    <div class="4_jawaban" name="4_jawaban">
                        <br>
                        <h5 class="text-primary">Pilihan Jawaban</h5>
                        <hr class="mb-5">
                        <datalist id="data_mahasiswa">
                            <?php
                            foreach ($pilihan->result() as $d) {
                                echo "<option value='$d->id'>$d->pilihan_1</option>";
                            }
                            ?>
                        </datalist>

                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Pilihan Jawaban 1 <span
                                    style="color: red;">*</span></label>
                            <div class="col-sm-9">
                                <input class="form-control pilihan" list="data_mahasiswa" type="text"
                                    name="pilihan_jawaban[]" id="id" placeholder="Masukkan pilihan jawaban anda .."
                                    onchange="return autofill();" autocomplete='off'>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Pilihan Jawaban 2 <span
                                    style="color: red;">*</span></label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control pilihan" name="pilihan_jawaban[]" id="pilihan_2">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Pilihan Jawaban 3 <span
                                    style="color: red;">*</span></label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control pilihan" name="pilihan_jawaban[]" id="pilihan_3">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Pilihan Jawaban 4 <span
                                    style="color: red;">*</span></label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control pilihan" name="pilihan_jawaban[]" id="pilihan_4">
                            </div>
                        </div>

                        <?php if($manage_survey->skala_likert == 5): ?>
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Pilihan Jawaban 5 <span
                                    style="color: red;">*</span></label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control pilihan" name="pilihan_jawaban[]" id="pilihan_5">
                            </div>
                        </div>
                        <?php endif; ?>

                    </div>

                    <hr class="mb-5">

                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label
                        font-weight-bold">Wajib Diisi <span style="color: red;">*</span></label>
                        <div class="col-sm-9">
                            <select class="form-control" id="is_required" name="is_required" required>
                                <option value=''>Please Select</option>
                                <option value='1'>Aktif</option>
                                <option value='2'>Tidak Aktif</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label
                        font-weight-bold">Alasan <span style="color: red;">*</span></label>
                        <div class="col-sm-9">
                            <select class="form-control" id="is_alasan" name="is_alasan" required>
                                <option value=''>Please Select</option>
                                <option value='1'>Aktif</option>
                                <option value='2'>Tidak Aktif</option>
                            </select>
                        </div>
                    </div>

                    <br>
                    <div class="text-right">
                        <?php
                        echo
                        anchor(base_url().$ci->session->userdata('username').'/'.$ci->uri->segment(2).'/pertanyaan-unsur',
                        'Batal', ['class' => 'btn btn-light-primary font-weight-bold'])
                        ?>

                        <button type="submit" value="1" name="is_submit"
                            class="btn btn-primary font-weight-bold">Simpan</button>

                        <?php if($ci->uri->segment(5) != ''): ?>
                        <button type="submit" value="2" name="is_submit" class="btn btn-success font-weight-bold"
                            onclick="preventBack()">Simpan & Lanjutkan Mengisi Sub Unsur <i
                                class="fa fa-arrow-right"></i></button>
                        <?php endif; ?>
                    </div>

                    <?php echo form_close(); ?>
                </div>
            </div>

        </div>
    </div>

</div>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('javascript'); ?>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.1/jquery.min.js"></script>
<script type="text/javascript">
$(function() {
    $(":radio.custom").click(function() {
        $("#dengan_sub_unsur").hide();
        $("#tanpa_sub_unsur").hide();
        if ($(this).val() == "1") {
            $("#jenis_pilihan_jawaban").removeAttr('required');
            $("#dengan_sub_unsur").show();
            $("#tanpa_sub_unsur").hidden();
        } else {
            $("#jenis_pilihan_jawaban").prop('required', true);
            $("#tanpa_sub_unsur").show();
            $("#dengan_sub_unsur").hidden();
        }
    });
});
</script>

<script type="text/javascript">
$(function() {
    $(":radio.jawaban").click(function() {
        $(".4_jawaban").hide()
        $(".2_jawaban").hide()
        if ($(this).val() == "2") {
            $(".pilihan_jawaban").removeAttr('required');
            $(".pilihan").prop('required', true);
            $(".4_jawaban").show();
            $(".2_jawaban").hide();
        } else {
            $(".pilihan").removeAttr('required');
            $(".pilihan_jawaban").prop('required', true);
            $(".2_jawaban").show();
            $(".4_jawaban").hide();
        }
    });
});
</script>


<script>
function autofill() {
    var id = document.getElementById('id').value;
    $.ajax({
        url: "<?php echo base_url() . $ci->session->userdata('username') . '/' . $ci->uri->segment(2) . '/pertanyaan-harapan/cari' ?>",
        data: '&id=' + id,
        success: function(data) {
            var hasil = JSON.parse(data);

            $.each(hasil, function(key, val) {

                document.getElementById('id').value = val.pilihan_1;
                document.getElementById('pilihan_2').value = val.pilihan_2;
                document.getElementById('pilihan_3').value = val.pilihan_3;
                document.getElementById('pilihan_4').value = val.pilihan_4;
                document.getElementById('pilihan_5').value = val.pilihan_5;
            });
        }
    });
}
</script>

<script src="https://cdn.ckeditor.com/ckeditor5/34.2.0/classic/ckeditor.js"></script>
<script>
ClassicEditor
    .create(document.querySelector('#isi_pertanyaan_unsur'))
    .then(editor => {
        console.log(editor);
    })
    .catch(error => {
        console.error(error);
    });
</script>

<script type="text/javascript">
function preventBack() {
    window.history.forward();
}
setTimeout("preventBack()", 0);
window.onunload = function() {
    null
};
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('include_backend/template_backend', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\IT\Documents\Htdocs MAMP\skp_surveiku\application\views/pertanyaan_unsur_survei/add_sub.blade.php ENDPATH**/ ?>