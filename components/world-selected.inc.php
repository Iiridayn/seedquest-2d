<?php if (isset($_SESSION['worlds'][$i])): ?>
	<?php $label = $map[$_SESSION['worlds'][$i]]['name'] ?? ''; ?>
<li>
	<label><span class="number"><?= $i + 1 ?></span><?= $label ?></label>
	<img
		alt="<?= $label ?>" title="<?= $label ?>"
		src="<?= $baseUrl ?>img/world/<?= $world_thumbs[$_SESSION['worlds'][$i]][0] ?>_Thumb_F<?= $_SESSION['worlds'][$i] == 9 ? ' 1' : '' ?>.png"
		onerror="this.src='<?= $baseUrl ?>placeholder.php?w=240&h=300&txt=<?= $label ?>';this.onerror=''"
		/>
</li>
<?php else: ?>
<li class="empty"></li>
<?php endif; ?>
