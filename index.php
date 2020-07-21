<?php
session_name("SEEDQUEST");
session_start();

require('config.inc.php');

function redirect($url) {
	global $baseUrl;
	$to = $baseUrl . 'index.php' . ($url !== '/' ? '/' . $url : '');

	if (!empty($_POST['ajax']))
		die(json_encode(array(['redirect', $to])));

	header("Location: $to");
	die;
}
function ensureCSRF() {
	// TODO: $_SESSION['csrf'] sometimes not set
	if (!empty($_POST) && (!isset($_POST['_csrf']) || !hash_equals($_POST['_csrf'], $_SESSION['csrf']))) {
		$_POST = [];
	}
}

function component($name, $args = []) {
	global $baseUrl;
	ob_start();
	extract($args, EXTR_SKIP);
	require('components/'.$name.'.inc.php');
	return ob_get_clean();
}


$baseUrl = substr($_SERVER['SCRIPT_NAME'], 0, stripos($_SERVER['SCRIPT_NAME'], 'index.php'));

$pages = ['encode', 'worlds', 'world', 'done'];
$page = substr($_SERVER['PATH_INFO'], 1);
if (!in_array($page, $pages))
	$page = 'index';

if (!empty($_POST) && file_exists('handlers/'.$page.'.inc.php')) {
	require('handlers/'.$page.'.inc.php');
	if (!empty($_POST['ajax']))
		die(json_encode([]));
}

ob_start();
require('pages/'.$page.'.inc.php');
$body = ob_get_clean();
require('pages/template.inc.php');
die();
?>
