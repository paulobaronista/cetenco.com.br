<div id="destaque-img">
	<?php if ($destaques->num_rows() > 0) :?>
		<?php foreach($destaques->result() as $key => $destaque):?>
			<?php if ($destaque->realizada == 1) : ?>
				<!-- DESTAQUE -> Obra Realizada -->
				<div id="slide-<?=($key+1)?>">
					<div class="destaque">
						<div class="legenda"><?php echo lang('obra_realizada'); ?> | <?=$destaque->titulo?></div>
						<a href="<?=site_url('obras/realizadas/'.$destaque->idCategoria.'/'.$destaque->idObra)?>"><img src="<?=site_url('images/destaques/'.$destaque->foto)?>" /></a>
					</div>
				</div>
			<?php else : ?>
				<!-- DESTAQUE -> Obra Em Andamento -->
				<div id="slide-<?=($key+1)?>">
					<div class="destaque">
						<div class="legenda"><?php echo lang('obra_andamento'); ?> |<?=$destaque->titulo?> </div>
						<a href="<?=site_url('obras/em-andamento/'.$destaque->idObra)?>"><img src="<?=site_url('images/destaques/'.$destaque->foto)?>" /></a>
					</div>
				</div>
			<?php endif;?>
		<?php endforeach;?>
	<?php endif;?>
</div>

<h2 id="destaque-home" <?=(isset($lang_css) ? $lang_css : '')?>>
	A CETENCO ENGENHARIA S.A atua na área de construção desde meados da década de 1930
	no Brasil e no Exterior e possui vasto know-how na execução nas mais diversas áreas da engenharia.
</h2>

<?php if (isset($realizada->idObra)) : ?>
<div class="homecol">
	<h3 id="orealizadas" <?=(isset($lang_css) ? $lang_css : '')?>>Obras Realizadas</h3>
	<a href="<?=site_url('obras/realizadas/'.$realizada->idCategoria.'/'.$realizada->idObra)?>"><img src="<?=site_url('images/destaques/'.$realizada->foto)?>" />
    <p><?=$realizada->titulo?></p></a>
</div>
<?php else : ?>
<div class="homecol">
	<h3 id="orealizadas" <?=(isset($lang_css) ? $lang_css : '')?>>Obras Realizadas</h3>
	<a href="#"><img src="<?=site_url('includes/img/foto_indisponivel.gif')?>" />
    <p>Nenhuma obra cadastrada</p></a>
</div>
<?php endif; ?>

<?php if (isset($andamento->idObra)) : ?>
<div class="homecol">
	<h3 id="orecentes" <?=(isset($lang_css) ? $lang_css : '')?>>Obras Recentes</h3>
	<a href="<?=site_url('obras/em-andamento/'.$andamento->idObra)?>"><img src="<?=site_url('images/destaques/'.$andamento->foto)?>" />
    <p><?=$andamento->titulo?></p></a>
</div>
<?php else : ?>
<div class="homecol">
	<h3 id="orecentes" <?=(isset($lang_css) ? $lang_css : '')?>>Obras Realizadas</h3>
	<a href="#"><img src="<?=site_url('includes/img/foto_indisponivel.gif')?>" />
    <p>Nenhuma obra cadastrada</p></a>
</div>
<?php endif; ?>

<div class="fonehome">
	<h3 id="fhome" <?=(isset($lang_css) ? $lang_css : '')?>>Contato</h3>
	
    <div class="container">
        <p><?=lang('contato_tel')?><br />
        +55 11 <strong>3320.7000</strong></p>
    
        <p><?=lang('contato_links')?>:</p>
        
        <p><a href="<?=site_url('contato')?>"><?=mb_strtoupper(lang('fale_conosco'),'UTF-8')?></a></p>
        
        <p><a href="<?=site_url('contato/trabalhe-conosco')?>"><?=mb_strtoupper(lang('trabalhe_conosco'),'UTF-8')?></a></p>
        
        <p><a href="http://maps.google.com.br/maps?f=q&source=s_q&hl=pt-BR&geocode=&q=Rua+Maria+Paula+36+-+8%C2%BA+Andar+-+Bela+Vista&sll=-23.551669,-46.639042&sspn=0.001913,0.003484&ie=UTF8&hq=&hnear=R.+Maria+Paula,+36+-+Rep%C3%BAblica,+S%C3%A3o+Paulo,+01319-000&z=17" target="_blank"><?=mb_strtoupper(lang('localizacao'),'UTF-8')?></a></p>
    </div>
	
</div>

<div style="display: block; width: 100%; height: 1px; clear: both"></div>