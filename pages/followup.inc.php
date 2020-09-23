<?php
if (isset($_SESSION['registered']))
	redirect('instructions');
?>
<main class="document">
<p>Thank you for beta testing our follow up study. Please enter the same username you entered before, so we can retrieve your assigned passphrase from our database. This will only be used during the beta period - live will link with Mechanical Turk user IDs.</p>
<form method="post">
	<label for="username">Username</label>
	<input id="username" name="username" type="text">
	<input type="submit">
</form>
</main>
