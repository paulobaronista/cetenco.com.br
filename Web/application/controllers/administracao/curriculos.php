<?php

class Curriculos extends Controller {

	function __construct() {
		parent::Controller();

		$this->load->model('administracao/curriculos_model');
	}

	function index() {
		$data['areas'][] = 'TODAS';
		foreach ($this->curriculos_model->listar_departamentos()->result() as $depto) {
			$data['areas'][$depto->id] = $depto->nome;
		}

		$data['curriculos'] = $this->curriculos_model->ler_todos();
		$data['menu'] = buildMenu('curriculos');
		$data['main_content'] = 'administracao/curriculos_view';
		$this->load->view('administracao/includes/template', $data);
	}

	function filtrar(){
		$data['areas'][] = 'TODAS';
		foreach ($this->curriculos_model->listar_departamentos()->result() as $depto) {
			$data['areas'][$depto->id] = $depto->nome;
		}
		
		$data['curriculos'] = $this->curriculos_model->ler_todos('',$this->uri->segment(4));
		$data['menu'] = buildMenu('curriculos');
		$data['main_content'] = 'administracao/curriculos_view';
		$this->load->view('administracao/includes/template', $data);
	}

	function download() {
		$this->load->helper('download');
		$url = base_url() . 'curriculos/' . $this->uri->segment(4);
		$file = file_get_contents($url);
		force_download($this->uri->segment(4), $file);
	}

	function apagar() {
		$arquivo = $this->curriculos_model->ler_todos($this->uri->segment(4))->row();
//		$filePath = realpath('curriculos/'.$arquivo->curriculo);
		$this->firephp->log($arquivo);
//		if (unlink($filePath)) {
			if ($this->curriculos_model->apagar($this->uri->segment(4))) {
				redirect('administracao/curriculos');
			}
//		}

	}

}