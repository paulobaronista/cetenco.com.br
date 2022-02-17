<?php

if(!function_exists('url_title'))
{
    function url_title($str, $separator = 'dash', $lowercase = FALSE)
    {
        $charset = config_item('charset');
		switch ($separator) {
			case 'underscore':
				$separator='_';
			break;
			case 'none':
				$separator='';
			break;
			default:
				$separator='-';
			break;
		}

        $str = htmlentities($str, ENT_COMPAT, $charset);
        $str = preg_replace('/&(.)(acute|cedil|circ|lig|grave|ring|tilde|uml);/', "$1", $str);
        $str = preg_replace('/([^a-zA-Z0-9]+)/', $separator, html_entity_decode($str, ENT_COMPAT, $charset));
        $str = trim($str, $separator);
		if ($lowercase === TRUE) $str = strtolower($str);
		
        return $str;
    }
}  