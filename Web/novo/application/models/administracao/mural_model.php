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

class Mural_model extends Model {

	function __construct() {
		parent::Model();
	}

	function lerDados($id = FALSE, $status = FALSE) {
		$status = $this->session->userdata('status_obra');
		if ($status == 'realizadas'){
			$status = 1;
		} else if ($status == 'andamento') {
			$status = 0;
		}


		if (!$id) {
			$this->db->where('realizada', $status);
			$query = $this->db->get('mural');
			return $query;
		} else {
			$this->db->where('idMural', $id);
			$query = $this->db->get('mural');
			return $query;
		}
		
	}

	function gravar($upload_data = FALSE, $details = FALSE) {
	 
		if ($upload_data && $details) {
			$foto = Array(
				'idObra'	=> $details['obra'],
				'foto'		=> $upload_data->{'file_name'},
				'miniatura'	=> $upload_data->{'raw_name'}.'_thumb'.$upload_data->{'file_ext'},
			);

			$this->db->where('idMural', $details['id']);
			$is_new = $this->db->get('mural')->num_rows();

			if ($is_new == 1) {
				$this->db->where('idMural', $details['id']);
				$this->db->update('mural', $foto);
			} else {
				$this->db->insert('mural', $foto);
			}

			if ($this->db->affected_rows() > 0) {
				return TRUE;
			} else {
				return FALSE;
			}
		} else {
			$foto = Array(
				'idObra'	=> $this->input->post('obra')
			);

			$this->db->where('idMural', $this->input->post('id'));
			$this->db->update('mural', $foto);

			if ($this->db->affected_rows() > 0) {
				return TRUE;
			} else {
				return FALSE;
			}
		}
	}

}