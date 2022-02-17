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

class Textos extends Controller {

	function __construct() {
		parent::Controller();
        if (!$this->session->userdata('is_logged_in')) redirect('administracao/access');
		$this->load->model('administracao/textos_model');
		$this->load->model('administracao/sessoes_model');
		$this->load->helper('ckeditor');

		//Ckeditor's configuration
		$this->ckeditor = array(

			//ID of the textarea that will be replaced
			'id' 	=> 	'conteudo', 	// Must match the textarea's id
			'path'	=>	'includes/js/ckeditor',	// Path to the ckeditor folder relative to index.php

			//Optionnal values
			'config' => array(
				'toolbar'	=>	"Full",		//Using the Full toolbar
				'width'		=>	"99%",		//Setting a custom width
				'height'	=>	'300px',	//Setting a custom height

			)
		);
	}

	function index() {
		$this->session->set_userdata('page_title','Administração | Textos');

		$data['menu'] = buildMenu('textos');
		$data['registros'] = $this->textos_model->listarTextos();
		$data['main_content'] = 'administracao/textos_view';

		$this->load->view('administracao/includes/template', $data);
	}

	function adicionar() {
		$data['ckeditor'] = $this->ckeditor;

		foreach($this->sessoes_model->listarSessoes()->result() as $sessao) {
			$data['sessoes'][$sessao->idSessao] = $sessao->nome;
		}

		$data['menu'] = buildMenu('textos');
		$data['main_content'] = 'administracao/textos_add_view';
		$this->load->view('administracao/includes/template', $data);
	}

	function editar() {
		$data['ckeditor'] = $this->ckeditor;

		foreach($this->sessoes_model->listarSessoes()->result() as $sessao) {
			$data['sessoes'][$sessao->idSessao] = $sessao->nome;
		}
		$data['menu'] = buildMenu('textos');
		$query = $this->textos_model->listarTextos($this->uri->segment(4));
		$data['linha'] = $query->row_array();
		$data['main_content'] = 'administracao/textos_add_view';
		$this->load->view('administracao/includes/template', $data);
	}

	function apagar() {
		if ($this->textos_model->apagar($this->uri->segment(4))) {
			redirect('administracao/textos');
		}
	}

	function publicar() {
		if ($this->textos_model->publicar($this->uri->segment(4))) {
			redirect('administracao/textos');
		}
	}

	function despublicar() {
		if ($this->textos_model->despublicar($this->uri->segment(4))) {
			redirect('administracao/textos');
		}
	}

	function salvar() {
		$action = $this->input->post('action');
		$id = $this->input->post('id');
		$this->load->library('form_validation');

		$this->form_validation->set_rules('titulo', 'Título', 'trim|required|min_length[10]');
		$this->form_validation->set_rules('conteudo', 'Conteúdo', 'trim|required');

		if ($this->form_validation->run() == FALSE) {
			$this->session->set_flashdata('validation_errors', validation_errors('<p class="error">'));
			if ($action != 'editar') {
				redirect('administracao/textos/'.$action);
			} else {
				redirect('administracao/textos/'.$action.'/'.$id);
			}

		} else {
			if ($this->textos_model->$action()){
				redirect('administracao/textos');
			} else {
				if ($action != 'editar') {
					redirect('administracao/textos/'.$action);
				} else {
					redirect('administracao/textos/'.$action.'/'.$id);
				}
			}
		}

	}

}