<?php

/**
 * @property CI_Loader $load
 * @property CI_URI $uri
 * @property CI_Form_validation $form_validation
 * @property CI_Input $input
 * @property CI_Email $email
 * @property CI_DB_active_record $db
 * @property CI_DB_forge $dbforge
 */
class Certificacoes extends Controller {

	function __construct() {
		parent::Controller();
		if (!$this->session->userdata('is_logged_in')) redirect('administracao/access');
		$this->load->model('administracao/certificacoes_model');
	}

	function index() {
		$this->session->set_userdata('page_title', 'Administração | Certificações');
		$data['menu'] = buildMenu('certificacoes', 'Certificações');
		$data['registros'] = $this->certificacoes_model->listarCertificacoes();
		$data['main_content'] = 'administracao/certificacoes_view';
		$this->load->view('administracao/includes/template', $data);
	}

	function adicionar() {
		$this->load->view('administracao/certificacoes_ajax_view');
	}

	function editar() {
		$query = $this->certificacoes_model->listarCertificacoes($this->uri->segment(4));
		$data['linha'] = $query->row_array();
		$this->load->view('administracao/certificacoes_ajax_view', $data);
	}

	function apagar() {
		if ($this->certificacoes_model->apagar($this->uri->segment(4))) {
			redirect('administracao/certificacoes');
		}
	}

	function implantar() {
		if ($this->uri->segment(5) == 'nao') {
			if ($this->certificacoes_model->implantar()) {
				redirect('administracao/certificacoes');
			}
		} elseif ($this->uri->segment(5) == 'sim') {
			if ($this->certificacoes_model->implantar()) {
				redirect('administracao/certificacoes');
			}
		}
	}

	function salvar() {
		$action = $this->input->post('action');
		$id = $this->input->post('id');
		$this->load->library('form_validation');

		$this->form_validation->set_rules('codigo', 'Código', 'trim|required|min_length[5]');
		$this->form_validation->set_rules('implantada', 'Implantada', 'trim|required');

		if ($this->form_validation->run() == FALSE) {
			$this->session->set_flashdata('validation_errors', validation_errors('<p class="error">'));
			if ($action != 'editar') {
				redirect('administracao/certificacoes/'.$action);
			} else {
				redirect('administracao/certificacoes/'.$action.'/'.$id);
			}

		} else {
			if ($this->certificacoes_model->$action()){
				redirect('administracao/certificacoes');
			} else {
				if ($action != 'editar') {
					redirect('administracao/certificacoes/'.$action);
				} else {
					redirect('administracao/certificacoes/'.$action.'/'.$id);
				}
			}
		}

	}

}