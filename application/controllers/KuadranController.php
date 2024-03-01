<?php
defined('BASEPATH') or exit('No direct script access allowed');

class KuadranController extends Client_Controller
{

	public function __construct()
	{
		parent::__construct();

		if (!$this->ion_auth->logged_in()) {
			$this->session->set_flashdata('message_warning', 'You must be an admin to view this page');
			redirect('auth', 'refresh');
		}
	}

	public function index($id1, $id2)
	{
		$this->data = [];
		$this->data['title'] = "Kuadran";
		$this->data['profiles'] = Client_Controller::_get_data_profile($id1, $id2);

		$this->db->select('manage_survey.id AS id_manage_survey, manage_survey.table_identity AS table_identity, manage_survey.id_jenis_pelayanan AS id_jenis_pelayanan');
		$this->db->from('manage_survey');
		$this->db->where('manage_survey.slug', $this->uri->segment(2));
		$manage_survey = $this->db->get()->row();
		$table_identity = $manage_survey->table_identity;


		if ($this->db->get_where("survey_$table_identity", ['is_submit'=> 1])->num_rows() == 0) {
			$this->data['pesan'] = 'survei belum dimulai atau belum ada responden !';
			return view('not_questions/index', $this->data);
			exit();	
		}


		//NILAI PER UNSUR
		$this->data['unsur'] = $this->db->query("SELECT IF(id_parent = 0, unsur_pelayanan_$table_identity.id, unsur_pelayanan_$table_identity.id_parent) AS id_sub,
		(SELECT nomor_unsur FROM unsur_pelayanan_$table_identity WHERE id_sub = unsur_pelayanan_$table_identity.id) as nomor_unsur,
		(SELECT nama_unsur_pelayanan FROM unsur_pelayanan_$table_identity WHERE id_sub = unsur_pelayanan_$table_identity.id) as nama_unsur_pelayanan,
		AVG(IF(jawaban_pertanyaan_unsur_$table_identity.skor_jawaban != 0, skor_jawaban, NULL)) AS nilai_per_unsur

		FROM jawaban_pertanyaan_unsur_$table_identity
		JOIN pertanyaan_unsur_pelayanan_$table_identity ON jawaban_pertanyaan_unsur_$table_identity.id_pertanyaan_unsur = pertanyaan_unsur_pelayanan_$table_identity.id
		JOIN unsur_pelayanan_$table_identity ON pertanyaan_unsur_pelayanan_$table_identity.id_unsur_pelayanan = unsur_pelayanan_$table_identity.id
		JOIN survey_$table_identity ON jawaban_pertanyaan_unsur_$table_identity.id_responden = survey_$table_identity.id_responden
		WHERE survey_$table_identity.is_submit = 1 GROUP BY id_sub
		ORDER BY SUBSTR(nomor_unsur,2) + 0");

		

		$nilai_unsur = 0;
		foreach ($this->data['unsur']->result() as $values) {
			$array_unsur[] = $values->nilai_per_unsur;
			$nilai_unsur = array_sum($array_unsur) / count($array_unsur);
		}


		//NILAI PER HARAPAN
		$this->data['harapan'] = $this->db->query("SELECT IF(id_parent = 0, unsur_pelayanan_$table_identity.id, unsur_pelayanan_$table_identity.id_parent) AS id_sub,
		(SELECT nomor_unsur FROM unsur_pelayanan_$table_identity WHERE id_sub = unsur_pelayanan_$table_identity.id) as nomor_unsur,
		(SELECT nama_unsur_pelayanan FROM unsur_pelayanan_$table_identity WHERE id_sub = unsur_pelayanan_$table_identity.id) as nama_unsur_pelayanan,
		AVG(IF(jawaban_pertanyaan_harapan_$table_identity.skor_jawaban != 0, skor_jawaban, NULL)) AS nilai_per_unsur


		FROM jawaban_pertanyaan_harapan_$table_identity
		JOIN pertanyaan_unsur_pelayanan_$table_identity ON jawaban_pertanyaan_harapan_$table_identity.id_pertanyaan_unsur = pertanyaan_unsur_pelayanan_$table_identity.id
		JOIN unsur_pelayanan_$table_identity ON pertanyaan_unsur_pelayanan_$table_identity.id_unsur_pelayanan = unsur_pelayanan_$table_identity.id
		JOIN survey_$table_identity ON jawaban_pertanyaan_harapan_$table_identity.id_responden = survey_$table_identity.id_responden
		WHERE survey_$table_identity.is_submit = 1 GROUP BY id_sub
		ORDER BY SUBSTR(nomor_unsur,2) + 0");

		$nilai_harapan = 0;
		foreach ($this->data['harapan']->result() as $rows) {
			$array_harapan[] = $rows->nilai_per_unsur;
			$nilai_harapan = array_sum($array_harapan) / count($array_harapan);
		}
		


		

		$this->data['total_rata_unsur'] = $nilai_unsur;
		$this->data['total_rata_harapan'] = $nilai_harapan;
		$this->data['grafik'] =  $this->db->query("SELECT *,
		(CASE
			WHEN kup.skor_unsur <= $nilai_unsur && kup.skor_harapan >= $nilai_harapan
					THEN 1
			WHEN kup.skor_unsur >= $nilai_unsur && kup.skor_harapan >= $nilai_harapan
					THEN 2
				WHEN kup.skor_unsur <= $nilai_unsur && kup.skor_harapan <= $nilai_harapan
					THEN 3
				WHEN kup.skor_unsur >= $nilai_unsur && kup.skor_harapan <= $nilai_harapan
					THEN 4
			ELSE 0
		END) AS kuadran
		
		FROM (
			SELECT IF(id_parent = 0,unsur_pelayanan_$table_identity.id, unsur_pelayanan_$table_identity.id_parent) AS id_sub,
			(SELECT nomor_unsur FROM unsur_pelayanan_$table_identity WHERE id_sub = unsur_pelayanan_$table_identity.id) AS nomor_unsur,
			(SELECT nama_unsur_pelayanan FROM unsur_pelayanan_$table_identity WHERE id_sub = unsur_pelayanan_$table_identity.id) AS nama_unsur_pelayanan,

			(SELECT AVG(IF(jawaban_pertanyaan_unsur_$table_identity.skor_jawaban != 0, skor_jawaban, NULL)) FROM jawaban_pertanyaan_unsur_$table_identity
			JOIN survey_$table_identity ON jawaban_pertanyaan_unsur_$table_identity.id_responden = survey_$table_identity.id_responden WHERE is_submit = 1 && pertanyaan_unsur_pelayanan_$table_identity.id = jawaban_pertanyaan_unsur_$table_identity.id_pertanyaan_unsur) AS skor_unsur,

			(SELECT AVG(IF(jawaban_pertanyaan_harapan_$table_identity.skor_jawaban != 0, skor_jawaban, NULL))FROM jawaban_pertanyaan_harapan_$table_identity JOIN survey_$table_identity ON jawaban_pertanyaan_harapan_$table_identity.id_responden = survey_$table_identity.id_responden WHERE is_submit = 1 && pertanyaan_unsur_pelayanan_$table_identity.id = jawaban_pertanyaan_harapan_$table_identity.id_pertanyaan_unsur) AS skor_harapan

			FROM pertanyaan_unsur_pelayanan_$table_identity
			JOIN unsur_pelayanan_$table_identity ON pertanyaan_unsur_pelayanan_$table_identity.id_unsur_pelayanan = unsur_pelayanan_$table_identity.id
			GROUP BY id_sub
			ORDER BY SUBSTR(nomor_unsur,2) + 0
		) AS kup");
		// var_dump($this->data['grafik']->result());

		return view('kuadran/index', $this->data);
	}

	public function convert_kuadran()
	{
		$slug = $this->uri->segment(2);
		$manage_survey = $this->db->get_where('manage_survey', array('slug' => $this->uri->segment(2)))->row();

		$img = $_POST['imgBase64'];
		$img = str_replace('data:image/png;base64,', '', $img);
		$img = str_replace(' ', '+', $img);
		$fileData = base64_decode($img);
		$fileName = 'assets/klien/img_kuadran/kuadran-' . $manage_survey->table_identity . '.png';
		file_put_contents($fileName, $fileData);

		$data = [
			'atribut_kuadran' => serialize(array('kuadran-' . $manage_survey->table_identity . '.png', date("d/m/Y")))
		];
		$this->db->where('slug', $slug);
		$this->db->update('manage_survey', $data);

		// $coba = unserialize($data);
		// var_dump($coba[1]);

	}
}

/* End of file KuadranController.php */
/* Location: ./application/controllers/KuadranController.php */
