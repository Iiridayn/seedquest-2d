<?php

if ($_POST['encode'] != empty($_SESSION['decode']))
	return; // no credit if they used the wrong mode

if (!isset($_SESSION['payment'])) {
	// Hex, to minimize possible conflict w/assigned string passphrase
	$_SESSION['payment'] = bin2hex(random_bytes(3)); // 24 bits, 4 9's odds of no collision for 300 participants
}

$f = fopen(__DIR__ . "/../credit.csv", 'a');
fputcsv($f, array(date("Y-m-d H:i:s"), $_SESSION['username'], $_POST['words'] ?? null, isset($_SESSION['registered']) ? 0 : 1, $_SESSION['payment']));
fclose($f);

$_SESSION['words-input'] = $_POST['words'];
