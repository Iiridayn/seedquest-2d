<div id="progress">
	<div class="progress-bar">
		<div class="completion" style="width:<?= ($position / $from) * 100 ?>%"></div>
	</div>
	<span class="progress-count"><?= $position ?>/<?= $from ?></span>
</div>
