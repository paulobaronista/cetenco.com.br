<?php

class Obras extends Controller {

	function __construct() {
		parent::Controller();

		$this->load->model('obras_model');
		$this->load->model('mural_model');

		$this->session->set_userdata('site_idioma', $this->lang->lang());
	}

	function index() {
		redirect('obras/realizadas');
	}

	function realizadas() {
		$this->session->set_userdata('site_obra_status',1);

		if (!$this->uri->segment(4)) {
			$data['page_title'] = lang('menu_obras_realizadas');
			$data['categorias'][] = lang('dropdown_categoria');
			foreach ($this->obras_model->lerCategorias()->result() as $categoria) {
				$data['categorias'][$categoria->idCategoria] = $categoria->categoria;
			}

			$data['layer_ids'] = array(1,2,3,4,5,6,7,8,9,10,11);
			$data['mural'] = $this->mural_model->lerDados();
			if ($data['mural']->num_rows() > 0) {
				$data['mural'] = $data['mural']->result();
			} else {
				$data['mural'] = false;
			}

			$data['main_content'] = 'obras_view';
			$this->load->view('includes/template', $data);
		} else if ($this->uri->segment(4) && !$this->uri->segment(5)) {
			$obra = $this->obras_model->lerPrimeira($this->uri->segment(4))->row();
			redirect('obras/realizadas/'.$obra->idCategoria.'/'.$obra->idObra);
		} else {
			$data['categorias'][] = lang('dropdown_categoria');
			foreach($this->obras_model->lerCategorias()->result() as $categoria){
				$data['categorias'][$categoria->idCategoria] = $categoria->categoria;
			}

			if (!array_key_exists($this->uri->segment(4), $data['categorias'])) {
				redirect('obras/realizadas');
			} else {
				$obra = $this->obras_model->lerDados($this->uri->segment(5));

				if ($obra->num_rows() > 0) {
					$data['obra'] = $obra->row();
					$page_title = $data['obra']->titulo;
					if (isset($data['obra']->coordenadas) AND count($coords = explode(' e ', $data['obra']->coordenadas)) == 2) {
						$data['obra']->latitude = (float)$this->positionConvert(str_replace(' ', '', $coords[0]), 'degdec');
						$data['obra']->longitude = (float)$this->positionConvert(str_replace(' ', '', $coords[1]), 'degdec');
					}
				} else {
					$page_title = 'Obra não encontrada';
				}

				$data['fotos'] = $this->obras_model->lerFotos($this->uri->segment(5));

				
				if ($data['fotos']->num_rows() > 0){
					foreach($data['fotos']->result() as $foto) {
						if ($foto->destaque) {
							$data['destaque'] = $foto->nome;
							break;
						} else {
							$data['destaque'] = $data['fotos']->row(0)->nome;
						}
					}

					$foto_cache = 'images/cache/'.$data['destaque'];

					if (!is_file($foto_cache)){
						$width = 410;
						$height = 302;

						$destaque_config = Array(
							'source_image'		=> 'images/' . $data['destaque'],
							'new_image'			=> 'images/cache/'.$data['destaque'],
							'maintain_ratio'	=> TRUE,
							'master_dim'		=> 'width',
							'width'				=> $width,
							'height'			=> $height
						);

						$this->load->library('image_lib');
						$this->image_lib->clear();
						$this->image_lib->initialize($destaque_config);
						$this->image_lib->resize();
						$this->image_lib->clear();

						$image_info = getimagesize('images/cache/'.$data['destaque']);
						$x_axis = 0;
						$y_axis = ($image_info[1]-$height)/2;

						unset($destaque_config);

						$destaque_config = array(
							'source_image'		=> 'images/cache/' . $data['destaque'],
							'maintain_ratio'	=> FALSE,
							'width'				=> $width,
							'height'			=> $height,
							'x_axis'			=> $x_axis,
							'y_axis'			=> $y_axis
						);

	//					$cached_image_info = getimagesize('images/cache/'.$data['fotos']->row()->nome);
	//
	//					if ($cached_image_info[1] > $destaque_config['height']) {
	//						$destaque_config['x_axis'] = 0;
	//						$destaque_config['y_axis'] = ($cached_image_info[1]-$destaque_config['height'])/2;
	//					} else if ($cached_image_info[0] > $destaque_config['width']) {
	//						$destaque_config['x_axis'] = ($cached_image_info[0]-$destaque_config['width'])/2;
	//						$destaque_config['y_axis'] = 0;
	//					}

						$this->image_lib->initialize($destaque_config);

						if (!$this->image_lib->crop()) {
							echo $this->image_lib->display_errors();
							die();
						}
	//
	//					echo "<pre>";
	//					print_r(getimagesize('images/cache/'.$data['fotos']->row()->nome));
	//					echo "</pre>";
	//					die();
					}
				}


				$data['page_title'] = $page_title;
				$data['main_content'] = 'obra_detalhes_view';
				$this->load->view('includes/template', $data);
			}
		}
	}

	function em_andamento() {
		$this->session->set_userdata('site_obra_status',0);

		if (!$this->uri->segment(4)) {
			$data['page_title'] = lang('menu_obras_em_andamento');
//			foreach ($this->obras_model->lerCategorias()->result() as $categoria) {
//				$data['categorias'][$categoria->idCategoria] = $categoria->categoria;
//			}

			$data['obras'][] = lang('dropdown_obra');
			foreach ($this->obras_model->listar('andamento')->result() as $obra) {
				$data['obras'][$obra->idObra] = $obra->titulo;
			}
			
			$data['layer_ids'] = array(12,13,14,15,16,17,18,19,20,21,22);
			$data['mural'] = $this->mural_model->lerDados();
			if ($data['mural']->num_rows() > 0) {
				$data['mural'] = $data['mural']->result();
			} else {
				$data['mural'] = false;
			}
			
			$data['main_content'] = 'obras_view';
			$this->load->view('includes/template', $data);
		} else {
//			$data['categorias'][] = lang('dropdown_categoria');
//			foreach($this->obras_model->lerCategorias()->result() as $categoria){
//				$data['categorias'][$categoria->idCategoria] = $categoria->categoria;
//			}

			$data['obras'][] = lang('dropdown_obra');
			foreach ($this->obras_model->listar('andamento')->result() as $obra) {
				$data['obras'][$obra->idObra] = $obra->titulo;
			}

			if (!array_key_exists($this->uri->segment(4), $data['obras'])) {
				redirect('obras/em-andamento');
			} else {
				$obra = $this->obras_model->lerDados($this->uri->segment(4));

				if ($obra->num_rows() > 0) {
					$data['obra'] = $obra->row();
					$page_title = $data['obra']->titulo;
					if (count($coords = explode(' e ', $data['obra']->coordenadas)) == 2) {
						$data['obra']->latitude = (float)$this->positionConvert(str_replace(' ', '', $coords[0]), 'degdec');
						$data['obra']->longitude = (float)$this->positionConvert(str_replace(' ', '', $coords[1]), 'degdec');
					}
					if ($data['obra']->latitude == 0 AND $data['obra']->longitude == 0) {
						unset($data['obra']->latitude);
						unset($data['obra']->longitude);
					}
				} else {
					$page_title = 'Obra não encontrada';
				}
				
				$data['fotos'] = $this->obras_model->lerFotos($this->uri->segment(4));

				if ($data['fotos']->num_rows() > 0){
					foreach ($data['fotos']->result() as $foto) {
						if ($foto->destaque) {
							$data['destaque'] = $foto->nome;
							break;
						} else {
							$data['destaque'] = $data['fotos']->row(0)->nome;
						}
					}

					$foto_cache = 'images/cache/' . $data['destaque'];

					if (!is_file($foto_cache)){
						$width = 410;
						$height = 302;
						
						$destaque_config = Array(
							'source_image'		=> 'images/' . $data['destaque'],
							'new_image'			=> 'images/cache/'.$data['destaque'],
							'maintain_ratio'	=> TRUE,
							'master_dim'		=> 'width',
							'width'				=> $width,
							'height'			=> $height
						);

						$this->load->library('image_lib');
						$this->image_lib->clear();
						$this->image_lib->initialize($destaque_config);
						$this->image_lib->resize();
						$this->image_lib->clear();

						$image_info = getimagesize('images/cache/'.$data['destaque']);
						$x_axis = 0;
						$y_axis = ($image_info[1]-$height)/2;

						unset($destaque_config);

						$destaque_config = array(
							'source_image'		=> 'images/cache/' . $data['destaque'],
							'maintain_ratio'	=> FALSE,
							'width'				=> $width,
							'height'			=> $height,
							'x_axis'			=> $x_axis,
							'y_axis'			=> $y_axis
						);

	//					$cached_image_info = getimagesize('images/cache/'.$data['fotos']->row()->nome);
	//
	//					if ($cached_image_info[1] > $destaque_config['height']) {
	//						$destaque_config['x_axis'] = 0;
	//						$destaque_config['y_axis'] = ($cached_image_info[1]-$destaque_config['height'])/2;
	//					} else if ($cached_image_info[0] > $destaque_config['width']) {
	//						$destaque_config['x_axis'] = ($cached_image_info[0]-$destaque_config['width'])/2;
	//						$destaque_config['y_axis'] = 0;
	//					}

						$this->image_lib->initialize($destaque_config);

						if (!$this->image_lib->crop()) {
							echo $this->image_lib->display_errors();
							die();
						}
	//
	//					echo "<pre>";
	//					print_r(getimagesize('images/cache/'.$data['fotos']->row()->nome));
	//					echo "</pre>";
	//					die();
					}
				}
					
				$data['page_title'] = $page_title;
				$data['main_content'] = 'obra_detalhes_view';
				$this->load->view('includes/template', $data);
			}
		}
	}

	function filtroCategoria() {
		$query = $this->obras_model->lerCategorias();
		if ($query->num_rows() > 0) {
			$dropdown = '<select id="obras" style="margin-left:20px"><option value="0">-- ESCOLHA UMA OBRA --</option>';
			foreach($query->result() as $obra) {
				$dropdown .= '<option value="'.$obra->idObra.'">'.$obra->titulo.'</option>';
			}
			$dropdown .= '</select>';
		} else {
			$dropdown = lang('categoria_sem_obras');
		}

		echo $dropdown;
	}

	function _DMStoDEC($deg, $min, $sec) {

	// Converts DMS ( Degrees / minutes / seconds )
	// to decimal format longitude / latitude

		return $deg + ((($min * 60) + ($sec)) / 3600);
	}

	function positionConvert($coordinates, $outputFormat) {
		// $coordinates may contain a single value for longitude or latitude as well as a set of both, seperated by a blank
		// $ouputFormat can be either "degdec" (0.0000°), "mindec" (00°00.000') or "dms" (000°00'00.00'')
		$coordinates = stripslashes($coordinates);
		$coordinates = str_replace(',', '.', $coordinates);
		$coordinates = str_replace('"', "''", $coordinates);
		$old_pair = explode(' ', $coordinates);
		$new_pair = array();
		$error = 0;
		for ($p = 0; $p < count($old_pair); $p++) {
			if (preg_match("/^([0-9]{1,3})°([0-9]{1,2})'([0-9]{1,2})(\.[0-9]{1,2})?''([a-zA-Z]){1}$/", $old_pair[$p], $hits) == 1) { // 001°01'01.01''
				$degree = $hits[1];
				$minute = $hits[2];
				$second = $hits[3] . (isset($hits[4])?$hits[4]:'');
			} else if (preg_match("/^([0-9]{1,3})°([0-9]{1,2})\.([0-9]{1,3})'$/", $old_pair[$p], $hits) == 1) { // 001°01.001'
				$degree = $hits[1];
				$minute = $hits[2];
				$second = (("0." . $hits[3]) * 60);
			} else if (preg_match("/^([0-9]{1,3})\.([0-9]{1,5})°$/", $old_pair[$p], $hits) == 1) { // 001.0001°
				$degree = $hits[1];
				$minute = floor(("0." . $hits[2]) * 60);
				$second = (((("0." . $hits[2]) * 60) - floor(("0." . $hits[2]) * 60)) * 60);
			} else { // unknown format
				$error = 1;
			}

			if (strtolower($outputFormat) == 'degdec' AND isset($degree) AND isset($minute) AND isset($second)) {
				$new_pair[$p] = sprintf("%+01.5f°", (strtolower($hits[5]) == 's' || strtolower($hits[5]) == 'o' ? -1:1)*($degree + (($minute + ($second / 60)) / 60)));
			} else if (strtolower($outputFormat) == 'mindec' AND isset($minute) AND isset($second)) {
				$new_pair[$p] = sprintf("%02d°%06.3f'", $degree, ($minute + ($second / 60)));
			} else if (strtolower($outputFormat) == 'dms' AND isset($degree) AND isset($minute) AND isset($second)) {
				$new_pair[$p] = sprintf("%03d°%02d'%05.2f''", $degree, $minute, $second);
			} else {
				$error = 2;
			}
		}
		if ($error == 1)
			$new_coordinates = 'Error: unknown input format - '.$coordinates;
		else if ($error == 2)
			$new_coordinates = 'Error: unknown output format';
		else
			$new_coordinates = implode(' ', $new_pair);

		return $new_coordinates;
	}

}