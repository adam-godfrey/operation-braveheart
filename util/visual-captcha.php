<?php
    require('../libs/php-captcha.inc.php');
	
	$backgrounds = array();
	for($i = 1; $i < 33; $i++) {
		array_push($backgrounds, '../libs/resources/background/' . $i . '.jpg');
	}
    $aFonts = array('../libs/resources/fonts/VeraBd.ttf', '../libs/resources/fonts/VeraIt.ttf', '../libs/resources/fonts/Vera.ttf');
    $oVisualCaptcha = new PhpCaptcha($aFonts, 200, 60);
	$oVisualCaptcha->SetBackgroundImages($backgrounds);
    $oVisualCaptcha->Create();
?>
