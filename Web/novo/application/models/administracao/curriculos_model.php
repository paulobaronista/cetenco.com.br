<?php

class Curriculos_model extends Model {

	function __construct() {
		parent::Model();
	}

	function ler_todos($id = FALSE, $cat = FALSE) {
		if (!$id && !$cat) {
			$this->db->select('trabalhe_conosco.*, departamentos.nome AS depto');
			$this->db->join('departamentos','trabalhe_conosco.area = departamentos.id');
			$query = $this->db->get('trabalhe_conosco');
			return $query;
		} else if (!$id && $cat) {
			$this->db->select('trabalhe_conosco.*, departamentos.nome AS depto');
			$this->db->join('departamentos','trabalhe_conosco.area = departamentos.id');
			$this->db->where('area', $cat);
			$query = $this->db->get('trabalhe_conosco');
			return $query;
		} else {
			$this->db->select('trabalhe_conosco.*, departamentos.nome AS depto');
			$this->db->join('departamentos','trabalhe_conosco.area = departamentos.id');
			$this->db->where('id', $id);
			$query = $this->db->get('trabalhe_conosco');
			return $query;
		}
	}

	function apagar() {
		$this->db->where('id',$this->uri->segment(4));
		if ($this->db->delete('trabalhe_conosco')) {
			return TRUE;
		} else {
			return FALSE;
		}
	}

	function listar_departamentos() {
		$query = $this->db->get('departamentos');
		return $query;
	}
}