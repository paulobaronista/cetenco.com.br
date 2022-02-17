<div id="subHeader">
	<div id="subHeaderLeft">
		<img src="<?=base_url()?>template/img/document_64.png" />
		<h1>Textos</h1>
	</div>
	<div id="subHeaderRight">
	</div>
</div>
<div class="clr"></div>
<div id="content">
	<?php
	echo form_open('administracao/textos/salvar');
	echo form_label('Título', 'titulo');
	echo form_input('titulo', set_value('titulo', (isset($linha)? $linha['titulo'] : '')));
	?>
	<div class="clr"></div>
	<?php
	echo form_label('Sessão', 'sessao');
	echo form_dropdown('sessao', $sessoes, (isset($linha)? $linha['idSessao'] : 1));
	echo form_label('Publicado', 'publicado');
	echo form_radio('publicado', '1', (isset($linha) && $linha['publicado'] ? Array('checked'=>TRUE) : ''));
	echo form_label('Sim');
	echo form_radio('publicado', '0', (isset($linha) && !$linha['publicado'] ? Array('checked'=>TRUE) : ''));
	echo form_label('Não');
	?>
	<div class="clr"></div>
	<?php
	echo form_textarea(Array('name' => 'conteudo','id' => 'conteudo', 'value'=>(isset($linha) && $linha['conteudo'] ? $linha['conteudo'] : '')));
	echo display_ckeditor($ckeditor);
	?>
	<div class="clr"></div>
	<?php
	echo form_button(array('name'=>'salvar','id'=>'salvar','type'=>'submit','content'=>img(base_url().'template/img/save_16.png').' Salvar'));
	echo nbs();
	echo anchor('administracao/textos', img(base_url().'template/img/block_16.png') . ' Cancelar', array('class'=>'button','id'=>'cancel','name'=>'cancel'));
	echo form_hidden('action', $this->uri->segment(3));
	echo form_hidden('id', $this->uri->segment(4));
	?>
	<?=form_close()?>
	<?=$this->session->flashdata('validation_errors')?>
</div>