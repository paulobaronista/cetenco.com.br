<?php
/**
 * @property CI_Loader $load
 * @property CI_URI $uri
 * @property CI_Form_validation $form_validation
 * @property CI_Input $input
 * @property CI_Email $email
 * @property CI_DB_active_record $db
 * @property CI_DB_forge $dbforge
 * @property CI_Session $session
 */

class Arquivos extends Controller {

	function __construct() {
		parent::Controller();
        if (!$this->session->userdata('is_logged_in')) redirect('administracao/access');
		$this->load->model('administracao/arquivos_model');
		$this->load->model('administracao/usuarios_model');
		$this->load->helper('download');
	}

	function index() {
		$this->session->set_userdata('page_title','Administração | Arquivos');

		$data['menu'] = buildMenu('arquivos');
		$data['registros'] = $this->arquivos_model->listarArquivos();
		$data['main_content'] = 'administracao/arquivos_view';
		$this->load->view('administracao/includes/template', $data);
	}

	function adicionar() {
		if (!$this->input->post('filearray')){
			$this->load->view('administracao/arquivos_ajax_view');
		} else {
			if ($this->input->post('filearray') != "ERROR") {
				$upload_data = json_decode($this->input->post('filearray'));
				$form_data = $this->input->post('data');
				$status = $this->arquivos_model->adicionar($form_data, $upload_data);
				if ($status) {
					//$this->notificar($this->db->insert_id());
				}
			}
		}
	}

	function editar() {
		if (!$this->input->post('data') && !$this->input->post('action')){
			$query = $this->arquivos_model->listarArquivos($this->uri->segment(4));
			$data['linha'] = $query->row_array();
			$this->load->view('administracao/arquivos_ajax_view', $data);
		} else if ($this->input->post('action') == 'editar'){
			$status = $this->arquivos_model->editar();
			redirect('administracao/arquivos');
		} else {
			if ($this->input->post('filearray') != "ERROR") {
				$upload_data = json_decode($this->input->post('filearray'));
				$form_data = $this->input->post('data');
				$status = $this->arquivos_model->editar($form_data, $upload_data);
				if ($status) {
					return TRUE;
				} else {
					return FALSE;
				}
			}
		}
	}

	function apagar() {
		$arquivo = $this->arquivos_model->listarArquivos($this->uri->segment(4))->row();
		$filePath = realpath('arquivos/'.$arquivo->arquivo);
		if (unlink($filePath)) {
			if ($this->arquivos_model->apagar($this->uri->segment(4))) {
				redirect('administracao/arquivos');
			}
		}
		
	}

	function download() {
		$url = base_url() . 'arquivos/' . $this->uri->segment(4);
		$file = file_get_contents($url);
		force_download($this->uri->segment(4), $file);
	}

	function notificar($fileID = FALSE) {
		$config = Array(
			'protocol'	=> 'smtp',
			'smtp_host'	=> 'DIGITAR AQUI O ENDEREÇO DO SERVIDOR DE EMAIL',
			'smtp_port'	=> 'DIGITAR AQUI A PORTA DO SERVIDOR',
			'smtp_user'	=> 'DIGITAR AQUI O USUÁRIO (em geral, é o email inteiro)',
			'smtp_pass'	=> 'DIGITAR AQUI A SENHA PARA A CONTA CITADA ACIMA',
			'newline'	=> "\r\n"
		);

		$this->load->library('email', $config);

		$file = $this->arquivos_model->listarArquivos($this->uri->segment(4))->row();

		$this->firephp->log($file);

		if (!is_file(realpath('arquivos/'.$file->arquivo))) {
			$file = $this->arquivos_model->listarArquivos($fileID)->row();
		}

		$grupo = $file->idGrupo;

		$usuarios = $this->usuarios_model->filtrar($grupo);

		foreach ($usuarios->result() as $usuario) {
			$this->email->from('caio.guimaraes@gmail.com', 'Caio Guimarães');
			$this->email->subject('Novo arquivo adicionado');
			$this->email->message("Um novo arquivo foi adicionado.");
			$this->email->to($usuario->email);
			if($this->email->send()) {
				$status = TRUE;
			} else {
				$status = FALSE;
			}
		}

		$this->arquivos_model->notificar($status, $id);
		redirect('administracao/arquivos');
	}

}