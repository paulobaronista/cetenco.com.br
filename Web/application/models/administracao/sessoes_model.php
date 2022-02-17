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

class Sessoes_model extends Model {

	function __construct() {
		parent::Model();
	}

	function listarSessoes($id = FALSE) {
		if (!$id) {
			$query = $this->db->get('sessao');
			return $query;
		} else {
			$this->db->where('idSessao', $id);
			$query = $this->db->get('sessao');
			return $query;
		}
		
	}

}