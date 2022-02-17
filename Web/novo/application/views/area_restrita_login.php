<div id="login_form">
	<h1><?=lang('login')?></h1>
	<div class="clr"></div>
	<?=form_open(site_url('area-restrita/login'))?>
	<label for="usuario"><?=lang('usuario')?></label>
	<?=form_input('usuario', set_value('usuario'))?>
	<label for="senha"><?=lang('senha')?></label>
	<?=form_password('senha', set_value('senha'))?>
	<?=form_submit('entrar', 'OK')?>
	<?=form_close()?>
</div>