<?php
$mode = $_SESSION['registered']['mode'];
$spellout = new NumberFormatter('en', NumberFormatter::SPELLOUT);

switch($mode) {
case 0:
	$prefix = '3d-world';
	break;
case 1:
	$prefix = 'ordered';
	break;
case 2:
	$prefix = 'random';
	break;
default:
	trigger_error('Unhandled mode in instructions - breaks things');
}
?>
<main id="instructions" class="document">
<?php if (empty($_SESSION['decode'])): ?>
<p>Thank you.</p>

<p>SeedQuest is a game designed to make it easier to remember a large random sequence, such as a passphrase. You will be assigned a random passphrase, which you will enter into SeedQuest. SeedQuest will then give you a <strong>sequence of worlds and actions</strong> you will perform in those worlds, which we will ask you to <strong>remember in a follow up study</strong> some time later. We ask you to also <strong>remember the assigned passphrase</strong>, so we can see how SeedQuest compares to a passphrase. <strong>Please memorize this passphrase as if it were the only code to a safe containing thousands of dollars</strong> - this is the expected use case.</p>

<p>Your assigned passphrase is "<strong id="assigned"><?= $_SESSION['registered']['words'] ?></strong>". You will need to retype this into another browser window. Please do not copy this or write it down - we are testing how well SeedQuest helps you remember your passphrase. As we will be analyzing these assigned passphrases, please do not reuse your assigned passphrase outside of this study.</p>

<?php if ($mode === 0): ?>
<p>Please review the following instructions while SeedQuest is downloading in another browser tab. This should take around 8 minutes, but could take up to an hour on a slow ADSL connection. We suggest working on other tasks while this is downloading, and will award a $2 bonus, equivalent to download time on a 5 Mbit/s connection, for the inconvenience.</p>
<?php if (defined('TESTING')): ?>
<p class="beta">Beta testers please note how long SeedQuest takes to download and report that and your ISP reported connection speed back to Michael.</p>
<?php endif; ?>
<p><a id="game" href="../build/" target="_blank">Click here to start SeedQuest</a></p>
<?php endif; ?>

<!-- TODO: once loads is clunky for the insta-load -->
<p>Once SeedQuest loads, you will click on “Encode Key”.</p>
<?php if ($mode === 0): ?>
<?= component('img', array('src' => 'tutorial/3d-loading.png')) ?>
<?php endif; ?>
<?= component('img', array('src' => 'tutorial/' . ($mode === 0 ? 3 : 2) . 'd-main-encode.png')) ?>

<p>On the following screen, type your assigned passphrase into the box below the text “Encode Your Key” - if you have typed it correctly, the box will have a green circle with a checkmark at the end. If there is a red caution sign after you have typed your whole key, please correct any typos in the key.</p>
<?= component('img', array('src' => 'tutorial/' . ($mode === 0 ? 3 : 2) . 'd-encode-wrong.png')) ?>
<?= component('img', array('src' => 'tutorial/' . ($mode === 0 ? 3 : 2) . 'd-encode-right.png')) ?>

<p>Once you have entered your key correctly and the green circle with a checkmark appears, click on “Encode Key” - this will take you to the world selection screen.</p>
<p>SeedQuest will assign a sequence of <?= $spellout->format(WORLDS) ?> worlds based on your assigned passphrase - find the world thumbnail with a small “1” in a box over it, and click on that world thumbnail.<?php if (WORLDS > 1): ?> Repeat this process <?= $spellout->format(WORLDS - 1) ?> more time<?php if (WORLDS > 2): ?>s<?php endif; ?> until a blue “Continue” button appears below the world list. Due to random processes, you may be assigned the same world multiple times.<?php endif; ?></p>
<?= component('img', array('src' => 'tutorial/' . ($mode === 0 ? 3 : 2) . 'd-encode-worlds.png')) ?>
<?= component('img', array('src' => 'tutorial/' . ($mode === 0 ? 3 : 2) . 'd-encode-worlds-done.png')) ?>

<p>Click “Continue”. <?php if ($mode === 0): ?>After a brief loading screen, <?php endif; ?>SeedQuest will show you an overview of actions you will perform in this instance of the world. Review these briefly, then press “Start” - you will be able to see the next action to perform in the lower right corner of the screen once in the world.</p>

<?= component('img', array('src' => 'tutorial/' . ($mode === 0 ? 3 : 2) . 'd-world-actions.png')) ?>
<?= component('img', array('src' => 'tutorial/' . $prefix . '-encode-load.png')) ?>

<?php if ($mode === 0): ?>
<p>As shown below, there will be a floating blue pin indicating your target or a white chevron indicating which direction you need to go to reach your next target. You can left-click on the ground to instruct your avatar to move to where you clicked. Move so that you can see where the blue pin is pointing, then click on what it’s pointing at.</p>
<?= component('img', array('src' => 'tutorial/3d-world-encode-pin.png')) ?>
<?= component('img', array('src' => 'tutorial/3d-world-encode-chevron.png')) ?>

<p>If you accidentally click something else, you can just click the white X in the upper right. If you hover over a button and change the state, this is okay - only button presses are registered, and wrong button presses won’t impede you during Encoding.</p>
<?php elseif($mode === 1): ?>
<p>Find your target in the image - it will be a small image button over the background image, with the same label as the <strong>first</strong> line as the lower right corner of the screen.</p>

<p>If you accidentally click something else, you can just click the white X in the upper right. Wrong selections won't impact you during Encoding.</p>
<?php elseif ($mode === 2): ?>
<p>Find your target in the grid of objects - it will have the same label as the <strong>first</strong> line in the lower right corner of the screen. This list is randomized on each selection, to help you to remember the object instead of just where you saw it.</p>

<p>If you accidentally click something else, that's okay. You can't select an incorrect option from the second list during encoding mode - just find the correct item and click that instead, and you will see the correct options.</p>
<?php endif; // 3 way mode switch ?>

<?= component('img', array('src' => 'tutorial/' . $prefix . '-encode-wrong.png')) ?>
<?= component('img', array('src' => 'tutorial/' . $prefix . '-encode-select.png')) ?>

<p>You’ll see 4 options, one of which matches the <?php if ($mode === 0): ?>instructions<?php else: ?>second line<?php endif ?> in the lower right. Click on that item. <?php if ($mode !== 2): ?>Occasionally this will not produce a visible change, if set to an already visible state. <?php endif ?>You can be confident your click was recorded by the progress bar changing up top, and typically the target in the lower right will change as well (in rare cases you might interact with the same thing again - the progress bar is the surest indicator). Note that the lower right shows what the item should look like after you change it, so the <?php if ($mode === 0): ?>blue pin<?php else: ?>text below the picture<?php endif ?> is the best indicator of what to click on.</p>
<p>Do your best to remember what you’ve clicked on - when you return SeedQuest won’t be able to tell you what to click on or where to go!</p>

<?= component('img', array('src' => 'tutorial/' . $prefix . '-encode-next.png')) ?>

<p><?php if ($mode === 0): ?>Navigate to<?php else: ?>Find<?php endif; ?> the next target and select the correct option, until all items in the scene have been selected.</p>

<p>At this point you’ll see the “World Complete!” popup - click “Next World”, and repeat this process for each following world until done - the final world will say "Show Seed" instead. Click "Show Seed". Please take this opportunity to review your passphrase.</p>
<?= component('img', array('src' => 'tutorial/' . $prefix . '-encode-done.png')) ?>
<?= component('img', array('src' => 'tutorial/' . ($mode === 0 ? 3 : 2) . 'd-encode-done.png')) ?>

<?php if ($mode === 0): ?>
<p>Now, leave these instructions open so you can reference them and your password as needed, and continue once SeedQuest has finished loading in your other window.</p>
<?php else: ?>
<p>Now, leave this tab open so you can reference them and your password as needed. Follow this link to <a id="game" href="<?= $baseUrl ?>index.php" target="_blank">continue on to SeedQuest</a>.</p>
<?php endif; ?>
<p>Once you have memorized your passphrase and key sequence to your satisfaction, ideally by encoding the key multiple times, the following link will give you <a href="<?= $baseUrl ?>index.php/code">your survey completion code</a>. Please remember to treat this passphrase (and the corresponding sequence of actions) as though it were the only code to a safe containing thousands of dollars. It may help to make up a simple story focused on the words in the passphrase. After you are done, feel free to close the game window.</p>

<?php else: // decode ///////////////////////////////////////////////// ?>

<p>Next we’ll have you go through SeedQuest again, in Decode Key mode.<?php if ($mode === 0): ?> As before, please review the following instructions while waiting for SeedQuest to download in another tab.<?php endif; ?> Like with the passphrase, just make your best guess if you are having difficulty remembering your SeedQuest actions.</p>
<?php if ($mode === 0): ?>
<p><a id="game" href="../build/" target="_blank">Click here to start SeedQuest</a></p>
<?php endif; ?>
Once SeedQuest loads, you will click on “Decode Key”.
<?= component('img', array('src' => 'tutorial/' . ($mode === 0 ? 3 : 2) . 'd-main-decode.png')) ?>
<p>This will take you to the world selection screen, where you will select the worlds in the same sequence they were assigned - make your best guess if you are uncertain. If you make a mistake, you can clear the final world on the list one at a time with the “Undo Selection” link shown below.</p>
<?= component('img', array('src' => 'tutorial/' . ($mode === 0 ? 3 : 2) . 'd-decode-worlds.png')) ?>
<p>As during the Encode step, select “Continue” once you’ve selected all your assigned worlds.</p>
<?= component('img', array('src' => 'tutorial/' . ($mode === 0 ? 3 : 2) . 'd-decode-worlds-done.png')) ?>
<p>This will take you to the same world screen as last week, but without any helpful guidance of what to click on - SeedQuest doesn’t know what comes next, as it doesn’t know the passphrase this time. Perform the same actions as last week - choosing the same items and the same choices on each.<?php if ($mode === 0): ?> Items which can be selected are indicated by a white dot hovering above them.<?php endif; ?> If you activated the wrong option or an option on the wrong item, you can always use the “Undo” button next to the progress bar at the top to revert your selection. As in encode mode, you must select the item and the state<?php if ($mode !== 2): ?>, even if it doesn’t change the visual appearance<?php endif; ?> - the progress bar will update as you do.</p>

<?= component('img', array('src' => 'tutorial/' . $prefix . '-decode-load.png')) ?>
<?= component('img', array('src' => 'tutorial/' . $prefix . '-decode-select.png')) ?>
<?= component('img', array('src' => 'tutorial/' . $prefix . '-decode-next.png')) ?>

<p>Repeat the same selections across all loaded worlds, then you should see the “Seed Encoded” screen. You may need to copy this recovered passphrase into the outro survey on the next page.<p>
<?= component('img', array('src' => 'tutorial/' . ($mode === 0 ? 3 : 2) . 'd-decode-done.png')) ?>
<?php if ($mode === 0): ?>
<p>Now, leave this tab open so you can enter your password and reference the instructions as needed, and continue once SeedQuest has finished loading in your other window.</p>
<?php else: ?>
<p>Now, leave this tab open so you can reference the instructions as needed. Please use this link to <a id="game" href="<?= $baseUrl ?>index.php" target="_blank">open SeedQuest in a new window</a>.</p>
<?php endif; ?>

<p>Once you have used SeedQuest to recover your passphrase, please <a href="<?= $baseUrl ?>index.php/outro">follow this link to complete the outro survey</a> so you can get paid - other than the recovered passphrase, please feel free to skip any questions if you are not comfortable answering them.</p>
</main>
<?php endif; ?>

<script>
window.addEventListener('load', function() {
	console.log(window.screen.width, window.screen.height);
	document.getElementById('game').addEventListener('click', function(e) {
		e.preventDefault();
		// 1080p doesn't work on either of my computers; thus, 720p should preserve aspect ratio and fit
		// Note that UI scaling in Windows _does_ work
		window.open(e.target.href, 'SeedQuest', 'width=1280,height=720,resizable=0');
		return false;
	});
});
</script>
