<?php
/**
 * @author success.ddt@gmai.com
 */
//$mb_str = mb_strtoupper($mb_str,"utf8"); 
$captcha = imagecreatefrompng('kethon.png');

$stringck = mb_strtoupper($_GET['htck'],"utf8");
$stringvk = mb_strtoupper($_GET['htvk'],"utf8");

$stringnsck = $_GET['nsck'];
$stringnsvk = $_GET['nsvk'];

$stringhkck = $_GET['hkck'];
$stringhkvk = $_GET['hkvk'];

$stringcmck = $_GET['cmck'];
$stringcmvk = $_GET['cmvk'];
$now = getdate();
$stringngay = $now["mday"];
$stringthang = $now["mon"];
$stringnam = $now["year"];


$stringktck = $_GET['ktck'];
$stringktvk = $_GET['ktvk'];
//set some variables
$black = imagecolorallocate($captcha, 225, 0, 0);
$white = imagecolorallocate($captcha, 225, 225, 225);
$red = imagecolorallocate($captcha, 0, 0, 0);
$font = 'arial.ttf';
$chuky = 'chuky.ttf';

//random stuff
//$string = md5(microtime() * mktime());
$textck = substr($stringck, 0, 25);
$textvk = substr($stringvk, 0, 25);

$textnsck = substr($stringnsck, 0, 25);
$textnsvk = substr($stringnsvk, 0, 25);

$texthkck = substr($stringhkck, 0, 25);
$texthkvk = substr($stringhkvk, 0, 25);

$textcmck = substr($stringcmck, 0, 25);
$textcmvk = substr($stringcmvk, 0, 25);

$textktck = substr($stringktck, 0, 25);
$textktvk = substr($stringktvk, 0, 25);

$textkt1ck = substr($stringck, 0, 25);
$textkt1vk = substr($stringvk, 0, 25); 

$textngay = substr($stringngay, 0, 25); 
$textthang = substr($stringthang, 0, 25); 
$textnam = substr($stringnam, 0, 25); 
//$_SESSION['code'] = $text;

//create some stupid stuff

imagettftext($captcha, 18, 0, 210, 289, $red, $font, $textck);
imagettftext($captcha, 18, 0, 620, 289, $red, $font, $textvk);

imagettftext($captcha, 12, 0, 250, 320, $red, $font, $textnsck);
imagettftext($captcha, 12, 0, 680, 320, $red, $font, $textnsvk);

imagettftext($captcha, 15, 0, 100, 406, $red, $font, $texthkck);
imagettftext($captcha, 15, 0, 520, 406, $red, $font, $texthkvk);

imagettftext($captcha, 13, 0, 270, 435, $red, $font, $textcmck);
imagettftext($captcha, 13, 0, 702, 435, $red, $font, $textcmvk);

imagettftext($captcha, 20, 0, 260, 520, $red, $chuky, $textktck);
imagettftext($captcha, 20, 0, 700, 520, $red, $chuky, $textktvk);


imagettftext($captcha, 16, 0, 230, 560, $red, $font, $textkt1ck);
imagettftext($captcha, 16, 0, 680, 560, $red, $font, $textkt1vk);

imagettftext($captcha, 11, 0, 680, 600, $red, $font, $textngay);
imagettftext($captcha, 11, 0, 750, 600, $red, $font, $textthang);
imagettftext($captcha, 11, 0, 830, 600, $red, $font, $textnam);

// begin to create image
header('content-type: image/png');
imagepng($captcha);

//clean up
imagedestroy($captcha);

?>