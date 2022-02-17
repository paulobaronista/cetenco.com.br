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

class Pastas_model extends Model {

	function __construct() {
		parent::Model();
	}
	
	function criar($pasta) {
		$new_folder = Array(
			'path'	=> $pasta
		);
		
		$this->db->insert('pastas', $new_folder);
		
		return $this->db->affected_rows() > 0;
	}
	
	function listar() {
		$this->db->order_by('path');
		return $this->db->get('pastas');
	}
	
	function editar($oldname,$newname) {
		//atualiza tabela Pastas
		$this->db->update('pastas',Array('path'=>$newname),Array('path'=>$oldname));
		
		if ($this->db->affected_rows() > 0)
			//atualiza a tabela Arquivo
			$this->db->update('arquivo',Array('path'=>$newname),Array('path'=>$oldname));
		
		return $this->db->affected_rows() > 0;
	}
	
	function excluir($path) {
		$this->db->where('path',$path);
		$this->db->delete('pastas');
		
		return $this->db->affected_rows() > 0;
	}
	
}