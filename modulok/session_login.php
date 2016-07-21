<?php
	if (!defined('TOKEN'))
		exit('Közvetlenül nem elérheto!');
	
	if(!isset($_SESSION))
	{
		session_start();
	}

	function SetUser($email = null) {
		if ($email) {
			$_SESSION['email'] = $email;
		}
		else {
			unset($_SESSION['email']);
		}
	}
	
	function IsLoggedIn() {
		return isset($_SESSION['email']);
	}
	
	function WhoLoggedIn(){
		//if($_SESSION['username']){
			return $_SESSION['email'];
		//}
	}
	
?>