<?php
$item_size = 200;
if (defined('ORDERED'))
	$item_size = 100;

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

$style = 'top: ' . $positions[$world][$which][0] . '%; left: calc(' . ($positions[$world][$which][1] ?? floor(5 + $which * (90/16))) . '% - ' . $item_size . 'px)';
?>
<li class="item" data-item="<?= $which ?>" style="<?= $style ?>">
	<button type="submit" name="item" value="<?= $which ?>">
		<label><?= $label ?></label>
		<img width=<?= $item_size ?> height=<?= $item_size ?> src="<?= $baseUrl ?>img/scenes/<?= $filename ?>" alt="<?= $label ?>" title="<?= $label ?>" onerror="this.src='<?= $baseUrl ?>placeholder.php?w=200&txt=<?= $filename ?>';this.onerror=''" />
	</button>
</li>
