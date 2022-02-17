<div id="login_form">
	<h2 class="principal"><?=lang('login')?></h2>
	<div class="clr"></div>
	<div id="area-restrita"><?=form_open(site_url('area-restrita/login'))?>
	<label for="usuario"><?=lang('usuario')?></label>
	<?=form_input(Array('id' => 'usuario', 'name' => 'usuario', 'value' => set_value('usuario')))?>
	<label for="senha"><?=lang('senha')?></label>
	<?=form_password('senha', set_value('senha'))?>
    <div class="clr"></div>
	<?=form_submit(Array('name' => 'entrar', 'value' => 'Login', 'class' => 'btn'))?>
    <div class="clr"></div>
	<?=form_close()?></div>
    <div class="clr"></div>
</div>