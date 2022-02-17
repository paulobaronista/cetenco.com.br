<?php

class Cetenco extends Controller {

	function __construct() {
		parent::Controller();

		$this->load->model('timeline_model');

		$this->session->set_userdata('site_idioma', $this->lang->lang());
	}

	function index() {
		$data['timeline'] = $this->timeline_model->listar();
		switch ($this->uri->segment(1)) {
			case 'en':
				$data['main_content'] = 'cetenco_en_view';
				$this->load->view('includes/template',$data);
			break;
			case 'es':
				$data['main_content'] = 'cetenco_es_view';
				$this->load->view('includes/template',$data);
			break;
			default:
				$data['main_content'] = 'cetenco_br_view';
				$this->load->view('includes/template',$data);
			break;
		}
	}

}
