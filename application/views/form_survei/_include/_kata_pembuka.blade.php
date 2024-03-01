<div class="alert alert-secondary mb-5" role="alert">
    <i class="flaticon-exclamation-1"></i> Kata-kata ini akan ditampilkan pada halaman awal
    survei.
</div>



<div id="tablex">
    @php
    $checked = ($manage_survey->is_opening_survey == 'true') ? "checked" : "";
    @endphp
    <div class="custom-control custom-switch mt-5 mb-5">
        <input type="checkbox" name="setting_value" class="custom-control-input toggle_dash_1" value="{{ $manage_survey->id }}" id="customSwitch1" {{ $checked }} />
        <label class="custom-control-label" for="customSwitch1">Aktifkan halaman
            pembuka</label>
    </div>
</div>



<div class="alert alert-secondary mb-5" role="alert">
    <i class="flaticon-exclamation-1"></i> Jika Anda mengaktifkan halaman pembuka, Anda
    wajib mengisi bidang dibawah ini.
</div>

<form action="<?php echo base_url() . $ci->session->userdata('username') . '/' . $ci->uri->segment(2) . '/form-survei/update-display' ?>" class="form_pembuka">

    <div class="form-group">
        <textarea name="deskripsi" id="editor" value="" class="form-control" required> <?php echo $manage_survey->deskripsi_opening_survey ?></textarea>
    </div>

    <div class="text-right">
        <button type="submit" class="btn btn-primary font-weight-bold tombolSimpanPembuka">Update
            Deskripsi</button>
    </div>
</form>