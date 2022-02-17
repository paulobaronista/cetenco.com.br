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

	function listarArquivos($id = FALSE, $filtro = FALSE) {
		if (!$id) {
			if ($filtro)
				return $this->db->get_where('arquivo', Array('path'=>($filtro == 'root' ? NULL : $filtro)));
			else
				return $this->db->get('arquivo');
			
		} else {
			$this->db->where('idArquivo', $id);
			$query = $this->db->get('arquivo');
			return $query;
		}
	}
	
	function listar_pastas_com_arquivos() {
		$this->db->select('path');
		$this->db->distinct();
		return $this->db->get('arquivo');
	}

	function adicionar($file = FALSE, $group = 1, $path = 'root') {
		$new_file = Array(
			'nome'		=> ucwords(str_replace('-', ' ', $file->raw_name)),
			'arquivo'	=> $file->file_name,
			'idGrupo'	=> $group
		);
		
		if ($path AND $path != 'root')
			$new_file['path'] = $path;

		$this->db->insert('arquivo', $new_file);

		return $this->db->affected_rows() > 0;
	}

	function editar($data = FALSE, $upload = FALSE) {
		$editFile = Array(
			'nome' => $this->input->post('nome'),
			'idGrupo' => $this->input->post('grupo')
		);
		
		if ($this->input->post('path') != 'root')
			$editFile['path'] = $this->input->post('path');
		else
			$editFile['path'] = NULL;
		
		$this->db->where('idArquivo', $this->input->post('id'));

		$this->db->update('arquivo', $editFile);
		
		return $this->db->affected_rows() > 0;
	}

	function apagar() {
		$this->db->where('idArquivo',$this->uri->segment(4));
		if ($this->db->delete('arquivo')) {
			return TRUE;
		} else {
			return FALSE;
		}
	}

	function notificar($status = FALSE, $file_data = FALSE) {
		if($status) {
			switch (gettype($file_data)) {
				case 'array':
					foreach($file_data as $file) {
						$this->db->set('notificacao', 1);
						$this->db->where('idArquivo', $file['insert_id']);
						$this->db->update('arquivo');
					}
					break;
				default:
					$this->db->set('notificacao', 1);
					$this->db->where('idArquivo', $fileID);
					$this->db->update('arquivo');
					break;
			}
		}
	}

}