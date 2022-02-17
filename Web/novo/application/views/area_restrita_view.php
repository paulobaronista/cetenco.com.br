<a href="<?=site_url('area-restrita/logout')?>" style="float: right"><?=lang('sair')?></a>
<div class="clear"></div>
<?php
$oddCheck = 0;
$tabela =	'<table id="arquivos" name="arquivos" border="0" cellpadding="4" cellspacing="0">' .
				'<thead>'.
					'<tr>'.
						'<th>'.lang('nome').'</th>'.
						'<th>'.lang('arquivo').'</th>'.
						'<th>'.lang('download').'</th>'.
					'</tr>'.
				'</thead>' .
			'<tbody>';

foreach ($arquivos->result() as $arquivo) {
	$tabela .= ( $oddCheck % 2 ? '<tr class="odd">' : '<tr>') .
			'<td>' . $arquivo->nome . '</td>' .
			'<td>' . $arquivo->arquivo . '</td>' .
			'<td>' . anchor(site_url('area-restrita/download/' . $arquivo->arquivo), img(array('src' => base_url() . 'template/img/arrow_down_16.png', 'alt' => 'Baixar', 'title' => 'Baixar'))) . '</td>' .
			'</tr>';
	$oddCheck++;
}
$tabela .= '</tbody></table>';

echo $tabela;
?>