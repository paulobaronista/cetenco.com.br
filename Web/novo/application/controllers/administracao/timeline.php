<?php

class Timeline extends Controller {

	function __construct() {
		parent::Controller();
		if (!$this->session->userdata('is_logged_in')) redirect('administracao/access');

		$this->load->model('administracao/timeline_model');
		$this->load->model('administracao/obras_model');
		$this->load->model('administracao/fotos_model');
	}

	function index() {
		$this->session->set_userdata('page_title', 'Administração | Linha do tempo');
		$data['timeline'] = $this->timeline_model->listar();

		$data['menu'] = buildMenu('timeline', 'Linha do Tempo');
		$data['main_content'] = 'administracao/timeline_view';
		$this->load->view('administracao/includes/template', $data);
	}

	function lerFotos(){
		$id = $this->input->post('idObra');

		$fotos = $this->fotos_model->listarFotos($id);

		if ($fotos->num_rows() > 0) {
			$data['fotos'] = $fotos->result();
			echo '<ul id="ulSort" class="thumbs noscript">'.$this->load->view('administracao/timeline_thumbs', $data, TRUE).'</ul>';
		} else {
			echo 'Não existe nenhuma foto ainda.';
		}
	}

	function adicionar(){
		if (!$this->input->post('enviar')) {
			foreach($this->obras_model->listarTodas()->result() as $obra) {
				$data['obras'][$obra->idObra] = $obra->titulo;
			}

			$data['menu'] = buildMenu('timeline', 'Linha do Tempo');
			$data['main_content'] = 'administracao/timeline_add_view';
			$this->load->view('administracao/includes/template', $data);
		} else {
			if ($this->_upload()){
				$this->timeline_model->adicionar();

				redirect('administracao/timeline');
			} else {
				echo show_error($this->upload->display_errors());
			}
		}
	}

	function editar() {
		if (!$this->input->post('enviar')) {
			$data['timeline'] = $this->timeline_model->listar($this->uri->segment(4))->row();

			foreach ($this->obras_model->listarTodas()->result() as $obra) {
				$data['obras'][$obra->idObra] = $obra->titulo;
			}

			$data['menu'] = buildMenu('timeline', 'Linha do Tempo');
			$data['main_content'] = 'administracao/timeline_add_view';
			$this->load->view('administracao/includes/template', $data);
		} else {
			$file = $this->_upload();
			if ($file) {
				$this->timeline_model->editar($file);

				redirect('administracao/timeline');
			} else {
				echo show_error($this->upload->display_errors());
			}
		}
	}

	function apagar(){
		if ($this->timeline_model->apagar()) {
			redirect('administracao/timeline');
		} else {
			show_error('Houve um erro durante a tentativa de excluir este timeline', 500);
		}
	}

	function _upload() {
		$config = Array(
			'file_name'		=> url_title(substr($_FILES['userfile']['name'],0, strlen($_FILES['userfile']['name'])-4),'underscore',TRUE),
			'upload_path'	=> 'images/timeline',
			'allowed_types'	=> 'jpg|jpeg|png',
			'remove_spaces'	=> TRUE,
			'max_size'		=> 5120,
			'overwrite'		=> TRUE
		);


		$this->load->library('upload', $config);

		if (!$this->upload->do_upload()) {
			$error = array('error' => $this->upload->display_errors());
			$this->session->set_flashdata('upload_errors', $this->upload->display_errors());
			return FALSE;
		} else {
			$upload_data = $this->upload->data();

			$areaWidth = 120;
			$areaHeight = 86;
			$path = "images/timeline";

			$full_path = dirname($_SERVER['SCRIPT_FILENAME']) . '/' . $path . '/' . $upload_data['raw_name'] . $upload_data['file_ext'];
			// Finding Image size
			$img_size = getimagesize($full_path);
			$inputWidth = $img_size[0] . "px";   // get this value from upload data array
			$inputHeight = $img_size[1] . "px";  // get this value from upload data array
			/* calculate the optimal size before we crop the overlapping part */
			$x = $areaWidth / $inputWidth;
			$y = $areaHeight / $inputHeight;
			/* get what is the best side to scale */
			if ($x < $y) {
				$newWidth = round($inputWidth * ($areaHeight / $inputHeight));
				$newHeight = $areaHeight;
			} else {
				$newHeight = round($inputHeight * ($areaWidth / $inputWidth));
				$newWidth = $areaWidth;
			}

			$thumb_config = Array(
				'source_image'		=> $upload_data['full_path'],
				'maintain_ratio'	=> TRUE,
//				'create_thumb' => TRUE,
//				'thumb_marker' => '_timeline',
				'master_dim'		=> 'auto',
				'width'				=> $newWidth,
				'height'			=> $newHeight
			);

//			$this->load->library('image_lib');
////			$this->image_lib->clear();
//			$this->image_lib->initialize($thumb_config);
//			$this->image_lib->resize();
//			$this->image_lib->clear();

			$this->load->helper('cropper');

			$thumb_data = cropper($upload_data['raw_name'], $upload_data['file_ext'], $path, 135, 115);

			return $thumb_data;
		}
	}

	// Método para utilizar com o Jcrop
	/*
	function recortar(){
		$target = $this->input->post('file');
		if (is_file(realpath('images/' . $target))) {
			$data['foto'] = base_url() . 'images/' . $target;
		} else {
			$data['foto'] = base_url() . 'images/timeline/' . $target;
		}

		$this->load->view('administracao/timeline_crop', $data);
	}
	*/

}