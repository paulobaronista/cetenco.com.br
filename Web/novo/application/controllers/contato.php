<?php

class Contato extends Controller {

	function __construct() {
		parent::Controller();

		$this->lang->load('menu');
		$this->lang->load('messages');

		$this->session->set_userdata('site_idioma', $this->lang->lang());
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
				$config = Array(
					'protocol' => 'smtp',
					'smtp_host' => 'ssl://smtp.googlemail.com',
					'smtp_port' => 465,
					'smtp_user' => 'caio.guimaraes@gmail.com',
					'smtp_pass' => 'golias',
					'mailtype' => 'html',
					'newline' => "\r\n"
				);

				$this->load->library('email', $config);
				
				$this->email->from('caio.guimaraes@gmail.com', 'Cetenco Engenharia S.A.');
				$this->email->reply_to($this->input->post('email'), $this->input->post('nome'));
				$this->email->to('caio.guimaraes@gmail.com');
//					$this->email->from('contato@cetenco.com.br', 'Cetenco Engenharia S.A.');
//					$this->email->reply_to($this->input->post('email'), $this->input->post('nome'));
//					$this->email->to('contato@cetenco.com.br');

				$this->email->subject($this->input->post('txtAssunto'));
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

	function trabalhe_conosco() {
		$this->load->model('trabalhe_conosco_model');
		foreach($this->trabalhe_conosco_model->listar_departamentos()->result() as $depto) {
			$data['areas'][$depto->id] = $depto->nome;
		}

		if (!$this->input->post('enviar')) {
			$data['main_content'] = 'trabalhe_conosco_view';
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
				$data['main_content'] = 'trabalhe_conosco_view';
				$this->load->view('includes/template', $data);
			} else {
				if ($this->_upload()){
					$this->trabalhe_conosco_model->gravar();

					$config = Array(
						'protocol' => 'smtp',
						'smtp_host' => 'ssl://smtp.googlemail.com',
						'smtp_port' => 465,
						'smtp_user' => 'caio.guimaraes@gmail.com',
						'smtp_pass' => 'golias',
						'mailtype' => 'html',
						'newline' => "\r\n"
					);

					$this->load->library('email', $config);
					
					$upload_data = $this->upload->data();
					$this->email->from('caio.guimaraes@gmail.com', 'Cetenco Engenharia S.A.');
					$this->email->reply_to($this->input->post('email'), $this->input->post('nome'));
					$this->email->to('caio.guimaraes@gmail.com');
//					$this->email->from('contato@cetenco.com.br', 'Cetenco Engenharia S.A.');
//					$this->email->reply_to($this->input->post('email'), $this->input->post('nome'));
//					$this->email->to('contato@cetenco.com.br');

					$this->email->subject($this->input->post('txtAssunto'));
					$this->email->message($this->load->view('contato_email_view','',TRUE));
					$this->email->attach($upload_data['full_path']);

					if ($this->email->send()) {
						$data['titulo'] = lang('menu_trabalhe_conosco');
						$data['conteudo'] = '<p style="font-size:16px">' . lang('mensagem_trabalhe_enviada') . '</p>';

						$data['main_content'] = 'interna_view';
						$this->load->view('includes/template', $data);
					} else {
						show_error($this->email->print_debugger());
					}
				} else {
					$data['titulo'] = lang('menu_trabalhe_conosco');
					$data['conteudo'] = '<p style="font-size:16px">' . lang('sem_curriculo') . '</p>';
					$data['main_content'] = 'interna_view';
					$this->load->view('includes/template', $data);
				}
			}
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
