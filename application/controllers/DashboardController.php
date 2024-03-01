<?php
defined('BASEPATH') or exit('No direct script access allowed');

class DashboardController extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();

		$this->load->library('ion_auth');

		if (!$this->ion_auth->logged_in()) {
			$this->session->set_flashdata('message_warning', 'You must be logged in to access this page');
			redirect('auth', 'refresh');
		}
		$this->load->model('ManageSurvey_model', 'models');
	}

	public function index()
	{
		$this->data = [];
		$this->data['title'] = 'Dashboard';


		return view('dashboard/index', $this->data);
	}

	public function jumlah_survei()
	{
		$user_id = $this->session->userdata('user_id');

		$this->db->select('COUNT(id) AS jumlah_survei');
		$query = $this->db->get_where('manage_survey', ['id_user' => $user_id])->row();

		$this->data = [];
		$this->data['jumlah_survei'] = $query->jumlah_survei;


		return view('dashboard/jumlah_survei', $this->data);
		// echo json_encode($data);
	}

	public function prosedur_aplikasi()
	{
		$this->data = [];
		$this->data['title'] = 'Prosedur Penggunaan Aplikasi';
		
		$this->load->library('session');
		//$this->load->helper('cookie');
		//set_cookie('cookie_name','ronaldo','3600'); 
		$this->session->set_userdata('nameshare','bambang pamungkas');
		$this->session->set_userdata('some_name', 'lionel messi');
		//$this->session->unset_userdata('nameshare');


		return view('dashboard/prosedur_aplikasi', $this->data);
	}


	public function get_chart_survei()
	{
		$this->data = [];
		$this->data['title'] = 'Dashboard Chart';

		$manage_survey = $this->db->get_where("manage_survey", array('id_user' => $this->session->userdata('user_id')));

		$users_groups = $this->db->get_where("users_groups", array('user_id' => $this->session->userdata('user_id')))->row();
		
		$users = $this->db->get_where("users", array('id' => $this->session->userdata('user_id')))->row();
		$this->data['klien'] = $users->first_name.' '.$users->last_name;

		if ($users_groups->group_id == 2) {
			$this->db->select('*, manage_survey.slug AS slug_manage_survey');
			$this->db->from('manage_survey');
			$this->db->where('id_user', $this->session->userdata('user_id'));
		} else {
			$data_user = $this->db->get_where("users", array('id' => $this->session->userdata('user_id')))->row();

			$this->db->select('*, manage_survey.slug AS slug_manage_survey');
			$this->db->from('manage_survey');
			$this->db->join("supervisor_drs$data_user->is_parent", "manage_survey.id_berlangganan = supervisor_drs$data_user->is_parent.id_berlangganan");
			$this->db->where("supervisor_drs$data_user->is_parent.id_user", $this->session->userdata('user_id'));
		}
		$this->db->order_by('manage_survey.id', 'DESC');
		$this->db->limit(10);
		$manage_survey = $this->db->get();

		if ($manage_survey->num_rows() > 0) {

			$no = 1;
			foreach ($manage_survey->result() as $value) {

				$skala_likert = (100 / ($value->skala_likert == 5 ? 5 : 4));
				$this->data['tahun_awal'] = $value->survey_year;
				$array_perolehan[] = '{ label: "' . $value->survey_name . '", value: "' . $this->db->get_where("survey_$value->table_identity", array('is_submit' => 1))->num_rows() . '" }';
				

				if ($this->db->get_where("survey_$value->table_identity", array('is_submit' => 1))->num_rows() > 0) {

					$nilai_tertimbang[$no] = $this->db->query("SELECT AVG(rata_rata) AS rata_rata
					FROM (
					SELECT IF(id_parent = 0,unsur_pelayanan_$value->table_identity.id, unsur_pelayanan_$value->table_identity.id_parent) AS id_sub,
					(SELECT nomor_unsur FROM unsur_pelayanan_$value->table_identity unsur_sub WHERE unsur_sub.id = id_sub) AS nomor_unsur,
					(SELECT nama_unsur_pelayanan FROM unsur_pelayanan_$value->table_identity unsur_sub WHERE unsur_sub.id = id_sub) AS nama_unsur_pelayanan,
					AVG(IF(jawaban_pertanyaan_unsur_$value->table_identity.skor_jawaban != 0, skor_jawaban, NULL)) AS rata_rata
					
					FROM jawaban_pertanyaan_unsur_$value->table_identity
					JOIN pertanyaan_unsur_pelayanan_$value->table_identity ON jawaban_pertanyaan_unsur_$value->table_identity.id_pertanyaan_unsur = pertanyaan_unsur_pelayanan_$value->table_identity.id
					JOIN unsur_pelayanan_$value->table_identity ON pertanyaan_unsur_pelayanan_$value->table_identity.id_unsur_pelayanan = unsur_pelayanan_$value->table_identity.id
					JOIN survey_$value->table_identity ON jawaban_pertanyaan_unsur_$value->table_identity.id_responden = survey_$value->table_identity.id_responden
					WHERE survey_$value->table_identity.is_submit = 1 GROUP BY id_sub
					) jpu_$value->table_identity")->row()->rata_rata;


					$new_chart[] = '{ label: "' . $value->survey_name . '", value: "' . ROUND($nilai_tertimbang[$no] * $skala_likert, 2) . '" }';
				} else {
					$new_chart[] = '{ label: "' . $value->survey_name . '", value: "0" }';
				};

				$no++;
			}
			$this->data['new_chart'] = implode(", ", $new_chart);
			$this->data['perolehan'] = implode(", ", $array_perolehan);
		} else {
			$this->data['new_chart'] = '{ label: "NULL", value: "0" }';
			$this->data['perolehan'] = '{ label: "NULL", value: "0" }';
		}
		return view("dashboard/chart_survei", $this->data);
	}

	public function get_tabel_survei()
	{
		$this->data = [];
		$this->data['title'] = 'Dashboard Tabel';

		return view("dashboard/tabel_survei", $this->data);
	}

	public function ajax_list_tabel_survei()
	{
		$this->db->select('*');
		$this->db->from('users');
		$this->db->join('users_groups', 'users.id = users_groups.user_id');
		$this->db->where('users.username', $this->session->userdata('username'));
		$data_user = $this->db->get()->row();

		$list = $this->models->get_datatables($data_user);
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $value) {

			$no++;
			$row = array();
			$skala_likert = (100 / ($value->skala_likert == 5 ? 5 : 4));

			if ($this->db->get_where("survey_$value->table_identity", array('is_submit' => 1))->num_rows() > 0) {

				$nilai_tertimbang[$no] = $this->db->query("SELECT AVG(rata_rata) AS rata_rata
					FROM (
					SELECT IF(id_parent = 0,unsur_pelayanan_$value->table_identity.id, unsur_pelayanan_$value->table_identity.id_parent) AS id_sub,
					(SELECT nomor_unsur FROM unsur_pelayanan_$value->table_identity unsur_sub WHERE unsur_sub.id = id_sub) AS nomor_unsur,
					(SELECT nama_unsur_pelayanan FROM unsur_pelayanan_$value->table_identity unsur_sub WHERE unsur_sub.id = id_sub) AS nama_unsur_pelayanan,
					AVG(IF(jawaban_pertanyaan_unsur_$value->table_identity.skor_jawaban != 0, skor_jawaban, NULL)) AS rata_rata
					
					FROM jawaban_pertanyaan_unsur_$value->table_identity
					JOIN pertanyaan_unsur_pelayanan_$value->table_identity ON jawaban_pertanyaan_unsur_$value->table_identity.id_pertanyaan_unsur = pertanyaan_unsur_pelayanan_$value->table_identity.id
					JOIN unsur_pelayanan_$value->table_identity ON pertanyaan_unsur_pelayanan_$value->table_identity.id_unsur_pelayanan = unsur_pelayanan_$value->table_identity.id
					JOIN survey_$value->table_identity ON jawaban_pertanyaan_unsur_$value->table_identity.id_responden = survey_$value->table_identity.id_responden
					WHERE survey_$value->table_identity.is_submit = 1 GROUP BY id_sub
					) jpu_$value->table_identity")->row()->rata_rata;
					
				$skor_akhir[$no] = ROUND($nilai_tertimbang[$no] * $skala_likert, 2);
			} else {
				$skor_akhir[$no] = 0;
			};


			foreach ($this->db->query("SELECT * FROM definisi_skala_$value->table_identity ORDER BY id DESC")->result() as $obj) {
				if ($skor_akhir[$no] <= $obj->range_bawah && $skor_akhir[$no] >= $obj->range_atas) {
					$kualitas_pelayanan[$no] = $obj->kategori;
					$mutu_pelayanan[$no] = ' - ' . $obj->mutu;
				}
			}
			if ($skor_akhir[$no] <= 0) {
				$kualitas_pelayanan[$no] = '';
				$mutu_pelayanan[$no] = '';
			}



			$row[] = $no;
			$row[] = $value->survey_name;
			$row[] = '<span class="badge badge-success">' . $this->db->get_where("survey_$value->table_identity", array('is_submit' => 1))->num_rows() . '</span>';
			$row[] = $skor_akhir[$no] . '' . $mutu_pelayanan[$no];
			// $row[] = $kualitas_pelayanan[$no];
			$row[] = '<a class="btn btn-light-primary btn-sm" data-toggle="modal"
			onclick="showedit(' . $value->id . ')" href="#modal_detail"><i class="fa fa-info-circle"></i> Detail</a>';

			$data[] = $row;
		}

		$output = array(
			"draw" 				=> $_POST['draw'],
			"recordsTotal" 		=> $this->models->count_all($data_user),
			"recordsFiltered" 	=> $this->models->count_filtered($data_user),
			"data" 				=> $data,
		);

		echo json_encode($output);
	}

	public function get_detail_hasil_analisa()
	{

		$this->data = [];
		$id_manage_survey = $this->uri->segment(4);
		$this->data['id_manage_survey'] = $id_manage_survey;

		$this->data['manage_survey'] = $this->db->get_where('manage_survey', array('id' => $id_manage_survey))->row();


		return view('dashboard/detail_hasil_analisa', $this->data);
	}
}

/* End of file DashboardController.php */
/* Location: ./application/controllers/DashboardController.php */
