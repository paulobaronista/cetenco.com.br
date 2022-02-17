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

class Tipos extends Controller {

	function __construct() {
		parent::Controller();
		if (!$this->session->userdata('is_logged_in')) redirect('administracao/access');
		$this->load->model('administracao/tipos_model');
		$this->load->model('administracao/categorias_model');
	}

	function index() {
		$this->session->set_userdata('page_title','Administração | Tipos');

		$data['menu'] = buildMenu('tipos');
		$data['registros'] = $this->tipos_model->listarTipos();
		$data['main_content'] = 'administracao/tipos_view';

		$this->load->view('administracao/includes/template', $data);
	}

	function adicionar() {
		foreach($this->categorias_model->listarCategorias()->result() as $linha) {
			$data['categorias'][$linha->idCategoria] = $linha->categoria;
		}

		$data['menu'] = buildMenu('tipos');
		$data['main_content'] = 'administracao/tipos_ajax_view';
		$this->load->view('administracao/includes/template', $data);
	}

	function editar() {
		foreach($this->categorias_model->listarCategorias()->result() as $linha) {
			$data['categorias'][$linha->idCategoria] = $linha->categoria;
		}
		$query = $this->tipos_model->listarTipos($this->uri->segment(4));
		$data['linha'] = $query->result();
		
		$data['menu'] = buildMenu('tipos');
		$data['main_content'] = 'administracao/tipos_ajax_view';
		$this->load->view('administracao/includes/template', $data);
	}

	function apagar() {
		if ($this->tipos_model->apagar($this->uri->segment(4))) {
			redirect('administracao/tipos');
		}
	}

	function salvar() {
		$action = $this->input->post('action');
		$id = $this->input->post('id');

		if ($this->tipos_model->$action()){
			redirect('administracao/tipos');
		} else {
//				redirect('administracao/tipos');
		}

	}

}