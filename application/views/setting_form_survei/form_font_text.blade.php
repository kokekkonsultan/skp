@extends('setting_form_survei/_include/_template')

@php
$ci = get_instance();
@endphp

@section('style')
<link href="{{ TEMPLATE_BACKEND_PATH }}plugins/custom/datatables/datatables.bundle.css" rel="stylesheet">
<link href="{{ base_url() }}assets/vendor/bootstrap/css/bootstrap-colorpicker.css" rel="stylesheet" type="text/css" />
<script src="https://cdn.jsdelivr.net/npm/@jaames/iro@5"></script>
@endsection

@section('content')
<div class="secondary-label">
    Gaya Text
</div>


<form class="form_header" action="{{base_url() . $ci->session->userdata('username') . '/' . $ci->uri->segment(2) . '/form-survei/update-font-text'}}" method="POST">

    @php
    $font_text_header = unserialize($manage_survey->font_text_header);
    $font_type_header = $font_text_header[0];
    $font_size_header = $font_text_header[1];
    $font_color_header = $font_text_header[2];

    $font_text_body = unserialize($manage_survey->font_text_body);
    $font_type_body = $font_text_body[0];
    $font_size_body = $font_text_body[1];
    $font_color_body = $font_text_body[2];
    @endphp

    <h6 class="text-primary font-weight-bolder">Text Header</h6>
    <hr>

    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label class="form-label font-weight-bolder">Font Type <b class="text-danger">*</b></label>
                <select class="form-control" name="font_type_header" required>
                 
                    @foreach($ci->db->get("fonts_google")->result() as $row)
                    <option value="{{$row->id}}" {{$row->id == $font_type_header ? 'selected' : ''}}>{{$row->fonts_name}}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="col-md-3">
            <div class="form-group">
                <label class="form-label font-weight-bolder">Size <b class="text-danger">*</b></label>
                <select class="form-control" name="font_size_header" required>
                    @for($x = 10; $x <= 30; $x++) <option value="{{$x}}" {{$x == $font_size_header ? 'selected' : ''}}>{{$x}}</option>
                        @endfor
                </select>
            </div>
        </div>

        <div class="col-md-3">
            <div class="form-group">
                <label class="form-label font-weight-bolder">Color <b class="text-danger">*</b></label>
                <input class="form-control" type="color" name="font_color_header" value="{{$font_color_header}}" required>
            </div>
        </div>
    </div>


    <h6 class="text-primary font-weight-bolder mt-5">Text Body</h6>
    <hr>

    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label class="form-label font-weight-bolder">Font Type <b class="text-danger">*</b></label>
                <select class="form-control" name="font_type_body" required>

                    @foreach($ci->db->get("fonts_google")->result() as $row)
                    <option value="{{$row->id}}" {{$row->id == $font_type_body ? 'selected' : ''}}>{{$row->fonts_name}}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="col-md-3">
            <div class="form-group">
                <label class="form-label font-weight-bolder">Size <b class="text-danger">*</b></label>
                <select class="form-control" name="font_size_body" required>
                    @for($x = 10; $x <= 20; $x++) <option value="{{$x}}" {{$x == $font_size_body ? 'selected' : ''}}>{{$x}}</option>
                        @endfor
                </select>
            </div>
        </div>

        <div class="col-md-3">
            <div class="form-group">
                <label class="form-label font-weight-bolder">Color <b class="text-danger">*</b></label>
                <input class="form-control" type="color" name="font_color_body" value="{{$font_color_body}}" required>
            </div>
        </div>
    </div>

    <div class="text-right mt-3">
        <button type="submit" class="btn btn-primary font-weight-bold tombolSimpan">Simpan</button>
    </div>
</form>
@endsection


@section('form_preview')

<div class="text-center" data-aos="fade-up">
        <div id="progressbar" class="mb-5">
            <li id="account"><strong>Data Responden</strong></li>
            <li id="personal"><strong>Pertanyaan Survei</strong></li>
            @if($manage_survey->is_saran == 1)
            <li id="payment"><strong>Saran</strong></li>
            @endif
            <li id="completed"><strong>Completed</strong></li>
        </div>
    </div>
    <br>
    <br>


    <div class="card shadow" data-aos="fade-up">
                
                @include('survei/_include/_benner_survei')

                <div class="card-body">
                    <div class="font-text-body">
                    {!! $manage_survey->deskripsi_opening_survey !!}
                    </div>
                    <br>
                    <br>
                    <!-- <a class="btn btn-next btn-block shadow" href="">IKUT SURVEI</a> -->
                </div>
            </div>
@endsection


@section('javascript')
<script src="{{ base_url() }}assets/vendor/bootstrap/js/bootstrap-colorpicker.js"></script>

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