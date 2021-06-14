<?php
// Clear these here, so closing/reopening is another way to restart
$clear = ['worlds', 'world', 'choices', 'preview', 'worlds', 'seed', 'credit'];
foreach ($clear as $key)
	unset($_SESSION[$key]);
?>
<main id="mode-select" class="menu"><form method="post">
	<img id="biglogo" src="<?= $baseUrl ?>img/logo-cropped.png" />
	<h1>SeedQuest</h1>
	<p>encode and decode your private key</p>
	<button name="encode"><img src="<?= $baseUrl ?>img/HideKeyWhite.png" />Encode Key</button>
	<button name="decode"><img src="<?= $baseUrl ?>img/Find%20Key.png" />Decode Key</button>
	<?php if (!isset($_SESSION['ordered'])): ?>
	<fieldset>
		<input id="ordered-choice" type="radio" name="mode" value="ordered" <?= isset($_SESSION['ordered']) && $_SESSION['ordered'] ? ' checked="checked"' : '' ?>/>
		<label for="ordered-choice">Ordered</label>
		<input id="unordered-choice" type="radio" name="mode" value="unordered" <?= isset($_SESSION['ordered']) && !$_SESSION['ordered'] ? ' checked="checked"' : '' ?>/>
		<label for="unordered-choice">Unordered</label>
	</fieldset>
	<?php endif; ?>
</form></main>
