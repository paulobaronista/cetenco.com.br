<?php

class Destaques_model extends Model {

	function __construct() {
		parent::Model();
	}

	function listar($_id = FALSE, $principal = TRUE, $realizada = FALSE) {
		$this->db->select('destaques.*,obra_desc.titulo,obra_desc.idioma');
		$this->db->join('obra_desc', 'destaques.idObra = obra_desc.idObra');
		$this->db->where('obra_desc.idioma', $this->session->userdata('idioma'));
		$this->db->order_by('obra_desc.titulo');

		if (!$_id) {
			if (!$principal) {
				$this->db->select('obras.realizada');
				$this->db->join('obras', 'destaques.idObra = obras.idObra');
				$this->db->where('destaques.principal',0);
				$this->db->where('obras.realizada', ($realizada ? 1 : 0));
			} else {
				$this->db->where('destaques.principal',1);
			}
			$query = $this->db->get('destaques');
		} else {
			$this->db->where('id', $_id);
			$query = $this->db->get('destaques');
		}

		return $query;
	}

	function adicionar() {
		$upload_data = $this->upload->data();

		$destaque_dados = Array(
			'idObra'	=> $this->input->post('obra'),
			'foto'		=> $upload_data['file_name'],
			'principal'	=> $this->input->post('principal')
		);

		$this->db->insert('destaques', $destaque_dados);

		if ($this->db->affected_rows()){
			return TRUE;
		} else {
			return FALSE;
		}
	}

	function editar() {
		$upload_data = $this->upload->data();

		$destaque_dados = Array(
			'idObra'	=> $this->input->post('obra'),
			'foto'		=> $upload_data['file_name'],
			'principal'	=> $this->input->post('principal')
		);

		// Apaga foto anterior, economizando espaço no servidor
		$this->db->where('id', $this->input->post('id'));
		$foto = $this->db->get('destaques')->row()->foto;
		$file = realpath('images/destaques/' . $foto);
		if (is_file($file) && $foto != $destaque_dados['foto']) {
			unlink($file);
		}

		$this->db->where('id', $this->input->post('id'));
		$this->db->update('destaques', $destaque_dados);

		if ($this->db->affected_rows()) {
			return TRUE;
		} else {
			return FALSE;
		}
	}

	function apagar() {
		$this->db->where('id', $this->uri->segment(4));
		$foto = $this->db->get('destaques')->row()->foto;

		$this->db->where('id', $this->uri->segment(4));
		if ($this->db->delete('destaques')) {
			$file = realpath('images/destaques/' . $foto);
			if (is_file($file)) {
				unlink($file);
			}
			return TRUE;
		} else {
			return FALSE;
		}
	}

}