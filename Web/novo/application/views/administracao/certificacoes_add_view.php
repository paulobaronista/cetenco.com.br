<div id="subHeader">
	<div id="subHeaderLeft">
		<img src="<?=base_url()?>template/img/license_64.png" />
		<h1>Certificações</h1>
	</div>
	<div id="subHeaderRight">
	</div>
</div>
<div class="clr"></div>
<div id="content">
	<?php
	echo form_open('administracao/certificacoes/salvar');
	echo form_label('Código', 'codigo');
	echo form_input('codigo', set_value('codigo', (isset($linha)? $linha['codigo'] : '')));
	?>
	<span class="spacer"></span>
	<?php
	echo form_label('Implantada', 'implantada');
	echo form_radio('implantada', '1', (isset($linha) && $linha['implantada'] ? Array('checked'=>TRUE) : ''));
	echo form_label('Sim');
	echo form_radio('implantada', '0', (isset($linha) && !$linha['implantada'] ? Array('checked'=>TRUE) : ''));
	echo form_label('Não');
	?>
	<div class="clr"></div>
	<?php
	echo form_button(array('name'=>'salvar','id'=>'salvar','type'=>'submit','content'=>img(base_url().'template/img/save_16.png').' Salvar'));
	echo nbs(3);
	echo anchor('administracao/certificacoes', img(base_url().'template/img/block_16.png') . ' Cancelar', array('class'=>'button','id'=>'cancel','name'=>'cancel'));
	echo form_hidden('action', $this->uri->segment(3));
	echo form_hidden('id', $this->uri->segment(4));
	?>
	<?=form_close()?>
	<?=$this->session->flashdata('validation_errors')?>
</div>