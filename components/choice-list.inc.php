<section id="choices">
	<button name="undo">x</button>
	<h1><?= $map[$world]['items'][$_SESSION['item']]['name'] ?></h1>
	<ul data-item="<?= $_SESSION['item'] ?>">
	<?php
		$randomized = range(0, 3);
		$option_size = 150;
		if (!defined('ORDERED')) {
			$option_size = 200;
			shuffle($randomized);
		}
	?>
	<?php for ($i = 0; $i < 4; $i++): ?>
	<?php
		$label = $map[$world]['items'][$_SESSION['item']]['options'][$randomized[$i]];
		$filename = $world . '-' . $_SESSION['item']  . '-' . $randomized[$i] . '.png';
	?>
		<li class="choice"><button type="submit" name="choice" value="<?= $randomized[$i] ?>">
			<label><?= $label ?></label>
			<img width=<?= $option_size ?> height=<?= $option_size ?> src="<?= $baseUrl ?>img/scenes/<?= $filename ?>" alt="<?= $label ?>" title="<?= $label ?>" onerror="this.src='<?= $baseUrl ?>placeholder.php?w=200&txt=<?= $filename ?>';this.onerror=''" />
		</button></li>
	<?php endfor; ?>
	</ul>
</section>
