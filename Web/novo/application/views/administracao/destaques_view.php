<div id="subHeader">
	<div id="subHeaderLeft">
		<img src="<?=base_url()?>template/img/star1_64.png" />
		<h1>Destaques</h1>
	</div>
	<div id="subHeaderRight">
		<?php if ($destaques->num_rows() < 4):?>
		<div id="btnAdd">
			<?=anchor(site_url('administracao/destaques/adicionar'), img(array('src'=>base_url().'template/img/add.png','width'=>'48px','height'=>'48px')) . '<br />Adicionar')?>
		</div>
		<?php endif; ?>
	</div>
</div>
<div class="clr"></div>
<div id="content">
	<p>
		<strong>Ver destaques:</strong> <a href="<?=site_url('administracao/destaques/principal')?>">Principal</a> | <a href="<?=site_url('administracao/destaques/realizadas')?>">Obras Realizadas</a> | <a href="<?=site_url('administracao/destaques/em_andamento')?>">Obras em Andamento</a>
	</p>
	<?php
	$oddCheck = 0;
	$tabela = '<table id="destaques" name="destaques" border="0" cellpadding="4" cellspacing="0">' .
			'<thead><tr><th>Destaque</th><th>Editar</th><th>Apagar</th></tr></thead>' .
			'<tbody>';
	foreach ($destaques->result() as $destaque) {
		if ($destaque->idioma == $this->session->userdata('idioma')) {
			$tabela .= ( $oddCheck % 2 ? '<tr class="odd">' : '<tr>') .
					'<td>' . $destaque->titulo . '</td>' .
					'<td>' . anchor(site_url('administracao/destaques/editar/' . $destaque->id), img(array('src' => base_url() . 'template/img/pencil_16.png', 'alt' => 'Editar', 'title' => 'Editar')), 'id=editar') . '</td>' .
					'<td>' . anchor(site_url('administracao/destaques/apagar/' . $destaque->id), img(array('src' => base_url() . 'template/img/delete_16.png', 'alt' => 'Apagar', 'title' => 'Apagar'))) . '</td>' .
					'</tr>';
			$oddCheck++;
		}
	}
	$tabela .= '</tbody></table>';

	echo $tabela;
	?>
</div>