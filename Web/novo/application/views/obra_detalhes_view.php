<?php
if ($this->uri->segment(3) == 'realizadas') {
	$h2_title = 'menu_obras_realizadas';
} else if ($this->uri->segment(3) == 'em-andamento') {
	$h2_title = 'menu_obras_em_andamento';
}
?>
<h2 class="principal" style="float: left"><?=lang($h2_title)?></h2>

<div id="filtros" style="float: right; margin-top: 5px">
<?php if ($this->uri->segment(3) == 'realizadas') :?>
<p style="float: left"><?=form_dropdown('categorias', $categorias, 0, 'id = tipo')?></p>

<p id="obrasContainer" style="float: left"><?=lang('selecione_uma_categoria')?></p>
<?php else : ?>
<p style="float: left"><?=form_dropdown('obras', $obras, 0, 'id = tipo')?></p>
<?php endif;?>
</div>

<div class="clear" style="padding-top: 0"></div>

<?php if(isset($obra) && !empty($obra)):?>
	<div id="realizadas" style="margin-top: 0">
		<?php if ($fotos->num_rows() > 0): ?>
			<img src="<?=base_url().'images/cache/'.$fotos->row()->nome?>" width="410" />
		<?php else: ?>
			<img src="<?=base_url()?>/includes/img/foto_indisponivel.jpg" width="410" />
		<?php endif; ?>

		<div id="infos">
			<h2 class="principal"><?=$obra->titulo?></h2>
			<p><?php if(isset($obra->tipo)):?><strong><?=lang('tipo')?>:</strong> <?=$obra->tipo?><br /><?php endif;?>
				<?php if(isset($obra->potencia) && $obra->potencia > 0):?><strong><?=lang('potencia_instalada')?>:</strong> <?=$obra->potencia?>MW<br /><?php endif;?>
				<?php if(isset($obra->descricao)):?><strong><?=lang('descricao')?>:</strong> <?=$obra->descricao?><br /><?php endif;?>
				<?php if(isset($obra->coordenadas)):?><strong><?=lang('coordenadas')?>:</strong> <a href="#gmaps"><?=str_replace('e', lang('coordenadas_sep'),$obra->coordenadas)?></a><br /><?php endif;?>
				<?php if(isset($obra->local)):?><strong><?=lang('lugar')?>:</strong> <?=str_replace(' e ', ' ' . lang('coordenadas_sep') . ' ',$obra->local)?><br /><?php endif;?>
				<?php if(isset($obra->rio) && $obra->rio > 0):?><strong><?=lang('rio')?>:</strong> <?=$obra->rio?><br /><?php endif;?>
				<?php if(isset($obra->contratante)):?><strong><?=lang('contratante')?>:</strong> <?=$obra->contratante?><br /><?php endif;?>
				<?php if(isset($obra->execucao_inico) OR isset($obra->execucao_fim)):?><strong><?=lang('periodo_execucao')?>:</strong> <?=($obra->execucao_inicio ? $obra->execucao_inicio: '') . ($obra->execucao_fim ? lang('periodo_separador').$obra->execucao_fim: '')?></p><?php endif;?>
		</div>
	</div>



	<?php if ($fotos->num_rows() > 0): ?>
	<h2 class="principal"><?php echo lang('album_de_fotos'); ?></h2>
	<div id="thumbs">
		<ul>
			<?php foreach($fotos->result() as $foto):?>
			<li><a href="<?=site_url('images/'.$foto->nome)?>" class="pop" rel="thumbs" alt="Teste do título da imagem" style="height:90px"><img src="<?=base_url().'images/thumbs/'.$foto->miniatura?>" /></a></li>
			<?php endforeach; ?>
	<!--		<li><a href="includes/img/foto-principal.jpg" class="pop" rel="thumbs" alt="Teste do título da imagem"><img src="includes/img/th.jpg" /></a></li>
			<li><a href="includes/img/foto-principal.jpg" class="pop" rel="thumbs"><img src="includes/img/th.jpg" /></a></li>
			<li><a href="includes/img/foto-principal.jpg" class="pop" rel="thumbs"><img src="includes/img/th.jpg" /></a></li>
			<li><a href="includes/img/foto-principal.jpg" class="pop" rel="thumbs"><img src="includes/img/th.jpg" /></a></li>-->
		</ul>

		<p class="clear"><?=lang('click_to_zoom')?></p>
	</div>
	<?php endif; ?>

	<?php if(isset($obra->latitude) && isset($obra->longitude)) :?>
		<div id="gmaps">
			<h2 class="principal"><?php echo lang('google_maps'); ?> - Google Maps</h2>
			<div id="map_canvas" style="height:500px; width:790px"></div>
		</div>
	<?php endif; ?>

<?php else: ?>
	<p style="font-size: 16px"><?=lang('idioma_sem_obras')?></p>
<?php endif; ?>

<script type="text/javascript" charset="utf-8">
	function initialize() {
		var myLatlng = new google.maps.LatLng('<?=$obra->latitude?>', '<?=$obra->longitude?>');
		var myOptions = {
			zoom: 14,
			center: myLatlng,
			mapTypeId: google.maps.MapTypeId.HYBRID
		}
		var map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);
	}

	function loadMap() {
		var script = document.createElement("script");
		script.type = "text/javascript";
		script.src = "http://maps.google.com/maps/api/js?sensor=false&callback=initialize";
		document.body.appendChild(script);
	}

	$(function(){
		$("#content").localScroll();
		<?php if ($this->uri->segment(3) == 'realizadas') : ?>
			var segment = '<?=$this->uri->segment(3)?>';
			var idCat = '<?=$this->uri->segment(4)?>';
			var idObra = '<?=$this->uri->segment(5)?>';

			$('select[name=categorias]').change(function(){
				if ($('select[name=categorias]').val() != 0) {
	//				$.post('<?=site_url('obras/filtroCategoria')?>', {idCat: $('select[name=categorias]').val(), segment: segment}, function(info){
	//					$("#obrasContainer").html(info);
	//						$("#obras").change(function(){
	//							if ($(this).val() != 0) {
	//								window.location = '<?=site_url('obras/'.$this->uri->segment(3))?>/' + $('select[name=categorias]').val() + '/' + $(this).val();
	//							}
	//						});
	//
	//					if (idObra) {
	//						$("#obras").val(idObra);
	//					} else {
	//						$("#obras").val(1);
	//					}
	//				});
					window.location = '<?=site_url('obras/'.$this->uri->segment(3))?>/' + $('select[name=categorias]').val();
				}
			});

			$.post('<?=site_url('obras/filtroCategoria')?>', {idCat: idCat, segment: segment}, function(info){
				$("#obrasContainer").html(info);
				$("#obras").change(function(){
					if ($(this).val() != 0) {
						window.location = '<?=site_url('obras/'.$this->uri->segment(3))?>/' + $('select[name=categorias]').val() + '/' + $(this).val();
					}
				});

				if (idObra) {
					$("#obras").val(idObra);
				} else {
					$("#obras").val(1);
				}
			});

			if (idCat) {
				$('select[name=categorias]').val(idCat);
	//			$('select[name=categorias]').val(idCat).trigger('change');
			}
		<?php else: ?>
			$('select[name=obras]').change(function(){
				window.location = '<?= site_url('obras/' . $this->uri->segment(3)) ?>/' + $(this).val();
			});
		<?php endif; ?>
		<?php if(isset($obra->latitude) && isset($obra->longitude)) :?>
			loadMap();
		<?php endif; ?>

	});
</script>
