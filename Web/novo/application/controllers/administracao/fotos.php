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
class Fotos extends MY_Controller {

    function __construct() {
        parent::Controller();
        if (!$this->session->userdata('is_logged_in'))
            redirect('administracao/access');
        $this->load->model('administracao/fotos_model');
        $this->load->model('administracao/obras_model');
    }

    function index() {
		$id = $this->input->post('obra[id]');
        $data['fotos'] = $this->fotos_model->listarFotos($id)->result();
		$this->load->view('administracao/fotos_ajax', $data);
    }

    function adicionar() {
        if ($this->obras_model->listarObras()->num_rows > 0) {
            foreach ($this->obras_model->listarObras()->result() as $obra) {
                $data['obras'][$obra->idObra] = $obra->titulo;
            }
        } else {
            $data['obras'][0] = 'Nenhuma obra cadastrada';
        }

        $data['menu'] = buildMenu('fotos');
        $data['main_content'] = 'administracao/fotos_add_view';
        $this->load->view('administracao/includes/template', $data);
    }

    function processar() {
        if ($this->input->post('filearray') != "ERROR") {

			$this->load->helper('cropper');

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
					echo '<p style="display:block">Imagem processada: '.$upload_data->{'file_path'}.'<br />'.$this->image_lib->display_errors().'</p>';
					die();
				}

				$this->image_lib->clear();
			}

//            $thumb_config = Array(
//                'source_image'      =>	$upload_data->{'file_path'},
//                'new_image'         =>	$upload_data->{'path'}.'/thumbs/',
//                'maintain_ratio'    =>	TRUE,
//                'create_thumb'      =>	TRUE,
//				'thumb_marker'		=>	'_thumb',
//                'width'             =>	100,
//                'height'            =>	100
//            );
//
//			$this->image_lib->initialize($thumb_config);
//			if (!$this->image_lib->resize()) {
//				echo '<p style="display:block">Miniatura processada: '.$upload_data->{'path'}.'<br />'.$this->image_lib->display_errors().'</p>';
//				die();
//			}
//
//			$this->image_lib->clear();

			$thumb_data = cropper($upload_data->{'raw_name'}, $upload_data->{'file_ext'}, "/images/", 120, 90);

			$ordem = $this->fotos_model->gravar($upload_data, $this->uri->segment(4));

			$tmpl = '<li id="fotos_'.$ordem.'" class="thumb ui-state-default">'.
						'<a rel="colorbox" href="'.base_url().'images/'.$upload_data->{'file_name'}.'">'.
							'<img class="sortableitem" title="Ordem: '.$ordem.'" src="'.base_url().'images/thumbs/'.$upload_data->{'raw_name'}.'_thumb'.$upload_data->{'file_ext'}.'" />'.
						'</a>'.
						'<div class="caption"></div>'.
					'</li>';

			echo $tmpl;
        }
    }

	function ordenar(){
		$status = $this->fotos_model->ordenar($this->uri->segment(4));
	}

}