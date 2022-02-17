<div id="content">
	<?php
	echo form_open('administracao/certificacoes/salvar');
	echo form_label('Código', 'codigo');
	echo form_input('codigo', set_value('codigo', (isset($linha)? $linha['codigo'] : '')));
	echo form_label('Implantada', 'implantada');
	echo form_radio('implantada', '1', (isset($linha) && $linha['implantada'] ? Array('checked'=>TRUE) : ''));
	echo form_label('Sim');
	echo form_radio('implantada', '0', (isset($linha) && !$linha['implantada'] ? Array('checked'=>TRUE) : ''));
	echo form_label('Não');
	?>
	<div class="clr"></div>
	<?php
	echo form_button(array('name'=>'salvar','id'=>'salvar','type'=>'submit','content'=>img(base_url().'template/img/save_16.png').' Salvar', 'class'=>'button'));
	echo nbs(3);
	echo form_button(Array('name'=>'cancelar','id'=>'cancelar','content'=>img(base_url().'template/img/block_16.png') . ' Cancelar', 'class'=>'button','onclick'=>'$.colorbox.close();'));
	echo form_hidden('action', $this->uri->segment(3));
	echo form_hidden('id', $this->uri->segment(4));
	?>
	<?=form_close()?>
	<?=$this->session->flashdata('validation_errors')?>
</div>