<?php

// Refresh doesn't add more to the list
ensureCSRF();

if (isset($_POST['reset'])) {
	session_destroy();
	redirect("/");
}

if (isset($_POST['start'])) {
	$_SESSION['preview'] = false;
}

if (isset($_POST['item'])) {
	$_SESSION['item'] = $_POST['item'];
}

if (isset($_POST['choice']) && (!isset($_SESSION['seed']) || $_POST['choice'] == $_SESSION['seed']['choices'][count($_SESSION['choices'])][1])) {
	$_SESSION['choices'][] = array($_SESSION['item'], $_POST['choice']);
	unset($_SESSION['item']);
}

if (isset($_POST['replay'])) {
	for ($i = 0; $i < ITEMS; $i++)
		array_pop($_SESSION['choices']);
} else if (isset($_POST['next'])) {
	$_SESSION['world'] = (int) floor(count($_SESSION['choices']) / ITEMS);
	if ($_SESSION['world'] == WORLDS) {
		redirect('done');
	}
	if (isset($_SESSION['seed']))
		$_SESSION['preview'] = true;
}

if (isset($_POST['undo'])) {
	// Can't undo past a world boundary (for no good reason other than matching current system)
	if (isset($_SESSION['item']))
		unset($_SESSION['item']);
	else if (count($_SESSION['choices']) % ITEMS != 0)
		array_pop($_SESSION['choices']);
	// TODO: error message??
}
