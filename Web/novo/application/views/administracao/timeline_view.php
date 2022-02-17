<div id="subHeader">
	<div id="subHeaderLeft">
		<img src="<?=base_url()?>template/img/Clock-64.png" />
		<h1>Linha do tempo</h1>
	</div>
	<div id="subHeaderRight">
		<div id="btnAdd">
			<?=anchor(site_url('administracao/timeline/adicionar'), img(array('src'=>base_url().'template/img/add.png','width'=>'48px','height'=>'48px')) . '<br />Adicionar')?>
		</div>
	</div>
</div>
<div class="clr"></div>
<div id="content">
	<?php
	$oddCheck = 0;
	$tabela = '<table id="timeline" name="timeline" border="0" cellpadding="4" cellspacing="0">' .
			'<thead><tr><th>Item</th><th>Editar</th><th>Apagar</th></tr></thead>' .
			'<tbody>';
	foreach ($timeline->result() as $evento) {
		if ($evento->idioma == $this->session->userdata('idioma')) {
			$tabela .= ( $oddCheck % 2 ? '<tr class="odd">' : '<tr>') .
					'<td>' . $evento->titulo . '</td>' .
					'<td>' . anchor(site_url('administracao/timeline/editar/' . $evento->id), img(array('src' => base_url() . 'template/img/pencil_16.png', 'alt' => 'Editar', 'title' => 'Editar')), 'id=editar') . '</td>' .
					'<td>' . anchor(site_url('administracao/timeline/apagar/' . $evento->id), img(array('src' => base_url() . 'template/img/delete_16.png', 'alt' => 'Apagar', 'title' => 'Apagar'))) . '</td>' .
					'</tr>';
			$oddCheck++;
		}
	}
	$tabela .= '</tbody></table>';

	echo $tabela;
	?>
</div>