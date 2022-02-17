<div id="content">
	<?=form_open('administracao/tipos/salvar');?>
	<div id="tabsContent">
		<?php
			$idiomas = $this->config->item('idiomas');

			$abas = '';
			foreach($idiomas as $value) {
				$abas[]=  '<a href="#'.strtolower($value).'">'.$value.'</a>';
			}

			echo ul($abas);
			$i=0;
		?>

		<?php foreach($idiomas as $key => $value): ?>
			<div id="<?=strtolower($value)?>">
				<?php
				echo form_label('Tipo', 'tipo['.$key.']');
				echo form_input('tipo['.$key.']', set_value('tipo['.$key.']', (isset($linha)? $linha[$i]->tipo : 'Digite aqui o nome do tipo')));
				$i++;
				?>
			</div>
		<?php endforeach;?>
	</div>
	<div class="clr"></div>
	<div class="notabs">
		<?php
		echo form_label('Categoria', 'categoria');
		echo form_dropdown('categoria',$categorias, (isset($linha['idCategoria']) ? $linha['idCategoria'] : 1));
		?>
		<div class="clr"></div>
		<?
		echo form_button(array('name'=>'salvar','id'=>'salvar','type'=>'submit','content'=>img(base_url().'template/img/save_16.png').' Salvar', 'class'=>'button'));
		echo nbs(3);
		echo form_button(Array('name'=>'cancelar','id'=>'cancelar','content'=>img(base_url().'template/img/block_16.png') . ' Cancelar', 'class'=>'button','onclick'=>'$.colorbox.close();'));
		echo form_hidden('action', $this->uri->segment(3));
		echo form_hidden('id', $this->uri->segment(4));
		?>
		<?=form_close()?>
		<?=$this->session->flashdata('validation_errors')?>
	</div>
</div>
<script type="text/javascript" charset="utf-8">
	$(function(){
		$("button, input:submit, a.button").button();

		$("#tabsContent").tabs();
	});
</script>