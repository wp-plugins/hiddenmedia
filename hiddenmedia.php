<?php
/*
Plugin Name: HiddenMedia
Plugin URI: http://meandmymac.net/plugins/hiddenmedia/
Description: Use preset shortcodes to easily hide images and flash until you're on the single post page.
Author: Arnan de Gans
Version: 1.0
Author URI: http://meandmymac.net
*/ 

function hiddenmedia_shortcode( $atts, $content = null ) {

	$url = $atts['url'];
	$filetype = end(explode('.', basename($url)));

	if(empty($atts['width'])) $width = 320; 
		else $width = $atts['width'];
		
	if(empty($atts['height'])) $height = 240; 
		else $height = $atts['height'];
		
	if(empty($atts['loop'])) $loop = false; // Flash only
		else $loop = $atts['loop'];
		
	if(empty($atts['autoplay'])) $autoplay = false;  // Flash only
		else $autoplay = $atts['autoplay'];
		
	if(empty($atts['urltitle'])) $urltitle = 'Click here!'; 
		else $urltitle = $atts['urltitle'];
		
	$result = '';
	if(is_single() and !empty($url)) {
		if($filetype == "swf") {
			$result .= '<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" width="'.$width.'" height="'.$height.'" type="application/x-shockwave-flash" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,40,0">';
			$result .= '<param name="movie" value="'.$url.'">';
			$result .= '<param name="play" value="'.$autoplay.'">';
			$result .= '<param name="loop" value="'.$loop.'">';
			$result .= '<param name="quality" value="high">';
			$result .= '<param name="wmode" value="transparent">';
			$result .= '<embed src="'.$url.'" wmode="transparent" width="'.$width.'" height="'.$height.'" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer" play="'.$autoplay.'" loop="'.$loop.'" quality="high" wmode="transparent">';
			$result .= '</object>';
		} else if($filetype == "jpg" OR $filetype == "jpeg" OR $filetype == "png" OR $filetype == "gif" OR $filetype == "bmp" OR $filetype == "tif" OR $filetype == "ico") {
			if(!empty($width)) $imagewidth .= ' width="'.$width;
			if(!empty($height)) $imageheight .= ' height="'.$height;

			$result .= '<img src="'.$url.'"'.$imagewidth.$imageheight.' alt="HiddenMedia"/>';
		} else {
			$result .= '<span style="color:#f00; font-weight:bold;">[HiddenMedia] ERROR: No valid mime-type specified or mime-type could not be determined. Check your syntax and/or filename!</span>';
		}
	} else if(empty($url)) {
		$result .= '<span style="color:#f00; font-weight:bold;">[HiddenMedia] ERROR: No url specified. Check your syntax!</span>';
	} else {
		$result .= '<a href="'.get_permalink().'" title="'.$urltitle.'">'.$urltitle.'</a>';
	}

	return $result;
}

add_shortcode('hiddenmedia', 'hiddenmedia_shortcode');
?>