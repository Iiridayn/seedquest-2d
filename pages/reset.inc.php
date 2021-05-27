<?php
if (!defined('TESTING'))
	redirect('instructions');

session_destroy();
redirect("/");
