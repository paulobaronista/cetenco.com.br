<p>
	Nome: <?=$this->input->post('txtNome')?>
</p>
<?php if($this->input->post('txtEmpresa')):?>
<p>
	Empresa: <?=$this->input->post('txtEmpresa')?>
</p>
<?php endif;?>
<p>
	Área: <?=$this->input->post('txtArea')?>
</p>
<p>
	Mensagem: <?=$this->input->post('txtMensagem')?>
</p>