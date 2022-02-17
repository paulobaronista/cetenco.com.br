<?php

class Mapa_do_site extends Controller {

	function __construct() {
		parent::Controller();

		$this->lang->load('sitemap');

		$this->session->set_userdata('site_idioma', $this->lang->lang());
	}

	function index() {
		$data['main_content'] = 'sitemap_view';
		$this->load->view('includes/template', $data);
	}

}