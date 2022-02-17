<div id="subHeader">
	<div id="subHeaderLeft">
		<img src="<?=base_url()?>template/img/user1_64.png" />
		<h1>Usuários</h1>
	</div>
	<div id="subHeaderRight">
	</div>
</div>
<div class="clr"></div>
<div id="content">
	<?php
	echo form_open('administracao/usuarios/salvar');
	echo form_label('Nome', 'nome');
	echo form_input('nome', set_value('nome', (isset($linha)? $linha['nome'] : 'Digite aqui o nome completo do usuário')));
	?>
	<div class="clr"></div>
	<?
	echo form_label('Usuário', 'usuario');
	echo form_input('usuario', set_value('usuario', (isset($linha)? $linha['usuario'] : 'Digite aqui o usuário')));
	?>
	<div class="clr"></div>
	<?
	echo form_label('Senha', 'senha');
	echo form_password('senha', set_value('senha', ''));
	?>
	<span class="spacer"></span>
	<?
	echo form_label('Confirmar senha', 'senha_check');
	echo form_password('senha_check', set_value('senha_check', ''));
	?>
	<div class="clr"></div>
	<?
	echo form_label('Email','email');
	echo form_input('email', set_value('email', (isset($linha)? $linha['email'] : 'Digite aqui o email')));
	?>
	<span class="spacer"></span>
	<?
	echo form_label('Nível', 'nivel');
	echo form_dropdown('nivel', $grupos, 1, 'style="width: auto"');
	echo form_label('Grupo', 'grupo',array('style'=>'margin-left: 30px'));
	echo form_radio('grupo', '0', (isset($linha) && $linha['is_admin'] == 0 ? TRUE: FALSE));
	echo form_label('Usuários');
	echo form_radio('grupo', '1', (isset($linha) && $linha['is_admin'] == 1 ? TRUE: FALSE));
	echo form_label('Administradores');
	?>
	<div class="clr"></div>
	<?
	echo form_button(array('name'=>'salvar','id'=>'salvar','type'=>'submit','content'=>img(base_url().'template/img/save_16.png').' Salvar'));
	echo nbs(3);
	echo anchor('administracao/usuarios', img(base_url().'template/img/block_16.png') . ' Cancelar', array('class'=>'button','id'=>'cancel','name'=>'cancel'));
	echo form_hidden('action', $this->uri->segment(3));
	echo form_hidden('id', $this->uri->segment(4));
	?>
	<?=form_close()?>
	<?=$this->session->flashdata('validation_errors')?>
</div>