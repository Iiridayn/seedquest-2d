<?php

ini_set('display_errors', 1);
error_reporting(E_ALL | E_STRICT);
require('lib/bip39.php');
require('config.inc.php');

$f = fopen('php://stdin', 'r');
$line = fgets($f);
fclose($f);

$dict = file('lib/english.txt', FILE_IGNORE_NEW_LINES);

//echo "Bytes: " . bin2hex(decode(trim($line), $dict)) . "\n";

$bytes = decode(trim($line), $dict);
if ($bytes === false) {
	echo "Decoding error\n";
	exit(1);
}

echo "Bytes: " . bin2hex($bytes) . "\n";

$bit = 0;
for ($i = 0; $i < WORLDS; $i++) {
	// 4 bits select a scene
	$scene = getbits($bytes, $bit, 4);
	$bit += 4;
	echo "$scene\t" . $map[$scene]['name'] . "\n";

	for ($j = 0; $j < ITEMS; $j++) {
		$interactible = getbits($bytes, $bit, 4);
		$option = getbits($bytes, $bit + 4, 2);
		$item = $map[$scene]['items'][$interactible];
		echo "$scene-$interactible-$option\t" . $item['name'] . ":\t" . $item['options'][$option] . "\n";
		$bit += 6;
	}
}
