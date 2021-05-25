<?php

if ($_POST['encode'] != empty($_SESSION['decode']))
	return; // no credit if they used the wrong mode

if (empty($_SESSION['payment'])) {
	require_once('lib/bip39.php');
	$dict = file('lib/english.txt', FILE_IGNORE_NEW_LINES);
	list($code, $rand) = encode($dict, 2);
	$_SESSION['payment'] = $code;
}

$f = fopen(__DIR__ . "/../credit.csv", 'a');
fputcsv($f, array(date("Y-m-d H:i:s"), $_SESSION['username'], $_POST['words'] ?? null, isset($_SESSION['registered']) ? 0 : 1, $_SESSION['payment']));
fclose($f);

$_SESSION['words-input'] = $_POST['words'];
