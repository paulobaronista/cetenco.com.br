<div id="content">
	<?php
	echo form_open_multipart(site_url('administracao/arquivos/editar'),Array('id'=>'file_form'));
	if (!isset($linha['arquivo'])):
		echo form_label('Nível do documento:&nbsp;', 'nivel',Array('style'=>'width:auto'));
		echo form_dropdown('nivel', Array(1=>1,2=>2,3=>3,4=>4,5=>5), (isset($linha)? $linha['idGrupo'] : $this->session->userdata('grupo')), 'id="nivel" style="width:auto"');
		echo form_upload(Array('name' => 'Filedata', 'id' => 'upload'));
	?>
	<p id="aviso">Aguarde até que o arquivo apareça abaixo <strong>antes</strong> de clicar em Salvar.</p>
	<?php
	else :
		echo form_label('Nome', 'nome');
		echo form_input(Array('name' => 'nome', 'id' => 'nome'), set_value('nome', (isset($linha)? $linha['nome'] : 'Digite aqui o nome do arquivo')));
	?>
	<p><strong>Arquivo:</strong> <?=$linha['arquivo']?></p>
	<?php endif; ?>
	<div class="buttons">
	<?php
	echo form_button(array('name'=>'salvar','id'=>'salvar','type'=>'submit','content'=>img(base_url().'template/img/save_16.png').' Enviar arquivos', 'class'=>'button'));
	echo form_button(Array('name'=>'cancelar','id'=>'cancelar','content'=>img(base_url().'template/img/block_16.png') . ' Limpar arquivos selecionados', 'class'=>'button'));
	echo form_hidden('action', $this->uri->segment(3));
	echo form_hidden('id', $this->uri->segment(4));
	?>
	</div>
	<?=form_close()?>
	<div id="fileQueue"></div>
	<?=$this->session->flashdata('validation_errors')?>
</div>
<script type="text/javascript" charset="utf-8">
	$(function(){
		$("button, input:submit, a.button").button();
		$("#notificacao").css('margin-top', '10px');
		
		$.lazy({
			src: '<?=base_url()?>includes/js/uploadify/jquery.uploadify.v2.1.4.min.js',
			name: 'uploadify',
			dependencies: {
				css: ['<?=base_url()?>includes/css/uploadify/uploadify.css']
			},
			cache: true
		});
		
		$.getScript('<?=base_url()?>includes/js/jquery.blockUI.js');

		is_file_selected = false;
		files = new Array();
		
		$("#upload").uploadify({
			uploader:       '/includes/js/uploadify/uploadify.swf',
			script:         '<?=base_url()?>includes/js/uploadify/uploadify.php',
			cancelImg:      '<?=base_url()?>includes/js/uploadify/cancel.png',
			folder:         '/arquivos',
			buttonText:     'Arquivo',
			width:			120,
			height:			30,
			scriptAccess:   'always',
			multi:          true,
			wmode:			'transparent',
			scrolling:		false,
			fileDesc:		'Arquivos (PDF, DOC/DOCX, XLS/XLSX, RTF, TXT)',
			fileExt:		'*.pdf;*.doc;*.docx;*.xls;*.xlsx;*.rtf;*.txt',
			queueID:		'fileQueue',
			'onInit': function() {
				var uploader = this;
				$("#cancelar").click(function(e){
					$(uploader).uploadifyClearQueue();
				});
			},
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
			'onSelect': function(event, queueID, fileObj){
				is_file_selected = true;
				raw_name = fileObj.name.replace(fileObj.type, '');
				$("#nome").val(raw_name.replace(/[-_]/g,' '));
			},
			'onComplete': function (event, queueID, fileObj, response, data) {
//				//Post response back to controller
//				$.blockUI({
//					theme:     true,
//					title:    'Arquivo Enviado',
//					message:  '<p>Por favor, aguarde. Enviando emails de notificação.</p>'
//				});
				
				files.push(response);
				
				formData = $("#file_form").serializeArray();
//				$.post('<?php //echo site_url('administracao/arquivos/'.$this->uri->segment(3)); ?>',{filearray: response, data: formData},function(){
//					$.unblockUI({
//						onUnblock: function(){
//							location.reload();
//						}
//					});
//				});
			},
			'onAllComplete': function(event,data) {
				console.log(files);
				console.log(event);
				console.log(data);
			}
		});

		$("#file_form").submit(function(){
			if (is_file_selected) {
				$("#upload").uploadifyUpload();
				return false;
			} else {
				return true;
			}
		});
	});
</script>