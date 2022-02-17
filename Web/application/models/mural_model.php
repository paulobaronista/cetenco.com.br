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

	function lerDados($id = FALSE) {
		if (!$id) {
			$this->db->select('mural.*, obras.idCategoria');
			$this->db->join('obras', 'obras.idObra = mural.idObra');
			$this->db->where('mural.realizada', $this->session->userdata('site_obra_status'));
			$query = $this->db->get('mural');
		} else {
			$this->db->select('mural.*, obras.idCategoria');
			$this->db->join('obras', 'obras.idObra = mural.idObra');
			$this->db->where('idMural', $id);
			$query = $this->db->get('mural');
		}
		
		return $query;
		
	}

}