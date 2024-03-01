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
    <div class="text-center aos-init aos-animate" data-aos="fade-up">
        <div id="progressbar" class="mb-5">
            <li class="active" id="account"><strong>Data Responden</strong></li>
            <li class="active" id="personal"><strong>Pertanyaan Survei</strong></li>
            <li id="payment"><strong>Saran</strong></li>
            <li id="completed"><strong>Completed</strong></li>
        </div>
    </div>
    <br>
    <br>
    <div class="row">
        <div class="col-md-8 offset-md-2" style="font-size: 16px;">
            <div class="card shadow mb-4 mt-4 aos-init aos-animate" data-aos="fade-up" style="font-family: 'Exo 2', sans-serif;">

                <img class="card-img-top" src="http://192.168.1.104:2249/assets/img/site/page/banner-survey.jpg" alt="new image">


                <div class="card-body text-center">
                    <h3 class="mt-5" style="font-family: 'Exo 2', sans-serif;"><b>PERTANYAAN UNSUR</b></h3>
                    MOHON DIISI SEBELUM TANGGAL <strong>28 February 2024</strong>
                </div>

                <form action="http://192.168.1.104:2249/survei/skm-tes/add_pertanyaan/ccd0a7e9-f682-4f93-a2a4-e62172f0226e" class="form_survei" method="POST">
                </form>
            </div>

            <!--============================================================================================================================================================================================================================================================================================================================================================================== -->





            <!-- LOOP UNSUR -->

            <div class="card card-body mt-5 mb-5">
                <input type="hidden" name="id_pertanyaan_unsur[1]" value="1">
                <table class="table table-borderless" width="100%" border="0">
                    <tbody>
                        <tr>
                            <td width="5%" valign="top">U1<b class="text-danger">*</b>.</td>
                            <td width="95%">
                                <p>Pertanyaan 1</p>
                            </td>
                        </tr>

                        <tr>
                            <td width="5%"></td>
                            <td style="font-weight:bold;" width="95%">

                                <!-- Looping Pilihan Jawaban -->
                                <div class="radio-inline mb-2">
                                    <label class="radio radio-outline radio-success radio-lg" style="font-size: 16px;">

                                        <input type="radio" name="jawaban_pertanyaan_unsur[1]" value="1" class="unsur_U1" required=""><span></span>
                                        Sangat Banyak - T1
                                    </label>
                                </div>
                                <div class="radio-inline mb-2">
                                    <label class="radio radio-outline radio-success radio-lg" style="font-size: 16px;">

                                        <input type="radio" name="jawaban_pertanyaan_unsur[1]" value="2" class="unsur_U1" required=""><span></span>
                                        Banyak - T2
                                    </label>
                                </div>
                                <div class="radio-inline mb-2">
                                    <label class="radio radio-outline radio-success radio-lg" style="font-size: 16px;">

                                        <input type="radio" name="jawaban_pertanyaan_unsur[1]" value="3" class="unsur_U1" required=""><span></span>
                                        Cukup Sedikit - T3
                                    </label>
                                </div>
                                <div class="radio-inline mb-2">
                                    <label class="radio radio-outline radio-success radio-lg" style="font-size: 16px;">

                                        <input type="radio" name="jawaban_pertanyaan_unsur[1]" value="4" class="unsur_U1" required=""><span></span>
                                        Sedikit - T4
                                    </label>
                                </div>
                                <div class="radio-inline mb-2">
                                    <label class="radio radio-outline radio-success radio-lg" style="font-size: 16px;">

                                        <input type="radio" name="jawaban_pertanyaan_unsur[1]" value="5" class="unsur_U1" required=""><span></span>
                                        Tidak Ada - T4
                                    </label>
                                </div>
                            </td>
                        </tr>

                        <tr>
                            <td width="5%"></td>
                            <td width="95%">

                                <textarea class="form-control form-alasan" type="text" name="alasan_pertanyaan_unsur[1]" id="input_alasan_U1" placeholder="Berikan alasan jawaban anda ..." pattern="^[a-zA-Z0-9.,\s]*$|^\w$" style="display:none"></textarea>

                                <small id="text_alasan_U1" class="text-danger" style="display:none">**Pengisian alasan
                                    hanya dapat menggunakan tanda baca
                                    (.) titik dan (,) koma</small>
                            </td>
                        </tr>

                    </tbody>
                </table>
            </div>





            <!-- START TERBUKA -->

            <!-- CEK ATRIBUTE -->


            <!-- Looping Pertanyaan Terbuka -->

            <div class="card card-body mt-5 mb-5" id="display_T1">
                <input type="hidden" name="id_pertanyaan_terbuka[1]" value="1">
                <table class="table table-borderless" width="100%" border="0">
                    <tbody>
                        <tr>
                            <td width="5%" valign="top">T1<b class="text-danger">*</b>.</td>
                            <td width="95%">
                                <p>Pertanyaan Tambahan 1</p>
                            </td>
                        </tr>



                        <tr>
                            <td width="5%"></td>
                            <td style="font-weight:bold;" width="95%">

                                <div class="radio-inline mb-2">
                                    <label class="radio radio-outline radio-success radio-lg" style="font-size: 16px;">
                                        <input type="radio" name="jawaban_pertanyaan_terbuka[1][]" value="Ya" class="terbuka_T1" required="">
                                        <span></span> Ya - T2
                                    </label>
                                </div>

                                <div class="radio-inline mb-2">
                                    <label class="radio radio-outline radio-success radio-lg" style="font-size: 16px;">
                                        <input type="radio" name="jawaban_pertanyaan_terbuka[1][]" value="Tidak" class="terbuka_T1" required="">
                                        <span></span> Tidak - T3
                                    </label>
                                </div>


                            </td>
                        </tr>


                    </tbody>
                </table>



            </div>

            <div class="card card-body mt-5 mb-5" id="display_T2">
                <input type="hidden" name="id_pertanyaan_terbuka[2]" value="2">
                <table class="table table-borderless" width="100%" border="0">
                    <tbody>
                        <tr>
                            <td width="5%" valign="top">T2<b class="text-danger">*</b>.</td>
                            <td width="95%">
                                <p>Pertanyaan Tambahan 2</p>
                            </td>
                        </tr>



                        <tr>
                            <td width="5%"></td>
                            <td style="font-weight:bold;" width="95%">

                                <div class="radio-inline mb-2">
                                    <label class="radio radio-outline radio-success radio-lg" style="font-size: 16px;">
                                        <input type="radio" name="jawaban_pertanyaan_terbuka[2][]" value="Ya" class="terbuka_T2" required="">
                                        <span></span> Ya - T4
                                    </label>
                                </div>

                                <div class="radio-inline mb-2">
                                    <label class="radio radio-outline radio-success radio-lg" style="font-size: 16px;">
                                        <input type="radio" name="jawaban_pertanyaan_terbuka[2][]" value="Tidak" class="terbuka_T2" required="">
                                        <span></span> Tidak - T3
                                    </label>
                                </div>


                            </td>
                        </tr>


                    </tbody>
                </table>



            </div>

            <div class="card card-body mt-5 mb-5" id="display_T3">
                <input type="hidden" name="id_pertanyaan_terbuka[3]" value="3">
                <table class="table table-borderless" width="100%" border="0">
                    <tbody>
                        <tr>
                            <td width="5%" valign="top">T3<b class="text-danger">*</b>.</td>
                            <td width="95%">
                                <p>Pertanyaan Tambahan 3</p>
                            </td>
                        </tr>



                        <tr>
                            <td width="5%"></td>
                            <td style="font-weight:bold;" width="95%">

                                <textarea class="form-control terbuka_T3" type="text" name="jawaban_pertanyaan_terbuka[3][]" placeholder="Masukkan Jawaban Anda ..." required=""></textarea>
                            </td>
                        </tr>




                    </tbody>
                </table>



            </div>





            <!-- END TERBUKA -->




            <div class="card card-body mt-5 mb-5">
                <input type="hidden" name="id_pertanyaan_unsur[2]" value="6">
                <table class="table table-borderless" width="100%" border="0">
                    <tbody>
                        <tr>
                            <td width="5%" valign="top">U2<b class="text-danger">*</b>.</td>
                            <td width="95%">
                                <p>Pertanyaan Unsur 2</p>
                            </td>
                        </tr>

                        <tr>
                            <td width="5%"></td>
                            <td style="font-weight:bold;" width="95%">

                                <!-- Looping Pilihan Jawaban -->
                                <div class="radio-inline mb-2">
                                    <label class="radio radio-outline radio-success radio-lg" style="font-size: 16px;">

                                        <input type="radio" name="jawaban_pertanyaan_unsur[2]" value="1" class="unsur_U2" required=""><span></span>
                                        Sangat Tidak Percaya -
                                    </label>
                                </div>
                                <div class="radio-inline mb-2">
                                    <label class="radio radio-outline radio-success radio-lg" style="font-size: 16px;">

                                        <input type="radio" name="jawaban_pertanyaan_unsur[2]" value="2" class="unsur_U2" required=""><span></span>
                                        Tidak Percaya -
                                    </label>
                                </div>
                                <div class="radio-inline mb-2">
                                    <label class="radio radio-outline radio-success radio-lg" style="font-size: 16px;">

                                        <input type="radio" name="jawaban_pertanyaan_unsur[2]" value="3" class="unsur_U2" required=""><span></span>
                                        Cukup Percaya -
                                    </label>
                                </div>
                                <div class="radio-inline mb-2">
                                    <label class="radio radio-outline radio-success radio-lg" style="font-size: 16px;">

                                        <input type="radio" name="jawaban_pertanyaan_unsur[2]" value="4" class="unsur_U2" required=""><span></span>
                                        Percaya -
                                    </label>
                                </div>
                                <div class="radio-inline mb-2">
                                    <label class="radio radio-outline radio-success radio-lg" style="font-size: 16px;">

                                        <input type="radio" name="jawaban_pertanyaan_unsur[2]" value="5" class="unsur_U2" required=""><span></span>
                                        Sangat Percaya -
                                    </label>
                                </div>
                            </td>
                        </tr>

                        <tr>
                            <td width="5%"></td>
                            <td width="95%">

                                <textarea class="form-control form-alasan" type="text" name="alasan_pertanyaan_unsur[2]" id="input_alasan_U2" placeholder="Berikan alasan jawaban anda ..." pattern="^[a-zA-Z0-9.,\s]*$|^\w$" style="display:none"></textarea>

                                <small id="text_alasan_U2" class="text-danger" style="display:none">**Pengisian alasan
                                    hanya dapat menggunakan tanda baca
                                    (.) titik dan (,) koma</small>
                            </td>
                        </tr>

                    </tbody>
                </table>
            </div>

        </div>
    </div>
</div>

@endsection



@section('javascript')

<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.1/jquery.min.js"></script>


<!-- UNSUR -->
<script>
    $(document).ready(function() {
        if ($('.unsur_U1:checked').val() == 1) {
            $('#input_alasan_U1').prop('required', true).show();
            $('#text_alasan_U1').show();
            $('#display_T1').show();
            $('.terbuka_T1').prop('required', true);
            $('#display_T2').show();
            $('.terbuka_T2').prop('required', true);
            $('#display_T3').show();
            $('.terbuka_T3').prop('required', true);
        }
        if ($('.unsur_U1:checked').val() == 2) {
            $('#input_alasan_U1').prop('required', true).show();
            $('#text_alasan_U1').show();
            $('#display_T1').hide();
            $('.terbuka_T1').removeAttr('required');
            $('#display_T2').show();
            $('.terbuka_T2').prop('required', true);
            $('#display_T3').show();
            $('.terbuka_T3').prop('required', true);
        }
        if ($('.unsur_U1:checked').val() == 3) {
            $('#input_alasan_U1').removeAttr('required').hide();
            $('#text_alasan_U1').hide();
            $('#display_T1').hide();
            $('.terbuka_T1').removeAttr('required');
            $('#display_T2').hide();
            $('.terbuka_T2').removeAttr('required');
            $('#display_T3').show();
            $('.terbuka_T3').prop('required', true);
        }
        if ($('.unsur_U1:checked').val() == 4) {
            $('#input_alasan_U1').removeAttr('required').hide();
            $('#text_alasan_U1').hide();
            $('#display_T1').hide();
            $('.terbuka_T1').removeAttr('required');
            $('#display_T2').hide();
            $('.terbuka_T2').removeAttr('required');
            $('#display_T3').hide();
            $('.terbuka_T3').removeAttr('required');
        }
        if ($('.unsur_U1:checked').val() == 5) {
            $('#input_alasan_U1').removeAttr('required').hide();
            $('#text_alasan_U1').hide();
            $('#display_T1').hide();
            $('.terbuka_T1').removeAttr('required');
            $('#display_T2').hide();
            $('.terbuka_T2').removeAttr('required');
            $('#display_T3').hide();
            $('.terbuka_T3').removeAttr('required');
        }
    });

    $(function() {
        $(':radio.unsur_U1').click(function() {
            if ($(this).val() == 1) {
                $('#input_alasan_U1').prop('required', true).show();
                $('#text_alasan_U1').show();
                $('#display_T1').show();
                $('.terbuka_T1').prop('required', true);
                $('#display_T2').show();
                $('.terbuka_T2').prop('required', true);
                $('#display_T3').show();
                $('.terbuka_T3').prop('required', true);
            }
            if ($(this).val() == 2) {
                $('#input_alasan_U1').prop('required', true).show();
                $('#text_alasan_U1').show();
                $('#display_T1').hide();
                $('.terbuka_T1').removeAttr('required');
                $('#display_T2').show();
                $('.terbuka_T2').prop('required', true);
                $('#display_T3').show();
                $('.terbuka_T3').prop('required', true);
            }
            if ($(this).val() == 3) {
                $('#input_alasan_U1').removeAttr('required').hide();
                $('#text_alasan_U1').hide();
                $('#display_T1').hide();
                $('.terbuka_T1').removeAttr('required');
                $('#display_T2').hide();
                $('.terbuka_T2').removeAttr('required');
                $('#display_T3').show();
                $('.terbuka_T3').prop('required', true);
            }
            if ($(this).val() == 4) {
                $('#input_alasan_U1').removeAttr('required').hide();
                $('#text_alasan_U1').hide();
                $('#display_T1').hide();
                $('.terbuka_T1').removeAttr('required');
                $('#display_T2').hide();
                $('.terbuka_T2').removeAttr('required');
                $('#display_T3').hide();
                $('.terbuka_T3').removeAttr('required');
            }
            if ($(this).val() == 5) {
                $('#input_alasan_U1').removeAttr('required').hide();
                $('#text_alasan_U1').hide();
                $('#display_T1').hide();
                $('.terbuka_T1').removeAttr('required');
                $('#display_T2').hide();
                $('.terbuka_T2').removeAttr('required');
                $('#display_T3').hide();
                $('.terbuka_T3').removeAttr('required');
            }
        });
    });
    $(document).ready(function() {
        if ($('.unsur_U2:checked').val() == 1) {
            $('#input_alasan_U2').prop('required', true).show();
            $('#text_alasan_U2').show();
        }
        if ($('.unsur_U2:checked').val() == 2) {
            $('#input_alasan_U2').prop('required', true).show();
            $('#text_alasan_U2').show();
        }
        if ($('.unsur_U2:checked').val() == 3) {
            $('#input_alasan_U2').removeAttr('required').hide();
            $('#text_alasan_U2').hide();
        }
        if ($('.unsur_U2:checked').val() == 4) {
            $('#input_alasan_U2').removeAttr('required').hide();
            $('#text_alasan_U2').hide();
        }
        if ($('.unsur_U2:checked').val() == 5) {
            $('#input_alasan_U2').removeAttr('required').hide();
            $('#text_alasan_U2').hide();
        }
    });

    $(function() {
        $(':radio.unsur_U2').click(function() {
            if ($(this).val() == 1) {
                $('#input_alasan_U2').prop('required', true).show();
                $('#text_alasan_U2').show();
            }
            if ($(this).val() == 2) {
                $('#input_alasan_U2').prop('required', true).show();
                $('#text_alasan_U2').show();
            }
            if ($(this).val() == 3) {
                $('#input_alasan_U2').removeAttr('required').hide();
                $('#text_alasan_U2').hide();
            }
            if ($(this).val() == 4) {
                $('#input_alasan_U2').removeAttr('required').hide();
                $('#text_alasan_U2').hide();
            }
            if ($(this).val() == 5) {
                $('#input_alasan_U2').removeAttr('required').hide();
                $('#text_alasan_U2').hide();
            }
        });
    });
</script>



<!-- TERBUKA -->
<script type="text/javascript">
    $(function() {
        $(':radio.terbuka_T1').click(function() {

            if ($(this).val() == 'Ya') {
                $("#terbuka_lainnya_T1").prop('required', false).hide();
                $("#text_terbuka_T1").hide();

                $('#display_T2').show();
                $('.terbuka_T2').prop('required', true);

                $('#display_T3').show();
                $('.terbuka_T3').prop('required', true);

            }

            if ($(this).val() == 'Tidak') {
                $("#terbuka_lainnya_T1").prop('required', false).hide();
                $("#text_terbuka_T1").hide();

                $('#display_T2').hide();
                $('.terbuka_T2').prop('required', false);

                $('#display_T3').show();
                $('.terbuka_T3').prop('required', true);

            }


            if ($(this).val() == 'Lainnya') {
                $("#terbuka_lainnya_T1").prop('required', true).show();
                $("#text_terbuka_T1").show();

                $('#display_T2').hide();
                $('.terbuka_T2').prop('required', false);

                $('#display_T3').show();
                $('.terbuka_T3').prop('required', true);

            }

        });

    });
</script>

<script type="text/javascript">
    $(function() {
        $(':radio.terbuka_T2').click(function() {

            if ($(this).val() == 'Ya') {
                $("#terbuka_lainnya_T2").prop('required', false).hide();
                $("#text_terbuka_T2").hide();

                $('#display_T3').hide();
                $('.terbuka_T3').prop('required', false);

            }

            if ($(this).val() == 'Tidak') {
                $("#terbuka_lainnya_T2").prop('required', false).hide();
                $("#text_terbuka_T2").hide();

                $('#display_T3').show();
                $('.terbuka_T3').prop('required', true);
            }


            if ($(this).val() == 'Lainnya') {
                $("#terbuka_lainnya_T1").prop('required', true).show();
                $("#text_terbuka_T1").show();

                $('#display_T3').show();
                $('.terbuka_T3').prop('required', true);

            }

        });

    });
</script>


@endsection