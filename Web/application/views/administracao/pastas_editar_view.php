<div id="content">
	<?php
	echo form_open('administracao/arquivos/editar_pastas', Array('id' => 'frmPasta'));
	echo form_label('Pasta', 'pasta', Array('style'=>'display:block'));
	echo form_input('pasta', $pasta_atual);
	?>
	<div id="erro">
		<ul class="system_messages">
			<li class="red">
				<span class="ico"></span>
				<strong class="system_title"><?=validation_errors()?></strong>
			</li>
		</ul>
	</div>
	<?php
	echo form_hidden('path', ($path == $pasta_atual ? 'root' : $path));
	echo form_hidden('old_folder', $pasta_atual);
	echo form_button(array('name' => 'salvar', 'id' => 'salvar', 'type' => 'submit', 'content' => img(base_url() . 'template/img/save_16.png') . ' Salvar', 'class' => 'button'));
	echo form_close();
	?>
	
</div>
<script>
	function doSubmit(obj) {
		if ($("input[name=pasta]").val().match(/[a-zA-Z0-9-_]+/) && $("input[name=pasta]").val().length < 129) {
			$("#cboxWrapper").block({
				message:  '<p>Por favor, aguarde.</p>'
			});
			
			var form_data = $(obj).serialize();
			
			$.post('/administracao/arquivos/folder_exists',form_data,function(info){
				if (info == 0){
					$.post($(obj).attr('action'),form_data,function(){
						$("#cboxWrapper").unblock();
						$.colorbox({href:$(obj).attr('action'),width:500});
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
	
	$(document).bind('cbox_complete',function(){
		$("#erro").hide();
	
		$("#frmPasta").submit(function(){
			doSubmit(this);
			return false;
		});
	});
</script>