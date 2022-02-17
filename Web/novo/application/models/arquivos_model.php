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

class Arquivos_model extends Model {

	function __construct() {
		parent::Model();
	}

	function listarArquivos() {
		$this->db->where('idGrupo >=', $this->session->userdata('site_grupo'));
		$query = $this->db->get('arquivo');
		return $query;
	}
}