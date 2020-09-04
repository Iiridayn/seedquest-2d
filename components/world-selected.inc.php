<?php if (isset($_SESSION['worlds'][$i])): ?>
	<?php $label = $map[$_SESSION['worlds'][$i]]['label'] ?? ''; ?>
<li>
	<label><span class="number"><?= $i + 1 ?></span><?= $label ?></label>
	<?= component('img', array(
		'alt' => $label, 'title' => $label,
		'src' => 'world/' . $world_thumbs[$_SESSION['worlds'][$i]][0] . '_Thumb_F' . ($_SESSION['worlds'][$i] == 9 ? ' 1' : '') . '.png',
		'placeholder' => [240, 300],
	)) ?>
</li>
<?php else: ?>
<li class="empty"></li>
<?php endif; ?>
