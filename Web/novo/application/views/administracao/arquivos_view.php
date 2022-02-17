<div id="subHeader">
	<div id="subHeaderLeft">
		<img src="<?=base_url()?>template/img/folder_files_64.png" />
		<h1>Arquivos</h1>
	</div>
	<div id="subHeaderRight">
		<div id="btnAdd">
			<?=anchor(site_url('administracao/arquivos/adicionar'), img(array('src'=>base_url().'template/img/add.png','width'=>'48px','height'=>'48px')) . '<br />Adicionar', 'id=adicionar')?>
		</div>
	</div>
</div>
<div class="clr"></div>
<div id="content">
	<?php
		$oddCheck = 0;
		$tabela =	'<table id="arquivos" name="arquivos" border="0" cellpadding="4" cellspacing="0">'.
					'<thead><tr><th>Nome</th><th>Arquivo</th><th>Grupo</th><th>Notificação</th><th>Baixar</th><th>Editar</th><th>Apagar</th></tr></thead>'.
					'<tbody>';
		foreach ($registros->result() as $linha) {
			if (!$linha->notificacao) {
				$notificacao = anchor(site_url('administracao/arquivos/notificar/'.$linha->idArquivo), img(array('src'=>base_url().'template/img/megaphone_16.png','alt'=>'Notificar','title'=>'Notificar')),Array('id'=>'notificar'));
			} else {
				$notificacao = img(array('src'=>base_url().'template/img/tick_16.png','alt'=>'Notificação enviada','title'=>'Notificação enviada'));
			}
			$tabela .=	($oddCheck%2 ? '<tr class="odd">' : '<tr>') .
							'<td>'. $linha->nome .'</td>'.
							'<td>'. $linha->arquivo .'</td>'.
							'<td>'. $linha->idGrupo .'</td>'.
							'<td>'. $notificacao .'</td>'.
							'<td>'. anchor(site_url('administracao/arquivos/download/'.$linha->arquivo), img(array('src'=>base_url().'template/img/arrow_down_16.png','alt'=>'Baixar','title'=>'Baixar'))).'</td>'.
							'<td>'. anchor(site_url('administracao/arquivos/editar/'.$linha->idArquivo), img(array('src'=>base_url().'template/img/pencil_16.png','alt'=>'Editar','title'=>'Editar')), 'id=editar').'</td>'.
							'<td>'. anchor(site_url('administracao/arquivos/apagar/'.$linha->idArquivo), img(array('src'=>base_url().'template/img/delete_16.png','alt'=>'Apagar','title'=>'Apagar'))) .'</td>'.
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
		$.getScript('<?=base_url()?>includes/js/jquery.blockUI.js');
		$.lazy({
			src: '<?=base_url()?>includes/js/jquery.colorbox-min.js',
			name: 'colorbox',
			dependencies: {
				css: ['<?=base_url()?>includes/css/colorbox/colorbox.css']
			},
			cache: true
		});

		$("#notificar img").click(function(){
			$.blockUI({
				theme:     true,
				title:    'Envio de notificação',
				message:  '<p>Por favor, aguarde. Enviando emails de notificação.</p>'
			});
		});

		$("#adicionar, #editar").colorbox({
			width: 500,
			height: 190
		});
	});
</script>