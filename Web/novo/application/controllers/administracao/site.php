<?php
/**
 * @property CI_Loader $load
 * @property CI_URI $uri
 * @property CI_Form_validation $form_validation
 * @property CI_Input $input
 * @property CI_Email $email
 * @property CI_DB_active_record $db
 * @property CI_DB_forge $dbforge
 * $property CI_Session $session
 */

class Site extends Controller{

	function __construct() {
		parent::Controller();
        if (!$this->session->userdata('is_logged_in')) redirect('administracao/access');
	}

	function index() {
		if(!$this->session->userdata('is_logged_in')) {
			$this->session->set_userdata('page_title','Login');
			$this->login();
		} else {
			redirect(current_url() . '/timeline');
		}
	}

	function login() {
		redirect(current_url() . '/access');
	}

	function idioma(){
		$this->session->set_userdata('idioma', $this->input->post('idioma'));
		redirect($this->input->post('referrer'));
	}

}