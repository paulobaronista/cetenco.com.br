<?php

class Trabalhe_conosco_model extends Model {

	function __construct() {
		parent::Model();
	}

	function gravar() {
		$upload_data = $this->upload->data();

		$contato_dados = Array(
			'nome'		=> $this->input->post('txtNome'),
			'email'		=> $this->input->post('txtEmail'),
			'empresa'	=> ($this->input->post('txtEmpresa')?$this->input->post('txtEmpresa'):NULL),
			'area'		=> $this->input->post('txtArea'),
			'curriculo'	=> $upload_data['file_name'],
			'assunto'	=> $this->input->post('txtAssunto'),
			'mensagem'	=> $this->input->post('txtMensagem')
		);

		$this->db->insert('trabalhe_conosco', $contato_dados);

		if ($this->db->affected_rows() > 0) {
			return TRUE;
		} else {
			return FALSE;
		}
	}

	function listar_departamentos() {
		$query = $this->db->get_where('departamentos',Array('idioma'=>$this->session->userdata('site_idioma')));
		return $query;
	}

}