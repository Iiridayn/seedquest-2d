<ol id="worlds">
<?php for ($i = 0; $i < 16; $i++): ?>
	<?php $label = $map[$i]['label']; ?>
	<li class="world"><button type="submit" name="world" value="<?= $i ?>">
		<label><?= $label ?></label>
		<img
			alt="<?= $label ?>" title="<?= $label ?>"
			src="<?= $baseUrl ?>img/world/<?= $world_thumbs[$i][0] ?>_Thumb.png"
			<?php /* style="margin-top: <?= $world_thumbs[$i][1] ?? -186 ?>px" */ ?>
			onerror="this.src='<?= $baseUrl ?>placeholder.php?w=200&txt=<?= $label ?>';this.onerror=''"
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
