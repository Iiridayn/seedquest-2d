<?php $attrs = ['width', 'height', 'alt', 'title']; ?>
<img
<?php foreach ($attrs as $attr): ?>
	<?php if (isset($$attr)): ?>
		<?= $attr ?>="<?= $$attr ?>"
	<?php endif; ?>
<?php endforeach; ?>
	src="<?= $baseUrl ?>img/<?= $src ?>"
<?php if (isset($placeholder)): ?>
	onerror="this.src='<?= $baseUrl ?>placeholder.php?w=<?= $placeholder[0] ?><?= isset($placeholder[1]) ? '&h=' . $placeholder[1] : '' ?>&txt=<?= $placeholder[2] ?? $alt ?? $title ?? '""' ?>';this.onerror=''"
<?php endif; ?>
	/>
