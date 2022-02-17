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

class Certificacoes_model extends Model {

	function __construct() {
		parent::Model();
	}

	function listarCertificacoes($id = FALSE) {
		if (!$id) {
			$query = $this->db->get('certificacao');
			return $query;
		} else {
			$this->db->where('idCertificacao', $id);
			$query = $this->db->get('certificacao');
			return $query;
		}
		
	}

	function adicionar() {
		$novo_certificacao = Array(
			'codigo'		=>	$this->input->post('codigo'),
			'implantada'	=>	$this->input->post('implantada')
		);
		$insert = $this->db->insert('certificacao', $novo_certificacao);
		return $insert;
	}

	function editar() {
		$certificacao_editado = Array(
			'codigo'		=>	$this->input->post('codigo'),
			'implantada'	=>	$this->input->post('implantada')
		);

		$this->db->where('idCertificacao',$this->input->post('id'));
		$edit = $this->db->update('certificacao', $certificacao_editado);
		if ($edit) {
			return TRUE;
		} else {
			return FALSE;
		}
	}

	function apagar() {
		$this->db->where('idCertificacao',$this->uri->segment(4));
		if ($this->db->delete('certificacao')) {
			return TRUE;
		} else {
			return FALSE;
		}
	}

	function implantar() {
		if ($this->uri->segment(5) == 'sim') {
			$this->db->where('idCertificacao',$this->uri->segment(4));
			if ($this->db->update('certificacao',Array('implantada'=>1))) {
				return TRUE;
			} else {
				return FALSE;
			}
		} elseif ($this->uri->segment(5) == 'nao') {
			$this->db->where('idCertificacao',$this->uri->segment(4));
			if ($this->db->update('certificacao',Array('implantada'=>0))) {
				return TRUE;
			} else {
				return FALSE;
			}
		}
	}

}