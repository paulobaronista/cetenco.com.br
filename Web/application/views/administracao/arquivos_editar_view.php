<div id="content">
	<?php echo form_open_multipart(site_url('administracao/arquivos/editar'), Array('id' => 'file_form')); ?>
	<?php
	echo form_label('Nome', 'nome');
	echo form_input(Array('name' => 'nome', 'id' => 'nome'), set_value('nome', (isset($linha) ? $linha['nome'] : 'Digite aqui o nome do arquivo')));
	echo form_label('Grupo', 'grupo');
	echo form_dropdown('grupo', Array(1 => 1, 2 => 2, 3 => 3, 4 => 4, 5 => 5), (isset($linha) ? $linha['idGrupo'] : $this->session->userdata('grupo')), 'id="grupo" style="width:auto"');
	echo form_label('Caminho', 'path', Array('style' => 'display:block'));
	echo form_dropdown('path', $pastas, $actual_path);
	$submit_string = 'Salvar';
	$cancel_string = 'Cancelar';
	?>
	<p><strong>Arquivo:</strong> <?= $linha['arquivo'] ?></p>
	<div class="buttons">
		<?php
		echo form_button(array('name' => 'salvar', 'id' => 'salvar', 'type' => 'submit', 'content' => img(base_url() . 'template/img/save_16.png') . ' ' . $submit_string, 'class' => 'button'));
		echo form_button(Array('name' => 'cancelar', 'id' => 'cancelar', 'content' => img(base_url() . 'template/img/block_16.png') . ' ' . $cancel_string, 'class' => 'button'));
		echo form_hidden('action', $this->uri->segment(3));
		echo form_hidden('id', $this->uri->segment(4));
		?>
	</div
	<?= form_close() ?>
	<div id="fileQueue"></div>
	<?= $this->session->flashdata('validation_errors') ?>
</div>
<script type="text/javascript" charset="utf-8">
	$(function(){
		$("button, input:submit, a.button").button();
		$("#notificacao").css('margin-top', '10px');
		
		$.getScript('<?= base_url() ?>includes/js/jquery.blockUI.js');
	});
</script>