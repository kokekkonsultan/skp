@extends('include_backend/_template')

@php
$ci = get_instance();
$is_edit = $ci->uri->segment(5) == 'edit' ? '/edit' : '';
@endphp

@section('style')
<link rel="dns-prefetch" href="//fonts.gstatic.com">
<link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

<style>
    .input-nps-group {
        display: flex;
        height: 5rem;
        width: 100%;
    }

    input[type="radio"] {
        visibility: hidden;
        height: 0;
        width: 0;
    }


    .label-nps {
        display: flex;
        flex: auto;
        vertical-align: middle;
        align-items: center;
        justify-content: center;
        text-align: center;
        cursor: pointer;
        background-color: #FFFFFF;
        color: #d3d3d3;
        transition: color --transition-fast ease-out, background-color --transition-fast ease-in;
        user-select: none;
    }


    .label-nps-hijau {
        margin-left: 4px;
        border: 1px solid #30C895;
    }

    .label-nps-merah {
        margin-left: 4px;
        border: 1px solid #F14F4F;
    }

    .label-nps-orange {
        margin-left: 4px;
        border: 1px solid #FF8A06;
    }

    .label-nps-kuning {
        margin-left: 4px;
        border: 1px solid #FECD34;
    }

    input[type="radio"]:checked+label {
        background-color: #0072BB;
        color: #FFFFFF;
    }

    input[type="radio"]:hover:not(:checked)+label {
        background-color: #89CFF0;
        color: #232323;
    }
</style>
@endsection

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
        <div class="col-md-8 offset-md-2" style="font-size: 16px; font-family:arial, helvetica, sans-serif;">
            <div class="card shadow mb-4 mt-4" id="kt_blockui_content" data-aos="fade-up">

            @include('survei/_include/_benner_survei')

            
                <div class="card-header text-center">
                    <h3 class="mt-5" style="font-family: 'Exo 2', sans-serif;"><b>PERTANYAAN NPS</b></h3>
					@include('include_backend/partials_backend/_tanggal_survei')
                </div>
                <div class="card-body">

                    <form action="{{base_url() . 'survei/' . $ci->uri->segment(2) . '/add-pertanyaan-nps/' . $ci->uri->segment(4)}}" class="form_survei" method="POST">


                        @php
                        $i = 1;
                        @endphp

                        @foreach ($pertanyaan_nps->result() as $row)

                        <input type="hidden" name="id[{{ $i }}]" value="{{ $row->id }}">
                        <table class="table table-borderless mt-5 mb-5" width="100%" border="0">
                            <tr>
                                <td width="5%" valign="top">{{$i}}.</td>
                                <td width="95%">{!! $row->isi_pertanyaan !!}</td>
                            </tr>

                            <tr>
                                <td width="5%"></td>
                                <td style="font-weight: bold;" width="95%">


                                @if($manage_survey->is_emoji_nps == 1)

                                <div class="input-nps-group">
                                    @foreach ($ci->db->get_where("pilihan_jawaban_nps_$manage_survey->table_identity", ['id_pertanyaan_nps' => $row->id])->result() as $value)
                                        <input type="radio" name="jawaban_pertanyaan_nps[{{ $i }}]" id="nps_{{ $i . '_' . $value->bobot }}" value="{{ $value->bobot }}" <?= $row->is_required == 1 ? 'required' : '' ?> <?= $value->bobot == $row->skor_jawaban ? 'checked' : '' ?>>
                                        <label class="label-nps" for="nps_{{ $i . '_' . $value->bobot }}">
                                            <img src="{{base_url() . 'assets/img/emoji/' . $value->nama_kategori}}" width="30">
                                        </label>
                                    @endforeach
                                </div>

                                @else 

                                <div class="input-nps-group">
                                    @foreach ($ci->db->get_where("pilihan_jawaban_nps_$manage_survey->table_identity", ['id_pertanyaan_nps' => $row->id])->result() as $value)

                                    @php
                                    if($value->bobot < 2){
                                        $warna = 'merah';
                                    } elseif($value->bobot < 7) {
                                        $warna = 'orange';
                                    } elseif($value->bobot < 9) {
                                        $warna = 'kuning';
                                    } else {
                                        $warna = 'hijau';
                                    }
                                    @endphp

                                        <input type="radio" name="jawaban_pertanyaan_nps[{{ $i }}]" id="nps_{{ $i . '_' . $value->bobot }}" value="{{ $value->bobot }}" <?= $row->is_required == 1 ? 'required' : '' ?> <?= $value->bobot == $row->skor_jawaban ? 'checked' : '' ?>>
                                        <label class="label-nps label-nps-{{$warna}}" for="nps_{{ $i . '_' . $value->bobot }}">
                                            {{$value->bobot}}
                                        </label>
                                    @endforeach
                                </div>


                                @endif
                                    
                                </td>
                            </tr>
                        </table>
                        <br>

                        @php
                        $i++;
                        @endphp

                        @endforeach
                </div>


                <div class="card-footer">
                    <table class="table table-borderless">
                        <tr>
                            <td class="text-left">
                                @if(in_array(3, $atribut_pertanyaan))
                                <a class="btn btn-back btn-lg shadow tombolCancel" href="{{base_url() . 'survei/' . $ci->uri->segment(2) . '/pertanyaan-kualitatif/' . $ci->uri->segment(4) . $is_edit}}">Kembali</a>

                                @elseif (in_array(1, $atribut_pertanyaan))
                                <a class="btn btn-back btn-lg shadow tombolCancel" href="{{base_url() . 'survei/' . $ci->uri->segment(2) . '/pertanyaan-nps/' . $ci->uri->segment(4) . $is_edit}}">Kembali</a>

                                @else
                                <a class="btn btn-back btn-lg shadow tombolCancel" href="{{base_url() . 'survei/' . $ci->uri->segment(2) . '/pertanyaan/' . $ci->uri->segment(4) . $is_edit}}">Kembali</a>
                                @endif
                            </td>
                            <td class="text-right">
                                <button type="submit"
                                    class="btn btn-next btn-lg shadow tombolSave">Selanjutnya</button>
                            </td>
                        </tr>
                    </table>

                    </form>
                </div>
            </div>

        </div>
    </div>
</div>


@endsection

@section('javascript')
<script>
$('.form_survei').submit(function(e) {

    $.ajax({
        url: $(this).attr('action'),
        type: 'POST',
        dataType: 'json',
        data: $(this).serialize(),
        cache: false,
        beforeSend: function() {
            $('.tombolCancel').attr('disabled', 'disabled');
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
            $('.tombolCancel').removeAttr('disabled');
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
                    window.location.href = "<?php echo $url_next ?>";
                }, 500);
            }
        }
    })
    return false;
});
</script>
@endsection