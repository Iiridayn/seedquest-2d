<?php
session_name("SEEDQUEST");
session_start();

require('config.inc.php');
require('lib/bip39.php');

if (!isset($_SESSION['choices']) || count($_SESSION['choices']) < (WORLDS * ITEMS)) {
	header("Location: /");
	die;
}

if (!empty($_POST) && (!isset($_POST['_csrf']) || !hash_equals($_POST['_csrf'], $_SESSION['csrf']))) {
	$_POST = [];
}
$_SESSION['csrf'] = bin2hex(random_bytes(32));

if (isset($_POST['reset'])) {
	session_destroy();
	header("Location: /");
	die;
}

$bits = '';
$index = 0;
for ($i = 0; $i < WORLDS; $i++) {
	setbits($bits, $index, $_SESSION['worlds'][$i], 4);
	$index += 4;
	for ($j = $i * ITEMS; $j < ($i + 1)*ITEMS; $j++) {
		setbits($bits, $index, $_SESSION['choices'][$j][0], 4);
		$index += 4;
		setbits($bits, $index, $_SESSION['choices'][$j][1], 2);
		$index += 2;
	}
}

$dict = file('lib/english.txt', FILE_IGNORE_NEW_LINES);
$words = encode($dict, $index/8, $bits);
?>
<!doctype html>
<html>
<head>
	<title>SeedQuest</title>
	<link rel="stylesheet" href="style.css">
</head>
<body>
<form method="post">
<input type="hidden" name="_csrf" value="<?= $_SESSION['csrf'] ?>" />
<main id="done" class="menu">
	<h1>Seed Encoded! <img src="img/clappinghands2.png" alt="clapping hands" /></h1>
	<p>You may copy it <!-- or download your seed -->below.</p>
	<section id="seed">
		<?= $words ?>
	</section>
	<button name="reset">Back to Start Screen</button>
	<aside>
		<p class="small">Not your seed? Your actions might not be in the correct order;<br />or you missed one or two.</p>
		<p>You can always try again!</p>
	</aside>
</main>
</form>
</body>
</html>
