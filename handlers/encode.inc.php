<?php

if (isset($_POST['words'])) {
	require('lib/bip39.php');
	$dict = file('lib/english.txt', FILE_IGNORE_NEW_LINES);
	$bytes = decode(trim($_POST['words']), $dict);
	if ($bytes !== false && strlen($bytes) >= 16) {
		$_SESSION['seed'] = array(
			'worlds' => [],
			'choices' => [],
		);

		$bit = 0;
		for ($i = 0; $i < 6; $i++) {
			// 4 bits select a scene
			$scene = getbits($bytes, $bit, 4);
			$bit += 4;
			$_SESSION['seed']['worlds'][] = $scene;

			for ($j = 0; $j < 3; $j++) {
				$interactible = getbits($bytes, $bit, 4);
				$option = getbits($bytes, $bit + 4, 2);
				$_SESSION['seed']['choices'][] = array($interactible, $option);
				$bit += 6;
			}
		}

		redirect('worlds');
	}
}
