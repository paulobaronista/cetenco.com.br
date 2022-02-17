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

class Usuarios extends Controller {

	function __construct() {
		parent::Controller();
		if (!$this->session->userdata('is_logged_in')) redirect('administracao/access');
		$this->load->model('administracao/usuarios_model');
		$this->load->model('administracao/grupos_model');
	}

	function index() {
		$this->session->set_userdata('page_title','Administração | Usuários');

		$data['menu'] = buildMenu('usuarios', 'Usuários');
		$data['registros'] = $this->usuarios_model->listarUsuarios();
		$data['main_content'] = 'administracao/usuarios_view';

		$this->load->view('administracao/includes/template', $data);
	}

	function adicionar() {
		foreach($this->grupos_model->listarGrupos()->result() as $linha) {
			$data['grupos'][$linha->idGrupo] = $linha->idGrupo;
		}
		$data['menu'] = buildMenu('usuarios', 'Usuários');
		$data['main_content'] = 'administracao/usuarios_add_view';
		$this->load->view('administracao/includes/template', $data);
	}

	function editar() {
		foreach($this->grupos_model->listarGrupos()->result() as $linha) {
			$data['grupos'][$linha->idGrupo] = $linha->idGrupo;
		}
		$data['menu'] = buildMenu('usuarios', 'Usuários');
		$query = $this->usuarios_model->listarUsuarios($this->uri->segment(4));
		$data['linha'] = $query->row_array();
		$data['main_content'] = 'administracao/usuarios_add_view';
		$this->load->view('administracao/includes/template', $data);
	}

	function apagar() {
		if ($this->usuarios_model->apagar($this->uri->segment(4))) {
			redirect('administracao/usuarios');
		}
	}

	function salvar() {
		$action = $this->input->post('action');
		$id = $this->input->post('id');
		$this->load->library('form_validation');

		$this->form_validation->set_rules('nome', 'Nome', 'trim|required|min_length[5]');
		$this->form_validation->set_rules('usuario', 'Usuario', 'trim|required|min_length[5]');
		$this->form_validation->set_rules('senha', 'Senha', 'trim|min_length[5]');
		$this->form_validation->set_rules('senha_check', 'Confirmar Senha', 'trim|required|matches[senha]');
		$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');

		if ($this->form_validation->run() == FALSE) {
			$this->session->set_flashdata('validation_errors', validation_errors('<p class="error">'));
			if ($action != 'editar') {
				redirect('administracao/usuarios/'.$action);
			} else {
				redirect('administracao/usuarios/'.$action.'/'.$id);
			}

		} else {
			if ($this->usuarios_model->$action()){
				$this->session->unset_userdata('validation_errors');
				redirect('administracao/usuarios');
			} else {
				if ($action != 'editar') {
					redirect('administracao/usuarios/'.$action);
				} else {
					redirect('administracao/usuarios/'.$action.'/'.$id);
				}
			}
		}

	}

}