<?php

class Certificacoes extends Controller {

	function __construct() {
		parent::Controller();

		$this->session->set_userdata('site_idioma', $this->lang->lang());
	}

	function index() {
		$data['main_content'] = 'certificacoes_view';
		$this->load->view('includes/template', $data);
	}

}