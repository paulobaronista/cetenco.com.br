<div id="content">
	<div id="dados">
		<?php
			echo form_open_multipart(site_url('administracao/mural/processar/'.$this->uri->segment(4)));

			echo form_label('Obra', 'obra');
			echo form_dropdown('obra',$obras, (isset($layer->idObra) ? $layer->idObra : 1));
			if (!isset($layer->foto)):
			?>
			<p id="aviso">Aguarde até que a foto apareça abaixo <strong>antes</strong> de clicar em Salvar.</p>
			<?php
			else :
			?>
			<p><strong>Foto atual:</strong> <?=$layer->foto?></p>
			<?php endif; ?>
			<div id="fileQueue"></div>
			<div class="clr"></div>
			<?php
			echo form_upload(Array('name' => 'Filedata', 'id' => 'upload'));
			echo form_button(array('name'=>'salvar','id'=>'salvar','type'=>'submit','content'=>img(base_url().'template/img/save_16.png').' Salvar', 'class'=>'button'));
			echo form_button(Array('name'=>'cancelar','id'=>'cancelar','content'=>img(base_url().'template/img/block_16.png') . ' Cancelar', 'class'=>'button','onclick'=>'$.colorbox.close();'));
			echo form_hidden('action', $this->uri->segment(3));
			echo form_hidden('id', $this->uri->segment(4));
			echo form_hidden('x', 0);
			echo form_hidden('y', 0);
			echo form_hidden('w', 0);
			echo form_hidden('h', 0);
			echo form_hidden('refW', 0);
			echo form_hidden('refH', 0);
			echo form_hidden('file_path');

			echo form_close()
		?>
	</div>
	<div class="clr"></div>
	<div id="thumb">
		<?php if (isset($layer->foto)) : ?>
			<div id="cropWidget">
				<img id="cropbox" src="<?=base_url() . 'images/mural/' . $layer->foto ?>" />
			</div>
		<?php else :?>
			<div id="cropWidget">
			</div>
		<?php endif;?>
		<form action="" method="post">
			<input type="hidden" id="x" name="x" />
			<input type="hidden" id="y" name="y" />
			<input type="hidden" id="w" name="w" />
			<input type="hidden" id="h" name="h" />
			<input type="hidden" id="refW" name="refW" />
			<input type="hidden" id="refH" name="refH" />
		</form>
		<?php
			echo anchor('administracao/fotos/recortar', 'Recortar', array('class' => 'button', 'id' => 'recortar', 'name' => 'recortar'));
		?>
	</div>
</div>

<script type="text/javascript" charset="utf-8">
	$(function(){
		$("button, input:submit, a.button").button();
		$("#recortar").hide();

		id = <?=$this->uri->segment(4)?> - 1;

		is_file_selected = false;

		layer = new Array(
			{"width": 230, "height": 70},
			{"width": 115, "height": 68},
			{"width": 112, "height": 140},
			{"width": 114, "height": 70},
			{"width": 114, "height": 139},
			{"width": 114, "height": 142},
			{"width": 114, "height": 68},
			{"width": 114, "height": 70},
			{"width": 114, "height": 70},
			{"width": 114, "height": 68},
			{"width": 112, "height": 70},
			{"width": 230, "height": 70},
			{"width": 115, "height": 68},
			{"width": 112, "height": 140},
			{"width": 114, "height": 70},
			{"width": 114, "height": 139},
			{"width": 114, "height": 142},
			{"width": 114, "height": 68},
			{"width": 114, "height": 70},
			{"width": 114, "height": 70},
			{"width": 114, "height": 68},
			{"width": 112, "height": 70}
		);

		$.lazy({
			src: '<?=base_url()?>includes/js/uploadify/jquery.uploadify.v2.1.0.js',
			name: 'uploadify',
			dependencies: {
				css: ['<?=base_url()?>includes/css/uploadify/uploadify.css']
			},
			cache: true
		});

		var cropWidget;

		$.getScript('<?=base_url()?>includes/js/jquery.Jcrop.min.js');
		$.getScript('<?=base_url()?>includes/js/jquery.blockUI.js');

		function initCoords() {
			$('#x, input[name=x]').val(0);
			$('#y, input[name=y]').val(0);
			$('#w, input[name=w]').val(layer[id].width);
			$('#h, input[name=h]').val(layer[id].height);
			$('#refW, input[name=refW]').val(layer[id].width);
			$('#refH, input[name=refH]').val(layer[id].height);
		}

		function updateCoords(c) {
			$('#x, input[name=x]').val(c.x);
			$('#y, input[name=y]').val(c.y);
			$('#w, input[name=w]').val(c.w);
			$('#h, input[name=h]').val(c.h);
		};

		function checkCoords() {
			if (parseInt($('#w').val())) return true;
			alert('Please select a crop region then press submit.');
			return false;
		};

		$(document).bind('cbox_complete', function(){
			$("#cropbox").onImagesLoad({
				selectorCallback: function(){
					if (typeof(cropWidget) != 'undefined' && typeof(cropWidget.destroy == 'function')) {
						cropWidget.destroy();
					} else {
						initCoords();
						$("input[name=file_path]").val($(this).attr('src'));

						cropWidget = $.Jcrop("#cropbox",{
							aspectRatio: layer[id].width / layer[id].height,
							minSize: [layer[id].width , layer[id].height],
							setSelect: [0, 0, layer[id].width , layer[id].height],
							onSelect: updateCoords,
							onChange: updateCoords
						});
					}
				}
			});
		});

		$("#upload").uploadify({
			uploader:       '/includes/js/uploadify/uploadify_mod2.swf',
			script:         '/includes/js/uploadify/uploadify.php',
			cancelImg:      '/includes/js/uploadify/cancel.png',
			folder:         '/images/mural',
			buttonText:     'Foto',
			width:			98,
			height:			30,
			auto:			true,
			scriptAccess:   'always',
			wmode:			'transparent',
			fileDesc:		'Fotos (jpg, jpeg, png)',
			fileExt:		'*.jpg;*.jpeg;*.png',
			queueID:		'fileQueue',
			'onError': function (a, b, c, d) {
				if (d.status == 404)
					alert('Não foi possível encontrar o script de upload.');
				else if (d.type === "HTTP")
					alert('error '+d.type+": "+d.info);
				else if (d.type ==="File Size")
					alert(c.name+' '+d.type+' Limite: '+Math.round(d.sizeLimit/1024)+'KB');
				else
					alert('Erro '+d.type+": "+d.text);
			},
			'onSelect': function(event, queueID, fileObj){
				is_file_selected = true;
				$("#nome").val(fileObj.name.replace(fileObj.type, ''));
				$.colorbox.resize({'height':230});
			},
			'onCancel': function(event, queueID, fileObj){
				$.colorbox.resize({'height':170});
				$("#fileQueue").css({'display': 'none', 'margin-bottom': '0px'});
			},
			'onComplete': function (event, queueID, fileObj, response, data) {
				json = $.parseJSON(response);

				$("#cboxContent").block({
					message: '<h1>Aguarde...</h1>',
					css: { border: '3px solid #a00', padding: '25px 10px', 'font-size':'18px' }
				});

				$.post('<?php echo site_url('administracao/mural/processar/recorte'); ?>',{filearray: response},function(info){
					//Post response
					$("#cboxContent").unblock();
					$("#cropWidget").html(info);
					$.colorbox.resize({'width':850, 'height':800});

					$("#cropbox").Jcrop({
						aspectRatio: layer[id].width / layer[id].height,
						minSize: [layer[id].width , layer[id].height],
						setSelect: [0, 0, layer[id].width , layer[id].height],
						onSelect: updateCoords,
						onChange: updateCoords
					});

					$("#dados form").bind('submit', function(){
						data = $(this).serializeArray();
						cropData = $("#thumb form").serializeArray();
						$.post('<?php echo site_url('administracao/mural/processar/'.$this->uri->segment(4)); ?>',{filearray: response, details: data, cropInfo: cropData},function(info){
							//Post response
							$("#Layer-"+(id+1)).find("img").attr('src', info);
							$.colorbox.close();
						});

						$("#content").find("div#debug").html('kjfdlhgjdkf');

						return false;
					});
				});
			}
		});
	});
</script>