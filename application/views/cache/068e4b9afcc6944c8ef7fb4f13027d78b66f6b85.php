<?php
$ci = get_instance();
?>

<?php $__env->startSection('style'); ?>
<link href="<?php echo e(TEMPLATE_BACKEND_PATH); ?>plugins/custom/datatables/datatables.bundle.css" rel="stylesheet"
    type="text/css" />
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

<div class="container-fluid">
    <?php echo $__env->make("include_backend/partials_no_aside/_inc_menu_repository", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <div class="row mt-5">
        <div class="col-md-3">
            <?php echo $__env->make('manage_survey/menu_data_survey', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        </div>
        <div class="col-md-9">

            <div class="card card-custom bgi-no-repeat gutter-b"
                style="height: 150px; background-color: #1c2840; background-position: calc(100% + 0.5rem) 100%; background-size: 100% auto; background-image: url(/assets/img/banner/taieri.svg)"
                data-aos="fade-down">
                <div class="card-body d-flex align-items-center">
                    <div>
                        <h3 class="text-white font-weight-bolder line-height-lg mb-5">
                            <?php echo e(strtoupper($title)); ?>

                        </h3>


                        <?php if($profiles->is_question == 1 && $profiles->is_layanan_survei == 1): ?>
                        <?php
                        $color = $profiles->is_kategori_layanan_survei == 0 ? 'warning' : 'danger';
                        $text = $profiles->is_kategori_layanan_survei == 0 ? 'Aktifkan' : 'Non-Aktifkan';
                        ?>

                        <a class="btn btn-primary btn-sm" data-toggle="modal" data-target="#add"><i
                                class="fa fa-plus"></i> Tambah Barang/Jasa yang di Survei
                            
                        </a>

                        <a class="btn btn-<?php echo e($color); ?> btn-sm" data-toggle="modal" data-target="#activate"><i
                                class="fa fa-toggle-on"></i> <?php echo e($text); ?> Kategori Barang/Jasa Survei
                        </a>
                        <?php endif; ?>

                    </div>
                </div>
            </div>


            <div class=" card mb-5 mt-5" data-aos="fade-down">
                <div class="card-body">

                    <?php if($profiles->is_question == 1): ?>
                    <div id="tablex">
                        <div class="custom-control custom-switch mt-5 mb-5">
                            <input type="checkbox" name="setting_value" class="custom-control-input toggle_dash_1"
                                value="<?php echo e($profiles->is_layanan_survei); ?>" id="customSwitch1"
                                <?= $profiles->is_layanan_survei == 1 ? 'checked' : '' ?> />
                            <label class="custom-control-label" for="customSwitch1">Aktifkan Layanan Survei</label>
                        </div>
                    </div>

                    <?php else: ?>
                    <div class="custom-control custom-switch mt-5 mb-5">
                            <input type="checkbox"class="custom-control-input"
                                <?= $profiles->is_layanan_survei == 1 ? 'checked' : '' ?>  disabled>
                            <label class="custom-control-label" for="customSwitch1">Aktifkan Layanan Survei</label>
                        </div>

                    <?php endif; ?>


                    <div class="alert alert-secondary mb-5" role="alert">
                            <i class="flaticon-exclamation-1"></i> Jika Anda mengaktifkan layanan survei, maka survei yang anda buat akan menggunakan layanan survei.
                        </div>
                </div>
            </div>




            <?php if($profiles->is_layanan_survei == 1): ?>
            <div class="card card-custom card-sticky" data-aos="fade-down">
                <div class="card-body">

                    <form
                        action="<?php echo e(base_url() . $ci->session->userdata('username') . '/' . $ci->uri->segment(2) . '/layanan-survei/update-urutan'); ?>"
                        method="POST" class="form_default_urutan">
                        <div class="table-responsive">
                            <table id="table" class="table table-bordered table-hover example" style="width:100%">
                                <thead class="bg-secondary">
                                    <tr>
                                        <th width="5%">Urutan</th>
                                        <th>Nama Barang/Jasa</th>
                                        <?php if($profiles->is_kategori_layanan_survei == 1): ?>
                                        <th>Nama Kategori</th>
                                        <?php endif; ?>
                                        <th>Status</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                                <?php
                                $total_layanan = $layanan->num_rows();
                                ?>

                            </table>
                        </div>

                        <?php if($profiles->is_question == 1 && $total_layanan > 0): ?>
                        <button type="submit" class="btn btn-light-primary btn-sm mt-5 tombolSimpanUrutan">Simpan Urutan
                            Barang/Jasa</button>
                        <?php endif; ?>
                    </form>

                </div>
            </div>
            <?php endif; ?>

        </div>
    </div>
</div>



<!-- MODAL ADD -->
<div class="modal fade" id="add" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-secondary">
                <span class="modal-title" id="exampleModalLabel">Tambah Barang/Jasa</span>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close"></i>
                </button>
            </div>
            <form
                action="<?php echo base_url() . $ci->session->userdata('username') . '/' . $ci->uri->segment(2) . '/layanan-survei/add' ?>"
                method="POST" class="form_default">
                <div class="modal-body">

                    <?php if($profiles->is_kategori_layanan_survei == 1): ?>
                    <div class="form-group">
                        <label class="col-form-label font-weight-bold">Kategori Barang/Jasa<span
                                style="color: red;">*</span></label>
                        <?php if($kategori_layanan->num_rows() > 0): ?>

                        <select name="id_kategori_layanan" class="form-control" required>
                            <option value="">Please Select</option>
                            <?php $__currentLoopData = $kategori_layanan->result(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($data->id); ?>"><?php echo e($data->nama_kategori_layanan); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                        <?php else: ?>
                        <div class="">
                            Kategori barang/jasa survei masih kosong, silahkan tambahkan kategori barang/jasa survei. <a
                                href="<?php echo e(base_url()); ?><?php echo e($ci->session->userdata('username')); ?>/<?php echo e($ci->uri->segment(2)); ?>/kategori-layanan-survei">Tambah
                                kategori barang/jasa survei</a>
                        </div>
                        <?php endif; ?>
                    </div>
                    <?php else: ?>
                    <input name="id_kategori_layanan" value="" hidden>
                    <?php endif; ?>

                    <?php if($profiles->is_kategori_layanan_survei == 1): ?>
                    <?php if($kategori_layanan->num_rows() > 0): ?>
                    <div class="form-group">
                        <label class="col-form-label font-weight-bold">Nama Barang/Jasa<span
                                style="color: red;">*</span></label>
                        <input class="form-control" name="nama_layanan" value="" required>
                    </div>
                    <?php endif; ?>
                    <?php else: ?>
                    <div class="form-group">
                        <label class="col-form-label font-weight-bold">Nama Barang/Jasa<span
                                style="color: red;">*</span></label>
                        <input class="form-control" name="nama_layanan" value="" required>
                    </div>
                    <?php endif; ?>


                </div>
                <div class="modal-footer">
                    <div class="text-right mt-3">
                        
                        <button type="submit" class="btn btn-primary btn-sm tombolSimpanDefault">Simpan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>


<!-- Modal EDIT -->
<?php $__currentLoopData = $layanan->result(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<div class="modal fade" id="edit_<?php echo e($row->id); ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-secondary">
                <span class="modal-title" id="exampleModalLabel">Ubah Barang/Jasa</span>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close"></i>
                </button>
            </div>
            <form
                action="<?php echo base_url() . $ci->session->userdata('username') . '/' . $ci->uri->segment(2) . '/layanan-survei/edit' ?>"
                method="POST" class="form_default">
                <div class="modal-body">

                    <input name="id" value="<?php echo e($row->id); ?>" hidden>
                    <?php if($profiles->is_kategori_layanan_survei == 1): ?>
                    <div class="form-group">
                        <label class="col-form-label font-weight-bold">Kategori Barang/Jasa<span
                                style="color: red;">*</span></label>
                        <select name="id_kategori_layanan" class="form-control" required>
                            <option value="">Please Select</option>
                            <?php $__currentLoopData = $kategori_layanan->result(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($data->id); ?>"
                                <?php echo e($data->id == $row->id_kategori_layanan ? 'selected' : ''); ?>>
                                <?php echo e($data->nama_kategori_layanan); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                    <?php else: ?>
                    <input name="id_kategori_layanan" value="" hidden>
                    <?php endif; ?>

                    <div class="form-group">
                        <label class="col-form-label font-weight-bold">Nama Barang/Jasa<span
                                style="color: red;">*</span></label>
                        <input class="form-control" name="nama_layanan" value="<?php echo e($row->nama_layanan); ?>" required>
                    </div>

                    <div class=" form-group">
                        <label class="col-form-label font-weight-bold">Status<span style="color: red;">*</span></label>

                        <select class="form-control" name="is_active" required>
                            <option value="1" <?php echo e($row->is_active == 1 ? 'selected' : ''); ?>>Digunakan</option>
                            <option value="2" <?php echo e($row->is_active == 2 ? 'selected' : ''); ?>>Tidak digunakan</option>
                        </select>
                    </div>

                </div>
                <div class="modal-footer">
                    <div class="text-right mt-3">
                        <button type="submit" class="btn btn-primary btn-sm tombolSimpanDefault">Simpan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>



<!-- MODAL KATEGORI -->
<div class="modal fade" id="activate" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-secondary">
                <span class="modal-title" id="exampleModalLabel">Kategori Barang/Jasa Survei</span>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close"></i>
                </button>
            </div>
            <div class="modal-body">
                <form
                    action="<?php echo base_url() . $ci->session->userdata('username') . '/' . $ci->uri->segment(2) . '/layanan-survei/activate' ?>"
                    method="POST" class="form_default_activate">

                    <div class="alert alert-secondary mb-5" role="alert">
                        <i class="flaticon-warning"></i> Jika Anda mengaktifkan kategori barang/jasa survei, data
                        barang/jasa survei Anda yang sudah ada akan dihapus. Silahkan mencadangkan data barang/jasa
                        survei Anda terlebih dahulu.
                    </div>
                    <div class="form-group">
                        <label class="col-form-label font-weight-bold">Kategori Barang/Jasa Survei<span
                                style="color: red;">*</span></label>
                        <span class="switch switch-icon">
                            <label>
                                <input type="checkbox" id="is_kategori_layanan_survei" name="is_kategori_layanan_survei"
                                    <?php if($profiles->is_kategori_layanan_survei == 1): ?> checked="checked" <?php endif; ?> value="1"
                                />
                                <span></span>
                            </label>
                        </span>
                    </div>
                    <input type="hidden" id="old_is_kategori_layanan_survei" name="old_is_kategori_layanan_survei"
                        value="<?php echo e($profiles->is_kategori_layanan_survei); ?>" />

                    <div class="text-right mt-3">
                        <button type="submit" class="btn btn-primary btn-sm tombolSimpanDefault">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('javascript'); ?>
<script src="<?php echo e(TEMPLATE_BACKEND_PATH); ?>plugins/custom/datatables/datatables.bundle.js"></script>
<script>
$(document).ready(function() {
    table = $('#table').DataTable({

        "processing": true,
        "serverSide": true,
        "lengthMenu": [
            [5, 10, -1],
            [5, 10, "Semua data"]
        ],
        "pageLength": 10,
        "order": [],
        "language": {
            "processing": '<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span> ',
        },
        "ajax": {
            "url": "<?php echo e(base_url() . $ci->session->userdata('username') . '/' . $ci->uri->segment(2) . '/layanan-survei/ajax-list'); ?>",
            "type": "POST",
            "data": function(data) {}
        },

        "columnDefs": [{
            "targets": [-1],
            "orderable": false,
        }, ],

    });
});
</script>


<script>
$('.form_default_activate').submit(function(e) {
    var checkBox = document.getElementById("is_kategori_layanan_survei");
    var old_checkBox = document.getElementById("old_is_kategori_layanan_survei");

    if ((old_checkBox.value != 0) && (checkBox.checked == false)) {
        // var agree = confirm("Are you sure inactivate this data?");
        var agree = confirm("Anda yakin menon-aktifkan Kategori Barang/Jasa Survei ?");
        // confirm("Are you sure inactivate this data?");
    } else {
        // var agree = confirm("Are you sure you wish to continue?");
        var agree = confirm("Dengan menekan tombol OK, berarti Anda telah memahami ketentuan !");
        // confirm("Are you sure you wish to continue?");
    }

    e.preventDefault();

    if (agree) {
        $.ajax({
            url: $(this).attr('action'),
            type: 'POST',
            dataType: 'json',
            data: $(this).serialize(),
            cache: false,
            beforeSend: function() {
                $('.tombolSimpanDefault').attr('disabled', 'disabled');
                $('.tombolSimpanDefault').html(
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
                $('.tombolSimpanDefault').removeAttr('disabled');
                $('.tombolSimpanDefault').html('Simpan');
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
                        location.href = data.url;
                    }, 1000);
                    // table.ajax.reload();
                }
            }
        })
        return true;
    } else {
        return false;
    }
});


$('.form_default').submit(function(e) {
    $.ajax({
        url: $(this).attr('action'),
        type: 'POST',
        dataType: 'json',
        data: $(this).serialize(),
        cache: false,
        beforeSend: function() {
            $('.tombolSimpanDefault').attr('disabled', 'disabled');
            $('.tombolSimpanDefault').html('<i class="fa fa-spin fa-spinner"></i> Sedang diproses');
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
            $('.tombolSimpanDefault').removeAttr('disabled');
            $('.tombolSimpanDefault').html('Simpan');
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
                }, 2000);
                table.ajax.reload();
            }
        }
    })
    return false;
});




function delete_data(id) {
    if (confirm('Are you sure delete this data?')) {
        $.ajax({
            url: "<?php echo base_url() . $ci->session->userdata('username') . '/' . $ci->uri->segment(2) . '/layanan-survei/delete/' ?>" +
                id,
            type: "POST",
            dataType: "JSON",
            success: function(data) {
                if (data.status) {

                    Swal.fire(
                        'Informasi',
                        'Berhasil menghapus data',
                        'success'
                    );

                    // window.setTimeout(function() {
                    //     location.reload()
                    // }, 2000);
                    table.ajax.reload();
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
$('.form_default_urutan').submit(function(e) {

    $.ajax({
        url: $(this).attr('action'),
        type: 'POST',
        dataType: 'json',
        data: $(this).serialize(),
        cache: false,
        beforeSend: function() {
            // $('.tombolSimpanDefault').attr('disabled', 'disabled');
            // $('.tombolSimpanDefault').html('<i class="fa fa-spin fa-spinner"></i> Sedang diproses');
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
            // $('.tombolSimpanDefault').removeAttr('disabled');
            // $('.tombolSimpanDefault').html('Simpan');
            $('.tombolSimpanUrutan').removeAttr('disabled');
            $('.tombolSimpanUrutan').html('Simpan Urutan Barang/Jasa');
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
                table.ajax.reload();
                // window.setTimeout(function() {
                //     location.reload()
                // }, 2500);
            }
        }
    })
    return false;
});
</script>



<script>
$(document).ready(function() {
    $('#tablex').on('change', '.toggle_dash_1', function() {
        // alert("TT");
        var mode = $(this).prop('checked');
        var nilai_id = $(this).val();

        $.ajax({

            type: 'POST',
            dataType: 'JSON',
            url: "<?php echo e(base_url()); ?><?php echo e($ci->session->userdata('username')); ?>/<?php echo e($ci->uri->segment(2)); ?>/is-active-layanan",
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
                    window.location.href = ("<?php echo e(base_url()); ?><?php echo e($ci->session->userdata('username')); ?>/<?php echo e($ci->uri->segment(2)); ?>/layanan-survei");
                }, 2000);

            }
        });
    });
});
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('include_backend/template_backend', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\IT\Documents\Htdocs MAMP\skp_surveiku\application\views/layanan_survei/index.blade.php ENDPATH**/ ?>