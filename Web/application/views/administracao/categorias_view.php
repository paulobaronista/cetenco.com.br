<div id="subHeader">
	<div id="subHeaderLeft">
		<img src="<?=base_url()?>template/img/box_content.png" />
		<h1>Categorias</h1>
	</div>
	<div id="subHeaderRight">
		<div id="btnAdd">
			<?=anchor(site_url('administracao/categorias/adicionar'), img(array('src'=>base_url().'template/img/add.png','width'=>'48px','height'=>'48px')) . '<br />Adicionar', 'id=adicionar')?>
		</div>
	</div>
</div>
<div class="clr"></div>
<div id="content">
	<?php
		$oddCheck = 0;
		$tabela =	'<table id="categoria" name="categoria" border="0" cellpadding="4" cellspacing="0">'.
					'<thead><tr><th>Categoria</th><th>Editar</th><th>Apagar</th></tr></thead>'.
					'<tbody>';
		foreach ($registros->result() as $linha) {
			if ($linha->idioma == $this->session->userdata('idioma')){
				$tabela .=	($oddCheck%2 ? '<tr class="odd">' : '<tr>') .
								'<td>'. $linha->categoria .'</td>'.
								'<td>'. anchor(site_url('administracao/categorias/editar/'.$linha->idCategoria), img(array('src'=>base_url().'template/img/pencil_16.png','alt'=>'Editar','title'=>'Editar')), 'id=editar').'</td>'.
								'<td>'. anchor(site_url('administracao/categorias/apagar/'.$linha->idCategoria), img(array('src'=>base_url().'template/img/delete_16.png','alt'=>'Apagar','title'=>'Apagar'))) .'</td>'.
							'</tr>';
				$oddCheck++;
			}
		}
		$tabela .=	'</tbody></table>';

		echo $tabela;
	?>
</div>
<script type="text/javascript" charset="utf-8">
	$(function(){
		$.lazy({
			src: '<?=base_url()?>includes/js/jquery.colorbox-min.js',
			name: 'colorbox',
			dependencies: {
				css: ['<?=base_url()?>includes/css/colorbox/colorbox.css']
			},
			cache: true
		});

		$("a[rel=colorbox], #editar, #adicionar").colorbox({
			width: 600,
			height: 240
		});
	});
</script>