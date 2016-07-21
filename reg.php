<?php
	define('TOKEN', 'Védelem');
	include_once('modulok/session_login.php');
	if (IsLoggedIn()) {
		header('Location: lista.php');
		exit();
	}
	
	include_once('modulok/consts.php');
	include_once("modulok/sio.php");
	//-------------------------
	$hibak = array();
	if ($_POST) {
		$felhasznalonev = trim($_POST['felhasznalonev']);
		$jelszo = $_POST['jelszo'];
		$jelszo2 = $_POST['jelszo2'];
		$email = trim($_POST['email']);
		
		$felhasznalok = adat_betoltes($FELHASZNALOK);
		
		if ($felhasznalonev == '') {
			$hibak[] = 'A felhasználói név kötelező!';
		}
		if ($jelszo == '') {
			$hibak[] = 'A jelszó kötelező!';
		}
		if ($jelszo != $jelszo2) {
			$hibak[] = 'A jelszavak nem egyeznek!';
		}
		if ($email == '') {
			$hibak[] = 'A cím kötelező!';
		}
		if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
			$hibak[] = 'Hibás e-mail!';
		}
		if ($felhasznalok && array_key_exists($email, $felhasznalok)) {
			$hibak[] = 'Már létezik ilyen felhasználói név!';
		}
		if (!$hibak) {
			$felhasznalok[$email] = array(
				'felhasznalonev' => $felhasznalonev,
				'jelszo'	=> md5($jelszo),
			);
			adat_mentes($FELHASZNALOK, $felhasznalok);
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
				<h2>Regisztráció</h2>
			</div>
			
			<div class="megoldas well">
			<ul>
			<?php foreach ($hibak as $hiba) : ?>
				<li><?= $hiba; ?></li>
			<?php endforeach;?>
			</ul>
			<form action="" method="post">
				<table >
					<tr>
						<td>Felhasználói nev:</td>
						<td><input type="text" name="felhasznalonev"></td>
					</tr>
					<tr>
						<td>Jelszó:</td>
						<td><input type="password" name="jelszo"></td>
					<tr>
					<tr>
						<td>Jelszó még egyszer:</td>
						<td><input type="password" name="jelszo2"></td>
					<tr>
					<tr>
						<td>E-mail cím:</td>
						<td><input type="text" name="email"></td>
					<tr>
						<td colspan = 2><input type="submit" value="Regisztráció"></td>
					</tr>
				</table>
				
			</form>
			<?php if ($_POST && !$hibak) : ?>
				<b>Sikeres regisztráció</b><br>
			<?php endif; ?>
			
			</div>
			
			<div class="megoldas well">
				<p><a href = "index.php">Vissza a főoldalra</a></p>
			</div>
			
		</div>
		</div>
		</div>
	</body>
</html>