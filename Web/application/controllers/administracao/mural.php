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

class Mural extends Controller {

	function __construct() {
		parent::Controller();
        if (!$this->session->userdata('is_logged_in')) redirect('administracao/access');
		$this->load->model('administracao/mural_model');
		$this->load->model('administracao/obras_model');

		if ($this->uri->segment(3) == 'realizadas') {
			$this->status = 'realizadas';
		} else if ($this->uri->segment(3) == 'em_andamento') {
			$this->status = 'andamento';
		}
	}


	function index() {
		redirect('administracao/mural/realizadas');
	}

	function realizadas() {
		$this->session->set_userdata('page_title','Administração | Mural');
		$this->session->set_userdata('status_obra', 'realizadas');
		$data['menu'] = buildMenu('mural', 'Mural de Obras');
		$data['layer_ids'] = array(1,2,3,4,5,6,7,8,9,10,11);
		$data['mural'] = $this->mural_model->lerDados('','realizadas');
		if ($data['mural']->num_rows() > 0) {
			$data['mural'] = $data['mural']->result();
		} else {
			$data['mural'] = false;
		}
		$data['obras'] = $this->obras_model->listarObras('','realizadas')->num_rows();
		$data['main_content'] = 'administracao/mural_view';
		$this->load->view('administracao/includes/template', $data);
	}

	function em_andamento() {
		$this->session->set_userdata('page_title','Administração | Mural');
		$this->session->set_userdata('status_obra', 'andamento');
		$data['menu'] = buildMenu('mural', 'Mural de Obras');
		$data['layer_ids'] = array(12,13,14,15,16,17,18,19,20,21,22);
		$data['mural'] = $this->mural_model->lerDados('','andamento');
		if ($data['mural']->num_rows() > 0) {
			$data['mural'] = $data['mural']->result();
		} else {
			$data['mural'] = false;
		}
		$data['obras'] = $this->obras_model->listarObras('','andamento')->num_rows();
		$data['main_content'] = 'administracao/mural_view';
		$this->load->view('administracao/includes/template', $data);
	}

	function editar(){
		$this->status = $this->session->userdata('status_obra');

		$data['layer'] = $this->mural_model->lerDados($this->uri->segment(4))->row();

		foreach($this->obras_model->listarObras('',$this->status)->result() as $obra) {
			$data['obras'][$obra->idObra] = $obra->titulo;
		}

		$this->load->view('administracao/mural_ajax_view', $data);
	}

	function processar() {
		$fileArray = $this->input->post('filearray');

		if ($fileArray && $fileArray != "ERROR") {

			switch ($this->uri->segment(4)) {
				case 'recorte':
					$upload_data = json_decode($this->input->post('filearray'));

					$max_width = 800;
					$max_height = 600;

					$this->load->library('image_lib');

					if ($upload_data->{'width'} > $max_width || $upload_data->{'height'} > $max_height) {
						$processedImage_config = Array(
							'source_image'      =>	$upload_data->{'file_path'},
							'maintain_ratio'    =>	TRUE,
							'width'             =>	$max_width,
							'height'            =>	$max_height
						);

						$this->image_lib->initialize($processedImage_config);

						if (!$this->image_lib->resize()) {
							die();
							echo '<p style="display:block">Imagem processada: '.$upload_data->{'file_path'}.'<br />'.$this->image_lib->display_errors().'</p>';
						}

						$this->image_lib->clear();
					}

					echo '<img id="cropbox" src="'.base_url().'images/mural/'.$upload_data->{'file_name'}.'" />';
				break;

				default:
					$this->load->library('image_lib');

					if ($this->input->post('details')) {
						foreach($this->input->post('details') as $controlArray) {
							$details[$controlArray['name']] = $controlArray['value'];
						}
					}

					if ($this->input->post('cropInfo')) {
						foreach($this->input->post('cropInfo') as $controlArray) {
							$crop[$controlArray['name']] = $controlArray['value'];
						}
					}

					$upload_data = json_decode($this->input->post('filearray'));

					$thumb_config = Array(
						'source_image'      =>	$upload_data->{'file_path'},
						'new_image'         =>	$upload_data->{'path'}.'/thumbs/',
						'maintain_ratio'    =>	FALSE,
						'create_thumb'      =>	TRUE,
						'thumb_marker'		=>	'_thumb',
						'width'             =>	$crop['w'],
						'height'            =>	$crop['h'],
						'x_axis'			=>	$crop['x'],
						'y_axis'			=>	$crop['y']
					);

					$this->image_lib->initialize($thumb_config);
					if (!$this->image_lib->crop()) {
						echo '<p style="display:block">Miniatura processada: '.$upload_data->{'path'}.'<br />'.$this->image_lib->display_errors().'</p>';
						die();
					}

					$this->image_lib->clear();

					$resize_config = Array(
						'source_image'      =>	$upload_data->{'path'}.'thumbs/'.$upload_data->{'raw_name'}.'_thumb.jpg',
						'maintain_ratio'    =>	TRUE,
						'create_thumb'      =>	FALSE,
						'width'             =>	$crop['refW'],
						'height'            =>	$crop['refH']
					);

					$this->image_lib->initialize($resize_config);

					if (!$this->image_lib->resize()) {
						$status = $this->image_lib->display_errors();
					} else {
						$status = "ok";
					}

					$src = site_url('images/mural/thumbs/'.$upload_data->{'raw_name'}.'_thumb.jpg');

					$this->mural_model->gravar($upload_data, $details);

					echo $src;

				break;
			}
		} else {
			$file = pathinfo($this->input->post('file_path'));

			if (!isset($file['filename'])) {
				$file['filename'] = str_replace($file['extension'], '', $file['basename']);
			}

			$this->load->library('image_lib');

			$thumb_config = Array(
				'source_image'      =>	str_replace('index.php', '', $_SERVER['SCRIPT_FILENAME']).'images/mural/'.$file['basename'],
				'new_image'         =>	str_replace('index.php', '', $_SERVER['SCRIPT_FILENAME']).'images/mural/thumbs/',
				'maintain_ratio'    =>	FALSE,
				'create_thumb'      =>	TRUE,
				'thumb_marker'		=>	'_thumb',
				'width'             =>	$this->input->post('w'),
				'height'            =>	$this->input->post('h'),
				'x_axis'			=>	$this->input->post('x'),
				'y_axis'			=>	$this->input->post('y')
			);

			$this->image_lib->initialize($thumb_config);

			if (!$this->image_lib->crop()) {
				echo '<p style="display:block">Miniatura processada: '.$this->input->post('file_path').'<br />'.$this->image_lib->display_errors().'</p>';
				die();
			}

			$this->image_lib->clear();

			$resize_config = Array(
				'source_image'      =>	str_replace('index.php', '', $_SERVER['SCRIPT_FILENAME']).'images/mural/thumbs/'.$file['filename'].'_thumb.'.$file['extension'],
				'maintain_ratio'    =>	TRUE,
				'create_thumb'      =>	FALSE,
				'width'             =>	$this->input->post('refW'),
				'height'            =>	$this->input->post('refH')
			);

			$this->image_lib->initialize($resize_config);

			if (!$this->image_lib->resize()) {
				$status = $this->image_lib->display_errors();
			} else {
				$status = "ok";
			}

			$this->mural_model->gravar();

			redirect('administracao/mural');
		}
	}

}