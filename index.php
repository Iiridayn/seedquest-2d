<?php
session_name("SEEDQUEST");
session_start();

if (php_sapi_name() == 'cli-server') {
	ini_set('display_errors', 1);
	error_reporting(E_ALL | E_STRICT);
}

require('config.inc.php');

function redirect($url) {
	global $baseUrl;
	$to = $baseUrl . 'index.php' . ($url !== '/' ? '/' . $url : '');

	if (!empty($_POST['ajax']))
		die(json_encode(array(['redirect', $to])));

	header("Location: $to");
	die;
}

function makeCSRF() {
	$_SESSION['csrf'] = bin2hex(random_bytes(32));
	return '<input type="hidden" name="_csrf" value="' . $_SESSION['csrf'] . '" />';
}
function requireCSRF() {
	if (!empty($_POST) && (!isset($_POST['_csrf']) || !hash_equals($_POST['_csrf'], $_SESSION['csrf']))) {
		$_POST = [];
	}
}

function restart() {
	$clear = ['worlds', 'world', 'choices', 'preview', 'worlds', 'seed'];
	foreach ($clear as $key)
		unset($_SESSION[$key]);
	redirect("/");
}

function component($name, $args = []) {
	global $baseUrl;
	ob_start();
	extract($args, EXTR_SKIP);
	require('components/'.$name.'.inc.php');
	return ob_get_clean();
}

// Current best place for this; should probably move elsewhere later
function itemFilename($world, $which) {
	$mode = 'd';
	// change image to show last selected state
	// like SeedQuest 3d, remember _any_ previous visit to the scene
	foreach ($_SESSION['choices'] as $k => $v) {
		if ($_SESSION['worlds'][(int) floor($k / ITEMS)] !== $world)
			continue;
		if ($v[0] == $which)
			$mode = $v[1];
	}
	return $world . '-' . $which . '-' . $mode . '.png';
}


$baseUrl = substr($_SERVER['SCRIPT_NAME'], 0, stripos($_SERVER['SCRIPT_NAME'], 'index.php'));

// NOTE - all handlers need a page
$files = scandir('pages');
$pages = [];
foreach ($files as $file) {
	if (substr($file, -8) === '.inc.php')
		$pages []= substr($file, 0, -8);
}

$path = isset($_SERVER['PATH_INFO']) ? explode('/', substr($_SERVER['PATH_INFO'], 1)) : [];
$page = $path[0] ?? 'index';
if (!in_array($page, $pages)) // could merge w/the foreach above; premature optimization?
	$page = 'index';

if (!isset($_SESSION['registered']) && $page !== 'followup')
	$page = 'register';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && file_exists('handlers/'.$page.'.inc.php')) {
	require('handlers/'.$page.'.inc.php');
	if (!empty($_POST['ajax']))
		die(json_encode([]));
}

ob_start();
require('pages/'.$page.'.inc.php');
die(component('template', array('body' => ob_get_clean())));
?>
