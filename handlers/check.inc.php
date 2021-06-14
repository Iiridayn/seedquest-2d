<?php
if (empty($_SESSION['decode']))
	redirect('followup');

$db_file = __DIR__ . "/../check.csv";
$write_header = !file_exists($db_file) || !filesize($db_file);
$f = fopen($db_file, 'a');
if ($write_header) {
	fputcsv($f, array(
		"MTurk Id", "Return Time", "Recall Time",
		"IP", "Recalled",
	));
}
fputcsv($f, array(
	$_SESSION['decode'], $_SESSION['returned'], date("Y-m-d H:i:s"),
	$_SERVER['REMOTE_ADDR'], $_POST['assigned']),
);
fclose($f);

redirect('instructions');
