<div id="subHeader">
	<div id="subHeaderLeft">
		<img src="<?=base_url()?>template/img/box_content.png" />
		<h1>Tipos</h1>
	</div>
	<div id="subHeaderRight">
	</div>
</div>
<div class="clr"></div>
<div id="content">
	<?php
	echo form_open('administracao/tipos/salvar');
	echo form_label('Tipo', 'tipo');
	echo form_input('tipo', set_value('tipo', (isset($linha)? $linha['tipo'] : 'Digite aqui o nome do tipo')));
	?>
	<span class="spacer"></span>
	<?
	echo form_label('Categoria', 'categoria');
	echo form_dropdown('categoria',$categorias, (isset($linha['idCategoria']) ? $linha['idCategoria'] : 1));
	?>
	<div class="clr"></div>
	<?
	echo form_button(array('name'=>'salvar','id'=>'salvar','type'=>'submit','content'=>img(base_url().'template/img/save_16.png').' Salvar'));
	echo nbs(3);
	echo anchor('administracao/tipos', img(base_url().'template/img/block_16.png') . ' Cancelar', array('class'=>'button','id'=>'cancel','name'=>'cancel'));
	echo form_hidden('action', $this->uri->segment(3));
	echo form_hidden('id', $this->uri->segment(4));
	?>
	<?=form_close()?>
	<?=$this->session->flashdata('validation_errors')?>
</div>