<?php
$item_size = 150;
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
		<?= component('img', array(
			'width' => $item_size, 'height' => $item_size,
			'alt' => $label, 'title' => $label,
			'src' => 'scenes/' . $filename,
			'placeholder' => [200, null, $filename],
		)) ?>
	</button>
</li>
