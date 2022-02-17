<h2 class="principal"><?=lang('menu_sitemap')?></h2>
<ul class="formatada">
	<li><a href="<?=site_url()?>"><?=lang('home')?></a></li>
	<li><a href="<?=site_url('cetenco')?>"><?=lang('company')?></a></li>
	<li><?=lang('obras')?></li>
	<ul class="formatada">
		<li><a href="<?=site_url('obras/realizadas')?>"><?=lang('obras.realizadas')?></a></li>
		<li><a href="<?=site_url('obras/em_andamento')?>"><?=lang('obras.em_andamento')?></a></li>
	</ul>
	<!-- <li><a href="<?#=site_url('certificacoes')?>"><?#=lang('certificacoes')?></a></li> -->
	<li><?=lang('contato')?></li>
	<ul class="formatada">
		<li><a href="<?=site_url('contato')?>"><?=lang('contato.geral')?></a></li>
	
		<li><a href="<?=site_url('contato/trabalhe-conosco')?>"><?=lang('contato.trabalhe_conosco')?></a></li>

	</ul>
</ul>
