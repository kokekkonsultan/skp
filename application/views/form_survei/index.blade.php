@extends('include_backend/template_backend')

@php
$ci = get_instance();
@endphp

@section('style')
<link href="{{ TEMPLATE_BACKEND_PATH }}plugins/custom/datatables/datatables.bundle.css" rel="stylesheet" type="text/css">
<link href="{{ base_url() }}assets/vendor/bootstrap/css/bootstrap-colorpicker.css" rel="stylesheet" type="text/css" />
<script src="https://cdn.jsdelivr.net/npm/@jaames/iro@5"></script>
<style>
    .outer-box {
        font-family: arial;
        font-size: 24px;
        width: 580px;
        height: 114px;
        padding: 2px;
    }

    .box-edge-logo {
        font-family: arial;
        font-size: 14px;
        width: 110px;
        height: 110px;
        padding: 8px;
        float: left;
        text-align: center;
    }

    .box-edge-text {
        font-family: arial;
        font-size: 14px;
        width: 466px;
        height: 110px;
        padding: 8px;
        float: left;
    }

    .box-title {
        font-size: 18px;
        font-weight: bold;
    }

    .box-desc {
        font-size: 12px;
    }
</style>


<!-- <style>
    /* body {
    color: #ffffff;
    background: #171F30;
    line-height: 150%;
} */

    .wrap {
        max-width: 720px;
        margin: 0 auto;
        display: flex;
        flex-direction: row;
        align-items: center;
        justify-content: center;
    }

    .half {
        width: 50%;
        /* padding: 32px 0; */
    }

    .title-color {
        font-family: sans-serif;
        /* line-height: 24px; */
        display: block;
        padding: 8px 0;
        font-weight: bold;
    }

    .readout {
        /* margin-top: 32px; */
        line-height: 180%;
    }

    .colorSquare {
        height: 50px;
        width: 50px;
        /* background-color: red; */
        border-radius: 10%;
        margin-bottom: 10px;
    }
</style> -->
@endsection

@section('content')

<div class="container-fluid">
    @include("include_backend/partials_no_aside/_inc_menu_repository")

    <div class="row mt-5">
        <div class="col-md-3">
            @include('manage_survey/menu_data_survey')
        </div>
        <div class="col-md-9">

            <div class="card card-custom" data-aos="fade-down">
                <div class="card-header font-weight-bold">
                    <div class="card-title">
                        {{ $title }}
                    </div>
                    <div class="card-toolbar">
                        <a href="{{base_url() . $ci->session->userdata('username') . '/' . $ci->uri->segment(2) . '/setting-form-survei'}}" class="btn btn-sm btn-secondary font-weight-bold mr-2" target="_blank">
                            <i class="flaticon-interface-10"></i> Masuk Ke Pengaturan Form Survei
                        </a>
                        <a href="{{base_url() . $ci->session->userdata('username') . '/' . $ci->uri->segment(2) . '/preview-form-survei/opening'}}" class="btn btn-sm btn-primary font-weight-bold" target="_blank">
                            <i class="flaticon-interface-10"></i> Lihat Tampilan Form Survei
                        </a>
                    </div>
                </div>
                <div class="card-body">

                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active font-weight-bold" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Judul & sub judul</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link font-weight-bold" id="text-tab" data-toggle="tab" href="#text" role="tab" aria-controls="benner" aria-selected="false">Text</a>
                        </li>


                        <li class="nav-item">
                            <a class="nav-link font-weight-bold" id="benner-tab" data-toggle="tab" href="#benner" role="tab" aria-controls="benner" aria-selected="false">Banner</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link font-weight-bold" id="benner-tab" data-toggle="tab" href="#background" role="tab" aria-controls="benner" aria-selected="false">Latar Belakang</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link font-weight-bold" id="description-tab" data-toggle="tab" href="#description" role="tab" aria-controls="description" aria-selected="false">Kata Pembuka</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link font-weight-bold" id="tombol-tab" data-toggle="tab" href="#tombol" role="tab" aria-controls="benner" aria-selected="false">Tombol</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link font-weight-bold" id="saran-tab" data-toggle="tab" href="#saran" role="tab" aria-controls="saran" aria-selected="false">Form Saran</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link font-weight-bold" id="penutup-tab" data-toggle="tab" href="#penutup" role="tab" aria-controls="penutup" aria-selected="false">Kata Penutup</a>
                        </li>
                    </ul>

                    <br>


                    <div class="tab-content" id="myTabContent">

                        <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                            @include('form_survei/_include/_judul')
                        </div>

                        <div class="tab-pane fade" id="text" role="tabpanel" aria-labelledby="text-tab">
                            @include('form_survei/_include/_font_text')
                        </div>


                        <div class="tab-pane fade" id="benner" role="tabpanel" aria-labelledby="benner-tab">
                            @include('form_survei/_include/_benner')
                        </div>


                        <div class="tab-pane fade" id="background" role="tabpanel" aria-labelledby="background-tab">
                            @include('form_survei/_include/_latar_belakang')
                        </div>


                        <div class="tab-pane fade" id="description" role="tabpanel" aria-labelledby="description-tab">
                            @include('form_survei/_include/_kata_pembuka')
                        </div>


                        <div class="tab-pane fade" id="tombol" role="tabpanel" aria-labelledby="tombol-tab">
                            @include('form_survei/_include/_font_button')
                        </div>


                        <div class="tab-pane fade" id="saran" role="tabpanel" aria-labelledby="saran-tab">
                            @include('form_survei/_include/_form_saran')
                        </div>


                        <div class="tab-pane fade" id="penutup" role="tabpanel" aria-labelledby="penutup-tab">
                            @include('form_survei/_include/_kata_penutup')
                        </div>


                    </div>
                </div>
            </div>

        </div>
    </div>
</div>





<!-- 
<div class="modal fade" id="warna-survei" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content border border-white" style="background-color: #1c2840; color:#ffffff;">
            <div class="modal-body">

                <form
                    action="<?php echo base_url() . $ci->session->userdata('username') . '/' . $ci->uri->segment(2) . '/form-survei/update-kode-warna' ?>"
                    class="form_header">

                    <div class="wrap">
                        <div class="half">
                            <div class="colorPicker"></div>
                        </div>
                        <div class="half readout">
                            <h6 class="title-color">Warna Yang di Pilih :</h6>
                            <div class="colorSquare" id="colorSquare"></div>
                            <div class="" id="values"></div>

                            <div class="input-group input-group-sm mb-3 mt-5">
                                <input class="form-control" id="hexInput" name="kode_warna"
                                    placeholder="Silahkan pilih warna..." aria-label="Small"
                                    aria-describedby="inputGroup-sizing-sm">
                                <div class="input-group-append">
                                    <span class="input-group-text" id="inputGroup-sizing-sm"><i
                                            class="fa fa-paint-brush"></i></span>
                                </div>
                            </div>



                        </div>
                    </div>

                    <div class="text-right mt-5">
                        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
                        <button type="submit"
                            class="btn btn-light-primary btn-sm font-weight-bold tombolSimpanHeader">Update
                            Warna</button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div> -->

@endsection

@section('javascript')

<script src="https://cdn.ckeditor.com/ckeditor5/34.2.0/classic/ckeditor.js"></script>
<script src="{{ base_url() }}assets/vendor/bootstrap/js/bootstrap-colorpicker.js"></script>

<script>
    $(function() {
        //$('#cp1, #cp2, #cp3').colorpicker({"color": "#CCC"});
        $('#cp3').colorpicker({
            "color": "{{ $warna_latar_belakang1 }}"
        });
        $('#cp1').colorpicker({
            "color": "{{ $warna_latar_belakang2 }}"
        });
        $('#cp2').colorpicker({
            "color": "{{ $warna_latar_belakang3 }}"
        });

        $('#cp6').colorpicker({
            "color": "{{ $warna_benner1 }}"
        });
        $('#cp4').colorpicker({
            "color": "{{ $warna_benner2 }}"
        });
        $('#cp5').colorpicker({
            "color": "{{ $warna_benner3 }}"
        });
    });
</script>

<script>
    ClassicEditor
        .create(document.querySelector('#editor'))
        .then(editor => {
            console.log(editor);
        })
        .catch(error => {
            console.error(error);
        });
    ClassicEditor.create(document.querySelector('#editor-penutup'));
</script>

<script>
    $('.form_pembuka').submit(function(e) {

        $.ajax({
            url: $(this).attr('action'),
            type: 'POST',
            dataType: 'json',
            data: $(this).serialize(),
            cache: false,
            beforeSend: function() {
                $('.tombolSimpanPembuka').attr('disabled', 'disabled');
                $('.tombolSimpanPembuka').html('<i class="fa fa-spin fa-spinner"></i> Sedang diproses');

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
                $('.tombolSimpanPembuka').removeAttr('disabled');
                $('.tombolSimpanPembuka').html('Update Deskripsi');
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
                    toastr["success"]('Data berhasil disimpan');
                }
            }
        })
        return false;
    });

    $('.form_penutup').submit(function(e) {

        $.ajax({
            url: $(this).attr('action'),
            type: 'POST',
            dataType: 'json',
            data: $(this).serialize(),
            cache: false,
            beforeSend: function() {
                $('.tombolSimpanPenutup').attr('disabled', 'disabled');
                $('.tombolSimpanPenutup').html('<i class="fa fa-spin fa-spinner"></i> Sedang diproses');

                // KTApp.block('#content_1', {
                // 	overlayColor: '#000000',
                // 	state: 'primary',
                // 	message: 'Processing...'
                // });

                // setTimeout(function() {
                // 	KTApp.unblock('#content_1');
                // }, 1000);

            },
            complete: function() {
                $('.tombolSimpanPenutup').removeAttr('disabled');
                $('.tombolSimpanPenutup').html('Update Kata Penutup');
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
                    toastr["success"](data.sukses);
                }
            }
        })
        return false;
    });

    $('.form_header').submit(function(e) {

        $.ajax({
            url: $(this).attr('action'),
            type: 'POST',
            dataType: 'json',
            data: $(this).serialize(),
            cache: false,
            beforeSend: function() {
                $('.tombolSimpanHeader').attr('disabled', 'disabled');
                $('.tombolSimpanHeader').html('<i class="fa fa-spin fa-spinner"></i> Sedang diproses');

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
                $('.tombolSimpanHeader').removeAttr('disabled');
                $('.tombolSimpanHeader').html('Simpan');
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
                    toastr["success"]('Data berhasil disimpan');
                    window.setTimeout(function() {
                        location.reload()
                    }, 1500);
                }
            }
        })
        return false;
    });

    $('.form_saran').submit(function(e) {
        $.ajax({
            url: $(this).attr('action'),
            type: 'POST',
            dataType: 'json',
            data: $(this).serialize(),
            cache: false,
            beforeSend: function() {
                $('.tombolSimpanSaran').attr('disabled', 'disabled');
                $('.tombolSimpanSaran').html('<i class="fa fa-spin fa-spinner"></i> Sedang diproses');

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
                $('.tombolSimpanSaran').removeAttr('disabled');
                $('.tombolSimpanSaran').html('Update Form Saran');
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
                    toastr["success"]('Data berhasil disimpan');
                }
            }
        })
        return false;
    });
</script>

<script>
    $(document).ready(function() {

        $('#tanggal_survei').on('change', '.toggle_tanggal_1', function() {
            // alert("TT");
            var mode = $(this).prop('checked');
            var nilai_id = $(this).val();

            $.ajax({
                type: 'POST',
                dataType: 'JSON',
                url: "{{ base_url() }}{{ $ci->session->userdata('username') }}/{{ $ci->uri->segment(2) }}/form-survei/update-is-display-tanggal-survei",
                data: {
                    'mode': mode,
                    'nilai_id': nilai_id
                },
                success: function(data) {
                    var data = eval(data);
                    message = data.message;
                    success = data.success;

                    toastr["success"](message);

                    setTimeout(function() {
                        window.location.href = (
                            "{{ base_url() }}{{ $ci->session->userdata('username') }}/{{ $ci->uri->segment(2) }}/form-survei"
                        );
                    }, 2000);

                }
            });
        });



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

                    setTimeout(function() {
                        window.location.href = (
                            "{{ base_url() }}{{ $ci->session->userdata('username') }}/{{ $ci->uri->segment(2) }}/form-survei"
                        );
                    }, 2000);

                }
            });
        });


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

                    setTimeout(function() {
                        window.location.href = (
                            "{{ base_url() }}{{ $ci->session->userdata('username') }}/{{ $ci->uri->segment(2) }}/form-survei"
                        );
                    }, 2000);

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

        function ganti_warna_backgorund(mode, nilai_id, warna_latar_belakang) {
            $.ajax({

                type: 'POST',
                dataType: 'JSON',
                url: "{{ base_url() }}{{ $ci->session->userdata('username') }}/{{ $ci->uri->segment(2) }}/form-survei/update-is-background",
                data: {
                    'mode': mode,
                    'nilai_id': nilai_id,
                    'warna_latar_belakang': warna_latar_belakang,
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

        document.getElementById("warna4").onchange = function() {
            var mode = $(this).prop('checked');
            var nilai_id = '{{ $manage_survey->is_latar_belakang }}';
            warna_latar_belakang = $('input:enabled[name="warna_latar_belakang[]"]').map(function() {
                return $(this).val();
            }).get();

            ganti_warna_backgorund(mode, nilai_id, warna_latar_belakang);
        }

        document.getElementById("warna5").onchange = function() {
            var mode = $(this).prop('checked');
            var nilai_id = '{{ $manage_survey->is_latar_belakang }}';
            warna_latar_belakang = $('input:enabled[name="warna_latar_belakang[]"]').map(function() {
                return $(this).val();
            }).get();

            ganti_warna_backgorund(mode, nilai_id, warna_latar_belakang);
        }

        document.getElementById("warna6").onchange = function() {
            var mode = $(this).prop('checked');
            var nilai_id = '{{ $manage_survey->is_latar_belakang }}';
            warna_latar_belakang = $('input:enabled[name="warna_latar_belakang[]"]').map(function() {
                return $(this).val();
            }).get();

            ganti_warna_backgorund(mode, nilai_id, warna_latar_belakang);
        }


        $('#tableBackground').on('change', '.toggle_background_1', function() {
            // alert("TT");
            var mode = $(this).prop('checked');
            var nilai_id = $(this).val();
            //var warna_latar_belakang = [];
            warna_latar_belakang = $('input:enabled[name="warna_latar_belakang[]"]').map(function() {
                return $(this).val();
            }).get();

            $.ajax({

                type: 'POST',
                dataType: 'JSON',
                url: "{{ base_url() }}{{ $ci->session->userdata('username') }}/{{ $ci->uri->segment(2) }}/form-survei/update-is-background",
                data: {
                    'mode': mode,
                    'nilai_id': nilai_id,
                    'warna_latar_belakang': warna_latar_belakang,
                },
                success: function(data) {
                    var data = eval(data);
                    message = data.message;
                    success = data.success;

                    toastr["success"](message);

                    setTimeout(function() {
                        window.location.href = (
                            "{{ base_url() }}{{ $ci->session->userdata('username') }}/{{ $ci->uri->segment(2) }}/form-survei"
                        );
                    }, 2000);

                }
            });
        });
        //--------------------------------END BANNER DAN LATAR BELAKANG--------------------------------//

    });
</script>

<script type="text/javascript">
    $('#uploadForm').submit(function(e) {
        e.preventDefault();

        var reader = new FileReader();
        reader.readAsDataURL(document.getElementById('profil').files[0]);

        var formdata = new FormData();
        formdata.append('file', document.getElementById('profil').files[0]);
        $.ajax({
            method: 'POST',
            contentType: false,
            cache: false,
            processData: false,
            data: formdata,
            dataType: 'json',
            url: "<?php echo base_url() . $ci->session->userdata('username') . '/' . $ci->uri->segment(2) . '/form-survei/do-uploud' ?>",
            beforeSend: function() {
                $('.tombolUploud').attr('disabled', 'disabled');
                $('.tombolUploud').html('<i class="fa fa-spin fa-spinner"></i> Sedang diproses');

            },
            complete: function() {
                $('.tombolUploud').removeAttr('disabled');
                $('.tombolUploud').html('Upload');
            },
            error: function(e) {
                Swal.fire(
                    'Error !',
                    e,
                    'error'
                )
            },

            success: function(data) {
                if (data.error) {
                    toastr["danger"]('Data gagal disimpan');
                } else {
                    $('#uploadForm')[0].reset();
                    toastr["success"]('Data berhasil disimpan');
                    window.setTimeout(function() {
                        location.reload()
                    }, 1000);
                }

            }
        });
        return false;
    });
</script>

<script>
    $('.form_atribut_pertanyaan').submit(function(e) {
        $.ajax({
            url: $(this).attr('action'),
            type: 'POST',
            dataType: 'json',
            data: $(this).serialize(),
            cache: false,
            beforeSend: function() {
                $('.tombolSimpanJenisPertanyaan').attr('disabled', 'disabled');
                $('.tombolSimpanJenisPertanyaan').html(
                    '<i class="fa fa-spin fa-spinner"></i> Sedang diproses');

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
                $('.tombolSimpanJenisPertanyaan').removeAttr('disabled');
                $('.tombolSimpanJenisPertanyaan').html('Update Jenis Pertanyaan');
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
                    toastr["success"]('Data berhasil disimpan');
                    window.setTimeout(function() {
                        location.reload()
                    }, 1000);
                }
            }
        })
        return false;
    });
</script>


<script>
    var kode_warna = "<?php echo $kode_warna ?>";
    var values = document.getElementById("values");
    var hexInput = document.getElementById("hexInput");
    let colorSquare = document.getElementById("colorSquare");

    var colorPicker = new iro.ColorPicker(".colorPicker", {
        width: 180,
        color: kode_warna,
        borderWidth: 2,
        borderColor: "#fff"
    });

    colorPicker.on(["color:init", "color:change"], function(color) {
        values.innerHTML = [
            "<b>HEX : </b>" + color.hexString,
            "<b>RGB : </b>" + color.rgbString,
            "<b>HSL : </b>" + color.hslString
        ].join("<br>");

        hexInput.value = color.hexString;
        colorSquare.style.backgroundColor = color.hexString;
    });
    hexInput.addEventListener("change", function() {
        colorPicker.color.hexString = this.value;
    });
</script>
@endsection