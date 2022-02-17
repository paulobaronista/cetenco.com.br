<h2 class="principal">About Cetenco</h2>

<p><em>"The Cetenco was present in ventures that marked the development of Brazil and the world. And in future, will be present in many others".</em></p>
<p>Operating in the construction field since the mid-1930s in Brazil and abroad, CETENCO ENGENHARIA S.A. has vast know-how in the execution of works in the various areas of engineering.</p>
<p>During its existence, CETENCO has always stood out for the use of modern and advanced construction techniques, using and developing state-of-the-art technologies, aiming at constant concern with social responsibility and respect for the environment, working with emphasis on dams, sluices and hydropower plants, subways, bridges and viaducts, tunnels, roads, railways, ports, airports, transmission lines, substations and industrial, commercial and high-standard buildings.</p>
<p>The name CETENCO is thus engraved in the main and most complex national and international engineering works, such as, for example, in the construction of Binacional de Itaipu hydropower plant, Guri hydropower plant (Venezuela), Paulo Afonso IV hydropower plant, construction of Ferrovia do Aço [railway], Rodovia dos Imigrantes, Bandeirantes and Castelo Branco [highways], São Paulo, Rio de Janeiro and Caracas subways (Venezuela), Sepetiba Sea Terminal,  Barueri Treatment Station,  Dams and Sluices of Barra Bonita, Ibitinga and Promissão, Plaza Centenário and Cetenco Plaza buildings, among many others.</p>

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