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

class Categorias_model extends Model {

	function __construct() {
		parent::Model();
	}

	function listarCategorias($id = FALSE) {
		if (!$id) {
			$this->db->where('idioma', $this->session->userdata('idioma'));
			$this->db->order_by('categoria');
			$query = $this->db->get('categoria');
			return $query;
		} else {
			$this->db->where('idCategoria', $id);
			$query = $this->db->get('categoria');
			return $query;
		}
		
	}

	function adicionar() {
		$this->db->select_max('idCategoria');
		$maxCat = $this->db->get('categoria');
		$nextCat = $maxCat->row()->idCategoria + 1;
		$categoria = $this->input->post('categoria');

		foreach ($this->config->item('idiomas') as $key => $value) {
			$categoria_dados = Array(
				'idCategoria'	=> $nextCat,
				'categoria'		=> $categoria[$key],
				'idioma'		=> $key
			);

			$this->db->insert('categoria', $categoria_dados);
		}
		
		if ($this->db->affected_rows() > 0) {
			return TRUE;
		} else {
			return FALSE;
		}
	}

	function editar() {
		$idCategoria = $this->input->post('id');
		$this->db->where('idCategoria',$idCategoria);
		$this->db->delete('categoria');
		$categoria = $this->input->post('categoria');

		foreach ($this->config->item('idiomas') as $key => $value) {
			$categoria_dados = Array(
				'idCategoria'	=> $idCategoria,
				'categoria'		=> $categoria[$key],
				'idioma'		=> $key
			);

			$this->db->insert('categoria', $categoria_dados);
		}

		if ($this->db->affected_rows() > 0) {
			return TRUE;
		} else {
			return FALSE;
		}
	}

	function apagar() {
		$this->db->where('idCategoria',$this->uri->segment(4));
		if ($this->db->delete('categoria')) {
			return TRUE;
		} else {
			return FALSE;
		}
	}

}