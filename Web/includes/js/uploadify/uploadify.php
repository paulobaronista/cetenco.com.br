<?php

//include('upgradePhp.php');

/*
 * String Sanitization
 */

function friendly_url($url) {
	// everything to lower and no spaces begin or end
	$url = strtolower(trim($url));

	//replace accent characters, depends your language is needed
	//$url=replace_accents($url);

	// decode html maybe needed if there's html I normally don't use this
	//$url = html_entity_decode($url,ENT_QUOTES,'UTF8');

	// adding - for spaces and union characters
	$find = array(' ', '&', '\r\n', '\n', '+',',');
	$url = str_replace ($find, '-', $url);

	//delete and replace rest of special chars
	$find = array('/[^a-z0-9\-_<>]/', '/[\-]+/', '/<[^>]*>/');
	$repl = array('', '-', '');
	$url = preg_replace ($find, $repl, $url);

	//return the friendly url
	return $url;
}

function fix_enconding($string) {
	if (mb_check_encoding($string, 'UTF-8')) 
		return $string;
	else
		return mb_convert_encoding($string, 'UTF-8');
}

function replace_accents($var){ //replace for accents catalan spanish and more
    $a = array('À', 'Á', 'Â', 'Ã', 'Ä', 'Å', 'Æ', 'Ç', 'È', 'É', 'Ê', 'Ë', 'Ì', 'Í', 'Î', 'Ï', 'Ð', 'Ñ', 'Ò', 'Ó', 'Ô', 'Õ', 'Ö', 'Ø', 'Ù', 'Ú', 'Û', 'Ü', 'Ý', 'ß', 'à', 'á', 'â', 'ã', 'ä', 'å', 'æ', 'ç', 'è', 'é', 'ê', 'ë', 'ì', 'í', 'î', 'ï', 'ñ', 'ò', 'ó', 'ô', 'õ', 'ö', 'ø', 'ù', 'ú', 'û', 'ü', 'ý', 'ÿ', 'Ā', 'ā', 'Ă', 'ă', 'Ą', 'ą', 'Ć', 'ć', 'Ĉ', 'ĉ', 'Ċ', 'ċ', 'Č', 'č', 'Ď', 'ď', 'Đ', 'đ', 'Ē', 'ē', 'Ĕ', 'ĕ', 'Ė', 'ė', 'Ę', 'ę', 'Ě', 'ě', 'Ĝ', 'ĝ', 'Ğ', 'ğ', 'Ġ', 'ġ', 'Ģ', 'ģ', 'Ĥ', 'ĥ', 'Ħ', 'ħ', 'Ĩ', 'ĩ', 'Ī', 'ī', 'Ĭ', 'ĭ', 'Į', 'į', 'İ', 'ı', 'Ĳ', 'ĳ', 'Ĵ', 'ĵ', 'Ķ', 'ķ', 'Ĺ', 'ĺ', 'Ļ', 'ļ', 'Ľ', 'ľ', 'Ŀ', 'ŀ', 'Ł', 'ł', 'Ń', 'ń', 'Ņ', 'ņ', 'Ň', 'ň', 'ŉ', 'Ō', 'ō', 'Ŏ', 'ŏ', 'Ő', 'ő', 'Œ', 'œ', 'Ŕ', 'ŕ', 'Ŗ', 'ŗ', 'Ř', 'ř', 'Ś', 'ś', 'Ŝ', 'ŝ', 'Ş', 'ş', 'Š', 'š', 'Ţ', 'ţ', 'Ť', 'ť', 'Ŧ', 'ŧ', 'Ũ', 'ũ', 'Ū', 'ū', 'Ŭ', 'ŭ', 'Ů', 'ů', 'Ű', 'ű', 'Ų', 'ų', 'Ŵ', 'ŵ', 'Ŷ', 'ŷ', 'Ÿ', 'Ź', 'ź', 'Ż', 'ż', 'Ž', 'ž', 'ſ', 'ƒ', 'Ơ', 'ơ', 'Ư', 'ư', 'Ǎ', 'ǎ', 'Ǐ', 'ǐ', 'Ǒ', 'ǒ', 'Ǔ', 'ǔ', 'Ǖ', 'ǖ', 'Ǘ', 'ǘ', 'Ǚ', 'ǚ', 'Ǜ', 'ǜ', 'Ǻ', 'ǻ', 'Ǽ', 'ǽ', 'Ǿ', 'ǿ');
    $b = array('A', 'A', 'A', 'A', 'A', 'A', 'AE', 'C', 'E', 'E', 'E', 'E', 'I', 'I', 'I', 'I', 'D', 'N', 'O', 'O', 'O', 'O', 'O', 'O', 'U', 'U', 'U', 'U', 'Y', 's', 'a', 'a', 'a', 'a', 'a', 'a', 'ae', 'c', 'e', 'e', 'e', 'e', 'i', 'i', 'i', 'i', 'n', 'o', 'o', 'o', 'o', 'o', 'o', 'u', 'u', 'u', 'u', 'y', 'y', 'A', 'a', 'A', 'a', 'A', 'a', 'C', 'c', 'C', 'c', 'C', 'c', 'C', 'c', 'D', 'd', 'D', 'd', 'E', 'e', 'E', 'e', 'E', 'e', 'E', 'e', 'E', 'e', 'G', 'g', 'G', 'g', 'G', 'g', 'G', 'g', 'H', 'h', 'H', 'h', 'I', 'i', 'I', 'i', 'I', 'i', 'I', 'i', 'I', 'i', 'IJ', 'ij', 'J', 'j', 'K', 'k', 'L', 'l', 'L', 'l', 'L', 'l', 'L', 'l', 'l', 'l', 'N', 'n', 'N', 'n', 'N', 'n', 'n', 'O', 'o', 'O', 'o', 'O', 'o', 'OE', 'oe', 'R', 'r', 'R', 'r', 'R', 'r', 'S', 's', 'S', 's', 'S', 's', 'S', 's', 'T', 't', 'T', 't', 'T', 't', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'W', 'w', 'Y', 'y', 'Y', 'Z', 'z', 'Z', 'z', 'Z', 'z', 's', 'f', 'O', 'o', 'U', 'u', 'A', 'a', 'I', 'i', 'O', 'o', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'A', 'a', 'AE', 'ae', 'O', 'o');
    $var= str_replace($a, $b,$var);
    return fix_enconding($var);
}

/*
 * 	Functions taken from CI_Upload Class
 *
 */

/**
 * Sets the proper filename regarding if there's already a file with the same name
 *
 * @param string $path
 * @param string $filename
 * @param string $file_ext
 * @param boolean $encrypt_name
 * @return string
 */

function set_filename($path, $filename, $file_ext, $encrypt_name = FALSE) {
    if ($encrypt_name == TRUE) {
        mt_srand();
        $filename = md5(uniqid(mt_rand())) . $file_ext;
    }

	$filename = friendly_url(replace_accents(str_replace($file_ext, '', $filename)));

    if (!file_exists($path . $filename . $file_ext)) {
        return $filename.$file_ext;
    }

    $new_filename = '';
    for ($i = 1; $i < 100; $i++) {
        if (!file_exists($path . $filename . $i . $file_ext)) {
            $new_filename = $filename . $i . $file_ext;
            break;
        }
    }

    if ($new_filename == '') {
        return FALSE;
    } else {
        return $new_filename;
    }
}

function prep_filename($filename) {
    if (strpos($filename, '.') === FALSE) {
        return $filename;
    }
    $parts = explode('.', $filename);
    $ext = array_pop($parts);
    $filename = array_shift($parts);
    foreach ($parts as $part) {
        $filename .= '.' . friendly_url($part);
    }
    $filename .= '.' . $ext;
    return $filename;
}

function get_extension($filename) {
    $x = explode('.', $filename);
    return '.' . end($x);
}

/*
  Uploadify v2.1.0
  Release Date: August 24, 2009

  Copyright (c) 2009 Ronnie Garcia, Travis Nickels

  Permission is hereby granted, free of charge, to any person obtaining a copy
  of this software and associated documentation files (the "Software"), to deal
  in the Software without restriction, including without limitation the rights
  to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
  copies of the Software, and to permit persons to whom the Software is
  furnished to do so, subject to the following conditions:

  The above copyright notice and this permission notice shall be included in
  all copies or substantial portions of the Software.

  THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
  IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
  FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
  AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
  LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
  OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
  THE SOFTWARE.
 */
if (!empty($_FILES)) {
    $tempFile = $_FILES['Filedata']['tmp_name'];
    $targetPath = $_SERVER['DOCUMENT_ROOT'] . $_REQUEST['folder'] . DIRECTORY_SEPARATOR;
    $targetFile = str_replace('//', '/', $targetPath) . $_FILES['Filedata']['name'];
	$path = $_SERVER['DOCUMENT_ROOT'] . $_REQUEST['folder'] . DIRECTORY_SEPARATOR;
	
	$path = str_replace('/',DIRECTORY_SEPARATOR,$path);
	

    //$client_id = $_GET['client_id'];
    $file_temp = $tempFile;
    $file_name = prep_filename($_FILES['Filedata']['name']);
    $file_ext = get_extension($_FILES['Filedata']['name']);
    $real_name = $file_name;
    $newf_name = set_filename($path, $file_name, $file_ext);
    $file_size = round($_FILES['Filedata']['size']/1024, 2);
    $file_type = preg_replace("/^(.+?);.*$/", "\\1", $_FILES['Filedata']['type']);
    $file_type = strtolower($file_type);
	$targetFile = str_replace('//','/',$path) . $newf_name;
	$targetFile = str_replace('/',DIRECTORY_SEPARATOR,$targetFile);

    // $fileTypes  = str_replace('*.','',$_REQUEST['fileext']);
    // $fileTypes  = str_replace(';','|',$fileTypes);
    // $typesArray = split('\|',$fileTypes);
    // $fileParts  = pathinfo($_FILES['Filedata']['name']);
    // if (in_array($fileParts['extension'],$typesArray)) {
    // Uncomment the following line if you want to make the directory if it doesn't exist
    // mkdir(str_replace('//','/',$targetPath), 0755, true);

	if (!@copy($file_temp, $targetFile)) {
		if (!@move_uploaded_file($file_temp, $targetFile)) {
			echo "ERROR";
		}
	} else {
		$filearray = array();
		$filearray['file_name'] = $newf_name;
		$filearray['real_name'] = $real_name;
		$filearray['raw_name'] = friendly_url(replace_accents(basename($targetFile, $file_ext)));
		$filearray['file_ext'] = $file_ext;
		$filearray['file_size'] = $file_size;
		$filearray['file_path'] = $targetFile;
		$filearray['file_temp'] = $file_temp;
		$filearray['path'] = $path;

		list($filearray['width'], $filearray['height'], $filearray['type'], $filearray['attr']) = getimagesize($targetFile);

		//$filearray['client_id'] = $client_id;

		$json_array = json_encode($filearray);
		echo $json_array;
	}
} else {
    echo "ERROR";
}