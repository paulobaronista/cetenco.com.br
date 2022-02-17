<div id="content">
	<?=form_open('administracao/arquivos/criar_pasta',Array('id'=>'frmPasta'))?>
	<div id="tabsContent">
		<?php
			echo form_label('Caminho', 'path');
			echo form_dropdown('path', $pastas);
			echo form_label('Pasta', 'pasta');
			echo form_input('pasta', set_value('pasta', (isset($pasta)? $pasta : 'Digite aqui o nome da pasta')));
		?>
	</div>
	<div id="erro">
		<ul class="system_messages">
			<li class="red">
				<span class="ico"></span>
				<strong class="system_title"><?=validation_errors()?></strong>
			</li>
		</ul>
	</div>
	<div class="clr"></div>
	<div class="notabs">
		<?
		echo form_button(array('name'=>'salvar','id'=>'salvar','type'=>'submit','content'=>img(base_url().'template/img/save_16.png').' Criar pasta', 'class'=>'button'));
//		echo nbs(3);
//		echo form_button(Array('name'=>'cancelar','id'=>'cancelar','content'=>img(base_url().'template/img/block_16.png') . ' Cancelar', 'class'=>'button','onclick'=>'$.colorbox.close();'));
		?>
		<?=form_close()?>
	</div>
</div>
<script>
	function doSubmit(obj) {
		if ($("input[name=pasta]").val().match(/[a-zA-Z0-9-_]+/) && $("input[name=pasta]").val().length < 129) {
			$("#cboxWrapper").block({
				message:  '<p>Por favor, aguarde.</p>'
			});
			$.post('/administracao/arquivos/folder_exists',{path:$("select[name=path]").val(),str:$("input[name=pasta]").val()},function(info){
				$("#cboxWrapper").unblock();
				if (info == 0){
					$.colorbox.close();
					$.blockUI({
						message:  '<p>Por favor, aguarde.</p>'
					});
					
					$.post($(obj).attr('action'),$(obj).serialize(),function(){
						location.href = '/administracao/arquivos';
					});
				} else {
					$("#erro").show();
					$(".system_title").html('Esta pasta já existe.');
					$.colorbox.resize();
				}
			});
		} else {
			$("#erro").show();
			$(".system_title").html('Use somente caracteres alfanuméricos, hífen (-) ou underline (_).<br />O nome da pasta não pode conter mais que 128 caracteres.');
			$.colorbox.resize();
		}
	}
	
	$(function(){
		$("#erro").hide();
		
		$("input[name=pasta]").focus(function(){
			if ($(this).val() == 'Digite aqui o nome da pasta') $(this).val('');
		});
		
		$("input[name=pasta]").blur(function(){
			if ($(this).val() == '') $(this).val('Digite aqui o nome da pasta');
		});
		
		$("#frmPasta").submit(function(){
			doSubmit(this);
			return false;
		});
	});
</script>