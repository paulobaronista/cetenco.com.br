<div id="content">
	<?php
	$oddCheck = 0;
	$tabela = '<table id="pastas" name="pastas" border="0" cellpadding="4" cellspacing="0">' .
			'<thead><tr><th>Pasta</th><th>Editar</th></tr></thead>' .
			'<tbody>';
	foreach ($pastas->result() as $pasta) {
		$tabela .= ($oddCheck % 2 ? '<tr class="odd">' : '<tr>') .
				'<td>' . $pasta->path . '</td>' .
				'<td>' . anchor(site_url('administracao/arquivos/editar_pastas'), img(array('src'=>base_url().'template/img/pencil_16.png','width'=>'16px','height'=>'16px')), Array('rel'=>$pasta->path)) . '</td>' .
				'</tr>';
		$oddCheck++;
	}
	$tabela .= '</tbody></table>';

	echo $tabela;
	?>
</div>
<script>
	$(function(){
		$("#pastas").find('a').click(function(e){
			e.preventDefault();
			$.post($(this).attr('href'), {pasta:$(this).attr('rel')}, function(response){
				$.colorbox({html:response,width:500,onClosed:function(){$(document).unbind('cbox_complete');}});
			});
		});
	});
</script>