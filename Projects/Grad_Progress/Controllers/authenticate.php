<?php
	error_reporting(E_ALL & ~E_NOTICE);

	require_once "../Model/authenticate_model.php";

	$message = verifyLogin();

	require "../View/entrance_view.php";

?>