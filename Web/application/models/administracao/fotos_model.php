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
class Fotos_model extends Model {

	function __construct() {
		parent::Model();
	}

	function listarFotos($id = FALSE) {
		$this->db->select('foto.*');
//		$this->db->join('obra_desc', 'foto.idObra = obra_desc.idObra', 'left');
		$this->db->where('foto.idObra', $id);
		$this->db->order_by('foto.ordem', 'asc');
		$query = $this->db->get('foto');
		return $query;
	}

	function gravar($upload_data = FALSE, $id = FALSE) {
		if ($upload_data && $id) {
			$foto = Array(
				'nome' => $upload_data->{'file_name'},
				'miniatura' => $upload_data->{'raw_name'} . '_thumb' . $upload_data->{'file_ext'},
				'ordem' => $this->db->count_all('foto') + 1,
				'idObra' => $id
			);

			$insert = $this->db->insert('foto', $foto);
			return $this->db->count_all('foto');
		} else {
			return FALSE;
		}
	}

	function ordenar($idObra = FALSE) {
		$fotos = $this->input->post('fotos');
		$ordem = 1;
		foreach ($fotos as $foto) {
			$this->db->where('idFoto', $foto);
			$this->db->where('idObra', $idObra);
			$status = $this->db->update('foto', Array('ordem' => $ordem));
			$ordem++;
		}

		return $status;
	}

	function excluir($foto = FALSE) {
		$query = $this->db->get_where('foto', Array('nome' => $foto));
		if ($query->num_rows() == 1) {
//			$this->db->where('idFoto', $query->row()->idFoto);
			$this->db->delete('foto', Array('idFoto' => $query->row()->idFoto));

			return TRUE;
		} else {
			return FALSE;
		}
	}

	function destaque($foto = FALSE, $idObra = FALSE) {
		$query = $this->db->get_where('foto', Array('nome' => $foto, 'idObra' => $idObra));
		if ($query->num_rows() == 1) {
			$destaque = $this->db->get_where('foto', Array('destaque' => TRUE, 'idObra' => $idObra));
			if ($destaque->num_rows() == 1) {
				$this->db->update('foto', Array('destaque' => FALSE), Array('idFoto' => $destaque->row()->idFoto));
			}
			$this->db->update('foto', Array('destaque' => TRUE), Array('idFoto' => $query->row()->idFoto));
			return TRUE;
		}
		
		return FALSE;
	}

}