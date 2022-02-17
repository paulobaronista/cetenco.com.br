<?php
class Usuarios_model extends Model{

	function __construct() {
		parent::Model();
	}

	function login() {
		$this->db->where('usuario', $this->input->post('usuario'));
		$this->db->where('senha', md5($this->input->post('senha')));
		$this->db->where('is_admin', FALSE);
		$query = $this->db->get('usuario');

		if ($query->num_rows() == 1) {
			$this->_getUserData();
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
				'site_nome'		=>	$query->row()->nome,
				'site_usuario'	=>	$query->row()->usuario,
				'site_grupo'		=>	$query->row()->idGrupo
			);
			$this->session->set_userdata($userdata);
		}
	}

}