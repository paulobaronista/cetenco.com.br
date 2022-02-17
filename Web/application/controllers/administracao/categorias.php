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

class Categorias extends Controller {

	function __construct() {
		parent::Controller();
		if (!$this->session->userdata('is_logged_in')) redirect('administracao/access');
		$this->load->model('administracao/categorias_model');
	}

	function index() {
		$this->session->set_userdata('page_title','Administração | Categorias');

		$data['menu'] = buildMenu('categorias');
		$data['registros'] = $this->categorias_model->listarCategorias();
		$data['main_content'] = 'administracao/categorias_view';
		
		$this->load->view('administracao/includes/template', $data);
	}

	function adicionar() {
//		$data['menu'] = buildMenu('categorias');
//		$data['main_content'] = 'administracao/categorias_add_view';
//		$this->load->view('administracao/includes/template', $data);
		$this->load->view('administracao/categorias_ajax_view');
	}

	function editar() {
//		$data['menu'] = buildMenu('categorias');
		$query = $this->categorias_model->listarCategorias($this->uri->segment(4));
		$data['linha'] = $query->result();
//		$data['main_content'] = 'administracao/categorias_add_view';
//		$this->load->view('administracao/includes/template', $data);
		$this->load->view('administracao/categorias_ajax_view', $data);
	}

	function apagar() {
		if ($this->categorias_model->apagar($this->uri->segment(4))) {
			redirect('administracao/categorias');
		}
	}

	function salvar() {
		$action = $this->input->post('action');
		$id = $this->input->post('id');
		if ($this->categorias_model->$action()){
			redirect('administracao/categorias');
		} else {
//			redirect('administracao/categorias');
		}
	}

}