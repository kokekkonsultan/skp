@extends('setting_form_survei/_include/_template')

@php
$ci = get_instance();
@endphp

@section('style')
<link href="{{ TEMPLATE_BACKEND_PATH }}plugins/custom/datatables/datatables.bundle.css" rel="stylesheet"
    type="text/css">
@endsection

@section('content')
<div class="secondary-label">
    Kata Pembuka
</div>


<div>
    
    <div class="alert alert-secondary mb-5" role="alert">
        <i class="flaticon-exclamation-1"></i> Jika Anda mengaktifkan halaman pembuka, Anda
        wajib mengisi form kata pembuka.
    </div>

    <div id="tablex">
        @php
        $checked = $manage_survey->is_opening_survey == 'true' ? "checked" : "";
        $text = $manage_survey->is_opening_survey == 'true' ? "Non Aktifkan" : "Aktifkan";
        @endphp
        <div class="custom-control custom-switch mt-5 mb-5">
            <input type="checkbox" name="setting_value" class="custom-control-input toggle_dash_1"
                value="{{ $manage_survey->id }}" id="customSwitch1" {{ $checked }} />
            <label class="custom-control-label font-weight-bolder" for="customSwitch1">{{$text}} halaman
                pembuka</label>
        </div>
    </div>


    @if($manage_survey->is_opening_survey == 'true')
    <div class="alert alert-secondary mb-5" role="alert">
        <i class="flaticon-exclamation-1"></i> Kata-kata ini akan ditampilkan pada halaman awal
        survei.
    </div>

    
    <form class="form_header"
        action="{{base_url() . $ci->session->userdata('username') . '/' . $ci->uri->segment(2) . '/form-survei/update-display'}}"
        method="POST">
        <div class="form-group">
            <textarea name="deskripsi" id="editor" value="" rows="7" class="form-control"
                required>{!! $manage_survey->deskripsi_opening_survey !!}</textarea>
        </div>

        <div class="text-right">
            <button type="submit" class="btn btn-primary font-weight-bold tombolSimpan">Simpan</button>
        </div>
    </form>
    @endif
</div>

@endsection

@section('form_preview')

@if($manage_survey->is_opening_survey == 'true')
<div class="text-center" data-aos="fade-up">
    <div id="progressbar" class="mb-5">
        <li id="account" class="active"><strong>Data Responden</strong></li>
        <li id="personal"><strong>Pertanyaan Survei</strong></li>
        @if($manage_survey->is_saran == 1)
        <li id="payment"><strong>Saran</strong></li>
        @endif
        <li id="completed"><strong>Completed</strong></li>
    </div>
</div>
<br>
<br>


<div class="card shadow">

    @include('survei/_include/_benner_survei')

    <div class="card-body">
        <div class="font-text-body">
            {!! $manage_survey->deskripsi_opening_survey !!}
        </div>
        <br><br>
        <a class="btn btn-next btn-block shadow"
            href="{{base_url() . $ci->uri->segment(1) . '/' . $ci->uri->segment(2) . '/preview-form-survei/data-responden'}}">
            IKUT SURVEI
        </a>
    </div>
</div>
<br>
@include('include_backend.partials_survei.footer_survei')
@endif
@endsection

@section('javascript')
<script src="https://cdn.ckeditor.com/ckeditor5/34.2.0/classic/ckeditor.js"></script>
<script src="{{ base_url() }}assets/vendor/bootstrap/js/bootstrap-colorpicker.js"></script>

<!-- <script>
    ClassicEditor
        .create(document.querySelector('#editor'))
        .then(editor => {
            console.log(editor);
        })
        .catch(error => {
            console.error(error);
        });
    ClassicEditor.create(document.querySelector('#editor-penutup'));
</script> -->


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



$(document).ready(function() {
    $('#tablex').on('change', '.toggle_dash_1', function() {
        // alert("TT");
        var mode = $(this).prop('checked');
        var nilai_id = $(this).val();

        $.ajax({

            type: 'POST',
            dataType: 'JSON',
            url: "{{ base_url() }}{{ $ci->session->userdata('username') }}/{{ $ci->uri->segment(2) }}/form-survei/update-is-kata-pembuka",
            data: {
                'mode': mode,
                'nilai_id': nilai_id
            },
            success: function(data) {
                var data = eval(data);
                message = data.message;
                success = data.success;

                toastr["success"](message);
                window.setTimeout(function() {
                    location.reload()
                }, 1000);

            }
        });
    });
});
</script>

@endsection