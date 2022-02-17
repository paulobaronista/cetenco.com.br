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

class Obras_model extends Model {

	function __construct() {
		parent::Model();
	}

	function listarTodas() {
		$this->db->select('obras.*, obra_desc.*, categoria.*, tipo.tipo');
		$this->db->join('obras', 'obras.idObra=obra_desc.idObra');
		$this->db->join('categoria', 'obras.idCategoria=categoria.idCategoria AND categoria.idioma = obra_desc.idioma');
		$this->db->join('tipo', 'obras.idTipo=tipo.idTipo AND tipo.idioma = obra_desc.idioma', 'left');
		$this->db->where('obra_desc.idioma', $this->session->userdata('idioma'));
		$this->db->order_by('obras.realizada');
		$this->db->order_by('categoria.categoria');
		$this->db->order_by('obra_desc.titulo','asc');
		$query = $this->db->get('obra_desc');
		return $query;
	}

	function listarObras($id = FALSE, $status = FALSE, $id_cat = FALSE) {
		if ($status == 'realizadas'){
			$status = 1;
		} else if ($status == 'andamento') {
			$status = 0;
		}

		if (!$id && !$id_cat) {
			$this->db->select('obras.*, obra_desc.*, categoria.*, tipo.tipo');
			$this->db->join('obras', 'obras.idObra=obra_desc.idObra');
			$this->db->join('categoria', 'obras.idCategoria=categoria.idCategoria AND categoria.idioma = obra_desc.idioma');
			$this->db->join('tipo', 'obras.idTipo=tipo.idTipo AND tipo.idioma = obra_desc.idioma', 'left');
			$this->db->where('obra_desc.idioma', $this->session->userdata('idioma'));
			$this->db->where('obras.realizada', $status);
			$this->db->order_by('categoria.categoria');
			$this->db->order_by('obra_desc.titulo');
			$query = $this->db->get('obra_desc');
			return $query;
		} else if (!$id && $id_cat){
			$this->db->select('obras.*, obra_desc.*, categoria.*, tipo.tipo');
			$this->db->join('obras', 'obras.idObra=obra_desc.idObra');
			$this->db->join('categoria', 'obras.idCategoria=categoria.idCategoria AND categoria.idioma = obra_desc.idioma');
			$this->db->join('tipo', 'obras.idTipo=tipo.idTipo AND tipo.idioma = obra_desc.idioma', 'left');
			$this->db->where('obra_desc.idioma', $this->session->userdata('idioma'));
			$this->db->where('obras.realizada', $status);
			$this->db->where('categoria.idCategoria', $id_cat);
			$this->db->order_by('categoria.categoria');
			$this->db->order_by('obra_desc.titulo');
			$query = $this->db->get('obra_desc');
			return $query;
		} else {
			$this->db->where('obras.idObra', $id);
			
			$query->obra = $this->db->get('obras');

			$this->db->where('idObra', $id);
			foreach ($this->db->get('obra_desc')->result() as $desc){
				$query->obra_desc[$desc->idioma] = $desc;
			}

			return $query;
		}
	}

	function ler_categorias() {
		$this->db->where('idioma',$this->session->userdata('idioma'));
		$query = $this->db->get('categoria');
		return $query;
	}

	function adicionar($idioma = FALSE) {
		if ($this->input->post('coordenadas')) {
			$coordenadas = $this->input->post('coordenadas');
			$coords_array = explode(' ', $coordenadas);
			$latitude = (strtolower($coords[3]) == 's' ? '-': '').$this->DMStoDEC((int)$coords[0], (int)$coords[1], (int)$coords[2]);
			$longitude = (strtolower($coords[8]) == 'o' ? '-': '').$this->DMStoDEC((int)$coords[5], (int)$coords[6], (int)$coords[7]);
		}

		$obra = Array(
			'idCategoria'		=>	$this->input->post('categoria'),
			'idTipo'			=>	$this->input->post('tipo'),
			'contratante'		=>	$this->input->post('contratante'),
			'local'				=>	$this->input->post('local'),
			'execucao_inicio'	=>	$this->input->post('execucao_inicio'),
			'execucao_fim'		=>	$this->input->post('execucao_fim'),
			'publicada'			=>	$this->input->post('publicada'),
			'realizada'			=>	$this->input->post('realizada'),
			'embed'				=>	($this->input->post('embed')?$this->input->post('embed'):NULL),
			'coordenadas'		=>	($this->input->post('coordenadas')?$this->input->post('coordenadas'):NULL),
			'latitude'			=>	($this->input->post('latitude')?$this->input->post('latitude'):$latitude),
			'longitude'			=>	($this->input->post('longitude')?$this->input->post('longitude'):$longitude)
		);

		$this->db->insert('obras', $obra);

		$insert_id = $this->db->insert_id();
		
//		$titulo = $this->input->post('titulo');
//		$descricao = $this->input->post('descricao');
		
		foreach ($this->config->item('idiomas') as $key => $value) {
			if ($this->input->post('categoria') == 1) {
				$obra_desc = Array(
					'idObra'			=>	$insert_id,
					'titulo'			=>	$this->input->post('titulo_'.$key),
					'descricao'			=>	$this->input->post('descricao_'.$key),
					'idioma'			=>	$key
				);
//				$obra_desc = Array(
//					'idObra'			=>	$insert_id,
//					'titulo'			=>	$titulo[$key],
//					'descricao'			=>	$descricao[$key],
//					'idioma'			=>	$key
//				);
			} else {
				$obra_desc = Array(
					'idObra'			=>	$insert_id,
					'titulo'			=>	$this->input->post('titulo_'.$key),
					'descricao'			=>	$this->input->post('descricao_'.$key),
					'rio'				=>	$this->input->post('rio'),
					'potencia'			=>	$this->input->post('potencia'),
					'idioma'			=>	$key
				);
//				$obra_desc = Array(
//					'idObra'			=>	$insert_id,
//					'titulo'			=>	$titulo[$key],
//					'descricao'			=>	$descricao[$key],
//					'rio'				=>	$this->input->post('rio'),
//					'potencia'			=>	$this->input->post('potencia'),
//					'idioma'			=>	$key
//				);
			}

			$this->db->insert('obra_desc', $obra_desc);

			if ($this->db->affected_rows() > 0) {
				return TRUE;
			} else {
				return FALSE;
			}
		}
	}

	function editar() {
		$titulo = $this->input->post('titulo');
		$descricao = $this->input->post('descricao');

		$this->db->where('idCategoria', $this->input->post('categoria'));
		$query = $this->db->get('tipo');
		if ($query->num_rows() == 1) {
			$tipo = $query->row()->idTipo;
		} else if ($query->num_rows() > 0) {
			$tipo = $this->input->post('tipo');
		} else {
			$tipo = NULL;
		}

		$obra = Array(
			'idCategoria'		=>	$this->input->post('categoria'),
			'idTipo'			=>	$tipo,
			'local'				=>	$this->input->post('local'),
			'contratante'		=>	$this->input->post('contratante'),
			'execucao_inicio'	=>	$this->input->post('execucao_inicio'),
			'execucao_fim'		=>	$this->input->post('execucao_fim'),
			'publicada'			=>	$this->input->post('publicada'),
			'realizada'			=>	$this->input->post('realizada'),
			'embed'				=>	($this->input->post('embed')?$this->input->post('embed'):NULL),
			'coordenadas'		=>	($this->input->post('coordenadas')?$this->input->post('coordenadas'):NULL),
			'latitude'			=>	$this->input->post('latitude'),
			'longitude'			=>	$this->input->post('longitude')
		);

		$this->db->where('idObra',$this->input->post('id'));
		$edit = $this->db->update('obras', $obra);
		
		foreach ($this->config->item('idiomas') as $key => $value) {

			if ($this->input->post('categoria') == 1) {
				$obra_desc = Array(
					'idObra'			=>	$this->input->post('id'),
					'titulo'			=>	$this->input->post('titulo_'.$key),
					'descricao'			=>	$this->input->post('descricao_'.$key),
					'potencia'			=>	$this->input->post('potencia'),
					'rio'				=>	$this->input->post('rio')
				);
			} else {
				$obra_desc = Array(
					'idObra'			=>	$this->input->post('id'),
					'titulo'			=>	$this->input->post('titulo_'.$key),
					'descricao'			=>	$this->input->post('descricao_'.$key),
				);
			}

			$this->db->where('idioma',$key);
			$this->db->where('idObra',$this->input->post('id'));
			$query = $this->db->get('obra_desc');
			if ($query->num_rows() > 0) {
				$this->db->where('idioma', $key);
				$this->db->where('idObra_desc', $query->row()->idObra_desc);
				$edit = $this->db->update('obra_desc', $obra_desc);
			} elseif ($titulo[$key] != '' OR $descricao[$key] != ''){
				$obra_desc['idioma'] = $key;
				$this->db->insert('obra_desc', $obra_desc);
			}
		}

		if ($edit) {
			return TRUE;
		} else {
			return FALSE;
		}
	}

	function apagar() {
		$this->db->where('idObra',$this->uri->segment(4));
		if ($this->db->delete('obras')) {
			$this->db->delete('obra_desc', Array('idObra'=>$this->uri->segment(4)));
			return TRUE;
		} else {
			return FALSE;
		}
	}

	function publicar() {
		$this->db->where('idObra',$this->uri->segment(4));
		if ($this->db->update('obras',Array('publicada'=>1))) {
			return TRUE;
		} else {
			return FALSE;
		}
	}

	function despublicar() {
		$this->db->where('idObra',$this->uri->segment(4));
		if ($this->db->update('obras',Array('publicada'=>0))) {
			return TRUE;
		} else {
			return FALSE;
		}
	}

	function DMStoDEC($deg, $min, $sec) {

	// Converts DMS ( Degrees / minutes / seconds )
	// to decimal format longitude / latitude

		return $deg + ((($min * 60) + ($sec)) / 3600);
	}

}