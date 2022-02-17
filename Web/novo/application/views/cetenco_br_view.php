<h2 class="principal">Sobre a Cetenco</h2>

<p><em>"A Cetenco esteve presente em empreendimentos que marcaram o desenvolvimento do Brasil e do mundo.  E, no futuro, estará presente em muitos outros".</em></p>
<p>Atuando na área de construção desde meados da década de 1930 no Brasil e no exterior, a CETENCO ENGENHARIA S.A. possui vasto know-how na execução de obras nas diversas áreas da engenharia.</p>
<p>Ao longo de sua existência, a CETENCO destacou-se sempre pelo emprego de modernas e avançadas técnicas de construção com emprego e desenvolvimento de tecnologias de ponta, visando à constante preocupação com a responsabilidade social e respeito ao meio ambiente, atuando com ênfase em barragens, eclusas e usinas hidroelétricas, metrôs, pontes e viadutos, túneis, rodovias, ferrovias, portos, aeroportos, linhas de transmissão, subestações e edificações industriais, comerciais e de alto padrão.</p>
<p>Desta forma, o nome CETENCO está gravado nas principais e mais complexas obras da engenharia nacional e mundial como, por exemplo, na construção da usina Hidrelétrica Binacional de Itaipu, na Usina Hidrelétrica de Guri (Venezuela), Hidrelétrica de Paulo Afonso IV, construção da Ferrovia do Aço, Rodovia dos Imigrantes, Bandeirantes e Castelo Branco, metrôs de São Paulo, Rio de Janeiro e Caracas (Venezuela), Terminal Marítimo de Sepetiba, Estação de Tratamento de Barueri, Barragens e Eclusas de Barra Bonita, Ibitinga e Promissão, os Edifícios Plaza Centenário e Cetenco Plaza, dentre muitos outros.</p>

<!--<h2 class="principal" style="margin: 30px 0 10px">Fotos Históricas</h2>
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

	<p class="clear" style="margin-left: 10px">Clique nas imagens para expandí-las.</p>
</div>-->

<h2 class="principal" style="margin: 30px 0 20px">Linha do tempo</h2>
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