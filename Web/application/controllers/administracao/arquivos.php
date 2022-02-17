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
		$this->load->model('administracao/pastas_model');
		$this->load->model('administracao/usuarios_model');
		$this->load->helper('download');
	}

	function index() {
		$this->session->set_userdata('page_title','Administração | Arquivos');
		
		$this->load->helper('directory');
		
		$pastas = $this->pastas_model->listar();
		
		$data['edit_folders'] = $pastas->num_rows() > 0 ? TRUE : FALSE;
		
		foreach ($pastas->result() as $pasta) {
			if (is_dir($folder = './arquivos/'.$pasta->path)) {
				$directory_map = directory_map($folder);
				if (empty($directory_map)) {
					$data['pastas_vazias'][] = str_replace('./arquivos/', '', $folder);
				}
			}
		}
		
		$data['options']['none'] = 'Sem filtro';
		foreach ($this->arquivos_model->listar_pastas_com_arquivos()->result() as $item) {
			if (!is_null($item->path))
				$data['options'][$item->path] = $item->path;
			else
				$data['options']['root'] = 'PASTA PRINCIPAL';
		}
		
		if ($this->input->post('filtro') AND $this->input->post('filtro') != 'none')
			$data['registros'] = $this->arquivos_model->listarArquivos(FALSE,$this->input->post('filtro'));
		else
			$data['registros'] = $this->arquivos_model->listarArquivos();

		$data['menu'] = buildMenu('arquivos');
		$data['main_content'] = 'administracao/arquivos_view';
		$this->load->view('administracao/includes/template', $data);
	}

	function adicionar() {
		if (!is_ajax()){
			$pastas = $this->pastas_model->listar();

			$data['pastas']['root'] = 'Sem subpasta';
			foreach ($pastas->result() as $pasta) {
				$data['pastas'][$pasta->path] = $pasta->path;
			}
			
			$data['menu'] = buildMenu('arquivos');
			$data['main_content'] = 'administracao/arquivos_adicionar_view';
			$this->load->view('administracao/includes/template', $data);
		} else {
			$files = $this->input->post('ajax_data');
			$group = $this->input->post('group');
			$path = $this->input->post('path');
			foreach ($files as $file) {
				if ($file != "ERROR") {
					$file = json_decode($file);
					$status = $this->arquivos_model->adicionar($file, $group, $path);
					if ($status) {
	//					$this->notificar($this->db->insert_id());
						$successful_files[] = Array(
							'insert_id'	=> $this->db->insert_id(),
							'name'		=> ucwords(str_replace('-', ' ', $file->raw_name))
						);
					} else {
						$successful_files = NULL;
					}
				}
			}
			
//			if (!is_null($successful_files)) $this->notificar($successful_files);
			
			echo 'done';
		}
	}

	function editar() {
		if (!$this->input->post('data') && !$this->input->post('action')){
			$pastas = $this->pastas_model->listar();

			$data['pastas']['root'] = 'Sem subpasta';
			foreach ($pastas->result() as $pasta) {
				$data['pastas'][$pasta->path] = $pasta->path;
			}
			
			$query = $this->arquivos_model->listarArquivos($this->uri->segment(4));
			$data['linha'] = $query->row_array();
			if (!is_null($query->row()->path))
				$data['actual_path'] = $query->row()->path;
			else
				$data['actual_path'] = 'root';
			
			$data['menu'] = buildMenu('arquivos');
			$data['main_content'] = 'administracao/arquivos_editar_view';
			$this->load->view('administracao/includes/template', $data);
		} else if ($this->input->post('action') == 'editar'){
			$query = $this->arquivos_model->listarArquivos($this->input->post('id'));
			
			if ((is_null($query->row()->path) AND $this->input->post('path') != 'root') || $query->row()->path != $this->input->post('path')) {
				$oldname = is_null($query->row()->path) ? './arquivos/'.$query->row()->arquivo : './arquivos/'.$query->row()->path.'/'.$query->row()->arquivo;
				$newname = $this->input->post('path') == 'root' ? './arquivos/'.$query->row()->arquivo : './arquivos/'.$this->input->post('path').'/'.$query->row()->arquivo;
				rename($oldname, $newname);
			}
				
			$status = $this->arquivos_model->editar();
			redirect('administracao/arquivos');
		}
	}

	function apagar() {
		$arquivo = $this->arquivos_model->listarArquivos($this->uri->segment(4))->row();
		if (!is_null($arquivo->path))
			$filePath = realpath('arquivos/'.$arquivo->path.'/'.$arquivo->arquivo);
		else
			$filePath = realpath('arquivos/'.$arquivo->arquivo);
		
		if (is_file($filePath) AND unlink($filePath)) {
			if ($this->arquivos_model->apagar($this->uri->segment(4))) {
				redirect('administracao/arquivos');
			} else {
				show_error('Parece que houve um erro ao tentar apagar o arquivo do Banco de Dados, por favor novamente.');
			}
		} else {
			show_error('Não foi possível encontrar o arquivo indicado para excluir.');
		}
		
	}

	function download() {
		$url = base_url() . 'arquivos/' . $this->uri->segment(4);
		$file = file_get_contents($url);
		force_download($this->uri->segment(4), $file);
	}

	function notificar($file_data = NULL) {
		$config = Array(
					'protocol' => 'smtp',
					'smtp_host' => 'smtp.cetenco.com.br',
					'smtp_port' => 25,
					'smtp_user' => 'contato@cetenco.com.br',
					'smtp_pass' => 'primus2147',
					'mailtype' => 'html',
					'newline' => "\r\n"
				);

		$this->load->library('email', $config);
		
		switch (gettype($file_data)) {
			case 'array':
				foreach($file_data as $file) {
					$data['lista'][] = $file['name'];
				}
				
				$data['atributos'] = 'style="font-size: 12px; line-height: 20px; font-weight: normal; color: #56667d; margin: 0; padding: 0; margin-bottom: 10px;"';
				
				$grupo = $this->input->post('group');

				$usuarios = $this->usuarios_model->filtrar($grupo);
				
				foreach ($usuarios->result() as $usuario) {
					$this->email->from('contato@cetenco.com.br', 'Cetenco - Contato');
					$this->email->subject('Novo arquivo adicionado');
					$this->email->message($this->load->view('administracao/email/email_full_width_view',$data,TRUE));
					$this->email->to($usuario->email);
					if($this->email->send()) {
						$status = TRUE;
					} else {
						$status = FALSE;
					}
				}

				$this->arquivos_model->notificar($status, $file_data);
				break;
			default:
				$file = $this->arquivos_model->listarArquivos($this->uri->segment(4))->row();

				if (!is_file(realpath('arquivos/'.$file->arquivo))) {
					$file = $this->arquivos_model->listarArquivos($file_data)->row();
				}

				$grupo = $file->idGrupo;

				$usuarios = $this->usuarios_model->filtrar($grupo);

				foreach ($usuarios->result() as $usuario) {
					$this->email->from('contato@cetenco.com.br', 'Cetenco - Contato');
					$this->email->subject('Novo arquivo adicionado');
					$this->email->message("Um novo arquivo foi adicionado.");
					$this->email->to($usuario->email);
					if($this->email->send()) {
						$status = TRUE;
					} else {
						$status = FALSE;
					}
				}

				$this->arquivos_model->notificar($status, $file_data);
				redirect('administracao/arquivos');
				break;
		}

	}
	
	function criar_pasta() {
		$pastas = $this->pastas_model->listar();
		
		$data['pastas']['root'] = 'Sem subpasta';
		foreach($pastas->result() as $pasta) {
			$data['pastas'][$pasta->path] = $pasta->path;
		}
		
		if (!$this->input->post('path') || $this->input->post('path') == 'root')
			$pasta = './arquivos/'.$this->input->post('pasta');
		else
			$pasta = './arquivos/'.$this->input->post('path').'/'.$this->input->post('pasta');
		
		$this->load->library('form_validation');
		
		$this->form_validation->set_rules('pasta', 'Pasta', 'required|alpha_dash|max_length[128]|callback_folder_exists');
		
		if ($this->form_validation->run()) {
			if (mkdir($pasta)) {
				$this->pastas_model->criar(str_replace('./arquivos/', '', $pasta));
				redirect('administracao/arquivos');
			} else {
				show_error('Não foi possível criar a pasta');
			}
		}
		
		if (!is_ajax()) {
			$data['menu'] = buildMenu('arquivos');
			$data['main_content'] = 'administracao/arquivos_pasta_view';
			$this->load->view('administracao/includes/template', $data);
		} else {
			$this->load->view('administracao/arquivos_pasta_view', $data);
		}
	}
	
	function editar_pastas() {
		$pastas = $this->pastas_model->listar();
		
		if (!$this->input->post('pasta')) {
			$data['pastas'] = $pastas;
			$this->load->view('administracao/pastas_disponiveis_view',$data);
		} else if ($this->input->post('pasta') AND !$this->input->post('path')) {
			$data['pasta_atual'] = end(explode('/',$this->input->post('pasta')));
			$data['path'] = str_replace('/'.$data['pasta_atual'], '', $this->input->post('pasta'));
			
			$this->load->view('administracao/pastas_editar_view',$data);
		} else if ($this->input->post('path')) {
			$oldname = $this->input->post('path') == 'root' ? './arquivos/'.$this->input->post('old_folder') : './arquivos/'.$this->input->post('path').'/'.$this->input->post('old_folder');
			$newname = $this->input->post('path') == 'root' ? './arquivos/'.$this->input->post('pasta') : './arquivos/'.$this->input->post('path').'/'.$this->input->post('pasta');
			if (rename($oldname, $newname)) {
				$this->pastas_model->editar(str_replace('./arquivos/', '', $oldname),  str_replace('./arquivos/', '', $newname));
			}
			
			echo 1;
		}
		
	}
	
	function pastas_vazias() {
		$this->load->helper('directory');
		
		$pastas = $this->pastas_model->listar();
		
		foreach ($pastas->result() as $pasta) {
			if (is_dir($folder = './arquivos/'.$pasta->path)) {
				$directory_map = directory_map($folder);
				if (empty($directory_map)) {
					$data['pastas_vazias'][] = str_replace('./arquivos/', '', $folder);
				}
			}
		}
		
		if (!is_ajax()) {
			show_error('Você não pode visualizar esta página');
		} else {
			if ($folders = $this->input->post('pastas')) {
				foreach ($folders as $folder) {
					if (rmdir('./arquivos/'.$folder))
						$this->pastas_model->excluir($folder);
				}
				
				echo 1;
			} else {
				$this->load->view('administracao/pastas_vazias_view',$data);
			}
		}
	}
	
	function folder_exists($str = NULL) {
		if (!is_ajax()) {
			if (is_dir($str)) {
				$this->form_validation->set_message('folder_exists', 'Desculpe, esta pasta já existe.');
				return FALSE;
			} else {
				return TRUE;
			}
		} else {
			$pasta = $this->input->post('path') == 'root' ? $this->input->post('pasta') : $this->input->post('path') . '/' . $this->input->post('pasta');
			echo is_dir('/arquivos/' . $pasta) ? 1 : 0;
		}
	}

}