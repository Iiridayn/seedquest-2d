<?php

requireCSRF(); // So refreshing doesn't add more to the list

if (empty($_POST['recovered'])) {
	if (!empty($_POST['ajax']))
		die(json_encode([['style', '#required', 'color', 'red']]));
	return;
}

// Don't bother checking if in list; if not just manually set to "prefer not to answer" or drop the subject
$f = fopen(__DIR__ . "/../outro.csv", 'a');
fputcsv($f, array(
	date("Y-m-d H:i:s"),
	$_SESSION['username'], $_POST['recovered'],
	$_POST['gender'], $_POST['age'],
	$_POST['education'], $_POST['occupation'],
	$_POST['sus1'] ?? null, $_POST['sus2'] ?? null, $_POST['sus3'] ?? null,
	$_POST['sus4'] ?? null, $_POST['sus5'] ?? null, $_POST['sus6'] ?? null,
	$_POST['sus7'] ?? null, $_POST['sus8'] ?? null, $_POST['sus9'] ?? null,
	$_POST['sus10'] ?? null,
	$_SESSION['payment'], $_SESSION['words-input'],
));
fclose($f);

redirect('code');
?>
