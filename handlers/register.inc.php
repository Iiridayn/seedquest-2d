<?php

if (empty($_POST['username']))
	return false;

require('lib/bip39.php');
$dict = file('lib/english.txt', FILE_IGNORE_NEW_LINES);
list($words, $rand) = encode($dict, WORDS);

$mode = random_int(0, 2);
if ($env['testing'] && isset($_GET['mode']) && in_array($_GET['mode'], [0,1,2]))
	$mode = (int) $_GET['mode'];

if ($mode === 1)
	$_SESSION['ordered'] = true;
else if ($mode === 2)
	$_SESSION['ordered'] = false;

$db_file = __DIR__ . "/../register.csv";
$write_header = !file_exists($db_file) || !filesize($db_file);
$f = fopen($db_file, 'a');
if ($write_header) {
	fputcsv($f, array(
		"MTurk Id", "Registered", "Mode", "Passphrase", "Entropy", "IP",
		"User Agent", "JS Enabled",
	));
}
fputcsv($f, array(
	$_POST['username'], date("Y-m-d H:i:s"), $mode, $words, bin2hex($rand), $_SERVER['REMOTE_ADDR'],
	$_SERVER['HTTP_USER_AGENT'], $_POST['javascript']
));
fclose($f);

$_SESSION['username'] = $_POST['username'];
$_SESSION['registered'] = compact('mode', 'words');

redirect('instructions');
