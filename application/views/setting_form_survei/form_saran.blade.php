@extends('setting_form_survei/_include/_template')

@php
$ci = get_instance();
@endphp

@section('style')
<link href="{{ TEMPLATE_BACKEND_PATH }}plugins/custom/datatables/datatables.bundle.css" rel="stylesheet" type="text/css">
@endsection

@section('content')
<div class="secondary-label">
    Form Saran
</div>

<div class="alert alert-secondary mb-5" role="alert">
    <i class="flaticon-exclamation-1"></i> Jika diaktifkan, maka akan ditampilkan form saran
    survei.
</div>

<form action="{{base_url() . $ci->session->userdata('username') . '/' . $ci->uri->segment(2) . '/form-survei/update-saran'}}" class="form_header">

    <div class="form-group">
        <label class="col-form-label font-weight-bolder">Aktifkan Form Saran <span class="text-danger">*</span></label>
        <select class="form-control" name="is_saran" value="<?php echo set_value('is_saran'); ?>">
            <option value="1" <?= $manage_survey->is_saran == 1 ? 'selected' : '' ?>>Ya</option>
            <option value="2" <?= $manage_survey->is_saran == 2 ? 'selected' : '' ?>>Tidak</option>
        </select>
    </div>

    @if($manage_survey->is_saran == 1)
    <div class="form-group">
        <label class="col-form-label font-weight-bolder">Judul Form
            Saran <span class="text-danger">*</span></label>
        <textarea class="form-control" name="judul_form_saran" rows="3">{{$manage_survey->judul_form_saran}}</textarea>
    </div>
    @else
    <input name="judul_form_saran" value="{{$manage_survey->judul_form_saran}}" hidden>
    @endif


    @if($manage_survey->is_question == 1)
    <div class="text-right">
        <button type="submit" class="btn btn-primary font-weight-bolder tombolSimpan">Simpan</button>
    </div>
    @endif
</form>

@endsection

@section('form_preview')

@if($manage_survey->is_saran == 1)
<div class="text-center" data-aos="fade-up">
    <div id="progressbar" class="mb-5">
        <li id="account" class="active"><strong>Data Responden</strong></li>
        <li id="personal" class="active"><strong>Pertanyaan Survei</strong></li>
        @if($manage_survey->is_saran == 1)
        <li id="payment" class="active"><strong>Saran</strong></li>
        @endif
        <li id="completed"><strong>Completed</strong></li>
    </div>
</div>
<br>
<br>
<div class="card shadow mb-4 mt-4" data-aos="fade-up">

    @include('survei/_include/_benner_survei')

    <div class="card-header text-center">
        <h3 class="mt-5"><b>SARAN</b></h3>
        @include('include_backend/partials_backend/_tanggal_survei')
    </div>
    <div class="card-body">


        <div>
            <label style="font-size: 14px; text-transform: capitalize;">{{$manage_survey->judul_form_saran}}</label>
            <br />
            <textarea class="form-control" rows="8"></textarea>

            <small class="text-danger">** Pengisian form saran hanya dapat menggunakan tanda baca (.)
                titik dan (,) koma</small>
        </div>



    </div>
</div>
<br>
@include('include_backend.partials_survei.footer_survei')
@else

<div class="text-center"><i>Survei ini tidak menggunakan saran.</i></div>

@endif

@endsection

@section('javascript')

<script>
    $('.form_header').submit(function(e) {

        $.ajax({
            url: $(this).attr('action'),
            type: 'POST',
            dataType: 'json',
            data: $(this).serialize(),
            cache: false,
            beforeSend: function() {
                $('.tombolSimpan').attr('disabled', 'disabled');
                $('.tombolSimpan').html('<i class="fa fa-spin fa-spinner"></i> Sedang diproses');

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
                $('.tombolSimpan').removeAttr('disabled');
                $('.tombolSimpan').html('Simpan');
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
                    toastr["success"]('Data berhasil diubah');
                    window.location.reload()
                }
            }
        })
        return false;
    });
</script>

@endsection