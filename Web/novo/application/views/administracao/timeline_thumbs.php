<?php foreach ($fotos as $foto) : ?>
	<li id="fotos_<?=$foto->idFoto?>" class="thumb ui-state-default">
		<a rel="colorbox" href="<?=site_url('administracao/timeline/recortar') . '/' . $foto->nome ?>">
			<img src="<?=base_url() . 'images/thumbs/' . $foto->miniatura ?>" />
		</a>
	</li>
<?php endforeach; ?>