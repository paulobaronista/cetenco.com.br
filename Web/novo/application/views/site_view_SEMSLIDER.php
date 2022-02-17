<div id="destaque-img">
	<?php if ($destaques->num_rows() > 0) :?>
		<?php foreach($destaques->result() as $destaque):?>
		<div class="destaque">
			<div id="legenda"><?=($destaque->realizada == 1 ? 'Obra Realizada' : 'Obra Em Andamento')?></div>
			<img src="<?=site_url('images/destaques/'.$destaque->foto)?>" />
		</div>

		<div class="descricao">
			<h2><?=$destaque->titulo?></h2>
			<p><?=$destaque->local?></p>
			<?php $status=($destaque->realizada == 1 ? 'realizadas' : 'em-andamento')?>
			<p><a href="<?=site_url('obras/'.$status.'/'.$destaque->idCategoria.'/'.$destaque->idObra)?>">+ | Veja Mais</a></p>
		</div>
		<?php endforeach;?>
	<?php endif;?>
</div>

<h2 id="destaque-home">
	Atuando na área de construção desde a década de 1930 no Brasil e no exterior, a CETENCO ENGENHARIA S.A.
	possui vasto know-how na execução de obras nas diversas áreas da engenharia.
	Conheça mais sobre nossa história. Veja nossa Linha do Tempo.
</h2>

<!--<div id="linhadotempo"></div>-->
<ul id="linhadotempo" class="jcarousel-skin-tango"></ul>
<script type="text/javascript" charset="utf-8">
	$(function(){
		var mycarousel_itemList = new Array();

		<?php foreach ($timeline->result() as $index => $item) : ?>
			mycarousel_itemList.push({
				id: '<?=$item->idObra?>',
				cat: '<?=$item->idCategoria?>',
				title: '<?=$timeline->row($index)->titulo?>',
				description: '<?=character_limiter($timeline->row($index)->titulo, 20)?>',
				thumb:'<?=($timeline->row($index)->imagem != NULL ? base_url() . 'images/timeline/' . $timeline->row($index)->imagem : base_url() . 'includes/img/timeline_default.jpg')?>',
				upload_date: '<?=$timeline->row($index)->execucao_fim?>',
				status: '<?=($item->realizada == 1 ? 'realizadas' : 'em-andamento')?>'
			});
		<?php endforeach; ?>

		function mycarousel_itemLoadCallback(carousel, state) {
			for (var i = carousel.first; i <= carousel.last; i++) {
				if (carousel.has(i)) {
					continue;
				}

				if (i > mycarousel_itemList.length) {
					break;
				}

				// Create an object from HTML
				var item = jQuery(mycarousel_getItemHTML(mycarousel_itemList[i-1])).get(0);

				carousel.add(i, item);
			}
		};

		/**
		 * Item html creation helper.
		 */
		function mycarousel_getItemHTML(item) {
			return '<a href="<?=site_url('obras/')?>/' + item.status + '/' + item.cat + '/' + item.id + '" title="' + item.title + '">' + item.upload_date + '<img src="' + item.thumb + '" width="135" height="115" border="0" alt="' + item.title + '" /><br />' + item.description + '</a>';
		};


		$('#linhadotempo').jcarousel({
			visible: 5,
			size: mycarousel_itemList.length,
			itemLoadCallback: {onBeforeAnimation: mycarousel_itemLoadCallback}
		});
	});
</script>