<?php

// Refresh doesn't add more to the list
ensureCSRF();

if (isset($_POST['world'])) {
	$save = count($_SESSION['worlds']) < WORLDS && (
		!isset($_SESSION['seed']) ||
		$_SESSION['seed']['worlds'][count($_SESSION['worlds'])] == $_POST['world']
	);
	if ($save)
		$_SESSION['worlds'][] = $_POST['world'];
}

if (isset($_POST['undo'])) {
	array_pop($_SESSION['worlds']);
}

if (isset($_POST['back'])) {
	unset($_SESSION['worlds']);

	if (isset($_SESSION['seed'])) {
		unset($_SESSION['seed']);
		redirect('encode');
	}
	redirect('/');
}
