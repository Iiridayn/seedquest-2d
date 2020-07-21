<?php
if (!isset($_SESSION['worlds']) || count($_SESSION['worlds']) < WORLDS) {
	redirect("worlds");
}

if (!isset($_SESSION['world'])) {
	$_SESSION['world'] = 0;
	$_SESSION['choices'] = array();
	if (isset($_SESSION['seed']))
		$_SESSION['preview'] = true;
}

$_SESSION['csrf'] = bin2hex(random_bytes(32));

$world = $_SESSION['worlds'][$_SESSION['world']];
?>
<form method="post">
	<input type="hidden" name="_csrf" value="<?= $_SESSION['csrf'] ?>" />
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
			<img src="<?= $baseUrl ?>img/scenes/<?= $filename ?>" alt="" onerror="this.src='<?= $baseUrl ?>placeholder.php?w=200&txt=<?= $filename ?>'" />
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
		<div class="progress-bar">
			<div class="completion" style="width:<?= (count($_SESSION['choices']) / (ITEMS * WORLDS)) * 100 ?>%"></div>
		</div>
		<span class="progress-count"><?= count($_SESSION['choices']) ?>/<?= WORLDS * ITEMS ?></span>
		<button type="submit" name="undo"><img src="<?= $baseUrl ?>img/undoarrow2.png" />Undo</button>
	</header>
	<main id="world" style="background-image: url(<?= $baseUrl ?>img/env/<?= $world_thumbs[$world][0] ?>-3d-trimmed.png)" class="<?= defined('ORDERED') ? 'positions' : 'list' ?>">
		<section id="items">
			<h1>Choose an Item</h1>
			<ul id="item-list" data-world="<?= $world ?>">
			<?php
				$randomized = range(0, 15);
				$item_size = 200;
				$option_size = 200;
				if (!defined('ORDERED')) {
					shuffle($randomized);
				} else {
					$item_size = 100;
					$option_size = 150;
					// paint lowest positions first, to not overlap text at bottom
					usort($randomized, function($a, $b) use ($world, $positions) {
						if ($positions[$world][$a][0] == $positions[$world][$b][0])
							return 0;
						return $positions[$world][$a][0] > $positions[$world][$b][0] ? -1 : 1;
					});
				}
			?>
			<?php for ($i = 0; $i < 16; $i++): ?>
			<?php
				$which = $randomized[$i];

				$label = $map[$world]['items'][$which]['name'];

				$mode = 'd';
				// change image to show last selected state
				// like SeedQuest 3d, remember _any_ previous visit to the scene
				foreach ($_SESSION['choices'] as $k => $v) {
					if ($_SESSION['worlds'][(int) floor($k / ITEMS)] !== $world)
						continue;
					if ($v[0] == $which)
						$mode = $v[1];
				}
				$filename = $world . '-' . $which . '-' . $mode . '.png';
			?>
			<li class="item" style="top: <?= $positions[$world][$which][0] ?>%; left: calc(<?= $positions[$world][$which][1] ?? floor(5 + $which * (90/16)) ?>% - <?= $item_size ?>px)">
				<button type="submit" name="item" value="<?= $which ?>">
					<label><?= $label ?></label>
					<?php // TODO: change image if set to new image ?>
					<img width=<?= $item_size ?> height=<?= $item_size ?> src="<?= $baseUrl ?>img/scenes/<?= $filename ?>" alt="<?= $label ?>" title="<?= $label ?>" onerror="this.src='<?= $baseUrl ?>placeholder.php?w=200&txt=<?= $filename ?>'" />
				</button>
			</li>
			<?php endfor; ?>
			</ul>
		</section>
		<?php if (isset($_SESSION['item'])): ?>
		<section id="choices">
			<button name="undo">x</button>
			<h1><?= $map[$world]['items'][$_SESSION['item']]['name'] ?></h1>
			<ul data-item="<?= $i ?>">
			<?php
				$randomized = range(0, 3);
				if (!defined('ORDERED'))
					shuffle($randomized);
			?>
			<?php for ($i = 0; $i < 4; $i++): ?>
			<?php
				$label = $map[$world]['items'][$_SESSION['item']]['options'][$randomized[$i]];
				$filename = $world . '-' . $_SESSION['item']  . '-' . $randomized[$i] . '.png';
			?>
				<li class="choice"><button type="submit" name="choice" value="<?= $randomized[$i] ?>">
					<label><?= $label ?></label>
					<img width=<?= $option_size ?> height=<?= $option_size ?> src="<?= $baseUrl ?>img/scenes/<?= $filename ?>" alt="<?= $label ?>" title="<?= $label ?>" onerror="this.src='<?= $baseUrl ?>placeholder.php?w=200&txt=<?= $filename ?>'" />
				</button></li>
			<?php endfor; ?>
			</ul>
		<?php endif; ?>
		</section>
	</main>
	<?php if (isset($_SESSION['seed'])): ?>
	<figure id="objective">
	<?php
		$i = min(count($_SESSION['choices']), ($_SESSION['world'] + 1) * ITEMS - 1);
		$filename = $world . '-' .
			$_SESSION['seed']['choices'][$i][0] . '-' .
			$_SESSION['seed']['choices'][$i][1] . '.png';
		$item = $map[$world]['items'][$_SESSION['seed']['choices'][$i][0]];
	?>
		<img src="<?= $baseUrl ?>img/scenes/<?= $filename ?>" alt="" onerror="this.src='<?= $baseUrl ?>placeholder.php?w=200&txt=<?= $filename ?>'" />
		<figcaption>
			<h2><?= $item['name'] ?></h2>
			<p><?= $item['options'][$_SESSION['seed']['choices'][$i][1]] ?></p>
		</figcaption>
	</figure>
	<?php endif; ?>
	<?php if ($_SESSION['world'] !== (int) floor(count($_SESSION['choices']) / ITEMS)): ?>
	<section id="world-complete" class="popup">
		<h1>World Complete!</h1>
		<p>You did all the actions needed to advance.</p>
		<button name="replay">Replay World</button>
		<button name="next"><?= $_SESSION['world'] < (WORLDS - 1) ? 'Next World' : 'Show Seed' ?></button>
	</section>
	<?php endif; ?>
<?php endif; ?>
</form>
