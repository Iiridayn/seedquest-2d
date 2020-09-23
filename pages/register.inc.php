<?php
if (isset($_SESSION['registered']))
	redirect('instructions');
?>
<main class="document">
<p>Thank you for beta testing our study. Please enter a username, and we'll assign you a passphrase. We need the username to know who to contact later. This will only be used during the beta period - live will link with Mechanical Turk user IDs.</p>
<form method="post">
	<label for="username">Username</label>
	<input id="username" name="username" type="text">
	<input type="submit">
</form>
</main>
