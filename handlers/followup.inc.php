<?php

if (empty($_POST['username']))
	return;

$f = fopen(__DIR__ . '/../register.csv', 'r');
$record = null;
while (($data = fgetcsv($f)) !== false) {
	if ($data[0] === $_POST['username']) {
		$record = $data;
		break;
	}
}

if (empty($record))
	return;

$mode = (int) $record[2];
if ($mode === 1)
	$_SESSION['ordered'] = true;
else if ($mode === 2)
	$_SESSION['ordered'] = false;

$words = $record[3];

$_SESSION['username'] = $_POST['username'];
$_SESSION['decode'] = $data[0];
$_SESSION['registered'] = compact('mode', 'words');
$_SESSION['returned'] = date("Y-m-d H:i:s");

redirect('check');
