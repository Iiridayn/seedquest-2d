<?php if ($_SESSION['ordered']): ?>
<div id="choices" class="cover">
<?php endif; ?>
<section <?= $_SESSION['ordered'] ? 'class="popup"' : 'id="choices"' ?>>
<?php if ($_SESSION['ordered']): ?>
	<button name="undo">x</button>
<?php endif; ?>
	<h1><?= $map[$world]['items'][$_SESSION['item']]['name'] ?></h1>
	<ul data-item="<?= $_SESSION['item'] ?>">
	<?php
		$randomized = range(0, 3);
		$option_size = 150;
		if (!$_SESSION['ordered']) {
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
			<?= component('img', array(
				'width' => $option_size, 'height' => $option_size,
				'alt' => $label, 'title' => $label,
				'src' => 'scenes/' . $filename,
				'placeholder' => [200, null, $filename],
			)) ?>
		</button></li>
	<?php endfor; ?>
	</ul>
</section>
<?php if ($_SESSION['ordered']): ?>
</div>
<?php endif; ?>
