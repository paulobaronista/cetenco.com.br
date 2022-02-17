<div id="login_form">
	<h1>Login</h1>
	<div class="clr"></div>
	<?=form_open(current_url().'/login')?>
	<label for="usuario">Usuário</label>
	<?=form_input('usuario', set_value('usuario'))?>
	<label for="senha">Senha</label>
	<?=form_password('senha', set_value('senha'))?>
	<?=form_label('Idioma do conteúdo', 'idioma')?>
	<?=form_dropdown('idioma', Array('br'=>'Português','en'=>'Inglês','es'=>'Espanhol'))?>
	<?=form_submit('entrar', 'Entrar')?>
	<?=form_close()?>
	<?php if($this->session->flashdata('erro')) :?>
	<div id="erro">
		<ul class="system_messages">
			<li class="red">
				<span class="ico"></span>
				<strong class="system_title"><?=$this->session->flashdata('erro')?></strong>
			</li>
		</ul>
	</div>
	<?php endif; ?>
</div>