<?php function ucSpanWrap($str) {
	return preg_replace('/([[:upper:]])/', '<span>\1</span>', $str);
} ?>
<figure id="objective">
<?php
	$i = min(count($_SESSION['choices']), ($_SESSION['world'] + 1) * ITEMS - 1);
	$filename = $world . '-' .
		$_SESSION['seed']['choices'][$i][0] . '-' .
		$_SESSION['seed']['choices'][$i][1] . '.png';
	$item = $map[$world]['items'][$_SESSION['seed']['choices'][$i][0]];
?>
	<img src="<?= $baseUrl ?>img/scenes/<?= $filename ?>" alt="" onerror="this.src='<?= $baseUrl ?>placeholder.php?w=200&txt=<?= $filename ?>';this.onerror=''" />
	<figcaption>
		<h2><?= ucSpanWrap($item['name']) ?></h2>
		<p><?= ucSpanWrap($item['options'][$_SESSION['seed']['choices'][$i][1]]) ?></p>
	</figcaption>
</figure>
