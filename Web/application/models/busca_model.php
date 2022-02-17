<?php

class Busca_model extends Model {

	function __construct() {
		parent::Model();
	}

	function pesquisar() {
		$termos = $this->input->post('busca');

		$this->db->select('obras.*, obra_desc.*, categoria.categoria, tipo.tipo');
		$this->db->join('obras', 'obras.idObra=obra_desc.idObra');
		$this->db->join('categoria', 'obras.idCategoria=categoria.idCategoria AND categoria.idioma = obra_desc.idioma');
		$this->db->join('tipo', 'obras.idTipo=tipo.idTipo AND tipo.idioma = obra_desc.idioma', 'left');
		$this->db->like('obra_desc.titulo',$termos);
//		$this->db->like('obra_desc.descricao',$termos);
		$this->db->or_like('obras.execucao_inicio',$termos);
//		$this->db->like('obras.execucao_fim',$termos);
		$this->db->where('obra_desc.idioma', $this->lang->lang());
//		$this->db->where('obras.realizada', 1);
//		$query->realizada = $this->db->get('obra_desc');
		$query = $this->db->get('obra_desc');

		$sqls->realizada = $this->db->last_query();

//		$this->db->select('obras.*, obra_desc.*, categoria.categoria, tipo.tipo');
//		$this->db->join('obras', 'obras.idObra=obra_desc.idObra');
//		$this->db->join('categoria', 'obras.idCategoria=categoria.idCategoria AND categoria.idioma = obra_desc.idioma');
//		$this->db->join('tipo', 'obras.idTipo=tipo.idTipo AND tipo.idioma = obra_desc.idioma', 'left');
//		$this->db->like('obra_desc.titulo',$termos);
////		$this->db->like('obra_desc.descricao',$termos);
////		$this->db->like('obras.execucao_inicio',$termos);
////		$this->db->like('obras.execucao_fim',$termos);
//		$this->db->where('obra_desc.idioma', $this->lang->lang());
//		$this->db->where('obras.realizada', 0);
//		$query->em_andamento = $this->db->get('obra_desc');

//		$sqls->em_andamento = $this->db->last_query();

		return $query;
	}

	function pop(){
		$termos = $this->input->post('busca');
		$query->realizada = $this->db->query("	SELECT obras.idObra, obra_desc.titulo, obras.idCategoria
									FROM
										obras INNER JOIN obra_desc ON obras.idObra = obra_desc.idObra
									WHERE
										obra_desc.titulo LIKE  '%".$termos."%' OR
										obra_desc.descricao LIKE  '%".$termos."%' OR
										obras.execucao_inicio LIKE  '%".$termos."%' OR
										obras.execucao_fim LIKE '%".$termos."%' AND
										obra_desc.idioma = '".$this->lang->lang()."' AND
										obras.realizada = 1");
		$query->em_andamento = $this->db->query("	SELECT obras.idObra, obra_desc.titulo, obras.idCategoria
									FROM
										obras INNER JOIN obra_desc ON obras.idObra = obra_desc.idObra
									WHERE
										obra_desc.titulo LIKE  '%".$termos."%' OR
										obra_desc.descricao LIKE  '%".$termos."%' OR
										obras.execucao_inicio LIKE  '%".$termos."%' OR
										obras.execucao_fim LIKE '%".$termos."%' AND
										obra_desc.idioma = '".$this->lang->lang()."' AND
										obras.realizada = 0");

		return $query;

	}

}