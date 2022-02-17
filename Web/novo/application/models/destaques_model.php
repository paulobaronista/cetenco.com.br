<?php

class Destaques_model extends Model {

	function __construct() {
		parent::Model();
	}

	function listar($_id = FALSE, $principal = TRUE, $realizada = FALSE) {
		$this->db->select('destaques.*,obras.*,obra_desc.*');
		$this->db->join('obra_desc', 'destaques.idObra = obra_desc.idObra');
		$this->db->join('obras', 'destaques.idObra = obras.idObra');
		$this->db->where('obra_desc.idioma', $this->session->userdata('site_idioma'));

		if (!$_id) {
			if (!$principal) {
//				$this->db->select('obras.realizada');
//				$this->db->join('obras', 'destaques.idObra = obras.idObra');
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

}