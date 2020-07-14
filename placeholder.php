<?php
// I wrote this file, and license it under WTFPL, CC0, or MIT, your choice
$width = 100;
$height = 100;
if (isset($_GET['w']) && $_GET['w'] > 0) {
	$width = $_GET['w'];
	$height = $width;
}
if (isset($_GET['h']) && $_GET['h'] > 0) {
	$height = $_GET['h'];
}

$im = imagecreate($width, $height);

$bg = imagecolorallocate($im, 255, 255, 255);

$color = imagecolorallocate($im, 0, 0, 0);

imageline($im, 0, 0, $width, $height, $color);
imageline($im, $width, 0, 0, $height, $color);
imagerectangle($im, 0, 0, $width - 1, $height - 1, $color);

$text = isset($_GET['txt']) && $_GET['txt'] !== '' ? $_GET['txt'] : "${width}x$height";
$size = min(20, $width / 6);
$font = "/usr/share/fonts/TTF/Roboto-Medium.ttf";

$box = imagettfbbox($size, 0, $font, $text);
$midx = ($width - $box[4])/2;
$midy = ($height - $box[5])/2;
imagefilledrectangle($im, $midx, $midy, $midx + $box[4], $midy + $box[5], $bg);
imagettftext($im, $size, 0, $midx, $midy, $color, $font, $text);

header("Content-Type: image/png");
imagepng($im);
imagedestroy($im);
