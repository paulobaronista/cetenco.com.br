<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
	<head>
		<title>CETENCO - <?=$this->session->userdata('page_title')?></title>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<link type="text/css" href="<?=base_url()?>template/css/adminStyle.css" rel="stylesheet"  media="screen" charset="utf-8" />
		<link type="text/css" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.2/themes/redmond/jquery-ui.css" rel="Stylesheet" />
		<link type="text/css" href="<?=base_url()?>includes/css/jcrop/jquery.Jcrop.css" rel="Stylesheet" />
		<link type="text/css" href="<?=base_url()?>template/css/menu/menu.css" rel="Stylesheet" />
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
		<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.2/jquery-ui.min.js"></script>
		<script src="<?=base_url()?>includes/js/swfobject.js"></script>
		<script src="<?=base_url()?>includes/js/jquery.cookie.js"></script>
		<script src="<?=base_url()?>includes/js/jquery.lazy.js"></script>
		<script src="<?=base_url()?>includes/js/jquery.easing.1.3.js"></script>
		<script src="<?=base_url()?>includes/js/jquery.onImagesLoad.min.js"></script>
		<!--[if lt IE 7]>
		<script src="<?=base_url()?>includes/js/jquery.DD_belatedPNG_0.0.8a-min.js"></script>
		<script>
			DD_belatedPNG.fix('#wrapper, #cboxMiddleLeft, #cboxMiddleRight, #cboxTopLeft, #cboxTopCenter, #cboxTopRight');
		</script>
		<![endif]-->
	</head>
	<body>
		<div id="wrapper">
			<?php if($this->uri->segment(2) != 'access'):?>
			<div id="header">
				<div id="logo">
					<img src="<?=base_url()?>template/img/logo.png" />
				</div>
				<div id="rightBlock">
					<?php 
						echo form_open('administracao/site/idioma',Array('id'=>'idioma'));
						echo form_label('Idioma do conteúdo ', 'idioma');
						echo form_dropdown('idioma', Array('br'=>'Português', 'es'=>'Espanhol', 'en'=>'Inglês'), $this->session->userdata('idioma'));
						echo form_hidden('referrer', current_url());
						echo form_close();
					?>
				</div>
				<div class="cls"></div>
				<h1>ADMINISTRAÇÃO</h1>
			</div>
			<div class="clr"></div>
			<div id="menuWrap">
				<div class="menu">
					<ul><?php foreach ($menu as $menu_item) echo $menu_item ?></ul>
				</div>
			</div>
			<div id="body">
			<?php endif; ?>