<?php if ($this->uri->segment(3) == 'em-andamento'): ?>
<h2 class="principal"><?=lang('menu_obras_em_andamento')?></h2>
<p><?=form_dropdown('obras', $obras, 0)?></p>
<?php else: ?>
<h2 class="principal"><?=lang('menu_obras_realizadas')?></h2>
<p><?=form_dropdown('categorias', $categorias, 0)?></p>
<?php endif; ?>
<div id="mural">
	<?php if ($this->uri->segment(3) == 'em-andamento'): ?>
		<?php foreach($layer_ids as $index => $id) : ?>
			<div id="Layer-<?=$id?>"  >
				<a href="<?=site_url('obras/'.$this->uri->segment(3).'/'.$mural[$index]->idObra)?>">
					<img src="<?= base_url() . (isset($mural[$index]) ? 'images/mural/thumbs/' . $mural[$index]->miniatura : 'includes/dull.gif'); ?>" class="pngimg" />
				</a>
			</div>
		<?php endforeach; ?>
	<?php else: ?>
		<?php foreach($layer_ids as $index => $id) : ?>
			<div id="Layer-<?=$id?>"  >
				<a href="<?=site_url('obras/'.$this->uri->segment(3).'/'.$mural[$index]->idCategoria.'/'.$mural[$index]->idObra)?>">
					<img src="<?= base_url() . (isset($mural[$index]) ? 'images/mural/thumbs/' . $mural[$index]->miniatura : 'includes/dull.gif'); ?>" class="pngimg" />
				</a>
			</div>
		<?php endforeach; ?>
	<?php endif;?>
</div>
<?php if ($this->uri->segment(3) == 'realizadas'): ?>
<script type="text/javascript" charset="utf-8">
	$(function(){
		$('select[name=categorias]').change(function(){
			window.location = '<?=site_url('obras/'.$this->uri->segment(3))?>/' + $(this).val();
		});
	});
</script>
<?php else: ?>
<script type="text/javascript" charset="utf-8">
	$(function(){
		$('select[name=obras]').change(function(){
			window.location = '<?=site_url('obras/em-andamento')?>/' + $(this).val();
		});
	});
</script>
<?php endif;?>