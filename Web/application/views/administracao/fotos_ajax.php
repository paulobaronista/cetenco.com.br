<?php foreach ($fotos as $foto) : ?>
	<li id="fotos_<?=$foto->idFoto?>" class="thumb ui-state-default">
		<a rel="colorbox" href="<?=base_url() . 'images/' . $foto->nome ?>">
			<img src="<?=base_url() . 'images/thumbs/' . $foto->miniatura ?>" alt="Clique para ampliar" />
		</a>
		<div class="caption">
			<a href="<?=site_url('administracao/fotos/excluir/'.$foto->nome)?>">Excluir Foto</a>
			<?php if ($foto->destaque == TRUE) : ?>
				<span class="featured">Destaque</span>
			<?php else : ?>
				<a href="<?=site_url('administracao/fotos/destaque/'.$foto->nome)?>" class="regular">Destaque</a>
			<?php endif; ?>
		</div>
	</li>
<?php endforeach; ?>