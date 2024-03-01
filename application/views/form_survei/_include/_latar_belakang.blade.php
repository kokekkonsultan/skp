@php
$warna_latar_belakang = unserialize($manage_survey->warna_latar_belakang);
$warna_latar_belakang1 = (isset($warna_latar_belakang[0])) ? $warna_latar_belakang[0] :
"#E4E6EF";
$warna_latar_belakang2 = (isset($warna_latar_belakang[1])) ? $warna_latar_belakang[1] :
"#E4E6EF";
$warna_latar_belakang3 = (isset($warna_latar_belakang[2])) ? $warna_latar_belakang[2] :
"#E4E6EF";
@endphp

<div class="alert alert-secondary mb-5" role="alert">
    <i class="flaticon-exclamation-1"></i> Latar belakang ini akan ditampilkan pada halaman
    survei.
</div>

<div id="tableBackground">
    <div class="custom-control custom-switch mt-5 mb-5">
        <input type="checkbox" name="setting_background" class="custom-control-input toggle_background_1" value="1" id="customBackground1" {{ ($manage_survey->is_latar_belakang == '1') ? "checked" : ""; }} />
        <label class="custom-control-label" for="customBackground1">Latar belakang
            default</label>
    </div>

    <div class="custom-control custom-switch mt-5 mb-5">
        <input type="checkbox" name="setting_background" class="custom-control-input toggle_background_1" value="2" id="customBackground2" {{ ($manage_survey->is_latar_belakang == '2') ? "checked" : ""; }} />
        <label class="custom-control-label" for="customBackground2">Menggunakan latar
            belakang warna solid</label>
        <div id="cp3" class="input-group" style="width: 145px; ">
            <input type="text" name="warna_latar_belakang[]" id="warna4" value="{{ $warna_latar_belakang1 }}" class="form-control input-lg" />
            <span class="input-group-append">
                <span class="input-group-text colorpicker-input-addon"><i></i></span>
            </span>
        </div>
    </div>

    <div class="custom-control custom-switch mt-5 mb-5">
        <input type="checkbox" name="setting_background" class="custom-control-input toggle_background_1" value="3" id="customBackground3" {{ ($manage_survey->is_latar_belakang == '3') ? "checked" : ""; }} />
        <label class="custom-control-label" for="customBackground3">Menggunakan latar
            belakang warna gradasi</label>
        <div class="row" style="padding-left:12px; ">
            <div id="cp1" class="input-group" style="width: 145px; float:left; margin-right:10px; ">
                <input type="text" name="warna_latar_belakang[]" id="warna5" value="{{ $warna_latar_belakang2 }}" class="form-control input-lg" />
                <span class="input-group-append">
                    <span class="input-group-text colorpicker-input-addon"><i></i></span>
                </span>
            </div>
            <div id="cp2" class="input-group" style="width: 145px; ">
                <input type="text" name="warna_latar_belakang[]" id="warna6" value="{{ $warna_latar_belakang3 }}" class="form-control input-lg" />
                <span class="input-group-append">
                    <span class="input-group-text colorpicker-input-addon"><i></i></span>
                </span>
            </div>
        </div>
    </div>
</div>