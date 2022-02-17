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
class Site extends Controller {

	function __construct() {
		parent::Controller();
		$this->load->model('destaques_model');

		$this->session->set_userdata('site_idioma', $this->lang->lang());
	}

	function index() {
		if ($this->lang->lang() == 'es') {
			$data['lang_css'] = 'class="es"';
		} else if ($this->lang->lang() == 'en') {
			$data['lang_css'] = 'class="en"';
		}
		
		$data['destaques']	= $this->destaques_model->listar();

		$realizada = $this->destaques_model->listar('',FALSE,TRUE);
		$andamento = $this->destaques_model->listar('',FALSE,FALSE);
		$data['realizada']	= $realizada->row(mt_rand(0, $realizada->num_rows()-1));
		$data['andamento']	= $andamento->row(mt_rand(0, $andamento->num_rows()-1));
//		$data['timeline']	= $this->timeline_model->listar();
		

		$data['main_content'] = 'site_view';
		$this->load->view('includes/template', $data);
	}

}