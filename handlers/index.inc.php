<?php

if (!isset($_SESSION['ordered'])) {
	if (!isset($_POST['mode']) || !in_array($_POST['mode'], ['ordered', 'unordered'])) {
		return;
	}
	$_SESSION['ordered'] = $_POST['mode'] === 'ordered';
}

if (isset($_POST['encode']))
	redirect("encode");
else if (isset($_POST['decode']))
	redirect("worlds");
