<div id="subHeader">
	<div id="subHeaderLeft">
		<img src="<?=base_url()?>template/img/user1_64.png" />
		<h1>Usuários</h1>
	</div>
	<div id="subHeaderRight">
		<div id="btnAdd">
			<?=anchor(site_url('administracao/usuarios/adicionar'), img(array('src'=>base_url().'template/img/add.png','width'=>'48px','height'=>'48px')) . '<br /> Adicionar')?>
		</div>
	</div>
</div>
<div class="clr"></div>
<div id="content">
	<?php
		$oddCheck = 0;
		$tabela =	'<table id="usuarios" name="usuarios" border="0" cellpadding="4" cellspacing="0">'.
					'<thead><tr><th>Nome</th><th>Email</th><th>Usuário</th><th>Nível</th><th>Grupo</th><th>Editar</th><th>Apagar</th></tr></thead>'.
					'<tbody>';
		foreach ($registros->result() as $linha) {
			$tabela .=	($oddCheck%2 ? '<tr class="odd">' : '<tr>') .
							'<td>'. $linha->nome .'</td>'.
							'<td>'. $linha->email .'</td>'.
							'<td>'. $linha->usuario .'</td>'.
							'<td>'. $linha->idGrupo .'</td>'.
							'<td>'. ($linha->is_admin == 0 ? 'Usuários' : 'Administradores') .'</td>'.
							'<td>'. anchor(site_url('administracao/usuarios/editar/'.$linha->idUsuario), img(array('src'=>base_url().'template/img/pencil_16.png','alt'=>'Editar','title'=>'Editar'))).'</td>'.
							'<td>'. anchor(site_url('administracao/usuarios/apagar/'.$linha->idUsuario), img(array('src'=>base_url().'template/img/delete_16.png','alt'=>'Apagar','title'=>'Apagar'))) .'</td>'.
						'</tr>';
			$oddCheck++;
		}
		$tabela .= '</tbody></table>';

		echo $tabela;
	?>
</div>