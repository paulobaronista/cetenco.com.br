<div id="subHeader">
	<div id="subHeaderLeft">
		<img alt="Textos" src="<?=base_url()?>template/img/document_64.png" />
		<h1>Textos</h1>
	</div>
	<div id="subHeaderRight">
		<div id="btnAdd">
			<?=anchor(site_url('administracao/textos/adicionar'), img(array('src'=>base_url().'template/img/add.png','width'=>'48px','height'=>'48px')) . '<br />Adicionar')?>
		</div>
	</div>
</div>
<div class="clr"></div>
<div id="content">
	<?php
		$oddCheck = 0;
		$tabela =	'<table id="textos" name="textos" border="0" cellpadding="4" cellspacing="0">'.
					'<thead><tr><th>Título</th><th>Publicado</th><th>Editar</th><th>Apagar</th></tr></thead>'.
					'<tbody>';
		foreach ($registros->result() as $linha) {
			$tabela .=	($oddCheck%2 ? '<tr class="odd">' : '<tr>') .
							'<td>'. $linha->titulo .'</td>'.
							'<td>'. $linha->nome .'</td>'.
							'<td>'. ($linha->publicado ? anchor(current_url().'/despublicar/'.$linha->idTexto, img(array('src'=>base_url().'template/img/tick_16.png','alt'=>'Clique para despublicar','title'=>'Clique para despublicar'))) : anchor(site_url('administracao/textos/publicar/'.$linha->idTexto), img(array('src'=>base_url().'template/img/stop_16.png','alt'=>'Clique para publicar','title'=>'Clique para publicar')))) .'</td>'.
							'<td>'. anchor(site_url('administracao/textos/editar/'.$linha->idTexto), img(array('src'=>base_url().'template/img/pencil_16.png','alt'=>'Editar','title'=>'Editar'))).'</td>'.
							'<td>'. anchor(site_url('administracao/textos/apagar/'.$linha->idTexto), img(array('src'=>base_url().'template/img/delete_16.png','alt'=>'Apagar','title'=>'Apagar'))) .'</td>'.
						'</tr>';
			$oddCheck++;
		}
		$tabela .=	'</tbody></table>';

		echo $tabela;
	?>
</div>