<?php
if (isset($_SESSION['registered']))
	redirect('instructions');
?>
<main class="document">
<h1>Consent Form</h1>
<p>Please read the following.</p>
<p>You are invited to participate in a study regarding the usability of SeedQuest, a tool developed by ConsenSys, a blockchain company. This study is conducted by Michael Clark, of the Internet Security Research Lab at Brigham Young University (<a href="https://isrl.byu.edu">https://isrl.byu.edu</a>) with Dr. Kent Seamons as the faculty advisor. You can contact Michael Clark at <a href="mailto:clark.michael.c@byu.edu">clark.michael.c@byu.edu</a>, or Dr. Seamons at <a href="seamons@cs.byu.edu">seamons@cs.byu.edu</a>.</p>
<p>Our goal is to determine how effective the approach used by SeedQuest is compared to other state-of-the-art memory aids. In order to isolate the effect of certain design choices, we have prepared 2 additional versions of SeedQuest and will randomly assign you to one of these three groups. We will assign you a passphrase and ask you to memorize it, and also assign you a sequence of virtual environments and things to click on in those environments.  We will compare how well you remember the assigned passphrase and sequence of selections with prior research to see if SeedQuest really helps. We recommend a connection speed of at least 10 mbs and at least 3 GB of free RAM to run SeedQuest.</p>
<p>While we don’t expect any risks, either physical or mental, you are welcome to stop at any time should you feel uncomfortable. You are also free to choose not to participate. If you choose to stop participating we will not use any data from your participation and will delete it, and will not be able to compensate you for time spent.</p>
<p>Although we expect no immediate benefit to you by participating, we hope our research will improve understanding of memory and retention, which could result in easier and safer ways to log in to accounts in the future.</p>
<p>By proceeding, you agree that you have read the above and want to participate in this study.</p>
<?php if ($env['testing']): ?>
<p class="beta">Beta testers please use any non-secret unique string you will remember when you return to decode mode. If you're testing multiple modes, I suggest a username with a mode affix.</p>
<?php endif; ?>
<form method="post">
	<label for="username">Mechanical Turk Worker Id</label>
	<input id="username" name="username" type="text">
	<input id="javascript" name="javascript" type="hidden" value="no" />
	<input type="submit">
</form>
<script>
window.addEventListener('load', function() {
	document.getElementById('javascript').value = "yes";
});
</script>
</main>
