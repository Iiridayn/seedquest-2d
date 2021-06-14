<?php

if (!isset($_SESSION['choices']) || count($_SESSION['choices']) < (WORLDS * ITEMS)) {
	redirect("/");
}

require('lib/bip39.php');
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

// Give credit same way as 3d
if (!isset($_SESSION['credit'])) {
	$_POST['words'] = $words;
	$_POST['encode'] = isset($_SESSION['seed']);
	require(__DIR__ . '/../handlers/credit.inc.php');
	$_SESSION['credit'] = true;
}
?>
<form method="post">
<main id="done" class="menu">
	<h1>Seed <?= isset($_SESSION['seed']) ? 'En' : 'De' ?>coded! <img src="<?= $baseUrl ?>img/clappinghands2.png" alt="clapping hands" /></h1>
	<p>You may copy it <!-- or download your seed -->below.</p>
	<section id="seed">
		<?= $words ?>
	</section>
	<button name="reset">
	<?php if (isset($_SESSION['seed'])): ?>
		Practice Again
	<?php else: ?>
		Back to Start Screen
	<?php endif; ?>
	</button>
	<aside>
		<p class="small">Not your seed? Your actions might not be in the correct order;<br />or you missed one or two.</p>
		<p>You can always try again!</p>
	</aside>
</main>
</form>
