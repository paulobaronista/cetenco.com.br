<?php

class Contato extends Controller {

	function __construct() {
		parent::Controller();

		$this->lang->load('menu');
		$this->lang->load('messages');

		$this->session->set_userdata('site_idioma', $this->lang->lang());
		//date_default_timezone_set('America/Sao_Paulo');
	}

	function index() {
		$this->load->model('trabalhe_conosco_model');
		foreach($this->trabalhe_conosco_model->listar_departamentos()->result() as $depto) {
			$data['areas'][$depto->nome] = $depto->nome;
		}

		if(!$this->input->post('enviar')){
			$data['main_content'] = 'contato_view';
			$this->load->view('includes/template', $data);
		} else {
			
			$this->load->library('form_validation');

			$this->form_validation->set_error_delimiters('<span class="system negative">', '</span>');

			$this->form_validation->set_rules('txtNome', 'Nome', 'trim|required');
			$this->form_validation->set_rules('txtEmail', 'Email', 'trim|required|valid_email');
			$this->form_validation->set_rules('txtAssunto', 'Assunto', 'trim|required');
			$this->form_validation->set_rules('txtArea', 'Área', 'trim|callback__areaCheck');
			$this->form_validation->set_rules('txtMensagem', 'Mensagem', 'trim|required');

			if ($this->form_validation->run() == FALSE) {
				$data['main_content'] = 'contato_view';
				$this->load->view('includes/template', $data);
			} else {
				
				switch($this->input->post('txtArea')){
					case "Administrativo": $emailTo = "adm@cetenco.com.br";
					break;
					case "Tecnologia da Informação": $emailTo = "ti@cetenco.com.br";
					break;
					case "Administração de Obras": $emailTo = "engenharia@cetenco.com.br";
					break;
					case "Comercial": $emailTo = "comercial@cetenco.com.br";
					break;
					case "Diretoria": $emailTo = "adm@cetenco.com.br";
					break;
					case "Engenharia": $emailTo = "engenharia@cetenco.com.br";
					break;
					case "Financeiro": $emailTo = "financeiro@cetenco.com.br";
					break;
					case "Jurídico": $emailTo = "juridico@cetenco.com.br";
					break;
					case "Recursos Humanos": $emailTo = "rh.dp@cetenco.com.br";
					break;
					case "Suprimentos": $emailTo = "suprimentos@cetenco.com.br";
					break;
					default: die('Área não selecionada.');
					break;
				}
				
				$config = Array(
					'protocol' => 'smtp',					
					'smtp_host' => 'smtp.cetenco.com.br',					
					'smtp_port' => 587,
					'smtp_user' => 'contato@cetenco.com.br',
					'smtp_pass' => 'primus2147',
					'mailtype' => 'html',
					'newline' => "\r\n"
				);
				$this->load->library('email', $config);
				
				$this->email->from('contato@cetenco.com.br', 'Cetenco Engenharia S.A.');
				$this->email->reply_to($this->input->post('txtEmail'));
				$this->email->to($emailTo);
				//$this->email->to('contato@cetenco.com.br');
				//$this->email->to('gilbertogalindo@spicyweb.com.br');

				$this->email->subject('CONTATO - '.$this->input->post('txtNome').' - '.$this->input->post('txtAssunto'));
				$this->email->message($this->load->view('contato_email_view','',TRUE));

				if ($this->email->send()) {
					$data['titulo'] = lang('menu_trabalhe_conosco');
					$data['conteudo'] = '<p style="font-size:16px">'.lang('mensagem_enviada').'</p>';

					$data['main_content'] = 'interna_view';
					$this->load->view('includes/template', $data);
				} else {
					show_error($this->email->print_debugger());
				}
			}
		}
	}	
	
	function teste(){
		$this->load->view('contato_email_view');
	}
	
	function trabalhe_conosco() {
		$this->load->model('trabalhe_conosco_model');
		foreach($this->trabalhe_conosco_model->listar_departamentos()->result() as $depto) {
			$data['areas'][$depto->id] = $depto->nome;
		}

		$this->load->library('form_validation');

		$this->form_validation->set_error_delimiters('<span class="system negative">', '</span>');

		$this->form_validation->set_rules('txtNome', 'Nome', 'trim|required');
		$this->form_validation->set_rules('txtEmail', 'Email', 'trim|required|valid_email');
		$this->form_validation->set_rules('txtAssunto', 'Assunto', 'trim|required');
		$this->form_validation->set_rules('txtArea', 'Área', 'trim|callback__areaCheck');
		$this->form_validation->set_rules('txtMensagem', 'Mensagem', 'trim|required');

		if ($this->form_validation->run()) {
			if ($this->_upload()){
				$this->trabalhe_conosco_model->gravar();

				$config = Array(
					'protocol' => 'smtp',
					'smtp_host' => 'smtp.cetenco.com.br',
					'smtp_port' => 587,
					'smtp_user' => 'contato@cetenco.com.br',
					'smtp_pass' => 'primus2147',
					'mailtype' => 'html',
					'newline' => "\r\n"
				);

				$this->load->library('email', $config);

				$upload_data = $this->upload->data();

				$this->email->from('contato@cetenco.com.br', 'Cetenco Engenharia S.A.');
				$this->email->reply_to($this->input->post('txtEmail'));
				$this->email->to('contato@cetenco.com.br');

				$this->email->subject('TRABALHE CONOSCO - '.$this->input->post('txtNome').' - '.$this->input->post('txtAssunto'));
				$this->email->message($this->load->view('contato_email_view',$data,TRUE));
				$this->email->attach($upload_data['full_path']);
//				$this->email->attach($upload_data['file_name'] . '.pdf');
				
				
				if ($this->email->send()) {
					$is_uploaded_file = TRUE;
					$data['titulo'] = lang('menu_trabalhe_conosco');
					$data['conteudo'] = '<p style="font-size:16px">' . lang('mensagem_trabalhe_enviada') . '</p>';

					$data['main_content'] = 'interna_view';
					$this->load->view('includes/template', $data);
				} else {
					show_error($this->email->print_debugger());
				}
			} else {
				$is_uploaded_file = FALSE;
			}
		}

		if (isset($is_uploaded_file) AND $is_uploaded_file === FALSE) {
			$data['titulo'] = lang('menu_trabalhe_conosco');
			$data['conteudo'] = '<p style="font-size:16px">' . lang('sem_curriculo') . '</p>';
			$data['main_content'] = 'interna_view';
			$this->load->view('includes/template', $data);
		} else
			if (!isset($is_uploaded_file)) {
				$data['main_content'] = 'trabalhe_conosco_view1';
				$this->load->view('includes/template', $data);
			}
	}

	function _areaCheck($str) {
		if ($str == '0') {
			$this->form_validation->set_message('_areaCheck', lang('selecione_departamento'));
			return FALSE;
		} else {
			return TRUE;
		}
	}

	function _upload() {
		$config['upload_path'] = realpath('./curriculos/');
		$config['allowed_types'] = 'doc|docx|pdf';
		$config['max_size'] = '5120';
		$config['file_name'] = url_title(substr($_FILES['userfile']['name'],0, strlen($_FILES['userfile']['name'])-4),'underscore',TRUE);
		
		$this->load->library('upload');

		$this->upload->initialize($config);

		if (!$this->upload->do_upload()) {
			return FALSE;
		} else {
			return TRUE;
		}
	}

	function convert($size) {
		$unit=array('b','kb','mb','gb','tb','pb');
		return @round($size/pow(1024,($i=floor(log($size,1024)))),2).' '.$unit[$i];
	}

}
