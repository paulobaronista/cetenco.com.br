<div id="content">
	<?php
	echo form_open_multipart(site_url('administracao/arquivos/editar'), Array('id' => 'file_form','style'=>'margin-top:20px'));
	echo form_label('Vincular arquivos ao grupo:&nbsp;', 'grupo', Array('style' => 'width:auto;font-size: 16px;font-weight: bold;'));
	echo form_dropdown('grupo', Array(1 => 1, 2 => 2, 3 => 3, 4 => 4, 5 => 5), (isset($linha) ? $linha['idGrupo'] : $this->session->userdata('grupo')), 'id="grupo" style="width:auto"');
	echo form_label('Caminho', 'path', Array('style'=>'display:block'));
	echo form_dropdown('path', $pastas);
	
	$submit_string = 'Enviar arquivos';
	$cancel_string = 'Limpar arquivos selecionados';
	?>
	<div class="buttons">
		<?php
		echo form_upload(Array('name' => 'Filedata', 'id' => 'upload'));
		echo form_button(array('name' => 'salvar', 'id' => 'salvar', 'type' => 'submit', 'content' => img(base_url() . 'template/img/save_16.png') . ' ' . $submit_string, 'class' => 'button'));
		echo form_button(Array('name' => 'cancelar', 'id' => 'cancelar', 'content' => img(base_url() . 'template/img/block_16.png') . ' ' . $cancel_string, 'class' => 'button'));
		echo form_button(Array('name' => 'voltar', 'id' => 'voltar', 'content' => img(base_url() . 'template/img/arrow_up_16.png') . ' Voltar para a página anterior', 'class' => 'button', 'onclick'=>'history.go(-1)'));
		echo form_hidden('action', $this->uri->segment(3));
		echo form_hidden('id', $this->uri->segment(4));
		?>
	</div>
	<p id="aviso">Aguarde até que o arquivo apareça abaixo <strong>antes</strong> de clicar em "Enviar arquivos".</p>
	<?= form_close() ?>
	<div id="fileQueue"></div>
	<?= $this->session->flashdata('validation_errors') ?>
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
		files = [];
		
		$('select[name=path]').change(function(){
			if ($(this).val() != 'root')
				$('#upload').uploadifySettings('folder','/arquivos/'+$('select[name=path]').val());
		});
		
		$("#upload").uploadify({
			uploader:       '<?=base_url()?>includes/js/uploadify/uploadify.swf',
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
				
				if ($('select[name=path]').val() != 'root')
					$(uploader).uploadifySettings({'folder':'/arquivos/'.$('select[name=path]').val()});
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
				files.push(response);
			},
			'onAllComplete': function(event,data) {
				$.post('/administracao/arquivos/adicionar',{ajax_data: files, group: $("#grupo").val(),path:$('select[name=path]').val()},function(response){
//					if (response == 'done')
						$.unblockUI({
							onUnblock: function(){
								location.href = '/administracao/arquivos';
							}
						});
				});
			}
		});

		$("#file_form").submit(function(){
			if (is_file_selected) {
				$.blockUI({
					theme:     true,
					title:    'Enviando arquivos',
					message:  '<p>Por favor, aguarde.</p>'
				});
				$("#upload").uploadifyUpload();
				return false;
			} else {
				return true;
			}
		});
	});
</script>