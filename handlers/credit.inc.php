<?php

if (!isset($_POST['encode']))
	return;

// no credit if they used the wrong mode
if ($_POST['encode'] == empty($_SESSION['decode']) && !isset($_SESSION['payment'])) {
	// Hex, to minimize possible conflict w/assigned string passphrase
	$_SESSION['payment'] = bin2hex(random_bytes(3)); // 24 bits, 4 9's odds of no collision for 300 participants
	$_SESSION['words-input'] = $_POST['words'];
}

$db_file = __DIR__ . "/../credit.csv";
$write_header = !file_exists($db_file) || !filesize($db_file);
// log completion either way though
$f = fopen($db_file, 'a');
if ($write_header) {
	fputcsv($f, array(
		"MTurk Id", "Finished", "Passphrase",
		"Followup", "Decode", "Code",
	));
}
fputcsv($f, array(
	$_SESSION['username'], date("Y-m-d H:i:s"), $_POST['words'] ?? null,
	isset($_SESSION['decode']) ? 1 : 0, $_POST['encode'] ? 0 : 1, $_SESSION['payment'] ?? null
));
fclose($f);
