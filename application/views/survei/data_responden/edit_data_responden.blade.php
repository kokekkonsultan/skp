@extends('include_backend/_template')

@php
$ci = get_instance();
@endphp

@section('style')
<link rel="dns-prefetch" href="//fonts.gstatic.com">
<link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">


<style>
    .select2-container .select2-selection--single {
        /* height: 35px; */
        font-size: 1rem;
    }
</style>
@endsection

@section('content')

<div class="container mt-5 mb-5" style="">
    <div class="text-center" data-aos="fade-up">
        <div id="progressbar" class="mb-5">
            <li class="active" id="account"><strong>Data Responden</strong></li>
            <li id="personal"><strong>Pertanyaan Survei</strong></li>
            @if($status_saran == 1)
            <li id="payment"><strong>Saran</strong></li>
            @endif
            <li id="completed"><strong>Completed</strong></li>
        </div>
    </div>
    <br>
    <br>

    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card shadow mb-4 mt-4" data-aos="fade-up" style="">

                @include('survei/_include/_benner_survei')

                <div class="card-header text-center">
					<h3 class="mt-5" style="font-family: 'Exo 2', sans-serif;"><b>DATA RESPONDEN</b></h3>
					@include('include_backend/partials_backend/_tanggal_survei')
                </div>
                <div class="card-body">

                    @include('include_backend/partials_backend/_message')


                    <form action="{{base_url() . 'survei/' . $ci->uri->segment(2) . '/data-responden/' . $ci->uri->segment(4) . '/update'}}" class="form_responden" method="POST">


                        <span style="color: red; font-style: italic;">{!! validation_errors() !!}</span>

                        @if($manage_survey->is_layanan_survei != 0)
                        <div class="form-group">
                            <label for="layanan_survei" class="font-weight-bold">Layanan Survei <span class="text-danger">*</span></label>
                            {!! form_dropdown($id_layanan_survei); !!}
                        </div>
                        <br>
                        @endif



                        @foreach ($profil_responden->result() as $row)
                        @php
                        $nama_alias = $row->nama_alias;
                        $nama_alias_lainnya = $row->nama_alias. '_lainnya';
                        @endphp

                        <div class="form-group">
                            <label class="font-weight-bold">{{$row->nama_profil_responden}}<span class="text-danger">*</span></label>

                            @if ($row->jenis_isian == 2)
                            <input class="form-control" type="{{$row->type_data}}" name="{{$row->nama_alias}}" placeholder="Masukkan data anda ..." value="{!! $responden->$nama_alias !!}" required>

                            @else
                            <select class="form-control" name="{{$row->nama_alias}}" id="{{$row->nama_alias}}" required>
                                <option value="">Please Select</option>

                                @foreach ($kategori_profil_responden->result() as $value)
                                @if ($value->id_profil_responden == $row->id)

                                <option value="{{$value->id}}" id="{{$value->nama_kategori_profil_responden}}" <?php echo $responden->$nama_alias == $value->id ? 'selected' : '' ?>>
                                    {!! $value->nama_kategori_profil_responden !!}
                                </option>

                                @endif
                                @endforeach

                            </select>

                            @if ($row->is_lainnya == 1)
                            <input class="form-control mt-5" type="text" name="{{$row->nama_alias}}_lainnya" id="{{$row->nama_alias}}_lainnya" placeholder="Sebutkan Lainnya ..." value="{!! $responden->$nama_alias_lainnya !!}" <?php echo $responden->$nama_alias_lainnya == '' ? 'style="display: none;"' : ' required' ?>>
                            @endif

                            @endif
                        </div>

                        </br>
                        @endforeach


                </div>
                <div class="card-footer">
                    <table class="table table-borderless">
                        <tr>
                            <td class="text-right">
                                <button type="submit" class="btn btn-next btn-lg shadow tombolSave">Selanjutnya</button>
                            </td>
                        </tr>
                    </table>
                </div>
                </form>
            </div>


            <br><br>
        </div>
    </div>
</div>


@endsection

@section('javascript')
@php
if($ci->uri->segment(5) == 'edit'){
    $segment5 = '/edit';
} else {
    $segment5 = '';
}
@endphp
<script>
    $('.form_responden').submit(function(e) {

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
                }, 500);

            },
            complete: function() {
                $('.tombolCancel').removeAttr('disabled');
                $('.tombolSave').removeAttr('disabled');
                $('.tombolSave').html('Selanjutnya');
            },

            error: function(e) {
                Swal.fire(
                    'Gagal Menyimpan Data Survei!',
                    e,
                    'error'
                );
                setTimeout(function() {
                    location.reload();
                }, 500);
            },

            success: function(data) {
                if (data.validasi) {
                    $('.pesan').fadeIn();
                    $('.pesan').html(data.validasi);
                }
                if (data.sukses) {
                    // toastr["success"]('Data berhasil disimpan');

                    setTimeout(function() {
                        window.location.href =
                            "{{base_url() . 'survei/' . $ci->uri->segment(2) . '/pertanyaan/' . $ci->uri->segment(4) . $segment5}}";
                    }, 500);
                }
            }
        })
        return false;
    });
</script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
@php
$profil_responden_js = $ci->db->query("SELECT * FROM
profil_responden_$manage_survey->table_identity WHERE jenis_isian = 1 && is_lainnya = 1");
@endphp

@foreach($profil_responden_js->result() as $pr_js)
<script type='text/javascript'>
    $(window).load(function() {
        $("#{{$pr_js->nama_alias}}").change(function() {
            console.log(document.getElementById("{{$pr_js->nama_alias}}").options['Lainnya'].selected);

            if (document.getElementById("{{$pr_js->nama_alias}}").options['Lainnya'].selected == true) {
                $('#{{$pr_js->nama_alias}}_lainnya').show().prop('required', true);
            } else {
                $('#{{$pr_js->nama_alias}}_lainnya').removeAttr('required').hide();
            }
        });
    });
</script>
@endforeach



<script>
    $(document).ready(function() {
        $("#id_layanan_survei").select2({
            placeholder: "   Please Select",
            allowClear: true,
            closeOnSelect: true,
        });
    });
</script>

@endsection