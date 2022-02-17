<div id="content">
	<div id="toolbar">
		<?=anchor(current_url(), img(array('src'=>base_url().'template/img/delete_16.png','alt'=>'Excluir pastas selecionadas','title'=>'Excluir pastas selecionadas', 'id' => 'remove_all','style'=>'position:relative;top:3px')).' Excluir pastas selecionadas',Array('id'=>'remove_all'))?>
	</div>
	<?php
	$oddCheck = 0;
	$tabela = '<table id="pastas" name="pastas" border="0" cellpadding="4" cellspacing="0">' .
			'<thead><tr><th>Selecionar</th><th>Pasta</th><th>Apagar</th></tr></thead>' .
			'<tbody>';
	foreach ($pastas_vazias as $key => $pasta) {
		$tabela .= ($oddCheck % 2 ? '<tr class="odd">' : '<tr>') .
				'<td>' . form_checkbox("selected[$key]", $pasta) . '</td>' .
				'<td>' . $pasta . '</td>' .
				'<td>' . img(array('src' => base_url() . 'template/img/delete_16.png', 'alt' => 'Excluir pasta', 'title' => 'Excluir pasta', 'style' => 'cursor:pointer', 'rel' => "selected[$key]")) . '</td>' .
				'</tr>';
		$oddCheck++;
	}
	$tabela .= '</tbody></table>';

	echo $tabela;
	?>
</div>
<script>
	$(function(){
		pastas = new Array();
		$("#remove_all").button().click(function(e){
			e.preventDefault();
			$("#pastas").find('input:checked').each(function(){
				pastas.push($(this).val());
			});
			
			if (pastas.length < 1) {
				$('#cboxWrapper').block({
					theme:     true,
					title:    'ATENÇÃO',
					message:  '<p>Selecione uma ou mais pastas.</p><input type="button" id="ok" value="OK" onclick="$(\'#cboxWrapper\').unblock();" />'
				});
			} else {
				$('#cboxWrapper').block({
					message:  '<p>Por favor, aguarde.</p>'
				});
				
				$.post($(this).attr('href'),{pastas:pastas},function(response){
					$("#cboxWrapper").unblock();
					if (response == 1) {
//						$.colorbox.close();
						location.href = '/administracao/arquivos';
					}
				});
			}
		});
		
		
		$('#pastas').find('img').click(function(){
			pastas = [$('input[name='+$(this).attr('rel')+']').val()];
			
			$('#cboxWrapper').block({
				message:  '<p>Por favor, aguarde.</p>'
			});
			
			$.post('/administracao/arquivos/pastas_vazias',{pastas:pastas},function(response){
				$("#cboxWrapper").unblock();
				if (response == 1) {
//						$.colorbox.close();
					location.href = '/administracao/arquivos';
				}
			});
		});
		
	});
</script>