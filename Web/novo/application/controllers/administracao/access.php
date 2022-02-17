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

class Access extends Controller{

	function __construct() {
		parent::Controller();
	}

	function index() {
		$data['main_content'] = 'administracao/login_form';
		$this->load->view('administracao/includes/template', $data);
	}

	function login() {
		$this->load->model('administracao/usuarios_model');
		$login_success = $this->usuarios_model->login();

		if ($login_success){
			$this->session->set_userdata('is_logged_in', true);
			$this->session->set_userdata('idioma', $this->input->post('idioma'));
			redirect('administracao');
		} else {
//			$this->session->sess_destroy();
			redirect('administracao/access');
		}
	}

	function logout() {
		$this->session->sess_destroy();
		redirect('administracao/access');
	}
}