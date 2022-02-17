<html lang="pt-br">

	<head>
		<title></title>
		<meta charset="utf-8" />
	</head>
	
	<body>
		
		<p>
			<img alt="Cetenco" src="<?php echo base_url(); ?>template/img/logo.png" width="100" height="50" />
		</p>
		
		<p>
			<b>Nome:</b> <?=$this->input->post('txtNome')?>
		</p>
		<p>
			<b>Email:</b> <?=$this->input->post('txtEmail')?>
		</p>
		
		<?php if($this->input->post('txtEmpresa')):?>
		
			<p>
				<b>Empresa:</b> <?=$this->input->post('txtEmpresa')?>
			</p>
		
		<?php endif;?>
		
		<p>
			<b>Área:</b> <?=$this->input->post('txtArea')?>
		</p>
		<p>
			<b>Mensagem:</b> <?=$this->input->post('txtMensagem')?>
		</p>
	
	</body>

</html>