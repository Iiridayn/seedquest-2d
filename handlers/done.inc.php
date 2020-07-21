<?php

if (isset($_POST['reset'])) {
	session_destroy();
	redirect("/");
}
