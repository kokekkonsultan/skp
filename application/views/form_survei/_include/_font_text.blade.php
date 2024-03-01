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

    <h6 class="text-primary">Text Header</h6>
    <hr>

    <div id="tanggal_survei">
        @php
        $checked_tgl = ($manage_survey->is_display_tanggal_survei == 'true') ? "checked" : "";
        @endphp
        <div class="custom-control custom-switch mb-3">
            <input type="checkbox" name="is_display_tanggal_survei" class="custom-control-input toggle_tanggal_1" value="{{ $manage_survey->id }}" id="customSwitch2" {{ $checked_tgl }} />
            <label class="custom-control-label font-weight-bold" for="customSwitch2">Tampilkan Tanggal Survei</label>
        </div>
    </div>

    <div class="alert alert-secondary mb-10" role="alert">
        <i class="flaticon-exclamation-1"></i> Tanggal Survei akan ditampilkan diatas form survei.
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label class="form-label font-weight-bold">Font Type <b class="text-danger">*</b></label>
                <select class="form-control" name="font_type_header" required>

                    @foreach($ci->db->get("fonts_google")->result() as $row)
                    <option value="{{$row->id}}" {{$row->id == $font_type_header ? 'selected' : ''}}>{{$row->fonts_name}}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="col-md-3">
            <div class="form-group">
                <label class="form-label font-weight-bold">Size <b class="text-danger">*</b></label>
                <select class="form-control" name="font_size_header" required>
                    @for($x = 10; $x <= 20; $x++) <option value="{{$x}}" {{$x == $font_size_header ? 'selected' : ''}}>{{$x}}</option>
                        @endfor
                </select>
            </div>
        </div>

        <div class="col-md-3">
            <div class="form-group">
                <label class="form-label font-weight-bold">Color <b class="text-danger">*</b></label>
                <input class="form-control" type="color" name="font_color_header" value="{{$font_color_header}}" required>
            </div>
        </div>
    </div>


    <h6 class="text-primary mt-5">Text Body</h6>
    <hr>

    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label class="form-label font-weight-bold">Font Type <b class="text-danger">*</b></label>
                <select class="form-control" name="font_type_body" required>

                    @foreach($ci->db->get("fonts_google")->result() as $row)
                    <option value="{{$row->id}}" {{$row->id == $font_type_body ? 'selected' : ''}}>{{$row->fonts_name}}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="col-md-3">
            <div class="form-group">
                <label class="form-label font-weight-bold">Size <b class="text-danger">*</b></label>
                <select class="form-control" name="font_size_body" required>
                    @for($x = 10; $x <= 20; $x++) <option value="{{$x}}" {{$x == $font_size_body ? 'selected' : ''}}>{{$x}}</option>
                        @endfor
                </select>
            </div>
        </div>

        <div class="col-md-3">
            <div class="form-group">
                <label class="form-label font-weight-bold">Color <b class="text-danger">*</b></label>
                <input class="form-control" type="color" name="font_color_body" value="{{$font_color_body}}" required>
            </div>
        </div>
    </div>

    <div class="text-right mt-3">
        <button type="submit" class="btn btn-primary font-weight_bold tombolSimpanHeader">Simpan</button>
    </div>
</form>