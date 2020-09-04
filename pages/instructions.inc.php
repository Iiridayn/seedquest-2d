<?php
$_SESSION['ordered'] = false;
$mode = $_SESSION['registered']['mode'];
?>
<main id="instructions" class="document">
<p>Thank you.</p>

<p>SeedQuest is a game designed to make it easier to remember a large random sequence, such as a passphrase. You will be assigned a random passphrase, which you will enter into SeedQuest. SeedQuest will then give you a sequence of worlds and actions you will perform in those worlds, which we will ask you to remember in a follow up study 7 days later. We will also ask you to remember what you can of the assigned passphrase, so we can see how SeedQuest compares to a passphrase.</p>

<p>Your assigned passphrase is "<strong id="assigned"><?= $_SESSION['registered']['words'] ?></strong>". You will need to retype this into another browser window. Please do not copy this or write it down - we are testing how well SeedQuest helps you remember your passphrase.</p>

<?php if ($mode === 0): ?>
<p>Please review the following instructions while SeedQuest is downloading in another browser tab. This may take up to about an hour on a slow ADSL connection. We suggest working on other tasks while this is downloading, and have factored in about 12 minutes of pay (equivalent to a 5 Mbit/s connection) for the inconvenience.</p>
<p class="beta">Beta testers in the lab please note how long SeedQuest takes to download and report that and your ISP reported connection speed back to Michael.</p>
<p><a href="../build" target="_blank">Click here to start SeedQuest</a></p>
<?php endif; ?>

<p>Once SeedQuest loads, you will click on “Encode Key”.</p>
<?php if ($mode === 0): ?>
<?= component('img', array('src' => 'tutorial/Main Menu - Encode Circle.png')) ?>
<?php else: ?>
<?= component('img', array('src' => 'tutorial/2d Main Menu - Encode Circle.png')) ?>
<?php endif; ?>

<p>This will take you to the following screen. Type your assigned passphrase into the box below the text “Encode Your Key” - if you have typed it correctly, the box will have a green circle with a checkmark at the end. If there is a red caution sign after you have typed your whole key, please correct any typos in the key.</p>
<?= component('img', array('src' => 'tutorial/Incorrect Key.png')) ?>
<?= component('img', array('src' => 'tutorial/Correct Key.png')) ?>

<p>Once you have entered your key correctly and the green circle with a checkmark appears, click on “Encode Key” - this will take you to the world selection screen.</p>
<p>SeedQuest will assign a sequence of six worlds based on your assigned passphrase - find the world thumbnail with a small “1” in a box over it, and click on that world thumbnail. Repeat this process five more times until a blue “Continue” button appears below the world list. Due to random processes, it is fairly normal to be assigned the same world multiple times.</p>
<?= component('img', array('src' => 'tutorial/World Selection Start - arrow.png')) ?>
<?= component('img', array('src' => 'tutorial/World Selection Done.png')) ?>

<p>Click “Continue”. <?php if ($mode === 0): ?>After a brief loading screen, <?php endif; ?>SeedQuest will show you an overview of actions you will perform in this instance of the world. Review these briefly, then press “Start” - you will be able to see the next action to perform in the lower right corner of the screen once in the world.</p>
<?= component('img', array('src' => 'tutorial/Actions.png')) ?>
<?php if ($mode === 0): ?>
<?= component('img', array('src' => 'tutorial/World Loaded - you arrow.png')) ?>

<p>As shown below, there will be a floating blue pin indicating your target or a white chevron indicating which direction you need to go to reach your next target. You can left-click on the ground to instruct your avatar to move to where you clicked. Move so that you can see where the blue pin is pointing, then click on what it’s pointing at.</p>
<?= component('img', array('src' => 'tutorial/World Pin - circle.png')) ?>
<?= component('img', array('src' => 'tutorial/World Cheveron and Misclick - circle.png')) ?>

<p>If you accidentally click something else, you can just click the white X in the upper right. If you hover over a button and change the state, this is okay - only button presses are registered, and wrong button presses won’t impede you during Encoding.</p>
<?= component('img', array('src' => 'tutorial/World Misclick.png')) ?>
<?= component('img', array('src' => 'tutorial/World Item Select.png')) ?>
<?php else: ?>

<?php if($mode === 1): ?>
<?= component('img', array('src' => 'tutorial/2d World.png')) ?>
<p>Find your target in the image - it will be a small image button over the background image, with the same label as the <strong>first</strong> line as the lower right corner of the screen.</p>

<p>If you accidentally click something else, you can just click the white X in the upper right. Wrong selections won't impact you during Encoding..</p>
<?= component('img', array('src' => 'tutorial/2d Misclick.png')) ?>
<?= component('img', array('src' => 'tutorial/2d Select.png')) ?>
<?php elseif ($mode === 2): ?>
<?= component('img', array('src' => 'tutorial/2d Random World.png')) ?>
<p>Find your target in the top scrollbar - it will have the same label as the <strong>first</strong> line in the lower right corner of the screen. The selection list is randomized on each selection, to help you to remember the object instead of just the position of the object.</p>

<p>If you accidentally click something else, that's okay. You can't select an incorrect option from the second list during encoding mode - just find the correct item in the scroll bar and click that instead, and you will see the correct options.</p>
<?= component('img', array('src' => 'tutorial/2d Random Misclick.png')) ?>
<?= component('img', array('src' => 'tutorial/2d Random Select.png')) ?>
<?php endif; ?>


<?php endif; ?>

<p>You’ll see 4 options, one of which matches the <?php if ($mode === 0): ?>instructions<?php else: ?>second line<?php endif ?> in the lower right. Click on that item. <?php if ($mode !== 2): ?>Occasionally this will not produce a visible change, such as in the screenshot below - this is normal. <?php endif ?>You can be confident your click was recorded by the progress bar changing up top, and typically the target in the lower right will change as well (in rare cases you might interact with the same thing again - the progress bar is the surest indicator). Note that the lower right shows what the item should look like after you change it, so the <?php if ($mode === 0): ?>blue pin<?php else: ?>text below the picture<?php endif ?> is the best indicator of what to click on.</p>
<p>Do your best to remember what you’ve clicked on - when you return SeedQuest won’t be able to tell you what to click on or where to go!</p>

<?php if ($mode === 0): ?>
<?= component('img', array('src' => 'tutorial/World New Target.png')) ?>
<?= component('img', array('src' => 'tutorial/World 3rd target found, diff model.png')) ?>
<p>Navigate to the next target and select the correct option, until all items in the scene have been selected. At this point a review screen will appear. This provides a birds-eye view of the map, and will have you select the same items in the same sequence as before. Click on the circle identified by the blue pin, and select the flashing option. Repeat for the remaining items.</p>
<?= component('img', array('src' => 'tutorial/World review.png')) ?>
<?= component('img', array('src' => 'tutorial/World review item.png')) ?>
<?php else: ?>
<?php if ($mode === 1): ?>
<?= component('img', array('src' => 'tutorial/2d New Target.png')) ?>
<?= component('img', array('src' => 'tutorial/2d 3rd target diff picture - circled.png')) ?>
<?php elseif ($mode === 2): ?>
<?= component('img', array('src' => 'tutorial/2d Random New Target.png')) ?>
<?php endif; ?>
<p>Find the next target and select the correct option, until all items in the scene have been selected.</p>
<?php endif; ?>

<p>At this point you’ll see the “World Complete!” popup - click “Next World”, and repeat this process for each following world until done - you’ll see the “Seed Encoded” screen. Please take this opportunity to click on the “Words” tab and review your passphrase, then move on to the next screen.</p>
<?php if ($mode === 0): ?>
<?= component('img', array('src' => 'tutorial/World complete.png')) ?>
<?php elseif ($mode === 1): ?>
<?= component('img', array('src' => 'tutorial/2d World Complete.png')) ?>
<?php elseif ($mode === 2): ?>
<?= component('img', array('src' => 'tutorial/2d Random World Complete.png')) ?>
<?php endif; ?>
<?php if ($mode === 0): ?>
<?= component('img', array('src' => 'tutorial/Seed Encoded - arrow.png')) ?>
<?= component('img', array('src' => 'tutorial/Seed Encoded words.png')) ?>
<?php else: ?>
<?= component('img', array('src' => 'tutorial/2d Seed Encoded.png')) ?>
<?php endif; ?>

<?php if ($mode === 0): ?>
<p>Now, leave this tab open so you can retype your password and reference the instructions as needed, and see if SeedQuest has finished loading in your other tab.</p>
<?php else: ?>
<p>Now, leave this tab open so you can retype your password and reference the instructions as needed. Follow this link to <a href="<?= $baseUrl ?>index.php" target="_blank">continue on to SeedQuest</a>.</p>
<?php endif; ?>
</main>
