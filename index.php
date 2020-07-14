<?php
session_name("SEEDQUEST");
session_start();

require('config.inc.php');

if (!empty($_POST) && (!isset($_POST['_csrf']) || !hash_equals($_POST['_csrf'], $_SESSION['csrf']))) {
	$_POST = [];
}
$_SESSION['csrf'] = bin2hex(random_bytes(32));

if (isset($_POST['mode'])) {
	$_SESSION['mode'] = $_POST['mode'] == 'decode' ? 'decode' : 'encode';
}
if ($_SESSION['mode'] == 'decode') {
	header('Location: /worlds.php');
	die;
}

if (isset($_POST['back'])) {
	unset($_SESSION['mode']);
}

if (isset($_POST['words'])) {
	require('../bip39/bip39.php');
	$dict = file(__DIR__ . '/../bip39/english.txt', FILE_IGNORE_NEW_LINES);
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

		header('Location: /worlds.php');
		die;
	}
}

?>
<!doctype html>
<html>
<head>
	<title>SeedQuest</title>
	<link rel="stylesheet" href="style.css">
</head>
<body>
<?php if (empty($_SESSION['mode'])): ?>
<main id="mode-select" class="menu">
	<img id="biglogo" src="img/logo-cropped.png" />
	<h1>SeedQuest</h1>
	<p>encode and decode your private key</p>
	<form method="post">
		<input type="hidden" name="_csrf" value="<?= $_SESSION['csrf'] ?>" />
		<button name="mode" value="encode"><img src="img/HideKeyWhite.png" />Encode Key</button>
		<button name="mode" value="decode"><img src="img/Find%20Key.png" />Decode Key</button>
	</form>
</main>
<?php else: ?>
<main id="encode-select" class="menu">
	<form method="post">
		<input type="hidden" name="_csrf" value="<?= $_SESSION['csrf'] ?>" />
		<button class="link" name="back">&larr; Back to SeedQuest</button>
	</form>
	<form method="post">
		<input type="hidden" name="_csrf" value="<?= $_SESSION['csrf'] ?>" />
		<h1>Encode Your Key</h1>
		<p class="aside">Enter your seed below. It should be 33 hex characters long, or a set of 12 words with spaces.</p>
		<div id="input-wrapper">
			<input type="text" name="words" value="<?= isset($_POST['words']) ? htmlspecialchars($_POST['words']) : '' ?>" />
			<img class="warning" src="img/warning.png" style="display: <?= isset($_POST['words']) ? 'block' : 'none' ?>" />
			<img class="success" src="img/success.png" style="display: none" />
			<img src="img/eye-blue.png" alt="" />
			<p>We never share your seed.</p>
			<p class="warning small" style="display: <?= isset($_POST['words']) ? 'block' : 'none' ?>">Invalid phrase: Make sure the words are spelled<br />correctly.</p>
			<p class="success small" style="display: none">Word seed detected!</p>
		</div>
		<button type="submit">Encode Key</button>
	</form>
</main>
<?php endif; ?>
</body>
</html>
