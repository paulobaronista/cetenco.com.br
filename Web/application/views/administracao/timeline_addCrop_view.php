<div id="subHeader">
	<div id="subHeaderLeft">
		<img src="<?=base_url()?>template/img/Clock-64.png" />
		<h1>Linha do tempo</h1>
	</div>
	<div id="subHeaderRight">
	</div>
</div>
<div class="clr"></div>
<div id="content">
	<?=form_open_multipart('administracao/destaques/'.$this->uri->segment(3))?>
		<label>Obra</label>
		<?=form_dropdown('obra', $obras, (isset($evento->id)?$evento->id:1))?>
		<div id="leftCol">
		<div id="source"></div>
		<input type="submit" name="enviar" value="Salvar" style="width: auto" />
		<button type="button" id="cancel">Cancelar</button>
		</div>
		<div id="rightCol">
		<div id="crop"></div>
		</div>
		<div class="clr"></div>
		<?=form_hidden('id', $this->uri->segment(4))?>
	<?=form_close()?>
</div>
<script type="text/javascript">
	$(function(){
		$.lazy({
			src: '<?=base_url()?>includes/js/jquery.Jcrop.min.js',
			name: 'Jcrop',
			cache: true
		});

		$('select[name=obra]').change(function(){
			$('#source').load('<?=site_url('administracao/timeline/lerFotos')?>', {idObra:$(this).val()}, function(){
				$('#ulSort a').bind('click', function(event){
					var file = $(event.currentTarget).attr('href').split('/')[7];
					console.log(file);
					$('#crop').load('<?= site_url('administracao/timeline/recortar') ?>', {file: file});
					return false;
				});
			});
		});

		$('select[name=obra]').trigger('change');

		$('#cancel').click(function(){
			window.location = "<?=site_url('administracao/timeline')?>";
		});
	});
</script>