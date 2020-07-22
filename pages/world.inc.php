<?php

$okay = isset($path[1]) || (isset($_SESSION['worlds']) && count($_SESSION['worlds']) == WORLDS);
if (!$okay) {
	redirect("worlds");
}

if (!isset($_SESSION['world'])) {
	$_SESSION['world'] = 0;
	$_SESSION['choices'] = array();
	if (isset($_SESSION['seed']))
		$_SESSION['preview'] = true;
}

$world = isset($path[1]) ? $path[1] : $_SESSION['worlds'][$_SESSION['world']];
?>
<form method="post">
	<?= makeCSRF() ?>
<?php if ($_SESSION['preview']): ?>
<main id="preview" class="menu">
	<h1>Actions To Do</h1>
	<p><?= $map[$world]['name'] ?? ''; ?></p>
	<ol id="preview-items">
	<?php $start = $_SESSION['world'] * ITEMS; ?>
	<?php for($i = $start; $i < ($start + ITEMS); $i++): ?>
	<?php
		$filename = $world . '-' .
			$_SESSION['seed']['choices'][$i][0] . '-' .
			$_SESSION['seed']['choices'][$i][1] . '.png';
		$item = $map[$world]['items'][$_SESSION['seed']['choices'][$i][0]];
	?>
		<li><figure>
			<img src="<?= $baseUrl ?>img/scenes/<?= $filename ?>" alt="" onerror="this.src='<?= $baseUrl ?>placeholder.php?w=200&txt=<?= $filename ?>';this.onerror=''" />
			<figcaption>
				<h2><?= $item['name'] ?></h2>
				<p><?= $item['options'][$_SESSION['seed']['choices'][$i][1]] ?></p>
			</figcaption>
			<?php if ($i !== $start): ?>
				<span class="joiner">&rarr;</span>
			<?php endif; ?>
		</figure></li>
	<?php endfor ?>
	</ol>
	<div class="form-footer">
		<button type="submit" name="start">Start</button>
	</div>
</main>
<?php else: ?>
	<header>
		<button type="submit" name="reset">Reset</button>
		<span id="world-name"><?= $_SESSION['world'] + 1 ?>. <?= $map[$world]['name'] ?></span>
		<?= component('progress', array(
			'position' => count($_SESSION['choices']),
			'from' => ITEMS * WORLDS,
		)) ?>
		<button type="submit" name="undo"><img src="<?= $baseUrl ?>img/undoarrow2.png" />Undo</button>
	</header>
	<main id="world" style="background-image: url(<?= $baseUrl ?>img/env/<?= $world_thumbs[$world][0] ?>-3d-trimmed.png)" class="<?= defined('ORDERED') ? 'positions' : 'list' ?>">
		<?= component('item-list', compact('map', 'world', 'positions')) ?>
		<?php if (isset($_SESSION['item'])): ?>
			<?= component('choice-list', compact('map', 'world')) ?>
		<?php endif; ?>
	</main>
	<?php if (isset($_SESSION['seed'])): ?>
		<?= component('objective', compact('map', 'world')) ?>
	<?php endif; ?>
	<?php if ($_SESSION['world'] !== (int) floor(count($_SESSION['choices']) / ITEMS)): ?>
		<?= component('world-complete') ?>
	<?php endif; ?>
<?php endif; ?>
</form>
