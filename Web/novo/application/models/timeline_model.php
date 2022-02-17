<?php

class Timeline_model extends Model {

	function __construct() {
		parent::Model();
	}

	function listar() {
		$this->db->select('timeline.*, obras.execucao_fim, obras.idCategoria, obras.realizada, obra_desc.titulo, obra_desc.idioma');
		$this->db->join('obras', 'timeline.idObra = obras.idObra');
		$this->db->join('obra_desc', 'timeline.idObra = obra_desc.idObra');
		$this->db->where('obra_desc.idioma', $this->session->userdata('site_idioma'));
		$this->db->order_by('execucao_fim');

		$query = $this->db->get('timeline');

		return $query;
	}

}