<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

function buildMenu($active = 'timeline', $text = FALSE) {
	$menu = Array(
		'timeline'			=>	'<li>' . anchor('administracao', 'Linha do tempo') . '</li>',
//		'textos'		=>	'<li>' . anchor('administracao/textos', 'Textos') . '</li>',
		'destaques'		=>	'<li>' . anchor('administracao/destaques', 'Destaques') . '</li>',
		'obras'			=>	'<li>' . anchor('administracao/obras', 'Obras') . '</li>',
		'mural'			=>	'<li>' . anchor('administracao/mural', 'Mural de Obras') . '</li>',
//		'certificacoes'	=>	'<li>' . anchor('administracao/certificacoes', 'Certificações') . '</li>',
		'curriculos'	=>	'<li>' . anchor('administracao/curriculos', 'Currículos') . '</li>',
		'arquivos'		=>	'<li>' . anchor('administracao/arquivos', 'Arquivos') . '</li>',
		'categorias'	=>	'<li>' . anchor('administracao/categorias', 'Categorias') . '</li>',
		'tipos'			=>	'<li>' . anchor('administracao/tipos', 'Tipos') . '</li>',
		'usuarios'		=>	'<li>' . anchor('administracao/usuarios', 'Usuários') . '</li>',
		'sair'			=>	'<li>' . anchor('administracao/access/logout', 'Sair') . '</li>'
	);
	
	$menu[$active] = '<li>' . anchor('administracao/'.strtolower($active), (!$text ? ucfirst($active) : $text), Array('class'=>'current')) . '</li>';

	return $menu;
}