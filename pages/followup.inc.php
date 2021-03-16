<?php
if (isset($_SESSION['registered']))
	redirect('instructions');
?>
<main class="document">
<h1>Followup Study</h1>
<p>Thank you for returning for the followup memory portion - we really appreciate it. Please re-enter your Mechanical Turk Worker Id so we can retrieve the passphrase you were assigned from our database - your worker id will be deleted at the conclusion of the data gathering phase of the study.</p>
<form method="post">
	<label for="username">Mechanical Turk Worker Id</label>
	<input id="username" name="username" type="text">
	<input type="submit">
</form>
</main>
