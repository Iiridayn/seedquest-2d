<?php

// So refresh doesn't add more to the list
ensureCSRF();

if (isset($_POST['reset'])) {
	session_destroy();
	redirect("/");
}

if (isset($_POST['start'])) {
	$_SESSION['preview'] = false;

	if (!empty($_POST['ajax']))
		die(json_encode(array(['reload'])));
}

if (isset($_POST['item'])) {
	$_SESSION['item'] = $_POST['item'];

	if (!empty($_POST['ajax'])) {
		$world = $_SESSION['worlds'][$_SESSION['world']];
		die(json_encode(array(
			['add', 'main', component('choice-list', compact('map', 'world'))],
		)));
	}
}

if (isset($_POST['choice']) && (!isset($_SESSION['seed']) || $_POST['choice'] == $_SESSION['seed']['choices'][count($_SESSION['choices'])][1])) {
	$_SESSION['choices'][] = array($_SESSION['item'], $_POST['choice']);
	unset($_SESSION['item']);

	if (!empty($_POST['ajax'])) {
		$world = $_SESSION['worlds'][$_SESSION['world']];
		$which = end($_SESSION['choices'])[0];
		$actions = array(
			['remove', '#choices'],
			['replace', 'li.item[data-item="' . $which . '"]', component(
				'item', compact('map', 'world', 'which', 'positions')
			)],
			['replace', '#progress', component('progress', array(
				'position' => count($_SESSION['choices']),
				'from' => ITEMS * WORLDS,
			))],
		);
		if (isset($_SESSION['seed']))
			$actions []= ['replace', '#objective', component('objective', compact('map', 'world'))];
		if ($_SESSION['world'] !== (int) floor(count($_SESSION['choices']) / ITEMS))
			$actions []= ['add', 'form', component('world-complete')];
		die(json_encode($actions));
	}
}

if (isset($_POST['replay'])) {
	for ($i = 0; $i < ITEMS; $i++)
		array_pop($_SESSION['choices']);

	if (!empty($_POST['ajax'])) {
		$world = $_SESSION['worlds'][$_SESSION['world']];
		$actions = array(
			['remove', '#world-complete'],
			['replace', '#progress', component('progress', array(
				'position' => count($_SESSION['choices']),
				'from' => ITEMS * WORLDS,
			))],
			['replace', '#items', component('item-list', compact('map', 'world', 'positions'))],
		);
		if (isset($_SESSION['seed']))
			$actions []= ['replace', '#objective', component('objective', compact('map', 'world'))];
		die(json_encode($actions));
	}
} else if (isset($_POST['next'])) {
	$_SESSION['world'] = (int) floor(count($_SESSION['choices']) / ITEMS);
	if ($_SESSION['world'] == WORLDS) {
		redirect('done');
	}
	if (isset($_SESSION['seed']))
		$_SESSION['preview'] = true;

	if (!empty($_POST['ajax']))
		die(json_encode(array(['reload'])));
}

if (isset($_POST['undo'])) {
	// Can't undo past a world boundary (for no good reason other than matching current system)
	if (isset($_SESSION['item'])) {
		unset($_SESSION['item']);

		if (!empty($_POST['ajax']))
			die(json_encode(array(['remove', '#choices'])));
	}
	else if (count($_SESSION['choices']) % ITEMS != 0) {
		$saved = array_pop($_SESSION['choices']);

		if (!empty($_POST['ajax'])) {
			$which = $saved[0];
			$world = $_SESSION['worlds'][$_SESSION['world']];
			$actions = array(
				['replace', 'li.item[data-item="' . $which . '"]', component(
					'item', compact('map', 'world', 'which', 'positions')
				)],
				['replace', '#progress', component('progress', array(
					'position' => count($_SESSION['choices']),
					'from' => ITEMS * WORLDS,
				))],
			);
			if (isset($_SESSION['seed']))
				$actions []= ['replace', '#objective', component('objective', compact('map', 'world'))];
			die(json_encode($actions));
		}
	}
	// No error if undo won't do anything, to match current system
}
