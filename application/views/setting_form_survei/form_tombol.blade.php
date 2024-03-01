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
    Gaya Tombol
</div>


<form class="form_header" action="{{base_url() . $ci->session->userdata('username') . '/' . $ci->uri->segment(2) . '/form-survei/update-font-button'}}" method="POST">

    @php
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
    @endphp

    <h6 class="text-primary font-weight-bolder">Tombol Lanjut</h6>
    <hr>

    <div class="row">
        <div class="col-md-8">
            <div class="form-group">
                <label class="form-label font-weight-bolder">Tipe Font <b class="text-danger">*</b></label>
                <select class="form-control" name="font_type_next" required>
                    @foreach($ci->db->get("fonts_google")->result() as $row)
                    <option value="{{$row->id}}" {{$row->id == $font_type_next ? 'selected' : ''}}>{{$row->fonts_name}}
                    </option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="col-md-4">
            <div class="form-group">
                <label class="form-label font-weight-bolder">Ukuran Font <b class="text-danger">*</b></label>
                <select class="form-control" name="font_size_next" required>
                    @for($x = 10; $x <= 20; $x++) <option value="{{$x}}" {{$x == $font_size_next ? 'selected' : ''}}>
                        {{$x}}</option>
                        @endfor
                </select>
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group">
                <label class="form-label font-weight-bolder">Warna Font <b class="text-danger">*</b></label>
                <input class="form-control" type="color" name="font_color_next" value="{{$font_color_next}}" required>
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group">
                <label class="form-label font-weight-bolder">Warna Tombol <b class="text-danger">*</b></label>
                <input class="form-control" type="color" name="btn_color_next" value="{{$btn_color_next}}" required>
            </div>
        </div>
    </div>


    <h6 class="text-primary font-weight-bolder mt-5">Tombol Kembali</h6>
    <hr>

    <div class="row">
        <div class="col-md-8">
            <div class="form-group">
                <label class="form-label font-weight-bolder">Tipe Font <b class="text-danger">*</b></label>
                <select class="form-control" name="font_type_back" required>
                    @foreach($ci->db->get("fonts_google")->result() as $row)
                    <option value="{{$row->id}}" {{$row->id == $font_type_back ? 'selected' : ''}}>{{$row->fonts_name}}
                    </option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="col-md-4">
            <div class="form-group">
                <label class="form-label font-weight-bolder">Ukuran Font <b class="text-danger">*</b></label>
                <select class="form-control" name="font_size_back" required>
                    @for($x = 10; $x <= 20; $x++) <option value="{{$x}}" {{$x == $font_size_back ? 'selected' : ''}}>
                        {{$x}}</option>
                        @endfor
                </select>
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group">
                <label class="form-label font-weight-bolder">Warna Font <b class="text-danger">*</b></label>
                <input class="form-control" type="color" name="font_color_back" value="{{$font_color_back}}" required>
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group">
                <label class="form-label font-weight-bolder">Warna Tombol <b class="text-danger">*</b></label>
                <input class="form-control" type="color" name="btn_color_back" value="{{$btn_color_back}}" required>
            </div>
        </div>
    </div>

    <div class="text-right mt-3">
        <button type="submit" class="btn btn-primary font-weight_bold tombolSimpan">Simpan</button>
    </div>
</form>
@endsection


@section('form_preview')

<div class="text-center" data-aos="fade-up">
    <div id="progressbar" class="mb-5">
        <li id="account" class="active"><strong>Data Responden</strong></li>
        <li id="personal" class="active"><strong>Pertanyaan Survei</strong></li>
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

    <div class="card-header text-center">
        <h3 class="mt-5" style="font-family: 'Exo 2', sans-serif;"><b>PERTANYAAN</b></h3>
        @include('include_backend/partials_backend/_tanggal_survei')
    </div>

    <div class="card-body">
        <div class="text-center">
            <b>..........</b>
        </div>
    </div>

    <div class="card-footer">
        <table class="table table-borderless">
            <tr>
                <td class="text-left">
                    <button class="btn btn-back btn-lg shadow">Kembali</button>
                </td>
                <td class="text-right">
                    <button class="btn btn-next btn-lg shadow tombolSave">Selanjutnya</button>
                </td>
            </tr>
        </table>

        </form>
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