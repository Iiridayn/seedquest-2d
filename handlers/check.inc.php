<?php
if (empty($_SESSION['decode']))
	redirect('followup');

$f = fopen(__DIR__ . "/../return.csv", 'a');
fputcsv($f, array($_SESSION['decode'], date("Y-m-d H:i:s"), (int) !empty($_POST['complete']), $_POST['assigned']));
fclose($f);

if (empty($_POST['complete']))
	redirect('instructions');
else
	redirect('register'); // TODO: survey
