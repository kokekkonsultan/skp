<?php
defined('BASEPATH') or exit('No direct script access allowed');

class AnalisaSurveiController extends Client_Controller
{

	public function __construct()
	{
		parent::__construct();

		if (!$this->ion_auth->logged_in()) {
			$this->session->set_flashdata('message_warning', 'You must be an admin to view this page');
			redirect('auth', 'refresh');
		}

		$this->load->library('form_validation');
		$this->load->model('AnalisaSurvei_model', 'Models');
	}


	public function index($id1, $id2)
	{
		$this->data = [];
		$this->data['title'] = 'Analisa Survei';
		$this->data['profiles'] = Client_Controller::_get_data_profile($id1, $id2);


		$manage_survey = $this->db->get_where('manage_survey', array('slug' => $this->uri->segment(2)))->row();
		$table_identity = $manage_survey->table_identity;
		$this->data['table_identity'] = $table_identity;
		$this->data['skala_likert'] = 100 / ($manage_survey->skala_likert == '' ? 4 : $manage_survey->skala_likert);
		$this->data['definisi_skala'] = $this->db->query("SELECT * FROM definisi_skala_$table_identity ORDER BY id desc");


		if ($this->db->get_where("survey_$table_identity", array('is_submit' => 1))->num_rows() == 0) {
			$this->data['pesan'] = 'survei belum dimulai atau belum ada responden !';
			return view('not_questions/index', $this->data);
		}

		if (date("Y-m-d") < $manage_survey->survey_end) {
			$this->data['pesan'] = 'Halaman ini hanya bisa dikelola jika periode survei sudah diselesai atau survei sudah ditutup.';
			return view('not_questions/index', $this->data);
		}

		if ($manage_survey->is_layanan_survei != 1) {
			$this->data['pesan'] = 'Halaman ini hanya bisa dikelola jika survei anda menggunakan layanan.';
			return view('not_questions/index', $this->data);
		}
		


		$rata_rata_unsur = $this->db->query("SELECT AVG(rata_rata) AS rata_rata
		FROM (
		SELECT IF(id_parent = 0,unsur_pelayanan_$table_identity.id, unsur_pelayanan_$table_identity.id_parent) AS id_sub,
		(SELECT nomor_unsur FROM unsur_pelayanan_$table_identity unsur_sub WHERE unsur_sub.id = id_sub) AS nomor_unsur,
		(SELECT nama_unsur_pelayanan FROM unsur_pelayanan_$table_identity unsur_sub WHERE unsur_sub.id = id_sub) AS nama_unsur_pelayanan,
		AVG(IF(jawaban_pertanyaan_unsur_$table_identity.skor_jawaban != 0, skor_jawaban, NULL)) AS rata_rata
		
		FROM jawaban_pertanyaan_unsur_$table_identity
		JOIN pertanyaan_unsur_pelayanan_$table_identity ON jawaban_pertanyaan_unsur_$table_identity.id_pertanyaan_unsur = pertanyaan_unsur_pelayanan_$table_identity.id
		JOIN unsur_pelayanan_$table_identity ON pertanyaan_unsur_pelayanan_$table_identity.id_unsur_pelayanan = unsur_pelayanan_$table_identity.id
		JOIN survey_$table_identity ON jawaban_pertanyaan_unsur_$table_identity.id_responden = survey_$table_identity.id_responden
		WHERE survey_$table_identity.is_submit = 1
		GROUP BY id_sub
		ORDER BY SUBSTR(nomor_unsur,2) + 0
		) jpu_$table_identity")->row()->rata_rata;

		$ikm = $rata_rata_unsur * $this->data['skala_likert'];
		foreach ($this->data['definisi_skala']->result() as $obj) {
			if ($ikm <= $obj->range_bawah && $ikm >= $obj->range_atas) {
				$kategori = $obj->kategori;
			}
		}
		if ($ikm <= 0) {
			$kategori = 'NULL';
		}

		$this->data['indeks_total'] = ROUND($rata_rata_unsur, 3) . ' (' . $kategori . ')';

		return view('analisa_survei/index', $this->data);
	}



	public function detail_layanan($id1, $id2)
	{
		$this->data = [];
		$this->data['title'] = 'Analisa Survei';
		$this->data['profiles'] = Client_Controller::_get_data_profile($id1, $id2);

		$id_layanan_survei = $this->uri->segment(4);
		$manage_survey = $this->db->get_where('manage_survey', array('slug' => $this->uri->segment(2)))->row();
		$table_identity = $manage_survey->table_identity;
		$this->data['table_identity'] = $table_identity;


		//PENDEFINISIAN SKALA LIKERT
		$this->data['layanan'] = $this->db->get_where("layanan_survei_$table_identity", ['id' => $id_layanan_survei])->row();
		$this->data['jumlah_kuisioner'] = $this->db->get_where("survey_$table_identity", array('is_submit' => 1));
		$this->data['skala_likert'] = 100 / ($manage_survey->skala_likert == '' ? 4 : $manage_survey->skala_likert);
		$this->data['definisi_skala'] = $this->db->query("SELECT * FROM definisi_skala_$table_identity ORDER BY id desc");


		$this->data['nilai_per_unsur'] = $this->db->query("SELECT IF(id_parent = 0,unsur_pelayanan_$table_identity.id, unsur_pelayanan_$table_identity.id_parent) AS id_sub,
		(SELECT nomor_unsur FROM unsur_pelayanan_$table_identity unsur_sub WHERE unsur_sub.id = id_sub) AS nomor_unsur,
		(SELECT nama_unsur_pelayanan FROM unsur_pelayanan_$table_identity unsur_sub WHERE unsur_sub.id = id_sub) AS nama_unsur_pelayanan,
		AVG(IF(jawaban_pertanyaan_unsur_$table_identity.skor_jawaban != 0, skor_jawaban, NULL)) AS rata_rata
		
		FROM jawaban_pertanyaan_unsur_$table_identity
		JOIN pertanyaan_unsur_pelayanan_$table_identity ON jawaban_pertanyaan_unsur_$table_identity.id_pertanyaan_unsur = pertanyaan_unsur_pelayanan_$table_identity.id
		JOIN unsur_pelayanan_$table_identity ON pertanyaan_unsur_pelayanan_$table_identity.id_unsur_pelayanan = unsur_pelayanan_$table_identity.id
		JOIN survey_$table_identity ON jawaban_pertanyaan_unsur_$table_identity.id_responden = survey_$table_identity.id_responden
		JOIN responden_$table_identity ON survey_$table_identity.id_responden = responden_$table_identity.id
		WHERE survey_$table_identity.is_submit = 1 && responden_$table_identity.id_layanan_survei = $id_layanan_survei
		GROUP BY id_sub
		ORDER BY SUBSTR(nomor_unsur, 2) + 0");


		foreach ($this->data['nilai_per_unsur']->result() as $value) {
			$array_nilai[] = $value->rata_rata;
			$nilai_tertimbang = array_sum($array_nilai) / count($array_nilai);
		}
		$nilai_konversi = ROUND($nilai_tertimbang * $this->data['skala_likert'], 10);
		$this->data['nilai_tertimbang'] = $nilai_tertimbang;


		foreach ($this->data['definisi_skala']->result() as $obj) {
			if ($nilai_konversi <= $obj->range_bawah && $nilai_konversi >= $obj->range_atas) {
				$this->data['kategori'] = $obj->kategori;
			}
		}
		if ($nilai_konversi <= 0) {
			$this->data['kategori'] = 'NULL' ;
		}

		// var_dump($this->data['nilai_tertimbang']);
		return view('analisa_survei/detail_layanan', $this->data);
	}




	public function ajax_list()
	{
		$slug = $this->uri->segment(2);

		$get_identity = $this->db->get_where('manage_survey', array('slug' => "$slug"))->row();
		$table_identity = $get_identity->table_identity;

		$list = $this->Models->get_datatables($table_identity);
		$data = array();
		$no = $_POST['start'];

		foreach ($list as $value) {

			$no++;
			$row = array();
			$row[] = $no;
			$row[] = $value->nomor_unsur . '. ' . $value->nama_unsur_pelayanan;
			// $row[] = $value->saran_masukan;
			$row[] = $value->faktor_penyebab;
			$row[] = $value->rencana_perbaikan;
			// $row[] = $value->kegiatan;
			$row[] = $value->waktu;
			$row[] = $value->penanggung_jawab;
			$row[] = anchor($this->session->userdata('username') . '/' . $this->uri->segment(2) . '/analisa-survei/edit/' . $value->id_analisa, '<i class="fa fa-edit"></i> Edit', ['class' => 'btn btn-light-primary btn-sm font-weight-bold shadow']);

			$row[] = '<a class="btn btn-light-primary btn-sm font-weight-bold shadow" href="javascript:void(0)" title="Hapus ' . $value->nama_unsur_pelayanan . '" onclick="delete_analisa_survei(' . "'" . $value->id_analisa . "'" . ')"><i class="fa fa-trash"></i> Delete</a>';


			$data[] = $row;
		}

		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->Models->count_all($table_identity),
			"recordsFiltered" => $this->Models->count_filtered($table_identity),
			"data" => $data,
		);

		echo json_encode($output);
	}




	public function detail_unsur($username, $slug, $id_layanan_survei, $id_unsur_pelayanan)
	{
		$this->data = [];
		$this->data['title'] = 'Detail Unsur';
		$this->data['profiles'] = Client_Controller::_get_data_profile($username, $slug);

		$manage_survey = $this->db->get_where('manage_survey', array('slug' => "$slug"))->row();
		$table_identity = $manage_survey->table_identity;
		$this->data['atribut_pertanyaan'] = unserialize($manage_survey->atribut_pertanyaan_survey);

		//PENDEFINISIAN SKALA LIKERT
		$this->data['skala_likert'] = 100 / ($manage_survey->skala_likert == 5 ? 5 : 4);
		$this->data['definisi_skala'] = $this->db->query("SELECT * FROM definisi_skala_$table_identity ORDER BY id desc");

		// Cek unsur memiliki turunan atau tidak
		$this->data['cek_turunan_unsur'] = $this->db->get_where("unsur_pelayanan_$table_identity", ["id_parent" => $id_unsur_pelayanan]);

		if ($this->data['cek_turunan_unsur']->num_rows() > 0) {
			$nomor_unsur = "(SELECT nomor_unsur FROM unsur_pelayanan_$table_identity WHERE unsur_pelayanan_$table_identity.id = unsur_baru.id_sub) AS nomor_unsur";
			$nama_unsur_pelayanan = "(SELECT nama_unsur_pelayanan FROM unsur_pelayanan_$table_identity WHERE unsur_pelayanan_$table_identity.id = unsur_baru.id_sub) AS nama_unsur_pelayanan";
			$kondisi = "unsur_baru.id_sub";
		} else {
			$nomor_unsur = "nomor_unsur";
			$nama_unsur_pelayanan = 'nama_unsur_pelayanan';
			$kondisi = "unsur_baru.id";
		}

		
		// $this->db->select("nsur_baru.id AS id_unsur_pelayanan,
		// ((SUM(skor_jawaban)/COUNT(DISTINCT survey_$table_identity.id_responden))/(COUNT(id_parent)/COUNT(DISTINCT survey_$table_identity.id_responden))) AS nilai_per_unsur, $nama_unsur_pelayanan, $nomor_unsur, isi_pertanyaan_unsur");
		// $this->db->from("jawaban_pertanyaan_unsur_$table_identity");
		// $this->db->join("pertanyaan_unsur_pelayanan_$table_identity", "jawaban_pertanyaan_unsur_$table_identity.id_pertanyaan_unsur = pertanyaan_unsur_pelayanan_$table_identity.id");
		// $this->db->join("(SELECT *, IF(id_parent = 0,unsur_pelayanan_$table_identity.id, unsur_pelayanan_$table_identity.id_parent) AS id_sub FROM unsur_pelayanan_$table_identity) AS unsur_baru", "pertanyaan_unsur_pelayanan_$table_identity.id_unsur_pelayanan = unsur_baru.id");
		// $this->db->join("survey_$table_identity", "jawaban_pertanyaan_unsur_$table_identity.id_responden = survey_$table_identity.id_responden ");
		// $this->db->join("responden_$table_identity", "responden_$table_identity.id = survey_$table_identity.id_responden ");
		// $this->db->where("survey_$table_identity.is_submit", 1);
		// $this->db->where("responden_$table_identity.id_layanan_survei", $id_layanan_survei);
		// $this->db->where($kondisi, $id_unsur_pelayanan);


		$this->data['isi_pertanyaan'] = $this->db->query("SELECT unsur_baru.id AS id_unsur_pelayanan,
		AVG(IF(jawaban_pertanyaan_unsur_$table_identity.skor_jawaban != 0, skor_jawaban, NULL)) AS nilai_per_unsur,
		$nama_unsur_pelayanan, $nomor_unsur, isi_pertanyaan_unsur
		
		FROM jawaban_pertanyaan_unsur_$table_identity
		JOIN pertanyaan_unsur_pelayanan_$table_identity ON jawaban_pertanyaan_unsur_$table_identity.id_pertanyaan_unsur = pertanyaan_unsur_pelayanan_$table_identity.id
		JOIN (SELECT *, IF(id_parent = 0,unsur_pelayanan_$table_identity.id, unsur_pelayanan_$table_identity.id_parent) AS id_sub FROM unsur_pelayanan_$table_identity) AS unsur_baru ON pertanyaan_unsur_pelayanan_$table_identity.id_unsur_pelayanan = unsur_baru.id JOIN survey_$table_identity ON jawaban_pertanyaan_unsur_$table_identity.id_responden = survey_$table_identity.id_responden
		JOIN responden_$table_identity ON responden_$table_identity.id = survey_$table_identity.id_responden
		WHERE survey_$table_identity.is_submit = 1 && responden_$table_identity.id_layanan_survei = $id_layanan_survei && $kondisi = $id_unsur_pelayanan")->row();


		$this->data['profil'] = $this->db->query("SELECT * FROM profil_responden_$table_identity")->result();

		// Cek sudah diinput atau belum
		$cek_current = $this->db->get_where("analisa_$table_identity", ["id_layanan_survei" => $this->uri->segment(4) ,"id_unsur_pelayanan" => $this->uri->segment(5)]);

		if ($cek_current->num_rows() > 0) {

			$current = $cek_current->row();

			$this->data['form_action'] = base_url() . $this->session->userdata('username') . '/' . $this->uri->segment(2) . '/analisa-survei/update-analisa/' . $this->uri->segment(4) . '/' . $this->uri->segment(5);

			$this->data['faktor_penyebab'] = [
				'name'         => 'faktor_penyebab',
				'id'        => 'faktor_penyebab',
				'type'        => 'text',
				'class' 	=> "form-control",
				'value'        =>    $this->form_validation->set_value('faktor_penyebab', $current->faktor_penyebab)
			];

			$this->data['rencana_perbaikan'] = [
				'name'         => 'rencana_perbaikan',
				'id'        => 'rencana_perbaikan',
				'type'        => 'text',
				'class' 	=> "form-control",
				'value'        =>    $this->form_validation->set_value('rencana_perbaikan', $current->rencana_perbaikan)
			];

			$this->data['waktu'] = [
				'name'         => 'waktu',
				'type'        => 'text',
				'class' 	=> "form-control",
				'value'        =>    $this->form_validation->set_value('rencana_perbaikan', $current->waktu),
				'readonly' => 'readonly'
			];


			$this->data['penanggung_jawab'] = [
				'name'         => 'penanggung_jawab',
				'id'        => 'penanggung_jawab',
				'type'        => 'text',
				'value'        =>    $this->form_validation->set_value('penanggung_jawab', $current->penanggung_jawab),
				'class'        => 'form-control',
				'required' => 'required',
			];
		} else {

			$this->data['form_action'] = base_url() . $this->session->userdata('username') . '/' . $this->uri->segment(2) . '/analisa-survei/tambah-analisa/' . $this->uri->segment(4) . '/' . $this->uri->segment(5);

			$this->data['faktor_penyebab'] = [
				'name'         => 'faktor_penyebab',
				'id'        => 'faktor_penyebab',
				'type'        => 'text',
				'class' 	=> "form-control",
				'value'        =>    $this->form_validation->set_value('faktor_penyebab')
			];

			$this->data['rencana_perbaikan'] = [
				'name'         => 'rencana_perbaikan',
				'id'        => 'rencana_perbaikan',
				'type'        => 'text',
				'class' 	=> "form-control",
				'value'        =>    $this->form_validation->set_value('rencana_perbaikan')
			];

			$this->data['waktu'] = [
				'name'         => 'waktu',
				'type'        => 'text',
				'class' 	=> "form-control",
				'value'        =>    $this->form_validation->set_value('rencana_perbaikan'),
				'readonly' => 'readonly'
			];

			$this->data['penanggung_jawab'] = [
				'name'         => 'penanggung_jawab',
				'id'        => 'penanggung_jawab',
				'type'        => 'text',
				'value'        =>    $this->form_validation->set_value('penanggung_jawab'),
				'class'        => 'form-control',
				'required' => 'required',
			];
		}
		return view('analisa_survei/detail_unsur', $this->data);
	}




	public function ajax_list_unsur($username, $slug, $id_layanan_survei, $id_unsur_pelayanan)
	{
		$this->load->model('AnalisaUnsur_model');
		$table_identity = $this->get_table_identity($slug);

		$manage_survey = $this->db->get_where('manage_survey', array('slug' => "$slug"))->row();
		$atribut_pertanyaan = unserialize($manage_survey->atribut_pertanyaan_survey);


		$this->db->select("*, pertanyaan_unsur_pelayanan_$table_identity.id AS id_pertanyaan_unsur_pelayanan");
		$this->db->from("pertanyaan_unsur_pelayanan_$table_identity");
		$this->db->join("unsur_pelayanan_$table_identity", "unsur_pelayanan_$table_identity.id = pertanyaan_unsur_pelayanan_$table_identity.id_unsur_pelayanan");
		$this->db->where("unsur_pelayanan_$table_identity.id", $id_unsur_pelayanan);
		$isi_pertanyaan = $this->db->get()->row();
		$id_unsur_pelayanan = $isi_pertanyaan->id_unsur_pelayanan;

		$profil_responden = $this->db->query("SELECT * FROM profil_responden_$table_identity")->result();

		$list = $this->AnalisaUnsur_model->get_datatables($table_identity, $id_unsur_pelayanan, $profil_responden, $id_layanan_survei);
		$data = array();
		$no = $_POST['start'];

		foreach ($list as $value) {

			
			$no++;
			$row = array();
			$row[] = $no;
			foreach ($profil_responden as $get) {
				$profil = $get->nama_alias;
				$row[] = $value->$profil;
			}
			$row[] = '(' . $value->skor_jawaban . ') ' . $value->bobot;

			if(in_array(1, $atribut_pertanyaan)) {
			$row[] = '(' . $value->skor_harapan . ') ' . $value->nama_tingkat_kepentingan;
			}


			$row[] = $value->alasan_pilih_jawaban .
				'<hr>
				<a class="badge badge-primary" data-toggle="modal" onclick="showeditalasan(' . $value->id_jawaban_pertanyaan_unsur . ')" href="#modal_edit_alasan">Edit Alasan</a>';



			$row[] = $value->saran .
				'<hr>
				<a class="badge badge-info" data-toggle="modal" onclick="showeditsaran(' . $value->id_survei . ')" href="#modal_edit_saran">Edit Saran</a>';

			$data[] = $row;
		}

		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->AnalisaUnsur_model->count_all($table_identity, $id_unsur_pelayanan, $profil_responden, $id_layanan_survei),
			"recordsFiltered" => $this->AnalisaUnsur_model->count_filtered($table_identity, $id_unsur_pelayanan, $profil_responden, $id_layanan_survei),
			"data" => $data,
		);

		echo json_encode($output);
	}


	public function modal_alasan($id1, $id2) {

		$this->data['profiles'] = $this->_get_data_profile($id1, $id2);
		$this->data['table_identity'] = $this->data['profiles']->table_identity;

		return view('analisa_survei/modal_alasan', $this->data);
	}

	public function update_alasan($id1, $id2) {

		$this->data['profiles'] = $this->_get_data_profile($id1, $id2);

		$id = $this->uri->segment(5);
		$object = [
			'alasan_pilih_jawaban' => $this->input->post("alasan"),
		];
		$this->db->where('id', $id);
		$this->db->update('jawaban_pertanyaan_unsur_' . $this->data['profiles']->table_identity, $object);

        $pesan = 'Data berhasil disimpan';
        $msg = ['sukses' => $pesan];
        echo json_encode($msg);
	}

	public function modal_saran($id1, $id2) {

		$this->data['profiles'] = $this->_get_data_profile($id1, $id2);
		$this->data['table_identity'] = $this->data['profiles']->table_identity;
		// echo 'Perbaikan pada sarana dan pra sarana' . $this->uri->segment(5);
		return view('analisa_survei/modal_saran', $this->data);
	}

	public function update_saran($id1, $id2) {

		
		$this->data['profiles'] = $this->_get_data_profile($id1, $id2);

		$id = $this->uri->segment(5);
		$object = [
			'saran' => $this->input->post("saran"),
		];
		
		$this->db->where('id', $id);
		$this->db->update('survey_' . $this->data['profiles']->table_identity, $object);

        $pesan = 'Data berhasil disimpan';
        $msg = ['sukses' => $pesan];
        echo json_encode($msg);
	}

	

	// public function ajax_list_harapan($username, $slug, $id_layanan_survei, $id_unsur_pelayanan)
	// {
	// 	$this->load->model('AnalisaHarapan_model');

	// 	$table_identity = $this->get_table_identity($slug);

	// 	$this->db->select("*, pertanyaan_unsur_pelayanan_$table_identity.id AS id_pertanyaan_unsur_pelayanan");
	// 	$this->db->from("pertanyaan_unsur_pelayanan_$table_identity");
	// 	$this->db->join("unsur_pelayanan_$table_identity", "unsur_pelayanan_$table_identity.id = pertanyaan_unsur_pelayanan_$table_identity.id_unsur_pelayanan");
	// 	$this->db->where("unsur_pelayanan_$table_identity.id", $id_unsur_pelayanan);
	// 	$isi_pertanyaan = $this->db->get()->row();
	// 	$id_unsur_pelayanan = $isi_pertanyaan->id_unsur_pelayanan;


	// 	$list = $this->AnalisaHarapan_model->get_datatables($table_identity, $id_unsur_pelayanan);
	// 	$data = array();
	// 	$no = $_POST['start'];

	// 	foreach ($list as $value) {

	// 		$no++;
	// 		$row = array();
	// 		$row[] = $no;
	// 		$row[] = '(' . $value->skor_jawaban . ') ' . $value->bobot;

	// 		$data[] = $row;
	// 	}

	// 	$output = array(
	// 		"draw" => $_POST['draw'],
	// 		"recordsTotal" => $this->AnalisaHarapan_model->count_all($table_identity, $id_unsur_pelayanan),
	// 		"recordsFiltered" => $this->AnalisaHarapan_model->count_filtered($table_identity, $id_unsur_pelayanan),
	// 		"data" => $data,
	// 	);

	// 	echo json_encode($output);
	// }


	public function tambah_analisa($username, $slug, $id_layanan_survei, $id_unsur_pelayanan)
	{
		$input 	= $this->input->post(NULL, TRUE);
		$table_identity = $this->get_table_identity($slug);

		$object = [
			'id_layanan_survei' => $id_layanan_survei,
			'id_unsur_pelayanan' 	=> $id_unsur_pelayanan,
			'rencana_perbaikan' 	=> $input['rencana_perbaikan'],
			'waktu' 	=> $input['waktu'],
			'faktor_penyebab' 	=> $input['faktor_penyebab'],
			'penanggung_jawab' 	=> $input['penanggung_jawab'],
		];
		$this->db->insert('analisa_' . $table_identity, $object);

		$this->session->set_flashdata('message_success', 'Analisa berhasil ditambahkan');
		redirect(base_url() . $this->session->userdata('username') . '/' . $this->uri->segment(2) . '/analisa-survei/' . $this->uri->segment(5), 'refresh');
	}

	public function update_analisa($username, $slug, $id_layanan_survei, $id_unsur_pelayanan)
	{
		$input 	= $this->input->post(NULL, TRUE);
		$table_identity = $this->get_table_identity($slug);

		$object = [
			'rencana_perbaikan' 	=> $input['rencana_perbaikan'],
			'waktu' 	=> $input['waktu'],
			'faktor_penyebab' 	=> $input['faktor_penyebab'],
			'penanggung_jawab' 	=> $input['penanggung_jawab'],
		];
		$this->db->where(['id_layanan_survei', $this->uri->segment(5), 'id_unsur_pelayanan', $this->uri->segment(6)]);
		$this->db->update('analisa_' . $table_identity, $object);

		$this->session->set_flashdata('message_success', 'Analisa berhasil diubah');
		redirect(base_url() . $this->session->userdata('username') . '/' . $this->uri->segment(2) . '/analisa-survei/' . $this->uri->segment(5), 'refresh');
	}




	// public function update_executive_summary()
	// {
	// 	$slug = $this->uri->segment(2);
	// 	$object = [
	// 		'executive_summary' => $this->input->post('executive_summary')
	// 	];
	// 	$this->db->where('slug', "$slug");
	// 	$this->db->update('manage_survey', $object);

	// 	$pesan = 'Data berhasil disimpan';
	// 	$msg = ['sukses' => $pesan];
	// 	echo json_encode($msg);
	// }



	// public function add($id1, $id2)
	// {
	// 	$this->data = [];
	// 	$this->data['title'] = "Tambah Analisa Survei";

	// 	$this->data['profiles'] = Client_Controller::_get_data_profile($id1, $id2);

	// 	$slug = $this->uri->segment(2);
	// 	$manage_survey = $this->db->get_where('manage_survey', array('slug' => "$slug"))->row();
	// 	$table_identity = $manage_survey->table_identity;

	// 	$this->data['id_unsur_pelayanan'] = [
	// 		'name' 		=> 'id_unsur_pelayanan',
	// 		'id' 		=> 'id_unsur_pelayanan',
	// 		'options' 	=> $this->Models->dropdown_unsur_pelayanan($table_identity),
	// 		'selected' 	=> $this->form_validation->set_value('id_unsur_pelayanan'),
	// 		'class' 	=> "form-control",
	// 		'autofocus' => 'autofocus',
	// 		'required' => 'required'
	// 	];

	// 	$this->data['saran_masukan'] = [
	// 		'name'         => 'saran_masukan',
	// 		'id'        => 'saran_masukan',
	// 		'type'        => 'text',
	// 		'class' 	=> "form-control",
	// 		'value'        =>    $this->form_validation->set_value('saran_masukan')
	// 	];

	// 	$this->data['rencana_perbaikan'] = [
	// 		'name'         => 'rencana_perbaikan',
	// 		'id'        => 'rencana_perbaikan',
	// 		'type'        => 'text',
	// 		'class' 	=> "form-control",
	// 		'value'        =>    $this->form_validation->set_value('rencana_perbaikan')
	// 	];

	// 	$this->data['faktor_penyebab'] = [
	// 		'name'         => 'faktor_penyebab',
	// 		'id'        => 'faktor_penyebab',
	// 		'type'        => 'text',
	// 		'class' 	=> "form-control",
	// 		'value'        =>    $this->form_validation->set_value('faktor_penyebab')
	// 	];

	// 	$this->data['kegiatan'] = [
	// 		'name'         => 'kegiatan',
	// 		'id'        => 'kegiatan',
	// 		'type'        => 'text',
	// 		'class' 	=> "form-control",
	// 		'value'        =>    $this->form_validation->set_value('kegiatan')
	// 	];

	// 	$this->data['penanggung_jawab'] = [
	// 		'name'         => 'penanggung_jawab',
	// 		'id'        => 'penanggung_jawab',
	// 		'type'        => 'text',
	// 		'value'        =>    $this->form_validation->set_value('penanggung_jawab'),
	// 		'class'        => 'form-control',
	// 		'required' => 'required',
	// 	];

	// 	$this->form_validation->set_rules('penanggung_jawab', 'Penanggung Jawab', 'trim|required');
	// 	$this->form_validation->set_rules('kegiatan', 'Kegiatan', 'trim|required');
	// 	$this->form_validation->set_rules('faktor_penyebab', 'Faktor Penyebab', 'trim|required');
	// 	$this->form_validation->set_rules('rencana_perbaikan', 'Rencana Perbaikan', 'trim|required');
	// 	$this->form_validation->set_rules('saran_masukan', 'Saran Masukan', 'trim|required');
	// 	$this->form_validation->set_rules('id_unsur_pelayanan', 'Unsur Pelayanan', 'trim|required');

	// 	if ($this->form_validation->run() == FALSE) {

	// 		return view('analisa_survei/add', $this->data);
	// 	} else {

	// 		$input 	= $this->input->post(NULL, TRUE);

	// 		$object = [
	// 			'id_unsur_pelayanan' 	=> $input['id_unsur_pelayanan'],
	// 			// 'saran_masukan' 	=> $input['saran_masukan'],
	// 			'rencana_perbaikan' 	=> $input['rencana_perbaikan'],
	// 			'waktu' 	=> $input['waktu'],
	// 			'faktor_penyebab' 	=> $input['faktor_penyebab'],
	// 			// 'kegiatan' 	=> $input['kegiatan'],
	// 			'penanggung_jawab' 	=> $input['penanggung_jawab'],
	// 		];
	// 		// var_dump($object);
	// 		$this->db->insert('analisa_' . $table_identity, $object);

	// 		if ($this->db->affected_rows() > 0) {

	// 			$this->session->set_flashdata('message_success', 'Berhasil menambah data');
	// 			redirect(base_url() . $this->session->userdata('username') . '/' . $this->uri->segment(2) . '/analisa-survei', 'refresh');
	// 		} else {

	// 			$this->data['message_data_danger'] = "Gagal menambah data";
	// 			return view('analisa_survei/add', $this->data);
	// 		}
	// 	}
	// }

	public function edit($id1, $id2)
	{
		$this->data = [];
		$this->data['title'] = "Edit Analisa Survei";

		$this->data['profiles'] = Client_Controller::_get_data_profile($id1, $id2);

		$slug = $this->uri->segment(2);
		$manage_survey = $this->db->get_where('manage_survey', array('slug' => "$slug"))->row();
		$table_identity = $manage_survey->table_identity;

		$current = $this->db->get_where("analisa_$table_identity", array('id' => $this->uri->segment(5)))->row();
		$this->data['current'] = $current;

		$this->data['rencana_perbaikan'] = [
			'name'         => 'rencana_perbaikan',
			'id'        => 'rencana_perbaikan',
			'type'        => 'text',
			'class' 	=> "form-control",
			'value'        =>    $this->form_validation->set_value('rencana_perbaikan', $current->rencana_perbaikan)
		];

		$this->data['waktu'] = [
			'name'         => 'waktu',
			'type'        => 'text',
			'class' 	=> "form-control",
			'value'        =>    $this->form_validation->set_value('rencana_perbaikan', $current->waktu),
			'readonly' => 'readonly'
		];

		$this->data['faktor_penyebab'] = [
			'name'         => 'faktor_penyebab',
			'id'        => 'faktor_penyebab',
			'type'        => 'text',
			'class' 	=> "form-control",
			'value'        =>    $this->form_validation->set_value('faktor_penyebab', $current->faktor_penyebab)
		];
	

		$this->data['penanggung_jawab'] = [
			'name'         => 'penanggung_jawab',
			'id'        => 'penanggung_jawab',
			'type'        => 'text',
			'value'        =>    $this->form_validation->set_value('penanggung_jawab', $current->penanggung_jawab),
			'class'        => 'form-control',
			'required' => 'required',
		];

		$this->data['waktu_analisa'] = $current->waktu;

		$this->form_validation->set_rules('penanggung_jawab', 'Penanggung Jawab', 'trim|required');
		$this->form_validation->set_rules('faktor_penyebab', 'Faktor Penyebab', 'trim|required');
		$this->form_validation->set_rules('rencana_perbaikan', 'Rencana Perbaikan', 'trim|required');

		if ($this->form_validation->run() == FALSE) {

			return view('analisa_survei/edit', $this->data);
		} else {

			$input 	= $this->input->post(NULL, TRUE);

			$object = [
				'rencana_perbaikan' 	=> $input['rencana_perbaikan'],
				'waktu' 	=> $input['waktu'],
				'faktor_penyebab' 	=> $input['faktor_penyebab'],
				'penanggung_jawab' 	=> $input['penanggung_jawab'],
			];
			// var_dump($object);
			$this->db->where('id', $this->uri->segment(5));
			$this->db->update('analisa_' . $table_identity, $object);


			$this->session->set_flashdata('message_success', 'Berhasil mengubah data');
			redirect(base_url() . $this->session->userdata('username') . '/' . $this->uri->segment(2) . '/analisa-survei/' . $current->id_layanan_survei, 'refresh');
		}
	}

	public function delete()
	{
		$slug = $this->uri->segment(2);
		$manage_survey = $this->db->get_where('manage_survey', array('slug' => "$slug"))->row();
		$table_identity = $manage_survey->table_identity;

		$this->db->delete('analisa_' . $table_identity, array('id' => $this->uri->segment(5)));

		echo json_encode(array("status" => TRUE));
	}

	function get_table_identity($slug)
	{
		$this->db->select('table_identity');
		$this->db->from('manage_survey');
		$this->db->where("slug", $slug);
		return $this->db->get()->row()->table_identity;
	}
}

/* End of file PertanyaanKualitatifController.php */
/* Location: ./application/controllers/PertanyaanKualitatifController.php */
