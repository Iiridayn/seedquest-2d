<?php
if (!isset($_SESSION['worlds']))
	$_SESSION['worlds'] = [];
?>
<form method="post">
	<?= makeCSRF() ?>
	<main id="world-selection" class="menu">
		<div><button class="link" name="back">&larr; Back</button></div>
		<h1>World Selection</h1>
		<p class="desc">Select the worlds in the same sequence as when you encoded your key.<br />You can also drag a world in or out of each slot.</p>
		<?= component('world-buttons', compact('map', 'world_thumbs')) ?>
		<ol id="selected">
		<?php for ($i = 0; $i < WORLDS; $i++): ?>
			<?= component('world-selected', compact('i', 'map', 'world_thumbs')) ?>
		<?php endfor; ?>
		</ol>
		<div class="form-footer">
			<a href="<?= $baseUrl ?>index.php/world" class="button continue" style="visibility: <?= count($_SESSION['worlds']) < WORLDS ? 'hidden' : 'visible' ?>">Continue</a>
			<button type="submit" name="undo" class="link">Undo Selection</button>
		</div>
	</main>
</form>
