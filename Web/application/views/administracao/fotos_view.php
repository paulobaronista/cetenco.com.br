<div id="subHeader">
	<div id="subHeaderLeft">
		<img src="<?=base_url()
?>template/img/photo_64.png" />
		<h1>Fotos</h1>
	</div>
	<div id="subHeaderRight">
		<div id="btnAdd">
			<?=anchor(site_url('administracao/fotos/adicionar'), img(array('src' => base_url() . 'template/img/add.png', 'width' => '48px', 'height' => '48px')) . '<br />Adicionar')
?>
		</div>
	</div>
</div>
<div class="clr"></div>
<div id="content">
	<div id="gallery">
		<?php foreach ($fotos as $foto) :?>
			<div class="thumb">
				<img src="<?=base_url() . 'images/thumbs/' . $foto->miniatura ?>" />
			</div>
		<?php endforeach; ?>
	</div>
</div>