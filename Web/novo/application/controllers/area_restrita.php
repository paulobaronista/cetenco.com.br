<?php

class Area_restrita extends Controller {

	function __construct() {
		parent::Controller();

		$this->session->set_userdata('site_idioma', $this->lang->lang());
	}

	function index() {
		if (!$this->session->userdata('site_logado')) {
			$data['main_content'] = 'area_restrita_login';
			$this->load->view('includes/template', $data);
		} else {
			$this->load->model('arquivos_model');
			$data['arquivos'] = $this->arquivos_model->listarArquivos();

			$data['main_content'] = 'area_restrita_view';
			$this->load->view('includes/template', $data);
		}
	}

	function login() {
		$this->load->model('usuarios_model');
		$login_success = $this->usuarios_model->login();

		if ($login_success) {
			$this->session->set_userdata('site_logado', true);
			redirect(site_url('area-restrita'));
		} else {
			$this->session->sess_destroy();
			redirect(site_url());
		}
	}

	function logout() {
		$this->session->sess_destroy();
		redirect(site_url());
	}

	function download() {
		$this->load->helper('download');
		$url = base_url() . 'arquivos/' . $this->uri->segment(4);
		$file = file_get_contents($url);
		force_download($this->uri->segment(4), $file);
	}

}