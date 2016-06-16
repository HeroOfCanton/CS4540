<?php
	error_reporting(E_ALL & ~E_NOTICE);

	require_once "../Model/entrance_model.php";
	require_once "../Model/authenticate_model.php";
	redirectToHTTPS();
	require "../View/entrance_view.php";

?>