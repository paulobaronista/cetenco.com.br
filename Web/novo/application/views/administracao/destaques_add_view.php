<div id="subHeader">
	<div id="subHeaderLeft">
		<img src="<?=base_url()?>template/img/star1_64.png" />
		<h1>Destaques</h1>
	</div>
	<div id="subHeaderRight">
	</div>
</div>
<div class="clr"></div>
<div id="content">
	<div id="leftCol">
		<?=form_open_multipart('administracao/destaques/'.$this->uri->segment(3))?>
			<label>Obra</label>
			<?=form_dropdown('obra', $obras, (isset($destaque->idObra)?$destaque->idObra:1))?>
			<div id="file">
				<label style="width: auto">Imagem</label>
				<input type="file" name="userfile" />
			</div>
			<div id="radios">
				<label style="width: auto">Destaque principal?</label>
				<?php echo form_radio('principal', '1', (isset($destaque->principal) AND $destaque->principal == 1 ? TRUE : FALSE)); ?><label>Sim</label>
				<?php echo form_radio('principal', '0', (isset($destaque->principal) AND $destaque->principal == 0 ? TRUE : FALSE)); ?><label>Não</label>
			</div>
			<div class="clr"></div>
			<div id="observacoes">
				<p>DESTAQUE PRINCIPAL: a imagem deve ter <strong>830px</strong> de largura e <strong>310px</strong> de altura</p>
				<p>DEMAIS DESTAQUES: a imagem deve ter <strong>300px</strong> de largura e <strong>180px</strong> de altura</p>
			</div>
			<input type="submit" name="enviar" value="Salvar" style="width: auto" />
			<button type="button" id="cancel">Cancelar</button>
			<?=form_hidden('id', $this->uri->segment(4))?>
		<?=form_close()?>
	</div>
	<div id="rightCol">
		<?php if (isset($destaque->foto)): ?>
			<img src="<?=base_url().'images/destaques/'.$destaque->foto?>" />
		<?php endif;?>
	</div>
</div>
<script type="text/javascript">
	$(function(){
		$('#cancel').click(function(){
			window.location = "<?=site_url('administracao/destaques/'.$this->session->userdata('referrer'))?>";
		});
	});
</script>