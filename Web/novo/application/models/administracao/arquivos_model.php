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

	function listarArquivos($id = FALSE) {
		if (!$id) {
			$query = $this->db->get('arquivo');
			return $query;
		} else {
			$this->db->where('idArquivo', $id);
			$query = $this->db->get('arquivo');
			return $query;
		}
		
	}

	function adicionar($data = FALSE, $upload = FALSE) {
		foreach($data as $controlArray) {
			$newData[$controlArray['name']] = $controlArray['value'];
		}

		$newFile = Array(
			'nome'		=> $newData['nome'],
			'arquivo'	=> $upload->{'file_name'},
			'idGrupo'	=> $this->session->userdata('grupo')
		);

		$this->db->insert('arquivo', $newFile);

		if($this->db->affected_rows()>0) return TRUE;
		else return FALSE;
	}

	function editar($data = FALSE, $upload = FALSE) {
		if (is_array($data)){
			$has_new_file = TRUE;
			foreach($data as $controlArray) {
				$newData[$controlArray['name']] = $controlArray['value'];
			}

			$editFile = Array(
				'nome'		=> $newData['nome'],
				'arquivo'	=> $upload->{'file_name'},
				'idGrupo'	=> $this->session->userdata('grupo')
			);

			$this->db->where('idArquivo',$newData['id']);
		} else {
			$has_new_file = FALSE;
			$editFile = Array(
				'nome' => $this->input->post('nome')
			);
			$this->db->where('idArquivo', $this->input->post('id'));
		}
		
		$edit = $this->db->update('arquivo', $editFile);
		if ($edit) {
			return $has_new_file;
		} else {
			return FALSE;
		}
	}

	function apagar() {
		$this->db->where('idArquivo',$this->uri->segment(4));
		if ($this->db->delete('arquivo')) {
			return TRUE;
		} else {
			return FALSE;
		}
	}

	function notificar($status = FALSE, $fileID = FALSE) {
		if($status) {
			$this->db->set('notificacao', 1);
			$this->db->where('idArquivo', $fileID);
			$this->db->update('arquivo');
		}
	}

}