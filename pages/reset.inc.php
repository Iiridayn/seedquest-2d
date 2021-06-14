<?php
if (!$env['testing'])
	redirect('instructions');

session_destroy();
redirect("/");
