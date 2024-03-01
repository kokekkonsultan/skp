<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Welcome extends CI_Controller
{

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{


		$table_identity = 'cst393';
		foreach($this->db->query("SELECT * FROM survey_$table_identity WHERE is_submit = 1")->result() as $i => $row){

			foreach($this->db->query("SELECT * FROM jawaban_pertanyaan_kualitatif_$table_identity
			WHERE id_responden = $row->id")->result() as $val){

				$array[$i][] = '<td>' . $val->isi_jawaban_kualitatif . '</td>';

			}

			$html[] = '<tr>' . implode("", $array[$i]) . '</tr>';

		}

		echo '<table>
				<tr>
					<th>1</th>
					<th>2</th>
					<th>3</th>
					<th>4</th>
					<th>5</th>
				</tr>'
				 . implode("", $html) . 
			'</table>';




		// return view('welcome_message');
	}
}
