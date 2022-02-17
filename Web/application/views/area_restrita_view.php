<?
echo form_open(site_url('area_restrita'),Array('id'=>'frmFiltro','style'=>'float:left'));
echo form_label('Pasta: ', 'filtro');
echo form_dropdown('filtro', $options, ($this->input->post('filtro') ? $this->input->post('filtro') : 'none'), 'style=width:300px');
echo form_submit('filtrar','OK');
echo form_close();
?>
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
	$encoded_string = url_base64_encode(base64_encode($arquivo->arquivo.date('Ymd')));
	$tabela .= ( $oddCheck % 2 ? '<tr class="odd">' : '<tr>') .
			'<td>' . $arquivo->nome . '</td>' .
			'<td>' . $arquivo->arquivo . '</td>' .
			'<td>' . anchor(site_url('area-restrita/download/' . $encoded_string), img(array('src' => base_url() . 'template/img/arrow_down_16.png', 'alt' => 'Baixar', 'title' => 'Baixar'))) . '</td>' .
			'</tr>';
	$oddCheck++;
}
$tabela .= '</tbody></table>';

echo $tabela;
?>
<script>
	$(function(){
		$.getScript('<?=base_url()?>includes/js/jquery.blockUI.js',function(){
			$(document).ajaxStop($.unblockUI);
			$("select[name=filtro]").bind('change',function(){
				$.blockUI({ message: 'Por favor, aguarde'});
			})
		});
		
		$("input[type=submit]").hide();
		
		$("select[name=filtro]").change(function(){
			if ($(this).val() != 'none')
				$("#arquivos").load($("#frmFiltro").attr('action')+' #arquivos', {filtro:$(this).val()});
			else
				$("#arquivos").load($("#frmFiltro").attr('action')+' #arquivos');
		});
	});
</script>