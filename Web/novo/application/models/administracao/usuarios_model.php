<?php
class Usuarios_model extends Model{

	function __construct() {
		parent::Model();
	}

	function login() {
		$this->db->where('usuario', $this->input->post('usuario'));
		$this->db->where('senha', md5($this->input->post('senha')));
		$query = $this->db->get('usuario');

		if ($query->num_rows() == 1) {
			if ($query->row()->is_admin == 1) {
				$this->_getUserData();
				return TRUE;
			} else {
				$this->session->set_flashdata('erro','Você não tem acesso a essa área');
				return FALSE;
			}
		} else {
			$this->session->set_flashdata('erro','Usuário ou Senha inválido');
			return FALSE;
		}
	}

	function listarUsuarios($id = FALSE) {
		if (!$id) {
			$query = $this->db->get('usuario');
			return $query;
		} else {
			$this->db->where('idUsuario', $id);
			$query = $this->db->get('usuario');
			return $query;
		}
	}
	
	function filtrar($idGrupo = FALSE) {
		$this->db->where('idGrupo <', $idGrupo+1);
		$query = $this->db->get('usuario');
		return $query;
	}

	function adicionar() {
		$novo_usuario = Array(
			'nome'		=>	$this->input->post('nome'),
			'usuario'	=>	$this->input->post('usuario'),
			'senha'		=>	md5($this->input->post('senha')),
			'email'		=>	$this->input->post('email'),
			'idGrupo'	=>	$this->input->post('nivel'),
			'is_admin'	=>	$this->input->post('grupo')
		);
		$insert = $this->db->insert('usuario', $novo_usuario);
		return $insert;
	}

	function editar() {
		$usuario_editado = Array(
			'nome'		=>	$this->input->post('nome'),
			'usuario'	=>	$this->input->post('usuario'),
			'senha'		=>	md5($this->input->post('senha')),
			'email'		=>	$this->input->post('email'),
			'idGrupo'	=>	$this->input->post('nivel'),
			'is_admin'	=>	$this->input->post('grupo')
		);

		$this->db->where('idUsuario',$this->input->post('id'));
		$edit = $this->db->update('usuario', $usuario_editado);
		if ($edit) {
			return TRUE;
		} else {
			return FALSE;
		}
	}

	function apagar() {
		$this->db->where('idUsuario',$this->uri->segment(4));
		if ($this->db->delete('usuario')) {
			return TRUE;
		} else {
			return FALSE;
		}
	}

	function _getUserData() {
		$this->db->where('usuario', $this->input->post('usuario'));
		$query = $this->db->get('usuario');

		if ($query->num_rows() == 1) {
			$userdata = Array(
				'nome'		=>	$query->row()->nome,
				'usuario'	=>	$query->row()->usuario,
				'grupo'		=>	$query->row()->idGrupo
			);
			$this->session->set_userdata($userdata);
		}
	}

}