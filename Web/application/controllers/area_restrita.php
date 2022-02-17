<?php

class Area_restrita extends Controller {

	function __construct() {
		parent::Controller();
		
		$this->load->library('encrypt');
		$this->load->helper('encode');

		$this->session->set_userdata('site_idioma', $this->lang->lang());
	}

	function index() {
		if (!$this->session->userdata('site_logado')) {
			$data['main_content'] = 'area_restrita_login';
			$this->load->view('includes/template', $data);
		} else {
			$this->load->model('arquivos_model');
			
			$data['options']['none'] = 'Sem filtro de pasta';
			foreach ($this->arquivos_model->listar_pastas_com_arquivos()->result() as $item) {
				if (!is_null($item->path))
					$data['options'][$item->path] = $item->path;
				else
					$data['options']['root'] = 'PRINCIPAL';
			}
			
			if ($this->input->post('filtro') AND $this->input->post('filtro') != 'none')
				$data['arquivos'] = $this->arquivos_model->listarArquivos($this->input->post('filtro'));
			else
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
		$this->load->model('arquivos_model');
		$uri_string = str_replace(date('Ymd'), '', base64_decode(url_base64_decode($this->uri->segment(4))));

		$query = $this->arquivos_model->get_folder($uri_string);
		
		$this->load->helper('download');
		
		if ($query->num_rows() > 0 AND !is_null($query->row()->path))
			$filepath = './arquivos/' . $query->row()->path . '/' . $uri_string;
		else
			$filepath = './arquivos/' . $uri_string;
		
		
		if ($file = file_get_contents($filepath))
			force_download($uri_string, $file);
		else
			show_error('Arquivo não encontrado', 404);
	}

}