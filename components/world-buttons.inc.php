<ol id="worlds">
<?php for ($i = 0; $i < 16; $i++): ?>
	<?php $label = $map[$i]['label']; ?>
	<li class="world"><button type="submit" name="world" value="<?= $i ?>">
		<label><?= $label ?></label>
		<?= component('img', array(
			'alt' => $label, 'title' => $label,
			'src' => 'world/' . $world_thumbs[$i][0] . '_Thumb.png',
			'placeholder' => [200],
		)) ?>
	<?php
		if (isset($_SESSION['seed'])) {
			for ($j = 0; $j < count($_SESSION['seed']['worlds']) && $j <= count($_SESSION['worlds']); $j++) {
				if ($_SESSION['seed']['worlds'][$j] == $i) {
					echo '<span class="scene-marker scene-marker-'.($j+1).'">'.($j+1).'</span>';
				}
			}
		} else {
			for ($j = 0; $j < count($_SESSION['worlds']); $j++) {
				if ($_SESSION['worlds'][$j] == $i)
					echo '<span class="scene-marker scene-marker-'.($j+1).'">'.($j+1).'</span>';
			}
		}
	?>
	</button></li>
<?php endfor; ?>
</ol>
