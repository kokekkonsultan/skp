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
    Benner
</div>


@php
$warna_benner = unserialize($manage_survey->warna_benner);
$warna_benner1 = (isset($warna_benner[0])) ? $warna_benner[0] : "#E4E6EF";
$warna_benner2 = (isset($warna_benner[1])) ? $warna_benner[1] : "#E4E6EF";
$warna_benner3 = (isset($warna_benner[2])) ? $warna_benner[2] : "#E4E6EF";

$title_header = unserialize($manage_survey->title_header_survey);
$title_1 = $title_header[0];
$title_2 = $title_header[1];
@endphp

<div class="alert alert-secondary mb-5" role="alert">
    <i class="flaticon-exclamation-1"></i> Banner akan tampil dibagian header halaman survei
</div>

<div id="tableBanner">
    <div class="custom-control custom-switch mt-5 mb-5">
        <input type="checkbox" name="setting_banner" class="custom-control-input toggle_banner_1" value="1"
            id="customBanner1" {{ ($manage_survey->is_benner == '1') ? "checked" : ""; }} />
        <label class="custom-control-label" for="customBanner1">Menggunakan banner
            gambar</label>
    </div>

    @if($manage_survey->is_benner == 1)
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
            <button type="submit" class="btn btn-primary btn-sm font-weight-bold tombolUploud">Upload</button>
        </div>
    </form>
    @endif



    <div class="custom-control custom-switch mt-5 mb-5">
        <input type="checkbox" name="setting_banner" class="custom-control-input toggle_banner_1" value="2"
            id="customBanner2" {{ ($manage_survey->is_benner == '2') ? "checked" : ""; }} />
        <label class="custom-control-label" for="customBanner2">Menggunakan banner
            tulisan</label>
    </div>



    <div class="custom-control custom-switch mt-5 mb-5">
        <input type="checkbox" name="setting_banner" class="custom-control-input toggle_banner_1" value="3"
            id="customBanner3" {{ ($manage_survey->is_benner == '3') ? "checked" : ""; }} />
        <label class="custom-control-label" for="customBanner3">Menggunakan banner tulisan
            dengan warna solid</label>

        <div class="form-group">
            <input class="form-control" type="color" name="warna_benner[]" id="warna1" value="{{ $warna_benner1 }}"
                required>
        </div>
        <!-- <div id="cp6" class="input-group" style="width: 145px; ">
            <input type="text" name="warna_benner[]" id="warna1" value="{{ $warna_benner1 }}" class="form-control input-lg" />
            <span class="input-group-append">
                <span class="input-group-text colorpicker-input-addon"><i></i></span>
            </span>
        </div> -->
    </div>

    <div class="custom-control custom-switch mt-5 mb-5">
        <input type="checkbox" name="setting_banner" class="custom-control-input toggle_banner_1" value="4"
            id="customBanner4" {{ ($manage_survey->is_benner == '4') ? "checked" : ""; }} />
        <label class="custom-control-label" for="customBanner4">Menggunakan banner tulisan
            dengan warna gradasi</label>
        <div class="form-group row">
            <div class="col-md-6">
                <input class="form-control" type="color" name="warna_benner[]" id="warna2" value="{{ $warna_benner2 }}"
                    required>
            </div>
            <div class="col-md-6">
                <input class="form-control" type="color" name="warna_benner[]" id="warna3" value="{{ $warna_benner3 }}"
                    required>
            </div>


            <!-- <div id="cp4" class="input-group" style="width: 145px; float:left; margin-right:10px; ">
                <input type="text" name="warna_benner[]" id="warna2" value="{{ $warna_benner2 }}" class="form-control input-lg" />
                <span class="input-group-append">
                    <span class="input-group-text colorpicker-input-addon"><i></i></span>
                </span>
            </div>
            
            <div id="cp5" class="input-group" style="width: 145px; ">
                <input type="text" name="warna_benner[]" id="warna3" value="{{ $warna_benner3 }}" class="form-control input-lg" />
                <span class="input-group-append">
                    <span class="input-group-text colorpicker-input-addon"><i></i></span>
                </span>
            </div> -->
        </div>
    </div>

    <div class="custom-control custom-switch mt-5 mb-5">
        <input type="checkbox" name="setting_banner" class="custom-control-input toggle_banner_1" value="5"
            id="customBanner5" {{ ($manage_survey->is_benner == '5') ? "checked" : ""; }} />
        <label class="custom-control-label" for="customBanner5">Menggunakan banner tulisan
            dengan logo</label>
    </div>
</div>



@endsection

@section('form_preview')
<div class="card shadow">


    @if($manage_survey->is_benner == 2)
    <div class="card-header text-dark" style="background-color: #E4E6EF;">
        <div class="text-center font-weight-bold mt-5 mb-5" style="font-family: Helvetica, Arial, sans-serif;">
            <h1 style="font-weight:800;">{{strtoupper($title_1)}}</h1>
            <h3 class="mt-3" style="font-weight:800;">{{strtoupper($title_2)}}</h3>
        </div>
    </div>

    @elseif($manage_survey->is_benner == 3)
    <div class="card-header text-dark" id="gantiwarna1" style="background-color: <?= $warna_benner1 ?>;">
        <div class="text-center font-weight-bold mt-5 mb-5" style="font-family: Helvetica, Arial, sans-serif;">
            <h1 style="font-weight:800;">{{strtoupper($title_1)}}</h1>
            <h3 class="mt-3" style="font-weight:800;">{{strtoupper($title_2)}}</h3>
        </div>
    </div>

    @elseif($manage_survey->is_benner == 4)
    <div class="card-header text-dark" id="gantiwarna2"
        style="background-image: linear-gradient(to bottom right, <?= $warna_benner2 . ', ' . $warna_benner3 ?>);">
        <div class="text-center font-weight-bold mt-5 mb-5" style="font-family: Helvetica, Arial, sans-serif;">
            <h1 style="font-weight:800;">{{strtoupper($title_1)}}</h1>
            <h3 class="mt-3" style="font-weight:800;">{{strtoupper($title_2)}}</h3>
        </div>
    </div>

    @elseif($manage_survey->is_benner == 5)
    <div class="card-header text-dark" style="background-color: <?= $warna_benner1 ?>;">
        <table class="table table-borderless mt-5" width="100%">
            <tr>
                <td width="15%" style="vertical-align:middle;">
                    <img src="{{base_url() . 'assets/klien/foto_profile/200px.jpg'}}" height="100" width="100" alt="">
                </td>
                <td style="font-family: Helvetica, Arial, sans-serif; vertical-align:middle;">
                    <h1 style="font-weight:800;">{{strtoupper($title_1)}}</h1>
                    <h3 class="mt-3" style="font-weight:800;">{{strtoupper($title_2)}}</h3>
                </td>
            </tr>
        </table>
    </div>

    @else

    @if($manage_survey->img_benner == '')
    <img class="card-img-top" src="{{ base_url() }}assets/img/site/page/banner-survey.jpg" alt="new image" />
    @else
    <img class="card-img-top shadow" src="{{ base_url() }}assets/klien/benner_survei/{{$manage_survey->img_benner}}"
        alt="new image">
    @endif

    @endif

</div>
@endsection


@section('javascript')
<script src="{{ base_url() }}assets/vendor/bootstrap/js/bootstrap-colorpicker.js"></script>

<script>
$(document).ready(function() {
    //--------------------------------BANNER DAN LATAR BELAKANG--------------------------------//
    $('#tableBanner').on('change', '.toggle_banner_1', function() {
        // alert("TT");
        var mode = $(this).prop('checked');
        var nilai_id = $(this).val();
        //var warna_benner = [];
        warna_benner = $('input:enabled[name="warna_benner[]"]').map(function() {
            return $(this).val();
        }).get();

        $.ajax({

            type: 'POST',
            dataType: 'JSON',
            url: "{{ base_url() }}{{ $ci->session->userdata('username') }}/{{ $ci->uri->segment(2) }}/form-survei/update-is-banner",
            data: {
                'mode': mode,
                'nilai_id': nilai_id,
                'warna_benner': warna_benner,
            },
            success: function(data) {
                var data = eval(data);
                message = data.message;
                success = data.success;

                toastr["success"](message);
                window.location.reload()

            }
        });
    });


    function ganti_warna_banner(mode, nilai_id, warna_benner) {
        $.ajax({

            type: 'POST',
            dataType: 'JSON',
            url: "{{ base_url() }}{{ $ci->session->userdata('username') }}/{{ $ci->uri->segment(2) }}/form-survei/update-is-banner",
            data: {
                'mode': mode,
                'nilai_id': nilai_id,
                'warna_benner': warna_benner,
            },
            success: function(data) {
                var data = eval(data);
                message = data.message;
                success = data.success;

                //toastr["success"](message);

            }
        });
    }

    document.getElementById("warna1").onchange = function() {
        var mode = $(this).prop('checked');
        var nilai_id = '{{ $manage_survey->is_benner }}';
        warna_benner = $('input:enabled[name="warna_benner[]"]').map(function() {
            return $(this).val();
        }).get();

        ganti_warna_banner(mode, nilai_id, warna_benner);
        document.getElementById("gantiwarna1").style.backgroundColor = warna_benner.toString().split(',')
            .shift();
    }

    document.getElementById("warna2").onchange = function() {
        var mode = $(this).prop('checked');
        var nilai_id = '{{ $manage_survey->is_benner }}';
        warna_benner = $('input:enabled[name="warna_benner[]"]').map(function() {
            return $(this).val();
        }).get();

        ganti_warna_banner(mode, nilai_id, warna_benner);
        document.getElementById("gantiwarna2").style.backgroundImage = 'linear-gradient(to bottom right, ' +
            warna_benner.toString().split(',')[1] + ', ' + warna_benner.toString().split(',')[2] + ')';
    }

    document.getElementById("warna3").onchange = function() {
        var mode = $(this).prop('checked');
        var nilai_id = '{{ $manage_survey->is_benner }}';
        warna_benner = $('input:enabled[name="warna_benner[]"]').map(function() {
            return $(this).val();
        }).get();

        ganti_warna_banner(mode, nilai_id, warna_benner);
        document.getElementById("gantiwarna2").style.backgroundImage = 'linear-gradient(to bottom right, ' +
            warna_benner.toString().split(',')[1] + ', ' + warna_benner.toString().split(',')[2] + ')';
    }
});
</script>

@endsection