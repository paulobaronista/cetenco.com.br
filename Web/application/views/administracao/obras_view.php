<div id="subHeader">
	<div id="subHeaderLeft">
		<img src="<?=base_url()?>template/img/settings_64.png" />
		<h1>Obras</h1>
	</div>
	<div id="subHeaderRight">
		<div id="btnAdd">
			<?=anchor(site_url('administracao/obras/adicionar'), img(array('src'=>base_url().'template/img/add.png','width'=>'48px','height'=>'48px')) . '<br />Adicionar')?>
		</div>
	</div>
</div>
<div class="clr"></div>
<div id="content">
	<p>
		<strong>Ver:</strong> <a href="<?=site_url('administracao/obras/realizadas')?>">Obras Realizadas</a> | <a href="<?=site_url('administracao/obras/em-andamento')?>">Obras em Andamento</a>
		<?php if($this->uri->segment(3) == 'realizadas') : ?>
			 - Filtrar por categoria: <?=form_dropdown('categorias', $categorias)?>
		<?php endif;?>
	</p>
	<?php
		$oddCheck = 0;
		$tabela =	'<table id="obras" name="obras" border="0" cellpadding="4" cellspacing="0">'.
					'<thead><tr><th>Título</th><th>Categoria</th><th>Tipo</th><th>Início</th><th>Término</th><th>Publicada</th><th>Editar</th><th>Apagar</th></tr></thead>'.
					'<tbody>';
		foreach ($registros->result() as $linha) {
			$tabela .=	($oddCheck%2 ? '<tr class="odd">' : '<tr>') .
							'<td>'. $linha->titulo .'</td>'.
							'<td>'. $linha->categoria .'</td>'.
							'<td>'. $linha->tipo .'</td>'.
							'<td>'. $linha->execucao_inicio .'</td>'.
							'<td>'. $linha->execucao_fim .'</td>'.
							'<td>'. ($linha->publicada ? anchor(site_url('administracao/obras/despublicar/'.$linha->idObra), img(array('src'=>base_url().'template/img/tick_16.png','alt'=>'Clique para despublicar','title'=>'Clique para despublicar'))) : anchor(site_url('administracao/obras/publicar/'.$linha->idObra), img(array('src'=>base_url().'template/img/stop_16.png','alt'=>'Clique para publicar','title'=>'Clique para publicar')))) .'</td>'.
							'<td>'. anchor(site_url('administracao/obras/editar/'.$linha->idObra), img(array('src'=>base_url().'template/img/pencil_16.png','alt'=>'Editar','title'=>'Editar'))).'</td>'.
							'<td>'. anchor(site_url('administracao/obras/apagar/'.$linha->idObra), img(array('src'=>base_url().'template/img/delete_16.png','alt'=>'Apagar','title'=>'Apagar')), Array('rel'=>'apagar')) .'</td>'.
						'</tr>';
			$oddCheck++;
		}
		$tabela .=	'</tbody></table>';

		echo $tabela;
	?>
</div>

<div id="dialog-confirm" title="Deseja excluir esta obra?">
	<p>
		<span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span>
		Esta ação irá excluir a obra permanentemente e não apenas o idioma exibido desta obra.
	</p>
	<p>&nbsp;</p>
	<p>
		Para apagar apenas um idioma, basta editar a obra, apagando o título e descrição do idioma desejado.
	</p>
	<p>&nbsp;</p>
	<p>
		Você tem certeza que deseja excluir permanentemente esta obra?
	</p>
</div>

<?php if ($this->uri->segment(3) == 'realizadas'): ?>
<script type="text/javascript" charset="utf-8">
	$(function(){
		$('select[name=categorias]').change(function(){
			if ($(this).val() != 0) {
				window.location = '<?=site_url('administracao/obras/'.$this->uri->segment(3))?>/' + $(this).val();
			}
		});

		$("a[rel=apagar]").click(function(){
			var targetUrl = $(this).attr("href");
			console.log(targetUrl);
			$( "#dialog-confirm" ).dialog({
				resizable: false,
				height:250,
				width: 450,
				modal: true,
				buttons: {
					SIM: function() {
						$( this ).dialog( "close" );
						window.location.href = targetUrl;
					},
					NÃO: function() {
						$( this ).dialog( "close" );
					}
				}
			});
			
			return false;
		});
	});
</script>
<?php endif; ?>
