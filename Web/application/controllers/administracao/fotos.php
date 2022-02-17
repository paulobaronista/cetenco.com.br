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
			
			if ($upload_data->width > $max_width || $upload_data->height > $max_height) {
				$processedImage_config = Array(
					'source_image'      =>	$upload_data->file_path,
					'maintain_ratio'    =>	TRUE,
					'width'             =>	$max_width,
					'height'            =>	$max_height
				);
				
				$this->image_lib->initialize($processedImage_config);

				if (!$this->image_lib->resize()) {
					echo '<p style="display:block">Imagem processada: '.$upload_data->file_path.'<br />'.$this->image_lib->display_errors().'</p>';
					die();
				}

				$this->image_lib->clear();
			}

//            $thumb_config = Array(
//                'source_image'      =>	$upload_data->file_path,
//                'new_image'         =>	$upload_data->path.'/thumbs/',
//                'maintain_ratio'    =>	TRUE,
//                'create_thumb'      =>	TRUE,
//				'thumb_marker'		=>	'_thumb',
//                'width'             =>	100,
//                'height'            =>	100
//            );
//
//			$this->image_lib->initialize($thumb_config);
//			if (!$this->image_lib->resize()) {
//				echo '<p style="display:block">Miniatura processada: '.$upload_data->path.'<br />'.$this->image_lib->display_errors().'</p>';
//				die();
//			}
//
//			$this->image_lib->clear();

			$thumb_data = cropper($upload_data->raw_name, $upload_data->file_ext, "/images/", 120, 90);

			$ordem = $this->fotos_model->gravar($upload_data, $this->uri->segment(4));

			$tmpl = '<li id="fotos_'.$ordem.'" class="thumb ui-state-default">'.
						'<a rel="colorbox" href="'.base_url().'images/'.$upload_data->file_name.'">'.
							'<img class="sortableitem" src="'.base_url().'images/thumbs/'.$upload_data->raw_name.'_thumb'.$upload_data->file_ext.'" />'.
						'</a>'.
						'<div class="caption">'.
							'<a href='.site_url('administracao/fotos/excluir/'.$upload_data->raw_name.$upload_data->file_ext).'>Excluir Foto</a>'.
							'<a href='.site_url('administracao/fotos/destaque/'.$upload_data->file_name).' class="regular">Destaque</a>'.
						'</div>'.
					'</li>';

			echo $tmpl;
        } else {
			echo 'Não foi possível processar as imagens';
		}
    }

	function ordenar(){
		$status = $this->fotos_model->ordenar($this->uri->segment(4));
	}

	function excluir(){
		$path = realpath('./images');
		$foto = $this->uri->segment(4);
		$thumb = substr_replace($foto,'_thumb',strrpos($foto, '.'),0);
		if ($this->fotos_model->excluir($foto)) {
			if (is_file($path.DIRECTORY_SEPARATOR.$foto))
				unlink($path.DIRECTORY_SEPARATOR.$foto);
			
			if (is_file($path.DIRECTORY_SEPARATOR.'thumbs'.DIRECTORY_SEPARATOR.$thumb))
				unlink($path.DIRECTORY_SEPARATOR.'thumbs'.DIRECTORY_SEPARATOR.$thumb);

			echo "OK";
		} else {
			echo "ERROR";
		}
	}

	function destaque(){
//		$path = realpath('./images');
		$foto = $this->uri->segment(4);
//		$thumb = substr_replace($foto,'_thumb',strrpos($foto, '.'),0);
		if ($this->fotos_model->destaque($foto,$this->input->post('idObra'))) {
			echo "OK";
		} else {
			echo "ERROR";
		}
	}

}