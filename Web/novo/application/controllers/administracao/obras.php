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
class Obras extends Controller {

	function __construct() {
		parent::Controller();
		if (!$this->session->userdata('is_logged_in')) redirect('administracao/access');
		$this->load->model('administracao/obras_model');
		$this->load->model('administracao/categorias_model');
		$this->load->model('administracao/tipos_model');
		$this->load->model('administracao/sessoes_model');
		$this->load->model('administracao/fotos_model');
		$this->load->model('administracao/mural_model');
		$this->load->helper('date');
	}

	function index() {
		redirect('administracao/obras/realizadas');
	}
	
	function realizadas() {
		$this->session->set_userdata('page_title', 'Administração | Obras');
		if (!$this->uri->segment(4)) {
			$data['registros'] = $this->obras_model->listarObras('','realizadas');
		} else {
			$data['registros'] = $this->obras_model->listarObras('','realizadas',$this->uri->segment(4));
		}

		$data['categorias'][] = '-- ESCOLHA UMA CATEGORIA --';
		foreach($this->obras_model->ler_categorias()->result() as $categoria) {
			$data['categorias'][$categoria->idCategoria] = $categoria->categoria;
		}

		$data['menu'] = buildMenu('obras');
		$data['main_content'] = 'administracao/obras_view';
		$this->load->view('administracao/includes/template', $data);
	}

	function em_andamento(){
		$this->session->set_userdata('page_title', 'Administração | Obras');
		$data['registros'] = $this->obras_model->listarObras('','andamento');
		$data['menu'] = buildMenu('obras');
		$data['main_content'] = 'administracao/obras_view';
		$this->load->view('administracao/includes/template', $data);
	}

	function adicionar() {
		foreach($this->categorias_model->listarCategorias()->result() as $categoria) {
			$data['categorias'][$categoria->idCategoria] = $categoria->categoria;
		}

		$data['tipos'][0] = 'NÃO APLICÁVEL';
		foreach($this->tipos_model->listarTipos()->result() as $tipo) {
			$data['tipos'][$tipo->idTipo] = $tipo->tipo;
		}
		
		$data['menu'] = buildMenu('obras');
		$data['main_content'] = 'administracao/obras_add_view';
		$this->load->view('administracao/includes/template', $data);
	}

	function editar() {
		$obra = $this->uri->segment(4);
		foreach($this->categorias_model->listarCategorias()->result() as $categoria) {
			$data['categorias'][$categoria->idCategoria] = $categoria->categoria;
		}

		$data['tipos'][0] = 'NÃO APLICÁVEL';
		foreach($this->tipos_model->listarTipos()->result() as $tipo) {
			$data['tipos'][$tipo->idTipo] = $tipo->tipo;
		}

		$data['fotos'] = $this->fotos_model->listarFotos($obra)->result();
		$data['menu'] = buildMenu('obras');
		$obra_dados = $this->obras_model->listarObras($this->uri->segment(4));
		$data['obra'] = $obra_dados->obra->row();
		$data['obra_desc'] = $obra_dados->obra_desc;
		$data['main_content'] = 'administracao/obras_add_view';
		$this->load->view('administracao/includes/template', $data);
	}

	function apagar() {
		if ($this->obras_model->apagar($this->uri->segment(4))) {
			redirect('administracao/obras');
		}
	}

	function publicar() {
		if ($this->obras_model->publicar($this->uri->segment(4))) {
			redirect('administracao/obras');
		}
	}

	function despublicar() {
		if ($this->obras_model->despublicar($this->uri->segment(4))) {
			redirect('administracao/obras');
		}
	}

	function salvar() {
		$action = $this->input->post('action');
		$id = $this->input->post('id');
		
		if ($this->obras_model->$action()){
			redirect('administracao/obras');
		} else {
			show_error('ERRO',500);
//				if ($action != 'editar') {
//					redirect('administracao/obras/'.$action);
//				} else {
//					redirect('administracao/obras/'.$action.'/'.$id);
//				}
		}

	}

	function upload() {
		$config = Array(
			'upload_path'	=>	'images',
			'allowed_types'	=>	'jpg|jpeg|gif|png',
			'remove_spaces'	=>	'TRUE',
			'max_size'		=>	'5120',
			'overwrite'		=>	'TRUE'
		);


		$this->load->library('upload', $config);

		if (!$this->upload->do_upload()) {
			$error = array('error' => $this->upload->display_errors());
			$this->session->set_flashdata('upload_errors', $this->upload->display_errors());
			redirect('administracao/obras');
		} else {
			$upload_data = $this->upload->data();
			$thumb_config = Array(
				'source_image'		=>	$upload_data['full_path'],
				'new_image'			=>	'images/thumbs',
				'maintain_ratio'	=>	TRUE,
				'create_thumb'		=>	TRUE,
				'width'				=>	100,
				'height'			=>	100
			);

			$this->load->library('image_lib', $thumb_config);
			$this->image_lib->resize();

			$this->fotos_model->gravar($upload_data);

			//redirect('administracao/obras');
		}
	}

}