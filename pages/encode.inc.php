<main id="encode-select" class="menu">
	<a href="<?= $baseUrl ?>index.php">&larr; Back to SeedQuest</a>
	<form method="post">
		<input type="hidden" name="_csrf" value="<?= $_SESSION['csrf'] ?>" />
		<h1>Encode Your Key</h1>
		<p class="aside">Enter your seed below. It should be 33 hex characters long, or a set of 12 words with spaces.</p>
		<div id="input-wrapper">
			<input type="text" name="words" autofocus value="<?= isset($_POST['words']) ? htmlspecialchars($_POST['words']) : '' ?>" onpaste="return false;" />
			<img class="warning" src="<?= $baseUrl ?>img/warning.png" style="display: <?= isset($_POST['words']) ? 'block' : 'none' ?>" />
			<img class="success" src="<?= $baseUrl ?>img/success.png" style="display: none" />
			<img src="<?= $baseUrl ?>img/eye-blue.png" alt="" />
			<p>We never share your seed.</p>
			<p class="warning small" style="display: <?= isset($_POST['words']) ? 'block' : 'none' ?>">Invalid phrase: Make sure the words are spelled<br />correctly.</p>
			<p class="success small" style="display: none">Word seed detected!</p>
		</div>
		<button type="submit">Encode Key</button>
	</form>
</main>
<script src="<?= $baseUrl ?>words.js"></script>
