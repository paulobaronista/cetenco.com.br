<div id="subHeader">
	<div id="subHeaderLeft">
		<img src="<?=base_url()?>template/img/settings_64.png" />
		<h1>Obras</h1>
	</div>
	<div id="subHeaderRight">
	</div>
</div>
<div class="clr"></div>
<div id="content">
	<?=form_open('administracao/obras/salvar', array('id'=>'frmObra'))?>
	<div id="obra">
		<?php
			$idiomas = $this->config->item('idiomas');

			$abas[] = '<a href="#dados_gerais">Dados gerais</a>';
			foreach($idiomas as $value) {
				$abas[]=  '<a href="#titulo_desc_'.strtolower($value).'">Descrição ('.$value.')</a>';
			}

			$abas[] = '<a href="#fotos">Fotos</a>';

			echo ul($abas);
		?>
		<div id="dados_gerais">
			<div id="leftCol">
				<?php
				echo form_label('Categoria', 'categoria');
				echo form_dropdown('categoria', $categorias, (isset($obra->idCategoria) ? $obra->idCategoria : 1), 'id=categoria');
				echo form_label('Tipo', 'tipo');
				echo form_dropdown('tipo', $tipos, (isset($obra->idTipo) ? $obra->idTipo : 0), 'id=tipo');
				?>
				<div class="clr"></div>
				<?php
					echo form_label('Contratante', 'contratante');
					echo form_input('contratante', set_value('contratante', (isset($obra->contratante) ? $obra->contratante : '')));
				?>
				<div class="clr"></div>
				<?php
					echo form_label('Local', 'local');
					echo form_input('local', set_value('local', (isset($obra->local) ? $obra->local : '')));
					echo form_label('Código de incorporação', 'embed', array('style' => 'width:auto'));
					echo form_input('embed', set_value('embed', (isset($obra->embed) ? html_entity_decode($obra->embed) : '')));
					echo form_label('Latitude', 'latitude');
					echo form_input('latitude', set_value('latitude', (isset($obra->latitude) ? $obra->latitude : '')));
					echo form_label('Longitude', 'longitude');
					echo form_input('longitude', set_value('longitude', (isset($obra->longitude) ? $obra->longitude : '')));
				?>
			</div>
			<div id="rightCol">
				<?php
				echo form_fieldset('Período de execução');
				echo form_label('Início', 'execucao_inicio');
				echo form_input(Array('name'=>'execucao_inicio', 'id'=>'execucao_inicio', 'value'=>(isset($obra->execucao_inicio) ? $obra->execucao_inicio : '')));
				?>
				<span class="spacer"></span>
				<?php
				echo form_label('Término', 'execucao_fim');
				echo form_input(Array('name'=>'execucao_fim', 'id'=>'execucao_fim', 'value'=>(isset($obra->execucao_fim) ? $obra->execucao_fim : '')));
				echo form_fieldset_close();
				echo form_fieldset('Parâmetros adicionais');
				?>
				<div class="radios">
					<?php
					echo form_label('Tipo', 'realizada');
					echo form_radio('realizada', '1', (isset($obra->realizada) && $obra->realizada ? Array('checked' => TRUE) : ''));
					echo form_label('Realizada');
					echo form_radio('realizada', '0', (isset($obra->realizada) && !$obra->realizada ? Array('checked' => TRUE) : ''));
					echo form_label('Em andamento','',array('style'=>'width:95px'));
					?>
				</div>
				<span class="spacer"></span>
				<div class="radios">
				<?php
				echo form_label('Publicada', 'publicada');
				echo form_radio('publicada', '1', (isset($obra->publicada) && $obra->publicada ? Array('checked' => TRUE) : ''));
				echo form_label('Sim');
				echo form_radio('publicada', '0', (isset($obra->publicada) && !$obra->publicada ? Array('checked' => TRUE) : ''));
				echo form_label('Não');
				?>
				</div>
				<?=form_fieldset_close();?>
				<div id="hidreletrica">
					<?php
					echo form_fieldset('Usina Hidrelétrica');
					echo form_label('Rio', 'rio');
					echo form_input(Array('name' => 'rio', 'id' => 'rio', 'value' => set_value('rio', (isset($obra_desc[$this->session->userdata('idioma')]) ? $obra_desc[$this->session->userdata('idioma')]->rio : ''))));
					?>
					<span class="spacer"></span>
					<?php
					echo form_label('Potência', 'potencia');
					echo form_input(Array('name' => 'potencia', 'id' => 'potencia', 'class' => "auto {aSep: '.', aDec: ',', mDec: 0}" , 'value' => set_value('potencia', (isset($obra_desc[$this->session->userdata('idioma')]) ? $obra_desc[$this->session->userdata('idioma')]->potencia : ''))));
					echo form_label('MW', 'potencia');
					echo form_fieldset_close();
					?>
				</div>
				<?php
					echo form_label('Coordenadas', 'coordenadas', array('style' => 'width:auto'));
					echo form_input('coordenadas', set_value('coordenadas', (isset($obra->coordenadas) ? html_entity_decode($obra->coordenadas) : '')));
				?>
			</div>
			<div id="bottom">
				<?php
//					echo form_label('Código de incorporação', 'embed', array('style'=>'width:auto'));
//					echo form_input('embed', set_value('embed', (isset($obra->embed) ? html_entity_decode($obra->embed) : '')));
//					echo form_textarea(array('name'=>'embed', 'value'=>(isset($obra->embed) ? html_entity_decode($obra->embed) : '')));
					echo form_button(array('name' => 'salvar', 'id' => 'salvar', 'type' => 'submit', 'content' => img(base_url() . 'template/img/save_16.png') . ' Salvar'));
					echo nbs(3);
					echo anchor('administracao/obras', img(base_url() . 'template/img/block_16.png') . ' Cancelar', array('class' => 'button', 'id' => 'cancel', 'name' => 'cancel'));
					echo form_hidden('action', $this->uri->segment(3));
					echo form_hidden('id', $this->uri->segment(4));
					echo form_close();
					echo $this->session->flashdata('validation_errors');
				?>
			</div>
		</div>
		<?php foreach($idiomas as $key => $value): ?>
			<div id="titulo_desc_<?=strtolower($value)?>">
				<?php
				echo form_label('Título', 'titulo');
				echo form_input(Array('name' => 'titulo['.$key.']', 'value' => set_value('titulo['.$key.']', (isset($obra_desc[$key]->titulo) ? $obra_desc[$key]->titulo : '')), 'class' => 'titulo'));
				?>
				<div class="clr"></div>
				<?php
				echo form_label('Descrição', 'descricao');
				echo form_textarea(Array('name' => 'descricao['.$key.']', 'id' => 'descricao', 'rows' => 4, 'cols' => '75', 'value' => (isset($obra_desc[$key]->descricao) ? $obra_desc[$key]->descricao : '')));
				?>
			</div>
		<?php endforeach;?>
		<div id="fotos">
			<?php
				if ($this->uri->segment(3) == 'editar') :
					echo form_open_multipart('');
			?>
					<div id="uploadifySwfWrapper">
						<?php
							echo form_upload(Array('name' => 'Filedata', 'id' => 'upload'));
						?>
					</div>
			<?php
					echo form_hidden('id', $this->uri->segment(4));
					echo form_button(Array('name'=>'enviar','id'=>'enviar','content'=>'Enviar foto(s)', 'class'=>'button','onclick'=>'$(\'#upload\').uploadifyUpload();'));
					echo form_button(Array('name'=>'limpar','id'=>'limpar','content'=>'Cancelar upload', 'class'=>'button','onclick'=>'$(\'#upload\').uploadifyClearQueue();'));
					echo form_close();
			?>
			<div id="fileQueue"></div>
			<div id="thumbs">
				<ul id="ulSort" class="thumbs noscript">
					<?php $this->load->view('administracao/fotos_ajax',$fotos);?>
				</ul>
			</div>
			<?	else : ?>
					<p>Você precisa salvar os dados gerais antes de enviar fotos.</p>
			<?php endif;?>
		</div>
	</div>
</div>
<script type="text/javascript" charset="utf-8">
	$(function(){
		$("#obra").tabs();

		$.getScript('<?=base_url()?>includes/js/jquery.autoNumeric-1.5.1.js', function(){
			$("#potencia").autoNumeric({aSep: '.', aDec: ',', mDec: 0});
			if ($("#potencia").val() != ''){
				$("#potencia").triggerHandler('blur');
			}

			$("#potencia").bind('focus', function(){
				$(this).val($.fn.autoNumeric.Strip(this.id, {aSep: '.', aDec: ',', mDec: 0}));
			});
			
			$("#frmObra").submit(function(){
				$("#potencia").val($.fn.autoNumeric.Strip('potencia', {aSep: '.', aDec: ',', mDec: 0}));
				return true;
			});
		});

		$("input[name=coordenadas]").bind('blur',function(){
			if ($(this).val() == '') {
				var string = '7° 46\' 06" N e 63° 00\' 15" O';
				var array = string.split(' ');
				var latitude = (parseInt(array[0]) + (parseInt(array[1]) * 1/60) + (parseInt(array[2]) * 1/60 * 1/60));
				var longitude = (parseInt(array[5]) + (parseInt(array[6]) * 1/60) + (parseInt(array[7]) * 1/60 * 1/60));

				$("input[name=latitude]").val(latitude);
				$("input[name=longitude]").val(longitude);
			}
		});

		$("#categoria").change(function(){
			if ($(this).val() != 1) {
				$("#hidreletrica input").attr('disabled', 'disabled');
			} else {
				$("#hidreletrica input").removeAttr("disabled");
			}
		}).triggerHandler('change');

		$.lazy({
			src: '<?=base_url()?>includes/js/jquery.evenifhidden.js',
			name: 'evenIfHidden',
			cache: true
		});
		
		$.lazy({
			src: '<?=base_url()?>includes/js/uploadify/jquery.uploadify.v2.1.0.js',
			name: 'uploadify',
			dependencies: {
				css: ['<?=base_url()?>includes/css/uploadify/uploadify.css']
			},
			cache: true
		});
		
		$.lazy({
			src: '<?=base_url()?>includes/js/jquery.colorbox-min.js',
			name: 'colorbox',
			dependencies: {
				css: ['<?=base_url()?>includes/css/colorbox/colorbox.css']
			},
			cache: true
		});

		$("a[rel='colorbox']").colorbox();

		$("#upload").uploadify({
			uploader:       '<?=base_url()?>includes/js/uploadify/uploadify_mod2.swf',
			script:         '<?=base_url()?>includes/js/uploadify/uploadify.php',
			cancelImg:      '<?=base_url()?>includes/js/uploadify/cancel.png',
			folder:         '/novo/images',
			buttonText:     'Selecionar',
			width:			98,
			height:			30,
			scriptAccess:   'always',
			multi:          true,
			wmode:			'transparent',
			fileDesc:		'Imagens (jpg, jpeg, png)',
			fileExt:		'*.jpg;*.jpeg;*.png',
			queueID:		'fileQueue',
			'onError': function (a, b, c, d) {
				if (d.status == 404)
					alert('Não foi possível encontrar o script de upload.');
				else if (d.type === "HTTP")
					alert('error '+d.type+": "+d.status);
				else if (d.type ==="File Size")
					alert(c.name+' '+d.type+' Limite: '+Math.round(d.sizeLimit/1024)+'KB');
				else
					alert('Erro '+d.type+": "+d.text);
			},
			'onComplete': function (event, queueID, fileObj, response, data) {
				//Post response back to controller
				var obra = {};
				obra['id']= "<?=$this->uri->segment(4)?>";

				$.post('<?php echo site_url('administracao/fotos/processar/'.$this->uri->segment(4)); ?>',{filearray: response},function(info){
					$("#thumbs ul").append(info);  //Add response returned by controller
					$("a[rel='colorbox']").colorbox();
					$("#thumbs ul li img").position({my: 'center center', at: 'center center', of: $(this).parent("li")});
				});
			},
			'onAllComplete': function(event, data) {
				$("#ulSort").sortable({
					placeholder: 'ui-state-highlight placeholder',
					start: function(e, ui) {
						ui.placeholder.height(ui.item.outerHeight()-(parseInt(ui.item.css("outline-width"))*2));
						ui.placeholder.width(ui.item.outerWidth()-(parseInt(ui.item.css("outline-width"))*2));
						ui.placeholder.css("margin-top", ui.item.css("margin-top")).css("margin-right", ui.item.css("margin-right")).css("margin-bottom", ui.item.css("margin-bottom")).css("margin-left", ui.item.css("margin-left"));

					}
				});
				$("#ulSort").disableSelection();
			}
		});

		$("#ulSort").sortable({
			placeholder: 'ui-state-highlight placeholder',
			start: function(e, ui) {
				ui.placeholder.height(ui.item.outerHeight()-(parseInt(ui.item.css("outline-width"))*2));
				ui.placeholder.width(ui.item.outerWidth()-(parseInt(ui.item.css("outline-width"))*2));
				ui.placeholder.css("margin-top", ui.item.css("margin-top")).css("margin-right", ui.item.css("margin-right")).css("margin-bottom", ui.item.css("margin-bottom")).css("margin-left", ui.item.css("margin-left"));

			},
			update: function(event, ui) {
				var ordem = $("#ulSort").sortable('serialize');
				$.post('<?php echo site_url('administracao/fotos/ordenar/'.$this->uri->segment(4)); ?>', ordem, function(info){
//					console.log(info);
				});

			}
		});

		$("#ulSort").disableSelection();
		
		$("#ulSort li").evenIfHidden(function(element){
			element.find("a img").each(function(index, el){
				$(el).position({my: 'center center', at: 'center center', of: $(this).parents("li")});
			});
		});
	});
</script>