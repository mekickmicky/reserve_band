<?php
	session_start();
	echo !isset($_SESSION["username"]) && !isset($_SESSION["id"]);
?>