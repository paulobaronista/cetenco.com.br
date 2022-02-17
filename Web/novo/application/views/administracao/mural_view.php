<div id="subHeader">
	<div id="subHeaderLeft">
		<img src="<?=base_url()?>template/img/photo_64.png" />
		<h1>Mural - <?=($this->uri->segment(3) == 'realizadas' ? 'Obras Realizadas' : 'Obras Em Andamento')?></h1>
	</div>
	<div id="subHeaderRight">
	</div>
</div>
<div class="clr"></div>
<div id="content">
	<p>
		<strong>Ver:</strong> <a href="<?=site_url('administracao/mural/realizadas')?>">Obras Realizadas</a> | <a href="<?=site_url('administracao/mural/em_andamento')?>">Obras em Andamento</a>
	</p>
	<div id="mural">
		<?php if($obras != 0): ?>
		<!-- This is 'layer1_img' -->
		<div id="Layer-<?=$layer_ids[0]?>"  >
			<img src="<?=base_url().(isset($mural[0])?'images/mural/thumbs/'.$mural[0]->miniatura:'includes/dull.gif');?>" width="230" height="70" alt="layer1" class="pngimg" />
		</div>

		<!-- This is 'layer2_img' -->
		<div id="Layer-<?=$layer_ids[1]?>"  >
			<img src="<?=base_url().(isset($mural[1])?'images/mural/thumbs/'.$mural[1]->miniatura:'includes/dull.gif');?>" width="115" height="68" alt="layer2" class="pngimg" />
		</div>

		<!-- This is 'layer3_img' -->
		<div id="Layer-<?=$layer_ids[2]?>"  >
			<img src="<?=base_url().(isset($mural[2])?'images/mural/thumbs/'.$mural[2]->miniatura:'includes/dull.gif');?>" width="112" height="140" alt="layer3" class="pngimg" />
		</div>

		<!-- This is 'layer4_img' -->
		<div id="Layer-<?=$layer_ids[3]?>"  >
			<img src="<?=base_url().(isset($mural[3])?'images/mural/thumbs/'.$mural[3]->miniatura:'includes/dull.gif');?>" width="114" height="70" alt="layer4" class="pngimg" />
		</div>

		<!-- This is 'layer5_img' -->
		<div id="Layer-<?=$layer_ids[4]?>"  >
			<img src="<?=base_url().(isset($mural[4])?'images/mural/thumbs/'.$mural[4]->miniatura:'includes/dull.gif');?>" width="114" height="139" alt="layer5" class="pngimg" />
		</div>

		<!-- This is 'layer6_img' -->
		<div id="Layer-<?=$layer_ids[5]?>"  >
			<img src="<?=base_url().(isset($mural[5])?'images/mural/thumbs/'.$mural[5]->miniatura:'includes/dull.gif');?>" width="114" height="142" alt="layer6" class="pngimg" />
		</div>

		<!-- This is 'layer7_img' -->
		<div id="Layer-<?=$layer_ids[6]?>"  >
			<img src="<?=base_url().(isset($mural[6])?'images/mural/thumbs/'.$mural[6]->miniatura:'includes/dull.gif');?>" width="114" height="68" alt="layer7" class="pngimg" />
		</div>

		<!-- This is 'layer8_img' -->
		<div id="Layer-<?=$layer_ids[7]?>"  >
			<img src="<?=base_url().(isset($mural[7])?'images/mural/thumbs/'.$mural[7]->miniatura:'includes/dull.gif');?>" width="114" height="70" alt="layer8" class="pngimg" />
		</div>

		<!-- This is 'layer9_img' -->
		<div id="Layer-<?=$layer_ids[8]?>"  >
			<img src="<?=base_url().(isset($mural[8])?'images/mural/thumbs/'.$mural[8]->miniatura:'includes/dull.gif');?>" width="114" height="70" alt="layer9" class="pngimg" />
		</div>

		<!-- This is 'layer10_img' -->
		<div id="Layer-<?=$layer_ids[9]?>"  >
			<img src="<?=base_url().(isset($mural[9])?'images/mural/thumbs/'.$mural[9]->miniatura:'includes/dull.gif');?>" width="114" height="68" alt="layer10" class="pngimg" />
		</div>

		<!-- This is 'layer11_img' -->
		<div id="Layer-<?=$layer_ids[10]?>"  >
			<img src="<?=base_url().(isset($mural[10])?'images/mural/thumbs/'.$mural[10]->miniatura:'includes/dull.gif');?>" width="112" height="70" alt="layer11" class="pngimg" />
		</div>
		<?php else: ?>
		<div id="dialog-message" title="Atenção">
			<p>
				<span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 50px 0;"></span>
				Você não possui nenhuma obra cadastrada.
			</p>
			<p>
				Para que você possa utilizar o <b>Mural de Obras</b>, você precisa cadastrar uma obra.
			</p>
		</div>
		<?php endif; ?>
	</div>

</div>
<script type="text/javascript" charset="utf-8">
	$(function(){
		$("#mural").position({my: 'center top', at: 'center top', of: $("#content")});
		
		$.lazy({
			src: '<?=base_url()?>includes/js/jquery.colorbox-min.js',
			name: 'colorbox',
			dependencies: {
				css: ['<?=base_url()?>includes/css/colorbox/colorbox.css']
			},
			cache: true
		});

		$("#mural div").click(function(){
			obj = $(this);
			id = obj.attr('id').match(/[0-9]+/g);
			$.colorbox({
				href: '<?=site_url('administracao/mural/editar')?>/' + id,
				width: 850,
				height: 800
			})
		});

		$("#dialog-message").dialog({
			modal: true,
			resizable: false,
			buttons: {
				Ok: function() {
					location.replace('<?=site_url('administracao/obras')?>');
				}
			},
			close: function(event, ui){
				location.replace('<?=site_url('administracao/obras')?>');
			}
		});

	});
</script>