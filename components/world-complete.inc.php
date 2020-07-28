<div id="world-complete" class="cover">
	<section class="popup">
		<h1>World Complete!</h1>
		<p>You did all the actions needed to advance.</p>
		<button name="replay">Replay World</button>
		<button name="next"><?= $_SESSION['world'] < (WORLDS - 1) ? 'Next World' : 'Show Seed' ?></button>
	</section>
</div>
