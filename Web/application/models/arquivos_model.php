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

	function listarArquivos($filtro = FALSE) {
		$this->db->where('idGrupo <=', $this->session->userdata('site_grupo'));
		
		if ($filtro)
			return $this->db->get_where('arquivo', Array('path' => ($filtro == 'root' ? NULL : $filtro)));
		else
			return $this->db->get('arquivo');
		
//		$query = $this->db->get('arquivo');
//		return $query;
	}
	
	function listar_pastas_com_arquivos() {
		$this->db->select('path');
		$this->db->distinct();
		return $this->db->get('arquivo');
	}
	
	function get_folder($file = NULL) {
		$this->db->select('path');
		return $this->db->get_where('arquivo',Array('arquivo'=>$file));
	}
}