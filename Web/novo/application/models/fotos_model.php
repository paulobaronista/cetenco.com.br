<?php

class Fotos_model extends Controller {

	function __construct() {
		parent::Controller();
	}

	function listarFotos($_id = FALSE) {
		$this->db->select('foto.*');
//		$this->db->join('obra_desc', 'foto.idObra = obra_desc.idObra', 'left');
		$this->db->where('foto.idObra', ($_id?$_id:1));
		$this->db->order_by('foto.ordem', 'asc');
		$query = $this->db->get('foto');
		return $query;
	}

}