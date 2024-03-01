@extends('include_backend/_template')

@php
$ci = get_instance();
@endphp

@section('style')
<link rel="dns-prefetch" href="//fonts.gstatic.com">
<link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
@endsection

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

@section('content')
<div class="container mt-5 mb-5" style="font-family: nunito;">
    <div class="text-center" data-aos="fade-up">
        <div id="progressbar" class="mb-5">
            <li class="active" id="account"><strong>Data Responden</strong></li>
            <li class="active" id="personal"><strong>Pertanyaan Survei</strong></li>
            @if($status_saran == 1)
            <li id="payment"><strong>Saran</strong></li>
            @endif
            <li id="completed"><strong>Completed</strong></li>
        </div>
    </div>
    <br>
    <br>
    <div class="row">
        <div class="col-md-8 offset-md-2" style="font-size: 16px;">
            <div class="card shadow mb-4 mt-4" data-aos="fade-up" style="font-family: 'Exo 2', sans-serif;">

                @include('survei/_include/_benner_survei')

                <div class="card-header text-center">
                    <h3 class="mt-5" style="font-family: 'Exo 2', sans-serif;"><b>PERTANYAAN UNSUR</b></h3>
                    @include('include_backend/partials_backend/_tanggal_survei')
                </div>

                <form action="{{base_url() . 'survei/' . $ci->uri->segment(2) . '/add_pertanyaan/' . $ci->uri->segment(4)}}" class="form_survei" method="POST">

                    <div class="card-body ml-5 mr-5">


                        <!-- START TERBUKA ATAS -->
                        {{--@if($manage_survey->is_kategori_pertanyaan_terbuka == 1)
                        @include('survei/pertanyaan_terbuka/_dengan_kategori/form_terbuka_atas')
                        @else
                        @include('survei/pertanyaan_terbuka/_tanpa_kategori/form_terbuka_atas')
                        @endif--}}

                        @include('survei/pertanyaan_terbuka/_tanpa_kategori/form_terbuka_atas')
                        <!-- END TERBUKA ATAS-->



                        <!--============================================================================================================================================================================================================================================================================================================================================================================== -->


                        <!-- LOOP DIMENSI -->
                        @foreach(
                        $ci->db->query("SELECT *
                        FROM (SELECT *, (SELECT COUNT(id) FROM unsur_pelayanan_$manage_survey->table_identity WHERE
                        dimensi_$manage_survey->table_identity.id =
                        unsur_pelayanan_$manage_survey->table_identity.id_dimensi) AS jumlah FROM
                        dimensi_$manage_survey->table_identity) dms_$manage_survey->table_identity
                        WHERE jumlah > 0
                        ORDER BY id ASC")->result() as $dms
                        )


                        <div class="text-center" style="background-color: #FCF7B6; padding: 5px; font-family: 'Exo 2', sans-serif; color:#294087;">
                            <h4 class="mt-2"><b>{{strtoupper($dms->dimensi)}}</b></h4>
                            <span>{{$dms->keterangan}}</span>
                        </div>
                        

                        <!-- LOOP UNSUR -->
                        @php
                        $i = 1;
                        @endphp
                        @foreach ($pertanyaan_unsur->result() as $row)
                        @if($dms->id == $row->id_dimensi)
                        @php
                        $is_required = $row->is_required == 1 ? 'required' : '';
                        $is_required_u = $row->is_required == 1 ? '<b class="text-danger">*</b>' : '';
                        @endphp

                        <div class="mt-10 mb-10">
                            <input type="hidden" name="id_pertanyaan_unsur[{{ $i }}]" value="{{ $row->id_pertanyaan_unsur }}">
                            <table class="table table-borderless" width="100%" border="0">
                                <tr>
                                    <td width="5%" valign="top">{!! $row->nomor . '' . $is_required_u !!}.</td>
                                    <td width="95%">{!! $row->isi_pertanyaan_unsur !!}</td>
                                </tr>

                                <tr>
                                    <td width="5%"></td>
                                    <td style="font-weight:bold;" width="95%">

                                        {{-- Looping Pilihan Jawaban --}}
                                        @foreach ($ci->db->get_where("kategori_unsur_pelayanan_$table_identity",
                                        ['id_pertanyaan_unsur' => $row->id_pertanyaan_unsur])->result() as $value)
                                        <div class="radio-inline mb-2">
                                            <label class="radio radio-outline radio-success radio-lg" style="font-size: 16px;">

                                                <input type="radio" name="jawaban_pertanyaan_unsur[{{ $i }}]" value="{{$value->nomor_kategori_unsur_pelayanan}}" class="unsur_{{$row->nomor}}" <?= $value->nomor_kategori_unsur_pelayanan == $row->skor_jawaban ? 'checked' : '' ?> {{ $is_required }}><span></span>
                                                {{$value->nama_kategori_unsur_pelayanan}}
                                            </label>
                                        </div>
                                        @endforeach
                                    </td>
                                </tr>

                                @if($row->is_alasan == 1)
                                <tr>
                                    <td width="5%"></td>
                                    <td width="95%">

                                        <textarea class="form-control form-alasan" type="text" name="alasan_pertanyaan_unsur[{{ $i }}]" id="input_alasan_{{$row->nomor}}" placeholder="Berikan alasan jawaban anda ..." pattern="^[a-zA-Z0-9.,\s]*$|^\w$" <?= $row->skor_jawaban == 1 || $row->skor_jawaban == 2 ? 'required' : 'style="display:none"' ?>>{{ $row->alasan_jawaban }}</textarea>

                                        <small id="text_alasan_{{$row->nomor}}" class="text-danger" style="display:none">**Pengisian alasan hanya dapat menggunakan tanda baca
                                            (.) titik dan (,) koma</small>
                                    </td>
                                </tr>
                                @endif

                            </table>
                        </div>



                        <!-- START TERBUKA -->
                        {{--@if($manage_survey->is_kategori_pertanyaan_terbuka == 1)
                        @include('survei/pertanyaan_terbuka/_dengan_kategori/form_terbuka')
                        @else
                        @include('survei/pertanyaan_terbuka/_tanpa_kategori/form_terbuka')
                        @endif--}}

                        @include('survei/pertanyaan_terbuka/_tanpa_kategori/form_terbuka')
                        <!-- END TERBUKA -->


                        @endif
                        @php
                        $i++;
                        @endphp
                        @endforeach


                        @endforeach







                        <!--============================================================================================================================================================================================================================================================================================================================================================================== -->



                        <!-- START TERBUKA BAWAH -->
                        {{--@if($manage_survey->is_kategori_pertanyaan_terbuka == 1)
                        @include('survei/pertanyaan_terbuka/_dengan_kategori/form_terbuka_bawah')
                        @else
                        @include('survei/pertanyaan_terbuka/_tanpa_kategori/form_terbuka_bawah')
                        @endif--}}

                        @include('survei/pertanyaan_terbuka/_tanpa_kategori/form_terbuka_bawah')
                        <!-- END TERBUKA BAWAH -->                        

                    </div>


                    <div class="card-footer">
                        <table class="table table-borderless">
                            <tr>
                                @php
                                if($ci->uri->segment(5) == 'edit'){
                                    $segment5 = 'edit';
                                } else {
                                    $segment5 = 'do';
                                }
                                @endphp

                                <td class="text-left">
                                    <a class="btn btn-back btn-lg shadow" href="{{ base_url() . 'survei/' . $ci->uri->segment(2) . '/data-responden/' . $ci->uri->segment(4) . '/' . $segment5 }}">Kembali</a>
                                </td>

                                <td class="text-right">
                                    <button type="submit" class="btn btn-next btn-lg shadow-lg tombolSave">Selanjutnya</button>
                                </td>
                            </tr>
                        </table>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection



@section('javascript')

<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.1/jquery.min.js"></script>


<!-- UNSUR -->
<script>
<?php echo $js_pertanyaan_terbuka_atas ?>
<?php echo $js_pertanyaan_unsur ?>
<?php echo $js_pertanyaan_terbuka_bawah ?>
</script>







@foreach ($ci->db->get("pertanyaan_terbuka_$manage_survey->table_identity")->result() as $pt)
@if($pt->is_model_pilihan_ganda == 2)
<script type="text/javascript">
$(document).ready(function() {
    var checkboxes = $('.terbuka_{{ $pt->nomor_pertanyaan_terbuka }}');
    checkboxes.change(function() {
        if ($('.terbuka_{{ $pt->nomor_pertanyaan_terbuka }}:checked').length > 0) {
            checkboxes.removeAttr('required');
        } else {
            checkboxes.attr('required', 'required');
        }
    });
    if ($('.terbuka_{{ $pt->nomor_pertanyaan_terbuka }}:checked').length > 0) {
        checkboxes.removeAttr('required');
    }
});
</script>
@endif
@endforeach





<script>
    $('.form_survei').submit(function(e) {

        var textboxes = document.getElementsByClassName("form-alasan");
        for (var i = 0; i < textboxes.length; i++) {
            var textbox = textboxes[i].value;
            var result = !!textbox.match(/[-:;!?"'()/{}<>@#$%^&*_+=|`~]/)
            if (result) {
                //alert("Pengisian alasan hanya dapat menggunakan tanda baca(.) titik dan (,) koma");
                Swal.fire({
                    icon: 'warning',
                    title: 'Peringatan',
                    text: 'Pengisian alasan hanya dapat menggunakan tanda baca(.) titik dan (,) koma !',
                    confirmButtonColor: '#8950FC',
                    confirmButtonText: 'Baik, saya mengerti',
                })
                return false;
            }
        }

        $.ajax({
            url: $(this).attr('action'),
            type: 'POST',
            dataType: 'json',
            data: $(this).serialize(),
            cache: false,
            beforeSend: function() {
                $('.tombolSave').attr('disabled', 'disabled');
                $('.tombolSave').html('<i class="fa fa-spin fa-spinner"></i> Sedang diproses');

                KTApp.block('#kt_blockui_content', {
                    overlayColor: '#FFA800',
                    state: 'primary',
                    message: 'Processing...'
                });

                setTimeout(function() {
                    KTApp.unblock('#kt_blockui_content');
                }, 1000);

            },
            complete: function() {
                $('.tombolSave').removeAttr('disabled');
                $('.tombolSave').html('Selanjutnya');
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
                    // toastr["success"]('Data berhasil disimpan');

                    setTimeout(function() {
                        window.location.href = "<?= $url_next ?>";
                    }, 500);
                }
            }
        })
        return false;
    });


    $('.form-alasan').keyup(function() {
        var textboxes = document.getElementsByClassName("form-alasan");
        for (var i = 0; i < textboxes.length; i++) {
            var textbox = textboxes[i].value;
            var result = !!textbox.match(/[-:;!?"'()/{}<>@#$%^&*_+=|`~]/)
            if (result) {
                //alert("Pengisian alasan hanya dapat menggunakan tanda baca(.) titik dan (,) koma");
                Swal.fire({
                    icon: 'warning',
                    title: 'Peringatan',
                    text: 'Pengisian alasan hanya dapat menggunakan tanda baca(.) titik dan (,) koma !',
                    confirmButtonColor: '#8950FC',
                    confirmButtonText: 'Baik, saya mengerti',
                })
                textboxes[i].focus();
            }
        }
    });
</script>

@endsection