<?php
defined('BASEPATH') or exit('No direct script access allowed');

class OlahDataController extends Client_Controller
{

	public function __construct()
	{
		parent::__construct();

		if (!$this->ion_auth->logged_in()) {
			$this->session->set_flashdata('message_warning', 'You must be an admin to view this page');
			redirect('auth', 'refresh');
		}
		$this->load->model('OlahData_model', 'models');
	}

	public function index($id1, $id2)
	{
		$url = $this->uri->uri_string();
		$this->session->set_userdata('urlback', $url);

		$this->data = [];
		$this->data['title'] = 'Olah Data';
		$this->data['profiles'] = Client_Controller::_get_data_profile($id1, $id2);

		$this->db->select('*, manage_survey.id AS id_manage_survey');
		$this->db->from('manage_survey');
		$this->db->where('manage_survey.slug', $this->uri->segment(2));
		$manage_survey = $this->db->get()->row();
		$table_identity = $manage_survey->table_identity;
		$this->data['atribut_pertanyaan'] = unserialize($manage_survey->atribut_pertanyaan_survey);
		// var_dump($manage_survey);

		//PENDEFINISIAN SKALA LIKERT
		$this->data['skala_likert'] = 100 / ($manage_survey->skala_likert == 5 ? 5 : 4);
		$this->data['definisi_skala'] = $this->db->query("SELECT * FROM definisi_skala_$table_identity ORDER BY id DESC");


		$this->data['unsur'] = $this->db->query("SELECT *, SUBSTR(nomor_unsur,2) AS nomor_harapan
		FROM unsur_pelayanan_$table_identity
		JOIN pertanyaan_unsur_pelayanan_$table_identity ON unsur_pelayanan_$table_identity.id = pertanyaan_unsur_pelayanan_$table_identity.id_unsur_pelayanan
		ORDER BY SUBSTR(nomor_unsur, 2) + 0");


		//TOTAL
		$this->data['total_unsur'] = $this->db->query("SELECT (SELECT nomor_unsur FROM unsur_pelayanan_$table_identity
		JOIN pertanyaan_unsur_pelayanan_$table_identity ON unsur_pelayanan_$table_identity.id = pertanyaan_unsur_pelayanan_$table_identity.id_unsur_pelayanan WHERE pertanyaan_unsur_pelayanan_$table_identity.id = jawaban_pertanyaan_unsur_$table_identity.id_pertanyaan_unsur) AS nomor_unsur,
		SUM(skor_jawaban) AS sum_skor_jawaban,
		AVG(IF(jawaban_pertanyaan_unsur_$table_identity.skor_jawaban != 0, skor_jawaban, NULL)) AS rata_rata

		FROM jawaban_pertanyaan_unsur_$table_identity
		JOIN responden_$table_identity ON jawaban_pertanyaan_unsur_$table_identity.id_responden = responden_$table_identity.id
		JOIN survey_$table_identity ON responden_$table_identity.id = survey_$table_identity.id
		WHERE is_submit = 1
		GROUP BY id_pertanyaan_unsur
		ORDER BY SUBSTR((SELECT nomor_unsur FROM unsur_pelayanan_$table_identity
		JOIN pertanyaan_unsur_pelayanan_$table_identity ON unsur_pelayanan_$table_identity.id = pertanyaan_unsur_pelayanan_$table_identity.id_unsur_pelayanan
		WHERE pertanyaan_unsur_pelayanan_$table_identity.id = jawaban_pertanyaan_unsur_$table_identity.id_pertanyaan_unsur),2) + 0");



		//TOTAL HARAPAN
		$this->data['total_harapan'] = $this->db->query("SELECT SUM(skor_jawaban) AS sum_skor_jawaban,
		AVG(IF(jawaban_pertanyaan_harapan_$table_identity.skor_jawaban != 0, skor_jawaban, NULL)) AS rata_rata

		FROM jawaban_pertanyaan_harapan_$table_identity
		JOIN responden_$table_identity ON jawaban_pertanyaan_harapan_$table_identity.id_responden = responden_$table_identity.id
		JOIN survey_$table_identity ON responden_$table_identity.id = survey_$table_identity.id
		WHERE is_submit = 1
		GROUP BY id_pertanyaan_unsur
		ORDER BY SUBSTR((SELECT nomor_unsur FROM unsur_pelayanan_$table_identity
		JOIN pertanyaan_unsur_pelayanan_$table_identity ON unsur_pelayanan_$table_identity.id = pertanyaan_unsur_pelayanan_$table_identity.id_unsur_pelayanan
		WHERE pertanyaan_unsur_pelayanan_$table_identity.id = jawaban_pertanyaan_harapan_$table_identity.id_pertanyaan_unsur),2) + 0");


		//JUMLAH KUISIONER
		$this->data['jumlah_kuisioner'] = $this->db->get_where("survey_$table_identity", ['is_submit' => 1])->num_rows();
		if ($this->data['jumlah_kuisioner'] == 0) {
			$this->data['pesan'] = 'survei belum dimulai atau belum ada responden !';
			return view('not_questions/index', $this->data);
		}



		//NILAI PER UNSUR
		$this->data['nilai_per_unsur'] = $this->db->query("SELECT nomor_unsur, nama_unsur_pelayanan,
		IF(id_parent = 0, unsur_pelayanan_$table_identity.id, unsur_pelayanan_$table_identity.id_parent) AS id_sub,
		(SELECT COUNT(id) FROM unsur_pelayanan_$table_identity WHERE id_parent = 0) AS bobot,
		(COUNT(id_parent)/COUNT(DISTINCT survey_$table_identity.id_responden)) AS colspan,
		AVG(IF(jawaban_pertanyaan_unsur_$table_identity.skor_jawaban != 0, skor_jawaban, NULL)) AS rata_rata,
		(AVG(IF(jawaban_pertanyaan_unsur_$table_identity.skor_jawaban != 0, skor_jawaban, NULL)) / (SELECT COUNT(id) FROM unsur_pelayanan_$table_identity WHERE id_parent = 0)) AS rata_rata_x_bobot


		FROM jawaban_pertanyaan_unsur_$table_identity
		JOIN pertanyaan_unsur_pelayanan_$table_identity ON jawaban_pertanyaan_unsur_$table_identity.id_pertanyaan_unsur = pertanyaan_unsur_pelayanan_$table_identity.id
		JOIN unsur_pelayanan_$table_identity ON pertanyaan_unsur_pelayanan_$table_identity.id_unsur_pelayanan = unsur_pelayanan_$table_identity.id
		JOIN survey_$table_identity ON jawaban_pertanyaan_unsur_$table_identity.id_responden = survey_$table_identity.id_responden
		WHERE survey_$table_identity.is_submit = 1 GROUP BY id_sub
		ORDER BY SUBSTR(nomor_unsur,2) + 0");


		//NILAI PER HARAPAN
		$this->data['nilai_per_unsur_harapan'] = $this->db->query("SELECT nomor_unsur, nama_unsur_pelayanan,
		IF(id_parent = 0, unsur_pelayanan_$table_identity.id, unsur_pelayanan_$table_identity.id_parent) AS id_sub,
		(SELECT COUNT(id) FROM unsur_pelayanan_$table_identity WHERE id_parent = 0) AS bobot,
		(COUNT(id_parent)/COUNT(DISTINCT survey_$table_identity.id_responden)) AS colspan,
		AVG(IF(jawaban_pertanyaan_harapan_$table_identity.skor_jawaban != 0, skor_jawaban, NULL)) AS rata_rata


		FROM jawaban_pertanyaan_harapan_$table_identity
		JOIN pertanyaan_unsur_pelayanan_$table_identity ON jawaban_pertanyaan_harapan_$table_identity.id_pertanyaan_unsur = pertanyaan_unsur_pelayanan_$table_identity.id
		JOIN unsur_pelayanan_$table_identity ON pertanyaan_unsur_pelayanan_$table_identity.id_unsur_pelayanan = unsur_pelayanan_$table_identity.id
		JOIN survey_$table_identity ON jawaban_pertanyaan_harapan_$table_identity.id_responden = survey_$table_identity.id_responden
		WHERE survey_$table_identity.is_submit = 1 GROUP BY id_sub
		ORDER BY SUBSTR(nomor_unsur,2) + 0");



		return view('olah_data/index', $this->data);
	}

	public function ajax_list()
	{
		$slug = $this->uri->segment(2);

		$get_identity = $this->db->get_where('manage_survey', ['slug' => "$slug"])->row();
		$table_identity = $get_identity->table_identity;

		// $jawaban_unsur = $this->db->get("jawaban_pertanyaan_unsur_$table_identity");

		$jawaban_unsur = $this->db->query("SELECT *
		FROM jawaban_pertanyaan_unsur_$table_identity
		JOIN pertanyaan_unsur_pelayanan_$table_identity ON jawaban_pertanyaan_unsur_$table_identity.id_pertanyaan_unsur = pertanyaan_unsur_pelayanan_$table_identity.id
		JOIN unsur_pelayanan_$table_identity ON pertanyaan_unsur_pelayanan_$table_identity.id_unsur_pelayanan = unsur_pelayanan_$table_identity.id
		ORDER BY SUBSTR(nomor_unsur, 2) + 0");

		$list = $this->models->get_datatables($table_identity);
		$data = array();
		$no = $_POST['start'];

		foreach ($list as $value) {

			$no++;
			$row = array();
			$row[] = $no;
			$row[] = 'Responden ' . $no;

			foreach ($jawaban_unsur->result() as $get_unsur) {
				if ($get_unsur->id_responden == $value->id_responden) {
					$row[] = $get_unsur->skor_jawaban;
				}
			}

			$data[] = $row;
		}

		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->models->count_all($table_identity),
			"recordsFiltered" => $this->models->count_filtered($table_identity),
			"data" => $data,
		);

		echo json_encode($output);
	}
}

/* End of file DataPerolehanSurveiController.php */
/* Location: ./application/controllers/DataPerolehanSurveiController.php */
