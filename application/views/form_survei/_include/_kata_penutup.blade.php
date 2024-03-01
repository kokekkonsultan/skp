<div class="alert alert-secondary mb-5" role="alert">
    <i class="flaticon-exclamation-1"></i> Kata-kata ini akan ditampilkan pada halaman akhir
    survei.
</div>

<form action="{{ base_url() }}{{ $ci->session->userdata('username') }}/{{ $ci->uri->segment(2) }}/form-survei/update-kata-penutup" class="form_penutup">

    <div class="form-group">
        <textarea name="deskripsi_selesai_survei" id="editor-penutup" value="" class="form-control" required> <?php echo $manage_survey->deskripsi_selesai_survei ?></textarea>
    </div>

    <div class="text-right">
        <button type="submit" class="btn btn-primary font-weight-bold tombolSimpanPenutup">Update Kata
            Penutup</button>
    </div>
</form>