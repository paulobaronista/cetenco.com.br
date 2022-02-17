<h2 class="principal">Acerca de Cetenco</h2>


<p><em>"El Cetenco estuvo presente en negocios que marcaron el desarrollo de Brasil y del mundo. Y en el futuro, estará presente en muchos otros".</em></p>
<p>Actuando en el área de construcción desde mediados de la década de 1930 en Brasil y en el exterior, CETENCO ENGENHARIA S.A. posee amplio know-how en la ejecución de obras en las diversas áreas de la ingeniería.
<p>A lo largo de su existencia, CETENCO se destacó siempre por la colocación de modernas y avanzadas técnicas de construcción con empleo y desarrollo de tecnologías de punta, visando a la constante preocupación con la responsabilidad social y respeto al medio ambiente, actuando con énfasis en represas, esclusas y usinas hidroeléctricas, subterráneos, puentes y viaductos, túneles, autopistas, ferrocarriles, puertos, aeropuertos, líneas de transmisión, subestaciones y edificaciones industriales, comerciales y de alta calidad.</p>
<p>De esta forma, el nombre CETENCO está grabado en las principales y más complejas obras de la ingeniería nacional y mundial como, por ejemplo, en la construcción de la usina Hidroeléctrica Binacional de Itaipú, en la Usina Hidroeléctrica de Guri (Venezuela), Hidroeléctrica de Paulo Afonso IV, construcción del Ferrocarril del Acero, Rodovia dos Imigrantes, Bandeirantes y Castelo Branco, subterráneos de São Paulo, Rio de Janeiro y Caracas (Venezuela), Terminal Marítimo de Sepetiba,  Estación de Tratamiento de Barueri,  Represas y Esclusas de Barra Bonita, Ibitinga y Promissão, los Edificios Plaza Centenário y Cetenco Plaza, entre muchos otros.</p>

<!--<h2 class="principal" style="margin-top: 50px"> Historic Photos </h2>
<div id="thumbs">
	<ul>
		<li><a href="<?=base_url()?>includes/img/historicas/fotosHistoricas1Grd.jpg" class="pop" rel="thumbs"><img src="<?=base_url()?>includes/img/historicas/fotosHistoricas1Pqn.jpg" /></a></li>
		<li><a href="<?=base_url()?>includes/img/historicas/fotosHistoricas2Grd.jpg" class="pop" rel="thumbs"><img src="<?=base_url()?>includes/img/historicas/fotosHistoricas2Pqn.jpg" /></a></li>
		<li><a href="<?=base_url()?>includes/img/historicas/fotosHistoricas3Grd.jpg" class="pop" rel="thumbs"><img src="<?=base_url()?>includes/img/historicas/fotosHistoricas3Pqn.jpg" /></a></li>
		<li><a href="<?=base_url()?>includes/img/historicas/fotosHistoricas4Grd.jpg" class="pop" rel="thumbs"><img src="<?=base_url()?>includes/img/historicas/fotosHistoricas4Pqn.jpg" /></a></li>
		<li><a href="<?=base_url()?>includes/img/historicas/fotosHistoricas5Grd.jpg" class="pop" rel="thumbs"><img src="<?=base_url()?>includes/img/historicas/fotosHistoricas5Pqn.jpg" /></a></li>
		<li><a href="<?=base_url()?>includes/img/historicas/fotosHistoricas6Grd.jpg" class="pop" rel="thumbs"><img src="<?=base_url()?>includes/img/historicas/fotosHistoricas6Pqn.jpg" /></a></li>
		<li><a href="<?=base_url()?>includes/img/historicas/fotosHistoricas7Grd.jpg" class="pop" rel="thumbs"><img src="<?=base_url()?>includes/img/historicas/fotosHistoricas7Pqn.jpg" /></a></li>
		<li><a href="<?=base_url()?>includes/img/historicas/fotosHistoricas8Grd.jpg" class="pop" rel="thumbs"><img src="<?=base_url()?>includes/img/historicas/fotosHistoricas8Pqn.jpg" /></a></li>
	</ul>

	<p class="clear"> Click on images to expand them. </p>
</div>-->

<h2 class="principal" style="margin: 30px 0 20px"><?=lang('timeline')?></h2>
<ul id="linhadotempo" class="jcarousel-skin-tango"></ul>

<script type="text/javascript" charset="utf-8">
	$(function(){
		var mycarousel_itemList = new Array();

		<?php foreach ($timeline->result() as $index => $item) : ?>
			mycarousel_itemList.push({
				id: '<?=$item->idObra?>',
				cat: '<?=$item->idCategoria?>',
				title: '<?=strtr($timeline->row($index)->titulo,"'","\'")?>',
				description: '<?=strtr(character_limiter($timeline->row($index)->titulo, 20),"'","\'")?>',
				thumb:'<?=($timeline->row($index)->imagem != NULL ? base_url() . 'images/timeline/thumbs/' . $timeline->row($index)->imagem : base_url() . 'includes/img/timeline_default.jpg')?>',
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

		function mycarousel_initCallback(carousel)
		{
			// Disable autoscrolling if the user clicks the prev or next button.
			carousel.buttonNext.bind('click', function() {
				carousel.startAuto(0);
			});

			carousel.buttonPrev.bind('click', function() {
				carousel.startAuto(0);
			});

			// Pause autoscrolling if the user moves with the cursor over the clip.
			carousel.clip.hover(function() {
				carousel.stopAuto();
			}, function() {
				carousel.startAuto();
			});
		};


		/**
		 * Item html creation helper.
		 */
		function mycarousel_getItemHTML(item) {
			if (item.status == 'realizadas') {
				return '<a href="<?=site_url('obras/')?>/' + item.status + '/' + item.cat + '/' + item.id + '" title="' + item.title + '"><img src="' + item.thumb + '" border="0" alt="' + item.title + '" /><br />' + item.description + '</a>';
			} else {
				return '<a href="<?=site_url('obras/')?>/' + item.status + '/' + item.id + '" title="' + item.title + '"><img src="' + item.thumb + '" border="0" alt="' + item.title + '" /><br />' + item.description + '</a>';
			}
		};

		$('#linhadotempo').jcarousel({
			auto: 2,
//			visible: 6,
			size: mycarousel_itemList.length,
			wrap: 'circular',
			itemLoadCallback: {onBeforeAnimation: mycarousel_itemLoadCallback},
			initCallback: mycarousel_initCallback
		});
	});
</script>