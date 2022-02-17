<?php
/**
 * @property CI_Loader $load
 * @property CI_URI $uri
 * @property CI_Form_validation $form_validation
 * @property CI_Input $input
 * @property CI_Email $email
 * @property CI_DB_active_record $db
 * @property CI_DB_forge $dbforge
 * @property CI_Session $session
 */

class Destaques extends Controller {

	function __construct() {
		parent::Controller();
        if (!$this->session->userdata('is_logged_in')) redirect('administracao/access');

		$this->load->model('administracao/destaques_model');
		$this->load->model('administracao/obras_model');
	}

	function index() {
		redirect('administracao/destaques/principal');
	}

	function principal() {
		$this->session->set_userdata('referrer','principal');
		$this->session->set_userdata('page_title','Administração | Destaques - Principal');
		$data['destaques'] = $this->destaques_model->listar();

		$data['menu'] = buildMenu('destaques');
		$data['main_content'] = 'administracao/destaques_view';
		$this->load->view('administracao/includes/template', $data);
	}

	function realizadas() {
		$this->session->set_userdata('referrer','realizadas');
		$this->session->set_userdata('page_title','Administração | Destaques - Obras Realizadas');
		$data['destaques'] = $this->destaques_model->listar('',FALSE,TRUE);

		$data['menu'] = buildMenu('destaques');
		$data['main_content'] = 'administracao/destaques_view';
		$this->load->view('administracao/includes/template', $data);
	}

	function em_andamento() {
		$this->session->set_userdata('referrer','em_andamento');
		$this->session->set_userdata('page_title','Administração | Destaques - Obras Em Andamento');
		$data['destaques'] = $this->destaques_model->listar('',FALSE,FALSE);

		$data['menu'] = buildMenu('destaques');
		$data['main_content'] = 'administracao/destaques_view';
		$this->load->view('administracao/includes/template', $data);
	}

	function adicionar(){
		if (!$this->input->post('enviar')) {
			$obras = $this->obras_model->listarTodas();

			foreach($obras->result() as $obra) {
				$data['obras'][$obra->idObra] = ($obra->realizada == 1 ? 'Obra Realizada':'Obra Em Andamento').' - '.$obra->titulo;
			}

			$data['menu'] = buildMenu('destaques');
			$data['main_content'] = 'administracao/destaques_add_view';
			$this->load->view('administracao/includes/template', $data);
		} else {
			if ($this->_upload((int)$this->input->post('principal'))){
				$this->destaques_model->adicionar();

				redirect('administracao/destaques/'.$this->session->userdata('referrer'));
			} else {
				echo show_error($this->upload->display_errors());
			}
		}
	}

	function editar() {
		if (!$this->input->post('enviar')) {
			$data['destaque'] = $this->destaques_model->listar($this->uri->segment(4),FALSE)->row();

			foreach ($this->obras_model->listarTodas()->result() as $obra) {
				$data['obras'][$obra->idObra] = ($obra->realizada == 1 ? 'Obra Realizada':'Obra Em Andamento').' - '.$obra->titulo;
			}

			$data['menu'] = buildMenu('destaques');
			$data['main_content'] = 'administracao/destaques_add_view';
			$this->load->view('administracao/includes/template', $data);
		} else {
			if ($this->_upload((int)$this->input->post('principal'))) {
				$this->destaques_model->editar();

				redirect('administracao/destaques/'.$this->session->userdata('referrer'));
			} else {
				echo show_error($this->upload->display_errors());
			}
		}
	}

	function _upload($principal = 1) {
		$config = Array(
			'file_name'		=> url_title(substr($_FILES['userfile']['name'],0, strlen($_FILES['userfile']['name'])-4),'underscore',TRUE),
			'upload_path'	=> 'images/destaques',
			'allowed_types'	=> 'jpg|jpeg|png',
			'remove_spaces'	=> TRUE,
			'max_size'		=> 5120,
			'overwrite'		=> TRUE
		);


		$this->load->library('upload', $config);

		if (!$this->upload->do_upload()) {
			$error = array('error' => $this->upload->display_errors());
			$this->session->set_flashdata('upload_errors', $this->upload->display_errors());
			return FALSE;
		} else {
			$path = "images/destaques";
			$upload_data = $this->upload->data();
//			$thumb_config = Array(
//				'source_image' => $upload_data['full_path'],
//				'maintain_ratio' => FALSE,
//			);
//
			if ($principal === 1) {
				$width = 830;
				$height = 310;
			} else if ($principal === 0) {
				$width = 300;
				$height = 180;
			}
//
//			$this->load->library('image_lib', $thumb_config);
//			$this->image_lib->resize();

			$this->load->helper('cropper');

			$thumb_data = cropper($upload_data['raw_name'], $upload_data['file_ext'], $path, $width, $height, FALSE, TRUE);

			return TRUE;
		}
	}

	function apagar(){
		if ($this->destaques_model->apagar()) {
			redirect('administracao/destaques/'.$this->session->userdata('referrer'));
		} else {
			show_error('Houve um erro durante a tentativa de excluir este destaque', 500);
		}
	}

}