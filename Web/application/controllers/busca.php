<?php

class Busca extends Controller {

	var $minLength = 4;

	function __construct() {
		parent::Controller();

		$this->load->model('busca_model');

		$this->lang->load('busca');
		$this->lang->load('messages');

		$this->session->set_userdata('site_idioma', $this->lang->lang());
	}

	function index() {
		if (strlen($this->input->post('busca')) >= $this->minLength) {
			$resultado = $this->busca_model->pesquisar();

			$data['conteudo'] = '';
			
			if ($resultado->num_rows() > 0) {
//				$data['conteudo'] .= '<p style="font-size:16px">Obras Em Andamento</p>';
				foreach($resultado->result() as $obra) {
					if ($obra->realizada == 0) {
						$data['conteudo'] .= '<p><a href="'.site_url('obras/em-andamento/'.$obra->idObra).'">'.$obra->titulo.'</a></p>';
					} else {
						$data['conteudo'] .= '<p><a href="'.site_url('obras/realizadas/'.$obra->idCategoria.'/'.$obra->idObra).'">'.$obra->titulo.'</a></p>';
					}
				}
			}

//			if ($resultado->em_andamento->num_rows() > 0) {
//				$data['conteudo'] .= '<p style="font-size:16px">Obras Em Andamento</p>';
//				foreach($resultado->em_andamento->result() as $em_andamento) {
//					$data['conteudo'] .= '<p><a href="'.site_url('obras/em-andamento/'.$em_andamento->idObra).'">'.$em_andamento->titulo.'</a></p>';
//				}
//			}
//
//			if ($resultado->realizada->num_rows() > 0) {
//				$data['conteudo'] .= '<p style="font-size:16px">Obras Realizadas</p>';
//				foreach($resultado->realizada->result() as $realizada) {
//					$data['conteudo'] .= '<p><a href="'.site_url('obras/realizadas/'.$realizada->idObra.'/'.$realizada->idObra).'">'.$realizada->titulo.'</a></p>';
//				}
//			}

			$data['titulo'] = lang('resultado_busca');
			$data['main_content'] = 'interna_view';
			$this->load->view('includes/template',$data);
		} else {
			$data['titulo'] = lang('resultado_busca');
			$data['conteudo'] = '<p style="font-size:16px">' . lang('limite_minimo') . $this->minLength . ' ' . lang('limite_minimo2') . '</p>';
			$data['main_content'] = 'interna_view';
			$this->load->view('includes/template',$data);
		}
	}

}
