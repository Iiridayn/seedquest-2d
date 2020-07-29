<main id="mode-select" class="menu"><form method="post">
	<img id="biglogo" src="<?= $baseUrl ?>img/logo-cropped.png" />
	<h1>SeedQuest</h1>
	<p>encode and decode your private key</p>
	<button name="encode"><img src="<?= $baseUrl ?>img/HideKeyWhite.png" />Encode Key</button>
	<button name="decode"><img src="<?= $baseUrl ?>img/Find%20Key.png" />Decode Key</button>
	<fieldset>
		<input id="ordered-choice" type="radio" name="mode" value="ordered" <?= isset($_SESSION['ordered']) && $_SESSION['ordered'] ? ' checked="checked"' : '' ?>/>
		<label for="ordered-choice">Ordered</label>
		<input id="unordered-choice" type="radio" name="mode" value="unordered" <?= isset($_SESSION['ordered']) && !$_SESSION['ordered'] ? ' checked="checked"' : '' ?>/>
		<label for="unordered-choice">Unordered</label>
	</fieldset>
</form></main>
