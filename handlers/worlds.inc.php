<?php

// So refresh doesn't add more to the list
ensureCSRF();

if (isset($_POST['world'])) {
	$save = count($_SESSION['worlds']) < WORLDS && (
		!isset($_SESSION['seed']) ||
		$_SESSION['seed']['worlds'][count($_SESSION['worlds'])] == $_POST['world']
	);
	if ($save) {
		$_SESSION['worlds'][] = $_POST['world'];

		if (!empty($_POST['ajax'])) {
			$nth = count($_SESSION['worlds']); // works, because of 1-based indexing on the client
			$i = $nth - 1;
			$updates = array(
				['replace', "#selected li:nth-child($nth)", component(
					'world-selected', compact('i', 'map', 'world_thumbs')
				)],
				['replace', '#worlds', component(
					'world-buttons', compact('map', 'world_thumbs')
				)],
			);
			if ($nth == WORLDS)
				$updates []= ['style', '.form-footer .continue', 'visibility', 'visible'];
			die(json_encode($updates));
		}
	}
}

if (isset($_POST['undo']) && count($_SESSION['worlds'])) {
	array_pop($_SESSION['worlds']);

	if (!empty($_POST['ajax'])) {
		$i = count($_SESSION['worlds']);
		$nth = $i + 1;
		$updates = array(
			['replace', "#selected li:nth-child($nth)", component(
				'world-selected', compact('i', 'map', 'world_thumbs')
			)],
			['replace', '#worlds', component(
				'world-buttons', compact('map', 'world_thumbs')
			)],
		);
		if ($nth == WORLDS)
			$updates []= ['style', '.form-footer .continue', 'visibility', 'hidden'];
		die(json_encode($updates));
	}
}

if (isset($_POST['back'])) {
	unset($_SESSION['worlds']);

	if (isset($_SESSION['seed'])) {
		unset($_SESSION['seed']);
		redirect('encode');
	}
	redirect('/');
}
