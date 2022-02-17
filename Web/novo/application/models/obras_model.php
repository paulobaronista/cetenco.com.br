<?php

class Obras_model extends Model {

	function __construct() {
		parent::Model();
	}

	function listar($_filtro = FALSE) {
		switch ($_filtro) {
			case 'andamento':
//				$this->db->select('obras.*, obra_desc.*');
				$this->db->select('obras.*, obra_desc.*, categoria.categoria, tipo.tipo');
				$this->db->join('obras', 'obras.idObra=obra_desc.idObra');
				$this->db->join('categoria', 'obras.idCategoria=categoria.idCategoria AND categoria.idioma = obra_desc.idioma');
				$this->db->join('tipo', 'obras.idTipo=tipo.idTipo AND tipo.idioma = obra_desc.idioma','left');
				$this->db->where('obra_desc.idioma', $this->lang->lang());
				$this->db->where('publicada', TRUE);
				$this->db->where('realizada', FALSE);
				$query = $this->db->get('obra_desc');
			break;

			case 'realizadas':
//				$this->db->select('obras.*, obra_desc.*, categoria.categoria');
				$this->db->select('obras.*, obra_desc.*, categoria.categoria, tipo.tipo');
				$this->db->join('obras', 'obras.idObra=obra_desc.idObra');
				$this->db->join('categoria', 'obras.idCategoria=categoria.idCategoria AND categoria.idioma = obra_desc.idioma');
				$this->db->join('tipo', 'obras.idTipo=tipo.idTipo AND tipo.idioma = obra_desc.idioma','left');
				$this->db->where('obra_desc.idioma', $this->lang->lang());
				$this->db->where('publicada', TRUE);
				$this->db->where('realizada', TRUE);
				$query = $this->db->get('obra_desc');
			break;

			default:
				$this->db->select('obras.*, obra_desc.*, categoria.categoria, tipo.tipo');
				$this->db->join('obras', 'obras.idObra=obra_desc.idObra');
				$this->db->join('categoria', 'obras.idCategoria=categoria.idCategoria AND categoria.idioma = obra_desc.idioma');
				$this->db->join('tipo', 'obras.idTipo=tipo.idTipo AND tipo.idioma = obra_desc.idioma','left');
				$this->db->where('obra_desc.idioma', $this->lang->lang());
				$this->db->where('publicada', TRUE);
				$query = $this->db->get('obra_desc');
			break;
		}
		
		return $query;
	}

	function lerDados($_id = FALSE){
		$this->db->select('obra_desc.*, obras.*, categoria.categoria');
		$this->db->select('obra_desc.*, obras.*, categoria.categoria, tipo.tipo');
		$this->db->join('obras', 'obra_desc.idObra=obras.idObra');
		$this->db->join('categoria', 'obras.idCategoria=categoria.idCategoria AND categoria.idioma = obra_desc.idioma');
		$this->db->join('tipo', 'obras.idTipo=tipo.idTipo AND tipo.idioma = obra_desc.idioma','left');
		$this->db->where('obras.idObra', ($_id?$_id:1));
		$this->db->where('obra_desc.idioma', $this->lang->lang());
		$this->db->where('publicada', TRUE);
		if (!$_id) {
			if ($this->uri->segment(3) == 'realizadas') {
				$this->db->where('realizada', TRUE);
			} else {
				$this->db->where('realizada', FALSE);
			}
		}
		$query = $this->db->get('obra_desc');

		return $query;
	}

	function lerFotos ($_id = FALSE) {
		$this->db->where('idObra', ($_id?$_id:1));
		$query = $this->db->get('foto');

		return $query;
	}

	function lerCategorias() {
		if (!$this->input->post('idCat')) {
			$this->db->where('idioma', $this->lang->lang());
			$query = $this->db->get('categoria');
		} else {
			if ($this->input->post('segment') == 'realizadas') {
				$realizada = 1;
			} else {
				$realizada = 0;
			}

			$this->db->select('obra_desc.*, obras.*, categoria.*');
			$this->db->join('obras', 'obra_desc.idObra=obras.idObra');
			$this->db->join('categoria', 'obras.idCategoria=categoria.idCategoria AND categoria.idioma = obra_desc.idioma');
			$this->db->where('categoria.idCategoria', $this->input->post('idCat'));
			$this->db->where('obra_desc.idioma', $this->lang->lang());
			$this->db->where('publicada', TRUE);
			$this->db->where('realizada', $realizada);
			$query = $this->db->get('obra_desc');
		}

		return $query;
	}
	
	function lerPrimeira($_id_cat = FALSE) {
		$this->db->select('obra_desc.*, obras.*, categoria.*');
		$this->db->join('obras', 'obra_desc.idObra=obras.idObra');
		$this->db->join('categoria', 'obras.idCategoria=categoria.idCategoria AND categoria.idioma = obra_desc.idioma');
		$this->db->where('categoria.idCategoria', $_id_cat);
		$this->db->where('obra_desc.idioma', $this->lang->lang());
		$this->db->where('publicada', TRUE);
		$this->db->where('realizada', 1);
		$this->db->limit(1);
		$query = $this->db->get('obra_desc');

		return $query;
	}

}