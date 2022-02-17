<?php
/**
 * @property CI_Loader $load
 * @property CI_URI $uri
 * @property CI_Form_validation $form_validation
 * @property CI_Input $input
 * @property CI_Email $email
 * @property CI_DB_active_record $db
 * @property CI_DB_forge $dbforge
 */

class Tipos_model extends Model {

	function __construct() {
		parent::Model();

		$idiomas = $this->config->item('idiomas');
	}

	function listarTipos($id = FALSE) {
		if (!$id) {
			$this->db->select('tipo.*, categoria.* ');
			$this->db->join('categoria', 'tipo.idCategoria = categoria.idCategoria');
			$this->db->where('tipo.idioma', $this->session->userdata('idioma'));
			$this->db->order_by('tipo.tipo');
			$query = $this->db->get('tipo');
			return $query;
		} else {
			$this->db->where('idTipo', $id);
			$query = $this->db->get('tipo');
			return $query;
		}
		
	}

	function adicionar() {
		$this->db->select_max('idTipo');
		$maxTipo = $this->db->get('tipo');
		$nextTipo = $maxTipo->row()->idTipo + 1;
		$tipo = $this->input->post('tipo');

		foreach ($this->config->item('idiomas') as $key => $value) {
			$novo_tipo = Array(
				'idTipo'		=>	$nextTipo,
				'tipo'			=>	$tipo[$key],
				'idCategoria'	=>	$this->input->post('categoria'),
				'idioma'		=>	$key
			);

			$this->db->insert('tipo', $novo_tipo);
		}

		if ($this->db->affected_rows() > 0) {
			return TRUE;
		} else {
			return FALSE;
		}
	}

	function editar() {
		$idTipo = $this->input->post('id');
		$this->db->where('idTipo', $idTipo);
		$this->db->delete('tipo');
		$tipo = $this->input->post('tipo');

		foreach ($this->config->item('idiomas') as $key => $value) {
			$novo_tipo = Array(
				'idTipo'		=>	$idTipo,
				'tipo'			=>	$tipo[$key],
				'idCategoria'	=>	$this->input->post('categoria'),
				'idioma'		=>	$key
			);

			$this->db->insert('tipo', $novo_tipo);
		}
		
		if ($this->db->affected_rows() > 0) {
			return TRUE;
		} else {
			return FALSE;
		}
	}

	function apagar() {
		$this->db->where('idTipo',$this->uri->segment(4));
		if ($this->db->delete('tipo')) {
			return TRUE;
		} else {
			return FALSE;
		}
	}

}