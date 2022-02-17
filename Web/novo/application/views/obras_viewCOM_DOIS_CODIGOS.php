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
	<!-- This is 'layer1_img' -->
<!--	<div id="Layer-<?=$layer_ids[0]?>"  >
		<a href="<?=site_url('obras/'.$this->uri->segment(3).'/'.$mural[0]->idCategoria.'/'.$mural[0]->idObra)?>">
			<img src="<?= base_url() . (isset($mural[0]) ? 'images/mural/thumbs/' . $mural[0]->miniatura : 'includes/dull.gif'); ?>" width="230" height="70" alt="layer1" class="pngimg" />
		</a>
	</div>

	 This is 'layer2_img' 
	<div id="Layer-<?=$layer_ids[1]?>"  >
		<a href="<?=site_url('obras/'.$this->uri->segment(3).'/'.$mural[1]->idCategoria.'/'.$mural[1]->idObra)?>">
			<img src="<?= base_url() . (isset($mural[1]) ? 'images/mural/thumbs/' . $mural[1]->miniatura : 'includes/dull.gif'); ?>" width="115" height="68" alt="layer2" class="pngimg" />
		</a>
	</div>

	 This is 'layer3_img' 
	<div id="Layer-<?=$layer_ids[2]?>"  >
		<a href="<?=site_url('obras/'.$this->uri->segment(3).'/'.$mural[2]->idCategoria.'/'.$mural[2]->idObra)?>">
			<img src="<?= base_url() . (isset($mural[2]) ? 'images/mural/thumbs/' . $mural[2]->miniatura : 'includes/dull.gif'); ?>" width="112" height="140" alt="layer3" class="pngimg" />
		</a>
	</div>

	 This is 'layer4_img' 
	<div id="Layer-<?=$layer_ids[3]?>"  >
		<a href="<?=site_url('obras/'.$this->uri->segment(3).'/'.$mural[3]->idCategoria.'/'.$mural[3]->idObra)?>">
			<img src="<?= base_url() . (isset($mural[3]) ? 'images/mural/thumbs/' . $mural[3]->miniatura : 'includes/dull.gif'); ?>" width="114" height="70" alt="layer4" class="pngimg" />
		</a>
	</div>

	 This is 'layer5_img' 
	<div id="Layer-<?=$layer_ids[4]?>"  >
		<a href="<?=site_url('obras/'.$this->uri->segment(3).'/'.$mural[4]->idCategoria.'/'.$mural[4]->idObra)?>">
			<img src="<?= base_url() . (isset($mural[4]) ? 'images/mural/thumbs/' . $mural[4]->miniatura : 'includes/dull.gif'); ?>" width="114" height="139" alt="layer5" class="pngimg" />
		</a>
	</div>

	 This is 'layer6_img' 
	<div id="Layer-<?=$layer_ids[5]?>"  >
		<a href="<?=site_url('obras/'.$this->uri->segment(3).'/'.$mural[5]->idCategoria.'/'.$mural[5]->idObra)?>">
			<img src="<?= base_url() . (isset($mural[5]) ? 'images/mural/thumbs/' . $mural[5]->miniatura : 'includes/dull.gif'); ?>" width="114" height="142" alt="layer6" class="pngimg" />
		</a>
	</div>

	 This is 'layer7_img' 
	<div id="Layer-<?=$layer_ids[6]?>"  >
		<a href="<?=site_url('obras/'.$this->uri->segment(3).'/'.$mural[6]->idCategoria.'/'.$mural[6]->idObra)?>">
			<img src="<?= base_url() . (isset($mural[6]) ? 'images/mural/thumbs/' . $mural[6]->miniatura : 'includes/dull.gif'); ?>" width="114" height="68" alt="layer7" class="pngimg" />
		</a>
	</div>

	 This is 'layer8_img' 
	<div id="Layer-<?=$layer_ids[7]?>"  >
		<a href="<?=site_url('obras/'.$this->uri->segment(3).'/'.$mural[7]->idCategoria.'/'.$mural[7]->idObra)?>">
			<img src="<?= base_url() . (isset($mural[7]) ? 'images/mural/thumbs/' . $mural[7]->miniatura : 'includes/dull.gif'); ?>" width="114" height="70" alt="layer8" class="pngimg" />
		</a>
	</div>

	 This is 'layer9_img' 
	<div id="Layer-<?=$layer_ids[8]?>"  >
		<a href="<?=site_url('obras/'.$this->uri->segment(3).'/'.$mural[8]->idCategoria.'/'.$mural[8]->idObra)?>">
			<img src="<?= base_url() . (isset($mural[8]) ? 'images/mural/thumbs/' . $mural[8]->miniatura : 'includes/dull.gif'); ?>" width="114" height="70" alt="layer9" class="pngimg" />
		</a>
	</div>

	 This is 'layer10_img' 
	<div id="Layer-<?=$layer_ids[9]?>"  >
		<a href="<?=site_url('obras/'.$this->uri->segment(3).'/'.$mural[9]->idCategoria.'/'.$mural[9]->idObra)?>">
			<img src="<?= base_url() . (isset($mural[9]) ? 'images/mural/thumbs/' . $mural[9]->miniatura : 'includes/dull.gif'); ?>" width="114" height="68" alt="layer10" class="pngimg" />
		</a>
	</div>

	 This is 'layer11_img' 
	<div id="Layer-<?=$layer_ids[10]?>"  >
		<a href="<?=site_url('obras/'.$this->uri->segment(3).'/'.$mural[10]->idCategoria.'/'.$mural[10]->idObra)?>">
			<img src="<?= base_url() . (isset($mural[10]) ? 'images/mural/thumbs/' . $mural[10]->miniatura : 'includes/dull.gif'); ?>" width="112" height="70" alt="layer11" class="pngimg" />
		</a>
	</div>-->
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