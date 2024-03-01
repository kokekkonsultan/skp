@extends('include_backend/_template')

@php
$ci = get_instance();
@endphp

@section('style')
<link rel="dns-prefetch" href="//fonts.gstatic.com">
<link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
@endsection

@section('content')


<div class="container mt-5 mb-5">
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
        <div class="col-md-8 offset-md-2" style="font-size: 16px; ">
            <div class="card shadow mb-4 mt-4" data-aos="fade-up" style="border-left: 0px solid #FFA800;">

            @include('survei/_include/_benner_survei')

                <div class="card-header text-center">
                    <h4><b>PERTANYAAN UNSUR</b> - @include('include_backend/partials_backend/_tanggal_survei')</h4>
                </div>

                <form>

                    <div class="card-body ml-5 mr-5">



                        {{-- Looping Pertanyaan Terbuka ATAS --}}
                        @foreach ($pertanyaan_terbuka_atas->result() as $row_terbuka_atas)
                        @php
                        $model_ta = $row_terbuka_atas->is_model_pilihan_ganda == 2 ? 'checkbox' : 'radio';
                        @endphp

                        <table class="table table-borderless" width="100%" border="0">
                            <input type="hidden" value="{{$row_terbuka_atas->id_pertanyaan_terbuka}}">
                            <tr>
                                <td width="4%" valign="top">{{$row_terbuka_atas->nomor_pertanyaan_terbuka}}.
                                </td>
                                <td><?php echo $row_terbuka_atas->isi_pertanyaan_terbuka ?></td>
                            </tr>
                            <tr>
                                <td></td>
                                <td style="font-weight:bold;">

                                    @foreach ($jawaban_pertanyaan_terbuka->result() as $value_terbuka_atas)

                                    @if ($value_terbuka_atas->id_perincian_pertanyaan_terbuka ==
                                    $row_terbuka_atas->id_perincian_pertanyaan_terbuka)

                                    <div class="{{$model_ta}}-inline mb-2">
                                        <label class="{{$model_ta}} {{$model_ta}}-outline {{$model_ta}}-success {{$model_ta}}-lg"
                                            style="font-size:16px">
                                            <input type="{{$model_ta}}" name="terbuka" value="" required><span></span>
                                            <?php echo $value_terbuka_atas->pertanyaan_ganda; ?>
                                        </label>
                                    </div>

                                    @endif
                                    @endforeach

                                    @if ($row_terbuka_atas->dengan_isian_lainnya == 1)
                                    <div class="{{$model_ta}}-inline mb-2">
                                        <label class="{{$model_ta}} {{$model_ta}}-outline {{$model_ta}}-success {{$model_ta}}-lg"
                                            style="font-size:16px">
                                            <input type="{{$model_ta}}" name="terbuka" value="Lainnya"><span></span>
                                            Lainnya</label>
                                    </div>
                                    <br>
                                    @endif

                                    @if ($row_terbuka_atas->id_jenis_pilihan_jawaban == 2)
                                    <input class="form-control" type="text" placeholder="Masukkan Jawaban Anda ..."
                                        value=""></input>
                                    @endif
                                </td>
                            </tr>
                        </table>
                        <hr>
                        <hr>
                        @endforeach






                        {{-- Looping Pertanyaan Unsur --}}

                        @foreach(
                            $ci->db->query("SELECT *
                            FROM (SELECT *, (SELECT COUNT(id) FROM unsur_pelayanan_$manage_survey->table_identity WHERE dimensi_$manage_survey->table_identity.id = unsur_pelayanan_$manage_survey->table_identity.id_dimensi) AS jumlah FROM dimensi_$manage_survey->table_identity) dms_$manage_survey->table_identity
                            WHERE jumlah > 0
                            ORDER BY id ASC")->result() as $dms
                        )

                        <div class="text-center" style="background-color: #FCF7B6; padding: 5px; font-family:Arial,Helvetica,sans-serif; color:#294087;">
                            <span style="font-size: 16px; font-weight: bold;">{{$dms->dimensi}}</span><br>
                            <span style="font-size: 13px;">{{$dms->keterangan}}</span>
                            
                        </div>
                        <br>


                        @foreach ($pertanyaan_unsur->result() as $row)
                        @if($dms->id == $row->id_dimensi)

                        <table class="table table-borderless" width="100%" border="0">
                            <tr>
                                <td width="4%" valign="top">{{ $row->nomor }}.</td>
                                <td><?php echo $row->isi_pertanyaan_unsur ?></td>
                            </tr>


                            <tr>
                                <td></td>
                                <td style="font-weight:bold;">

                                    {{-- Looping Pilihan Jawaban --}}
                                    @foreach ($jawaban_pertanyaan_unsur->result() as $value)

                                    @if ($value->id_pertanyaan_unsur == $row->id_pertanyaan_unsur)

                                    <div class="radio-inline mb-2">
                                        <label class="radio radio-outline radio-success radio-lg"
                                            style="font-size:16px">
                                            <input type="radio" name="jawaban_pertanyaan_unsur[]"
                                                value="{{$value->nomor_kategori_unsur_pelayanan}}"
                                                class="{{$value->id_pertanyaan_unsur}}" required><span></span>
                                            {{$value->nama_kategori_unsur_pelayanan}}
                                        </label>
                                    </div>

                                    @endif
                                    @endforeach

                                </td>
                            </tr>


                            <tr>
                                <td></td>
                                <td>
                                    <textarea class="form-control" type="text" name="alasan_pertanyaan_unsur[]"
                                        id="{{$row->id_pertanyaan_unsur}}" placeholder="Berikan alasan jawaban anda ..."
                                        style="display: none;"></textarea>

                                </td>
                            </tr>
                        </table>

                        @php
                        @endphp



                        <div id="display_terbuka_by_unsur_{{$row->id_pertanyaan_unsur}}">
                            <hr>

                            {{-- Looping Pertanyaan Terbuka --}}
                            @foreach ($pertanyaan_terbuka->result() as $row_terbuka)

                            @if ($row_terbuka->id_unsur_pelayanan == $row->id_unsur_pelayanan)
                            @php
                            $model_t = $row_terbuka->is_model_pilihan_ganda == 2 ? 'checkbox' : 'radio';
                            @endphp
                            <hr>
                            <div id="terbuka_display_{{$row_terbuka->nomor_pertanyaan_terbuka}}">
                                <!-- <hr style="border-top: 1px solid red;"> -->

                                <table class="table table-borderless" width="100%" border="0">
                                    <tr>
                                        <td width="4%" valign="top">{{$row_terbuka->nomor_pertanyaan_terbuka}}.</td>
                                        <td><?php echo $row_terbuka->isi_pertanyaan_terbuka ?></td>
                                    </tr>

                                    <tr>
                                        <td></td>
                                        <td style="font-weight:bold;">

                                            @foreach ($jawaban_pertanyaan_terbuka->result() as $value_terbuka)
                                            @if ($value_terbuka->id_perincian_pertanyaan_terbuka ==
                                            $row_terbuka->id_perincian_pertanyaan_terbuka)

                                            <div class="{{$model_t}}-inline mb-2">
                                                <label class="{{$model_t}} {{$model_t}}-outline {{$model_t}}-success {{$model_t}}-lg"
                                                    style="font-size:16px">
                                                    <input type="{{$model_t}}"
                                                        name="jawaban_pertanyaan_terbuka[{{$value_terbuka->id_pertanyaan_terbuka}}]"
                                                        value="{{$value_terbuka->pertanyaan_ganda}}"
                                                        class="terbuka_{{$row_terbuka->nomor_pertanyaan_terbuka}}"
                                                        required><span></span>
                                                    <?php echo $value_terbuka->pertanyaan_ganda; ?>
                                                </label>
                                            </div>

                                            @endif
                                            @endforeach

                                            @if ($row_terbuka->dengan_isian_lainnya == 1)
                                            <div class="{{$model_t}}-inline mb-2">
                                                <label class="{{$model_t}} {{$model_t}}-outline {{$model_t}}-success {{$model_t}}-lg"
                                                    style="font-size:16px">
                                                    <input type="{{$model_t}}" name="jawaban_pertanyaan_terbuka[]"
                                                        value="Lainnya"><span></span> Lainnya</label>
                                            </div>
                                            <br>
                                            @endif

                                            @if ($row_terbuka->id_jenis_pilihan_jawaban == 2)
                                            <input class="form-control" type="text" name="jawaban_pertanyaan_terbuka[]"
                                                placeholder="Masukkan Jawaban Anda ..." value=""></input>
                                            @endif
                                        </td>
                                    </tr>

                                </table>
                                <!-- <hr style="border-top: 1px solid red;"> -->
                            </div>
                            <hr>
                            @endif
                            @endforeach
                            <hr>
                        </div>
                        @endif
                        @endforeach
                        @endforeach






                        {{-- Looping Pertanyaan Terbuka BAWAH --}}
                        @foreach ($pertanyaan_terbuka_bawah->result() as $row_terbuka_bawah)
                        @php
                        $model_tb = $row_terbuka_bawah->is_model_pilihan_ganda == 2 ? 'checkbox' : 'radio';
                        @endphp

                        <table class="table table-borderless" width="100%" border="0">

                            <input type="hidden" value="{{$row_terbuka_bawah->id_pertanyaan_terbuka}}">
                            <tr>
                                <td width="4%" valign="top">
                                    {{$row_terbuka_bawah->nomor_pertanyaan_terbuka}}.
                                </td>
                                <td><?php echo $row_terbuka_bawah->isi_pertanyaan_terbuka ?></td>
                            </tr>
                            <tr>
                                <td></td>
                                <td style="font-weight:bold;">

                                    @foreach ($jawaban_pertanyaan_terbuka->result() as $value_terbuka_bawah)

                                    @if ($value_terbuka_bawah->id_perincian_pertanyaan_terbuka ==
                                    $row_terbuka_bawah->id_perincian_pertanyaan_terbuka)

                                    <div class="{{$model_tb}}-inline mb-2">
                                        <label class="{{$model_tb}} {{$model_tb}}-outline {{$model_tb}}-success {{$model_tb}}-lg"
                                            style="font-size:16px">
                                            <input type="{{$model_tb}}" name="terbuka" value="" required><span></span>
                                            <?php echo $value_terbuka_bawah->pertanyaan_ganda; ?>
                                        </label>
                                    </div>

                                    @endif
                                    @endforeach

                                    @if ($row_terbuka_bawah->dengan_isian_lainnya == 1)
                                    <div class="{{$model_tb}}-inline mb-2">
                                        <label class="{{$model_tb}} {{$model_tb}}-outline {{$model_tb}}-success {{$model_tb}}-lg"
                                            style="font-size:16px">
                                            <input type="{{$model_tb}}" name="terbuka" value="Lainnya"><span></span>
                                            Lainnya</label>
                                    </div>
                                    <br>
                                    @endif

                                    @if ($row_terbuka_bawah->id_jenis_pilihan_jawaban == 2)
                                    <input class="form-control" type="text" placeholder="Masukkan Jawaban Anda ..."
                                        value=""></input>
                                    @endif
                                </td>
                            </tr>
                        </table>
                        <hr>
                        <hr>
                        @endforeach


                    </div>

                    <div class="card-footer">
                        <table class="table table-borderless">
                            <tr>
                                <td class="text-left">
                                    {!! anchor(base_url() . $ci->uri->segment(1) . '/' .
                                    $ci->uri->segment(2)
                                    . '/preview-form-survei/data-responden', 'Kembali',
                                    ['class' => 'btn btn-back btn-lg shadow']) !!}
                                </td>
                                <td class="text-right">
                                    <a class="btn btn-next btn-lg shadow"
                                        href="<?php echo $url_next ?>">Selanjutnya</a>
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


@foreach ($pertanyaan_unsur->result() as $pr)
<script type="text/javascript">
$(function() {
    $(":radio.<?php echo $pr->id_pertanyaan_unsur; ?>").click(function() {
        $("#<?php echo $pr->id_pertanyaan_unsur; ?>").hide();



        <?php
        //LOOP KATEGORI UNSUR
        foreach($ci->db->get_where("kategori_unsur_pelayanan_$manage_survey->table_identity", array('id_pertanyaan_unsur' => $pr->id_pertanyaan_unsur))->result() as $row_kategori) {  ?>

        if ($(this).val() == <?php echo $row_kategori->nomor_kategori_unsur_pelayanan ?>) {


            $("#<?php echo $pr->id_pertanyaan_unsur; ?>")
                .<?php echo $row_kategori->nomor_kategori_unsur_pelayanan == 1 || $row_kategori->nomor_kategori_unsur_pelayanan == 2 ? "show().prop('required', true)" : "removeAttr('required').hide()" ?>;


            <?php foreach ($pertanyaan_terbuka->result() as $val_u) {
                      if ($val_u->id_unsur_pelayanan == $pr->id_unsur_pelayanan) { ?>

            $("#terbuka_display_<?php echo $val_u->nomor_pertanyaan_terbuka ?>")
                .<?php echo substr($val_u->nomor_pertanyaan_terbuka,1) < substr($row_kategori->is_next_step,1) ? 'hide()' : 'show()' ?>;

            <?php } } ?>


        }

        <?php } ?>

    });
});
</script>





@foreach ($pertanyaan_terbuka->result() as $val_terbuka)
@if ($val_terbuka->id_unsur_pelayanan == $pr->id_unsur_pelayanan)


@php
$pilihan_jawaban = $ci->db->query("SELECT *, (SELECT nomor_pertanyaan_terbuka FROM
pertanyaan_terbuka_$manage_survey->table_identity JOIN perincian_pertanyaan_terbuka_$manage_survey->table_identity ON
pertanyaan_terbuka_$manage_survey->table_identity.id =
perincian_pertanyaan_terbuka_$manage_survey->table_identity.id_pertanyaan_terbuka WHERE
isi_pertanyaan_ganda_$manage_survey->table_identity.id_perincian_pertanyaan_terbuka =
perincian_pertanyaan_terbuka_$manage_survey->table_identity.id) AS nomor_pertanyaan_terbuka,

IF(is_next_step != '', is_next_step, CONCAT('T',(SUBSTR((SELECT nomor_pertanyaan_terbuka FROM
pertanyaan_terbuka_$manage_survey->table_identity JOIN perincian_pertanyaan_terbuka_$manage_survey->table_identity ON
pertanyaan_terbuka_$manage_survey->table_identity.id =
perincian_pertanyaan_terbuka_$manage_survey->table_identity.id_pertanyaan_terbuka WHERE
isi_pertanyaan_ganda_$manage_survey->table_identity.id_perincian_pertanyaan_terbuka =
perincian_pertanyaan_terbuka_$manage_survey->table_identity.id),2) + 1))) AS hasil_if

FROM isi_pertanyaan_ganda_$manage_survey->table_identity WHERE id_perincian_pertanyaan_terbuka =
$val_terbuka->id_perincian_pertanyaan_terbuka");
@endphp

<script type="text/javascript">
$(function() {
    $(":radio.terbuka_{{$val_terbuka->nomor_pertanyaan_terbuka}}").click(function() {


        <?php 
        //LOOP 1
        foreach ($pilihan_jawaban->result() as $get_val_terbuka) { ?>

        if ($(this).val() == '<?php echo $get_val_terbuka->pertanyaan_ganda ?>') {



            <?php
                //LOOP 2
                foreach ($pertanyaan_terbuka->result() as $val_js) {
                      if ($val_js->id_unsur_pelayanan == $pr->id_unsur_pelayanan) { 

                        
                        if(substr($val_js->nomor_pertanyaan_terbuka,1) < substr($val_terbuka->nomor_pertanyaan_terbuka,1)) {
                            $status = '';
                        } else if((substr($val_js->nomor_pertanyaan_terbuka,1) > substr($get_val_terbuka->nomor_pertanyaan_terbuka,1)) && (substr($val_js->nomor_pertanyaan_terbuka,1) < substr($get_val_terbuka->hasil_if,1))) {

                            $status = '.hide()';
                        } else {
                            $status = '.show()';
                        };
                        ?>

            $("#terbuka_display_<?php echo $val_js->nomor_pertanyaan_terbuka ?>") <?php echo $status ?>;

            <?php }
                      } ?>

        }

        <?php } ?>


    });
});
</script>

@endif
@endforeach


@endforeach

@endsection