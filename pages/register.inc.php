<?php
if (isset($_SESSION['registered']))
	redirect('instructions');
?>
<p>Thank you for beta testing our study. Please enter a username, and we'll assign you a passphrase.</p>
<form method="post">
	<label for="username">Username</label>
	<input id="username" name="username" type="text">
	<input type="submit">
</form>
