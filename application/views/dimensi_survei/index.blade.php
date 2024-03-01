@extends('include_backend/template_backend')

@php
$ci = get_instance();
@endphp

@section('style')
<link href="{{ TEMPLATE_BACKEND_PATH }}plugins/custom/datatables/datatables.bundle.css" rel="stylesheet" type="text/css" />

@endsection

@section('content')

<div class="container-fluid">
    @include("include_backend/partials_no_aside/_inc_menu_repository")

    <div class="row mt-5">
        <div class="col-md-3">
            @include('manage_survey/menu_data_survey')
        </div>
        <div class="col-md-9">

            <div class="card card-custom bgi-no-repeat gutter-b"
                style="height: 150px; background-color: #1c2840; background-position: calc(100% + 0.5rem) 100%; background-size: 100% auto; background-image: url(/assets/img/banner/taieri.svg)"
                data-aos="fade-down">
                <div class="card-body d-flex align-items-center">
                    <div>
                        <h3 class="text-white font-weight-bolder line-height-lg mb-5">
                            {{strtoupper($title)}}
                        </h3>

                        @if ($is_question == 1)
                        <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#add">
                            <i class="fas fa-plus"></i> Tambah Dimensi
                        </button>
                        @endif
                    </div>
                </div>
            </div>

            <div class="card card-custom card-sticky" data-aos="fade-down">
                <div class="card-body">

                    <form
                        action="{{base_url() . $ci->session->userdata('username') . '/' . $ci->uri->segment(2) . '/dimensi-survei/update-urutan'}}"
                        method="POST" class="form_default">


                        <div class="table-responsive">
                            <table id="table" class="table table-bordered table-hover" cellspacing="0" width="100%"
                                style="font-size: 12px;">
                                <thead class="bg-secondary">
                                    <tr>
                                        <th width="5%">Kode</th>
                                        <th>Dimensi</th>
                                        @if($profiles->is_aspek == 1)
                                        <th>Aspek</th>
                                        @endif
                                        <th>Keterangan</th>
                                        <th></th>
                                        <?php if ($is_question == 1) {
                                        echo '<th></th>';
                                    } ?>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>

                        @if ($is_question == 1)
                        <button type="submit" class="font-weight-bold btn btn-danger btn-sm mt-3 tombolSimpanUrutan" onclick="return confirm('Apakah anda yakin ingin mengubah urutan kode dimensi ?')"><i class="fa fa-random"></i> Update Urutan Kode Dimensi</button>
                        @endif

                    </form>

                </div>
            </div>

        </div>
    </div>

</div>



<!-- ===================================================== MODAL ADD ==================================================================== -->
<div class="modal fade" id="add" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-secondary">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Dimensi</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form
                action="<?php echo base_url() . $ci->session->userdata('username') . '/' . $ci->uri->segment(2) . '/dimensi-survei/add' ?>"
                class="form_default" method="POST">
                <div class="modal-body">



                    @if ($profiles->is_aspek == 1)
                        @if ($aspek_survei->num_rows() > 0)
                        <div class="form-group">
                            <label class="font-weight-bold">Aspek
                                <span class="text-danger">*</span></label>
                            <select name="id_aspek" class="form-control" required>
                                <option value="">Please Select</option>
                                @foreach($aspek_survei->result() as $data)
                                <option value="{{$data->id}}">{{ $data->nama_aspek }}</option>
                                @endforeach
                            </select>
                        </div>
                        @else
                        <div class="">
                            Aspek survei masih kosong, silahkan tambahkan aspek survei. <a
                                href="{{ base_url() }}{{ $ci->session->userdata('username') }}/{{ $ci->uri->segment(2) }}/aspek-survei">Tambah
                                aspek survei</a>
                        </div>
                        @endif
                    @else
                    <input name="id_aspek" value="" hidden>
                    @endif


                    <div class="form-group">
                        <label class="font-weight-bold">Dimensi
                            <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <div class="input-group-prepend"><span
                                    class="input-group-text font-weight-bold">D{{$jumlah_tambahan}}</span>
                            </div>
                            <input type="text" class="form-control" name="dimensi" required autofocus>
                        </div>
                        <input type="hidden" name="kode" value="D{{$jumlah_tambahan}}">
                    </div>
                    <div class="form-group">
                        <label class="font-weight-bold">Keterangan</label>
                        <textarea class="form-control" name="keterangan" value=""></textarea>
                    </div>

                </div>

                <div class="modal-footer">
                    <div class="text-right mt-3">
                        <!-- <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button> -->
                        <button type="submit"
                            class="btn btn-primary btn-sm font-weight-bold tombolSimpan">Simpan</button>
                    </div>
                </div>
            </form>

        </div>
    </div>
</div>


@include('dimensi_survei/edit')


@endsection

@section('javascript')
<script src="{{ TEMPLATE_BACKEND_PATH }}plugins/custom/datatables/datatables.bundle.js"></script>
<script>
$(document).ready(function() {
    table = $('#table').DataTable({

        "processing": true,
        "serverSide": true,
        "order": [],
        "language": {
            "processing": '<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span> ',
        },
        "ajax": {
            "url": "<?php echo base_url() . $ci->session->userdata('username') . '/' . $ci->uri->segment(2) . '/dimensi-survei/ajax-list' ?>",
            "type": "POST",
            "data": function(data) {}
        },

        "columnDefs": [{
            "targets": [-1],
            "orderable": false,
        }, ],

    });
});

$('#btn-filter').click(function() {
    table.ajax.reload();
});
$('#btn-reset').click(function() {
    $('#form-filter')[0].reset();
    table.ajax.reload();
});

function delete_dimensi(id) {
    if (confirm('Are you sure delete this data?')) {
        $.ajax({
            url: "<?php echo base_url() . $ci->session->userdata('username') . '/' . $ci->uri->segment(2) . '/dimensi-survei/delete/' ?>" +
                id,
            type: "POST",
            dataType: "JSON",
            success: function(data) {
                if (data.status) {

                    table.ajax.reload();

                    Swal.fire(
                        'Informasi',
                        'Berhasil menghapus data',
                        'success'
                    );
                } else {
                    Swal.fire(
                        'Informasi',
                        'Hak akses terbatasi. Bukan akun administrator.',
                        'warning'
                    );
                }


            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert('Error deleting data');
            }
        });

    }
}
</script>




<script>
$('.form_default').submit(function(e) {

    $.ajax({
        url: $(this).attr('action'),
        type: 'POST',
        dataType: 'json',
        data: $(this).serialize(),
        cache: false,
        beforeSend: function() {
            $('.tombolSimpan').attr('disabled', 'disabled');
            $('.tombolSimpan').html('<i class="fa fa-spin fa-spinner"></i> Sedang diproses');

            $('.tombolSimpanUrutan').attr('disabled', 'disabled');
            $('.tombolSimpanUrutan').html('<i class="fa fa-spin fa-spinner"></i> Sedang diproses');



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

            $('.tombolSimpanUrutan').removeAttr('disabled');
            $('.tombolSimpanUrutan').html('<i class="fa fa-random"></i> Update Urutan Kode Dimensi');
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
                // Swal.fire(
                //         'Informasi',
                //         'Data berhasil disimpan',
                //         'success'
                //     );
                // window.setTimeout(function() {
                //         location.reload()
                //     }, 1500);
                table.ajax.reload();
            }
        }
    })
    return false;

});
</script>
@endsection