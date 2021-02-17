<?php
session_start();

if (!isset($_SESSION['referer'])) {
	$_SESSION['referer'] = $_SERVER["HTTP_REFERER"];
}
if ($_SESSION['referer']) {
	$origin = str_replace(['https://', '.', '/'], ['', '_', ''], $_SESSION['referer']);
	// echo '<!-- ORIGEM: ' . $origin . ' -->';
	$bankcss = $SERVER["HTTP_REFERER"] . 'wl/css/custom' . $origin . '.css';
	// echo '<!-- ' . $bankcss . ' -->';
}

/*<link rel="stylesheet" href="<?= $bankcss; ?>"> */

?>