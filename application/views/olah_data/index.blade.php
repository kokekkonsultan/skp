@extends('include_backend/template_backend')

@php
$ci = get_instance();
@endphp

@section('style')
<link href="{{ TEMPLATE_BACKEND_PATH }}plugins/custom/datatables/datatables.bundle.css" rel="stylesheet"
    type="text/css" />
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
                            TABULASI DAN {{strtoupper($title)}}
                        </h3>

                        <span class="btn btn-light btn-sm font-weight-bold">
                            <i class="fa fa-bookmark"></i> <strong>{{$jumlah_kuisioner}}</strong> Kuesioner
                            Lengkap 
                        </span>
                    </div>
                </div>
            </div>

            <div class="card card-custom card-sticky" data-aos="fade-down">
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="table" class="table table-bordered table-hover" cellspacing="0" width="100%"
                            style="font-size: 12px;">
                            <thead class="bg-secondary">
                                <tr>
                                    <th width="5%">No.</th>
                                    <th>Responden</th>

                                    @foreach ($unsur->result() as $row)
                                    <th>{{$row->nomor_unsur}}</th>
                                    @endforeach

                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="card card-body mt-5" data-aos="fade-down">
                <h3>Persepsi</h3>
                <div class="table-responsive">
                    <table width="100%" class="table table-bordered" style="font-size: 12px;">
                        <tr align="center">
                            <th></th>
                            @foreach ($unsur->result() as $row)
                            <th class="bg-primary text-white">{{ $row->nomor_unsur }}</th>
                            @endforeach
                        </tr>
                        <tr>
                            <th class="bg-secondary">TOTAL</th>
                            @foreach ($total_unsur->result() as $loop1)
                            <th class="text-center">{{ ROUND($loop1->sum_skor_jawaban, 3) }}</th>
                            @endforeach
                        </tr>


                        <tr>
                            <th class="bg-secondary">Rata-Rata</th>
                            @foreach ($total_unsur->result() as $loop2)
                            <td class="text-center">{{ ROUND($loop2->rata_rata, 3) }}</td>
                            @endforeach
                        </tr>

                        <tr>
                            <th class="bg-secondary">Nilai per Unsur</th>
                            @foreach ($nilai_per_unsur->result() as $loop3)
                            @php
                            $nilai_bobot[] = $loop3->rata_rata;
                            $nilai_tertimbang = array_sum($nilai_bobot) / count($nilai_bobot);
                            $ikm = ROUND($nilai_tertimbang * $skala_likert, 10);
                            @endphp
                            <th colspan="{{ $loop3->colspan }}" class="text-center">
                                {{ ROUND($loop3->rata_rata, 3) }}
                            </th>
                            @endforeach
                        </tr>

                        <tr>
                            <th class="bg-secondary">Rata-Rata * Bobot</th>
                            @foreach ($nilai_per_unsur->result() as $loop4)
                            <td colspan="{{ $loop4->colspan }}" class="text-center">
                                {{ ROUND($loop4->rata_rata_x_bobot, 3) }}
                            </td>
                            @endforeach
                        </tr>

                        <tr>
                            <th class="bg-secondary">Nilai Rata2 Tertimbang</th>
                            <td colspan="{{ $unsur->num_rows() }}">{{ ROUND($nilai_tertimbang, 3) }}</td>
                        </tr>
                        <tr>
                            <th class="bg-secondary">IKP</th>
                            <th colspan="{{ $unsur->num_rows() }}">{{ROUND($ikm, 2)}}</th>
                        </tr>


                        <?php
                        foreach ($definisi_skala->result() as $obj) {
                            if ($ikm <= $obj->range_bawah && $ikm >= $obj->range_atas) {
                                $kategori = $obj->kategori;
                                $mutu = $obj->mutu;
                            }
                        }
                        if ($ikm <= 0) {
                            $kategori = 'NULL';
                            $mutu = 'NULL';
                        }
                        ?>

                        <tr>
                            <th class="bg-secondary">MUTU PELAYANAN</th>
                            <th colspan="{{ $unsur->num_rows() }}">{{$mutu}}</th>
                        </tr>

                        <tr>
                            <th class="bg-secondary">KATEGORI</th>
                            <th colspan="{{ $unsur->num_rows() }}">{{$kategori}}</th>
                        </tr>
                    </table>
                </div>
            </div>



            @if(in_array(1, $atribut_pertanyaan))
            <div class="card card-body mt-5" data-aos="fade-down">
                <h3>Harapan</h3>
                <div class="table-responsive">
                    <table width="100%" class="table table-bordered" style="font-size: 12px;">
                        <tr align="center">
                            <th></th>
                            @foreach ($unsur->result() as $row)
                            <th class="bg-primary text-white">H{{ $row->nomor_harapan }}</th>
                            @endforeach
                        </tr>

                        <tr>
                            <td class="bg-secondary"><strong>TOTAL</strong></td>
                            @foreach ($total_harapan->result() as $loop5)
                            <th class="text-center">{{ ROUND($loop5->sum_skor_jawaban, 3) }}</th>
                            @endforeach
                        </tr>

                        <tr>
                            <th class="bg-secondary">Rata-Rata</th>
                            @foreach ($total_harapan->result() as $loop6)
                            <th class="text-center">{{ ROUND($loop6->rata_rata, 3) }}</th>
                            @endforeach
                        </tr>

                        <tr>
                            <td class="bg-secondary"><strong>Rata-Rata per Harapan</strong>
                            </td>
                            @foreach ($nilai_per_unsur_harapan->result() as $loop7)
                            <td class="text-center" colspan="{{ $loop7->colspan }}">
                                {{ ROUND($loop7->rata_rata, 3) }}
                            </td>
                            @endforeach
                        </tr>

                    </table>
                </div>
            </div>
            @endif


        </div>
    </div>

</div>
</div>

</div>

@endsection

@section('javascript')
<script src="{{ TEMPLATE_BACKEND_PATH }}plugins/custom/datatables/datatables.bundle.js"></script>
<script>
$(document).ready(function() {
    table = $('#table').DataTable({

        "processing": true,
        "serverSide": true,
        // paging: true,
        //     dom: 'Blfrtip',
        //     "buttons": [
        //         {
        //             extend: 'collection',
        //             text: 'Export',
        //             buttons: [
        //                 'excel'
        //             ]
        //         }
        //     ],

        "lengthMenu": [
            [5, 10, 25, 50, 100, -1],
            [5, 10, 25, 50, 100, "Semua data"]
        ],
        "pageLength": 5,
        "order": [],
        "language": {
            "processing": '<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span> ',
        },
        "ajax": {
            "url": "<?php echo base_url() . $ci->session->userdata('username') . '/' . $ci->uri->segment(2) . '/olah-data/ajax-list' ?>",
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
</script>
@endsection