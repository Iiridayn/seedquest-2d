<?php
$item_size = 200;
if ($_SESSION['ordered'])
	$item_size = 100;

$label = $map[$world]['items'][$which]['name'];
$filename = itemFilename($world, $which);

$style = '';
if ($_SESSION['ordered'])
	$style = 'top: ' . $positions[$world][$which][0] . '%; left: calc(' . ($positions[$world][$which][1] ?? floor(5 + $which * (90/16))) . '% - ' . $item_size . 'px)';
?>
<li class="item" data-item="<?= $which ?>" style="<?= $style ?>">
	<button type="submit" name="item" value="<?= $which ?>">
		<label><?= $label ?></label>
		<img width=<?= $item_size ?> height=<?= $item_size ?> src="<?= $baseUrl ?>img/scenes/<?= $filename ?>" alt="<?= $label ?>" title="<?= $label ?>" onerror="this.src='<?= $baseUrl ?>placeholder.php?w=200&txt=<?= $filename ?>';this.onerror=''" />
	</button>
</li>
