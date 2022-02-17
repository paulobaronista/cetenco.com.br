<?php foreach ($fotos as $foto) : ?>
	<li id="fotos_<?=$foto->idFoto?>" class="thumb ui-state-default">
		<a rel="colorbox" href="<?=base_url() . 'images/' . $foto->nome ?>">
			<img src="<?=base_url() . 'images/thumbs/' . $foto->miniatura ?>" />
		</a>
		<div class="caption"></div>
	</li>
<?php endforeach; ?>