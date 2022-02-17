<div id="subHeader">
	<div id="subHeaderLeft">
		<img src="<?=base_url()?>template/img/Clock-64.png" />
		<h1>Linha do tempo</h1>
	</div>
	<div id="subHeaderRight">
	</div>
</div>
<div class="clr"></div>
	<div id="content">
	<div id="leftCol" style="width: auto">
		<?php if (isset($timeline->imagem)): ?>
			<img src="<?=base_url().'images/timeline/thumbs/'.$timeline->imagem?>" />
		<?php endif;?>
	</div>
	<div id="rightCol" style="float: left">
		<?=form_open_multipart('administracao/timeline/'.$this->uri->segment(3))?>
			<label>Obra</label>
			<?=form_dropdown('obra', $obras, (isset($timeline->idObra)?$timeline->idObra:1))?>
			<label style="width: auto">Imagem</label>
			<input type="file" name="userfile" />
			<input type="submit" name="enviar" value="Salvar" style="width: auto" />
			<button type="button" id="cancel">Cancelar</button>
			<?=form_hidden('id', $this->uri->segment(4))?>
		<?=form_close()?>
		<p>OBS: a imagem será reduzida e recortada para 120 x 86 pixels</p>
	</div>
</div>
<script type="text/javascript">
	$(function(){
		$('#cancel').click(function(){
			window.location = "<?=site_url('administracao/timeline')?>";
		});
	});
</script>