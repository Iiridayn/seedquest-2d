<?php

if (isset($_POST['words'])) {
	require('lib/bip39.php');
	$dict = file('lib/english.txt', FILE_IGNORE_NEW_LINES);
	$bytes = decode(trim($_POST['words']), $dict);

	$good = $bytes !== false && strlen($bytes) >= ceil(BITS/8);
	if (!empty($_POST['check'])) {
		die(json_encode($good));
	}

	if ($good) {
		$seed = array(
			'worlds' => [],
			'choices' => [],
		);

		$bit = 0;
		for ($i = 0; $i < WORLDS; $i++) {
			// 4 bits select a scene
			$scene = getbits($bytes, $bit, 4);
			$bit += 4;
			$seed['worlds'][] = $scene;

			for ($j = 0; $j < ITEMS; $j++) {
				$interactible = getbits($bytes, $bit, 4);
				$option = getbits($bytes, $bit + 4, 2);
				$seed['choices'][] = array($interactible, $option);
				$bit += 6;
			}
		}

		$_SESSION['seed'] = $seed;
		redirect('worlds');
	}
}
