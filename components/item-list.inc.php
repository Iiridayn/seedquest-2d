<section id="items">
	<h1>Choose an Item</h1>
	<ul id="item-list" data-world="<?= $world ?>">
	<?php
		$ordered = range(0, 15);
		if (!$_SESSION['ordered']) {
			shuffle($ordered);
		} else {
			// paint lowest positions first, to not overlap text at bottom
			usort($ordered, function($a, $b) use ($world, $positions) {
				if ($positions[$world][$a][0] == $positions[$world][$b][0])
					return 0;
				return $positions[$world][$a][0] > $positions[$world][$b][0] ? -1 : 1;
			});
		}
	?>
	<?php for ($i = 0; $i < 16; $i++): ?>
		<?php $which = $ordered[$i]; ?>
		<?= component('item', compact('map', 'world', 'which', 'positions')) ?>
	<?php endfor; ?>
	</ul>
</section>
