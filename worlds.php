<?php
session_name("SEEDQUEST");
session_start();

require('config.inc.php');

if (!isset($_SESSION['mode'])) {
	header("Location: /");
	die;
}

if (!empty($_POST) && (!isset($_POST['_csrf']) || !hash_equals($_POST['_csrf'], $_SESSION['csrf']))) {
	$_POST = [];
}
$_SESSION['csrf'] = bin2hex(random_bytes(32));

if (!isset($_SESSION['worlds']))
	$_SESSION['worlds'] = [];

if (isset($_POST['world'])) {
	$save = count($_SESSION['worlds']) < WORLDS && (
		!isset($_SESSION['seed']) ||
		$_SESSION['seed']['worlds'][count($_SESSION['worlds'])] == $_POST['world']
	);
	if ($save)
		$_SESSION['worlds'][] = $_POST['world'];
}

if (isset($_POST['undo'])) {
	array_pop($_SESSION['worlds']);
}

if (isset($_POST['back'])) {
	if (isset($_SESSION['seed'])) {
		unset($_SESSION['seed']);
	} else {
		unset($_SESSION['mode']);
	}
	header('Location: /index.php');
	die;
}
?>
<!doctype html>
<html>
<head>
	<title>SeedQuest</title>
	<link rel="stylesheet" href="style.css">
</head>
<body><form method="post">
	<input type="hidden" name="_csrf" value="<?= $_SESSION['csrf'] ?>" />
	<main id="world-selection" class="menu">
		<div><button class="link" name="back">&larr; Back</button></div>
		<h1>World Selection</h1>
		<p class="desc">Select the worlds in the same sequence as when you encoded your key.<br />You can also drag a world in or out of each slot.</p>
		<ol id="worlds">
		<?php for ($i = 0; $i < 16; $i++): ?>
			<?php $label = $map[$i]['name']; ?>
		<li class="world"><button type="submit" name="world" value="<?= $i ?>">
			<label><?= $label ?></label>
			<img
				alt="<?= $label ?>" title="<?= $label ?>"
				src="img/world/<?= $world_thumbs[$i][0] ?>_Thumb.png"
				<?php /* style="margin-top: <?= $world_thumbs[$i][1] ?? -186 ?>px" */ ?>
				onerror="this.src='placeholder.php?w=200&txt=<?= $label ?>'"
				/>
		<?php
			if (isset($_SESSION['seed'])) {
				for ($j = 0; $j < count($_SESSION['seed']['worlds']) && $j <= count($_SESSION['worlds']); $j++) {
					if ($_SESSION['seed']['worlds'][$j] == $i) {
						echo '<span class="scene-marker scene-marker-'.($j+1).'">'.($j+1).'</span>';
					}
				}
			}
		?>
		</button></li>
		<?php endfor; ?>
		</ol>
		<ol id="selected">
		<?php for ($i = 0; $i < WORLDS; $i++): ?>
			<?php if (isset($_SESSION['worlds'][$i])): ?>
				<?php $label = $map[$_SESSION['worlds'][$i]]['name'] ?? ''; ?>
			<li>
				<label><span class="number"><?= $i + 1 ?></span><?= $label ?></label>
				<img
					alt="<?= $label ?>" title="<?= $label ?>"
					src="img/world/<?= $world_thumbs[$_SESSION['worlds'][$i]][0] ?>_Thumb_F<?= $_SESSION['worlds'][$i] == 9 ? ' 1' : '' ?>.png"
					onerror="this.src='placeholder.php?w=240&h=300&txt=<?= $label ?>'"
					/>
			</li>
			<?php else: ?>
			<li class="empty"></li>
			<?php endif; ?>
		<?php endfor; ?>
		</ol>
		<div class="form-footer">
			<a href="world.php" class="button continue" style="visibility: <?= count($_SESSION['worlds']) < WORLDS ? 'hidden' : 'visible' ?>">Continue</a>
			<button type="submit" name="undo" class="link">Undo Selection</button>
		</div>
	</main>
</form></body>
</html>
