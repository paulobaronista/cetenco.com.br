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

class Textos_model extends Model {

	function __construct() {
		parent::Model();
	}

	function listarTextos($id = FALSE) {
		if (!$id) {
			$this->db->order_by('titulo');
			$query = $this->db->get('texto');

			return $query;
		} else {
			$this->db->where('idTexto', $id);
			$query = $this->db->get('texto');
			return $query;
		}
		
	}

	function adicionar() {
		$novo_texto = Array(
			'titulo'		=>	$this->input->post('titulo'),
			'conteudo'		=>	$this->input->post('conteudo'),
			'publicado'		=>	$this->input->post('publicado')
		);
		$insert = $this->db->insert('texto', $novo_texto);
		return $insert;
	}

	function editar() {
		$texto_editado = Array(
			'titulo'		=>	$this->input->post('titulo'),
			'conteudo'		=>	$this->input->post('conteudo'),
			'publicado'		=>	$this->input->post('publicado')
		);

		$this->db->where('idTexto',$this->input->post('id'));
		$edit = $this->db->update('texto', $texto_editado);
		if ($edit) {
			return TRUE;
		} else {
			return FALSE;
		}
	}

	function apagar() {
		$this->db->where('idTexto',$this->uri->segment(4));
		if ($this->db->delete('texto')) {
			return TRUE;
		} else {
			return FALSE;
		}
	}

	function publicar() {
		$this->db->where('idTexto',$this->uri->segment(4));
		if ($this->db->update('texto',Array('publicado'=>1))) {
			return TRUE;
		} else {
			return FALSE;
		}
	}

	function despublicar() {
		$this->db->where('idTexto',$this->uri->segment(4));
		if ($this->db->update('texto',Array('publicado'=>0))) {
			return TRUE;
		} else {
			return FALSE;
		}
	}

}