<div id="content">
	<?php
	echo form_open(site_url('administracao/arquivos/editar'));
	echo form_label('Nome', 'nome');
	echo form_input(Array('name' => 'nome', 'id' => 'nome'), set_value('nome', (isset($linha)? $linha['nome'] : 'Digite aqui o nome do arquivo')));
	if (!isset($linha['arquivo'])):
	?>
	<p id="aviso">Aguarde até que o arquivo apareça abaixo <strong>antes</strong> de clicar em Salvar.</p>
	<?php
	else :
	?>
	<p><strong>Arquivo atual:</strong> <?=$linha['arquivo']?></p>
	<?php endif; ?>
	<div id="fileQueue"></div>
	<?php
	echo form_upload(Array('name' => 'Filedata', 'id' => 'upload'));
	echo form_button(array('name'=>'salvar','id'=>'salvar','type'=>'submit','content'=>img(base_url().'template/img/save_16.png').' Salvar', 'class'=>'button'));
	echo form_button(Array('name'=>'cancelar','id'=>'cancelar','content'=>img(base_url().'template/img/block_16.png') . ' Cancelar', 'class'=>'button','onclick'=>'$.colorbox.close();'));
	echo form_hidden('action', $this->uri->segment(3));
	echo form_hidden('id', $this->uri->segment(4));
	?>
	<?=form_close()?>
	<?=$this->session->flashdata('validation_errors')?>
</div>
<script type="text/javascript" charset="utf-8">
	$(function(){
		$("button, input:submit, a.button").button();
		$("#notificacao").css('margin-top', '10px');
		
		$.lazy({
			src: '<?=base_url()?>includes/js/uploadify/jquery.uploadify.v2.1.0.js',
			name: 'uploadify',
			dependencies: {
				css: ['<?=base_url()?>includes/css/uploadify/uploadify.css']
			},
			cache: true
		});

		$.getScript('<?=base_url()?>includes/js/jquery.blockUI.js');

		is_file_selected = false;

		$("#upload").uploadify({
			uploader:       '<?=base_url()?>includes/js/uploadify/uploadify_mod2.swf',
			script:         '<?=base_url()?>includes/js/uploadify/uploadify.php',
			cancelImg:      '<?=base_url()?>includes/js/uploadify/cancel.png',
			folder:         '/cetenco/arquivos',
			buttonText:     'Arquivo',
			width:			98,
			height:			30,
			scriptAccess:   'always',
			multi:          true,
			wmode:			'transparent',
			fileDesc:		'Arquivos (PDF, DOC/DOCX, XLS/XLSX, RTF, TXT)',
			fileExt:		'*.pdf;*.doc;*.docx;*.xls;*.xlsx;*.rtf;*.txt',
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
			'onSelect': function(event, queueID, fileObj){
				is_file_selected = true;
				$("#nome").val(fileObj.name.replace(fileObj.type, ''));
				$.colorbox.resize({'height':250});
			},
			'onCancel': function(event, queueID, fileObj){
				$.colorbox.resize({'height':190});
				$("#fileQueue").css({'display': 'none', 'margin-bottom': '0px'});
			},
			'onComplete': function (event, queueID, fileObj, response, data) {
				//Post response back to controller
				$.colorbox.close();
				$.blockUI({
					theme:     true,
					title:    'Arquivo Enviado',
					message:  '<p>Por favor, aguarde. Enviando emails de notificação.</p>'
				});
				formData = $("#content form").serializeArray();
				$.post('<?php echo site_url('administracao/arquivos/'.$this->uri->segment(3)); ?>',{filearray: response, data: formData},function(info){
					$.unblockUI({
						onUnblock: function(){
							location.reload();
						}
					});
				});
			}
		});

		$("#content form").submit(function(){
			if (is_file_selected) {
				$("#upload").uploadifyUpload();
				return false;
			} else {
				return true;
			}
		});
	});
</script>