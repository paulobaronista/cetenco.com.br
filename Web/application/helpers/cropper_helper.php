<?php if (!defined('BASEPATH'))	exit('No direct script access allowed.');

/* * ***
 * Cropper is a very flexible helper that generates cropper easily but only when
 * a cropper with the same dimensions don't yet exist, making it light on server load.
 * @author     shishir raven
 * @email      shishir_raven@yahoo.com
 * @filename   cropper_healper.php
 * @title      Cropper
 * @url        http://www.cradleofweb.com/
 * @version    1.0
 * *** */

function cropper($filename, $ext = '.jpg', $path, $dx=100, $dy=100, $thumb = TRUE, $centered_crop = FALSE) {
	// Get current diimensions
	$CI = & get_instance();
	$full_path = dirname($_SERVER['SCRIPT_FILENAME']) . '/' . $path . '/' . $filename . $ext;
	$full_path = str_replace('//','\\',$full_path);
	if ($thumb) {
		$thumbpath = dirname($_SERVER['SCRIPT_FILENAME']) . '/' . $path . "/thumbs/" . $filename . "_thumb" . $ext;
	} else {
		$thumbpath = dirname($_SERVER['SCRIPT_FILENAME']) . '/' . $path . "/" . $filename . $ext;
	}
	// Finding Image size
	$img_size = getimagesize($full_path);
	$inputWidth = $img_size[0] . "px";   // get this value from upload data array
	$inputHeight = $img_size[1] . "px";  // get this value from upload data array
	//echo print_r($img_size);
	//echo "--".$inputHeight ."--";
	// Desired size
	$areaWidth = $dx; // wished output width
	$areaHeight = $dy; // wished output height
	$scale = 1;
//	$toCropLeft = ($areaWidth - ($inputWidth * $scale)) / 2;  // you have to divide it by 2 because you want to crop from the center
//	$toCropTop = ($areaHeight - ($inputHeight * $scale)) / 2;  // you have to divide it by 2 because you want to crop from the center
	if (!file_exists($thumbpath) || !$thumb) {
		/* calculate the optimal size before we crop the overlapping part */
		$x = $areaWidth / $inputWidth;
		$y = $areaHeight / $inputHeight;
		/* get what is the best side to scale */
		if ($x < $y) {
			$newWidth = round($inputWidth * ($areaHeight / $inputHeight));
			$newHeight = $areaHeight;
		} else {
			$newHeight = round($inputHeight * ($areaWidth / $inputWidth));
			$newWidth = $areaWidth;
		}
		//echo "--".$inputWidth."--";
		//echo "--".$inputHeight."--";
		//die('end');
		// Calculating the width
		$source_aspect_ratio = $inputWidth / $inputHeight;
		$desired_aspect_ratio = $dx / $dy;
		if ($source_aspect_ratio > $desired_aspect_ratio) {
			//
			// Triggered when source image is wider
			//
			$temp_height = $dy;
			$temp_width = (int) ( $dy * $source_aspect_ratio );
		} else {
			//
			// Triggered otherwise (i.e. source image is similar or taller)
			//
			$temp_width = $dx;
			$temp_height = (int) ( $dx / $source_aspect_ratio );
		}

		$toCropLeft = ($temp_width - $areaWidth) / 2;
		$toCropTop = ($temp_height - $areaHeight) / 2;
		
		///--------------------
		/* first step resize to the calculated size */
		$config['image_library'] = 'GD2';
		$config['source_image'] = $full_path;
		if ($thumb) $config['new_image'] = $thumbpath;
		$config['maintain_ratio'] = true;
		$config['width'] = $temp_width;
		$config['height'] = $temp_height;
		$config['quality'] = '100';
		$CI->load->library('image_lib', $config);
		$CI->image_lib->initialize($config);
		$CI->image_lib->resize();
		$CI->image_lib->clear();
		/* now crop the image from the center */
		$config['image_library'] = 'GD2';
		$config['source_image'] = ($thumb ? $thumbpath : $full_path);
		$config['width'] = $areaWidth;
		$config['height'] = $areaHeight;
		$config['quality'] = '100';
		$config['maintain_ratio'] = false;
		$config['x_axis'] = ($centered_crop ? $toCropLeft : 0);
		$config['y_axis'] = ($centered_crop ? $toCropTop : 0);
		$CI->image_lib->initialize($config);
		$CI->image_lib->crop();
		$CI->image_lib->clear();
	}

	if ($thumb) {
		return $path . "/thumbs/" . $filename . "_thumb" . $ext;
	} else {
		return $path . "/" . $filename . $ext;
	}
}