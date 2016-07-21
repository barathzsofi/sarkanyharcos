<?php
	define('TOKEN', 'Védelem');
	include_once('modulok/session_login.php');
	if (IsLoggedIn()) {
		header('Location: lista.php');
		exit();
	}
	
	include_once("modulok/sio.php");
	include_once('modulok/consts.php');
	//-------------------------
	$hibak = array();
	if ($_POST) {
		$email = trim($_POST['email']);
		$jelszo = $_POST['jelszo'];
		
		$tagok = adat_betoltes($FELHASZNALOK);
		
		if ($email == '') {
			$hibak[] = 'Az e-mail cím megadása kötelező!';
		}
		if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
			$hibak[] = 'Hibás formátumú e-mail!';
		}
		if ($jelszo == '') {
			$hibak[] = 'A jelszó megadása kötelező!';
		}
		if (!array_key_exists($email, $tagok)) {
			$hibak[] = 'Hibás felhasználói név vagy jelszó!';
		}
		else {
			if (md5($_POST['jelszo']) != $tagok[$email]['jelszo']) {
				$hibak[] = 'Hibás felhasználói név vagy jelszó!';
			}
		}
		
		if (!$hibak) {
			SetUser($email);
			header('Location: lista.php');
		}
	}
?>
<!doctype html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Sárkányharcos</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<!-- Bootstrap -->
		<link href="css/bootstrap.min.css" rel="stylesheet" media="screen">
		<link href="css/sablon.css" rel="stylesheet" media="screen">
		<link href="css/bootstrap-responsive.min.css" rel="stylesheet">
	</head>
	<body>
	
		<div class="container-fluid">
		<div class="row-fluid">
        <div class="span9">
	
			<div class="well">
				<h2>Bejelentkezés</h2>
			</div>
		
			<div class="well">
			
			<ul>
			<?php foreach ($hibak as $hiba) : ?>
				<li><?= $hiba; ?></li>
			<?php endforeach;?>
			</ul>
			<form action="" method="post">
				<table >
					<tr>
						<td>E-mail cím:</td>
						<td><input type="text" name="email"></td>
					</tr>
					<tr>
						<td>Jelszó:</td>
						<td><input type="password" name="jelszo"></td>
					<tr>
						<td colspan = 2><input type="submit" value="Belépés"></td>
					</tr>
				</table>
			</form>
			<p><a href="index.php">Vissza a főoldalra</a></p>
			</div>
		</div>
		</div>
		</div>
	</body>
</html>