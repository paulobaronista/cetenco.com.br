<div id="subHeader">
	<div id="subHeaderLeft">
		<img src="<?=base_url()?>template/img/folder_files_64.png" />
		<h1>Currículos</h1>
	</div>
	<div id="subHeaderRight">
	</div>
</div>
<div class="clr"></div>
<div id="content">
	<?php
		echo form_label('Filtrar por área: ', 'areas');
		echo form_dropdown('areas', $areas);

		$oddCheck = 0;
		$tabela =	'<table id="arquivos" name="arquivos" border="0" cellpadding="4" cellspacing="0">'.
					'<thead><tr><th>Nome</th><th>Email</th><th>Área</th><th>Data de Envio</th><th>Baixar Currículo</th><th>Apagar</th></tr></thead>'.
					'<tbody>';
		foreach ($curriculos->result() as $curriculo) {
			$tabela .=	($oddCheck%2 ? '<tr class="odd">' : '<tr>') .
							'<td>'. $curriculo->nome .'</td>'.
							'<td>'. $curriculo->email .'</td>'.
							'<td>'. $curriculo->depto .'</td>'.
							'<td>'. $curriculo->data .'</td>'.
//							'<td>'. anchor(site_url('administracao/curriculos/download/'.$curriculo->curriculo), img(array('src'=>base_url().'template/img/arrow_down_16.png','alt'=>'Baixar','title'=>'Baixar'))).'</td>'.
							'<td>'. anchor(site_url('curriculos/'.$curriculo->curriculo), img(array('src'=>base_url().'template/img/arrow_down_16.png','alt'=>'Baixar','title'=>'Baixar'))).'</td>'.
							'<td>'. anchor(site_url('administracao/curriculos/apagar/'.$curriculo->id), img(array('src'=>base_url().'template/img/delete_16.png','alt'=>'Apagar','title'=>'Apagar'))) .'</td>'.
						'</tr>';
			$oddCheck++;
		}
		$tabela .= '</tbody></table>';

		echo $tabela;
	?>
	<div id="returnTest"></div>
</div>
<script type="text/javascript" charset="utf-8">
	$(function(){
		depto = '<?=$this->uri->segment(4)?>';

		if (depto) {
			$("select[name=areas]").val(depto);
		} else {
			$("select[name=areas]").val(0);
		}

		$("select[name=areas]").change(function(){
//			$.post('<?=site_url('administracao/curriculos/filtrar')?>',{area:$("select[name=areas]").val()}, function(info){
//				$("#content").html(info);
//			});
			if ($(this).val() > 0) {
				window.location = '<?=site_url('administracao/curriculos/filtrar')?>/' + $(this).val();
			} else {
				window.location = '<?=site_url('administracao/curriculos')?>';
			}
		});
	});
</script>