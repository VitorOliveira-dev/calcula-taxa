<?php
session_start();

if (!isset($_SESSION['referer'])) {
	$_SESSION['referer'] = $_SERVER["HTTP_REFERER"];
}
if ($_SESSION['referer'] && stristr($_SESSION['referer'], 'bank') === TRUE) {
	$origin = str_replace(['https://', '.', '/'], ['', '_', ''], $_SESSION['referer']);

	// echo '<!-- ORIGEM: ' . $origin . ' -->';
	$bankcss = $SERVER["HTTP_REFERER"] . 'wl/css/custom' . $origin . '.css';
	// echo '<!-- ' . $bankcss . ' -->';
}else{
	$bankcss = 'css/stylebkp.css';
}

/*<link rel="stylesheet" href="<?= $bankcss; ?>"> */

?>
