<?php

class Timeline_model extends Model {

	function __construct() {
		parent::Model();
	}

	function listar($_id = FALSE) {
		$this->db->select('timeline.*, obras.execucao_fim, obra_desc.titulo, obra_desc.idioma');
		$this->db->join('obras', 'timeline.idObra = obras.idObra');
		$this->db->join('obra_desc', 'timeline.idObra = obra_desc.idObra');
		$this->db->where('obra_desc.idioma', $this->session->userdata('idioma'));
		$this->db->order_by('obra_desc.titulo');

		if (!$_id) {
			$query = $this->db->get('timeline');
		} else {
			$this->db->where('id', $_id);
			$query = $this->db->get('timeline');
		}

		return $query;
	}

	function adicionar($_file = FALSE) {
//		$upload_data = $this->upload->data();

		$file_info = pathinfo($_file);

		$timeline_dados = Array(
			'idObra' => $this->input->post('obra'),
			'imagem' => $file_info['basename']
		);

		$this->db->insert('timeline', $timeline_dados);

		if ($this->db->affected_rows()){
			return TRUE;
		} else {
			return FALSE;
		}
	}

	function editar($_file = FALSE) {
//		$upload_data = $this->upload->data();

		$file_info = pathinfo($_file);

		$timeline_dados = Array(
			'idObra' => $this->input->post('obra'),
			'imagem' => $file_info['basename']
		);

		// Apaga imagem anterior, economizando espaço no servidor
		$this->db->where('id', $this->input->post('id'));
		$imagem = $this->db->get('timeline')->row()->imagem;
		$file = realpath('images/timeline/thumbs/' . $imagem);
		if (is_file($file) && $imagem != $timeline_dados['imagem']) {
			unlink($file);
		}

		$this->db->where('id', $this->input->post('id'));
		$this->db->update('timeline', $timeline_dados);

		if ($this->db->affected_rows()) {
			return TRUE;
		} else {
			return FALSE;
		}
	}

	function apagar() {
		$this->db->where('id', $this->uri->segment(4));
		$imagem = $this->db->get('timeline')->row()->imagem;

		$this->db->where('id', $this->uri->segment(4));
		if ($this->db->delete('timeline')) {
			$file = realpath('images/timeline/thumbs/' . $imagem);
			if (is_file($file)) {
				unlink($file);
			}
			return TRUE;
		} else {
			return FALSE;
		}
	}
}