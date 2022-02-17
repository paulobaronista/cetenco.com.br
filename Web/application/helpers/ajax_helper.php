<?php
/**
 * Verifica se o post foi feito via ajax
 * @return boolean
 */
function is_ajax() 
{
	return (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && ($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest'));
}
