<?php
defined('BASEPATH') or exit('No direct script access allowed');

class SettingFormSurveiController extends Client_Controller
{

	public function __construct()
	{
		parent::__construct();

		if (!$this->ion_auth->logged_in()) {
			$this->session->set_flashdata('message_warning', 'You must be an admin to view this page');
			redirect('auth', 'refresh');
		}

		$this->load->library('form_validation');
		$this->load->model('PertanyaanUnsurSurvei_model');
		$this->load->library('uuid');
	}

	public function index($id1, $id2)
	{
		$this->data = [];
		$this->data['title'] = 'Form Survei';
		$this->data['profiles'] = Client_Controller::_get_data_profile($id1, $id2);

		$this->data['data_user'] = $this->ion_auth->user()->row();

		$slug = $this->uri->segment('2');

		$this->db->select('*');
		$this->db->from('manage_survey');
		$this->db->where("slug = '$slug'");
		$this->data['manage_survey'] = $this->db->get()->row();

		$this->data['id_manage_survey'] = $this->data['manage_survey']->id;
		$this->data['atribut_pertanyaan_survey'] = unserialize($this->data['manage_survey']->atribut_pertanyaan_survey);


		return view('setting_form_survei/index', $this->data);
	}


	public function form_judul($id1, $id2)
	{
		$this->data = [];
		$this->data['title'] = 'Form Survei';
		$this->data['profiles'] = Client_Controller::_get_data_profile($id1, $id2);

		$this->data['data_user'] = $this->ion_auth->user()->row();

		$slug = $this->uri->segment('2');

		$this->db->select('*');
		$this->db->from('manage_survey');
		$this->db->where("slug = '$slug'");
		$this->data['manage_survey'] = $this->db->get()->row();

		return view('setting_form_survei/form_judul', $this->data);
	}


	public function form_pembuka($id1, $id2)
	{
		$this->data = [];
		$this->data['title'] = 'Form Survei';
		$this->data['profiles'] = Client_Controller::_get_data_profile($id1, $id2);

		$this->data['data_user'] = $this->ion_auth->user()->row();

		$slug = $this->uri->segment('2');

		$this->db->select('*');
		$this->db->from('manage_survey');
		$this->db->where("slug = '$slug'");
		$this->data['manage_survey'] = $this->db->get()->row();

		return view('setting_form_survei/form_pembuka', $this->data);
	}

	public function form_benner($id1, $id2)
	{
		$this->data = [];
		$this->data['title'] = 'Form Survei';
		$this->data['profiles'] = Client_Controller::_get_data_profile($id1, $id2);

		$this->data['data_user'] = $this->ion_auth->user()->row();

		$slug = $this->uri->segment('2');

		$this->db->select('*');
		$this->db->from('manage_survey');
		$this->db->where("slug = '$slug'");
		$this->data['manage_survey'] = $this->db->get()->row();

		return view('setting_form_survei/form_benner', $this->data);
	}


	public function form_font_text($id1, $id2)
	{
		$this->data = [];
		$this->data['title'] = 'Form Survei';
		$this->data['profiles'] = Client_Controller::_get_data_profile($id1, $id2);

		$this->data['data_user'] = $this->ion_auth->user()->row();

		$slug = $this->uri->segment('2');

		$this->db->select('*');
		$this->db->from('manage_survey');
		$this->db->where("slug = '$slug'");
		$this->data['manage_survey'] = $this->db->get()->row();

		return view('setting_form_survei/form_font_text', $this->data);
	}


	public function form_tombol($id1, $id2)
	{
		$this->data = [];
		$this->data['title'] = 'Form Survei';
		$this->data['profiles'] = Client_Controller::_get_data_profile($id1, $id2);

		$this->data['data_user'] = $this->ion_auth->user()->row();

		$slug = $this->uri->segment('2');

		$this->db->select('*');
		$this->db->from('manage_survey');
		$this->db->where("slug = '$slug'");
		$this->data['manage_survey'] = $this->db->get()->row();

		return view('setting_form_survei/form_tombol', $this->data);
	}


	public function form_saran($id1, $id2)
	{
		$this->data = [];
		$this->data['title'] = 'Form Survei';
		$this->data['profiles'] = Client_Controller::_get_data_profile($id1, $id2);

		$this->data['data_user'] = $this->ion_auth->user()->row();

		$slug = $this->uri->segment('2');

		$this->db->select('*');
		$this->db->from('manage_survey');
		$this->db->where("slug = '$slug'");
		$this->data['manage_survey'] = $this->db->get()->row();

		return view('setting_form_survei/form_saran', $this->data);
	}


	public function form_penutup($id1, $id2)
	{
		$this->data = [];
		$this->data['title'] = 'Form Survei';
		$this->data['profiles'] = Client_Controller::_get_data_profile($id1, $id2);

		$this->data['data_user'] = $this->ion_auth->user()->row();

		$slug = $this->uri->segment('2');

		$this->db->select('*');
		$this->db->from('manage_survey');
		$this->db->where("slug = '$slug'");
		$this->data['manage_survey'] = $this->db->get()->row();

		return view('setting_form_survei/form_penutup', $this->data);
	}

	
	
}

/* End of file PertanyaanKualitatifController.php */
/* Location: ./application/controllers/PertanyaanKualitatifController.php */