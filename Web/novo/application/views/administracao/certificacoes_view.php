<div id="subHeader">
	<div id="subHeaderLeft">
		<img src="<?=base_url()?>template/img/license_64.png" />
		<h1>Certificações</h1>
	</div>
	<div id="subHeaderRight">
		<div id="btnAdd">
			<?=anchor(site_url('administracao/certificacoes/adicionar'), img(array('src'=>base_url().'template/img/add.png','width'=>'48px','height'=>'48px')) . '<br />Adicionar', 'rel=colorbox')?>
		</div>
	</div>
</div>
<div class="clr"></div>
<div id="content">
	<?php
		$oddCheck = 0;
		$tabela =	'<table id="certificacoes" name="certificacoes" border="0" cellpadding="4" cellspacing="0">'.
					'<thead><tr><th>Código</th><th>Implantada</th><th>Editar</th><th>Apagar</th></tr></thead>'.
					'<tbody>';
		foreach ($registros->result() as $linha) {
			$tabela .=	($oddCheck%2 ? '<tr class="odd">' : '<tr>') .
							'<td>'. $linha->codigo .'</td>'.
							'<td>'. ($linha->implantada ? anchor(site_url('administracao/certificacoes/implantar/'.$linha->idCertificacao).'/nao', img(array('src'=>base_url().'template/img/tick_16.png','alt'=>'Marcar como Em Implantação','title'=>'Marcar como Em Implantação'))) : anchor(site_url('administracao/certificacoes/implantar/'.$linha->idCertificacao.'/sim'), img(array('src'=>base_url().'template/img/stop_16.png','alt'=>'Marcar como Implantada','title'=>'Marcar como Implantada')))) .'</td>'.
							'<td>'. anchor(site_url('administracao/certificacoes/editar/'.$linha->idCertificacao), img(array('src'=>base_url().'template/img/pencil_16.png','alt'=>'Editar','title'=>'Editar')), 'id=editar').'</td>'.
							'<td>'. anchor(site_url('administracao/certificacoes/apagar/'.$linha->idCertificacao), img(array('src'=>base_url().'template/img/delete_16.png','alt'=>'Apagar','title'=>'Apagar'))) .'</td>'.
						'</tr>';
			$oddCheck++;
		}
		$tabela .=	'</tbody></table>';

		echo $tabela;
	?>
</div>
<script type="text/javascript" charset="utf-8">
	$(function(){
		$.lazy({
			src: '<?=base_url()?>includes/js/jquery.colorbox-min.js',
			name: 'colorbox',
			dependencies: {
				css: ['<?=base_url()?>includes/css/colorbox/colorbox.css']
			},
			cache: true
		});

		$("a[rel=colorbox], #editar, .subtext a").colorbox({
			width: 600,
			height: 180
		});

	});
</script>