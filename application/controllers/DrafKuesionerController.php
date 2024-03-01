<?php
defined('BASEPATH') or exit('No direct script access allowed');

class DrafKuesionerController extends Client_Controller
{

    public function __construct()
    {
        parent::__construct();

        $this->load->library('Pdf');
    }


    public function index($id1, $id2)
    {

        $this->data = [];
        $this->data['title'] = 'Detail Pertanyaan Unsur';
        $this->data['profiles'] = Client_Controller::_get_data_profile($id1, $id2);

        // get tabel identity
        $this->db->select('*, manage_survey.id AS id_manage_survey');
        $this->db->from('manage_survey');
        $this->db->where('manage_survey.slug', $this->uri->segment(2));
        $this->data['manage_survey'] = $this->db->get()->row();
        $table_identity = $this->data['manage_survey']->table_identity;

        $this->db->select('*');
        $this->db->from('users');
        $this->db->where('id=' . $this->data['manage_survey']->id_user);
        $this->data['user'] = $this->db->get()->row();

        $this->data['profil_responden'] = $this->db->query("SELECT *,  REPLACE(LOWER(nama_profil_responden), ' ', '_') AS nama_alias, (SELECT COUNT(id) FROM kategori_profil_responden_$table_identity WHERE id_profil_responden = profil_responden_$table_identity.id) AS total_kategori FROM profil_responden_$table_identity")->result();

        //PERTANYAAN UNSUR
        $this->data['pertanyaan_unsur'] = $this->db->query("SELECT *, (SELECT nama_kategori_unsur_pelayanan FROM kategori_unsur_pelayanan_$table_identity WHERE id_pertanyaan_unsur = pertanyaan_unsur_pelayanan_$table_identity.id && nomor_kategori_unsur_pelayanan = 1 ) AS pilihan_1,
        (SELECT nama_kategori_unsur_pelayanan FROM kategori_unsur_pelayanan_$table_identity WHERE id_pertanyaan_unsur = pertanyaan_unsur_pelayanan_$table_identity.id && nomor_kategori_unsur_pelayanan = 2 ) AS pilihan_2,
        (SELECT nama_kategori_unsur_pelayanan FROM kategori_unsur_pelayanan_$table_identity WHERE id_pertanyaan_unsur = pertanyaan_unsur_pelayanan_$table_identity.id && nomor_kategori_unsur_pelayanan = 3 ) AS pilihan_3,
        (SELECT nama_kategori_unsur_pelayanan FROM kategori_unsur_pelayanan_$table_identity WHERE id_pertanyaan_unsur = pertanyaan_unsur_pelayanan_$table_identity.id && nomor_kategori_unsur_pelayanan = 4 ) AS pilihan_4
        FROM pertanyaan_unsur_pelayanan_$table_identity
        JOIN unsur_pelayanan_$table_identity ON pertanyaan_unsur_pelayanan_$table_identity.id_unsur_pelayanan = unsur_pelayanan_$table_identity.id");


        //PERTANYAAN HARAPAN
        $this->data['pertanyaan_harapan'] = $this->db->query("SELECT *, (SELECT nama_tingkat_kepentingan FROM nilai_tingkat_kepentingan_$table_identity WHERE id_pertanyaan_unsur_pelayanan = pertanyaan_unsur_pelayanan_$table_identity.id && nomor_tingkat_kepentingan = 1 ) AS pilihan_1,
        (SELECT nama_tingkat_kepentingan FROM nilai_tingkat_kepentingan_$table_identity WHERE id_pertanyaan_unsur_pelayanan = pertanyaan_unsur_pelayanan_$table_identity.id && nomor_tingkat_kepentingan = 2 ) AS pilihan_2,
        (SELECT nama_tingkat_kepentingan FROM nilai_tingkat_kepentingan_$table_identity WHERE id_pertanyaan_unsur_pelayanan = pertanyaan_unsur_pelayanan_$table_identity.id && nomor_tingkat_kepentingan = 3 ) AS pilihan_3,
        (SELECT nama_tingkat_kepentingan FROM nilai_tingkat_kepentingan_$table_identity WHERE id_pertanyaan_unsur_pelayanan = pertanyaan_unsur_pelayanan_$table_identity.id && nomor_tingkat_kepentingan = 4 ) AS pilihan_4, (SELECT nomor_unsur FROM unsur_pelayanan_$table_identity WHERE id_unsur_pelayanan = unsur_pelayanan_$table_identity.id) AS nomor_unsur
        FROM pertanyaan_unsur_pelayanan_$table_identity");


        //PERTANYAAN KUALITATIF
        $this->data['pertanyaan_kualitatif'] = $this->db->get_where("pertanyaan_kualitatif_$table_identity", array('is_active' => 1));

        if ($this->data['pertanyaan_unsur']->num_rows() > 0) {

            $this->load->library('pdfgenerator');
            $this->data['title_pdf'] = 'Draf Kuesioner';
            $file_pdf = 'Draf Kuesioner';

            $paper = 'A4';
            $orientation = "potrait";

            $html = $this->load->view('draf_kuesioner/cetak', $this->data, true);
            $this->pdfgenerator->generate($html, $file_pdf, $paper, $orientation);

            // $this->load->view('draf_kuesioner/cetak', $this->data);
        } else {
            $this->data['pesan'] = 'Pertanyaan Belum di Isi !';
            return view('not_questions/index', $this->data);
            exit();
        }
    }



    public function tcpdf()
    {
        //START QUERY
        $this->db->select('*');
        $this->db->from('manage_survey');
        $this->db->where('manage_survey.slug', $this->uri->segment(2));
        $manage_survey = $this->db->get()->row();
        $table_identity = $manage_survey->table_identity;
        $skala_likert = $manage_survey->skala_likert == 5 ? 5 : 4;

        $this->db->select('*');
        $this->db->from('users');
        $this->db->where('id', $manage_survey->id_user);
        $user = $this->db->get()->row();



        //============================================= START NEW PDF BY TCPDF =============================================
        $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('Hanif');
        $pdf->SetTitle('Draf Kuesioner ' . $manage_survey->survey_name);
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
        $pdf->SetPrintHeader(false);
        $pdf->SetPrintFooter(false);
        // $pdf->SetFont('dejavusans', '', 10);
        $pdf->AddPage('P', 'A4');





        //========================================  USER PROFIL =============================================
        if ($user->foto_profile == NULL) {
            $profil = '<img src="' . URL_AUTH . 'assets/klien/foto_profile/200px.jpg" height="75" alt="">';
        } else {
            $profil = '<img src="' . URL_AUTH . 'assets/klien/foto_profile/' . $user->foto_profile . '" height="75" alt="">';
        };

        $title_header = unserialize($manage_survey->title_header_survey);
        $title_1 = $title_header[0];
        $title_2 = $title_header[1];



        //========================================  PROFIL RESPONDEN =============================================
        $profil_responden = $this->db->query("SELECT *,  REPLACE(LOWER(nama_profil_responden), ' ', '_') AS nama_alias FROM profil_responden_$table_identity ORDER BY IF(urutan != '',urutan,id) ASC")->result();
        $nama_profil = [];
        foreach ($profil_responden as $get_profil) {
            
            if ((isset($get_profil->posisi_label_isian)) && ($get_profil->posisi_label_isian == 1)) {
                $label_kiri = $get_profil->label_isian . ' ';
            } else {
                $label_kiri = '';
            }
            if ((isset($get_profil->posisi_label_isian)) && ($get_profil->posisi_label_isian == 2)) {
                $label_kanan = ' ' . $get_profil->label_isian;
            } else {
                $label_kanan = '';
            }

            if ($get_profil->jenis_isian == 1) {
                $kategori = [];
                foreach ($this->db->get_where("kategori_profil_responden_$table_identity", array('id_profil_responden' => $get_profil->id))->result() as $value) {
                    $kategori[] = '<li>' . $value->nama_kategori_profil_responden . '</li>';
                }
                $get_kategori = implode("", $kategori);
            } else {
                $get_kategori = '';
            };
            
            if ((!isset($get_profil->id_profil)) || ($get_profil->id_profil == 0)) {
                $namaalias = $get_profil->nama_profil_responden;
            }else{
                $namaalias = '&nbsp;';
            }

            $nama_profil[] = '<tr style="font-size: 11px;"><td width="30%" style="height:15px;" valign="top">' . $namaalias . ' </td><td width="70%">';
            $nama_profil[] = '<ul style="list-style-type:img|png|3|3|' . base_url() . 'assets/img/site/vector/check.png">';
            $nama_profil[] = $label_kiri . $get_kategori . $label_kanan;
            $nama_profil[] = '</ul>';
            $nama_profil[] = '</td></tr>';
        }
        $get_nama = implode("", $nama_profil);



        //CEK MENGGUNAKAN JENIS LAYANAN ATAU TIDAK
        if ($manage_survey->is_layanan_survei != 0) {
            $nama_layanan = [];
                foreach ($this->db->get_where("layanan_survei_$table_identity", array('is_active' => 1))->result() as $row) {
                    $nama_layanan[] = '<li>' . $row->nama_layanan . '</li>';
                }
                $get_layanan = '<ul style="list-style-type:img|png|3|3|' . base_url() . 'assets/img/site/vector/check.png">' . implode("", $nama_layanan) . '</ul>';


            $layanan_survei = '<tr style="font-size: 11px;">
            <td width=" 30%" style="height:15px;">Jenis Pelayanan yang diterima</td>
            <td width="70%">' . $get_layanan . '</td>
            </tr>';
        } else {
            $layanan_survei = '';
        }






        //CEK SKALA TERLEBIH DAHULU SEBELUM MEMBUAT JUDUL TABEL
        if ($skala_likert == 5) {
            $thead_tabel_unsur = '<table width="100%" style="font-size: 11px; text-align:center; background-color:#C7C6C1" border="1" cellpadding="3">
            <tr>
                <td rowspan="2" width="5%">No</td>
                <td rowspan="2" width="32%">PERTANYAAN</td>
                <td colspan="5" width="40%">PILIHAN JAWABAN</td>
                <td rowspan="2" width="23%">Berikan alasan jika pilihan jawaban: 1 atau 2
                </td>
            </tr>
            <tr>
                <td>1</td>
                <td>2</td>
                <td>3</td>
                <td>4</td>
                <td>5</td>
            </tr>
        </table>';

            $thead_tabel_harapan = '<table width="100%" style="font-size: 11px; text-align:center; background-color:#C7C6C1" border="1" cellpadding="3">
            <tr>
                <td rowspan="2" width="5%">No</td>
                <td rowspan="2" width="32%">PERTANYAAN</td>
                <td colspan="5" width="63%">PILIHAN JAWABAN</td>
            </tr>
            <tr>
                <td>1</td>
                <td>2</td>
                <td>3</td>
                <td>4</td>
                <td>5</td>
            </tr>
        </table>';
        } else {

            $thead_tabel_unsur = '<table width="100%" style="font-size: 11px; text-align:center; background-color:#C7C6C1" border="1" cellpadding="3">
            <tr>
                <td rowspan="2" width="5%">No</td>
                <td rowspan="2" width="32%">PERTANYAAN</td>
                <td colspan="4" width="40%">PILIHAN JAWABAN</td>
                <td rowspan="2" width="23%">Berikan alasan jika pilihan jawaban: 1 atau 2
                </td>
            </tr>
            <tr>
                <td>1</td>
                <td>2</td>
                <td>3</td>
                <td>4</td>
            </tr>
        </table>';

            $thead_tabel_harapan = '<table width="100%" style="font-size: 11px; text-align:center; background-color:#C7C6C1" border="1" cellpadding="3">
            <tr>
                <td rowspan="2" width="5%">No</td>
                <td rowspan="2" width="32%">PERTANYAAN</td>
                <td colspan="4" width="63%">PILIHAN JAWABAN</td>
            </tr>
            <tr>
                <td>1</td>
                <td>2</td>
                <td>3</td>
                <td>4</td>
            </tr>
        </table>';
        }





        //=================================== PERTANYAAN TERBUKA ATAS ==========================================
        if (in_array(2, unserialize($manage_survey->atribut_pertanyaan_survey))) {

            $pertanyaan_terbuka_atas = $this->db->query("SELECT *, perincian_pertanyaan_terbuka_$table_identity.id AS id_perincian_pertanyaan_terbuka, (SELECT DISTINCT(dengan_isian_lainnya) FROM isi_pertanyaan_ganda_$table_identity WHERE isi_pertanyaan_ganda_$table_identity.id_perincian_pertanyaan_terbuka = perincian_pertanyaan_terbuka_$table_identity.id) AS dengan_isian_lainnya
            FROM pertanyaan_terbuka_$table_identity
            JOIN perincian_pertanyaan_terbuka_$table_identity ON pertanyaan_terbuka_$table_identity.id = perincian_pertanyaan_terbuka_$table_identity.id_pertanyaan_terbuka
            WHERE pertanyaan_terbuka_$table_identity.is_letak_pertanyaan = 1
            ORDER BY SUBSTR(nomor_pertanyaan_terbuka,2) + 0");

            if ($pertanyaan_terbuka_atas->num_rows() > 0) {

                $per_terbuka_atas = [];
                foreach ($pertanyaan_terbuka_atas->result() as $value) {

                    if ($value->gambar_pertanyaan_terbuka){ 
                        $gambar_pertanyaan_terbuka = '<div style="padding-bottom: 0px; "><img src="'.base_url().'assets/img/site/pertanyaan/'.$value->gambar_pertanyaan_terbuka.'" alt=""
                            style="max-width: 100%;"></div>';
                    }else{
                        $gambar_pertanyaan_terbuka = '';
                    }

                    if ($value->id_jenis_pilihan_jawaban == 2) {

                        $per_terbuka_atas[] = '
                    <table width="100%" style="font-size: 11px;" border="1" cellpadding="3">
                        <tr>
                            <td width="5%" style="text-align:center; font-size: 11px;">' . $value->nomor_pertanyaan_terbuka . '</td>
                            <td width="32%" style="text-align:left; font-size: 11px;">' . $gambar_pertanyaan_terbuka . $value->isi_pertanyaan_terbuka . '</td>
                            <td width="40%"></td>
                            <td width="23%" style="text-align:left; font-size: 11px;"></td>
                        </tr>
                    </table>';
                    } else {

                        $pilihan_terbuka_atas = [];
                        foreach ($this->db->get_where("isi_pertanyaan_ganda_$table_identity", array('id_perincian_pertanyaan_terbuka' => $value->id_perincian_pertanyaan_terbuka))->result() as $get) {

                            $pilihan_terbuka_atas[] = '<tr>
                        <td width="4%"></td>
                        <td width="36%" style="background-color:#C7C6C1;">' . $get->pertanyaan_ganda . '</td>
                        </tr>';
                        }


                        $get_pilihan_terbuka_atas = implode("", $pilihan_terbuka_atas);
                        $isi_terbuka_atas[$value->nomor_pertanyaan_terbuka] = $this->db->get_where("isi_pertanyaan_ganda_$table_identity", array('id_perincian_pertanyaan_terbuka' => $value->id_perincian_pertanyaan_terbuka))->num_rows() + 1;


                        $per_terbuka_atas[] = '
                        <table width="100%" style="font-size: 11px;" border="1" cellpadding="3">
                            <tr>
                                <td rowspan="' . $isi_terbuka_atas[$value->nomor_pertanyaan_terbuka] . '" width="5%" style="text-align:center; font-size: 11px;">' . $value->nomor_pertanyaan_terbuka . '</td>

                                <td width="32%" rowspan="' . $isi_terbuka_atas[$value->nomor_pertanyaan_terbuka] . '" style="text-align:left; font-size: 11px;">' . $gambar_pertanyaan_terbuka . $value->isi_pertanyaan_terbuka . '</td>

                                <td colspan="2" width="40%"></td>
                                        
                                <td width="23%"rowspan="' . $isi_terbuka_atas[$value->nomor_pertanyaan_terbuka] . '" style="text-align:left; font-size: 11px;"></td>
                            </tr>' . $get_pilihan_terbuka_atas . '
                    </table>';
                    }
                }
                $get_pertanyaan_terbuka_atas = implode("", $per_terbuka_atas);
            } else {
                $get_pertanyaan_terbuka_atas = '';
            }
        } else {
            $get_pertanyaan_terbuka_atas = '';
        };




        //============================================= PERTANYAAN UNSUR =============================================
        //JIKA MENGGUNAKAN DIMENSI MAKA PROSES INI
        if ($manage_survey->is_dimensi == 1) {


            $dimensi = $this->db->query("SELECT *
            FROM (SELECT *, (SELECT COUNT(id) FROM unsur_pelayanan_$table_identity WHERE dimensi_$table_identity.id = unsur_pelayanan_$table_identity.id_dimensi) AS jumlah FROM dimensi_$table_identity) dms_$table_identity
            WHERE jumlah > 0
            ORDER BY id ASC");

            $per_dimensi = [];
            foreach ($dimensi->result() as $dms) {


                $pertanyaan_unsur = $this->db->query("SELECT *, (SELECT nama_kategori_unsur_pelayanan FROM kategori_unsur_pelayanan_$table_identity WHERE id_pertanyaan_unsur = pertanyaan_unsur_pelayanan_$table_identity.id && nomor_kategori_unsur_pelayanan = 1 ) AS pilihan_1,
                (SELECT nama_kategori_unsur_pelayanan FROM kategori_unsur_pelayanan_$table_identity WHERE id_pertanyaan_unsur = pertanyaan_unsur_pelayanan_$table_identity.id && nomor_kategori_unsur_pelayanan = 2 ) AS pilihan_2,
                (SELECT nama_kategori_unsur_pelayanan FROM kategori_unsur_pelayanan_$table_identity WHERE id_pertanyaan_unsur = pertanyaan_unsur_pelayanan_$table_identity.id && nomor_kategori_unsur_pelayanan = 3 ) AS pilihan_3,
                (SELECT nama_kategori_unsur_pelayanan FROM kategori_unsur_pelayanan_$table_identity WHERE id_pertanyaan_unsur = pertanyaan_unsur_pelayanan_$table_identity.id && nomor_kategori_unsur_pelayanan = 4 ) AS pilihan_4,
                (SELECT nama_kategori_unsur_pelayanan FROM kategori_unsur_pelayanan_$table_identity WHERE id_pertanyaan_unsur = pertanyaan_unsur_pelayanan_$table_identity.id && nomor_kategori_unsur_pelayanan = 5 ) AS pilihan_5
                FROM pertanyaan_unsur_pelayanan_$table_identity
                JOIN unsur_pelayanan_$table_identity ON pertanyaan_unsur_pelayanan_$table_identity.id_unsur_pelayanan = unsur_pelayanan_$table_identity.id
                WHERE unsur_pelayanan_$table_identity.id_dimensi = $dms->id
                ORDER BY SUBSTR(nomor_unsur,2) + 0");

                $per_unsur = [];
                foreach ($pertanyaan_unsur->result() as $row) {


                    if (in_array(2, unserialize($manage_survey->atribut_pertanyaan_survey))) {

                        $pertanyaan_terbuka = $this->db->query("SELECT *, perincian_pertanyaan_terbuka_$table_identity.id AS id_perincian_pertanyaan_terbuka, (SELECT DISTINCT(dengan_isian_lainnya) FROM isi_pertanyaan_ganda_$table_identity WHERE isi_pertanyaan_ganda_$table_identity.id_perincian_pertanyaan_terbuka = perincian_pertanyaan_terbuka_$table_identity.id) AS dengan_isian_lainnya
                        FROM pertanyaan_terbuka_$table_identity
                        JOIN perincian_pertanyaan_terbuka_$table_identity ON pertanyaan_terbuka_$table_identity.id = perincian_pertanyaan_terbuka_$table_identity.id_pertanyaan_terbuka
                        WHERE  id_unsur_pelayanan = $row->id_unsur_pelayanan
                        ORDER BY SUBSTR(nomor_pertanyaan_terbuka,2) + 0");

                        $per_terbuka = [];
                        foreach ($pertanyaan_terbuka->result() as $value) {


                            if ($value->id_jenis_pilihan_jawaban == 2) {

                                $per_terbuka[] = '
                                <table width="100%" style="font-size: 11px;" border="1" cellpadding="3">
                                    <tr>
                                        <td width="5%" style="text-align:center; font-size: 11px;">' . $value->nomor_pertanyaan_terbuka . '</td>
                                        <td width="32%" style="text-align:left; font-size: 11px;">' . $value->isi_pertanyaan_terbuka . '</td>
                                        <td width="40%"></td>
                                        <td width="23%" style="text-align:left; font-size: 11px;"></td>
                                    </tr>
                                </table>';

                            } else {

                                $pilihan_terbuka = [];
                                foreach ($this->db->get_where("isi_pertanyaan_ganda_$table_identity", array('id_perincian_pertanyaan_terbuka' => $value->id_perincian_pertanyaan_terbuka))->result() as $get) {

                                    $pilihan_terbuka[] = '<tr>
                                <td width="4%"></td>
                                <td width="36%" style="background-color:#C7C6C1;">' . $get->pertanyaan_ganda . '</td>
                                </tr>';
                                }


                                $get_pilihan_terbuka = implode("", $pilihan_terbuka);
                                $isi[$value->nomor_pertanyaan_terbuka] = $this->db->get_where("isi_pertanyaan_ganda_$table_identity", array('id_perincian_pertanyaan_terbuka' => $value->id_perincian_pertanyaan_terbuka))->num_rows() + 1;


                                $per_terbuka[] = '
                                <table width="100%" style="font-size: 11px;" border="1" cellpadding="3">
                                    <tr>
                                        <td rowspan="' . $isi[$value->nomor_pertanyaan_terbuka] . '" width="5%" style="text-align:center; font-size: 11px;">' . $value->nomor_pertanyaan_terbuka . '</td>

                                        <td width="32%" rowspan="' . $isi[$value->nomor_pertanyaan_terbuka] . '" style="text-align:left; font-size: 11px;">' . $value->isi_pertanyaan_terbuka . '</td>

                                        <td colspan="2" width="40%"></td>
                                        
                                        <td width="23%"rowspan="' . $isi[$value->nomor_pertanyaan_terbuka] . '" style="text-align:left; font-size: 11px;"></td>
                                    </tr>' . $get_pilihan_terbuka . '
                                </table>';
                            }
                        }
                        $get_pertanyaan_terbuka = implode("", $per_terbuka);
                    } else {
                        $get_pertanyaan_terbuka = '';
                    }



                    //CEK SKALA TERLEBIH DAHULU
                    if ($skala_likert == 5) {
                        $pilihan_ke_2 = $row->pilihan_5;
                        $width = 8;
                        $pilihan_ke_5 = '<td width="8%" style="background-color:#C7C6C1; text-align:center; font-size: 11px;">' . $row->pilihan_5 . '</td>';
                        $ke_5 = '<th></th>';
                    } else {
                        $pilihan_ke_2 = $row->pilihan_4;
                        $width = 10;
                        $pilihan_ke_5 = '';
                        $ke_5 = '';
                    }


                    if ($row->jenis_pilihan_jawaban == 1) {

                        $per_unsur[] = '
                        <table width="100%" border="1" cellpadding="4">
                            <tr>
                                <td rowspan="2" width="5%" style="text-align:center; font-size: 11px;">' . $row->nomor_unsur . '</td>
                                <td width="32%" rowspan="2" style="text-align:left; font-size: 11px;">' . $row->isi_pertanyaan_unsur . '</td>
                                <td width="20%" style="background-color:#C7C6C1; text-align:center; font-size: 11px;">' . $row->pilihan_1 . '</td>
                                <td width="20%" style="background-color:#C7C6C1; text-align:center; font-size: 11px;">' . $pilihan_ke_2 . '</td>
                                <td width="23%" rowspan="2" style="text-align:left; font-size: 11px;"></td>
                            </tr>

                            <tr>
                                <th></th>
                                <th></th>
                            </tr>
                        </table>
                    ' . $get_pertanyaan_terbuka;
                    } else {


                        $per_unsur[] = '
                        <table width="100%" border="1" cellpadding="4">
                            <tr>
                                <td rowspan="2" width="5%" style="text-align:center; font-size: 11px;">' . $row->nomor_unsur . '</td>
                                <td width="32%" rowspan="2" style="text-align:left; font-size: 11px;">' . $row->isi_pertanyaan_unsur . '</td>
                                <td width="' . $width . '%" style="background-color:#C7C6C1; text-align:center; font-size: 11px;">' . $row->pilihan_1 . '</td>
                                <td width="' . $width . '%" style="background-color:#C7C6C1; text-align:center; font-size: 11px;">' . $row->pilihan_2 . '</td>
                                <td width="' . $width . '%" style="background-color:#C7C6C1; text-align:center; font-size: 11px;">' . $row->pilihan_3 . '</td>
                                <td width="' . $width . '%" style="background-color:#C7C6C1; text-align:center; font-size: 11px;">' . $row->pilihan_4 . '</td>' . $pilihan_ke_5 . '
                                <td width="23%" rowspan="2" style="text-align:left; font-size: 11px;"></td>
                            </tr>

                            <tr>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>'
                                    . $ke_5 .
                                    '</tr>
                        </table>
                        ' . $get_pertanyaan_terbuka;
                    }
                }
                $get_pertanyaan_unsur = implode("", $per_unsur);

                $keterangan = $dms->keterangan != '' ? '<br>' . $dms->keterangan : '';
                $per_dimensi[] = '
                    <table width="100%" style="font-size: 11px;" border="1" cellpadding="3">
                            <tr>
                                <td><b>' . $dms->dimensi . '</b>' . $keterangan . '</td>
                            </tr>
                    </table>
                    ' . $get_pertanyaan_unsur;
            }
            $get_dimensi = implode("", $per_dimensi);



            //JIKA TIDAK MAKA PROSES INI
        } else {


            $pertanyaan_unsur = $this->db->query("SELECT *, (SELECT nama_kategori_unsur_pelayanan FROM kategori_unsur_pelayanan_$table_identity WHERE id_pertanyaan_unsur = pertanyaan_unsur_pelayanan_$table_identity.id && nomor_kategori_unsur_pelayanan = 1 ) AS pilihan_1,
            (SELECT nama_kategori_unsur_pelayanan FROM kategori_unsur_pelayanan_$table_identity WHERE id_pertanyaan_unsur = pertanyaan_unsur_pelayanan_$table_identity.id && nomor_kategori_unsur_pelayanan = 2 ) AS pilihan_2,
            (SELECT nama_kategori_unsur_pelayanan FROM kategori_unsur_pelayanan_$table_identity WHERE id_pertanyaan_unsur = pertanyaan_unsur_pelayanan_$table_identity.id && nomor_kategori_unsur_pelayanan = 3 ) AS pilihan_3,
            (SELECT nama_kategori_unsur_pelayanan FROM kategori_unsur_pelayanan_$table_identity WHERE id_pertanyaan_unsur = pertanyaan_unsur_pelayanan_$table_identity.id && nomor_kategori_unsur_pelayanan = 4 ) AS pilihan_4,
            (SELECT nama_kategori_unsur_pelayanan FROM kategori_unsur_pelayanan_$table_identity WHERE id_pertanyaan_unsur = pertanyaan_unsur_pelayanan_$table_identity.id && nomor_kategori_unsur_pelayanan = 5 ) AS pilihan_5
            FROM pertanyaan_unsur_pelayanan_$table_identity
            JOIN unsur_pelayanan_$table_identity ON pertanyaan_unsur_pelayanan_$table_identity.id_unsur_pelayanan = unsur_pelayanan_$table_identity.id
            ORDER BY SUBSTR(nomor_unsur,2) + 0");

            $per_unsur = [];
            foreach ($pertanyaan_unsur->result() as $row) {


                if (in_array(2, unserialize($manage_survey->atribut_pertanyaan_survey))) {

                    $pertanyaan_terbuka = $this->db->query("SELECT *, perincian_pertanyaan_terbuka_$table_identity.id AS id_perincian_pertanyaan_terbuka, (SELECT DISTINCT(dengan_isian_lainnya) FROM isi_pertanyaan_ganda_$table_identity WHERE isi_pertanyaan_ganda_$table_identity.id_perincian_pertanyaan_terbuka = perincian_pertanyaan_terbuka_$table_identity.id) AS dengan_isian_lainnya
                    FROM pertanyaan_terbuka_$table_identity
                    JOIN perincian_pertanyaan_terbuka_$table_identity ON pertanyaan_terbuka_$table_identity.id = perincian_pertanyaan_terbuka_$table_identity.id_pertanyaan_terbuka
                    WHERE  id_unsur_pelayanan = $row->id_unsur_pelayanan
                    ORDER BY SUBSTR(nomor_pertanyaan_terbuka,2) + 0");

                    $per_terbuka = [];
                    foreach ($pertanyaan_terbuka->result() as $value) {


                        if ($value->id_jenis_pilihan_jawaban == 2) {

                            $per_terbuka[] = '
                            <table width="100%" style="font-size: 11px;" border="1" cellpadding="3">
                                <tr>
                                    <td width="5%" style="text-align:center; font-size: 11px;">' . $value->nomor_pertanyaan_terbuka . '</td>
                                    <td width="32%" style="text-align:left; font-size: 11px;">' . $value->isi_pertanyaan_terbuka . '</td>
                                    <td width="40%"></td>
                                    <td width="23%" style="text-align:left; font-size: 11px;"></td>
                                </tr>
                            </table>
                        ';
                        } else {

                            $pilihan_terbuka = [];
                            foreach ($this->db->get_where("isi_pertanyaan_ganda_$table_identity", array('id_perincian_pertanyaan_terbuka' => $value->id_perincian_pertanyaan_terbuka))->result() as $get) {

                                $pilihan_terbuka[] = '<tr>
                                <td width="4%"></td>
                                <td width="36%" style="background-color:#C7C6C1;">' . $get->pertanyaan_ganda . '</td>
                                </tr>';
                            }

                            $get_pilihan_terbuka = implode("", $pilihan_terbuka);
                            $isi[$value->nomor_pertanyaan_terbuka] = $this->db->get_where("isi_pertanyaan_ganda_$table_identity", array('id_perincian_pertanyaan_terbuka' => $value->id_perincian_pertanyaan_terbuka))->num_rows() + 1;



                            $per_terbuka[] = '
                            <table width="100%" style="font-size: 11px;" border="1" cellpadding="3">
                                <tr>
                                    <td rowspan="' . $isi[$value->nomor_pertanyaan_terbuka] . '" width="5%" style="text-align:center; font-size: 11px;">' . $value->nomor_pertanyaan_terbuka . '</td>

                                    <td width="32%" rowspan="' . $isi[$value->nomor_pertanyaan_terbuka] . '" style="text-align:left; font-size: 11px;">' . $value->isi_pertanyaan_terbuka . '</td>

                                    <td colspan="2" width="40%"></td>
                                    
                                    <td width="23%"rowspan="' . $isi[$value->nomor_pertanyaan_terbuka] . '" style="text-align:left; font-size: 11px;"></td>
                                </tr>' . $get_pilihan_terbuka . '
                            </table>
                        ';
                        }
                    }
                    $get_pertanyaan_terbuka = implode("", $per_terbuka);
                } else {
                    $get_pertanyaan_terbuka = '';
                }



                //CEK SKALA TERLEBIH DAHULU
                if ($skala_likert == 5) {
                    $pilihan_ke_2 = $row->pilihan_5;
                    $width = 8;
                    $pilihan_ke_5 = '<td width="8%" style="background-color:#C7C6C1; text-align:center; font-size: 11px;">' . $row->pilihan_5 . '</td>';
                    $ke_5 = '<th></th>';
                } else {
                    $pilihan_ke_2 = $row->pilihan_4;
                    $width = 10;
                    $pilihan_ke_5 = '';
                    $ke_5 = '';
                }


                if ($row->jenis_pilihan_jawaban == 1) {

                    $per_unsur[] = '
                    <table width="100%" border="1" cellpadding="4">
                        <tr>
                            <td rowspan="2" width="5%" style="text-align:center; font-size: 11px;">' . $row->nomor_unsur . '</td>
                            <td width="32%" rowspan="2" style="text-align:left; font-size: 11px;">' . $row->isi_pertanyaan_unsur . '</td>
                            <td width="20%" style="background-color:#C7C6C1; text-align:center; font-size: 11px;">' . $row->pilihan_1 . '</td>
                            <td width="20%" style="background-color:#C7C6C1; text-align:center; font-size: 11px;">' . $pilihan_ke_2 . '</td>
                            <td width="23%" rowspan="2" style="text-align:left; font-size: 11px;"></td>
                        </tr>

                        <tr>
                            <th></th>
                            <th></th>
                        </tr>
                    </table>
                ' . $get_pertanyaan_terbuka;
                } else {


                    $per_unsur[] = '
                        <table width="100%" border="1" cellpadding="4">
                            <tr>
                                <td rowspan="2" width="5%" style="text-align:center; font-size: 11px;">' . $row->nomor_unsur . '</td>
                                <td width="32%" rowspan="2" style="text-align:left; font-size: 11px;">' . $row->isi_pertanyaan_unsur . '</td>
                                <td width="' . $width . '%" style="background-color:#C7C6C1; text-align:center; font-size: 11px;">' . $row->pilihan_1 . '</td>
                                <td width="' . $width . '%" style="background-color:#C7C6C1; text-align:center; font-size: 11px;">' . $row->pilihan_2 . '</td>
                                <td width="' . $width . '%" style="background-color:#C7C6C1; text-align:center; font-size: 11px;">' . $row->pilihan_3 . '</td>
                                <td width="' . $width . '%" style="background-color:#C7C6C1; text-align:center; font-size: 11px;">' . $row->pilihan_4 . '</td>' . $pilihan_ke_5 . '
                                <td width="23%" rowspan="2" style="text-align:left; font-size: 11px;"></td>
                            </tr>

                            <tr>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>'
                                . $ke_5 .
                                '</tr>
                        </table>
                ' . $get_pertanyaan_terbuka;
                }
            }
            $get_dimensi = implode("", $per_unsur);
        }





        //============================================= PERTANYAAN TERBUKA BAWAH =========================================
        if (in_array(2, unserialize($manage_survey->atribut_pertanyaan_survey))) {

            $pertanyaan_terbuka_bawah = $this->db->query("SELECT *, perincian_pertanyaan_terbuka_$table_identity.id AS id_perincian_pertanyaan_terbuka, (SELECT DISTINCT(dengan_isian_lainnya) FROM isi_pertanyaan_ganda_$table_identity WHERE isi_pertanyaan_ganda_$table_identity.id_perincian_pertanyaan_terbuka = perincian_pertanyaan_terbuka_$table_identity.id) AS dengan_isian_lainnya
            FROM pertanyaan_terbuka_$table_identity
            JOIN perincian_pertanyaan_terbuka_$table_identity ON pertanyaan_terbuka_$table_identity.id = perincian_pertanyaan_terbuka_$table_identity.id_pertanyaan_terbuka
            WHERE pertanyaan_terbuka_$table_identity.is_letak_pertanyaan = 2
            ORDER BY SUBSTR(nomor_pertanyaan_terbuka,2) + 0");

            if ($pertanyaan_terbuka_bawah->num_rows() > 0) {

                $per_terbuka_bawah = [];
                foreach ($pertanyaan_terbuka_bawah->result() as $value) {

                    if ($value->gambar_pertanyaan_terbuka){ 
                        $gambar_pertanyaan_terbuka = '<div style="padding-bottom: 0px; "><img src="'.base_url().'assets/img/site/pertanyaan/'.$value->gambar_pertanyaan_terbuka.'" alt=""
                            style="max-width: 100%;"></div>';
                    }else{
                        $gambar_pertanyaan_terbuka = '';
                    }

                    if ($value->id_jenis_pilihan_jawaban == 2) {

                        $per_terbuka_bawah[] = '
                            <table width="100%" style="font-size: 11px;" border="1" cellpadding="3">
                                <tr>
                                    <td width="5%" style="text-align:center; font-size: 11px;">' . $value->nomor_pertanyaan_terbuka . '</td>
                                    <td width="32%" style="text-align:left; font-size: 11px;">' . $gambar_pertanyaan_terbuka . $value->isi_pertanyaan_terbuka . '</td>
                                    <td width="40%"></td>
                                    <td width="23%" style="text-align:left; font-size: 11px;"></td>
                                </tr>
                            </table>';
                    } else {

                        $pilihan_terbuka_bawah = [];
                        foreach ($this->db->get_where("isi_pertanyaan_ganda_$table_identity", array('id_perincian_pertanyaan_terbuka' => $value->id_perincian_pertanyaan_terbuka))->result() as $get) {

                            $pilihan_terbuka_bawah[] = '<tr>
                    <td width="4%"></td>
                    <td width="36%" style="background-color:#C7C6C1;">' . $get->pertanyaan_ganda . '</td>
                    </tr>';
                        }

                    $get_pilihan_terbuka_bawah = implode("", $pilihan_terbuka_bawah);
                    $isi_terbuka_bawah[$value->nomor_pertanyaan_terbuka] = $this->db->get_where("isi_pertanyaan_ganda_$table_identity", array('id_perincian_pertanyaan_terbuka' => $value->id_perincian_pertanyaan_terbuka))->num_rows() + 1;

                    

                        $per_terbuka_bawah[] = '
                    <table width="100%" style="font-size: 11px;" border="1" cellpadding="3">
                        <tr>
                            <td rowspan="' . $isi_terbuka_bawah[$value->nomor_pertanyaan_terbuka] . '" width="5%" style="text-align:center; font-size: 11px;">' . $value->nomor_pertanyaan_terbuka . '</td>

                            <td width="32%" rowspan="' . $isi_terbuka_bawah[$value->nomor_pertanyaan_terbuka] . '" style="text-align:left; font-size: 11px;">' . $gambar_pertanyaan_terbuka . $value->isi_pertanyaan_terbuka . '</td>

                            <td colspan="2" width="40%"></td>
                                    
                            <td width="23%"rowspan="' . $isi_terbuka_bawah[$value->nomor_pertanyaan_terbuka] . '" style="text-align:left; font-size: 11px;"></td>
                        </tr>' . $get_pilihan_terbuka_bawah . '
                </table>';
                    }
                }
                $get_pertanyaan_terbuka_bawah = implode("", $per_terbuka_bawah);
            } else {
                $get_pertanyaan_terbuka_bawah = '';
            }
        } else {
            $get_pertanyaan_terbuka_bawah = '';
        };







        //PERTANYAAN HARAPAN
        if (in_array(1, unserialize($manage_survey->atribut_pertanyaan_survey))) {

            $pertanyaan_harapan = $this->db->query("SELECT *, (SELECT nama_tingkat_kepentingan FROM nilai_tingkat_kepentingan_$table_identity WHERE id_pertanyaan_unsur_pelayanan = pertanyaan_unsur_pelayanan_$table_identity.id && nomor_tingkat_kepentingan = 1 ) AS pilihan_1,
            (SELECT nama_tingkat_kepentingan FROM nilai_tingkat_kepentingan_$table_identity WHERE id_pertanyaan_unsur_pelayanan = pertanyaan_unsur_pelayanan_$table_identity.id && nomor_tingkat_kepentingan = 2 ) AS pilihan_2,
            (SELECT nama_tingkat_kepentingan FROM nilai_tingkat_kepentingan_$table_identity WHERE id_pertanyaan_unsur_pelayanan = pertanyaan_unsur_pelayanan_$table_identity.id && nomor_tingkat_kepentingan = 3 ) AS pilihan_3,
            (SELECT nama_tingkat_kepentingan FROM nilai_tingkat_kepentingan_$table_identity WHERE id_pertanyaan_unsur_pelayanan = pertanyaan_unsur_pelayanan_$table_identity.id && nomor_tingkat_kepentingan = 4 ) AS pilihan_4, 
            (SELECT nama_tingkat_kepentingan FROM nilai_tingkat_kepentingan_$table_identity WHERE id_pertanyaan_unsur_pelayanan = pertanyaan_unsur_pelayanan_$table_identity.id && nomor_tingkat_kepentingan = 5 ) AS pilihan_5, (SELECT nomor_unsur FROM unsur_pelayanan_$table_identity WHERE id_unsur_pelayanan = unsur_pelayanan_$table_identity.id) AS nomor_unsur
            FROM pertanyaan_unsur_pelayanan_$table_identity
            JOIN unsur_pelayanan_$table_identity ON pertanyaan_unsur_pelayanan_$table_identity.id_unsur_pelayanan = unsur_pelayanan_$table_identity.id
            ORDER BY SUBSTR(nomor_unsur,2) + 0");

            $per_harapan = [];
            foreach ($pertanyaan_harapan->result() as $row) {


                if ($skala_likert == 5) {
                    $width = 12.6;
                    $pilihan_ke_5 = '<td width="12.6%" style="background-color:#C7C6C1; text-align:center; font-size: 11px;">' . $row->pilihan_5 . '</td>';
                    $ke_5 = '<th></th>';
                } else {
                    $width = 15.75;
                    $pilihan_ke_5 = '';
                    $ke_5 = '';
                }

                $per_harapan[] = '
            <table width="100%" border="1" cellpadding="4">
                <tr>
                    <td rowspan="2" width="5%" style="text-align:center; font-size: 11px;">H' . substr($row->nomor_unsur, 1) . '</td>
                    <td width="32%" rowspan="2" style="text-align:left; font-size: 11px;">' . $row->isi_pertanyaan_unsur . '</td>
                    <td width="' . $width . '%" style="background-color:#C7C6C1; text-align:center; font-size: 11px;">' . $row->pilihan_1 . '</td>
                    <td width="' . $width . '%" style="background-color:#C7C6C1; text-align:center; font-size: 11px;">' . $row->pilihan_2 . '</td>
                    <td width="' . $width . '%" style="background-color:#C7C6C1; text-align:center; font-size: 11px;">' . $row->pilihan_3 . '</td>
                    <td width="' . $width . '%" style="background-color:#C7C6C1; text-align:center; font-size: 11px;">' . $row->pilihan_4 . '</td>' . $pilihan_ke_5 . '
                </tr>

                <tr>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>'
                    . $ke_5 .
                    '</tr>
            </table>
            ';
            }
            $get_pertanyaan_harapan = '<table style="width: 100%;" border="1" cellpadding="3">
            <tr>
                <td colspan="2" style="text-align:left; font-size: 11px; background-color: black; color:white;"><b>PENILAIAN HARAPAN TERHADAP UNSUR PELAYANAN BERDASARKAN TINGKAT KEPENTINGAN</b></td>
            </tr>

            <tr>
                <td colspan="2" style="text-align:left; font-size: 11px; background-color: black; color:white;">Berikan tanda silang (x) sesuai jawaban Saudara</td>
            </tr>
        </table>' . $thead_tabel_harapan . implode("", $per_harapan);
        } else {
            $get_pertanyaan_harapan = '';
        }






        // ======================================== PERTANYAAN KUALITATIF ======================================
        if (in_array(3, unserialize($manage_survey->atribut_pertanyaan_survey))) {

            $pertanyaan_kualitatif = $this->db->get_where("pertanyaan_kualitatif_$table_identity", array('is_active' => 1));
            $per_kualitatif = [];
            $no = 1;
            foreach ($pertanyaan_kualitatif->result() as $row) {
                $per_kualitatif[] = '
                <tr>
                    <td width="5%" style="text-align:center;">' . $no++ . '</td>
                    <td width="32%">' . $row->isi_pertanyaan . '</td>
                    <td width="63%"></td>
                </tr>
            ';
            }
            $get_pertanyaan_kualitatif = '<table style="width: 100%;" border="1" cellpadding="3">
            <tr>
                <td colspan="2" style="text-align:left; font-size: 11px; background-color: black; color:white;"><b>PENILAIAN KUALITATIF KEPUASAN PELANGGAN</b></td>
            </tr>
    
            <tr>
                <td colspan="2" style="text-align:left; font-size: 11px; background-color: black; color:white;">Berikan jawaban sesuai dengan pendapat dan pengetahuan Saudara.</td>
            </tr>
        </table>
    
        <table width="100%" style="font-size: 11px; text-align:center; background-color:#C7C6C1" border="1" cellpadding="3">
            <tr>
                <td width="5%">No</td>
                <td width="32%">PERTANYAAN</td>
                <td width="63%">JAWABAN</td>
            </tr>
        </table>
    
        <table width="100%" style="font-size: 11px;" border="1" cellpadding="10">
            ' . implode("", $per_kualitatif) . '
        </table>';
        } else {
            $get_pertanyaan_kualitatif = '';
        }





        //PERTANYAAN NPS
        if (in_array(4, unserialize($manage_survey->atribut_pertanyaan_survey))) {

            $pertanyaan_nps = $this->db->query("SELECT *,
            (SELECT bobot FROM pilihan_jawaban_nps_$table_identity WHERE id_pertanyaan_nps = pertanyaan_nps_$table_identity.id && bobot = 0) AS pilihan_0,
            (SELECT bobot FROM pilihan_jawaban_nps_$table_identity WHERE id_pertanyaan_nps = pertanyaan_nps_$table_identity.id && bobot = 1) AS pilihan_1,
            (SELECT bobot FROM pilihan_jawaban_nps_$table_identity WHERE id_pertanyaan_nps = pertanyaan_nps_$table_identity.id && bobot = 2) AS pilihan_2,
            (SELECT bobot FROM pilihan_jawaban_nps_$table_identity WHERE id_pertanyaan_nps = pertanyaan_nps_$table_identity.id && bobot = 3) AS pilihan_3,
            (SELECT bobot FROM pilihan_jawaban_nps_$table_identity WHERE id_pertanyaan_nps = pertanyaan_nps_$table_identity.id && bobot = 4) AS pilihan_4,
            (SELECT bobot FROM pilihan_jawaban_nps_$table_identity WHERE id_pertanyaan_nps = pertanyaan_nps_$table_identity.id && bobot = 5) AS pilihan_5,
            (SELECT bobot FROM pilihan_jawaban_nps_$table_identity WHERE id_pertanyaan_nps = pertanyaan_nps_$table_identity.id && bobot = 6) AS pilihan_6,
            (SELECT bobot FROM pilihan_jawaban_nps_$table_identity WHERE id_pertanyaan_nps = pertanyaan_nps_$table_identity.id && bobot = 7) AS pilihan_7,
            (SELECT bobot FROM pilihan_jawaban_nps_$table_identity WHERE id_pertanyaan_nps = pertanyaan_nps_$table_identity.id && bobot = 8) AS pilihan_8,
            (SELECT bobot FROM pilihan_jawaban_nps_$table_identity WHERE id_pertanyaan_nps = pertanyaan_nps_$table_identity.id && bobot = 9) AS pilihan_9,
            (SELECT bobot FROM pilihan_jawaban_nps_$table_identity WHERE id_pertanyaan_nps = pertanyaan_nps_$table_identity.id && bobot = 10) AS pilihan_10
            FROM pertanyaan_nps_$table_identity");

            $per_nps = [];
            $no_nps = 1;
            foreach ($pertanyaan_nps->result() as $row) {

                $per_nps[] = '
            <table width="100%" border="1" cellpadding="4">
                <tr>
                    <td width="5%" style="text-align:center; font-size: 11px;">' . $no_nps++ . '</td>
                    <td width="32%" style="text-align:left; font-size: 11px;">' . $row->isi_pertanyaan . '</td>
                    <th width="5.725%"></th>
                    <th width="5.725%"></th>
                    <th width="5.725%"></th>
                    <th width="5.725%"></th>
                    <th width="5.725%"></th>
                    <th width="5.725%"></th>
                    <th width="5.725%"></th>
                    <th width="5.725%"></th>
                    <th width="5.725%"></th>
                    <th width="5.725%"></th>
                    <th width="5.725%"></th>
                </tr>
            </table>
            ';
            }
            $get_pertanyaan_nps = '<table style="width: 100%;" border="1" cellpadding="3">
            <tr>
                <td colspan="2" style="text-align:left; font-size: 11px; background-color: black; color:white;"><b>PENILAIAN TERHADAP <i>NET PROMOTER SCORE</i></b></td>
            </tr>

            <tr>
                <td colspan="2" style="text-align:left; font-size: 11px; background-color: black; color:white;">Berikan tanda silang (x) sesuai jawaban Saudara</td>
            </tr>
        </table>
        
        <table width="100%" style="font-size: 11px; text-align:center; background-color:#C7C6C1" border="1" cellpadding="3">
        <tr>
            <td rowspan="2" width="5%">No</td>
            <td rowspan="2" width="32%">PERTANYAAN</td>
            <td colspan="11" width="63%">PILIHAN JAWABAN</td>
        </tr>
        <tr>
            <td width="5.725%">0</td>
            <td width="5.725%">1</td>
            <td width="5.725%">2</td>
            <td width="5.725%">3</td>
            <td width="5.725%">4</td>
            <td width="5.725%">5</td>
            <td width="5.725%">6</td>
            <td width="5.725%">7</td>
            <td width="5.725%">8</td>
            <td width="5.725%">9</td>
            <td width="5.725%">10</td>
        </tr>
    </table>' . implode("", $per_nps);
        } else {
            $get_pertanyaan_nps = '';
        }





        // =============================================== STATUS SARAN ================================================
        if ($manage_survey->is_saran == 1) {
            $is_saran = '<tr>
            <td colspan="2" style="text-align:left; font-size: 11px;"><b>' .  $manage_survey->judul_form_saran . '</b>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
            </td>
        </tr>';
        } else {
            $is_saran = '';
        }







        // ============================================= GET HTML VIEW =============================================
        $html = '
        <table border="1" style="width: 100%;">
            <tr>
                <td>
                    <table border="0" cellspacing="2" cellpadding="1" style="width: 100%;">
                        <tr>
                            <td width="10%">' . $profil . '</td>

                            <td class="text-right" width="90%">
                                <div style="font-size:12px; font-weight:bold;">
                                ' . strtoupper($title_1) . '<br>  ' . strtoupper($title_2) . '
                                </div>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
        

        <table  border="1" style="width: 100%;" cellpadding="7">
            <tr>
                <td style="text-align:center; font-size: 11px; font-family:Arial, Helvetica, sans-serif; height:35px;">' . $manage_survey->deskripsi_opening_survey . '</td>
            </tr>
        </table>


        <table border="1" style="width: 100%;" cellpadding="3">
            <tr>
                <td style="font-size: 11px; background-color: black; color:white; height:15px;"><b>DATA RESPONDEN</b> (Berikan tanda silang (x) sesuai jawaban Saudara pada kolom yang tersedia)
                </td>
            </tr>
        </table>
        <table border="1" style="width: 100%;" cellpadding="4">' . $layanan_survei
            . $get_nama . '
        </table>
        
        
        <table style="width: 100%;" border="1" cellpadding="3">
            <tr>
                <td colspan="2" style="text-align:left; font-size: 11px; background-color: black; color:white;"><b>PENILAIAN TERHADAP UNSUR-UNSUR KEPUASAN</b></td>
            </tr>

            <tr>
                <td colspan="2" style="text-align:left; font-size: 11px; background-color: black; color:white;">Berikan tanda silang (x) sesuai jawaban Saudara<!-- dan berikan alasan jika jawaban Saudara negatif(Tidak
                    atau Kurang Baik)--></td>
            </tr>
        </table>' .

            $thead_tabel_unsur . $get_pertanyaan_terbuka_atas . $get_dimensi . $get_pertanyaan_terbuka_bawah .   $get_pertanyaan_harapan . $get_pertanyaan_kualitatif . $get_pertanyaan_nps . '

        <table style="width: 100%;" border="1" cellpadding="5">' . $is_saran . '
            

            <tr>
                <td colspan="2" style="text-align:center; font-size: 11px;">' . $manage_survey->deskripsi_selesai_survei . '</td>
            </tr>
        </table>
    ';
        // // var_dump($html);
        $pdf->writeHTML($html, true, false, true, false, '');


        $pdf->lastPage();
        $pdf->Output('Draf Kuesioner ' . $manage_survey->survey_name . '.pdf', 'I');
    }
}