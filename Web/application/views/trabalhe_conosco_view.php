<h2 class="principal"><?=lang('fale_conosco')?></h2>

<p><?=lang('preencha_form')?></p>

<?=form_open(site_url('contato'), Array('id'=>'formulario'))?>
	
	<p><?=lang('nome')?> * <?=form_error('txtNome')?><br />
		<input type="text" value="<?=set_value('txtNome')?>" id="txtNome" class="formContato" name="txtNome"></p>


	<p><?=lang('email')?> * <?=form_error('txtEmail')?><br />
		<input type="text" value="<?=set_value('txtEmail')?>" id="txtEmail" class="formContato" name="txtEmail"></p>


	<p><?=lang('empresa')?><br />
		<input type="text" value="<?=set_value('txtEmpresa')?>" id="txtEmpresa" class="formContato" name="txtEmpresa"></p>


	<p><?=lang('area')?> * <?=form_error('txtArea')?><br />
		<?=form_dropdown('txtArea', $areas, '0', 'id=txtArea')?>
	</p>


	<p><?=lang('assunto')?> * <?=form_error('txtAssunto')?><br />
		<input type="text" value="<?=set_value('txtAssunto')?>" valid="s" id="txtAssunto" class="formContato" name="txtAssunto">
	</p>


	<p><?=lang('mensagem')?> * <?=form_error('txtMensagem')?><br />
		<textarea maxlength="250" wrap="virtual" id="txtMensagem" class="formContatoGd" rows="5" cols="38" name="txtMensagem"><?=set_value('txtMensagem')?></textarea>
	</p>


	<input type="submit" name="enviar" value="<?=lang('btn_enviar')?>" class="btn">
<?=form_close()?>


<div class="endereco">
	<h2 class="principal" style="margin: 0">CETENCO Engenharia S.A.</h2>
	R. Maria Paula 36 - 8º Andar - Bela Vista<br />
	Cep: 01319-000 - São Paulo - SP<br />
	Tel: 11 3320 7000 | Fax: 11 3320 7177<br />
	<a href="http://maps.google.com.br/maps?f=q&source=s_q&hl=pt-BR&geocode=&q=Rua+Maria+Paula+36+-+8%C2%BA+Andar+-+Bela+Vista&sll=-23.551669,-46.639042&sspn=0.001913,0.003484&ie=UTF8&hq=&hnear=R.+Maria+Paula,+36+-+Rep%C3%BAblica,+S%C3%A3o+Paulo,+01319-000&z=17" target="_blank"><?=lang('localize_no_gmaps')?></a>
</div>

<p class="clear">