<?php
	define('TOKEN', 'Védelem');
	include('modulok/session_login.php');
	SetUser();
	header('Location: index.php');
?>