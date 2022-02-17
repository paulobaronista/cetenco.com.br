<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="title" content="" />
<meta name="description" content="" />
<meta name="keywords" content="" />
<meta name="language" content="pt-br" />
<meta name="author" content="www.spicyweb.com.br" />
<meta name="copyright" content="www.spicyweb.com.br" />
<meta name="robots" content="ALL" />
<meta name="document-classification" content="ong" />
<meta name="document-rating" content="General" />
<title>CETENCO<?=(isset($page_title)?' - '.$page_title:'')?></title>

<link rel="shortcut icon" href="<?= base_url() ?>includes/img/favicon.ico" type="image/x-icon" />
<script type="text/javascript" src="<?= base_url() ?>includes/js/swfobject.js"></script>

<!-- CSS -->
<link rel="stylesheet" href="<?= base_url() ?>includes/css/cetenco.css" type="text/css" />
<!--CSS jQuery UI-->
<link type="text/css" href="<?= base_url() ?>template/css/smoothness/jquery-ui-1.8.4.custom.css" rel="Stylesheet" />
<!--CSS Fancybox-->
<link rel="stylesheet" href="<?= base_url() ?>includes/css/jquery.fancybox-1.3.1.css" type="text/css" media="screen" />
<!--CSS jCarousel-->
<link rel="stylesheet" href="<?= base_url() ?>includes/css/jcarousel/skins/tango/skin.css" type="text/css" media="screen" />
<!--CSS Content Slider-->
<link rel="stylesheet" href="<?= base_url() ?>includes/css/jquery.content_slider.css" type="text/css" media="screen" />


<!-- JS JQuery -->
<script src="<?=base_url()?>includes/js/jquery-1.4.2.min.js"></script>
<!--JS jQuery UI-->
<script src="<?=base_url()?>includes/js/jquery-ui-1.8.2.custom.min.js"></script>
<!--JS Fancybox-->
<script src="<?= base_url() ?>includes/js/jquery.fancybox-1.3.1.pack.js"></script>
<!--JS jCarousel-->
<script src="<?= base_url() ?>includes/js/jquery.jcarousel.js"></script>
<!--JS ScrollTo-->
<script src="<?= base_url() ?>includes/js/jquery.scrollTo-1.4.2-min.js"></script>
<!--JS LocalScroll-->
<script src="<?= base_url() ?>includes/js/jquery.localscroll-1.2.7-min.js"></script>
<!--JS doTimeout-->
<script src="<?= base_url() ?>includes/js/jquery.ba-dotimeout.min.js"></script>


<!-- IE6 PNG Hack e Whatever:Hover Fix -->
    <!--[if IE 6]>
    <script src="<?=base_url() ?>includes/js/DD_belatedPNG.js"></script>

    <script>
      DD_belatedPNG.fix('.pngimg, #legenda');
    </script>

    <style type="text/css">
    body { behavior: url("<?= base_url() ?>includes/js/csshover3.htc"); }
    </style>

    <![endif]-->
</head>

<body>
	<div id="outter-wrap">
		<div id="bg">
    		<img src="<?= base_url() ?>includes/img/bg.png" width="100%" height="100%" class="pngimg" />
    	</div>


        <div id="wrapper">
        	<div id="top">
            	<h1><a href="<?=site_url()?>">Cetenco</a></h1>

                <div id="tools">
					<?php
						// Carrega as opções de idiomas
						$idiomas = $this->config->item('idiomas');
						$lang_code = substr($this->uri->segment(1), 0, 2);

						// Itera sobre os idiomas disponíveis e monta os links de mudança de idioma
						foreach($idiomas as $code => $text) {
							if(strlen(uri_string()) == 3 && $lang_code == $code) {
								$lang_links[$code] = site_url(uri_string());
							} else {
								if ($lang_code != ''){
									$lang_links[$code] = site_url(str_replace($lang_code, $code, uri_string()));
								} else {
									$lang_links[$code] = site_url($code .'/'. uri_string());
								}
							}
						}

					?>
                	<ul id="lang">
						<?php foreach($idiomas as $code => $text): ?>
							<li class="<?=$code?>"><a href="<?=$this->lang->switch_uri($code, 'site_idioma')?>"><?=$text?></a></li>
						<?php endforeach; ?>
                    </ul>

                   <p class="mapa"><a href="<?=site_url('mapa-do-site')?>"><?=lang('menu_sitemap')?></a></p>

                	<form action="<?=site_url('busca')?>" method="post">
                    	<input type="text" class="txt" name="busca" />
                        <input type="submit" value="Pesquisar" class="btn" />
                    </form>

                </div>

                <div id="menu">
				<a href="<?=site_url()?>"><?=mb_strtoupper(lang('menu_home'),'UTF-8')?></a> | <a href="<?=site_url('cetenco')?>"><?=mb_strtoupper(lang('menu_company'),'UTF-8')?></a> | <a href="<?=site_url('obras/realizadas')?>"><?=mb_strtoupper(lang('menu_obras_realizadas'),'UTF-8')?></a> | <a href="<?=site_url('obras/em-andamento')?>"><?=mb_strtoupper(lang('menu_obras_em_andamento'),'UTF-8')?></a> | <a href="<?=site_url('area-restrita')?>"><?=mb_strtoupper(lang('menu_area_restrita'),'UTF-8')?></a> | <a href="<?=site_url('contato/trabalhe-conosco')?>"><?=mb_strtoupper(lang('menu_trabalhe_conosco'),'UTF-8')?></a> | <a href="<?=site_url('contato')?>"><?=mb_strtoupper(lang('menu_contato'),'UTF-8')?></a></div>


            </div>


            <div id="content">